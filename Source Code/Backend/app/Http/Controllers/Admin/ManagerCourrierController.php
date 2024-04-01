<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Traits\Courrier\Filtration;
use App\Http\Requests\CourrierRequest;
use App\Models\Courrier;
use App\Presenters\CommonPresenter;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\View\View;

class ManagerCourrierController extends Controller
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
        $courriers = Courrier::query();
        if ($this->filterQueryStrings()) {
            $courriers = $this->filterData($request, $courriers);
        }
        $courriers = app(CommonPresenter::class)->paginate($courriers->get());

        return view('pages.courriers.index', [
            'courriers' => $courriers,
            'breadcrumb' => $this->breadcrumb([], 'Courriers')
        ]);
    }

    /**
     * create.
     */
    public function create()
    {
        return view('pages.courriers.add', [
            'breadcrumb' => $this->breadcrumb([
                [
                    'title' => 'Courriers',
                    'route' => route('courrier.admin.index')
                ]
            ], 'Add Courrier'),
        ]);
    }

    /**
     * store.
     *
     * @param CourrierRequest $request
     * @return JsonResponse|RedirectResponse|Redirector
     */
    public function store(CourrierRequest $request)
    {
        Courrier::create($request->all());
        return $this->returnCrudData(__('system_messages.common.create_success'), route('courrier.admin.index'));
    }

    /**
     * edit.
     *
     * @param mixed $courrier
     * @return Factory|View
     */
    public function edit(Courrier $courrier)
    {
        return view('pages.courriers.edit', [
            'courrier' => $courrier,
            'breadcrumb' => $this->breadcrumb([
                [
                    'title' => 'Courriers',
                    'route' => route('courrier.admin.index')
                ]
            ], 'Edit Courrier'),
        ]);
    }

    /**
     * update.
     *
     * @param mixed $courrier
     * @param CourrierRequest $request
     * @return JsonResponse|RedirectResponse|Redirector
     */
    public function update(Courrier $courrier, CourrierRequest $request)
    {
        $courrier->update($request->except('redirect_to'));
        return $this->returnCrudData(__('system_messages.common.update_success'), $request->redirect_to);
    }

    /**
     * delete.
     *
     * @param Courrier $courrier
     * @param Request $request
     * @return JsonResponse|RedirectResponse|Redirector
     * @throws \Throwable
     */
    public function destroy(Courrier $courrier, Request $request)
    {
        DB::transaction(function () use ($courrier) {
            $courrier->delete();
        });

        return $this->returnCrudData(__('system_messages.common.delete_success'), $request->redirect_to ?: url()->previous());
    }
}
