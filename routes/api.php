<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\AuthController;

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

Route::group(['prefix' => 'auth'], function ($router) {
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/register', [AuthController::class, 'register'])->name('register');
    // Route::group(['middleware' => ['auth:sanctum']], function () {
    //     Route::post('/logout', [AuthController::class, 'logout']);
    //     Route::get('/current-user', [AuthController::class, 'getUser']);
    //     Route::post('/change-password', [AuthController::class, 'changePassword']);
    // });
});

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group(['middleware' => ['auth:sanctum', 'check-permission', 'log-request']], function () {
    Route::group(['prefix' => '/users'], function() {
        Route::get('/', [UserController::class, 'index'])->name('user.index');
    });
});
