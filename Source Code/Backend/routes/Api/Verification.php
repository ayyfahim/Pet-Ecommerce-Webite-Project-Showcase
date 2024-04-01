<?php

Route::group([
    'prefix'    => 'user',
    'namespace' => 'Auth\Api',
], function () {
    /* --------------------------------- email --------------------------------- */
    Route::get('email/verify/{id}', 'VerificationController@verify');
    Route::get('email/resend', 'VerificationController@resend');

    /* --------------------------------- mobile --------------------------------- */
    Route::post('mobile/verify', 'VerificationController@verifyMobile');
    Route::patch('mobile/resend', 'VerificationController@resendMobileVerificationCode');
});
