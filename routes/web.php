<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\KelasController;
use App\Http\Middleware\GetKelasQuery;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Guest
Route::get('/login', [AuthController::class, 'getLoginPage'])->name('auth.getLoginPage');
Route::post('/login', [AuthController::class, 'postLoginRequest'])->name('auth.postLoginRequest');

Route::get('/kelas', [KelasController::class, 'index'])->middleware(GetKelasQuery::class)->name('kelas.index');