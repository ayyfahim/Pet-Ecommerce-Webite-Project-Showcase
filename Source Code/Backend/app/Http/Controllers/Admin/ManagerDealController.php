<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Traits\Deal\Filtration;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Deal;
use App\Models\Product;
use App\Models\Vendor;
use App\Presenters\CommonPresenter;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use App\Http\Controllers\Controller;
use App\Http\Requests\DealRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

/**
 * @group ManagerDeal
 */
class ManagerDealController extends Controller
{
    use Filtration;

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
        $deals = Deal::query();
        if ($this->filterQueryStrings()) {
            $deals = $this->filterData($request, $deals);
        }


        return view('pages.deals.manager.index', [
            'deals' => $deals->get(),
            'products' => Product::latest()->isActive()->get(),
            'vendors' => Vendor::get()->sortBy('name'),
            'brands' => Brand::get()->sortBy('name'),
            'childCategories' => Category::lastLevel()->get()->groupBy('parent.name')->sortBy('name'),
            'breadcrumb' => $this->breadcrumb([], 'Deals')
        ]);
    }

    /**
     * create.
     */
    public function create()
    {
        return view('pages.deals.manager.add', [
            'products' => Product::latest()->isActive()->get(),
            'breadcrumb' => $this->breadcrumb([
                [
                    'title' => 'Deals',
                    'route' => route('deal.admin.index')
                ]
            ], 'Add New Deal'),
        ]);
    }

    /**
     * store.
     *
     * @param DealRequest $request
     * @return JsonResponse|RedirectResponse|Redirector
     * @throws \Throwable
     */
    public function store(DealRequest $request)
    {
        DB::transaction(function () use ($request) {
            $deal = Deal::create($request->toArray());
        });

        return $this->returnCrudData(__('system_messages.common.create_success'), route('deal.admin.index'));
    }

    /**
     * edit.
     *
     * @param mixed $deal
     * @return Factory|View
     */
    public function edit(Deal $deal)
    {
        return view('pages.deals.manager.edit', [
            'products' => Product::latest()->isActive()->get(),
            'deal' => $deal,
            'breadcrumb' => $this->breadcrumb([
                [
                    'title' => 'Deals',
                    'route' => route('deal.admin.index')
                ]
            ], 'Edit Deal'),
        ]);
    }

    /**
     * update.
     *
     * @param mixed $deal
     * @param DealRequest $request
     * @return JsonResponse|RedirectResponse|Redirector
     * @throws \Throwable
     */
    public function update(Deal $deal, DealRequest $request)
    {
        DB::transaction(function () use ($request, $deal) {
            $deal->update($request->except('redirect_to'));
        });
        return $this->returnCrudData(__('system_messages.common.update_success'), $request->redirect_to);
    }

    /**
     * delete.
     *
     * @param Deal $deal
     * @param Request $request
     * @return JsonResponse|RedirectResponse|Redirector
     * @throws Exception
     */
    public function destroy(Deal $deal, Request $request)
    {
        $deal->delete();
        return $this->returnCrudData(__('system_messages.common.delete_success'), $request->redirect_to ?: url()->previous());
    }
}
