<?php

use App\Http\Controllers\CalculatorController;
use Illuminate\Support\Facades\Route;
use App\Models\Calculation;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    $calculations = Calculation::all();
    return view('welcome', ['calculations' => $calculations]);
});

Route::post('/calculate', [CalculatorController::class, 'calculate']);
Route::delete('/calculations/{id}', [CalculatorController::class, 'destroy'])->name('calculations.destroy');
Route::get('/calculator', [CalculatorController::class, 'showCalculator'])->name('calculator.show');
