<?php

namespace App\Http\Controllers\Auth\Api;

use App\Http\Controllers\Traits\Auth\ResetsPasswords;
use App\Http\Requests\UserAuth;
use App\Http\Controllers\Controller;
use App\Transformers\UserTransformer;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

/**
 * @group Auth
 */
class ResetPasswordController extends Controller
{
    use ResetsPasswords;

    protected $authUser;

    protected function rules()
    {
        return (new UserAuth())->passwordResetRules();
    }

    /**
     * Reset the given user's password.
     * @bodyParam token string
     * @bodyParam email string
     * @bodyParam password string required
     * @bodyParam password_confirmation string required
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function reset(Request $request)
    {
        $request->validate($this->rules(), $this->validationErrorMessages());
        // Here we will attempt to reset the user's password. If it is successful we
        // will update the password on an actual user model and persist it to the
        // database. Otherwise we will parse the error and return the response.

        $response = $this->broker()->reset(
            $this->credentials($request), function ($user, $password) {
            $this->resetPassword($user, $password);
        }
        );
        // If the password was successfully reset, we will redirect the user back to
        // the application's home authenticated view. If there is an error we can
        // redirect them back to where they came from with their error message.
        return $response == Password::PASSWORD_RESET
            ? $this->sendResetResponse($request, $response)
            : $this->sendResetFailedResponse($request, $response);
    }

    /**
     * Reset the given user's password.
     *
     * @param \Illuminate\Contracts\Auth\CanResetPassword $user
     * @param string $password
     */
    protected function resetPassword($user, $password)
    {
        $user->password = $password;
        $user->save();

        $this->authUser = $user;

        event(new PasswordReset($user));
    }

    /**
     * Get the response for a successful password reset.
     *
     * @param \Illuminate\Http\Request $request
     * @param string $response
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    protected function sendResetResponse($request, $response)
    {
        $user = $this->authUser;
        $token = auth()->fromUser($user);
        $response = str_replace("passwords.", "forgot_password.", $response);

        return $this->returnCrudData(trans("system_messages.auth." . $response), null, 'success', [
            'user' => fractal($user, new UserTransformer())->toArray()['data'],
            'token' => $token,
        ]);
    }

    /**
     * Get the response for a failed password reset.
     *
     * @param \Illuminate\Http\Request $request
     * @param string $response
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    protected function sendResetFailedResponse($request, $response)
    {
        return $this->returnCrudData(__($response), null, 'error');
    }
}
