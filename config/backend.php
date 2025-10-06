<?php

return [
    //DON'T TEMPER WITH THE app_id value
    'app_id' => "31145802",
    //
    'colors' => [
        "pending" => "#18d3ec",
        "failed" => "#e45e5e",
        "completed" => "#11c58f",
        "successful" => "#11c58f",
        "delivered" => "#11c58f",
        "enroute" => "#086E7D",
        "ready" => "#4873f4",
        "review" => "#D67D3E",
    ],
    "languages" => [
        "Spanish",
        "English",
        "Portuguese"
    ],
    "languageCodes" => [
        "es",
        "en",
        "pt",
    ],
    "support" => [
        "email" => "info@edentech.online"
    ],
    "order" => [
        "statuses" => [
            "pending", "scheduled", "preparing", "ready", "enroute", "delivered", "failed", "cancelled",
            // 'pending', 'preparing', 'ready', 'enroute', 'delivered', 'failed', 'cancelled'
        ]
    ]
];
