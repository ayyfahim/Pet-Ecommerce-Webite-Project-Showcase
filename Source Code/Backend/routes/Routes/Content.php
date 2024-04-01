<?php

Route::group([
    'prefix' => 'admin/content',
    'as' => 'content.admin.',
    'namespace' => 'Admin',
    'middleware' => 'manager_access',
], function () {
    /* -------------------------------- resource -------------------------------- */
    Route::group([
        'prefix' => 'pages',
        'as' => 'page.',
    ], function () {
        /* -------------------------------- resource -------------------------------- */
        Route::get('/', [
            'as' => 'index',
            'uses' => 'ManagerPageController@index',
            'middleware' => 'permission:view_pages'
        ]);

        Route::get('create', [
            'as' => 'create',
            'uses' => 'ManagerPageController@create',
            'middleware' => 'permission:add_pages'
        ]);

        Route::post('/', [
            'as' => 'store',
            'uses' => 'ManagerPageController@store',
            'middleware' => 'permission:add_pages'
        ]);

        Route::get('{page}', [
            'as' => 'edit',
            'uses' => 'ManagerPageController@edit',
            'middleware' => 'permission:edit_pages'
        ]);

        Route::patch('update/{page}', [
            'as' => 'update',
            'uses' => 'ManagerPageController@update',
            'middleware' => 'permission:edit_pages'
        ]);

        Route::delete('destroy/{page}', [
            'as' => 'destroy',
            'uses' => 'ManagerPageController@destroy',
            'middleware' => 'permission:delete_pages'
        ]);

        Route::get('show-dump/{page}', [
            'as' => 'test_dump',
            'uses' => 'ManagerPageController@show_dump',
        ]);
    });
    Route::group([
        'prefix' => 'email_templates',
        'as' => 'email_template.',
    ], function () {
        /* -------------------------------- resource -------------------------------- */
        Route::get('/', [
            'as' => 'index',
            'uses' => 'ManagerEmailTemplateController@index',
            'middleware' => 'permission:view_email_templates'
        ]);

        Route::get('{notification}', [
            'as' => 'edit',
            'uses' => 'ManagerEmailTemplateController@edit',
            'middleware' => 'permission:edit_email_templates'
        ]);
        Route::get('preview/{notification}', [
            'as' => 'show',
            'uses' => 'ManagerEmailTemplateController@show',
            'middleware' => 'permission:view_email_templates'
        ]);
        Route::patch('update/{notification}', [
            'as' => 'update',
            'uses' => 'ManagerEmailTemplateController@update',
            'middleware' => 'permission:edit_email_templates'
        ]);
    });
});

Route::group([
    'prefix' => 'content',
    'as' => 'content.',
], function () {
    Route::get('{slug}', [
        'as' => 'show',
        'uses' => 'PageController@show'
    ]);
});
