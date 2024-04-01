<?php

namespace App\Http\Controllers\Admin;

use App\Exports\ProductExport;
use App\Http\Controllers\Traits\Product\Attributes;
use App\Http\Controllers\Traits\Product\Filtration;
use App\Http\Controllers\Traits\Product\GoogleSheets;
use App\Http\Controllers\Traits\Product\HasFaq;
use App\Http\Controllers\Traits\Product\HasVoucher;
use App\Http\Controllers\Traits\Product\ProductDataImport;
use App\Http\Controllers\Traits\Product\HasVariation;
use App\Models\Attribute;
use App\Models\Brand;
use App\Models\Breed;
use App\Models\Category;
use App\Models\Concern;
use App\Models\Country;
use App\Models\Icon;
use App\Models\Product;
use App\Models\RelatedAttributeConfiguration;
use App\Models\ProductInfo;
use App\Models\Vendor;
use App\Presenters\CommonPresenter;
use Carbon\Carbon;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductStore;
use Illuminate\View\View;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Spatie\MediaLibrary\Models\Media;
use Maatwebsite\Excel\Facades\Excel;


/**
 * @group ManagerProduct
 */
class ManagerProductController extends Controller
{
    use Filtration, ProductDataImport, HasVariation, HasFaq, Attributes, HasVoucher;

    public function __construct()
    {
    }

    /**
     * index.
     *
     * @param Request $request
     * @return Factory|View
     */
    public function index(Request $request)
    {
        $config = Product::getStatusFor();
        //        Product::whereNotNull('id')->delete();
        if ($request->country_id) {
            $country = Country::findOrFail($request->country_id);
        }

        return view('pages.products.manager.index', [
            'products' => $this->getProducts($request),
            'status' => $config['status'],
            'vendors' => Vendor::get()->sortBy('name'),
            'brands' => Brand::get()->sortBy('name'),
            'concerns' => Concern::get()->sortBy('name'),
            'cities' => isset($country) ? $country->cities->pluck('name') : [],
            'childCategories' => Category::lastLevel()->get()->groupBy('parent.name')->sortBy('name'),
            'countries' => Country::select('id', 'name')->get(),
            'sorting' => Product::getSortingOptions(),
            'breadcrumb' => $this->breadcrumb([], 'Products')
        ]);
    }

    public function getProducts(Request $request)
    {
        $coupons = Product::query();
        if ($this->filterQueryStrings()) {
            $coupons = $this->filterData($request, $coupons);
        }
        return $coupons->latest()->get();
    }

    public function export(Request $request)
    {
        return Excel::download(new ProductExport($this->getProducts($request)), "Products " . today()->format('d-m-Y') . ".csv");
    }

    /**
     * import.
     */
    public function import()
    {
        return view('pages.products.manager.import', [
            'breadcrumb' => $this->breadcrumb([
                [
                    'title' => 'Products',
                    'route' => route('product.admin.index')
                ]
            ], 'Import Products'),
        ]);
    }

    /**
     * create.
     */
    public function create()
    {
        return view('pages.products.manager.add', array_merge($this->commonData(), [
            'voucher_code' => rand(111111111, 999999999),
            'status' => Product::getStatusFor('status'),
            'google_categories' => config('google_categories'),
            'breadcrumb' => $this->breadcrumb([
                [
                    'title' => 'Products',
                    'route' => route('product.admin.index')
                ]
            ], 'Add New Product'),
        ]));
    }

    /**
     * store.
     *
     * @param ProductStore $request
     * @return JsonResponse|RedirectResponse|Redirector
     */
    public function store(ProductStore $request)
    {
        $product = $this->commonCrud($request);
        return $this->returnCrudData(__('system_messages.common.create_success'), ($product && $product->configurations()->count()) ? route('product.admin.edit', $product->id) : route('product.admin.index'));
    }

