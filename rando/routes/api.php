<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\OpinionController;
use App\Http\Controllers\PlaceController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;









// Route protégée pour récupérer l'utilisateur connecté
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Users
Route::apiResource('users', UserController::class);

// Favorites
Route::apiResource('favorites', FavoriteController::class);
Route::post('/favorites/toggle', [FavoriteController::class, 'toggleFavorite']);
Route::get('/users/{userId}/favorites', [FavoriteController::class, 'userFavorites']);
Route::get('/places/{placeId}/comments', [FavoriteController::class, 'placeComments']);

// Categories
Route::apiResource('categories', CategoryController::class);

// Opinions
Route::apiResource('opinions', OpinionController::class);
Route::get('/opinions/place/{placeId}', [OpinionController::class, 'getOpinionsByPlace']);
Route::get('/opinions/user/{userId}', [OpinionController::class, 'getOpinionsByUser']);
Route::get('/opinions/user/{userId}/place/{placeId}', [OpinionController::class, 'getOpinionsByUserAndPlace']);
Route::get('/opinions/{opinion}/comments', [OpinionController::class, 'getCommentsByOpinion']);
Route::post('/opinions/{opinion}/comments', [OpinionController::class, 'addCommentToOpinion']);

// Places
Route::apiResource('places', PlaceController::class);
Route::get('/places/category/{categoryId}', [PlaceController::class, 'getPlacesByCategory']);
Route::get('/places/home', [PlaceController::class, 'indexHome']);
Route::get('/places/{place}/favorites', [PlaceController::class, 'getFavoritesByPlace']);
Route::get('/places/{place}/opinions', [PlaceController::class, 'getOpinionsByPlace']);
Route::get('/places/{place}/comments', [PlaceController::class, 'getCommentsByPlace']);
Route::post('/places/{place}/upload-image', [PlaceController::class, 'uploadImage']);
Route::get('/places/{place}/images', [PlaceController::class, 'getImagesByPlace']);
Route::post('/places/{place}/upload-map', [PlaceController::class, 'uploadMap']);
Route::get('/places/{place}/map', [PlaceController::class, 'getMapByPlace']);

// Articles
Route::apiResource('articles', ArticleController::class);
Route::get('/articles/home', [ArticleController::class, 'indexHome']);
Route::get('/articles/category/{categoryId}', [ArticleController::class, 'getArticlesByCategory']);
Route::get('/articles/{article}/comments', [ArticleController::class, 'getCommentsByArticle']);
Route::post('/articles/{article}/comments', [ArticleController::class, 'addCommentToArticle']);
Route::post('/articles/{article}/upload-image', [ArticleController::class, 'uploadImage']);
Route::get('/articles/{article}/images', [ArticleController::class, 'getImagesByArticle']);

// Roles
Route::apiResource('roles', RoleController::class);
