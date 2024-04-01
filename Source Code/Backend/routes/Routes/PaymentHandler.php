<?php


Route::group([
    'prefix' => 'paymentHandler',
    'as' => 'paymentHandler.',
], function () {
    Route::get('callback', [
        'as' => 'callback_success',
        'uses' => 'PaymentHandler@callbackSuccess',
    ]);
    Route::post('callback', [
        'as' => 'callback_success',
        'uses' => 'PaymentHandler@callbackSuccess',
    ]);
});
