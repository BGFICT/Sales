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

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],
    'github' => [
        'client_id' => 'YOUR_GITHUB_API', //Github API
        'client_secret' => 'YOUR_GITHUB_SECRET', //Github Secret
        'redirect' => 'http://localhost:8000/login/github/callback',
     ],
     'google' => [
        'client_id' => env('GOOGLE_CLIENT_ID'),
        'client_secret' =>env('GOOGLE_CLIENT_SECRET'),
        'redirect' => 'http://localhost:8000/auth/google/callback',
        
        // 'client_id' => env('GOOGLE_APP_ID'),
        // 'client_secret' => env('GOOGLE_APP_SECRET'),
        // 'redirect' => env('GOOGLE_REDIRECT'),
     ],
     'facebook' => [
        'client_id' => '', //Facebook API
        'client_secret' => '', //Facebook Secret
        'redirect' => 'http://localhost:8000/login/facebook/callback',
     ],
     
     'mode'    => env('PAYPAL_MODE', 'sandbox'), // Can be 'sandbox' or 'live'

    'sandbox' => [
        'client_id'         => env('PAYPAL_SANDBOX_CLIENT_ID', ''),
        'client_secret'     => env('PAYPAL_SANDBOX_CLIENT_SECRET', ''),
        'app_id'            => env('PAYPAL_SANDBOX_APP_ID', ''),
    ],

    'live' => [
        'client_id'         => env('PAYPAL_LIVE_CLIENT_ID', ''),
        'client_secret'     => env('PAYPAL_LIVE_CLIENT_SECRET', ''),
        'app_id'            => env('PAYPAL_LIVE_APP_ID', ''),
    ],
    
    'payment_action' => 'Sale', // Can be 'Sale', 'Authorization', 'Order'
    'currency'       => env('PAYPAL_CURRENCY', 'USD'),
    'notify_url'     => '', // Change this accordingly for your application.
    'locale'         => env('PAYPAL_LOCALE', 'en_US'),
    'validate_ssl'   => env('PAYPAL_VALIDATE_SSL', true),

];
