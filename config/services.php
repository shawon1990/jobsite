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

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
    ],

    'ses' => [
        'key' => env('SES_KEY'),
        'secret' => env('SES_SECRET'),
        'region' => 'us-east-1',
    ],

    'sparkpost' => [
        'secret' => env('SPARKPOST_SECRET'),
    ],

    'stripe' => [
        'model' => App\User::class,
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
    ],

    /**
     * Development
     */
//    'facebook' => [
//        'client_id' => '535092080280098',
//        'client_secret' =>'445746a4383fa7c04215a3700d0f1018',
//        'redirect' => 'http://localhost/valere/forum/callback',
//    ],
//
//    'google' => [
//        'client_id'     => '121180934831-arjjafpi40qcmbrvjnmrukc3jt97cp8o.apps.googleusercontent.com',
//        'client_secret' => 'aP4t3yih5MBcWl34QmsEDrC0',
//        'redirect'      => 'http://localhost/valere/forum/gmail/callback'
//    ],


    /**
     * Live
     */
    'facebook' => [
        'client_id' => '305183686699785',
        'client_secret' => '5d3e8db505208c152fedbb5a3a8f0cc1',
        'redirect' => 'https://valerejobs.com/forum/callback',
    ],

    'google' => [
        'client_id'     => '310334492390-47tms80bc7ckl6ebdv4ab0a6lbbliltd.apps.googleusercontent.com',
        'client_secret' => 'sFtWb2hxGR08EY-CkjNcA76J',
        'redirect'      => 'https://valerejobs.com/forum/gmail/callback'
    ],
];
