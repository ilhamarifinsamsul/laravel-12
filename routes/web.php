<?php

use Illuminate\Support\Facades\Route;

// Import product controller
use App\Http\Controllers\ProductController;

// route resource for product
Route::resource('/products', ProductController::class);

Route::get('/', function () {
    return view('welcome');
});
