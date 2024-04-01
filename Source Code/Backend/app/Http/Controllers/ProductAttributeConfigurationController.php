<?php

namespace App\Http\Controllers;

use App\Models\RelatedAttributeConfiguration;
use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Validation\ValidationException;

class ProductAttributeConfigurationController extends Controller
{

    public function __construct()
    {
    }

    /**
     * index
     *
     * @return Renderable
     */
    public function index()
    {
        return view('pages.productattributeconfigurations.index',[
        ]);
    }

    /**
     * create
     *
     * @return Renderable
     */
    public function create()
    {
        return view('pages.productattributeconfigurations.create', [
        ]);
    }

    /**
     * store
     *
     * @param Request $request
     * @return JsonResponse|RedirectResponse|Redirector
     * @throws ValidationException
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            '' => 'required',
        ]);
        try {
            RelatedAttributeConfiguration::create($request->toArray());
            return $this->returnCrudData(__('system_messages.common.create_success'), route('productattributeconfiguration.index'));
        } catch (Exception $exception) {
            return $this->returnCrudData($exception->getMessage(), null, 'error');
        }
    }

    /**
     * update
     *
     * @param Request $request
     * @param RelatedAttributeConfiguration $productattributeconfiguration.
     * @return JsonResponse|RedirectResponse|Redirector
     * @throws ValidationException
     */
    public function update(Request $request, RelatedAttributeConfiguration $productattributeconfiguration)
    {
        $this->validate($request, [
                   '' => 'required',
               ]);
        try {
           $productattributeconfiguration->update($request->toArray());
           return $this->returnCrudData(__('system_messages.common.update_success'), route('productattributeconfiguration.index'));
        } catch (Exception $exception) {
           return $this->returnCrudData($exception->getMessage(), null, 'error');
        }
    }

    /**
     * show
     *
     * @param RelatedAttributeConfiguration $productattributeconfiguration.
     * @return Renderable
     */
    public function show(RelatedAttributeConfiguration $productattributeconfiguration)
    {
        return view('pages.productattributeconfigurations.show', [
            'productattributeconfiguration' => $productattributeconfiguration
        ]);
    }

    /**
     * destroy
     *
     * @param RelatedAttributeConfiguration $productattributeconfiguration.
     * @return JsonResponse|RedirectResponse|Redirector
     * @throws Exception
     */
    public function destroy(RelatedAttributeConfiguration $productattributeconfiguration)
    {
        $productattributeconfiguration->delete();
        return $this->returnCrudData(__('system_messages.common.delete_success'), route('productattributeconfiguration.index'));
    }
}
