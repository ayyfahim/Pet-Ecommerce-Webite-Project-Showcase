<?php

Route::group([
    'prefix' => 'orders',
    'as' => 'order.',
], function () {
    /* -------------------------------- resource -------------------------------- */
    Route::get('/', [
        'as' => 'index',
        'uses' => 'OrderController@index',
    ]);

    Route::post('store', [
        'as' => 'store',
        'uses' => 'OrderController@store',
    ]);

    Route::get('{order}', [
        'as' => 'show',
        'uses' => 'OrderController@show',
    ]);

    Route::post('pay', [
        'as' => 'pay',
        'uses' => 'OrderController@pay',
    ]);

    Route::post('pay/success', [
        'as' => 'pay',
        'uses' => 'OrderController@orderPaySuccess',
    ]);

    Route::get('print/{order}', [
        'as' => 'print',
        'uses' => 'OrderController@print'
    ]);
});


Route::group([
    'prefix' => 'admin/orders',
    'as' => 'order.admin.',
    'namespace' => 'Admin',
    'middleware' => 'manager_access',
], function () {
    /* -------------------------------- resource -------------------------------- */
    Route::get('/', [
        'as' => 'index',
        'uses' => 'ManagerOrderController@index',
    ]);

    Route::get('export', [
        'as' => 'export',
        'uses' => 'ManagerOrderController@export',
    ]);
    Route::get('{order}', [
        'as' => 'show',
        'uses' => 'ManagerOrderController@show',
    ]);
    Route::get('print/{order}', [
        'as' => 'print',
        'uses' => 'ManagerOrderController@print',
    ]);

    Route::patch('update/{order}', [
        'as' => 'update',
        'uses' => 'ManagerOrderController@update',
    ]);
    Route::patch('email/{order}', [
        'as' => 'email',
        'uses' => 'ManagerOrderController@email',
    ]);
});

Route::get('export_dashboard', [
    'as' => 'export_dashboard',
    'uses' => 'HomeController@export',
]);
