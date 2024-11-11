<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\PesertaController;
use App\Http\Controllers\ProgramKelasController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\Authenticated;
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

    Route::get('/peserta', [PesertaController::class, 'index'])->middleware(HandleGetQuery::class)->name('peserta.index');

    Route::get('/program-kelas', [ProgramKelasController::class, 'index'])->name('program-kelas.index');
    Route::put('/program-kelas/{programKelas:id}', [ProgramKelasController::class, 'update'])->name('program-kelas.update');
    Route::delete('/program-kelas', [ProgramKelasController::class, 'destroy'])->name('program-kelas.destroy');
});