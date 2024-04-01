<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Traits\User\Filtration;
use App\Http\Requests\ProductListStore;
use App\Models\Product;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Presenters\UserPresenter;
use Zizaco\Entrust\EntrustRole as Role;

/**
 * @group ManagerProductList
 */
class ManagerProductListController extends Controller
{
    use Filtration;

    public function store(ProductListStore $request)
    {
        if (!$request->product_ids) {
            return $this->returnCrudData("Please select products", null, 'error');
        }
        $products = Product::whereIn('id', $request->product_ids)->get();
        $user = User::findOrFail($request->user_id);
        foreach ($products as $product) {
            if (!$this->checkExists($product->id, $request->type, $user)) {
                $product->lists()->create([
                    'user_id' => $user->id,
                    'type' => $request->type,
                    'product_info_id' => $product->info->id,
                ]);
            }
        }

        return $this->returnCrudData(__('list.added_to_' . $request->type), url()->previous());

    }

    private
    function checkExists(string $product_id, $type, User $user)
    {
        $list = $user->{$type}();
        return $list->whereType($type)->where('product_id', $product_id)->count();
    }
}
