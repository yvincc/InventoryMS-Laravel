<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\APIs\UserController;
use App\Http\Controllers\APIs\CategoryController;
use App\Http\Controllers\APIs\ProductController;


Route::post('auth', [UserController::class, 'auth']);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::resource('categories', CategoryController::class);
    Route::resource('products', ProductController::class);
    Route::get('products/category/{category_id}', [ProductController::class, 'getByCategory']);
});
