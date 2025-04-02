<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

// Import product controller
use App\Http\Controllers\ProductController;

// Auth Routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/products', function(){
    return view('products.index');
})->name('products.index');

// route resource for product
Route::resource('/products', ProductController::class);

// Protected Routes
// Route::middleware('auth')->group(function () {
//     Route::get('/products', function(){
//         return view('products.index');
//     })->name('products.index');
// });

Route::get('/', function () {
    return view('welcome');
});
