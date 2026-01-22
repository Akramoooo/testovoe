<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProductController;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// ЭНДПОИНТЫ
Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/{product}', [ProductController::class, 'show']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/products', [ProductController::class, 'store']);
    Route::patch('/products/{product}', [ProductController::class, 'update']);
    Route::delete('/products/{product}', [ProductController::class, 'destroy']);

});

Route::post('/login', [AuthController::class, 'login']);

Route::get('/categories', function () {
    return Category::all();
});

// SANTCUMш

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
