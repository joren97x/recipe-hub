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
    Route::put('/change-password', [UserController::class, 'change_password']);
    Route::put('/update-name-email/{user}', [UserController::class, 'update_name_email']);
    Route::get('/users/{user}/recipes', [UserController::class, 'user_recipes']);
    Route::post('/upload', function(Request $request) {
        $request->validate([
            'file' => 'required',
        ]);
        $request->file->move(public_path('/images'), $request->file->getClientOriginalName());
        return response(['message' => 'File uploaded'], 200);
    });
});

Route::get('/search/{q}', [RecipeController::class, 'search']);
Route::apiResource('recipes', RecipeController::class)->only(['index', 'show']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

