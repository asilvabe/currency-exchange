<?php

namespace Tests\Feature;

use Closure;
use Illuminate\Support\Facades\Cache;
use Tests\TestCase;

class ConvertCurrencyApiTest extends TestCase
{
    private const ROUTE = 'api.convert';

    private const TEST_DATA = [
        'from' => 'USD',
        'to' => 'COP',
        'amount' => 1,
    ];

    protected function setUp(): void
    {
        parent::setUp();

        Cache::shouldReceive('rememberForever')
            ->with('convert_rates', Closure::class)
            ->andReturn(['USDCOP' => 4000]);
    }

    /** @test */
    public function the_convert_endpoint_works(): void
    {
        $response = $this->get(route(self::ROUTE, self::TEST_DATA));
        $response->assertStatus(200);
    }

    /** @test */
    public function it_converts_currencies(): void
    {
        $response = $this->get(route(self::ROUTE, self::TEST_DATA));

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'result' => 4000,
            ]);
    }

    /**
     * @test
     * @dataProvider apiParamsValidationProvider
     * */
    public function it_validates_the_input_params($input, $inputValue): void
    {
        $response = $this->get(route(self::ROUTE, [$input => $inputValue]));

        $response->assertStatus(422)
            ->assertJsonValidationErrors($input);
    }

    public function apiParamsValidationProvider()
    {
        return [
            'Test from is required' => ['from', ''],
            'Test to is required' => ['to', ''],
            'Test amount is required' => ['amount', ''],
            'Test from current is in supported currencies' => ['from', 'NOT_SUPPORTED'],
            'Test to current is in supported currencies' => ['to', 'NOT_SUPPORTED'],
            'Test amount must be numeric' => ['amount', 'NOT_NUMERIC_VALUE'],
        ];
    }
}
