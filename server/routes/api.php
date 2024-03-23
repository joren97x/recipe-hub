<?php

use App\Models\Recipe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\RecipeController;
use App\Http\Controllers\UserController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::group(['middleware' => 'auth:sanctum'], function() {
    Route::apiResource('users', UserController::class);
    Route::post('/recipes/{recipe}/like', [LikeController::class, 'like']);
    Route::apiResource('recipes', RecipeController::class);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/users/{user}/recipes', [UserController::class, 'user_recipes']);
});

Route::apiResource('recipes', RecipeController::class)->only(['index', 'show']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);