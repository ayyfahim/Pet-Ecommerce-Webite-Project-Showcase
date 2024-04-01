<?php

Route::group([
    'prefix' => 'admin/courriers',
    'as' => 'courrier.admin.',
    'namespace' => 'Admin',
    'middleware' => 'manager_access',
], function () {
    /* -------------------------------- resource -------------------------------- */
    Route::get('/', [
        'as' => 'index',
        'uses' => 'ManagerCourrierController@index',
    ]);

    Route::get('create', [
        'as' => 'create',
        'uses' => 'ManagerCourrierController@create',
    ]);

    Route::post('/', [
        'as' => 'store',
        'uses' => 'ManagerCourrierController@store',
    ]);

    Route::get('edit/{courrier}', [
        'as' => 'edit',
        'uses' => 'ManagerCourrierController@edit',
    ]);

    Route::patch('update/{courrier}', [
        'as' => 'update',
        'uses' => 'ManagerCourrierController@update',
    ]);

    Route::delete('destroy/{courrier}', [
        'as' => 'destroy',
        'uses' => 'ManagerCourrierController@destroy',
    ]);
});
