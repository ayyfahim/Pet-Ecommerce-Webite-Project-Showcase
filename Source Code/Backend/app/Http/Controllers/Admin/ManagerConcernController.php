<?php

namespace App\Http\Controllers\Admin;

use App\Models\Concern;
use App\Presenters\CommonPresenter;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\ConcernStore;
use App\Presenters\ConcernPresenter;
use App\Transformers\ConcernTransformer;
use App\Http\Controllers\Traits\ConcernFiltration;
use Illuminate\View\View;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Spatie\MediaLibrary\Exceptions\FileCannotBeAdded\DiskDoesNotExist;
use Spatie\MediaLibrary\Exceptions\FileCannotBeAdded\FileDoesNotExist;
use Spatie\MediaLibrary\Exceptions\FileCannotBeAdded\FileIsTooBig;

/**
 * @group ManagerConcern
 */
class ManagerConcernController extends Controller
{
    use ConcernFiltration;

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
        $concerns = Concern::query();
        if ($this->filterQueryStrings()) {
            $concerns = $this->filterData($request, $concerns);
        }

        return view('pages.concerns.manager.index', [
            'concerns' => $concerns->get(),
            'breadcrumb' => $this->breadcrumb([], 'Concerns')
        ]);
    }

    /**
     * create.
     */
    public function create()
    {
        return view('pages.concerns.manager.add', [
            'breadcrumb' => $this->breadcrumb([
                [
                    'title' => 'Concerns',
                    'route' => route('concern.admin.index')
                ]
            ], 'Add New Concern'),
        ]);
    }

    /**
     * store.
     *
     * @param ConcernStore $request
     * @return JsonResponse|RedirectResponse|Redirector
     */
    public function store(ConcernStore $request)
    {
        $data = $request->except('badge', 'badge_alt', 'banner', 'banner_alt');
        $data['slug'] = $request->slug ?: $request->name;
        $concern = Concern::create($data);
        if ($badge = $request->badge) {
            $concern->addHashedMedia($badge, null, ['alt' => $request->badge_alt])->toMediaCollection('badge');
        }
        if ($banner = $request->banner) {
            $concern->addHashedMedia($banner, null, ['alt' => $request->banner_alt])->toMediaCollection('banner');
        }
        return $this->returnCrudData(__('system_messages.common.create_success'), route('concern.admin.index'));
    }

    /**
     * edit.
     *
     * @param mixed $concern
     * @return Factory|View
     */
    public function edit(Concern $concern)
    {
        return view('pages.concerns.manager.edit', [
            'concern' => $concern,
            'breadcrumb' => $this->breadcrumb([
                [
                    'title' => 'Concerns',
                    'route' => route('concern.admin.index')
                ]
            ], 'Edit Concern'),
        ]);
    }

    /**
     * update.
     *
     * @param mixed $concern
     * @param ConcernStore $request
     * @return JsonResponse|RedirectResponse|Redirector
     * @throws DiskDoesNotExist
     * @throws FileDoesNotExist
     * @throws FileIsTooBig
     */
    public function update(Concern $concern, ConcernStore $request)
    {
        $concern->update($request->except('redirect_to', 'badge', 'badge_alt', 'banner', 'banner_alt'));
        if ($badge = $request->badge) {
            $concern->addHashedMedia($badge, null, ['alt' => $request->badge_alt])->toMediaCollection('badge');
        }
        if ($banner = $request->banner) {
            $concern->addHashedMedia($banner, null, ['alt' => $request->banner_alt])->toMediaCollection('banner');
        }
        return $this->returnCrudData(__('system_messages.common.update_success'), $request->redirect_to);
    }

    /**
     * delete.
     *
     * @param Concern $concern
     * @param Request $request
     * @return JsonResponse|RedirectResponse|Redirector
     * @throws Exception
     */
    public function destroy(Concern $concern, Request $request)
    {
        $concern->delete();
        return $this->returnCrudData(__('system_messages.common.delete_success'), $request->redirect_to ?: url()->previous());
    }
}
