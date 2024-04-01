<?php

Route::group([
    'prefix' => 'admin/redirections',
    'as' => 'redirection.admin.',
    'namespace' => 'Admin',
    'middleware' => 'manager_access',
], function () {
    /* -------------------------------- resource -------------------------------- */
    Route::get('/', [
        'as' => 'index',
        'uses' => 'ManagerRedirectionController@index',
    ]);

    Route::get('create', [
        'as' => 'create',
        'uses' => 'ManagerRedirectionController@create',
    ]);

    Route::post('/', [
        'as' => 'store',
        'uses' => 'ManagerRedirectionController@store',
    ]);

    Route::get('edit/{redirection}', [
        'as' => 'edit',
        'uses' => 'ManagerRedirectionController@edit',
    ]);

    Route::patch('update/{redirection}', [
        'as' => 'update',
        'uses' => 'ManagerRedirectionController@update',
    ]);

    Route::delete('destroy/{redirection}', [
        'as' => 'destroy',
        'uses' => 'ManagerRedirectionController@destroy',
    ]);
});
