<?php

namespace App\Http\Controllers\Auth\Api;

use App\User;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Requests\UserAuth;
use App\Http\Requests\UserStore;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserCartStore;
use Illuminate\Support\Facades\Auth;
use App\Transformers\UserTransformer;
use App\Transformers\Traits\CartHelpers;
use Laravel\Socialite\Facades\Socialite;
use GuzzleHttp\Exception\ClientException;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Http\Controllers\Traits\CartChanges;
use App\Http\Controllers\Traits\Product\HasVariation;
use App\Http\Controllers\Traits\CartHelpers as TraitsCartHelpers;

/**
 * @group Auth
 */
class AuthController extends Controller
{
    use CartHelpers, CartChanges, HasVariation, TraitsCartHelpers;

    public function __construct()
    {
        $this->middleware('auth')
            ->only(['logout', 'getAuthUser', 'refresh', 'edit']);
    }

    /**
     * login.
     *
     * @param Request $request [description]
     *
     * @return \Illuminate\Http\JsonResponse [type] [description]
     * @throws \Illuminate\Validation\ValidationException
     * @bodyParam email string required
     * @bodyParam password string required
     * @bodyParam device_token string
     *
     */
    public function login(Request $request)
    {
        $this->validate($request, (new UserAuth())->loginRules());
        $user = User::where('email', $request->email)->first();
        if ($user && ($user->status->order == 2)) {
            return $this->returnCrudData(__('system_messages.auth.inactive'), null, 'error');
        }
        if (!$request->password) {
            return response()->json(['message' => 'could not create token'], 500);
        }
        $credentials = $request->only('email', 'password');
        $token = auth()->attempt($credentials, true);
        try {
            if (!$token) {
                return response()->json(['errors' => ['password' => ['Password incorrect.']], 'wrong_password_error' => true], 400);
            }
        } catch (JWTException $e) {
            return response()->json(['message' => 'could not create token'], 500);
        }
        $authUser = auth()->user();
        $authUser->update(['last_login' => now()]);
        $this->saveToken($request, auth()->user());
        $this->moveGuest($authUser);
        return $this->returnCrudData('', null, 'success', [
            'user' => fractal($user->fresh(), new UserTransformer())->toArray()['data'],
            'token' => $token,
        ]);
    }

    /**
     * register.
     *
     * @bodyParam full_name string required for customer only
     * @bodyParam email string required
     * @bodyParam country_code string required for mobileApp only
     * @bodyParam mobile string required
     * @bodyParam password string required
     * @bodyParam social integer [send it only if the user is with social register and send it with value = 1]
     * @bodyParam locale string [en/ar]
     * @bodyParam device_token string
     *
     * @param UserStore $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(UserStore $request)
    {
        $data = $request->except('avatar', 'social', 'device_token');
        if ($request->social) {
            $data['email_verified_at'] = now();
        }
        $user = User::create($data);
        $token = auth()->fromUser($user);
        if ($request->avatar) {
            $user->addMediaFromUrl($request->avatar)->toMediaCollection('avatar');
        }
        $user->attachRoleOf('customer');
        //        $this->saveToken($request, $user);
        $this->moveGuest($user);
        return $this->returnCrudData('', null, 'success', [
            'user' => fractal($user->fresh(), new UserTransformer())->toArray()['data'],
            'token' => $token,
        ]);
    }

    /**
     * check.
     *
     * @bodyParam email string required
     */
    public function check(Request $request)
    {
        $response['user_exist'] = false;
        if ($user = User::where('email', $request->email)->first()) {
            $response['user'] = [
                'first_name' => $user->first_name,
                'full_name' => $user->full_name,
                'email' => $user->email,
            ];
            $response['user_exist'] = true;
        }
        return response()->json($response);
    }

    /**
     * logout.
     * @bodyParam device_token string
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector [type] [description]
     */
    public function logout(Request $request)
    {
        $auth = auth()->user();
        if ($request->device_token) {
            $tokens = $auth->device_tokens;
            if (!is_null($tokens)) {
                $pos = array_search($request->device_token, $tokens);
                if ($pos !== false) {
                    unset($tokens[$pos]);
                }
            }
            $auth->update([
                'device_tokens' => $tokens ?: null,
            ]);
        }
        auth()->logout();
        return $this->returnCrudData('');
    }

    /**
     * get current Authenticated User.
     *
     * @return [type] [description]
     */
    public function getAuthUser()
    {
        return $this->returnCrudData(
            '',
            null,
            'success',
            fractal(auth()->user(), new UserTransformer())->toArray()['data']
        );
    }

    protected function getToken($t)
    {
        return [
            'access_token' => $t,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL(),
        ];
    }

    public function edit(UserStore $request)
    {
        auth()->user()->update($request->all());

        return $this->returnCrudData(
            '',
            null,
            'success',
            fractal(auth()->user(), new UserTransformer())->toArray()['data']
        );
    }

