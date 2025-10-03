<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Default Country
    |--------------------------------------------------------------------------
    |
    | This value is the default country code that will be used when validating
    | phone numbers. This should be a valid ISO 3166-1 alpha-2 country code.
    |
    */

    'default_country' => 'HN', // Honduras

    /*
    |--------------------------------------------------------------------------
    | Default Format
    |--------------------------------------------------------------------------
    |
    | This value is the default format that will be used when formatting
    | phone numbers. This should be a valid format string.
    |
    */

    'default_format' => 'E164',

    /*
    |--------------------------------------------------------------------------
    | Validation Rules
    |--------------------------------------------------------------------------
    |
    | These are the validation rules that will be applied to phone numbers.
    | You can customize these rules based on your requirements.
    |
    */

    'validation' => [
        'strict' => false,
        'lenient' => true,
    ],

    /*
    |--------------------------------------------------------------------------
    | Country-specific Rules
    |--------------------------------------------------------------------------
    |
    | These are country-specific validation rules. You can add custom rules
    | for specific countries here.
    |
    */

    'country_rules' => [
        'HN' => [
            'mobile' => true,
            'fixed_line' => false,
            'min_length' => 8,
            'max_length' => 8,
        ],
    ],
];
