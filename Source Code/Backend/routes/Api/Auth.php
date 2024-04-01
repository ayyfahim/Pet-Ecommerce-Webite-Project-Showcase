<?php

Route::group([
    'prefix'    => 'auth',
    'namespace' => 'Auth\Api',
], function () {
    Route::post('register', 'AuthController@register');
    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@getAuthUser');
    Route::post('check', 'AuthController@check');
    Route::patch('edit', 'AuthController@edit');
    Route::post('register/cart', 'AuthController@registerWithCart');

    // social login
    Route::get('/social-login/{provider}', 'AuthController@redirectToProvider');
    Route::get('/social-login/{provider}/callback', 'AuthController@handleProviderCallback');

    // forget pass
    Route::post('password/email', 'ForgetPasswordController@sendResetLinkEmail');
    Route::post('password/reset', 'ResetPasswordController@reset');
});
