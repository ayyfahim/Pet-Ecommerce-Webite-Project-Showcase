<?php

namespace App\Http\Controllers\Admin;

use App\Exports\CategoryExport;
use App\Http\Controllers\Traits\Product\Attributes;
use App\Http\Controllers\Traits\Product\GoogleSheets;
use App\Models\Attribute;
use App\Models\Category;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryStore;
use App\Presenters\CommonPresenter;
use App\Transformers\CategoryTransformer;
use App\Http\Controllers\Traits\CategoryFiltration;
use Illuminate\View\View;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Spatie\MediaLibrary\Exceptions\FileCannotBeAdded\DiskDoesNotExist;
use Spatie\MediaLibrary\Exceptions\FileCannotBeAdded\FileDoesNotExist;
use Spatie\MediaLibrary\Exceptions\FileCannotBeAdded\FileIsTooBig;
use Maatwebsite\Excel\Facades\Excel;


/**
 * @group ManagerCategory
 */
class ManagerCategoryController extends Controller
{
    use CategoryFiltration, Attributes;

    public function __construct()
    {
    }

    /**
     * index.
     *
     * @queryParam q search in name
     */
    public function index(Request $request)
    {
        $config = Category::getStatusFor();

        $categories = app(CommonPresenter::class)->paginate($this->getCategories($request), 'name', 'asc',100);

        if ($request->expectsJson()) {
            return $this->returnPaginatedApiData($categories, new CategoryTransformer());
        }

        return view('pages.categories.manager.index', [
            'categories' => $categories,
            'status' => $config['status'],
            'breadcrumb' => $this->breadcrumb([], 'Categories')
        ]);
    }

    public function getCategories(Request $request)
    {
        $categories = Category::query();
        if ($this->filterQueryStrings()) {
            $categories = $this->filterData($request, $categories);
        }
        return $categories->get()->toTree();
    }

    public function export(Request $request)
    {
        return Excel::download(new CategoryExport($this->getCategories($request)), "Categories " . today()->format('d-m-Y') . ".csv");
    }

    /**
     * create.
     */
    public function create()
    {
        $config = Category::getStatusFor();
        return view('pages.categories.manager.add', [
            'parents' => $this->parentCategories(),
            'breadcrumb' => $this->breadcrumb([
                [
                    'title' => 'Categories',
                    'route' => route('category.admin.index')
                ]
            ], 'Add New Category'),
            'categories' => $this->parentCategories(),
            'status' => $config['status'],
            'attributes' => Attribute::isActive()->where('category', true)->get()->sortBy('name'),
            'active_status' => $config['status']->firstWhere('order', 1)->id,
            'inactive_status' => $config['status']->firstWhere('order', 2)->id,
        ]);
    }

    /**
     * store.
     *
     * @param CategoryStore $request
     * @return JsonResponse|RedirectResponse|Redirector
     * @throws \Throwable
     */
    public function store(CategoryStore $request)
    {
        DB::transaction(function () use ($request) {
            $data = $request->except('badge', 'icon', 'icon_alt', 'badge_alt', 'attributes', 'options_to_delete');
            $data['slug'] = $request->slug ?: $request->name;
            if ($data['parent_id'] == 'parent') {
                $data['parent_id'] = null;
            }
            $category = Category::create($data);
            if ($badge = $request->badge) {
                $category->addHashedMedia($badge, null, ['alt' => $request->badge_alt])->toMediaCollection('badge');
            }
            if ($icon = $request->icon) {
                $category->addHashedMedia($icon, null, ['alt' => $request->icon_alt])->toMediaCollection('icon');
            }
//            $this->setAttributes($request->input('attributes'), $category, $request->options_to_delete);
        });
        return $this->returnCrudData(__('system_messages.common.create_success'), route('category.admin.index'));
    }

    /**
     * edit.
     *
     * @param mixed $category
     * @return Factory|View
     */
    public function edit(Category $category)
    {
        $config = Category::getStatusFor();
        return view('pages.categories.manager.edit', [
            'category' => $category,
            'parents' => $this->parentCategories(),
            'breadcrumb' => $this->breadcrumb([
                [
                    'title' => 'Categories',
                    'route' => route('category.admin.index')
                ]
            ], 'Edit Category'),
            'categories' => $this->parentCategories(),
            'status' => $config['status'],
            'attributes' => Attribute::isActive()->where('category', true)->get()->sortBy('name'),
            'active_status' => $config['status']->firstWhere('order', 1)->id,
            'inactive_status' => $config['status']->firstWhere('order', 2)->id,
        ]);
    }

    /**
     * update.
     *
     * @param mixed $category
     * @param CategoryStore $request
     * @return JsonResponse|RedirectResponse|Redirector
     * @throws \Throwable
     */
    public function update(Category $category, CategoryStore $request)
    {
        DB::transaction(function () use ($request, $category) {
            $data = $request->except('redirect_to', 'badge', 'icon', 'icon_alt', 'badge_alt', 'attributes', 'options_to_delete');
            if ($data['parent_id'] == 'parent') {
                $data['parent_id'] = null;
            }
            $category->update($data);
            if ($badge = $request->badge) {
                $category->addHashedMedia($badge, null, ['alt' => $request->badge_alt])->toMediaCollection('badge');
            }
            if ($icon = $request->icon) {
                $category->addHashedMedia($icon, null, ['alt' => $request->icon_alt])->toMediaCollection('icon');
            }
//            $this->setAttributes($request->input('attributes'), $category, $request->options_to_delete);
        });
        return $this->returnCrudData(__('system_messages.common.update_success'), $request->redirect_to);
    }

    /**
     * delete.
     *
     * @param Category $category
     * @param Request $request
     * @return JsonResponse|RedirectResponse|Redirector
     * @throws Exception
     */
    public function destroy(Category $category, Request $request)
    {
        $category->delete();

        return $this->returnCrudData(__('system_messages.common.delete_success'), $request->redirect_to ?: url()->previous());
    }

    private function parentCategories()
    {
        return Category::where(function ($query) {
            $query->where(function ($query) {
                $query->doesnthave('parent');
                $query->orWhereHas('children', function ($query) {
                    $query->doesnthave('children');
                    $query->orWhereHas('children', function ($query) {
                        $query->doesnthave('children');
                    });
                });
            });
            $query->orWhere(function ($query) {
                $query->doesnthave('children');
                $query->whereHas('parent', function ($query) {
                    $query->doesnthave('parent');
                    $query->orWhereHas('parent', function ($query) {
                        $query->doesnthave('parent');
                    });
                });
            });
        })->get()->sortBy('name');
    }

}