    /**
     * edit.
     *
     * @param mixed $product
     * @return Factory|View
     */
    public function edit(Product $product)
    {
        return view('pages.products.manager.edit', array_merge($this->commonData($product), [
            'product' => $product,
            'status' => Product::getStatusFor('status'),
            'google_categories' => config('google_categories'),
            'breadcrumb' => $this->breadcrumb([
                [
                    'title' => 'Products',
                    'route' => route('product.admin.index')
                ]
            ], 'Edit Product'),
        ]));
    }

    /**
     * update.
     *
     * @param mixed $product
     * @param ProductStore $request
     * @return JsonResponse|RedirectResponse|Redirector
     * @throws \Throwable
     */
    public function update(Product $product, ProductStore $request)
    {
        $this->commonCrud($request, 'update', $product);

        return $this->returnCrudData(__('system_messages.common.update_success'), url()->previous());
    }

    /**
     * delete.
     *
     * @param Request $request
     * @param Product $product
     * @return JsonResponse|RedirectResponse|Redirector
     * @throws Exception
     */
    public function destroy(Request $request, Product $product)
    {
        $product->delete();
        return $this->returnCrudData(__('system_messages.common.delete_success'), $request->redirect_to ?: route('product.admin.index'));
    }

    private function commonData(Product $product = null)
    {
        $status = Product::getStatusFor('status');
        $status_id = $status->firstWhere('order', 1)->id;
        $reversed_status_id = $status->firstWhere('order', 2)->id;
        $attributes = Attribute::isActive()->where('product', true);
        if ($product) {
            $attributes->whereNotIn('id', $product->attributes->pluck('attribute_id'));
        }
        return [
            'childCategories' => Category::lastLevel()->get()->sortBy('name'),
            'brands' => Brand::get()->sortBy('name'),
            'breeds' => Breed::get()->sortBy('name'),
            'concerns' => Concern::get()->sortBy('name'),
            'product_attributes' => $product
                ? Attribute::isActive()->where('product', true)->whereHas('related_attributes', function ($query) use ($product) {
                    $query->where('product_id', $product->id);
                })->get()->sortBy('name')
                : [],
            'attributes' => $attributes->get()->sortBy('name'),
            'icons' => Icon::get()->sortBy('name'),
            'vendors' => Vendor::get()->sortBy('name'),
            'regions' => Country::select('region')->distinct('region')->get()->pluck('region'),
            'countries' => $product && $product->info->region
                ? Country::select('id', 'region', 'name')
                ->where('region', $product->info->region)
                ->get()
                : [],
            'cities' => $product && $product->info->country
                ? $product->info->country->cities()->select('name')->get()->pluck('name')->toArray()
                : [],
            'status_id' => $status_id,
            'reversed_status_id' => $reversed_status_id,
        ];
    }

