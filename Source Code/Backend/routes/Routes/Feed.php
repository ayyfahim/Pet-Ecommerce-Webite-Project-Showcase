<?php

Route::group([
    'prefix' => 'admin/feeds',
    'as' => 'feed.admin.',
    'namespace' => 'Admin',
    'middleware' => 'manager_access',
], function () {
    /* -------------------------------- resource -------------------------------- */
    Route::get('/', [
        'as' => 'index',
        'uses' => 'ManagerFeedController@index',
    ]);

    Route::get('fetch', [
        'as' => 'fetch',
        'uses' => 'ManagerFeedController@fetch',
    ]);
    Route::get('sync/{feed}', [
        'as' => 'sync',
        'uses' => 'ManagerFeedController@sync',
    ]);

    Route::get('create', [
        'as' => 'create',
        'uses' => 'ManagerFeedController@create',
    ]);

    Route::post('/', [
        'as' => 'store',
        'uses' => 'ManagerFeedController@store',
    ]);

    Route::get('edit/{feed}', [
        'as' => 'edit',
        'uses' => 'ManagerFeedController@edit',
    ]);

    Route::patch('update/{feed}', [
        'as' => 'update',
        'uses' => 'ManagerFeedController@update',
    ]);

    Route::delete('destroy/{feed}', [
        'as' => 'destroy',
        'uses' => 'ManagerFeedController@destroy',
    ]);
});
