<?php

use App\Http\Controllers\Api\BlogController;
use App\Http\Controllers\Api\CommentController;
use App\Http\Controllers\Api\IslamicShortStoryController;
use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group([
    'middleware' => 'auth:sanctum',
], function () {
    Route::apiResource('/users', UserController::class);
    Route::apiResource('/roles', RoleController::class);
    Route::apiResource('/blogs', BlogController::class);
    Route::apiResource('/islamic_short_stories', IslamicShortStoryController::class);

    Route::post('/replies', [CommentController::class, 'replies']);
    Route::apiResource('/comments', CommentController::class)->only([
        'index', 'store',
    ]);
    Route::post('/approved/{id}', [BlogController::class, 'approved']);
});
