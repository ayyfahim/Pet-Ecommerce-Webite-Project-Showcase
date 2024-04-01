<?php

namespace App\Http\Controllers\Auth\Web;

use App\Http\Controllers\Traits\Auth\ResetsPasswords;
use App\Http\Requests\UserAuth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Display the password reset view for the given token.
     *
     * If no token is present, display the link request form.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  string|null $token
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showResetForm(Request $request, $token = null)
    {
        return view('auth.passwords.reset', [
            'breadcrumb' => $this->breadcrumb([], __('auth.reset_password'), false)
        ])->with(
            ['token' => $token, 'email' => $request->email]
        );
    }

    /**
     * Get the response for a successful password reset.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  string $response
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    protected function sendResetResponse(Request $request, $response)
    {
        $response = str_replace("passwords.", "forgot_password.", $response);
        return $this->returnCrudData(trans("system_messages.auth." . $response), route('home'));
    }

    /**
     * Get the response for a failed password reset.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  string $response
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    protected function sendResetFailedResponse(Request $request, $response)
    {
        $response = str_replace("passwords.", "forgot_password.", $response);
        return $this->returnCrudData(trans("system_messages.auth." . $response), null, 'error');
    }

    protected function rules()
    {
        return (new UserAuth())->passwordResetRules();
    }
}
