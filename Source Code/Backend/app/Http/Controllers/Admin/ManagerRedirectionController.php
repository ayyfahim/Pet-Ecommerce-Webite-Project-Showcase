<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Traits\Redirection\Filtration;
use App\Http\Controllers\Traits\RedirectionOptions;
use App\Models\Redirection;
use App\Presenters\CommonPresenter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\RedirectionRequest;

class ManagerRedirectionController extends Controller
{
    use Filtration;

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
        $redirections = Redirection::query();
        if ($this->filterQueryStrings()) {
            $redirections = $this->filterData($request, $redirections);
        }

        $redirections = app(CommonPresenter::class)->paginate($redirections->get());

        return view('pages.redirections.manager.index', [
            'redirections' => $redirections,
            'status' => Redirection::getStatusFor('status'),
            'breadcrumb' => $this->breadcrumb([], 'Redirections')
        ]);
    }

    /**
     * create.
     */
    public function create()
    {
        $config = Redirection::getStatusFor();
        return view('pages.redirections.manager.add', [
            'types' => app(Redirection::class)->types,
            'active_status' => $config['status']->firstWhere('order', 1)->id,
            'inactive_status' => $config['status']->firstWhere('order', 2)->id,
            'status' => Redirection::getStatusFor('status'),
            'breadcrumb' => $this->breadcrumb([
                [
                    'title' => 'Redirections',
                    'route' => route('redirection.admin.index')
                ]
            ], 'Add New Redirection'),
        ]);
    }

    /**
     * store.
     *
     * @param RedirectionRequest $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Throwable
     */
    public function store(RedirectionRequest $request)
    {
        $redirection = null;
        DB::transaction(function () use ($request, &$redirection) {
            $redirection = Redirection::create($request->except('categories'));
        });
        if ($redirection) {
            return $this->returnCrudData(__('system_messages.common.create_success'), route('redirection.admin.index'));
        }
    }

    /**
     * edit.
     *
     * @param mixed $redirection
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Redirection $redirection)
    {
        $config = Redirection::getStatusFor();
        return view('pages.redirections.manager.edit', [
            'redirection' => $redirection,
            'active_status' => $config['status']->firstWhere('order', 1)->id,
            'inactive_status' => $config['status']->firstWhere('order', 2)->id,
            'status' => Redirection::getStatusFor('status'),
            'breadcrumb' => $this->breadcrumb([
                [
                    'title' => 'Redirections',
                    'route' => route('redirection.admin.index')
                ]
            ], 'Edit Redirection'),
        ]);
    }

    /**
     * update.
     *
     * @param mixed $redirection
     * @param RedirectionRequest $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Throwable
     */
    public function update(Redirection $redirection, RedirectionRequest $request)
    {
        DB::transaction(function () use ($redirection, $request) {
            $redirection->update($request->except('redirect_to', 'options', 'categories'));
        });
        return $this->returnCrudData(__('system_messages.common.update_success'), $request->redirect_to);
    }

    /**
     * delete.
     *
     * @param Redirection $redirection
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Throwable
     */
    public function destroy(Redirection $redirection, Request $request)
    {
        DB::transaction(function () use ($redirection) {
            $redirection->delete();
        });
        return $this->returnCrudData(__('system_messages.common.delete_success'), $request->redirect_to ?: url()->previous());
    }

}
