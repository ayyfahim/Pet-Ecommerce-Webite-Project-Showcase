<?php

Route::group([
    'prefix' => 'cart',
    'as' => 'cart.',
], function () {
    /* -------------------------------- resource -------------------------------- */
    Route::get('', [
        'as' => 'index',
        'uses' => 'CartController@index',
    ]);

    Route::post('/store', [
        'as' => 'store',
        'uses' => 'CartController@store',
    ]);
    Route::patch('/update/{cartBasket}', [
        'as' => 'update',
        'uses' => 'CartController@update',
    ]);

    Route::delete('destroy/{cartBasket}', [
        'as' => 'destroy',
        'uses' => 'CartController@destroy',
    ]);
    Route::delete('clear', [
        'as' => 'clear',
        'uses' => 'CartController@clear',
    ]);
    Route::post('clinic/move', [
        'as' => 'clinic.move',
        'uses' => 'CartController@move_to_cart',
    ]);
    Route::get('shipping_methods/{address_info}', [
        'as' => 'getShippingMethods',
        'uses' => 'CartController@getShippingMethods',
    ]);
    Route::post('set_shipping_method', [
        'as' => 'setShippingMethod',
        'uses' => 'CartController@setShippingMethod',
    ]);
    Route::post('set_payment_method', [
        'as' => 'setPaymentMethod',
        'uses' => 'CartController@setPaymentMethod',
    ]);
    Route::post('set_additional', [
        'as' => 'setAdditional',
        'uses' => 'CartController@setAdditional',
    ]);
    Route::post('apply/coupon', [
        'as' => 'applyCouponCode',
        'uses' => 'CartController@applyCartCouponCode',
    ]);
});
