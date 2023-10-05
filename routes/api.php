<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthenticationController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\ReferralController;

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

Route::group(['prefix' => 'auth'], function() {
    Route::post('login', [AuthenticationController::class, 'login'])->name('login');
    Route::post('register', [AuthenticationController::class, 'register'])->name('register');
    Route::post('logout', [AuthenticationController::class, 'logout'])->middleware('auth:sanctum')->name('logout');
});


Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('me', [UserController::class, 'me'])->name('user.me');

    Route::group(['prefix' => 'referrals'], function() {
        Route::get('/', [ReferralController::class, 'index'])->name('referrals.index');
        Route::post('/invite', [ReferralController::class, 'store'])->name('referrals.store');
        Route::get('/me', [ReferralController::class, 'show'])->name('referrals.show');
    });
});