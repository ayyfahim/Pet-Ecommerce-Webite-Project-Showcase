<?php

Route::group([
    'prefix' => 'admin/coupons',
    'as' => 'coupon.admin.',
    'namespace' => 'Admin',
    'middleware' => 'manager_access',
], function () {
    /* -------------------------------- resource -------------------------------- */
    Route::get('/', [
        'as' => 'index',
        'uses' => 'ManagerCouponController@index',
    ]);

    Route::get('export', [
        'as' => 'export',
        'uses' => 'ManagerCouponController@export',
    ]);
    Route::get('create', [
        'as' => 'create',
        'uses' => 'ManagerCouponController@create',
    ]);

    Route::post('/', [
        'as' => 'store',
        'uses' => 'ManagerCouponController@store',
    ]);

    Route::get('{coupon}', [
        'as' => 'edit',
        'uses' => 'ManagerCouponController@edit',
    ]);

    Route::patch('update/{coupon}', [
        'as' => 'update',
        'uses' => 'ManagerCouponController@update',
    ]);

    Route::delete('destroy/{coupon}', [
        'as' => 'destroy',
        'uses' => 'ManagerCouponController@destroy',
    ]);
});
