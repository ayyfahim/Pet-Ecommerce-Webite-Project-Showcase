<?php

namespace App\Http\Controllers\Auth\Web;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\Auth\AuthenticatesUsers;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Handle a login request to the application.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Symfony\Component\HttpFoundation\Response|void
     * @throws \Illuminate\Validation\ValidationException
     */
    public function login(Request $request)
    {
        $this->validateLogin($request);
        $user = User::where('email', $request->email)->first();
        if ($user && ($user->status->order == 2)) {
            return $this->returnCrudData(__('system_messages.auth.inactive'), null, 'error');
        }

        // add if user soft delete

        if ($user && $user->deleted_at != null) {
            return $this->sendFailedLoginResponse($request);
        }

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if (method_exists($this, 'hasTooManyLoginAttempts') &&
            $this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        if ($this->attemptLogin($request)) {
            return $this->sendLoginResponse($request);
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }

    /**
     * Show the application's login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm()
    {
        dd(1);
        return view('auth.login', [
            'breadcrumb' => $this->breadcrumb([], __('auth.login'), 0),
        ]);
    }

    /**
     * Show the admin's login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showAdminLoginForm()
    {
        return view('auth.admin_login', [
            'breadcrumb' => $this->breadcrumb([], __('auth.login'), 0),
        ]);
    }

    /**
     * Validate the user login request.
     *
     * @param \Illuminate\Http\Request $request
     * @return void
     *
     */
    protected function validateLogin(Request $request)
    {
        $request->validate([
            $this->username() => 'required|email',
            'password' => 'required|string',
        ]);
    }

    /**
     * The user has been authenticated.
     *
     * @param \Illuminate\Http\Request $request
     * @param mixed $user
     *
     * @return mixed
     */
    protected function authenticated(Request $request, $user)
    {
        if ($request->expectsJson()) {
            return response()->json(['reload' => true]);
        }
        return redirect()->intended(url()->previous());
    }

    /**
     * Get the failed login response instance.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     *
     */
    protected function sendFailedLoginResponse(Request $request)
    {
        return $this->returnCrudData(__('system_messages.auth.failed'), null, 'error');
    }

    /**
     * Send the response after the user was authenticated.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    protected function sendLoginResponse(Request $request)
    {
        $request->session()->regenerate();

        $this->clearLoginAttempts($request);
        $url = URL::previous();
        $authUser = auth()->user();
        if ($authUser) {
            $authUser->update(['last_login' => now()]);
        }
        if($authUser->hasManagerAccess())
        {
            $url = route('admin.dashboard');
        }
        return $this->returnCrudData(__('system_messages.auth.success'), $url);
    }

    /**
     * The user has logged out of the application.
     *
     * @param \Illuminate\Http\Request $request
     * @return mixed
     */
    protected function loggedOut(Request $request)
    {
        if ($request->redirect_to) {
            return Redirect::to($request->redirect_to);
        }
    }

}
