<?php

namespace App\Http\Controllers;

use App\Actions\ConvertCurrency;
use App\Http\Controllers\Controller;
use App\Http\Requests\ConvertCurrencyFormRequest;
use Illuminate\Contracts\View\View;

class ConvertCurrencyController extends Controller
{
    public function __invoke(ConvertCurrency $converter, ConvertCurrencyFormRequest $request): View
    {
        return view('index', array_merge([
            'result' => $converter->execute($request->validated())
        ], $request->validated()));
    }
}
