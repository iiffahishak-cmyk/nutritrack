<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    */
     'openrouter' => [
      'key' => env('OPENROUTER_API_KEY'),
  ],

    'postmark' => [
        'key' => env('POSTMARK_API_KEY'),
    ],

    // ✅ FIXED — was: env('AIzaSyCDW...') — wrong, key goes in .env not here
    'gemini' => [
        'key' => env('GEMINI_API_KEY'),
    ],

    'resend' => [
        'key' => env('RESEND_API_KEY'),
    ],

    'ses' => [
        'key'    => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel'              => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

    // ✅ FIXED — was: env('29bbfe001...') — wrong, key goes in .env not here
    'spoonacular' => [
        'key' => env('SPOONACULAR_API_KEY'),
    ],
    'pexels' => [
    'key' => env('PEXELS_API_KEY'),
],

];