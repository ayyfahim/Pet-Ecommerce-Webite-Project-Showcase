<?php

Route::group([
    'prefix' => 'admin/attributes',
    'as' => 'attribute.admin.',
    'namespace' => 'Admin',
    'middleware' => 'manager_access',
], function () {
    /* -------------------------------- resource -------------------------------- */
    Route::get('/', [
        'as' => 'index',
        'uses' => 'ManagerAttributeController@index',
        'middleware' => 'permission:view_attributes'
    ]);

    Route::get('create', [
        'as' => 'create',
        'uses' => 'ManagerAttributeController@create',
        'middleware' => 'permission:add_attributes'
    ]);

    Route::post('/', [
        'as' => 'store',
        'uses' => 'ManagerAttributeController@store',
        'middleware' => 'permission:add_attributes'
    ]);

    Route::get('getProductOption', [
        'as' => 'getProductOption',
        'uses' => 'ManagerAttributeController@getProductOption',
    ]);
    Route::get('{attribute}', [
        'as' => 'edit',
        'uses' => 'ManagerAttributeController@edit',
        'middleware' => 'permission:edit_attributes'
    ]);

    Route::patch('update/{attribute}', [
        'as' => 'update',
        'uses' => 'ManagerAttributeController@update',
        'middleware' => 'permission:edit_attributes'
    ]);

    Route::delete('destroy/{attribute}', [
        'as' => 'destroy',
        'uses' => 'ManagerAttributeController@destroy',
        'middleware' => 'permission:delete_attributes'
    ]);
});
