<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use App\Models\ProductList;
use Illuminate\Http\Request;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\DB;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * return paginated data for api.
     *
     * @param [type] $collection
     * @param [type] $transformer
     * @return \Illuminate\Http\JsonResponse
     */
    protected function returnPaginatedApiData($collection, $transformer, array $metaData = [], array $include = [])
    {
        return fractal($collection->getCollection(), $transformer)
            ->parseIncludes($include)
            ->paginateWith(new IlluminatePaginatorAdapter($collection))
            ->addMeta($metaData)
            ->respond();
    }

    /**
     * for store, update, delete.
     *
     * @param string $msg
     * @param string|null $url
     * @param string $type
     * @param array $data
     * @param null $view
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    protected function returnCrudData(string $msg, string $url = null, string $type = 'success', $data = [], $view = null)
    {
        if (request()->expectsJson()) {
            return response()->json(['message' => $msg, 'url' => $url, 'data' => $data, 'status' => $type == 'success', 'view' => $view], $type == 'error' ? 400 : 200);
        }

        flash()->{$type}($msg);
        return $url ? redirect($url) : back();
    }

    /**
     * filter out empty query strings.
     */
    protected function filterQueryStrings()
    {
        return array_filter(request()->query());
    }

    /**
     * get currently active locale.
     */
    protected function getCurrentLocale()
    {
        return LaravelLocalization::getCurrentLocale();
    }

    /**
     * auto hydrate checkboxs false value.
     *
     * http://novate.co.uk/laravel-5-checkbox-processing/
     * https://medium.com/@secmuhammed/laravel-observers-e68c69a8c8c6
     *
     * @param [type] $model   [$model description]
     * @param [type] $request [$request description]
     *
     * @return [type] [return description]
     */
    protected function hydrateCheckboxs($model, $request)
    {
        $model = app($model);

        if (property_exists($model, 'casts')) {
            collect($model->getCasts())
                ->filter(function ($v, $k) {
                    return $v == 'boolean';
                })->each(function ($v, $k) use ($request) {
                    $request->merge([$k => $request->input($k, false)]);
                });

            return $request;
        }
    }

    protected function currentRoute()
    {
        return request()->getRequestUri();
    }

    protected function breadcrumb($pages, $current, $dashboard = 1)
    {
        $breadcrumb = ['pages' => [], 'current' => $current];
        if ($dashboard) {
            array_push($breadcrumb['pages'], ['title' => __('user.dashboard'), 'route' => route('admin.dashboard')]);
        }
        foreach ($pages as $page) {
            array_push($breadcrumb['pages'], ['title' => $page['title'], 'route' => $page['route']]);
        }
        return $breadcrumb;
    }

    public function saveToken($request, $auth)
    {
        $token_exist = 0;
        if ($request->device_token) {
            if ($auth->device_token) {
                foreach ($auth->device_token as $device_token) {
                    if ($device_token == $request->device_token) {
                        $token_exist = 1;
                    }
                }
            }
            if (!$token_exist && $auth->device_token) {
                $device_tokens = array_merge($auth->device_token, array($request->device_token));
            } else {
                $device_tokens = array($request->device_token);
            }
            $auth->update([
                'device_tokens' => $device_tokens,
            ]);
        }
    }

    protected function moveGuest($user)
    {
        DB::transaction(function () use ($user) {
            // product lists
            ProductList::where('session_id', session()->getId())->whereNull('user_id')->update(['user_id' => $user->id, 'session_id' => null]);
            if ($cart = Cart::where('session_id', session()->getId())->whereNull('user_id')->latest()->first()) {
                if ($activeCart = $user->activeCart) {
                    $cart->basket()->update(['cart_id'=> $activeCart->id]);
                }
                $cart->delete();
            }
            session()->regenerate();
        });
    }
    protected function setFiltrationColumns(Product $product)
    {
        if ($categories_ids = $product->categories_ids_attribute) {
            $data['categories_ids'] = $categories_ids;
        }
        if ($product->info->brand_id) {
            $data['brand_id'] = $product->info->brand_id;
        }
        $data['price'] = $product->info->price;
        $data['title'] = $product->info->title;
        $product->update($data);
    }

}
