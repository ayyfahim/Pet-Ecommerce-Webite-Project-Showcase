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
use App\Http\Requests\PetTypeRequest;
use App\Models\PetType;
use Illuminate\View\View;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Spatie\MediaLibrary\Exceptions\FileCannotBeAdded\DiskDoesNotExist;
use Spatie\MediaLibrary\Exceptions\FileCannotBeAdded\FileDoesNotExist;
use Spatie\MediaLibrary\Exceptions\FileCannotBeAdded\FileIsTooBig;

/**
 * @group ManagerBreed
 */
class ManagerPetTypeController extends Controller
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
        $breeds = PetType::query();
        if ($this->filterQueryStrings()) {
            $breeds = $this->filterData($request, $breeds);
        }

        return view('pages.pet_types.manager.index', [
            'breeds' => $breeds->get(),
            'breadcrumb' => $this->breadcrumb([], 'Pet Types')
        ]);
    }

    /**
     * create.
     */
    public function create()
    {
        return view('pages.pet_types.manager.add', [
            'animals' => Breed::$animals,
            'breadcrumb' => $this->breadcrumb([
                [
                    'title' => 'Pet Type',
                    'route' => route('petType.admin.index')
                ]
            ], 'Add New Pet Type'),
        ]);
    }

    /**
     * store.
     *
     * @param PetTypeRequest $request
     * @return JsonResponse|RedirectResponse|Redirector
     */
    public function store(PetTypeRequest $request)
    {
        $data = $request->except('badge', 'badge_alt', 'banner', 'banner_alt');
        $data['slug'] = $request->slug ?: $request->name;
        $breed = PetType::create($data);
        if ($badge = $request->badge) {
            $breed->addHashedMedia($badge, null, ['alt' => $request->badge_alt])->toMediaCollection('badge');
        }
        if ($banner = $request->banner) {
            $breed->addHashedMedia($banner, null, ['alt' => $request->banner_alt])->toMediaCollection('banner');
        }
        return $this->returnCrudData(__('system_messages.common.create_success'), route('petType.admin.index'));
    }

    /**
     * edit.
     *
     * @param mixed $breed
     * @return Factory|View
     */
    public function edit(PetType $breed)
    {
        return view('pages.pet_types.manager.edit', [
            'animals' => Breed::$animals,
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
     * @param PetTypeRequest $request
     * @return JsonResponse|RedirectResponse|Redirector
     * @throws DiskDoesNotExist
     * @throws FileDoesNotExist
     * @throws FileIsTooBig
     */
    public function update(PetType $breed, PetTypeRequest $request)
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
    public function destroy(PetType $breed, Request $request)
    {
        $breed->delete();
        return $this->returnCrudData(__('system_messages.common.delete_success'), $request->redirect_to ?: url()->previous());
    }
}
