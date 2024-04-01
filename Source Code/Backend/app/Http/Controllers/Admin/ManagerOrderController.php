<?php

namespace App\Http\Controllers\Admin;

use App\Models\Order;
use App\Models\Vendor;
use App\Models\Product;
use App\Models\Category;
use App\Models\Courrier;
use Illuminate\View\View;
use App\Models\ConfigData;
use App\Exports\OrderExport;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Http\Requests\OrderStore;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Redirector;
use App\Presenters\CommonPresenter;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\View\Factory;
use App\Http\Controllers\Traits\Order\HasEmails;
use App\Http\Controllers\Traits\Order\Filtration;

/**
 * @group ManagerOrder
 */
class ManagerOrderController extends Controller
{
    use Filtration, HasEmails;

    public function __construct()
    {
    }

    /**
     * index.
     *
     * @queryParam q search in name
     */
    public function index(Request $request)
    {
        $orders = app(CommonPresenter::class)->paginate($this->getOrders($request));

        return view('pages.orders.manager.index', [
            'orders' => $orders,
            'childCategories' => Category::lastLevel()->get()->groupBy('parent.name')->sortBy('name'),
            'products' => Product::latest()->isActive()->get(),
            'vendors' => Vendor::get()->sortBy('name'),
            'payment_methods' => Order::getStatusFor('payment_method'),
            'shipping_methods' => Order::getStatusFor('shipping_method'),
            'status' => Order::getStatusFor('status'),
            'breadcrumb' => $this->breadcrumb([], 'Orders')
        ]);
    }

    /**
     * show.
     *
     * @param mixed $order
     * @return Factory|View
     */
    public function show(Order $order)
    {
        return view('pages.orders.manager.show', [
            'order' => $order,
            'status' => Order::getStatusFor('status')->sortBy('order'),
            'courriers' => Courrier::orderBy('name')->get(),
            'notifications' => Notification::whereIn('event', [
                'order_confirmation',
                'order_ship',
                'order_cancel',
                'points_create',
                'admin_order_create',
                'supplier_order_create'
            ])->get(),
            'breadcrumb' => $this->breadcrumb([
                [
                    'title' => 'Orders',
                    'route' => route('order.admin.index')
                ]
            ], 'Order #' . $order->short_id),
        ]);
    }

    /**
     * print.
     *
     * @param mixed $order
     * @return Factory|View
     */
    public function print(Order $order)
    {
        return view('pages.orders.manager.print', [
            'order' => $order,
            'site_title' => ConfigData::findByType('title')->value,
            'site_logo' => ConfigData::findByType('logo')->cover->getUrl(),
            'site_address' => ConfigData::findByType('address')->value,
            'contact_number' => ConfigData::findByType('contact_numbers')->value,
            'email' => ConfigData::findByType('emails')->value,
        ]);
    }

    /**
     * update.
     *
     * @param mixed $order
     * @param OrderStore $request
     * @return JsonResponse|RedirectResponse|Redirector
     */
    public function update(Order $order, OrderStore $request)
    {
        $order->update($request->except('redirect_to'));
        return $this->returnCrudData(__('system_messages.common.update_success'), $request->redirect_to);
    }

    /**
     * update.
     *
     * @param mixed $order
     * @param OrderStore $request
     * @return JsonResponse|RedirectResponse|Redirector
     */
    public function email(Order $order, OrderStore $request)
    {
        $notification = Notification::findOrFail($request->notification_id);
        if ($notification->event == 'points_create') {
            $this->{$notification->event}($order->reward_points()->latest()->first());
        } else {
            $this->{$notification->event}($order);
        }
        return $this->returnCrudData(__('Email Sent Successfully'));
    }

    public function export(Request $request)
    {
        return Excel::download(new OrderExport($this->getOrders($request)), "Orders " . today()->format('d-m-Y') . ".csv");
    }

    private function getOrders(Request $request)
    {
        $orders = Order::query();
        $orders->whereHas('user')->where('is_temp', false);
        if ($this->filterQueryStrings()) {
            $orders = $this->filterData($request, $orders);
        }
        return $orders->get();
    }
}
