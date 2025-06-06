<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    // 'ses' => [
    //     'key' => env('AWS_ACCESS_KEY_ID'),
    //     'secret' => env('AWS_SECRET_ACCESS_KEY'),
    //     'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    // ],
    // 'github' => [
    //     'client_id' => 'YOUR_GITHUB_API', //Github API
    //     'client_secret' => 'YOUR_GITHUB_SECRET', //Github Secret
    //     'redirect' => 'http://localhost:8000/login/github/callback',
    //  ],
    'google' => [
     'client_id' => env('GOOGLE_CLIENT_ID'),
     'client_secret' => env('GOOGLE_CLIENT_SECRET'),
     'redirect' => env('GOOGLE_REDIRECT_URL'),
    ],

    // 'midtrans' => [
    //     'server_key' => env('MIDTRANS_SERVER_KEY'),
    //     'client_key' => env('MIDTRANS_CLIENT_KEY'),
    //     'is_production' => env('MIDTRANS_IS_PRODUCTION', false),
    //     'is_sanitized' => env('MIDTRANS_IS_SANITIZED', true),
    //     'is_3ds' => env('MIDTRANS_IS_3DS', true),
    // ],

    //  'facebook' => [
    //     'client_id' => 'YOUR_FACEBOOK_API', //Facebook API
    //     'client_secret' => 'YOUR_FACEBOK_SECRET', //Facebook Secret
    //     'redirect' => 'http://localhost:8000/login/facebook/callback',
    //  ],

];
