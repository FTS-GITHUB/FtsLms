<?php

use App\Http\Controllers\Api\NewsletterController;
use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Auth\{ForgotPasswordController};
use Illuminate\Http\Request;
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

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('/forgot-password', [ForgotPasswordController::class, 'resetPasswordRequest'])->middleware('guest')->name('password.email');
Route::post('/reset-password', [ForgotPasswordController::class, 'resetPassword'])->middleware('guest')->name('reset-password');
Route::group([
    'middleware' => 'auth:sanctum',
], function () {
    Route::resource('/users', UserController::class);
    Route::resource('/roles', RoleController::class);
    Route::resource('/newsletter', NewsletterController::class);
});

require __DIR__.'/auth.php';
// require __DIR__ . '/permissions.php';
