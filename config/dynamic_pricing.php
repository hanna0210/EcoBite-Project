<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Dynamic Pricing Configuration
    |--------------------------------------------------------------------------
    |
    | This file contains the configuration options for the dynamic pricing
    | system in EcoMueve.
    |
    */

    /*
    |--------------------------------------------------------------------------
    | Enable Dynamic Pricing
    |--------------------------------------------------------------------------
    |
    | Set to true to enable dynamic pricing system globally.
    | Individual vendors can still be configured separately.
    |
    */
    'enabled' => env('DYNAMIC_PRICING_ENABLED', false),

    /*
    |--------------------------------------------------------------------------
    | Default Multipliers
    |--------------------------------------------------------------------------
    |
    | Default multiplier values when no specific rules apply.
    |
    */
    'default_multipliers' => [
        'base' => 1.0,
        'distance' => 1.0,
        'time' => 1.0,
    ],

    /*
    |--------------------------------------------------------------------------
    | Multiplier Bounds
    |--------------------------------------------------------------------------
    |
    | Global bounds for all multipliers to prevent extreme pricing.
    |
    */
    'multiplier_bounds' => [
        'min' => 0.5,
        'max' => 3.0,
    ],

    /*
    |--------------------------------------------------------------------------
    | Demand Thresholds
    |--------------------------------------------------------------------------
    |
    | Default demand level thresholds (orders per hour).
    |
    */
    'demand_thresholds' => [
        'low' => 5,
        'medium' => 15,
        'high' => 30,
        'critical' => 50,
    ],

    /*
    |--------------------------------------------------------------------------
    | Cache Settings
    |--------------------------------------------------------------------------
    |
    | Cache settings for demand level calculations.
    |
    */
    'cache' => [
        'demand_level_ttl' => 300, // 5 minutes
        'pricing_rules_ttl' => 600, // 10 minutes
    ],

    /*
    |--------------------------------------------------------------------------
    | Analytics Settings
    |--------------------------------------------------------------------------
    |
    | Settings for pricing analytics and tracking.
    |
    */
    'analytics' => [
        'enabled' => true,
        'retention_days' => 90,
        'batch_size' => 1000,
    ],

    /*
    |--------------------------------------------------------------------------
    | Weather Integration
    |--------------------------------------------------------------------------
    |
    | Settings for weather-based pricing (if implemented).
    |
    */
    'weather' => [
        'enabled' => false,
        'api_key' => env('WEATHER_API_KEY'),
        'api_url' => 'https://api.openweathermap.org/data/2.5/weather',
    ],

    /*
    |--------------------------------------------------------------------------
    | Event Detection
    |--------------------------------------------------------------------------
    |
    | Settings for special event detection and pricing.
    |
    */
    'events' => [
        'enabled' => false,
        'sources' => [
            // Add event data sources here
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Notification Settings
    |--------------------------------------------------------------------------
    |
    | Settings for dynamic pricing notifications.
    |
    */
    'notifications' => [
        'price_increase_threshold' => 50, // Percentage
        'notify_vendors' => true,
        'notify_customers' => true,
    ],

    /*
    |--------------------------------------------------------------------------
    | Testing Settings
    |--------------------------------------------------------------------------
    |
    | Settings for testing and development.
    |
    */
    'testing' => [
        'enabled' => env('APP_ENV') === 'testing',
        'mock_demand_level' => null, // Set to 0-3 to mock demand level
        'mock_weather' => 'clear',
    ],
];
