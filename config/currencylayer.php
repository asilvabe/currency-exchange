<?php

return [
    'api_key' => env('CURRENCY_LAYER_API_KEY'),
    'base_url' => env('CURRENCY_LAYER_BASE_URL', 'http://api.currencylayer.com/'),
    'rates_endpoint' => env('CURRENCY_LAYER_RATES_ENDPOINT', 'live'),
];
