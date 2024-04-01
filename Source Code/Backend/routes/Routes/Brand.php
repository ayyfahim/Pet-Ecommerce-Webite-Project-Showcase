<?php

Route::group(
    [
        'prefix' => 'brands',
        'as' => 'brands.',
    ],
    function () {
        Route::get('/', [
            'as' => 'index',
            'uses' => 'BrandController@index',
        ]);
    }
);

Route::group([
    'prefix' => 'admin/brands',
    'as' => 'brand.admin.',
    'namespace' => 'Admin',
    'middleware' => 'manager_access',
], function () {
    /* -------------------------------- resource -------------------------------- */
    Route::get('/', [
        'as' => 'index',
        'uses' => 'ManagerBrandController@index',
        'middleware' => 'permission:view_brands'
    ]);

    Route::get('create', [
        'as' => 'create',
        'uses' => 'ManagerBrandController@create',
        'middleware' => 'permission:add_brands'
    ]);

    Route::post('/', [
        'as' => 'store',
        'uses' => 'ManagerBrandController@store',
        'middleware' => 'permission:add_brands'
    ]);

    Route::get('{brand}', [
        'as' => 'edit',
        'uses' => 'ManagerBrandController@edit',
        'middleware' => 'permission:edit_brands'
    ]);

    Route::patch('update/{brand}', [
        'as' => 'update',
        'uses' => 'ManagerBrandController@update',
        'middleware' => 'permission:edit_brands'
    ]);

    Route::delete('destroy/{brand}', [
        'as' => 'destroy',
        'uses' => 'ManagerBrandController@destroy',
        'middleware' => 'permission:delete_brands'
    ]);
});
