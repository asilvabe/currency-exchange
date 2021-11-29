<?php

use App\Http\Controllers\Api\ConvertCurrencyController;
use Illuminate\Support\Facades\Route;

Route::get('convert', ConvertCurrencyController::class)->name('api.convert');
