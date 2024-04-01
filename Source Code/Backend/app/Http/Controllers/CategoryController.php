<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Traits\CategoryFiltration;
use App\Models\Category;
use App\Presenters\CommonPresenter;
use App\Transformers\AttributeTransformer;
use App\Transformers\CategoryTransformer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * @group Category
 */
class CategoryController extends Controller
{
    use CategoryFiltration;

    public function __construct()
    {
    }

    /**
     * Category-Listing
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request)
    {
        $categories = Category::isActive()->whereIsRoot()->orderByRaw('-sort_order DESC');
        if ($this->filterQueryStrings()) {
            $categories = $this->filterData($request, $categories);
        }
        $categories = $categories->get();
        if ($request->expectsJson()) {
            return response()->json([
                'categories' => fractal($categories, new CategoryTransformer())->toArray()['data'],
            ]);
        }
    }

    /**
     * Category-Single
     *
     * @param $slug
     * @queryParam sub_categories array
     * @queryParam attributes array
     * @param Request $request
     * @return JsonResponse
     */
    public function show($slug, Request $request)
    {
        $category = Category::findBySlug($slug)->first();
        if (!$category) {
            abort(404);
        }
        $categories = $category->children()->isActive()->orderByRaw('-sort_order DESC');
        if ($this->filterQueryStrings()) {
            $categories = $this->filterData($request, $categories);
        }
        $categories = $categories->get();
        $sub_categories = [];
        foreach ($categories as $sub_category) {
            if ($sub_category->children->count())
                $sub_categories = array_merge($sub_categories, $sub_category->children->pluck('id')->toArray());
        }
        $categories = app(CommonPresenter::class)->paginate($categories);
        if ($request->expectsJson()) {
            return $this->returnPaginatedApiData(
                $categories, new CategoryTransformer(), [
                    'category' => fractal($category, new CategoryTransformer())->toArray()['data'],
                    'sub_categories' => $sub_categories ? fractal(Category::whereIn('id', $sub_categories)->orderByRaw('-sort_order DESC')->get(), new CategoryTransformer())->toArray()['data'] : [],
                    'attributes' => fractal($category->configurations, AttributeTransformer::class)->toArray()['data']
                ]
            );
        }
    }

    /**
     * Category-Single
     *
     * @param $slug
     * @queryParam sub_categories array
     * @queryParam attributes array
     * @param Request $request
     * @return JsonResponse
     */
    public function showSingle($slug, Request $request)
    {
        $category = Category::where('slug', $slug)->firstOrFail();
        if (!$category) {
            abort(404);
        }

        return response()->json([
            'category' => fractal($category, new CategoryTransformer())->toArray()['data']
        ]);
    }
}
