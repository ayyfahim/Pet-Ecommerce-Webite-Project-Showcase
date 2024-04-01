<?php

namespace App\Http\Controllers;

use App\Presenters\CommonPresenter;
use App\Transformers\NotificationTransformer;
use App\Transformers\UserTransformer;
use App\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\UserStore;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Illuminate\View\View;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

/**
 * @group User
 */
class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth'])->except(['show', 'reviews']);
//        $this->middleware(['auth', 'confirmUserVerification'])->except(['show', 'reviews']);
    }

    /**
     * edit.
     *
     * @param int $id
     * @return Factory|View
     */
    public function edit()
    {
        $auth = auth()->user();

        return view('pages.user.profile.edit', [
            'user' => $auth,
            'locales' => LaravelLocalization::getSupportedLocales(),
        ]);
    }

    /**
     * update.
     * @bodyParam first_name string required for customer only
     * @bodyParam last_name string required for customer only
     * @bodyParam email string required
     * @bodyParam country_code string required for mobileApp only
     * @bodyParam mobile string required
     * @bodyParam current_password string required
     * @bodyParam password string required
     * @bodyParam password_confirmation string required
     * @bodyParam locale string [en/ar] required
     *
     * @param User $user
     * @param UserStore $request
     * @return JsonResponse|RedirectResponse|Redirector
     */
    public function update(User $user, UserStore $request)
    {
        $auth = auth()->user();
        if (!$auth->can('edit_customers') && $user->id != $auth->id) {
            abort(403, 'This action is unauthorized.');
        }
        $user = $user ?: $auth;
        $ignore = ['avatar', 'current_password'];
        $data = $request->except($ignore);
        if ($request->email && $request->email != $user->email) {
            if ($user->hasVerifiedEmail()) {
                $data['email_verified_at'] = null;
            }
        }
        $user->update($data);
        $url = null;
        if (app('router')->getRoutes()->match(app('request')->create(url()->previous()))->getName() == 'user.admin.index')
            $url = url()->previous();
        return $this->returnCrudData(__('system_messages.common.update_success'), $url, 'success', [
            'user' => fractal($auth->fresh(), new UserTransformer())->toArray()['data']
        ]);
    }
}
