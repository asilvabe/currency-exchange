<?php

use App\Http\Controllers\ConvertCurrencyController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index');
});

Route::post('/', ConvertCurrencyController::class)->name('convert');
