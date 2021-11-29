<?php

namespace Tests\Unit;

use App\Actions\ConvertCurrency;
use Closure;
use Illuminate\Support\Facades\Cache;
use PHPUnit\Framework\TestCase;

class ConvertCurrencyActionTest extends TestCase
{
    /**
     * @test
     * @dataProvider dataProvider
     * */
    public function it_converts_between_different_currencies($input, $inputValue): void
    {
        Cache::shouldReceive('rememberForever')
            ->with('convert_rates', Closure::class)
            ->andReturn([
                'USDCOP' => 4000,
                'USDEUR' => 0.5,
            ]);

        $converter = new ConvertCurrency();
        $result = $converter->execute($input);
        $this->assertEquals($inputValue, $result);
    }

    public function dataProvider()
    {
        return [
            'Converts from USD to any currency' => [
                'input' => ['from' => 'USD', 'to' => 'COP', 'amount' => 1],
                'result' => 4000
            ],

            'Converts from any currency to USD' => [
                'input' => ['from' => 'COP', 'to' => 'USD', 'amount' => 4000],
                'result' => 1
            ],

            'Converts between different currencies' => [
                'input' => ['from' => 'EUR', 'to' => 'COP', 'amount' => 1],
                'result' => 8000
            ],
        ];
    }
}
