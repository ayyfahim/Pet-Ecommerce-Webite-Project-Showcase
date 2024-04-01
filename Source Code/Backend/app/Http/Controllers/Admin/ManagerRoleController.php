<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Traits\Role\Filtration;
use App\Models\Permission;
use App\Models\Role;
use App\Presenters\CommonPresenter;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use App\Http\Controllers\Controller;
use App\Http\Requests\RoleRequest;
use Illuminate\View\View;

/**
 * @group ManagerRole
 */
class ManagerRoleController extends Controller
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
        $roles = Role::whereNotIn('name', ['customer']);
        if ($this->filterQueryStrings()) {
            $roles = $this->filterData($request, $roles);
        }
        $roles = app(CommonPresenter::class)->paginate($roles->get(),null,'asc');
        return view('pages.roles.manager.index', [
            'roles' => $roles,
            'breadcrumb' => $this->breadcrumb([], 'Roles')
        ]);
    }

    /**
     * create.
     */
    public function create()
    {
        return view('pages.roles.manager.add', [
            'permissions' => Permission::get()->groupBy('group'),
            'breadcrumb' => $this->breadcrumb([
                [
                    'title' => 'Roles',
                    'route' => route('management.admin.role.index')
                ]
            ], 'Add New Role'),
        ]);
    }

    /**
     * store.
     *
     * @param RoleRequest $request
     * @return JsonResponse|RedirectResponse|Redirector
     */
    public function store(RoleRequest $request)
    {
        $data = $request->except('permissions','_token');
        $data['name'] = slugfy($request->display_name,'_');
        $role = Role::create($data);
        $role->perms()->sync($request->permissions);
        return $this->returnCrudData(__('system_messages.common.create_success'), route('management.admin.role.index'));
    }

    /**
     * edit.
     *
     * @param mixed $role
     * @return Factory|View
     */
    public function edit(Role $role)
    {
        return view('pages.roles.manager.edit', [
            'role' => $role,
            'permissions' => Permission::get()->groupBy('group'),
            'breadcrumb' => $this->breadcrumb([
                [
                    'title' => 'Roles',
                    'route' => route('management.admin.role.index')
                ]
            ], 'Edit Role'),
        ]);
    }

    /**
     * update.
     *
     * @param mixed $role
     * @param RoleRequest $request
     * @return JsonResponse|RedirectResponse|Redirector
     */
    public function update(Role $role, RoleRequest $request)
    {
        $data = $request->except('redirect_to','permissions','_token');
        $data['name'] = slugfy($request->display_name,'_');
        $role->update($data);
        $role->perms()->sync($request->permissions);
        return $this->returnCrudData(__('system_messages.common.update_success'), $request->redirect_to);
    }

    /**
     * delete.
     *
     * @param Role $role
     * @param Request $request
     * @return JsonResponse|RedirectResponse|Redirector
     * @throws Exception
     */
    public function destroy(Role $role, Request $request)
    {
        $role->delete();
        return $this->returnCrudData(__('system_messages.common.delete_success'), $request->redirect_to ?: url()->previous());
    }
}
