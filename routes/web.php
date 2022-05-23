<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();
Route::get('/', function () {
    return view('auth.login');
});

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['middleware' => 'auth'], function () {
    Route::group(['middleware' => 'check-route-permission'], function () {
        Route::group(['prefix' => '/users'], function() {
            Route::get('/', [App\Http\Controllers\UserController::class, 'index'])->name('admin.user.index');
        });
    
        Route::group(['prefix' => '/roles'], function() {
            Route::get('/', [App\Http\Controllers\RoleController::class, 'index'])->name('admin.role.index');
        });
    
        Route::group(['prefix' => '/master-data'], function() {
            Route::get('/', [App\Http\Controllers\MasterDataController::class, 'index'])->name('admin.master-data.index');
        });
    
        Route::group(['prefix' => '/audits'], function() {
            Route::get('/', [App\Http\Controllers\AuditController::class, 'index'])->name('admin.audit.index');
        });

        Route::group(['prefix' => '/post-reports'], function() {
            Route::get('/', [App\Http\Controllers\PostReportController::class, 'index'])->name('admin.post-report.index');
        });
    
        Route::group(['prefix' => '/files'], function() {
            Route::get('/', [App\Http\Controllers\FileController::class, 'index'])->name('admin.file.index');
        });

        Route::get('/pending', [App\Http\Controllers\PostController::class, 'pending'])->name('admin.post.pending');
    });

    Route::group(['prefix' => '/post-types'], function() {
        Route::get('/', [App\Http\Controllers\PostTypeController::class, 'index'])->name('admin.post-type.index');
    });
    
    Route::group(['prefix' => '/posts'], function() {
        Route::get('/', [App\Http\Controllers\PostController::class, 'index'])->name('admin.post.index');
        Route::get('/show/{id}', [App\Http\Controllers\PostController::class, 'show'])->name('admin.post.show');
    });
});
