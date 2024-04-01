<?php

Route::group([
    'prefix' => 'admin/configurations',
    'as' => 'config.manager.',
    'namespace' => 'Admin',
], function () {
    Route::get('{group}', [
        'as' => 'index',
        'uses' => 'ManagerConfigController@index',
    ]);
    Route::get('authorize/instagram', [
        'as' => 'authorizeInstagram',
        'uses' => 'ManagerConfigController@authorizeInstagram',
    ]);
    Route::patch('update', [
        'as' => 'update',
        'uses' => 'ManagerConfigController@update',
    ]);
});
