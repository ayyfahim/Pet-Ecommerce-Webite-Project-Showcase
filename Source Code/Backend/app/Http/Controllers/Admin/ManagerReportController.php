<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Traits\Report\ExtendedOps;
use App\Http\Controllers\Traits\Report\Filtration;
use App\Models\Category;
use App\Models\ConfigData;
use App\Models\Earning;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Product;
use App\Models\Rfp;
use App\Models\RfpProposal;
use App\Models\Service;
use App\Models\ServiceRequest;
use App\Presenters\CommonPresenter;
use App\Presenters\ServicePresenter;
use App\Presenters\UserPresenter;
use App\User;
use Carbon\Carbon;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class ManagerReportController extends Controller
{
    use ExtendedOps, Filtration;

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:admin')->except('index');
    }

    /**
     * index.
     *
     * @param Request $request
     * @return Factory|View
     */
    public function index(Request $request)
    {
        $date_from = $request->created_at_from ?: today()->subMonths(1)->firstOfMonth()->format('d-m-Y');
        $date_to = $request->created_at_to ?: today()->format('d-m-Y');
        $orders = Order::query()->whereHas('status', function ($query) {
            $query->where('order', 3);
        })->whereDate('created_at', '>=', Carbon::parse($date_from)->toDateString())
            ->whereDate('created_at', '<=', Carbon::parse($date_to)->toDateString());
        if ($request->product_id || $request->category_id) {
            $orders->whereHas('order_products', function ($query) use ($request) {
                if ($request->product_id) {
                    $query->where('product_id', $request->product_id);
                }
                if ($request->category_id) {
                    $query->where('category_id', $request->category_id);
                }
            });
            $orders = $orders->get();
            $sales = 0;
            foreach ($orders as $order) {
                $order_products = $order->order_products();
                if ($request->product_id) {
                    $order_products->where('product_id', $request->product_id);
                }
                if ($request->category_id) {
                    $order_products->where('category_id', $request->category_id);
                }
                $sales += $order_products->get()->sum('amount');
            }
        } else {
            $orders = $orders->get();
            $sales = $orders->sum('amount');
        }
        $sales = number_format($sales);
        $orders = app(CommonPresenter::class)->paginate($orders);
        return view('pages.reports.manager.index', [
            'date_from' => $date_from,
            'date_to' => $date_to,
            'breadcrumb' => $this->breadcrumb([], 'Reports'),
            'categories' => Category::lastLevel()->get()->sortBy('name'),
            'products' => Product::get()->sortBy('name'),
            'orders' => $orders,
            'sales' => $sales,
        ]);
    }
}
