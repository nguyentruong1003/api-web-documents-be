<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\RoleController;
use App\Http\Controllers\API\PermissionController;
use App\Http\Controllers\API\MasterDataController;
use App\Http\Controllers\API\AuditController;
use App\Http\Controllers\API\PostController;

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
    Route::group(['middleware' => ['auth:sanctum']], function () {
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::get('/current-user', [AuthController::class, 'getUser']);
        Route::post('/change-password', [AuthController::class, 'changePassword']);
    });
});

Route::group(['middleware' => ['auth:sanctum', 'check-permission', 'log-request']], function () {
    Route::group(['prefix' => '/users'], function() {
        Route::get('/', [UserController::class, 'index'])->name('user.index');
        Route::post('/', [UserController::class, 'create'])->name('user.create');
        Route::get('/{user:id}', [UserController::class, 'show'])->name('user.show');
        Route::post('/{user:id}', [UserController::class, 'edit'])->name('user.edit');
        Route::delete('/{user:id}', [UserController::class, 'delete'])->name('user.delete');
    });

    Route::group(['prefix' => '/roles'], function () {
        Route::get('/', [RoleController::class, 'index'])->name('role.index');
        Route::post('/', [RoleController::class, 'create'])->name('role.create');
        Route::get('/{role:id}', [RoleController::class, 'show'])->name('role.show');
        Route::post('/{role:id}', [RoleController::class, 'edit'])->name('role.edit');
        Route::delete('/{role:id}', [RoleController::class, 'delete'])->name('role.delete');
    });

    Route::group(['prefix' => '/permissions'], function () {
        Route::get('/', [PermissionController::class, 'index'])->name('permission.index');
        Route::post('/', [PermissionController::class, 'create'])->name('permission.create');
        Route::get('/{permission:id}', [PermissionController::class, 'show'])->name('permission.show');
        Route::post('/{permission:id}', [PermissionController::class, 'edit'])->name('permission.edit');
        Route::delete('/{permission:id}', [PermissionController::class, 'delete'])->name('permission.delete');
    });

    Route::group(['prefix' => '/master-data'], function () {
        Route::get('/', [MasterDataController::class, 'index'])->name('master-data.index');
        Route::post('/', [MasterDataController::class, 'create'])->name('master-data.create');
        Route::get('/{masterdata:id}', [MasterDataController::class, 'show'])->name('master-data.show');
        Route::post('/{masterdata:id}', [MasterDataController::class, 'edit'])->name('master-data.edit');
        Route::delete('/{masterdata:id}', [MasterDataController::class, 'delete'])->name('master-data.delete');
    });

    Route::group(['prefix' => '/audits'], function() {
        Route::get('/', [AuditController::class, 'index'])->name('audit.index');
    });

    Route::group(['prefix' => '/posts'], function() {
        Route::get('/', [PostController::class, 'index'])->name('post.index');
        Route::post('/', [PostController::class, 'create'])->name('post.create');
        Route::get('/{post:id}', [PostController::class, 'show'])->name('post.show');
        Route::post('/{post:id}', [PostController::class, 'edit'])->name('post.edit');
        Route::delete('/{post:id}', [PostController::class, 'delete'])->name('post.delete');
    });

    Route::group(['prefix' => '/post-type'], function() {
        Route::get('/', [PostTypeController::class, 'index'])->name('post-type.index');
    });
});
