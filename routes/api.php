<?php

use App\Http\Controllers\Api\V1\CalculatorController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\PassportAuthController;

/* Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
}); */

Route::post('register', [PassportAuthController::class, 'register']);
Route::post('login', [PassportAuthController::class, 'login']);

Route::group([
    'middleware' => 'auth:api',
    'prefix'     => 'calculator'
], function () {
    Route::post('/calculate', [CalculatorController::class, 'calculate']);
    Route::get('/history', [CalculatorController::class, 'calculatorHistory']);
});
