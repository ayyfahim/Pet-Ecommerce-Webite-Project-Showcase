<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Traits\AttributeOptions;
use App\Models\Attribute;
use App\Models\Category;
use App\Models\Product;
use App\Presenters\CommonPresenter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\AttributeStore;
use App\Http\Controllers\Traits\AttributeFiltration;

class ManagerAttributeController extends Controller
{
    use AttributeFiltration, AttributeOptions;

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
        $attributes = Attribute::query();
        if ($this->filterQueryStrings()) {
            $attributes = $this->filterData($request, $attributes);
        }

        $attributes = app(CommonPresenter::class)->paginate($attributes->get());

        return view('pages.attributes.manager.index', [
            'attributes' => $attributes,
            'status' => Attribute::getStatusFor('status'),
            'breadcrumb' => $this->breadcrumb([], 'Attributes')
        ]);
    }

    /**
     * create.
     */
    public function create()
    {
        $config = Attribute::getStatusFor();
        return view('pages.attributes.manager.add', [
            'types' => app(Attribute::class)->types,
            'active_status' => $config['status']->firstWhere('order', 1)->id,
            'inactive_status' => $config['status']->firstWhere('order', 2)->id,
            'status' => Attribute::getStatusFor('status'),
            'breadcrumb' => $this->breadcrumb([
                [
                    'title' => 'Attributes',
                    'route' => route('attribute.admin.index')
                ]
            ], 'Add New Attribute'),
        ]);
    }

    /**
     * store.
     *
     * @param AttributeStore $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Throwable
     */
    public function store(AttributeStore $request)
    {
        $attribute = null;
        DB::transaction(function () use ($request, &$attribute) {
            $attribute = Attribute::create($request->except('categories'));
        });
        if ($attribute) {
            return $this->returnCrudData(__('system_messages.common.create_success'), route('attribute.admin.index'));
        }
    }

    /**
     * edit.
     *
     * @param mixed $attribute
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Attribute $attribute)
    {
        $config = Attribute::getStatusFor();
        return view('pages.attributes.manager.edit', [
            'attribute' => $attribute,
            'active_status' => $config['status']->firstWhere('order', 1)->id,
            'inactive_status' => $config['status']->firstWhere('order', 2)->id,
            'status' => Attribute::getStatusFor('status'),
            'breadcrumb' => $this->breadcrumb([
                [
                    'title' => 'Attributes',
                    'route' => route('attribute.admin.index')
                ]
            ], 'Edit Attribute'),
        ]);
    }

    /**
     * update.
     *
     * @param mixed $attribute
     * @param AttributeStore $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Throwable
     */
    public function update(Attribute $attribute, AttributeStore $request)
    {
        DB::transaction(function () use ($attribute, $request) {
            $attribute->update($request->except('redirect_to', 'options', 'categories'));
        });
        return $this->returnCrudData(__('system_messages.common.update_success'), $request->redirect_to);
    }

    /**
     * delete.
     *
     * @param Attribute $attribute
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Throwable
     */
    public function destroy(Attribute $attribute, Request $request)
    {
        DB::transaction(function () use ($attribute) {
            $attribute->delete();
        });
        return $this->returnCrudData(__('system_messages.common.delete_success'), $request->redirect_to ?: url()->previous());
    }

    /**
     * getAttributeOption.
     *
     * @param Request $request
     * @return string
     */
    public function getAttributeOption(Request $request)
    {
        return (string)view('pages.attributes.manager.partials.option', ['show_delete_button' => true, 'index' => $request->index, 'to_render' => true]);
    }

    /**
     * getProductOption.
     *
     * @param Request $request
     * @return string
     */
    public function getProductOption(Request $request)
    {
        $attribute = Attribute::findOrFail($request->attribute_id);
        return (string)view('pages.products.manager.partials.form-items.attribute-configurable', [
            'show_delete_button' => true,
            'index' => $request->index,
            'configurationKey' => $request->configuration_index,
            'attributeMainKey' => $request->attribute_key,
            'attribute' => $attribute,
        ]);
    }
}
