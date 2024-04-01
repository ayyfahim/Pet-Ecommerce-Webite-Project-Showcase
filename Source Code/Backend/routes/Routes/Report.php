<?php

Route::group([
    'prefix' => 'admin/reports',
    'as' => 'report.admin.',
    'namespace' => 'Admin',
    'middleware' => 'manager_access',
], function () {
    /* -------------------------------- resource -------------------------------- */
    Route::get('/', [
        'as' => 'index',
        'uses' => 'ManagerReportController@index',
    ]);
});
