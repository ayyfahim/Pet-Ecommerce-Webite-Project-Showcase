<?php

namespace App\Http\Controllers\Admin;

use App\Exports\CouponExport;
use App\Http\Controllers\Traits\CouponFiltration;
use App\Models\Category;
use App\Models\Coupon;
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

use Maatwebsite\Excel\Facades\Excel;

/**
 * @group ManagerCoupon
 */
class ManagerCouponController extends Controller
{
    use CouponFiltration;

    public function __construct()
    {
    }

    /**
     * index.
     *
     * @queryParam q search in name
     * @param Request $request
     * @return Factory|View
     */
    public function index(Request $request)
    {

        $coupons = app(CommonPresenter::class)->paginate($this->getCoupons($request));

        return view('pages.coupons.manager.index', [
            'coupons' => $coupons,
            'childCategories' => Category::lastLevel()->get()->groupBy('parent.name')->sortBy('name'),
            'products' => Product::latest()->isActive()->get(),
            'status' => Coupon::getStatusFor('status'),
            'breadcrumb' => $this->breadcrumb([], 'Coupons')
        ]);
    }
    public function getCoupons(Request $request){
        $coupons = Coupon::query();
        if ($this->filterQueryStrings()) {
            $coupons = $this->filterData($request, $coupons);
        }
        return $coupons->get();
    }

    public function export(Request $request)
    {
        return Excel::download(new CouponExport($this->getCoupons($request)), "Coupons " . today()->format('d-m-Y') . ".csv");
    }

    /**
     * create.
     */
    public function create()
    {
        $status = Coupon::getStatusFor('status');
        return view('pages.coupons.manager.add', [
            'status_id' => $status->firstWhere('order', 1)->id,
            'reversed_status_id' => $status->firstWhere('order', 2)->id,
            'childCategories' => Category::lastLevel()->get()->sortBy('name'),
            'products' => Product::latest()->isActive()->get(),
            'status' => $status,
            'breadcrumb' => $this->breadcrumb([
                [
                    'title' => 'Coupons',
                    'route' => route('coupon.admin.index')
                ]
            ], 'Add New Coupon'),
        ]);
    }

    /**
     * store.
     *
     * @param CouponRequest $request
     * @return JsonResponse|RedirectResponse|Redirector
     * @throws \Throwable
     */
    public function store(CouponRequest $request)
    {
        DB::transaction(function () use ($request) {
            $coupon = Coupon::create($request->except('cover', 'categories', 'products'));
            if ($categories = $request->categories) {
                $coupon->categories()->sync($categories);
            }

            if ($products = $request->products) {
                foreach ($products as $product) {
                    $coupon->products()->create(['product_id' => $product]);
                }
            }
        });

        return $this->returnCrudData(__('system_messages.common.create_success'), route('coupon.admin.index'));
    }

    /**
     * edit.
     *
     * @param mixed $coupon
     * @return Factory|View
     */
    public function edit(Coupon $coupon)
    {
        $status = Coupon::getStatusFor('status');
        return view('pages.coupons.manager.edit', [
            'status_id' => $status->firstWhere('order', 1)->id,
            'reversed_status_id' => $status->firstWhere('order', 2)->id,
            'childCategories' => Category::lastLevel()->get()->sortBy('name'),
            'products' => Product::latest()->isActive()->get(),
            'coupon' => $coupon,
            'status' => $status,
            'breadcrumb' => $this->breadcrumb([
                [
                    'title' => 'Coupons',
                    'route' => route('coupon.admin.index')
                ]
            ], 'Edit Coupon'),
        ]);
    }

    /**
     * update.
     *
     * @param mixed $coupon
     * @param CouponRequest $request
     * @return JsonResponse|RedirectResponse|Redirector
     * @throws \Throwable
     */
    public function update(Coupon $coupon, CouponRequest $request)
    {
        DB::transaction(function () use ($request, $coupon) {
            $coupon->update($request->except('redirect_to', 'cover', 'categories', 'products'));
            if ($categories = $request->categories) {
                $coupon->categories()->sync($categories);
            }
            if ($products = $request->products) {
                $coupon->products()->delete();
                foreach ($products as $product) {
                    $coupon->products()->create(['product_id' => $product]);
                }
            }
        });
        return $this->returnCrudData(__('system_messages.common.update_success'), $request->redirect_to);
    }

    /**
     * delete.
     *
     * @param Coupon $coupon
     * @param Request $request
     * @return JsonResponse|RedirectResponse|Redirector
     * @throws Exception
     */
    public function destroy(Coupon $coupon, Request $request)
    {
        $coupon->delete();
        return $this->returnCrudData(__('system_messages.common.delete_success'), $request->redirect_to ?: url()->previous());
    }
}
