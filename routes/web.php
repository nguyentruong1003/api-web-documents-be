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

Route::group(['middleware' => ['auth']], function () {
    Route::group(['prefix' => '/users'], function() {
        Route::get('/', [App\Http\Controllers\UserController::class, 'index'])->name('admin.user.index');
        // Route::post('/', [App\Http\Controllers\UserController::class, 'create'])->name('user.create');
        // Route::get('/{user:id}', [App\Http\Controllers\UserController::class, 'show'])->name('user.show');
        // Route::post('/{user:id}', [App\Http\Controllers\UserController::class, 'edit'])->name('user.edit');
        // Route::delete('/{user:id}', [App\Http\Controllers\UserController::class, 'delete'])->name('user.delete');
    });
});
