<?php
Route::group([
    'prefix' => 'categories',
    'as' => 'category.',
], function () {
    /* -------------------------------- resource -------------------------------- */
    Route::get('/', [
        'as' => 'index',
        'uses' => 'CategoryController@index',
    ]);
    Route::get('{slug}', [
        'as' => 'show',
        'uses' => 'CategoryController@show',
    ]);
    Route::get('single/{slug}', [
        'as' => 'show',
        'uses' => 'CategoryController@showSingle',
    ]);
});
Route::group([
    'prefix' => 'admin/categories',
    'as' => 'category.admin.',
    'namespace' => 'Admin',
    'middleware' => 'manager_access',
], function () {
    /* -------------------------------- resource -------------------------------- */
    Route::get('/', [
        'as' => 'index',
        'uses' => 'ManagerCategoryController@index',
        'middleware' => 'permission:view_categories'
    ]);

    Route::get('export', [
        'as' => 'export',
        'uses' => 'ManagerCategoryController@export',
        'middleware' => 'permission:view_categories'
    ]);

    Route::get('create', [
        'as' => 'create',
        'uses' => 'ManagerCategoryController@create',
        'middleware' => 'permission:add_categories'
    ]);

    Route::post('/', [
        'as' => 'store',
        'uses' => 'ManagerCategoryController@store',
        'middleware' => 'permission:add_categories'
    ]);

    Route::get('{category}', [
        'as' => 'edit',
        'uses' => 'ManagerCategoryController@edit',
        'middleware' => 'permission:edit_categories'
    ]);

    Route::patch('update/{category}', [
        'as' => 'update',
        'uses' => 'ManagerCategoryController@update',
        'middleware' => 'permission:edit_categories'
    ]);

    Route::delete('destroy/{category}', [
        'as' => 'destroy',
        'uses' => 'ManagerCategoryController@destroy',
        'middleware' => 'permission:delete_categories'
    ]);
});
