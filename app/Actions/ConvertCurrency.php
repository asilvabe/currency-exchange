<?php

namespace App\Actions;

use App\WebServices\CurrencyLayerWebService;
use Illuminate\Support\Facades\Cache;

class ConvertCurrency
{
    public function execute(array $params): float
    {
        $from = $params['from'];
        $to = $params['to'];
        $amount = $params['amount'];

        if ($from == 'USD' || $to == 'USD') {
            return $from == 'USD'
                ? $this->fromUSDToAny($to, $amount)
                : $this->fromAnyToUSD($from, $amount);
        }

        $intermediateAmount = $this->fromAnyToUSD($from, $amount);
        return $this->fromUSDToAny($to, $intermediateAmount);
    }

    private function fromUSDToAny(string $to, float $amount): float
    {
        $quote = $this->getConvertRates()['USD'.$to];
        return (float) $quote * $amount;
    }

    private function fromAnyToUSD(string $from, float $amount): float
    {
        $quote = $this->getConvertRates()['USD'.$from];
        return (float) $amount / $quote;
    }

    private function getConvertRates(): array
    {
        return Cache::rememberForever('convert_rates', function () {
            return CurrencyLayerWebService::getCurrentRates();
        });
    }
}
