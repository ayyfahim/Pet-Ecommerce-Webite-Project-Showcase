<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Traits\Icon\Filtration;
use App\Models\Icon;
use App\Presenters\CommonPresenter;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\IconRequest;
use App\Presenters\IconPresenter;
use App\Transformers\IconTransformer;
use App\Http\Controllers\Traits\IconFiltration;
use Illuminate\View\View;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

/**
 * @group ManagerIcon
 */
class ManagerIconController extends Controller
{
    use Filtration;

    public function __construct()
    {
        $this->middleware(['auth','manager_access']);
    }

    /**
     * index.
     *
     * @queryParam q search in name
     */
    public function index(Request $request)
    {
        $icons = Icon::query();
        if ($this->filterQueryStrings()) {
            $icons = $this->filterData($request, $icons);
        }

        $icons = app(CommonPresenter::class)->paginate($icons->get());

        return view('pages.icons.manager.index', [
            'icons' => $icons,
            'breadcrumb' => $this->breadcrumb([], 'Icons')
        ]);
    }

    /**
     * create.
     */
    public function create()
    {
        return view('pages.icons.manager.add', [
            'breadcrumb' => $this->breadcrumb([
                [
                    'title' => 'Icons',
                    'route' => route('icon.admin.index')
                ]
            ], 'Add New Icon'),
        ]);
    }

    /**
     * store.
     *
     * @param IconRequest $request
     * @return JsonResponse|RedirectResponse|Redirector
     * @throws \Throwable
     */
    public function store(IconRequest $request)
    {
        DB::transaction(function () use ($request) {
            $icon = Icon::create($request->except('badge','alt'));
            if ($badge = $request->badge) {
                $icon->addHashedMedia($badge, null, ['alt' => $request->alt])->toMediaCollection('badge');
            }
        });
        return $this->returnCrudData(__('system_messages.common.create_success'), route('icon.admin.index'));
    }

    /**
     * edit.
     *
     * @param mixed $icon
     * @return Factory|View
     */
    public function edit(Icon $icon)
    {
        return view('pages.icons.manager.edit', [
            'icon' => $icon,
            'breadcrumb' => $this->breadcrumb([
                [
                    'title' => 'Icons',
                    'route' => route('icon.admin.index')
                ]
            ], 'Edit Icon'),
        ]);
    }

    /**
     * update.
     *
     * @param mixed $icon
     * @param IconRequest $request
     * @return JsonResponse|RedirectResponse|Redirector
     * @throws \Throwable
     */
    public function update(Icon $icon, IconRequest $request)
    {
        DB::transaction(function () use ($request, $icon) {
            $icon->update($request->except('redirect_to','badge','alt'));
            if ($badge = $request->badge) {
                $icon->addHashedMedia($badge, null, ['alt' => $request->alt])->toMediaCollection('badge');
            }
        });
        return $this->returnCrudData(__('system_messages.common.update_success'), $request->redirect_to);
    }

    /**
     * delete.
     *
     * @param Icon $icon
     * @param Request $request
     * @return JsonResponse|RedirectResponse|Redirector
     * @throws Exception
     */
    public function destroy(Icon $icon, Request $request)
    {
        $icon->delete();
        return $this->returnCrudData(__('system_messages.common.delete_success'), $request->redirect_to ?:url()->previous());
    }
}
