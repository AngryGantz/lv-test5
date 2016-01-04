<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, Mandrill, and others. This file provides a sane
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
    ],

    'mandrill' => [
        'secret' => env('MANDRILL_SECRET'),
    ],

    'ses' => [
        'key'    => env('SES_KEY'),
        'secret' => env('SES_SECRET'),
        'region' => 'us-east-1',
    ],

    'stripe' => [
        'model'  => App\User::class,
        'key'    => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
    ],

    'facebook' => [
        'client_id' => '722824941186073',
        'client_secret' => '15e102eb982c191e33d9a69ad0ac6a9c',
        'redirect' => 'http://lv-test5.mychefs.ru/socialite/facebook/callback',
    ],

    'twitter' => [
        'client_id' => '1QgPX2sx8kBLcdLFwusU1qEf7',
        'client_secret' => 'LLnyhST6DtseuCbVBFibGkmMPPTslxwucc198Gq20tGPiOBraW',
        'redirect' => 'http://lv-test5.mychefs.ru/socialite/twitter/callback',
    ],

    'vkontakte' => [
        'client_id' => '5208962',
        'client_secret' => 'qXoMtOvzVyqjLff1h6OX',
        'redirect' => 'http://lv-test5.mychefs.ru/socialite/vkontakte/callback',
    ],
];
