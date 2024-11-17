<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RecipeController;
use App\Http\Controllers\AuthController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
Route::patch('/user/edit', [AuthController::class, 'editProfile'])->middleware('auth:sanctum');
Route::post('/user/forgot-password', [AuthController::class, 'forgotPassword']);

Route::apiResource('recipes', RecipeController::class);

Route::post('/recipes/{recipe}/like', [RecipeController::class, 'likeRecipe']);
Route::get('/recipes/{recipe}/likes-count', [RecipeController::class, 'getRecipeLikesCount']);

Route::post('/recipes/{recipe}/favorite', [RecipeController::class, 'favoriteRecipe']);
Route::get('/user/favorites', [RecipeController::class, 'getFavorites']);
