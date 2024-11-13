<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\LevelKelasController;
use App\Http\Controllers\PesertaController;
use App\Http\Controllers\ProgramKelasController;
use App\Http\Controllers\RuanganController;
use App\Http\Controllers\TipeKelasController;
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
    Route::get('/kelas/create', [KelasController::class, 'create'])->name('kelas.create');

    Route::get('/user', [UserController::class, 'index'])->middleware(HandleGetQuery::class)->name('user.index');

    Route::get('/peserta', [PesertaController::class, 'index'])->middleware(HandleGetQuery::class)->name('peserta.index');

    Route::get('/program-kelas', [ProgramKelasController::class, 'index'])->name('program-kelas.index');
    Route::get('/program-kelas/create', [ProgramKelasController::class, 'create'])->name('program-kelas.create');
    Route::post('/program-kelas', [ProgramKelasController::class, 'store'])->name('program-kelas.store');
    Route::put('/program-kelas/{id}', [ProgramKelasController::class, 'update'])->name('program-kelas.update');
    Route::delete('/program-kelas', [ProgramKelasController::class, 'destroy'])->name('program-kelas.destroy');

    Route::get('/tipe-kelas', [TipeKelasController::class, 'index'])->name('tipe-kelas.index');
    Route::get('/tipe-kelas/create', [TipeKelasController::class, 'create'])->name('tipe-kelas.create');
    Route::post('/tipe-kelas', [TipeKelasController::class, 'store'])->name('tipe-kelas.store');
    Route::put('/tipe-kelas/{id}', [TipeKelasController::class, 'update'])->name('tipe-kelas.update');
    Route::delete('/tipe-kelas', [TipeKelasController::class, 'destroy'])->name('tipe-kelas.destroy');

    Route::get('/level-kelas', [LevelKelasController::class, 'index'])->name('level-kelas.index');
    Route::get('/level-kelas/create', [LevelKelasController::class, 'create'])->name('level-kelas.create');
    Route::post('/level-kelas', [LevelKelasController::class, 'store'])->name('level-kelas.store');
    Route::put('/level-kelas/{id}', [LevelKelasController::class, 'update'])->name('level-kelas.update');
    Route::delete('/level-kelas', [LevelKelasController::class, 'destroy'])->name('level-kelas.destroy');

    Route::get('/ruangan', [RuanganController::class, 'index'])->name('ruangan.index');
});