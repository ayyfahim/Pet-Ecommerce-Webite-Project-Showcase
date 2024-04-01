<?php

namespace App\Http\Controllers\Auth\Web;

use App\Http\Controllers\Traits\Auth\VerifiesEmails;
use App\Notifications\SendNotification;
use App\User;
use Illuminate\Http\Request;
use App\Http\Requests\UserStore;
use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Verified;
use App\Notifications\SendMobileVerificationCodeSms;
use Illuminate\Support\Facades\URL;

class VerificationController extends Controller
{
    /* |-------------------------------------------------------------------------- | Email Verification Controller |-------------------------------------------------------------------------- | | This controller is responsible for handling email verification for any | user that recently registered with the application. Emails may also | be re-sent if the user didn't receive the original email message. |
    */

    use VerifiesEmails;

    /**
     * Where to redirect users after verification.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth')->except(['verify']);
        $this->middleware('signed')->only('verify');
        $this->middleware('throttle:6,1')->only(['verify', 'resend']);
    }

    /**
     * show.
     *
     * Show the email verification notice.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show()
    {
        $user = auth()->user();
        return view('auth.verify')->with([
            'user' => $user,
            'breadcrumb' => $this->breadcrumb([], __('auth.account_verification'))
        ]);
    }

    /**
     * verify email.
     *
     * Mark the authenticated user's email address as verified.
     *
     * @param mixed $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function verify(User $id)
    {
        if (!$id->hasVerifiedEmail()) {
            if ($id->markEmailAsVerified()) {
                event(new Verified($id));
            }
        }
        return redirect()->to(config('app.frontend_edit_url'));
    }

    /**
     * resend email verification code.
     *
     * Resend the email verification notification.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function resend()
    {
        $user = auth()->user();
        if ($user->hasVerifiedEmail()) {
            flash()->error(__('system_messages.auth.verification.email_already_verified'));
        } else {
            $user->sendEmailVerificationNotification();

            flash()->success(__('system_messages.auth.verification.email_sent'));
        }

        return back();
    }

    /**
     * verify mobile.
     *
     * User Verify His Mobile.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
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
        if (!$user) {
            return $this->returnCrudData(__('system_messages.auth.verification.mobile_verified_failed'), null, 'error');
        }
        $user->markMobileAsVerified();
        return $this->returnCrudData(__('system_messages.auth.verification.mobile_verified'), route($this->getRedirectUrl($user)));
    }

    /**
     * resend mobile verification code.
     *
     * Resend Mobile Verification Message
     * Save Current Mobile Number and send
     * Mobile Verification Message.
     *
     * @param mixed $id
     * @param UserStore $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function resendMobileVerificationCode(User $id, UserStore $request)
    {
        if ($id->hasVerifiedMobile()) {
            return $this->returnCrudData(__('system_messages.auth.verification.mobile_already_verified'), null, 'error');
        }

        $id->update([
            'mobile' => $request->mobile,
            'mobile_verification_token' => app(User::class)->getRandomNumber(),
        ]);

        new SendNotification('mobile_verification', $id, null, null, [
            'code' => $id->mobile_verification_token
        ]);

        return $this->returnCrudData(__('system_messages.auth.verification.mobile_code_sent'));
    }

    private function getRedirectUrl($user)
    {
        $url = 'verification.notice';
        return $url;
    }
}
