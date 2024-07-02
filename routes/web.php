<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;

// Route::get('/', function () {
//     return view('welcome');
// });


Route::get('/', [ProductController::class, 'index']);
Route::post('/order', [OrderController::class, 'store'])->name('order.store');

