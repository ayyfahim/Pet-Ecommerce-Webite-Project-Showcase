<?php

namespace App\Http\Controllers;

use App\Models\Courrier;
use App\Http\Controllers\Traits\Courrier\Filtration;
use App\Presenters\CommonPresenter;
use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\CourrierRequest;
use Illuminate\Routing\Redirector;

class CourrierController extends Controller
{
    use Filtration;

    public function __construct()
    {
        $this->middleware(['auth']);
    }

    /**
     * index
     *
     * @param Request $request
     * @return Renderable
     */
    public function index(Request $request)
    {
        $courriers = Courrier::query();
        if ($this->filterQueryStrings()) {
            $courriers = $this->filterData($request, $courriers);
        }
        return view('pages.courriers.index',[
            'courriers' => app(CommonPresenter::class)->paginate($courriers->get()),
            'breadcrumb' => $this->breadcrumb([], 'Courriers')
        ]);
    }

    /**
     * create
     *
     * @return Renderable
     */
    public function create()
    {
        return view('pages.courriers.create', array_merge($this->commonData(), [
            'breadcrumb' => $this->breadcrumb([
                [
                    'title' => 'Courriers',
                    'route' => route('courrier.index')
                ]
            ], 'Add New Courrier'),

        ]));
    }

    /**
     * store
     *
     * @param CourrierRequest $request
     * @return JsonResponse|RedirectResponse|Redirector
     */
    public function store(CourrierRequest $request)
    {
        try {
            Courrier::create($request->toArray());
            return $this->returnCrudData(__('system_messages.common.create_success'), route('courrier.index'));
        } catch (Exception $exception) {
            return $this->returnCrudData($exception->getMessage(), null, 'error');
        }
    }

    /**
     * edit
     *
     * @param Courrier $courrier.
     * @return Renderable
     */
    public function edit(Courrier $courrier)
    {
        return view('pages.courriers.edit', array_merge($this->commonData(), [
            'breadcrumb' => $this->breadcrumb([
                [
                    'title' => 'Courriers',
                    'route' => route('courrier.index')
                ]
            ], 'Edit Courrier'),
            'courrier' => $courrier,
        ]));
    }

    /**
     * update
     *
     * @param CourrierRequest $request
     * @param Courrier $courrier.
     * @return JsonResponse|RedirectResponse|Redirector
     */
    public function update(CourrierRequest $request, Courrier $courrier)
    {
        try {
           $courrier->update($request->except('redirect_to'));
           return $this->returnCrudData(__('system_messages.common.update_success'), $request->redirect_to);
        } catch (Exception $exception) {
           return $this->returnCrudData($exception->getMessage(), null, 'error');
        }
    }

    /**
     * show
     *
     * @param Courrier $courrier.
     * @return Renderable
     */
    public function show(Courrier $courrier)
    {
        return view('pages.courriers.show', [
            'breadcrumb' => $this->breadcrumb([
                [
                    'title' => 'Courriers',
                    'route' => route('courrier.index')
                ]
            ], $courrier->title),
            'courrier' => $courrier
        ]);
    }

    /**
     * destroy
     *
     * @param Courrier $courrier.
     * @return JsonResponse|RedirectResponse|Redirector
     * @throws Exception
     */
    public function destroy(Courrier $courrier)
    {
        $courrier->delete();
        return $this->returnCrudData(__('system_messages.common.delete_success'), route('courrier.index'));
    }

    // Other Methods

    private function commonData()
    {
        return [
            'status' => Courrier::getStatusFor('status')
        ];
    }
}
