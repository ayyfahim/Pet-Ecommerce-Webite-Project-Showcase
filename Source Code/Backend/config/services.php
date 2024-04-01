<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, SparkPost and others. This file provides a sane
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
    |
    */

    /* --------------------------------- mail -------------------------------- */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
    ],

    'ses' => [
        'key'    => env('SES_KEY'),
        'secret' => env('SES_SECRET'),
        'region' => env('SES_REGION', 'us-east-1'),
    ],

    'sparkpost' => [
        'secret' => env('SPARKPOST_SECRET'),
    ],

    /* --------------------------------- social -------------------------------- */

    'google' => [
        'client_id'     => env('GOOGLE_CLIENT_ID', "519358372432-3hin422ksmdl36fi5s02823kt5o9amf4.apps.googleusercontent.com"),
        'client_secret' => env('GOOGLE_CLIENT_SECRET', "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"),
        'redirect'      => env('GOOGLE_CALLBACK_URL', config('app.frontend_url') . '/login'),
    ],

    'facebook' => [
        'client_id'     => env('FACEBOOK_KEY', "995428685049725"),
        'client_secret' => env('FACEBOOK_SECRET', "149b857bf0b6a7591b65fa0bef0e771b"),
        'redirect'      => env('FACEBOOK_REDIRECT_URI', config('app.frontend_url') . '/login'),
    ],

    /* --------------------------------- payment -------------------------------- */

    'stripe' => [
        'model'  => App\User::class,
        'key'    => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
    ],

    /* --------------------------------- sms -------------------------------- */

    'twilio' => [
        'username'    => env('TWILIO_USERNAME'), // optional when using auth token
        'password'    => env('TWILIO_PASSWORD'), // optional when using auth token
        'auth_token'  => env('TWILIO_AUTH_TOKEN'), // optional when using username and password
        'account_sid' => env('TWILIO_ACCOUNT_SID'),
        'from'        => env('TWILIO_FROM'), // optional
    ],

    'slack' => [
        'webhook_url' => env('SLACK_HOOK'),
    ],
];
