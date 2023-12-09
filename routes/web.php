<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Web\CalculatorController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('calculator');
});

Route::post('/calculate',[CalculatorController::class, 'calculate'])->name('calculate');
