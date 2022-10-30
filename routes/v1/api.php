<?php

use App\Http\Controllers\Api\v1\Auth\LoginController;
use App\Http\Controllers\Api\v1\Auth\LogoutController;
use App\Http\Controllers\Api\v1\Auth\RefreshTokenController;
use App\Http\Controllers\Api\v1\Auth\RegisterController;
use App\Http\Controllers\Api\v1\Auth\ResendVerifyController;
use App\Http\Controllers\Api\v1\Auth\VerifyEmailController;
use App\Http\Controllers\Api\v1\UserController;
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

Route::post('/register', [RegisterController::class, 'register']);
Route::post('login', [LoginController::class, 'loginWithPassword']);
Route::post('login-email-otp', [LoginController::class, 'loginEmailOtp']);

Route::get('/email/verify-email/{id}', [VerifyEmailController::class, 'verify'])
    ->name('verification.verify');
Route::post('/email/verification-resend', [ResendVerifyController::class, 'resendEmail']);
Route::get('verify-login/{token}', [LoginController::class, 'verifyLoginOtp'])
    ->name('verify-login');

Route::middleware(['auth:api', 'jwt.verify'])->group(
    function () {
        Route::get('logout', [LogoutController::class, 'logout']);
        Route::post('refresh-token', [RefreshTokenController::class, 'refreshToken']);
        Route::get('user-profile', [UserController::class, 'getProfile']);
    }
);
