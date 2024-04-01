<?php

Route::group([
    'prefix' => 'admin/pet_types',
    'as' => 'petType.admin.',
    'namespace' => 'Admin',
    'middleware' => 'manager_access',
], function () {
    /* -------------------------------- resource -------------------------------- */
    Route::get('/', [
        'as' => 'index',
        'uses' => 'ManagerPetTypeController@index',
    ]);

    Route::get('create', [
        'as' => 'create',
        'uses' => 'ManagerPetTypeController@create',
    ]);

    Route::post('/', [
        'as' => 'store',
        'uses' => 'ManagerPetTypeController@store',
    ]);

    Route::get('edit/{breed}', [
        'as' => 'edit',
        'uses' => 'ManagerPetTypeController@edit',
    ]);

    Route::patch('update/{breed}', [
        'as' => 'update',
        'uses' => 'ManagerPetTypeController@update',
    ]);

    Route::delete('destroy/{breed}', [
        'as' => 'destroy',
        'uses' => 'ManagerPetTypeController@destroy',
    ]);
});
