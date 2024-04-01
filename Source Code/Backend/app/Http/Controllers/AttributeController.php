<?php

namespace App\Http\Controllers;

use App\Models\Attribute;
use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Validation\ValidationException;

class AttributeController extends Controller
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
        return view('pages.attributes.index',[
        ]);
    }

    /**
     * create
     *
     * @return Renderable
     */
    public function create()
    {
        return view('pages.attributes.create', [
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
            Attribute::create($request->toArray());
            return $this->returnCrudData(__('system_messages.common.create_success'), route('attribute.index'));
        } catch (Exception $exception) {
            return $this->returnCrudData($exception->getMessage(), null, 'error');
        }
    }

    /**
     * update
     *
     * @param Request $request
     * @param Attribute $attribute.
     * @return JsonResponse|RedirectResponse|Redirector
     * @throws ValidationException
     */
    public function update(Request $request, Attribute $attribute)
    {
        $this->validate($request, [
                   '' => 'required',
               ]);
        try {
           $attribute->update($request->toArray());
           return $this->returnCrudData(__('system_messages.common.update_success'), route('attribute.index'));
        } catch (Exception $exception) {
           return $this->returnCrudData($exception->getMessage(), null, 'error');
        }
    }

    /**
     * show
     *
     * @param Attribute $attribute.
     * @return Renderable
     */
    public function show(Attribute $attribute)
    {
        return view('pages.attributes.show', [
            'attribute' => $attribute
        ]);
    }

    /**
     * destroy
     *
     * @param Attribute $attribute.
     * @return JsonResponse|RedirectResponse|Redirector
     * @throws Exception
     */
    public function destroy(Attribute $attribute)
    {
        $attribute->delete();
        return $this->returnCrudData(__('system_messages.common.delete_success'), route('attribute.index'));
    }
}
