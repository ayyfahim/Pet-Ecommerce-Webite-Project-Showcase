<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductListStore;
use App\Models\Attribute;
use App\Models\ProductList;
use App\Models\Product;
use App\Presenters\CommonPresenter;
use App\Transformers\ProductListTransformer;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;

/**
 * @group Lists (Wishlist | Compare | Clinic)
 */
class ProductListController extends Controller
{
    public function __construct()
    {
//        $this->middleware(['auth']);
    }

    /**
     * List Index.
     *
     * @param $type
     * @param Request $request
     * @return JsonResponse
     */
    public function index($type, Request $request)
    {
//        dd(session()->getId());
        $lists = $this->getList($type);
        if ($type == 'compare') {
            $lists->limit(4);
        }
        $lists = $lists->get();
        $product_ids = $lists->pluck('product_id')->toArray();
        $lists = app(CommonPresenter::class)->paginate($lists);
        if ($request->expectsJson()) {
            if ($type == 'compare') {
                $main_attributes = ['id', 'compare_id', 'cover', 'title', 'slug', 'avg_rating', 'price', 'country', 'description'];
                $response = [];
                foreach ($main_attributes as $main_attributeKey => $main_attribute) {
                    $response[$main_attribute]['label'] = ucfirst(str_replace('_', ' ', $main_attribute));
                    $response[$main_attribute]['values'] = [];
                    foreach ($lists as $key => $list) {
                        $info = $list->product->info;
                        $product = $list->product;
                        if ($main_attribute == 'id' || $main_attribute == 'slug' || $main_attribute == 'warranty') {
                            $response[$main_attribute]['values'][] = $product->$main_attribute;
                        } elseif ($main_attribute == 'description') {
                            $response[$main_attribute]['values'][] = strip_tags($info->description);
                        } elseif ($main_attribute == 'compare_id') {
                            $response[$main_attribute]['values'][] = $list->id;
                        } elseif ($main_attribute == 'avg_rating') {
                            $response[$main_attribute]['values'][] = round($product->reviews->avg('rate'), 1) ?: 0;
                        } elseif ($main_attribute == 'cover') {
                            $response[$main_attribute]['values'][] = $product->cover ? asset($product->cover->getUrl()) : '';
                        }  elseif ($main_attribute == 'country') {
                            $response[$main_attribute]['values'][] = [
                                'code' => $info->country ? $info->country : '',
                                'name' => $info->country ? country($info->country)->getName() : ''
                            ];
                        } else {
                            $response[$main_attribute]['values'][] = $info->$main_attribute;
                        }
                    }
                }
                $compare_attributes = Attribute::where('compare', true)->whereHas('product_attributes', function ($query) use ($product_ids) {
                    $query->whereIn('product_id', $product_ids);
                })->orderBy('name->'.app()->getLocale())->get();
                foreach ($compare_attributes as $key => $compare_attribute) {
                    $response['attribute_' . $key]['label'] = $compare_attribute->name;
                    $response['attribute_' . $key]['values'] = [];

                    foreach ($lists as $listKey => $list) {
                        $product = $list->product;
                        $productAttribute = $product->specifications()->where('attribute_id', $compare_attribute->id)->first();
//                        dd($productAttribute);
                        $value = "";
                        if($productAttribute){
                            $value = $productAttribute->attribute->type == 'dropdown' && $productAttribute->option
                                ? $productAttribute->option->name
                                : $productAttribute->value;
                        }
                        $response['attribute_' . $key]['values'][] = $value;
                    }
                }
                foreach ($lists as $listKey => $list) {
                    $product = $list->product;
                    $info = $list->product->info;
                    $response['other']['label'] = "Another Specifications";
                    $response['other']['values'][] = $info->other;
                    $response['videos']['label'] = "Videos";
                    $response['videos']['values'][] = $product->video_urls?:[];
                    $attachments = [];
                    if ($product->attachments) {
                        foreach ($product->attachments as $attachment) {
                            $attachments[] = asset($attachment->getUrl());
                        }
                    }
                    $response['attachments']['label'] = "Attachments";
                    $response['attachments']['values'][] = $attachments;
                }

                return response()->json([
                    'data' => $response,
                    'total' => $lists->count()
                ]);
            }
            return $this->returnPaginatedApiData(
                $lists, new ProductListTransformer()
            );
        }
    }

    /**
     * List Store.
     * @bodyParam product_id required
     * @bodyParam type required
     * @param ProductListStore $request
     * @return JsonResponse|RedirectResponse|Redirector
     */
    public function store(ProductListStore $request)
    {
        $product = Product::findOrFail($request->product_id);
        if (!$this->checkExists($product->id, $request->type)) {
            if ($request->type == 'compare') {
                if ($this->compareLimit()) {
                    return $this->returnCrudData(__('list.compare_exceed'), null, 'error');
                } elseif (!$this->compareValid($product)) {
                    return $this->returnCrudData(__('list.compare_invalid'), null, 'error');
                }
            }
            $list = $product->lists()->create([
                'user_id' => $this->getUserId(),
                'session_id' => $this->getSessionId(),
                'type' => $request->type,
                'product_info_id' => $product->info->id,
            ]);
            $data['id'] = $list->id;
            if (!request()->is('api*')) {
                $data['action'] = route('list.destroy', $list->id);
            }
            return $this->returnCrudData(__('list.added_to_' . $request->type), null, 'success', $data);
        }
        return $this->returnCrudData(__('list.already_in_' . $request->type), null, 'error');
    }

    /**
     * List Delete.
     *
     * @param ProductList $list
     * @return JsonResponse|RedirectResponse|Redirector
     * @throws Exception
     */
    public
    function destroy(ProductList $list)
    {
        $type = $list->type;
        $list->delete();
        return $this->returnCrudData(__('list.removed_from_' . $type),url()->previous());
    }

    private
    function checkExists(string $product_id, $type)
    {
        $list = $this->getList($type);
        return $list->whereType($type)->where('product_id', $product_id)->count();
    }

    private
    function getSessionId()
    {
        if (!auth()->check()) {
            return session()->getId();
        }
        return null;
    }

    private
    function getUserId()
    {
        if (auth()->check()) {
            return auth()->user()->id;
        }
        return null;
    }

    private
    function getList($type = null)
    {
        $list = ProductList::query()->whereHas('product');
        if ($type) {
            $list->whereType($type);
        }
        if ($sessionId = $this->getSessionId()) {
            $list->where('session_id', $sessionId);
        } elseif ($userId = $this->getUserId()) {
            $list->where('user_id', $userId);
        }
        return $list;
    }

    private
    function compareLimit()
    {
        $compare = $this->getList('compare');
        return $compare->count() >= 4;
    }

    private
    function compareValid(Product $product)
    {
        $compare = $this->getList('compare')->latest()->first();
        if ($compare) {
            $current_category = $product->info->categories->pluck('id')->toArray();
            $category_to_add = $compare->product->info->categories->pluck('id')->toArray();
            return sizeof(array_intersect($current_category, $category_to_add)) > 0;
        }
        return true;
    }
}
