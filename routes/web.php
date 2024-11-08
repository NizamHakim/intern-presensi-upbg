<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\Authenticated;
use App\Http\Middleware\GetKelasQuery;
use App\Http\Middleware\Guest;
use App\Http\Middleware\HandleGetQuery;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Guest
Route::middleware(Guest::class)->group(function(){
    Route::get('/login', [AuthController::class, 'loginPage'])->name('auth.loginPage');
    Route::post('/login', [AuthController::class, 'handleLoginRequest'])->name('auth.handleLoginRequest');
});

Route::middleware(Authenticated::class)->group(function(){
    Route::post('/logout', [AuthController::class, 'handleLogoutRequest'])->name('auth.handleLogoutRequest');

    Route::get('/kelas', [KelasController::class, 'index'])->middleware(HandleGetQuery::class)->name('kelas.index');

    Route::get('/user', [UserController::class, 'index'])->middleware(HandleGetQuery::class)->name('user.index');
});