<?php

Route::group([
    'prefix' => 'admin/authors',
    'as' => 'author.admin.',
    'namespace' => 'Admin',
    'middleware' => 'manager_access',
], function () {
    Route::get('/', [
        'as' => 'index',
        'uses' => 'ManagerAuthorController@index',
    ]);

    Route::get('create', [
        'as' => 'create',
        'uses' => 'ManagerAuthorController@create',
    ]);

    Route::post('/', [
        'as' => 'store',
        'uses' => 'ManagerAuthorController@store',
    ]);

    Route::get('edit/{author}', [
        'as' => 'edit',
        'uses' => 'ManagerAuthorController@edit',
    ]);

    Route::patch('update/{author}', [
        'as' => 'update',
        'uses' => 'ManagerAuthorController@update',
    ]);

    Route::delete('destroy/{author}', [
        'as' => 'destroy',
        'uses' => 'ManagerAuthorController@destroy',
    ]);
});
