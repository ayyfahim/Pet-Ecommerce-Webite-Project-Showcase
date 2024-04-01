<?php

namespace App\Http\Controllers;

use App\Exports\OrderExport;
use App\Exports\SupplierExport;
use App\Http\Controllers\Traits\VendorOptions;
use App\Models\Vendor;
use App\Models\Category;
use App\Models\Product;
use App\Presenters\CommonPresenter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\VendorStore;
use App\Http\Controllers\Traits\VendorFiltration;
use Maatwebsite\Excel\Facades\Excel;

class ManagerVendorController extends Controller
{
    use VendorFiltration;

    public function __construct()
    {
        $this->middleware(['auth', 'manager_access']);
    }

    /**
     * index.
     *
     * @queryParam q search in name
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        return view('pages.vendors.manager.index', [
            'vendors' => $this->getVendors($request),
            'breadcrumb' => $this->breadcrumb([], 'Suppliers')
        ]);
    }
    public function getVendors(Request $request){
        $vendors = Vendor::query();
        if ($this->filterQueryStrings()) {
            $vendors = $this->filterData($request, $vendors);
        }
        return $vendors->get();
    }

    public function export(Request $request)
    {
        return Excel::download(new SupplierExport($this->getVendors($request)), "Suppliers " . today()->format('d-m-Y') . ".csv");
    }
    /**
     * create.
     */
    public function create()
    {
        return view('pages.vendors.manager.add', [
            'status'=>Vendor::getStatusFor('status'),
            'breadcrumb' => $this->breadcrumb([
                [
                    'title' => 'Suppliers',
                    'route' => route('vendor.admin.index')
                ]
            ], 'Add New Supplier'),
        ]);
    }

    /**
     * store.
     *
     * @param VendorStore $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Throwable
     */
    public function store(VendorStore $request)
    {
        $vendor = Vendor::create($request->except('cover'));
        if ($cover = $request->cover) {
            $vendor->addHashedMedia($cover, null, ['alt' => $request->cover_alt])->toMediaCollection('cover');
        }
        return $this->returnCrudData(__('system_messages.common.create_success'), route('vendor.admin.index'));
    }

    /**
     * edit.
     *
     * @param mixed $vendor
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Vendor $vendor)
    {
        return view('pages.vendors.manager.edit', [
            'status'=>Vendor::getStatusFor('status'),
            'vendor' => $vendor,
            'breadcrumb' => $this->breadcrumb([
                [
                    'title' => 'Suppliers',
                    'route' => route('vendor.admin.index')
                ]
            ], 'Edit Supplier'),
        ]);
    }

    /**
     * update.
     *
     * @param mixed $vendor
     * @param VendorStore $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Throwable
     */
    public function update(Vendor $vendor, VendorStore $request)
    {
        $vendor->update($request->except('redirect_to','cover'));

        if ($cover = $request->cover) {
            $vendor->addHashedMedia($cover, null, ['alt' => $request->cover_alt])->toMediaCollection('cover');
        }
        return $this->returnCrudData(__('system_messages.common.update_success'), $request->redirect_to);
    }

    /**
     * delete.
     *
     * @param Vendor $vendor
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Throwable
     */
    public function destroy(Vendor $vendor, Request $request)
    {
        $vendor->delete();
        return $this->returnCrudData(__('system_messages.common.delete_success'), $request->redirect_to ?: url()->previous());
    }
}
