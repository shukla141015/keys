<?php

return [

    'admin_email' => env('ADMIN_EMAIL', 'admin@example.com'),

    '*' => [
        'max_page' => '904625697166532776746648320380374280100293470930272690489102837043110636675',
    ],

    'btc' => [
        // 128 keys per page.
        'max_page' => '904625697166532776746648320380374280100293470930272690489102837043110636675',
    ],

    'eth' => [
        // 128 keys per page.
        'max_page' => '904625697166532776746648320380374280100293470930272690489102837043110636675',
    ],

    'enable_page_number_hardcoded_check' => env('KEYS_ENABLE_PAGE_NUMBER_HARDCODED_CHECK', false),

    'recaptcha_site_key' => env('RECAPTCHA_V2_SITE_KEY'),
    'recaptcha_secret_key' => env('RECAPTCHA_V2_SECRET_KEY'),

];
