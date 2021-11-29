<?php

namespace App\Http\Controllers\Api;

use App\Actions\ConvertCurrency;
use App\Http\Controllers\Controller;
use App\Http\Requests\ConvertCurrencyApiRequest;
use Illuminate\Http\JsonResponse;

class ConvertCurrencyController extends Controller
{
    public function __invoke(ConvertCurrency $converter, ConvertCurrencyApiRequest $request): JsonResponse
    {
        return response()->json([
            'success' => true,
            'result' => $converter->execute($request->validated()),
        ]);
    }
}
