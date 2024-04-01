<?php

Route::group([
    'prefix' => 'admin/pages',
    'as' => 'page.admin.',
    'namespace' => 'Admin',
], function () {
    /* -------------------------------- resource -------------------------------- */
    Route::get('/', [
        'as' => 'index',
        'uses' => 'ManagerPageController@index',
    ]);

    Route::get('{page}', [
        'as' => 'edit',
        'uses' => 'ManagerPageController@edit',
    ]);

    Route::get('show-dump/{page}', [
        'as' => 'test_dump',
        'uses' => 'ManagerPageController@show_dump',
    ]);

    Route::patch('update/{page}', [
        'as' => 'update',
        'uses' => 'ManagerPageController@update',
    ]);
});

Route::group([
    'prefix' => 'page',
    'as' => 'page.',
], function () {
    /* -------------------------------- resource -------------------------------- */
    Route::get('{slug}', [
        'as' => 'show',
        'uses' => 'PageController@show',
    ]);
});
Route::post('support', 'HomeController@support');
//Route::get('admin/import', 'HomeController@importProducts');
Route::post('/upload_media', 'HomeController@upload_media')->name('media.store');
