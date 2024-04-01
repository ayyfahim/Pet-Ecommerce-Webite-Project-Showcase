<?php

Route::group([
    'prefix' => 'admin/management',
    'as' => 'management.admin.',
    'namespace' => 'Admin',
//    'middleware' => 'manager_access',
], function () {
    /* -------------------------------- resource -------------------------------- */
    Route::group([
        'prefix' => 'roles',
        'as' => 'role.',
    ], function () {
        /* -------------------------------- resource -------------------------------- */
        Route::get('/', [
            'as' => 'index',
            'uses' => 'ManagerRoleController@index',
            'middleware' => 'permission:view_roles'
        ]);

        Route::get('create', [
            'as' => 'create',
            'uses' => 'ManagerRoleController@create',
            'middleware' => 'permission:add_roles'
        ]);

        Route::post('/', [
            'as' => 'store',
            'uses' => 'ManagerRoleController@store',
            'middleware' => 'permission:add_roles'
        ]);

        Route::get('{role}', [
            'as' => 'edit',
            'uses' => 'ManagerRoleController@edit',
            'middleware' => 'permission:edit_roles'
        ]);

        Route::patch('update/{role}', [
            'as' => 'update',
            'uses' => 'ManagerRoleController@update',
            'middleware' => 'permission:edit_roles'
        ]);

        Route::delete('destroy/{role}', [
            'as' => 'destroy',
            'uses' => 'ManagerRoleController@destroy',
            'middleware' => 'permission:delete_roles'
        ]);
    });
    Route::group([
        'prefix' => 'users',
        'as' => 'user.',
    ], function () {
        /* -------------------------------- resource -------------------------------- */
        Route::get('/', [
            'as' => 'index',
            'uses' => 'ManagerAdminController@index',
            'middleware' => 'permission:view_admins'
        ]);

        Route::get('create', [
            'as' => 'create',
            'uses' => 'ManagerAdminController@create',
            'middleware' => 'permission:add_admins'
        ]);

        Route::post('/', [
            'as' => 'store',
            'uses' => 'ManagerAdminController@store',
            'middleware' => 'permission:add_admins'
        ]);

        Route::get('{user}', [
            'as' => 'edit',
            'uses' => 'ManagerAdminController@edit',
            'middleware' => 'permission:edit_admins'
        ]);
        Route::patch('update/{user}', [
            'as' => 'update',
            'uses' => 'ManagerAdminController@update',
            'middleware' => 'permission:edit_admins'
        ]);

        Route::delete('destroy/{user}', [
            'as' => 'destroy',
            'uses' => 'ManagerAdminController@destroy',
            'middleware' => 'permission:delete_admins'
        ]);
    });
});
