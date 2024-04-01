<?php
Route::group([
    'as' => 'admin.',
    'prefix' => 'admin',
    'middleware' => 'manager_access',
], function () {
    Route::get('/', [
        'as' => 'dashboard',
        'uses' => 'HomeController@dashboard',
    ]);
    Route::get('profile', [
        'as' => 'profile',
        'uses' => 'HomeController@profile',
    ]);
});
Route::group(['as' => 'user.'], function () {
    /* -------------------------------- manager -------------------------------- */
    Route::group([
        'as' => 'admin.',
        'prefix' => 'admin/customers',
        'namespace' => 'Admin',
        'middleware' => 'manager_access',
    ], function () {
        Route::get('/', [
            'as' => 'index',
            'uses' => 'ManagerUserController@index',
            'middleware' => 'permission:view_customers'
        ]);
        Route::get('{user}', [
            'as' => 'edit',
            'uses' => 'ManagerUserController@edit',
            'middleware' => 'permission:edit_customers'
        ]);
        Route::post('reset_password', [
            'as' => 'reset_password',
            'uses' => 'ManagerUserController@reset_password',
        ]);
        Route::delete('destroy/{user}', [
            'as' => 'destroy',
            'uses' => 'ManagerUserController@destroy',
            'middleware' => 'permission:delete_customers'
        ]);
    });

    /* -------------------------------- resource -------------------------------- */
    Route::group(['prefix' => 'users'], function () {
        Route::get('dashboard', [
            'as' => 'dashboard',
            'uses' => 'UserController@index',
        ]);

        Route::patch('update/{user}', [
            'as' => 'update',
            'uses' => 'UserController@update',
        ]);

        Route::get('notifications', [
            'as' => 'notifications',
            'uses' => 'UserController@notifications',
        ]);

    });
});
