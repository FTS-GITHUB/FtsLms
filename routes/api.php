<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\NewsletterController;
use App\Http\Controllers\Auth\ForgotPasswordController;
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
Route::post('/forgot-password', [ForgotPasswordController::class, 'resetPasswordRequest']);

Route::post('/reset-password', [ForgotPasswordController::class, 'resetPassword'])->middleware('guest')->name('reset-password');
Route::post('/login', [AuthController::class, 'login']);

Route::group([
    'middleware' => 'auth:sanctum',
], function () {
});

/* ------------ AUTH ------------ */
require __DIR__.'/auth.php';

/* ------------ Roles & Permissions --------- */
require __DIR__.'/permissions.php';
Route::resource('/newsletter', NewsletterController::class);
Route::post('/un-subscribe', [NewsletterController::class, 'un_subscribe']);
