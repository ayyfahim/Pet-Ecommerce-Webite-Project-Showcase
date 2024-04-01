<?php

Route::group([
    'prefix' => 'admin/reward_points',
    'as' => 'reward_point.admin.',
    'namespace' => 'Admin',
    'middleware' => 'manager_access',
], function () {
    /* -------------------------------- resource -------------------------------- */
    Route::get('/', [
        'as' => 'index',
        'uses' => 'ManagerRewardPointController@index',
    ]);

    Route::get('create/{user_id?}', [
        'as' => 'create',
        'uses' => 'ManagerRewardPointController@create',
    ]);

    Route::post('/', [
        'as' => 'store',
        'uses' => 'ManagerRewardPointController@store',
    ]);
    Route::get('{reward_point}', [
        'as' => 'edit',
        'uses' => 'ManagerRewardPointController@edit',
    ]);
    Route::patch('update/{reward_point}', [
        'as' => 'update',
        'uses' => 'ManagerRewardPointController@update',
    ]);

    Route::get('show/{user}', [
        'as' => 'show',
        'uses' => 'ManagerRewardPointController@show',
    ]);
    Route::delete('destroy/{reward_point}', [
        'as' => 'destroy',
        'uses' => 'ManagerRewardPointController@destroy',
    ]);
});

Route::group([
    'prefix' => 'reward_points',
    'as' => 'reward_point.',
], function () {
    /* -------------------------------- resource -------------------------------- */
    Route::get('/', [
        'as' => 'index',
        'uses' => 'RewardPointController@index',
    ]);
});
