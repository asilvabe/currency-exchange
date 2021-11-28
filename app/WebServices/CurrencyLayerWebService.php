<?php

namespace App\WebServices;

use Illuminate\Support\Facades\Http;

class CurrencyLayerWebService
{
    private const SUPPORTED_CURRENCIES = 'BRL,COP,CNY,EUR,MXN,USD';

    public function getCurrentRates(string $source = null): array
    {
        return Http::get(
            config('currencylayer.base_url') . config('currencylayer.rates_endpoint'),
            [
                'access_key' => config('currencylayer.api_key'),
                'source' => $source,
                'currencies' => self::SUPPORTED_CURRENCIES,
            ]
        )->json();
    }
}
