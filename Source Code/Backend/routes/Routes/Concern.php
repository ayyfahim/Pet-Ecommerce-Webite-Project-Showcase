<?php

Route::group(
    [
        'prefix' => 'concerns',
        'as' => 'concerns.',
    ],
    function () {
        Route::get('/', [
            'as' => 'index',
            'uses' => 'ConcernController@index',
        ]);

        Route::get('{slug}', [
            'as' => 'show',
            'uses' => 'ConcernController@show',
        ]);
    }
);

Route::group([
    'prefix' => 'admin/concerns',
    'as' => 'concern.admin.',
    'namespace' => 'Admin',
    'middleware' => 'manager_access',
], function () {
    /* -------------------------------- resource -------------------------------- */
    Route::get('/', [
        'as' => 'index',
        'uses' => 'ManagerConcernController@index',
        'middleware' => 'permission:view_brands'
    ]);

    Route::get('create', [
        'as' => 'create',
        'uses' => 'ManagerConcernController@create',
        'middleware' => 'permission:add_brands'
    ]);

    Route::post('/', [
        'as' => 'store',
        'uses' => 'ManagerConcernController@store',
        'middleware' => 'permission:add_brands'
    ]);

    Route::get('{concern}', [
        'as' => 'edit',
        'uses' => 'ManagerConcernController@edit',
        'middleware' => 'permission:edit_brands'
    ]);

    Route::patch('update/{concern}', [
        'as' => 'update',
        'uses' => 'ManagerConcernController@update',
        'middleware' => 'permission:edit_brands'
    ]);

    Route::delete('destroy/{concern}', [
        'as' => 'destroy',
        'uses' => 'ManagerConcernController@destroy',
        'middleware' => 'permission:delete_brands'
    ]);
});