    /**
     * register with add to cart.
     *
     * @bodyParam email string required
     * @bodyParam full_name string
     * @bodyParam mobile string
     *
     * @param UserCartStore $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function registerWithCart(UserCartStore $request)
    {
        $user = User::where('email', $request->email)->first();
        if ($user) {
            Auth::login($user, true);
            $authUser = auth()->user();
            $updateData = [];
            $updateData['last_login'] = now();
            if (isset($request->full_name)) {
                $updateData['full_name'] = $request->full_name;
            }
            if (isset($request->mobile)) {
                $updateData['mobile'] = $request->mobile;
            }
            $authUser->update($updateData);
            $this->saveToken($request, $authUser);
            if (!$user->carts()->count()) {
                $user->carts()->create();
            }
        } else {
            $data = $request->only('email', 'full_name', 'mobile');
            $data['email_verified_at'] = now();
            $user = User::create($data);
            $user = $user->fresh();
            Auth::login($user, true);
            $user->attachRoleOf('customer');
            $this->saveToken($request, $user);
            if (!$user->carts()->count()) {
                $user->carts()->create();
            }
        }
        $token = auth()->fromUser($user);
        $cart = $this->getCart(null, $user);
        if ($request->has('products')) {
            $this->getCart()->doEmptyCart();
            // Check Out of Stocks
            $checkForStockResponse = $this->checkOutOfStockProducts($request->products);
            if ($checkForStockResponse['type'] == 'error') {
                return $this->returnCrudData($checkForStockResponse['msg'], null, $checkForStockResponse['type'], $checkForStockResponse['data'] ?? []);
            }
            // Add to Carts
            $cartResponse = $this->addToMultipleCart($request->products, $cart);
            if ($cartResponse['type'] == 'error') {
                return $this->returnCrudData($cartResponse['msg'], null, $cartResponse['type'], $cartResponse['data'] ?? []);
            }
        }

        // if ($request->has('code') && isset($request->code) && $request->code != '') {
        //     $cart = $this->getCart(null, $user);
        //     $couponResponse = $this->applyCouponCode($cart, $request->code);
        //     if ($couponResponse['type'] == 'error') {
        //         return $this->returnCrudData($couponResponse['msg'], null, $couponResponse['type']);
        //     }
        // }

        // $this->createCartForTemporary($request->all());

        $data = [
            'user' => fractal($user->fresh(), new UserTransformer())->toArray()['data'],
        ];
        if ($token) {
            $data['token'] = $token;
        }

        if (!$cart->order) {
            $order = $cart->order()->create();

            Order::withoutEvents(function () use ($cart) {
                Order::where('cart_id', $cart->id)->get()->first()->update([
                    'is_temp' => false
                ]);
                return true;
            });

            $data['order'] = $order->fresh();
        } else {
            Order::withoutEvents(function () use ($cart) {
                Order::where('cart_id', $cart->id)->get()->first()->update([
                    'is_temp' => false,
                    'totals_info' => $this->getTotals($cart)
                ]);
            });

            $data['order'] = $cart->order->first();
        }

        return $this->returnCrudData('Added to cart', null, 'success', $data);
    }

    /**
     * Redirect the user to the Provider authentication page.
     *
     * @param $provider
     * @return JsonResponse
     */
    public function redirectToProvider($provider)
    {
        $validated = $this->validateProvider($provider);
        if (!is_null($validated)) {
            return $validated;
        }

        return Socialite::driver($provider)->stateless()->redirect()->getTargetUrl();
    }

    /**
     * Obtain the user information from Provider.
     *
     * @param $provider
     * @return JsonResponse
     */
    public function handleProviderCallback($provider)
    {
        $validated = $this->validateProvider($provider);
        if (!is_null($validated)) {
            return $validated;
        }
        try {
            $social_user = Socialite::driver($provider)->stateless()->user();
        } catch (ClientException $exception) {
            // return response()->json(['error' => 'Invalid credentials provided.'], 422);
            return $this->returnCrudData('Invalid credentials provided.', null, 'error', []);
        }

        // $userCreated = User::firstOrCreate(
        //     [
        //         'email' => $user->getEmail()
        //     ],
        //     [
        //         'email_verified_at' => now(),
        //         'name' => $user->getName(),
        //         'status' => true,
        //     ]
        // );
        // $userCreated->providers()->updateOrCreate(
        //     [
        //         'provider' => $provider,
        //         'provider_id' => $user->getId(),
        //     ],
        //     [
        //         'avatar' => $user->getAvatar()
        //     ]
        // );
        // $token = $userCreated->createToken('token-name')->plainTextToken;

        // return response()->json($userCreated, 200, ['Access-Token' => $token]);

        $user = User::where('email', $social_user->getEmail())->first();
        $request = request();
        if ($user) {
            Auth::login($user, true);
            $authUser = auth()->user();
            $updateData = [];
            $updateData['last_login'] = now();
            if (isset($request->full_name)) {
                $updateData['full_name'] = $request->full_name;
            }
            if (isset($request->mobile)) {
                $updateData['mobile'] = $request->mobile;
            }
            $authUser->update($updateData);
            $this->saveToken($request, $authUser);

            $authUser->social_providers()->updateOrCreate(
                [
                    'provider' => $provider,
                    'provider_id' => $social_user->getId(),
                ],
                [
                    'avatar' => $social_user->getAvatar()
                ]
            );
        } else {
            $data = [];
            $data['email_verified_at'] = now();
            $data['email'] = $social_user->getEmail();
            $data['full_name'] = $social_user->getName();
            $user = User::create($data);
            $user = $user->fresh();
            Auth::login($user, true);
            $user->attachRoleOf('customer');
            $this->saveToken($request, $user);
        }
        $token = auth()->fromUser($user);

        return $this->returnCrudData('', null, 'success', [
            'user' => fractal($user->fresh(), new UserTransformer())->toArray()['data'],
            'token' => $token,
        ]);

        return $this->returnCrudData('Added to cart', null, 'success', $data);
    }

    /**
     * @param $provider
     * @return JsonResponse
     */
    protected function validateProvider($provider)
    {
        if (!in_array($provider, ['facebook', 'google'])) {
            return $this->returnCrudData('Please login using facebook or google', null, 'error', []);
            // return response()->json(['error' => 'Please login using facebook, github or google'], 422);
        }
    }
}
