<?php

Route::group([
    'prefix' => 'admin/suppliers',
    'as' => 'vendor.admin.',
    /*'namespace' => 'Admin',*/
    'middleware' => 'manager_access',
], function () {
    /* -------------------------------- resource -------------------------------- */
    Route::get('/', [
        'as' => 'index',
        'uses' => 'ManagerVendorController@index',
        'middleware' => 'permission:view_vendors'
    ]);
    Route::get('export', [
        'as' => 'export',
        'uses' => 'ManagerVendorController@export',
        'middleware' => 'permission:view_vendors'
    ]);

    Route::get('create', [
        'as' => 'create',
        'uses' => 'ManagerVendorController@create',
        'middleware' => 'permission:add_vendors'
    ]);

    Route::post('/', [
        'as' => 'store',
        'uses' => 'ManagerVendorController@store',
        'middleware' => 'permission:add_vendors'
    ]);

    Route::get('{vendor}', [
        'as' => 'edit',
        'uses' => 'ManagerVendorController@edit',
        'middleware' => 'permission:edit_vendors'
    ]);

    Route::patch('update/{vendor}', [
        'as' => 'update',
        'uses' => 'ManagerVendorController@update',
        'middleware' => 'permission:edit_vendors'
    ]);

    Route::delete('destroy/{vendor}', [
        'as' => 'destroy',
        'uses' => 'ManagerVendorController@destroy',
        'middleware' => 'permission:delete_vendors'
    ]);
});
