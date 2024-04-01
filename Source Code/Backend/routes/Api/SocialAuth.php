<?php

Route::group([
    'prefix'    => 'auth/social',
    'namespace' => 'Auth\Api',
], function () {
    Route::post('/', 'SocialLoginController@getUserBySocial');
});
