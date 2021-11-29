<?php

namespace App\WebServices;

use Illuminate\Support\Facades\Http;

class CurrencyLayerWebService
{
    public static function getCurrentRates(): array
    {
        return Http::get(
            config('currencylayer.base_url').config('currencylayer.rates_endpoint'),
            [
                'access_key' => config('currencylayer.api_key'),
            ]
        )['quotes'];
    }
}
