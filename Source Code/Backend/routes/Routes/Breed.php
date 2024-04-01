<?php

Route::group([
    'prefix' => 'admin/breeds',
    'as' => 'breed.admin.',
    'namespace' => 'Admin',
    'middleware' => 'manager_access',
], function () {
    /* -------------------------------- resource -------------------------------- */
    Route::get('/', [
        'as' => 'index',
        'uses' => 'ManagerBreedController@index',
    ]);

    Route::get('create', [
        'as' => 'create',
        'uses' => 'ManagerBreedController@create',
    ]);

    Route::post('/', [
        'as' => 'store',
        'uses' => 'ManagerBreedController@store',
    ]);

    Route::get('edit/{breed}', [
        'as' => 'edit',
        'uses' => 'ManagerBreedController@edit',
    ]);

    Route::patch('update/{breed}', [
        'as' => 'update',
        'uses' => 'ManagerBreedController@update',
    ]);

    Route::delete('destroy/{breed}', [
        'as' => 'destroy',
        'uses' => 'ManagerBreedController@destroy',
    ]);
});
