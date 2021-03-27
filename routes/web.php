<?php

use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Route;

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
    return view('welcome');
});
Route::get('/payments', [PaymentController::class, 'index'])->name('payments.show');
Route::delete('/payments', [PaymentController::class, 'destroy'])->name('payments.delete');
Route::get('/payments/add', [PaymentController::class, 'create'])->name('payments.add');
Route::post('/payments/add', [PaymentController::class, 'store'])->name('payments.store');
