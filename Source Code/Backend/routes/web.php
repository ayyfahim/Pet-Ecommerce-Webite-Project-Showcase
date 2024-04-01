<?php

//$ignore = ['Web/SocialAuth', 'Web/Verification'];
$ignore = ['Web/SocialAuth'];
$dirs = ['Web', 'Routes'];

/* ------------------------------- with locale ------------------------------ */
Route::get('products/{slug}', [
    'as' => 'product.show',
    'uses' => 'ProductController@show',
]);
Route::get('admin/test', [
    'as' => 'admin.test',
    'uses' => 'HomeController@test',
]);
// Route::get('{reactRoutes}', [
//     'uses' => 'HomeController@react'
// ])->where('reactRoutes', '^((?!api|admin|paymentHandler).)*$'); // except 'api' word
Route::get('paymentCallback/redirect', [
    'as' => 'paymentHandler.redirect',
    'uses' => 'PaymentHandler@redirect',
]);
Route::group([
], function () use ($dirs, $ignore) {
    foreach ($dirs as $dir) {
        foreach (app('files')->allFiles(__DIR__ . "/$dir") as $route_file) {
            $path = $route_file->getPathname();

            if (!\Illuminate\Support\Str::contains($path, $ignore)) {
                require $path;
            }
        }
    }
});

/* ----------------------------- without locale ----------------------------- */

foreach ($ignore as $file) {
    require __DIR__ . "/$file.php";
}

Route::post('/stripe/webhook', [
    'as' => 'stripe_webhook',
    'uses' => "StripeController@webhook"
]);