<?php

Route::group([
    'as'         => 'verification.',
    'namespace'  => 'Auth\Web',
], function () {
    /* --------------------------------- email --------------------------------- */
    Route::get('user/verify', [
        'uses' => 'VerificationController@show',
        'as'   => 'notice',
    ]);

    Route::get('email/verify/{id}', [
        'uses' => 'VerificationController@verify',
        'as'   => 'verify',
    ]);

    Route::get('user/email/resend', [
        'uses' => 'VerificationController@resend',
        'as'   => 'resend',
    ]);

    /* --------------------------------- mobile --------------------------------- */
    Route::post('user/mobile/verify', [
        'uses' => 'VerificationController@verifyMobile',
        'as'   => 'notice.mobile',
    ]);

    Route::patch('user/mobile/resend/{id}', [
        'uses' => 'VerificationController@resendMobileVerificationCode',
        'as'   => 'resend.mobile',
    ]);
});
