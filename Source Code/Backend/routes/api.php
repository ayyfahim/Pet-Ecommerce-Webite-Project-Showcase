<?php

$dirs = ['Api', 'Routes'];

Route::group(['as' => 'api.'], function () use ($dirs) { // to differentiate api from web routes
    Route::get('product_recomeendation', [
        'as' => 'productRecomeendation',
        'uses' => 'ProductController@product_recomeendation',
    ]);
    Route::get('products/{slug}', [
        'as' => 'product.show',
        'uses' => 'ProductController@show',
    ]);
    Route::get('getTotalRewardPoint', [
        'as' => 'getTotalRewardPoint',
        'uses' => 'OrderController@getTotalRewardPoint',
    ]);
    Route::post('/create-payment-intent', [
        'as' => 'payment_intent',
        'uses' => "StripeController@createPaymentIntent"
    ]);
    foreach ($dirs as $dir) {
        foreach (app('files')->allFiles(__DIR__ . "/$dir") as $route_file) {
            require $route_file->getPathname();
        }
    }
});
