<?php

namespace App\Http\Controllers\Auth\Api;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Transformers\UserTransformer;

/**
 * @group Auth
 */
class SocialLoginController extends Controller
{
    /**
     * getUserBySocial.
     *
     * @bodyParam email string
     * @bodyParam full_name string
     * @bodyParam avatar string
     * @bodyParam device_token string
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getUserBySocial(Request $request)
    {
        if ($user = User::where('email', $request->email)->first()) {
            $token = auth()->fromUser($user);
            $this->saveToken($request, $user);
            $this->moveGuest($user);
            return $this->returnCrudData('Welcome Back', null, 'success', [
                'user' => fractal($user, new UserTransformer())->toArray()['data'],
                'token' => $token,
            ]);
        }
        else{
            $user = User::create($request->only(['full_name','email']));
            $token = auth()->fromUser($user);
            if ($request->avatar) {
                $user->addMediaFromUrl($request->avatar)->toMediaCollection('avatar');
            }
            $user->attachRoleOf('customer');
            return $this->returnCrudData('', null, 'success', [
                'user' => fractal($user, new UserTransformer())->toArray()['data'],
                'token' => $token,
            ]);
        }
    }
}
