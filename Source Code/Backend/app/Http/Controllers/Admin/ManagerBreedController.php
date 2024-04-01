<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Traits\Breed\Filtration;
use App\Models\Breed;
use App\Presenters\CommonPresenter;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\BreedRequest;
use App\Presenters\BreedPresenter;
use App\Transformers\BreedTransformer;
use App\Http\Controllers\Traits\BreedFiltration;
use App\Models\PetType;
use Illuminate\View\View;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Spatie\MediaLibrary\Exceptions\FileCannotBeAdded\DiskDoesNotExist;
use Spatie\MediaLibrary\Exceptions\FileCannotBeAdded\FileDoesNotExist;
use Spatie\MediaLibrary\Exceptions\FileCannotBeAdded\FileIsTooBig;

/**
 * @group ManagerBreed
 */
class ManagerBreedController extends Controller
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
        $breeds = Breed::query();
        if ($this->filterQueryStrings()) {
            $breeds = $this->filterData($request, $breeds);
        }

        return view('pages.breeds.manager.index', [
            'breeds' => $breeds->get(),
            'breadcrumb' => $this->breadcrumb([], 'Breeds')
        ]);
    }

    /**
     * create.
     */
    public function create()
    {
        // dd(PetType::select('name')->get()->toArray()[0]);
        return view('pages.breeds.manager.add', [
            'animals' => PetType::pluck('name')->toArray(),
            'pet_types' => PetType::get(),
            'breadcrumb' => $this->breadcrumb([
                [
                    'title' => 'Breeds',
                    'route' => route('breed.admin.index')
                ]
            ], 'Add New Breed'),
        ]);
    }

    /**
     * store.
     *
     * @param BreedRequest $request
     * @return JsonResponse|RedirectResponse|Redirector
     */
    public function store(BreedRequest $request)
    {
        $data = $request->except('badge', 'badge_alt', 'banner', 'banner_alt');
        $data['slug'] = $request->slug ?: $request->name;
        $breed = Breed::create($data);
        if ($badge = $request->badge) {
            $breed->addHashedMedia($badge, null, ['alt' => $request->badge_alt])->toMediaCollection('badge');
        }
        if ($banner = $request->banner) {
            $breed->addHashedMedia($banner, null, ['alt' => $request->banner_alt])->toMediaCollection('banner');
        }
        return $this->returnCrudData(__('system_messages.common.create_success'), route('breed.admin.index'));
    }

    /**
     * edit.
     *
     * @param mixed $breed
     * @return Factory|View
     */
    public function edit(Breed $breed)
    {
        return view('pages.breeds.manager.edit', [
            'animals' => PetType::pluck('name')->toArray(),
            'pet_types' => PetType::get(),
            'breed' => $breed,
            'breadcrumb' => $this->breadcrumb([
                [
                    'title' => 'Breeds',
                    'route' => route('breed.admin.index')
                ]
            ], 'Edit Breed'),
        ]);
    }

    /**
     * update.
     *
     * @param mixed $breed
     * @param BreedRequest $request
     * @return JsonResponse|RedirectResponse|Redirector
     * @throws DiskDoesNotExist
     * @throws FileDoesNotExist
     * @throws FileIsTooBig
     */
    public function update(Breed $breed, BreedRequest $request)
    {
        $breed->update($request->except('redirect_to', 'badge', 'badge_alt', 'banner', 'banner_alt'));
        if ($badge = $request->badge) {
            $breed->addHashedMedia($badge, null, ['alt' => $request->badge_alt])->toMediaCollection('badge');
        }
        if ($banner = $request->banner) {
            $breed->addHashedMedia($banner, null, ['alt' => $request->banner_alt])->toMediaCollection('banner');
        }
        return $this->returnCrudData(__('system_messages.common.update_success'), $request->redirect_to);
    }

    /**
     * delete.
     *
     * @param Breed $breed
     * @param Request $request
     * @return JsonResponse|RedirectResponse|Redirector
     * @throws Exception
     */
    public function destroy(Breed $breed, Request $request)
    {
        $breed->delete();
        return $this->returnCrudData(__('system_messages.common.delete_success'), $request->redirect_to ?: url()->previous());
    }
}
