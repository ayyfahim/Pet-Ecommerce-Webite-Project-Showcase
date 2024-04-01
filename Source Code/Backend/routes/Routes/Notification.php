<?php

Route::group([
    'prefix' => 'manager/notifications',
    'as' => 'notification.manager.',
    'namespace' => 'Admin',
], function () {
    /* -------------------------------- resource -------------------------------- */
    Route::get('/', [
        'as' => 'index',
        'uses' => 'ManagerNotificationController@index',
    ]);

    Route::get('{id}', [
        'as' => 'edit',
        'uses' => 'ManagerNotificationController@edit',
    ]);

    Route::patch('update/{id}', [
        'as' => 'update',
        'uses' => 'ManagerNotificationController@update',
    ]);
});
