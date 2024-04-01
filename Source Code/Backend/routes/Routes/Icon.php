<?php

Route::group([
    'prefix' => 'admin/icons',
    'as' => 'icon.admin.',
    'namespace' => 'Admin',
    'middleware' => 'manager_access',
], function () {
    /* -------------------------------- resource -------------------------------- */
    Route::get('/', [
        'as' => 'index',
        'uses' => 'ManagerIconController@index',
        'middleware' => 'permission:view_icons'
    ]);

    Route::get('create', [
        'as' => 'create',
        'uses' => 'ManagerIconController@create',
        'middleware' => 'permission:add_icons'
    ]);

    Route::post('/', [
        'as' => 'store',
        'uses' => 'ManagerIconController@store',
        'middleware' => 'permission:add_icons'
    ]);

    Route::get('{icon}', [
        'as' => 'edit',
        'uses' => 'ManagerIconController@edit',
        'middleware' => 'permission:edit_icons'
    ]);

    Route::patch('update/{icon}', [
        'as' => 'update',
        'uses' => 'ManagerIconController@update',
        'middleware' => 'permission:edit_icons'
    ]);

    Route::delete('destroy/{icon}', [
        'as' => 'destroy',
        'uses' => 'ManagerIconController@destroy',
        'middleware' => 'permission:delete_icons'
    ]);
});
