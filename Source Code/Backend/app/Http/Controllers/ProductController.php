<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Traits\Product\Filtration;
use App\Http\Controllers\Traits\Product\HasVariation;
use App\Models\Attribute;
use App\Models\Brand;
use App\Models\Breed;
use App\Models\Category;
use App\Models\Concern;
use App\Models\PetType;
use App\Models\Product;
use App\Models\ProductInfo;
use App\Models\RelatedAttribute;
use App\Models\Service;
use App\Presenters\CommonPresenter;
use App\Presenters\ProductPresenter;
use App\Transformers\AttributeTransformer;
use App\Transformers\BrandTransformer;
use App\Transformers\CategoryTransformer;
use App\Transformers\ConcernTransformer;
use App\Transformers\PetTypeTransformer;
use App\Transformers\ProductTransformer;
use App\Transformers\ReviewTransformer;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * @group Product
 */
class ProductController extends Controller
{
    use Filtration, HasVariation;

    public function __construct()
    {
    }

    /**
     * Product-Listing
     *
     * @queryParam q free text to search in title or description
     * @queryParam price_from
     * @queryParam price_to
     * @queryParam category_id from generic data
     * @queryParam country_code from generic data with key: iso_3166_1_alpha2
     * @queryParam brand_id from generic data
     * @queryParam vendor_id from generic data
     * @queryParam source in case of suggestion search send it with value = header
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request)
    {
        $products = Product::with('configurations')->isSearchable();
        if ($request->include == 'top_selling') {
            return response()->json([
                'top_selling_products' => fractal(Product::isSearchable()->orderByTopSelling()->take(5)->get(), new ProductTransformer())->toArray()['data'],
            ]);
        } else {
            if ($this->filterQueryStrings()) {
                $products = $this->filterData($request, $products);
            }
            if ($request->source == 'header') {
                return response()->json([
                    'products' => $request->q ? fractal($products->take(12)->get(), new ProductTransformer(false, false, true))->toArray()['data'] : [],
                ]);
            }
            $products = $products->get();
            $brands_ids = array_unique($products->pluck('info.brand_id')->toArray());
            $categories_ids = array_unique($products->pluck('info.category.id')->toArray());
            $concern_ids = array_unique($products->pluck('info.concerns')->collapse()->pluck('id')->toArray());
            $attributes_ids = [];
            foreach ($products as $product) {
                foreach ($product->configurations as $configuration) {
                    $attributes_ids[] = $configuration->id;
                }
            }
            $products = app(ProductPresenter::class)->paginate($products);
            $prices['min'] = ProductInfo::min('regular_price');
            $prices['max'] = ProductInfo::max('regular_price');
            $attributes = RelatedAttribute::whereIn('id', array_unique($attributes_ids))->groupBy('attribute_id')->get();
            if ($request->expectsJson()) {
                return $this->returnPaginatedApiData(
                    $products,
                    new ProductTransformer(),
                    [
                        'sorting' => Product::getSortingOptions(true),
                        'concerns' => fractal(Concern::whereIn('id', $concern_ids)->get(), new ConcernTransformer())->toArray()['data'],
                        'brands' => fractal(Brand::whereIn('id', $brands_ids)->get(), new BrandTransformer())->toArray()['data'],
                        'categories' => fractal(Category::whereIn('id', $categories_ids)->get(), new CategoryTransformer())->toArray()['data'],
                        'attributes' => fractal($attributes, AttributeTransformer::class)->toArray()['data'],
                        'price' => $prices
                    ]
                );
            }
        }
    }

    /**
     * Product-Single
     *
     * @param $slug
     * @return Renderable
     */
    public
    function show($slug)
    {
        $product = Product::findBySlug($slug);
        if (!$product)
            abort(404);
        if (request()->expectsJson()) {
            $product->increment('views');
            return response()->json([
                'product' => fractal($product, new ProductTransformer(false, true))->parseIncludes(['gallery'])->toArray()['data'],
                'recently_viewed' => fractal(Product::isSearchable()->where('id', '!=', $product->id)->where('views', '>', 0)->orderBy('views', 'DESC')->take(5)->get(), new ProductTransformer())->toArray()['data'],
                'related_products' => fractal($this->getRelatedProducts($product)->limit(6)->get(), new ProductTransformer())->toArray()['data'],
            ]);
        }
        $data = [
            '@context' => 'https://schema.org/',
            '@type' => 'Product',
            'name' => $product->info->title,
            'image' => [
                $product->getUrlFor('cover') ?: '',
            ],
            'description' => strip_tags($product->info->description),
            'sku' => $product->sku,
            'mpn' => $product->sku,
            'review' => [
                '@type' => 'Review',
                'reviewRating' => [
                    'ratingValue' => '5',
                    'bestRating' => '5',
                ],
                'author' => [
                    '@type' => 'Person',
                    'name' => 'Deal A Day',
                ],
            ],
            'aggregateRating' => [
                '@type' => 'AggregateRating',
                'ratingValue' => '5',
                'reviewCount' => '5',
            ],
            'brand' => [
                '@type' => 'Brand',
                'name' => $product->info->brand ? $product->info->brand->name : '',
            ],
            'offers' => [
                '@type' => 'Offer',
                'url' => route('product.show', $product->slug),
                'priceCurrency' => 'USD',
                'price' => $product->info->sale_price,
                'priceValidUntil' => today()->addDay()->toDateString(),
                "availability" => "https://schema.org/InStock",

            ],
        ];
        $breadcrumb_schema = [
            [
                "@type" => "ListItem",
                "position" => 1,
                "name" => "Home",
                'item' => route('home'),
            ],
            [
                "@type" => "ListItem",
                "position" => 2,
                "name" => $product->info->category ? $product->info->category->name : '',
                'item' => route('product.index', ['category_id' => $product->info->category ? $product->info->category->id : '']),
            ],
            [
                "@type" => "ListItem",
                "position" => 3,
                "name" => $product->info->title,
            ],
        ];
        return view('welcome', [
            'product' => $product,
            'google_schema' => json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES),
            'breadcrumb_schema' => json_encode($breadcrumb_schema, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES),
        ]);
    }

    private
    function getRelatedProducts(Product $product)
    {
        return Product::isSearchable()->latest()->where('id', '!=', $product->id)
            ->whereJsonContains('categories_ids', $product->info->categories->pluck('id'));
    }

    public function product_recomeendation(Request $request) {
        if (count($request->all()) == 0) {
            return response()->json([
                'pets' => fractal(PetType::all(), new PetTypeTransformer())->toArray()['data'],
                'concerns' => Concern::all()
            ]);
        } elseif(count($request->all()) == 1 && $request->has('pet_type_id')) {
            return response()->json([
                'breeds' => Breed::where('pet_type_id', $request->pet_type_id)->get()->toArray()
            ]);
        } else {

            $products = Product::with('configurations')->isSearchable();

            if ($this->filterQueryStrings()) {
                $products = $this->filterData($request, $products);
            }

            return response()->json([
                'data' => fractal($products->get(), new ProductTransformer())->toArray()['data'],
            ]);

        }
        // $page = FrontendHomepage::first();
        // return response()->json([
        //     'homepage' => fractal($page, new FrontendHomepageTransformer())->toArray()['data']
        // ]);
    }

    public function getProducts(Request $request)
    {
        $coupons = Product::query();
        if ($this->filterQueryStrings()) {
            $coupons = $this->filterData($request, $coupons);
        }
        return $coupons->latest()->get();
    }
}
