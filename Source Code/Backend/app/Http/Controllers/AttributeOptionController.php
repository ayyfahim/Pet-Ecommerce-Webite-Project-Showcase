<?php

namespace App\Http\Controllers;

use App\Models\AttributeOption;
use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Validation\ValidationException;

class AttributeOptionController extends Controller
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
        return view('pages.attributeoptions.index',[
        ]);
    }

    /**
     * create
     *
     * @return Renderable
     */
    public function create()
    {
        return view('pages.attributeoptions.create', [
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
            AttributeOption::create($request->toArray());
            return $this->returnCrudData(__('system_messages.common.create_success'), route('attributeoption.index'));
        } catch (Exception $exception) {
            return $this->returnCrudData($exception->getMessage(), null, 'error');
        }
    }

    /**
     * update
     *
     * @param Request $request
     * @param AttributeOption $attributeoption.
     * @return JsonResponse|RedirectResponse|Redirector
     * @throws ValidationException
     */
    public function update(Request $request, AttributeOption $attributeoption)
    {
        $this->validate($request, [
                   '' => 'required',
               ]);
        try {
           $attributeoption->update($request->toArray());
           return $this->returnCrudData(__('system_messages.common.update_success'), route('attributeoption.index'));
        } catch (Exception $exception) {
           return $this->returnCrudData($exception->getMessage(), null, 'error');
        }
    }

    /**
     * show
     *
     * @param AttributeOption $attributeoption.
     * @return Renderable
     */
    public function show(AttributeOption $attributeoption)
    {
        return view('pages.attributeoptions.show', [
            'attributeoption' => $attributeoption
        ]);
    }

    /**
     * destroy
     *
     * @param AttributeOption $attributeoption.
     * @return JsonResponse|RedirectResponse|Redirector
     * @throws Exception
     */
    public function destroy(AttributeOption $attributeoption)
    {
        $attributeoption->delete();
        return $this->returnCrudData(__('system_messages.common.delete_success'), route('attributeoption.index'));
    }
}
