<?php

Route::group([
    'prefix'    => 'auth/social',
    'namespace' => 'Auth\Web',
], function () {
    Route::get('{provider}', 'SocialLoginController@redirectToProvider')->name('login_by_social');
    Route::get('{provider}/callback', 'SocialLoginController@handleProviderCallback');
});
