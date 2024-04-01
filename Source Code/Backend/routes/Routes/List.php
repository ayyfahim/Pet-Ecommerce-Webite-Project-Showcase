<?php

Route::group([
    'prefix' => 'lists',
    'as' => 'list.',
], function () {
    /* -------------------------------- resource -------------------------------- */
    Route::get('{type}', [
        'as' => 'index',
        'uses' => 'ProductListController@index',
    ])->where('type', 'wishlist|compare|clinic');

    Route::post('/store', [
        'as' => 'store',
        'uses' => 'ProductListController@store',
    ]);

    Route::delete('destroy/{list}', [
        'as' => 'destroy',
        'uses' => 'ProductListController@destroy',
    ]);
});

Route::group([
    'prefix' => 'admin/lists',
    'as' => 'list.manager.',
    'namespace' => 'Admin',
    'middleware' => 'manager_access',
], function () {
    /* -------------------------------- resource -------------------------------- */
    Route::post('/store', [
        'as' => 'store',
        'uses' => 'ManagerProductListController@store',
    ]);
});
