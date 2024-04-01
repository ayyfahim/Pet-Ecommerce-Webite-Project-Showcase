<?php

Route::group([
    'prefix' => 'contact_us',
    'as' => 'contact_us.',
], function () {
    /* -------------------------------- resource -------------------------------- */
    Route::post('/', [
        'as' => 'store',
        'uses' => 'ContactUsController@store',
    ]);
});
