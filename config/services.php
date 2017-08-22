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
    'google' => [
        'client_id' => '420447498805-4obhhg2ob5rcn3s1nujiddo59vq5j756.apps.googleusercontent.com',
        'client_secret' => 'sfEaRXmFzP7rl8nO5C19zjte',
        'redirect' => 'http://localhost:8000/auth/google/callback',
    ],
    'facebook' => [
       'client_id'         =>  '112091552794910',
       'client_secret'     =>  '882e08356a7ab29eb3668beeaf7e4958',
       'redirect'          =>  'http://localhost:8000/auth/facebook/callback',
   ],
   'twitter' => [ //change it to any provider
       'client_id' => 'pW509hmmknmTsnN3Oys9DWWn7',
       'client_secret' => 'rJfMiGzeURP1dhrAXPzOSRfphjerk5SL7UreYaresJkABS2RRD',
       'redirect' => 'http://localhost:8000/auth/twitter/callback',
    ],

];
