<?php

namespace App\Http\Controllers;

use App\Exports\DonationReportExport;
use App\Exports\OrderExport;
use App\Http\Controllers\Admin\ManagerProductController;
use App\Http\Controllers\Traits\Product\ProductDataImport;
use App\Models\Article;
use App\Models\Attribute;
use App\Models\Brand;
use App\Models\City;
use App\Models\Country;
use App\Models\Deal;
use App\Models\DiscountRule;
use App\Models\Order;
use App\Models\Product;
use App\Models\RelatedAttribute;
use App\Models\Slide;
use App\Models\Service;
use App\Models\Category;
use App\Models\Vendor;
use App\Notifications\SendNotification;
use App\Presenters\CommonPresenter;
use App\Transformers\ArticleTransformer;
use App\Transformers\DealTransformer;
use App\Transformers\ProductTransformer;
use App\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Transformers\SlideTransformer;
use App\Transformers\ServiceTransformer;
use App\Transformers\CategoryTransformer;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

/**
 * @group Home
 */
class HomeController extends Controller
{

    /**
     *  Home-Page
     * @param Request $request
     * @return JsonResponse|RedirectResponse|Redirector
     */
    public function index(Request $request)
    {
        if ($request->expectsJson()) {
            return response()->json([
                'hot_deals_products' => fractal(collect([]), new DealTransformer())->toArray()['data'],
                'featured_products' => fractal(Product::isSearchable()->latest()->where('featured', true)->take(10)->get(), new ProductTransformer())->toArray()['data'],
                'featured_categories' => fractal(Category::where('featured', true)->orderByRaw('-sort_order DESC')->take(4)->get(), new CategoryTransformer())->toArray()['data'],
                'recent_blogs' => fractal(Article::isActive()->latest()->take(3)->get(), new ArticleTransformer())->toArray()['data'],
                'top_selling_products' => fractal(Product::isSearchable()->orderByTopSelling()->take(5)->get(), new ProductTransformer())->toArray()['data']
            ]);
        }
    }

    public function react(Request $request)
    {
        return view('welcome');
    }

    public function dashboard(Request $request)
    {
        $default_from = today()->firstOfMonth()->toDateString();
        $default_to = today()->toDateString();
        $dates['date_created_at_from'] = $request->date_created_at_from ? $request->date_created_at_from : $default_from;
        $dates['date_created_at_to'] = $request->date_created_at_to ? $request->date_created_at_to : $default_to;
        $dates['category_created_at_from'] = $request->category_created_at_from ? $request->category_created_at_from : $default_from;
        $dates['category_created_at_to'] = $request->category_created_at_to ? $request->category_created_at_to : $default_to;
        $dates['sub_category_created_at_from'] = $request->sub_category_created_at_from ? $request->sub_category_created_at_from : $default_from;
        $dates['sub_category_created_at_to'] = $request->sub_category_created_at_to ? $request->sub_category_created_at_to : $default_to;
        return view('pages.dashboard.index', array_merge($dates,[
            'breadcrumb' => $this->breadcrumb([], 'Dashboard', false),
            'customers_count' => User::withRole('customer')->isActive()->count(),
            'products_count' => Product::count(),
            'orders_count' => number_format(Order::get()->sum('amount')),
            'orders_pending_count' => Order::whereHas('status', function ($query) {
                $query->where('order', 1);
            })->count(),
            'orders_completed_count' => Order::whereHas('status', function ($query) {
                $query->where('order', 3);
            })->count(),
            'products' => Product::isSearchable()->where('quantity', '<', 10)->take(20)->get(),
            'orders' => Order::latest()->isPersisted()->take(10)->get(),

            'today_orders' => Order::IsPersisted()->today()->get(),
            'month_orders' => Order::IsPersisted()->whereMonth('created_at', today()->format('m'))->whereYear('created_at', today()->format('Y'))->get(),
            'year_orders' => Order::IsPersisted()->whereYear('created_at', today()->format('Y'))->get(),
            'all_orders' => Order::IsPersisted()->get(),
            'total_orders_date' => $this->getOrdersReport($request, 'date', $dates),
            'total_orders_category' => $this->getOrdersReport($request, 'category', $dates),
            'total_orders_sub_category' => $this->getOrdersReport($request, 'sub_category', $dates),

        ]));
    }

    private function getOrdersReport(Request $request, $type = null, $dates)
    {
        $orders = Order::IsPersisted();
        if ($type == 'date') {
            $orders->where('created_at', '>=', $dates['date_created_at_from']);
            $orders->where('created_at', '<=', $dates['date_created_at_to'] );
        }
        elseif ($type == 'category') {
            $orders->where('created_at', '>=', $dates['category_created_at_from']);
            $orders->where('created_at', '<=', $dates['category_created_at_to'] );
        }
        elseif ($type == 'sub_category') {
            $orders->where('created_at', '>=', $dates['sub_category_created_at_from']);
            $orders->where('created_at', '<=', $dates['sub_category_created_at_to'] );
        }
        $orders = $orders->get();
        if ($type == 'category') {
            $orders = $orders->groupBy(function ($item) {
                return $item->order_products->first()->parent_category->name ?? '';
            });
        } elseif ($type == 'sub_category') {
            $orders = $orders->groupBy(function ($item) {
                return $item->order_products->first()?->category_id;
            });
        } elseif($type == 'date') {
            $orders = $orders->groupBy(function ($item) {
                return $item->created_at->format('d/m/Y');
            });
        }
        return $orders;
    }

    public function export(Request $request)
    {
        $orders = $this->getOrdersReport($request, $request->type);
        return Excel::download(new OrderExport($orders), "Orders " . today()->format('d-m-Y') . ".csv");
    }

    /**
     *  Support
     * @bodyParam name string required
     * @bodyParam email string required
     * @bodyParam phone string required
     * @bodyParam message string required
     * @param Request $request
     * @return JsonResponse|RedirectResponse|Redirector
     */
    public function support(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'message' => 'required',
        ]);
        $admins = User::withRole('admin')->get();
        new SendNotification('support', $admins, [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'message' => $request->message,
        ]);
        return $this->returnCrudData('Message Sent Successfully');
    }

    public function past_deals(Request $request)
    {
//        $deals = Deal::expired()->latest();
        $deals = app(CommonPresenter::class)->paginate(collect([]));
        if ($request->expectsJson()) {
            return $this->returnPaginatedApiData(
                $deals, new DealTransformer()
            );
        }
    }
    public function upload_media(Request $request)
    {
        $fileNameToStore = time() . '.' . $request->file('file')->getClientOriginalExtension();
        $path = $request->file('file')->storeAs('/', 'tinymce/' . $fileNameToStore);
        $path = '/storage/' . $path;
        return response()->json(['location' => $path]);
    }
}
