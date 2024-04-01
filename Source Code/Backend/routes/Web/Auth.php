<?php

Route::group([
    'namespace'  => 'Auth\Web',
], function () {
    // register
    Route::group(['prefix' => 'register'], function () {
        Route::get('/', [
            'uses' => 'RegisterController@showRegistrationForm',
            'as'   => 'register',
        ]);

        Route::post('/', [
            'uses' => 'RegisterController@register',
            'as'   => 'register.store',
        ]);
    });

    // forgot password
    Route::group(['prefix' => 'password'], function () {
        Route::get('reset', [
            'uses' => 'ForgotPasswordController@showLinkRequestForm',
            'as'   => 'password.request',
        ]);

        Route::post('email', [
            'uses' => 'ForgotPasswordController@sendResetLinkEmail',
            'as'   => 'password.email',
        ]);

        Route::post('reset', [
            'uses' => 'ResetPasswordController@reset',
            'as'   => 'password.update',
        ]);
    });
    Route::get('password/reset/{token}', [
        'uses' => 'ResetPasswordController@showResetForm',
        'as'   => 'password.reset',
    ]);
    Route::get('admin/login', [
        'uses' => 'LoginController@showAdminLoginForm',
        'as'   => 'admin.login',
    ]);
    // login
    Route::group(['prefix' => 'login'], function () {
        Route::get('/', [
            'uses' => 'LoginController@showLoginForm',
            'as'   => 'login',
        ]);

        Route::post('/', [
            'uses' => 'LoginController@login',
            'as'   => 'login.store',
        ]);
    });

    // logout
    Route::post('logout', [
        'uses' => 'LoginController@logout',
        'as'   => 'logout',
    ]);
});
