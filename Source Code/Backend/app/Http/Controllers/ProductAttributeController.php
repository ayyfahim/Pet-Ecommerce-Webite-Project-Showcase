<?php

namespace App\Http\Controllers;

use App\Models\RelatedAttribute;
use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Validation\ValidationException;

class ProductAttributeController extends Controller
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
        return view('pages.productattributes.index',[
        ]);
    }

    /**
     * create
     *
     * @return Renderable
     */
    public function create()
    {
        return view('pages.productattributes.create', [
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
            RelatedAttribute::create($request->toArray());
            return $this->returnCrudData(__('system_messages.common.create_success'), route('productattribute.index'));
        } catch (Exception $exception) {
            return $this->returnCrudData($exception->getMessage(), null, 'error');
        }
    }

    /**
     * update
     *
     * @param Request $request
     * @param RelatedAttribute $productattribute.
     * @return JsonResponse|RedirectResponse|Redirector
     * @throws ValidationException
     */
    public function update(Request $request, RelatedAttribute $productattribute)
    {
        $this->validate($request, [
                   '' => 'required',
               ]);
        try {
           $productattribute->update($request->toArray());
           return $this->returnCrudData(__('system_messages.common.update_success'), route('productattribute.index'));
        } catch (Exception $exception) {
           return $this->returnCrudData($exception->getMessage(), null, 'error');
        }
    }

    /**
     * show
     *
     * @param RelatedAttribute $productattribute.
     * @return Renderable
     */
    public function show(RelatedAttribute $productattribute)
    {
        return view('pages.productattributes.show', [
            'productattribute' => $productattribute
        ]);
    }

    /**
     * destroy
     *
     * @param RelatedAttribute $productattribute.
     * @return JsonResponse|RedirectResponse|Redirector
     * @throws Exception
     */
    public function destroy(RelatedAttribute $productattribute)
    {
        $productattribute->delete();
        return $this->returnCrudData(__('system_messages.common.delete_success'), route('productattribute.index'));
    }
}