    private function commonCrud(Request $request, $type = 'store', Product $product = null)
    {
        $productResponse = null;
        DB::transaction(function () use ($request, $product, &$productResponse, $type) {
            $productAttributes = [
                'sku', 'quantity', 'status_id', 'featured', 'seo_title', 'seo_description',
                'supplier_code', 'google_category', 'additional_categories', 'affiliate_link', 'specifications', 'specifications_description',
                'nutrition_facts_serving', 'nutrition_facts_weight',
                'nutrition_facts_serving_label', 'nutrition_facts_description',
                'dosages', 'dosages_description',
                'show_brand', 'notes', 'keywords', 'shipping_cost', 'shipping_days',
                'deal_from', 'deal_to', 'deal_show_counter', 'vendor_id', 'age'
            ];
            $productData = $request->only($productAttributes);
            $ignore = [
                'cover', 'gallery', 'attachments', 'media_to_delete', 'categories',
                'concerns', 'redirect_to', 'attributes', 'variations', 'options_to_delete', 'variations_to_delete',
                'icons', 'slug', 'main', 'deals'
            ];
            if (isset($productData['deal_from']) && $productData['deal_from']) {
                $productData['deal_from'] = Carbon::parse($productData['deal_from'])->toDateTimeString();
            }
            if (isset($productData['deal_to']) && $productData['deal_to']) {
                $productData['deal_to'] = Carbon::parse($productData['deal_to'])->toDateTimeString();
            }
            if ($type == 'store') {
                $product = Product::create(array_merge($productData, ['slug' => $request->slug ?: $request->title]));
                $info = $product->infos()->create($request->except(array_merge($productAttributes, $ignore)));
                $this->setAttributes($request->input('attributes'), $product);
                $productResponse = $product;
            } else {
                $product->update(array_merge($productData, ['slug' => $request->slug ?: $request->title]));
                // TODO: Create Info if only needed
                $product->infos()->update(['active' => false]);
                $info = $product->infos()->create($request->except(array_merge($productAttributes, $ignore)));
                if ($media_to_delete = $request->media_to_delete) {
                    Media::whereIn('id', $media_to_delete)->delete();
                }
                $this->setAttributes($request->input('attributes'), $product, $request->options_to_delete);
                $this->setVariations($request->input('variations'), $product, $request->variations_to_delete);
            }
            if ($gallery = $request->gallery) {
                //                dd($gallery);
                //                dd($request->main);
                if (isset($gallery['files'])) {
                    foreach ($gallery['files'] as $key => $one) {
                        if ($one) {
                            $alt = (isset($gallery['alt']) && isset($gallery['alt'][$key])) ? $gallery['alt'][$key] : '';
                            $product->addHashedMedia($one, false, ['alt' => $alt, 'main' => $request->main == $gallery['index'][$key]])->toMediaCollection('gallery');
                        }
                    }
                }
                if (isset($gallery['current'])) {
                    foreach ($gallery['current'] as $key => $one) {
                        if (isset($one['id'])) {
                            if ($media = Media::find($one['id'])) {
                                $custom_properties = $media->custom_properties;
                                $custom_properties['alt'] = $one['alt'];
                                $custom_properties['main'] = $request->main == $key;
                                $media->update(['custom_properties' => $custom_properties]);
                            }
                        }
                    }
                }
            }
            if ($attachments = $request->attachments) {
                foreach ($attachments as $one) {
                    $product->addHashedMedia($one)->toMediaCollection('attachments');
                }
            }
            if ($categories = $request->categories) {
                $info->categories()->sync($categories);
            }
            if ($concerns = $request->concerns) {
                $info->concerns()->sync($concerns);
            }
            if ($request->icons) {
                foreach ($request->icons as $icon) {
                    $data = [
                        'icon_id' => $icon['icon_id'],
                        'label' => $icon['label'],
                        'helper' => $icon['helper'],
                        'listing' => isset($icon['listing']) && $icon['listing'] == true,
                        'enabled' => isset($icon['enabled']) && $icon['enabled'] == true,
                    ];
                    if (isset($icon['id'])) {
                        $iconObj = $product->product_icons()->findOrFail($icon['id']);
                        $iconObj->update($data);
                    } else {
                        $product->product_icons()->create($data);
                    }
                }
            }
            if ($request->deals) {
                foreach ($request->deals as $deal) {
                    if ($deal['quantity'] && $deal['discount_amount']) {
                        $data = [
                            'variation_id' => isset($deal['variation_id']) ? $deal['variation_id'] : null,
                            'quantity' => $deal['quantity'],
                            'discount_type' => $deal['discount_type'],
                            'discount_amount' => $deal['discount_amount'],
                            'is_active' => isset($deal['is_active']) && $deal['is_active'] == true,
                        ];
                        if (isset($deal['id'])) {
                            $dealObj = $product->deals()->find($deal['id']);
                            if ($deal) {
                                $dealObj->update($data);
                            }
                        } else {
                            $product->deals()->create($data);
                        }
                    }
                }
            }
            $this->setFiltrationColumns($product->fresh());
        });
        return $productResponse;
    }
}
