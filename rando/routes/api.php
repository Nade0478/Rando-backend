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
Route::get('/favorites/{favorite}', [FavoriteController::class, 'show']);
Route::put('/favorites/{favorite}', [FavoriteController::class, 'update']);
Route::delete('/favorites/{favorite}', [FavoriteController::class, 'destroy']);

Route::post('/favorites/toggle', [FavoriteController::class, 'toggleFavorite']);
Route::get('/users/{userId}/favorites', [FavoriteController::class, 'userFavorites']);
Route::get('/places/{placeId}/comments', [FavoriteController::class, 'placeComments']);

//Route pour Category
Route::apiResource('categories', CategoryController::class);
Route::get('/categories', [CategoryController::class, 'index']);

Route::post('/categories', [CategoryController::class, 'store']);
Route::get('/categories/{category}', [CategoryController::class, 'show']);
Route::put('/categories/{category}', [CategoryController::class, 'update']);
Route::delete('/categories/{category}', [CategoryController::class, 'destroy']);

//Route pour Opinion

Route::get('/opinions', [\App\Http\Controllers\API\OpinionController::class, 'index']);
Route::post('/opinions', [\App\Http\Controllers\API\OpinionController::class, 'store']);
Route::get('/opinions/{opinion}', [\App\Http\Controllers\API\OpinionController::class, 'show']);
Route::put('/opinions/{opinion}', [\App\Http\Controllers\API\OpinionController::class, 'update']);
Route::delete('/opinions/{opinion}', [\App\Http\Controllers\API\OpinionController::class, 'destroy']);
Route::get('/opinions/place/{placeId}', [\App\Http\Controllers\API\OpinionController::class, 'getOpinionsByPlace']);
Route::get('/opinions/user/{userId}', [\App\Http\Controllers\API\OpinionController::class, 'getOpinionsByUser']);
Route::get('/opinions/user/{userId}/place/{placeId}', [\App\Http\Controllers\API\OpinionController::class, 'getOpinionsByUserAndPlace']);
Route::get('/opinions/{opinion}/comments', [\App\Http\Controllers\API\OpinionController::class, 'getCommentsByOpinion']);
Route::post('/opinions/{opinion}/comments', [\App\Http\Controllers\API\OpinionController::class, 'addCommentToOpinion']);

//Route pour Place
Route::get('/places', [\App\Http\Controllers\API\PlaceController::class, 'index']);
Route::post('/places', [\App\Http\Controllers\API\PlaceController::class, 'store']);
Route::get('/places/{place}', [\App\Http\Controllers\API\PlaceController::class, 'show']);
Route::put('/places/{place}', [\App\Http\Controllers\API\PlaceController::class, 'update']);
Route::delete('/places/{place}', [\App\Http\Controllers\API\PlaceController::class, 'destroy']);
Route::get('/places/category/{categoryId}', [\App\Http\Controllers\API\PlaceController::class, 'getPlacesByCategory']);

Route::get('/places/home', [\App\Http\Controllers\API\PlaceController::class, 'indexHome']);
Route::get('/places/{place}/favorites', [\App\Http\Controllers\API\PlaceController::class, 'getFavoritesByPlace']);
Route::get('/places/{place}/opinions', [\App\Http\Controllers\API\PlaceController::class, 'getOpinionsByPlace']);
Route::get('/places/{place}/comments', [\App\Http\Controllers\API\PlaceController::class, 'getCommentsByPlace']);
Route::post('/places/{place}/upload-image', [\App\Http\Controllers\API\PlaceController::class, 'uploadImage']);
Route::get('/places/{place}/images', [\App\Http\Controllers\API\PlaceController::class, 'getImagesByPlace']);
Route::post('/places/{place}/upload-map', [\App\Http\Controllers\API\PlaceController::class, 'uploadMap']);
Route::get('/places/{place}/map', [\App\Http\Controllers\API\PlaceController::class, 'getMapByPlace']);
//Route pour Article
Route::apiResource('articles', \App\Http\Controllers\API\ArticleController::class);
Route::get('/articles', [\App\Http\Controllers\API\ArticleController::class, 'index']);
Route::get('/articles/home', [\App\Http\Controllers\API\ArticleController::class, 'indexHome']);
Route::post('/articles', [\App\Http\Controllers\API\ArticleController::class, 'store']);
Route::get('/articles/{article}', [\App\Http\Controllers\API\ArticleController::class, 'show']);
Route::put('/articles/{article}', [\App\Http\Controllers\API\ArticleController::class, 'update']);
Route::delete('/articles/{article}', [\App\Http\Controllers\API\ArticleController::class, 'destroy']);
Route::get('/articles/category/{categoryId}', [\App\Http\Controllers\API\ArticleController::class, 'getArticlesByCategory']);
Route::get('/articles/{article}/comments', [\App\Http\Controllers\API\ArticleController::class, 'getCommentsByArticle']);
Route::post('/articles/{article}/comments', [\App\Http\Controllers\API\ArticleController::class, 'addCommentToArticle']);
Route::post('/articles/{article}/upload-image', [\App\Http\Controllers\API\ArticleController::class, 'uploadImage']);
Route::get('/articles/{article}/images', [\App\Http\Controllers\API\ArticleController::class, 'getImagesByArticle']);
//Route pour Role
Route::apiResource('roles', \App\Http\Controllers\API\RoleController::class);
Route::get('/roles', [\App\Http\Controllers\API\RoleController::class, 'index']);

Route::post('/roles', [\App\Http\Controllers\API\RoleController::class, 'store']);
Route::get('/roles/{role}', [\App\Http\Controllers\API\RoleController::class, 'show']);
Route::put('/roles/{role}', [\App\Http\Controllers\API\RoleController::class, 'update']);
Route::delete('/roles/{role}', [\App\Http\Controllers\API\RoleController::class, 'destroy']);