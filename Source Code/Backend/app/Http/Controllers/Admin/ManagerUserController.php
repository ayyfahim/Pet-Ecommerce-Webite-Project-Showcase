<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Auth\Api\ForgetPasswordController;
use App\Http\Controllers\Traits\User\Filtration;
use App\Models\Product;
use App\Presenters\CommonPresenter;
use App\User;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Presenters\UserPresenter;
use Illuminate\Routing\Redirector;
use Illuminate\View\View;
use Zizaco\Entrust\EntrustRole as Role;

/**
 * @group ManagerUser
 */
class ManagerUserController extends Controller
{
    use Filtration;

    public function __construct()
    {
        $this->middleware(['auth', 'manager_access']);
    }

    /**
     * index.
     *
     * @param Request $request
     * @return Factory|View
     */
    public function index(Request $request)
    {
        $users = User::withRole('customer');
        $config = User::getStatusFor();

        if ($this->filterQueryStrings()) {
            $users = $this->filterData($request, $users);
        } else {
            $users->where('status_id', $config['status']->firstWhere('order', 1)->id);
        }

        return view('pages.users.manager.index', [
            'users' => app(CommonPresenter::class)->paginate($users->get()),
            'status' => $config['status'],
            'breadcrumb' => $this->breadcrumb([], 'Customers')
        ]);
    }

    /**
     * edit.
     *
     * @param User $user
     * @return Factory|View
     */
    public function edit(User $user)
    {
        $config = User::getStatusFor();
        return view('pages.users.manager.edit', [
            'breadcrumb' => $this->breadcrumb([
                [
                    'route' => route('user.admin.index'),
                    'title' => "Customers"
                ]
            ], 'Edit Customer'),
            'user' => $user,
            'active_status' => $config['status']->firstWhere('order', 1)->id,
            'inactive_status' => $config['status']->firstWhere('order', 2)->id,
        ]);
    }

    /**
     * delete.
     *
     * @param User $user
     * @param Request $request
     * @return JsonResponse|RedirectResponse|Redirector
     */
    public function destroy(User $user, Request $request)
    {
        $user->delete();
        return $this->returnCrudData(__('system_messages.common.delete_success'), $request->redirect_to ?: url()->previous());
    }

    public function reset_password(Request $request)
    {
        $resetPasswordController = new ForgetPasswordController();
        return $resetPasswordController->sendResetLinkEmail($request);
    }
}
