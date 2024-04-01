<?php

Route::group([
    'prefix' => 'admin/deals',
    'as' => 'deal.admin.',
    'namespace' => 'Admin',
    'middleware' => 'manager_access',
], function () {
    /* -------------------------------- resource -------------------------------- */
    Route::get('/', [
        'as' => 'index',
        'uses' => 'ManagerDealController@index',
    ]);

    Route::get('create', [
        'as' => 'create',
        'uses' => 'ManagerDealController@create',
    ]);

    Route::post('/', [
        'as' => 'store',
        'uses' => 'ManagerDealController@store',
    ]);

    Route::get('edit/{deal}', [
        'as' => 'edit',
        'uses' => 'ManagerDealController@edit',
    ]);

    Route::patch('update/{deal}', [
        'as' => 'update',
        'uses' => 'ManagerDealController@update',
    ]);

    Route::delete('destroy/{deal}', [
        'as' => 'destroy',
        'uses' => 'ManagerDealController@destroy',
    ]);
});
Route::get('deals', [
    'as' => 'past_deals',
    'uses' => 'HomeController@past_deals',
]);
