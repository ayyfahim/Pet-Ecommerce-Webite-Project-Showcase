<?php

namespace App\Http\Controllers\Auth\Web;

use App\User;
use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;

class SocialLoginController extends Controller
{
    protected $statless = true;

    /**
     * social auth request.
     *
     * https://laravel.com/docs/5.7/socialite.
     *
     * @param mixed $provider
     * @bodyParam provider string required the social provider name Example: google
     *
     * @return [type] [description]
     */
    public function redirectToProvider($provider)
    {
        if ($this->checkForProvider($provider)) {
            return $this->statless
                ? Socialite::with($provider)->stateless()->redirect()
                : Socialite::with($provider)->redirect();
        }
    }

    /**
     * provider answer.
     *
     * @param [type] $provider
     * @bodyParam provider string required the social provider name Example: google
     */
    public function handleProviderCallback($provider)
    {
        try {
            $social = $this->getUserSocialAccount($provider);
        } catch (\Exception $e) {
            flash()->error('something went wrong, please try again later');

            return redirect()->route('home');
        }

        if ($user = User::where('email', $social->email)->first()) {
            auth()->login($user, true);

            return redirect()->route('home');
        }

        return redirect()->route('register')->with('user', $social);
    }

    /**
     * checkForProvider.
     *
     * @param mixed $provider
     */
    protected function checkForProvider($provider)
    {
        return config('services.' . $provider);
    }

    /**
     * getUserSocialAccount.
     *
     * @param mixed $provider
     */
    protected function getUserSocialAccount($provider)
    {
        return $this->statless
            ? Socialite::with($provider)->stateless()->user()
            : Socialite::with($provider)->user();
    }
}
