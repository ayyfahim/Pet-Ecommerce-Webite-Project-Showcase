<?php

namespace App\Http\Controllers\Auth\Api;

use App\Notifications\SendNotification;
use App\User;
use Illuminate\Http\Request;
use App\Http\Requests\UserStore;
use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Verified;
use App\Notifications\SendMobileVerificationCodeSms;

/**
 * @group Auth
 */
class VerificationController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth')->except('verify');
//        $this->middleware('throttle:6,1');
    }

    /**
     * verify email.
     *
     * Mark the authenticated user's email address as verified.
     *
     * @param mixed $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function verify($id)
    {
        $user = User::whereId($id)->first();
        if (!$user) {
            abort(404);
        }
        if ($user->hasVerifiedEmail()) {
            return $this->returnCrudData(__('system_messages.auth.verification.email_already_verified'), null, 'error');
        }

        if ($user->markEmailAsVerified()) {
            event(new Verified($user));
        }
        return $this->returnCrudData(__('system_messages.auth.verification.email_verified'), sizeof($user->activeCart->basket) ? route('cart.index') : null);
    }

    /**
     * resend email verification code.
     *
     * Resend the email verification notification.
     *
     * @param \Illuminate\Http\Request $request
     */
    public function resend()
    {
        $user = auth()->user();

        if ($user->hasVerifiedEmail()) {
            return $this->returnCrudData(__('system_messages.auth.verification.email_already_verified'), null, 'error');
        }

        $user->sendEmailVerificationNotification();
        return $this->returnCrudData(__('system_messages.auth.verification.email_sent'));
    }

    /**
     * verify mobile.
     *
     * User Verify His Mobile.
     *
     * @bodyParam mobile_verification_token string
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Illuminate\Validation\ValidationException
     */
    public function verifyMobile(Request $request)
    {
        $this->validate($request, [
            'mobile_verification_token' => 'required',
        ]);
        $user = User::where([
            'id' => auth()->user()->getKey(),
            'mobile_verification_token' => $request->mobile_verification_token,
        ])->first();
        if ($user) {
            $user->markMobileAsVerified();
            return $this->returnCrudData(__('system_messages.auth.verification.mobile_verified'));
        } else {
            return $this->returnCrudData(__('system_messages.auth.verification.invalid_code'), null, 'error');
        }
    }

    /**
     * resend mobile verification code.
     *
     * Resend Mobile Verification Message
     * Save Current Mobile Number and send
     * Mobile Verification Message.
     *
     * @bodyParam country_code string
     * @bodyParam mobile string
     *
     * @param UserStore $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function resendMobileVerificationCode(UserStore $request)
    {
        $user = auth()->user();
        if ($user->hasVerifiedMobile()) {

            return $this->returnCrudData(__('system_messages.auth.verification.mobile_already_verified'), null, 'error');
        }
        $data['mobile_verification_token'] = app(User::class)->getRandomNumber();
        if ($request->mobile) {
            $data['mobile'] = $request->mobile;
        }
        if ($request->country_code) {
            $data['country_code'] = $request->country_code;
        }
        $user->update($data);
        new SendNotification('mobile_verification', $user, [
            'code' => $user->mobile_verification_token
        ]);
        return $this->returnCrudData(__('system_messages.auth.verification.verification_code_sent'));
    }
}
