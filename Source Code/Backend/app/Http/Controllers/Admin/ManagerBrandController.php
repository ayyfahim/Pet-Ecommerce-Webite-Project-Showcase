<?php

namespace App\Http\Controllers\Admin;

use App\Models\Brand;
use App\Presenters\CommonPresenter;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\BrandStore;
use App\Presenters\BrandPresenter;
use App\Transformers\BrandTransformer;
use App\Http\Controllers\Traits\BrandFiltration;
use Illuminate\View\View;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Spatie\MediaLibrary\Exceptions\FileCannotBeAdded\DiskDoesNotExist;
use Spatie\MediaLibrary\Exceptions\FileCannotBeAdded\FileDoesNotExist;
use Spatie\MediaLibrary\Exceptions\FileCannotBeAdded\FileIsTooBig;

/**
 * @group ManagerBrand
 */
class ManagerBrandController extends Controller
{
    use BrandFiltration;

    public function __construct()
    {
        $this->middleware(['auth', 'manager_access']);
    }

    /**
     * index.
     *
     * @queryParam q search in name
     */
    public function index(Request $request)
    {
        $brands = Brand::query();
        if ($this->filterQueryStrings()) {
            $brands = $this->filterData($request, $brands);
        }


        return view('pages.brands.manager.index', [
            'brands' => $brands->get(),
            'breadcrumb' => $this->breadcrumb([], 'Brands')
        ]);
    }

    /**
     * create.
     */
    public function create()
    {
        return view('pages.brands.manager.add', [
            'breadcrumb' => $this->breadcrumb([
                [
                    'title' => 'Brands',
                    'route' => route('brand.admin.index')
                ]
            ], 'Add New Brand'),
        ]);
    }

    /**
     * store.
     *
     * @param BrandStore $request
     * @return JsonResponse|RedirectResponse|Redirector
     */
    public function store(BrandStore $request)
    {
        $data = $request->except('badge', 'badge_alt', 'banner', 'banner_alt');
        $data['slug'] = $request->slug ?: $request->name;
        $brand = Brand::create($data);
        if ($badge = $request->badge) {
            $brand->addHashedMedia($badge, null, ['alt' => $request->badge_alt])->toMediaCollection('badge');
        }
        if ($banner = $request->banner) {
            $brand->addHashedMedia($banner, null, ['alt' => $request->banner_alt])->toMediaCollection('banner');
        }
        return $this->returnCrudData(__('system_messages.common.create_success'), route('brand.admin.index'));
    }

    /**
     * edit.
     *
     * @param mixed $brand
     * @return Factory|View
     */
    public function edit(Brand $brand)
    {
        return view('pages.brands.manager.edit', [
            'brand' => $brand,
            'breadcrumb' => $this->breadcrumb([
                [
                    'title' => 'Brands',
                    'route' => route('brand.admin.index')
                ]
            ], 'Edit Brand'),
        ]);
    }

    /**
     * update.
     *
     * @param mixed $brand
     * @param BrandStore $request
     * @return JsonResponse|RedirectResponse|Redirector
     * @throws DiskDoesNotExist
     * @throws FileDoesNotExist
     * @throws FileIsTooBig
     */
    public function update(Brand $brand, BrandStore $request)
    {
        $brand->update($request->except('redirect_to', 'badge', 'badge_alt', 'banner', 'banner_alt'));
        if ($badge = $request->badge) {
            $brand->addHashedMedia($badge, null, ['alt' => $request->badge_alt])->toMediaCollection('badge');
        }
        if ($banner = $request->banner) {
            $brand->addHashedMedia($banner, null, ['alt' => $request->banner_alt])->toMediaCollection('banner');
        }
        return $this->returnCrudData(__('system_messages.common.update_success'), $request->redirect_to);
    }

    /**
     * delete.
     *
     * @param Brand $brand
     * @param Request $request
     * @return JsonResponse|RedirectResponse|Redirector
     * @throws Exception
     */
    public function destroy(Brand $brand, Request $request)
    {
        $brand->delete();
        return $this->returnCrudData(__('system_messages.common.delete_success'), $request->redirect_to ?: url()->previous());
    }
}
