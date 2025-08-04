<?php

use App\Http\Controllers\API\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\FavoriteController;
use App\Http\Controllers\API\CategoryController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
    });
    Route::apiResource("users", UserController::class);

    //Route pour Favorite
    Route::apiResource('favorites', FavoriteController::class);
    Route::get('/favorites', [FavoriteController::class, 'index']);
Route::post('/favorites', [FavoriteController::class, 'store']);
Route::get('/favorites/{at_Favorite}', [FavoriteController::class, 'show']);
Route::put('/favorites/{at_Favorite}', [FavoriteController::class, 'update']);
Route::delete('/favorites/{at_Favorite}', [FavoriteController::class, 'destroy']);

Route::post('/favorites/toggle', [FavoriteController::class, 'toggleFavorite']);
Route::get('/users/{userId}/favorites', [FavoriteController::class, 'userFavorites']);
Route::get('/places/{placeId}/comments', [FavoriteController::class, 'placeComments']);