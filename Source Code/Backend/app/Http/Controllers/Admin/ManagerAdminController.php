<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Traits\User\Filtration;
use App\Models\Role;
use App\User;
use App\Presenters\CommonPresenter;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserStore;
use Illuminate\View\View;

class ManagerAdminController extends Controller
{
    use Filtration;

    public function __construct()
    {
//        $this->middleware(['auth', 'manager_access']);
    }

    /**
     * index.
     *
     * @queryParam q search in name
     */
    public function index(Request $request)
    {
        $users = User::whereHas('roles', function ($query) {
            $query->where('name', '!=', 'customer');
        });
        $config = User::getStatusFor();

        if ($this->filterQueryStrings()) {
            $users = $this->filterData($request, $users);
        }

        return view('pages.admins.manager.index', [
            'users' => app(CommonPresenter::class)->paginate($users->get()),
            'status' => $config['status'],
            'breadcrumb' => $this->breadcrumb([], 'Users')
        ]);
    }

    /**
     * create.
     */
    public function create()
    {
        $config = User::getStatusFor();
        return view('pages.admins.manager.add', [
            'roles' => Role::where('name', '!=', 'customer')->get(),
            'active_status' => $config['status']->firstWhere('order', 1)->id,
            'inactive_status' => $config['status']->firstWhere('order', 2)->id,
            'breadcrumb' => $this->breadcrumb([
                [
                    'title' => 'Users',
                    'route' => route('management.admin.user.index')
                ]
            ], 'Add New User'),
        ]);
    }

    /**
     * store.
     *
     * @param UserStore $request
     * @return JsonResponse|RedirectResponse|Redirector
     */
    public function store(UserStore $request)
    {
        $user = User::create($request->except('role_id'));
        $user->attachRole($request->role_id);
        return $this->returnCrudData(__('system_messages.common.create_success'), route('management.admin.user.index'));
    }

    /**
     * edit.
     *
     * @param mixed $user
     * @return Factory|View
     */
    public function edit(User $user)
    {
        $config = User::getStatusFor();
        return view('pages.admins.manager.edit', [
            'user' => $user,
            'roles' => Role::where('name', '!=', 'customer')->get(),
            'active_status' => $config['status']->firstWhere('order', 1)->id,
            'inactive_status' => $config['status']->firstWhere('order', 2)->id,
            'breadcrumb' => $this->breadcrumb([
                [
                    'title' => 'Users',
                    'route' => route('management.admin.user.index')
                ]
            ], 'Edit User'),
        ]);
    }

    /**
     * update.
     *
     * @param mixed $user
     * @param UserStore $request
     * @return JsonResponse|RedirectResponse|Redirector
     */
    public function update(User $user, UserStore $request)
    {
        $user->update($request->except('redirect_to', 'role_id'));
        $user->detachRoles();
        $user->attachRole($request->role_id);
        return $this->returnCrudData(__('system_messages.common.update_success'), $request->redirect_to);
    }

    /**
     * delete.
     *
     * @param User $user
     * @param Request $request
     * @return JsonResponse|RedirectResponse|Redirector
     * @throws Exception
     */
    public function destroy(User $user, Request $request)
    {
        $user->delete();
        return $this->returnCrudData(__('system_messages.common.delete_success'), $request->redirect_to ?: url()->previous());
    }
}
