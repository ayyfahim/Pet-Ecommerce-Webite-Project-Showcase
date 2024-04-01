<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Traits\CouponFiltration;
use App\Models\Category;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\Product;
use App\Presenters\CommonPresenter;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use App\Http\Controllers\Controller;
use App\Http\Requests\CouponRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

/**
 * @group ManagerCoupon
 */
class ManagerOrderNoteController extends Controller
{

    public function __construct()
    {
    }

    /**
     * store.
     *
     * @param Request $request
     * @return JsonResponse|RedirectResponse|Redirector
     */
    public function store(Request $request)
    {
        $request->validate([
            'order_id' => 'required',
            'notes' => 'required',
        ]);
        $order = Order::findOrFail($request->order_id);
        $order->order_notes()->create($request->only('notes'));
        return $this->returnCrudData(__('system_messages.common.create_success'), url()->previous());
    }

}
