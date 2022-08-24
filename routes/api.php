<?php

use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\RegisteredUserController;
use App\Http\Controllers\Api\AuthenticatedSessionController;
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

Route::middleware(['auth:sanctum'])->group(function () {

    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');

    Route::apiResource('users', UserController::class)->only(['index', 'show']);
});

Route::middleware('guest')->group(function () {

    Route::post('register', [RegisteredUserController::class, 'store']);

    Route::post('login', [AuthenticatedSessionController::class, 'store']);

    // Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
    //     ->name('password.email');

    // Route::post('reset-password', [NewPasswordController::class, 'store'])
    //     ->name('password.update');
});
