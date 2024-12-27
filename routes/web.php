<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\LevelKelasController;
use App\Http\Controllers\PertemuanKelasController;
use App\Http\Controllers\PesertaController;
use App\Http\Controllers\PresensiPertemuanKelasController;
use App\Http\Controllers\ProgramKelasController;
use App\Http\Controllers\RuanganController;
use App\Http\Controllers\TesController;
use App\Http\Controllers\TipeKelasController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\Authenticated;
use App\Http\Middleware\Guest;
use App\Http\Middleware\HandleGetQuery;
use App\Models\ProgramKelas;
use Illuminate\Container\Attributes\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use function Illuminate\Log\log;

Route::get('/', function () {
    return view('welcome');
});

// Guest
Route::middleware(Guest::class)->group(function(){
    Route::get('/login', [AuthController::class, 'loginPage'])->name('auth.loginPage');
    Route::post('/login', [AuthController::class, 'handleLoginRequest'])->name('auth.handleLoginRequest');
});

Route::middleware(Authenticated::class)->group(function(){
    Route::patch('/switch-role', [AuthController::class, 'switchRole'])->name('auth.switchRole');
    Route::post('/logout', [AuthController::class, 'handleLogoutRequest'])->name('auth.handleLogoutRequest');

    Route::get('/kelas', [KelasController::class, 'index'])->name('kelas.index');
    Route::get('/kelas/create', [KelasController::class, 'create'])->name('kelas.create');
    Route::get('/kelas/{slug}', [KelasController::class, 'detail'])->name('kelas.detail');
    Route::post('/kelas', [KelasController::class, 'store'])->name('kelas.store');
    Route::get('/kelas/{slug}/edit', [KelasController::class, 'edit'])->name('kelas.edit');
    Route::put('/kelas/{slug}', [KelasController::class, 'update'])->name('kelas.update');
    Route::delete('/kelas/{slug}', [KelasController::class, 'destroy'])->name('kelas.destroy');
    Route::get('/kelas/{slug}/daftar-peserta', [KelasController::class, 'daftarPeserta'])->name('kelas.daftarPeserta');
    Route::get('/kelas/{slug}/daftar-peserta/tambah', [KelasController::class, 'tambahPeserta'])->name('kelas.tambahPeserta');
    Route::post('/kelas/{slug}/daftar-peserta/tambah', [KelasController::class, 'storePeserta'])->name('kelas.storePeserta');
    Route::patch('/kelas/{slug}/daftar-peserta/update', [KelasController::class, 'updatePeserta'])->name('kelas.updatePeserta');
    Route::delete('/kelas/{slug}/delete-peserta', [KelasController::class, 'destroyPeserta'])->name('kelas.destroyPeserta');

    Route::get('/kelas/{slug}/pertemuan/{id}', [PertemuanKelasController::class, 'detail'])->name('kelas.pertemuan.detail');
    Route::get('/kelas/{slug}/pertemuan/{id}/edit', [PertemuanKelasController::class, 'edit'])->name('kelas.pertemuan.edit');
    Route::post('/kelas/{slug}/pertemuan', [PertemuanKelasController::class, 'store'])->name('kelas.pertemuan.store');
    Route::delete('/kelas/{slug}/pertemuan{id}', [PertemuanKelasController::class, 'destroy'])->name('kelas.pertemuan.destroy');
    Route::put('/kelas/{slug}/pertemuan/{id}/update-detail', [PertemuanKelasController::class, 'updateDetail'])->name('kelas.pertemuan.updateDetail');
    Route::patch('/kelas/{slug}/pertemuan/{id}/update-topik-catatan', [PertemuanKelasController::class, 'updateTopikCatatan'])->name('kelas.pertemuan.updateTopikCatatan');
    Route::patch('/kelas/{slug}/pertemuan/{id}/reschedule', [PertemuanKelasController::class, 'reschedule'])->name('kelas.pertemuan.reschedule');
    Route::patch('/kelas/{slug}/pertemuan/{id}/mulai-pertemuan', [PertemuanKelasController::class, 'mulaiPertemuan'])->name('kelas.pertemuan.mulaiPertemuan');
    
    Route::post('/kelas/{slug}/pertemuan/{id}', [PresensiPertemuanKelasController::class, 'store'])->name('presensi.store');
    Route::delete('/kelas/{slug}/pertemuan/{id}/presensi/destroy', [PresensiPertemuanKelasController::class, 'destroy'])->name('presensi.destroy');
    Route::patch('/kelas/{slug}/pertemuan/{id}/presensi/{presensiId}', [PresensiPertemuanKelasController::class, 'updatePresensi'])->name('presensi.updatePresensi');
    Route::put('/kelas/{slug}/pertemuan/{id}/presensi-all', [PresensiPertemuanKelasController::class, 'updatePresensiAll'])->name('presensi.updatePresensiAll');

    Route::get('/tes', [TesController::class, 'index'])->name('tes.index');
    Route::get('/tes/create', [TesController::class, 'create'])->name('tes.create');
    Route::post('/tes', [TesController::class, 'store'])->name('tes.store');
    Route::get('/tes/{slug}', [TesController::class, 'detail'])->name('tes.detail');
    Route::get('/tes/{slug}/edit', [TesController::class, 'edit'])->name('tes.edit');
    Route::put('/tes/{slug}', [TesController::class, 'update'])->name('tes.update');
    Route::delete('/tes/{slug}', [TesController::class, 'destroy'])->name('tes.destroy');
    Route::get('/tes/{slug}/kelola-peserta', [TesController::class, 'kelolaPeserta'])->name('tes.kelolaPeserta');

    Route::get('/user', [UserController::class, 'index'])->middleware(HandleGetQuery::class)->name('user.index');
    Route::get('/user/create', [UserController::class, 'create'])->name('user.create');
    Route::post('/user', [UserController::class, 'store'])->name('user.store');
    Route::get('/user/{id}', [UserController::class, 'detail'])->name('user.detail');
    Route::patch('/user/{id}', [UserController::class, 'updateRole'])->name('user.updateRole');

    Route::get('/peserta', [PesertaController::class, 'index'])->middleware(HandleGetQuery::class)->name('peserta.index');

    Route::get('/program-kelas', [ProgramKelasController::class, 'index'])->name('program-kelas.index');
    Route::post('/program-kelas', [ProgramKelasController::class, 'store'])->name('program-kelas.store');
    Route::put('/program-kelas/update', [ProgramKelasController::class, 'update'])->name('program-kelas.update');
    Route::delete('/program-kelas', [ProgramKelasController::class, 'destroy'])->name('program-kelas.destroy');
    Route::patch('/program-kelas/restore', [ProgramKelasController::class, 'restore'])->name('program-kelas.restore');

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

Route::get('/component-testing', function(){
    if(request()->ajax()){
        return view('dummy', [
            'name' => request('name'),
        ]);
    }
    return view('component-testing');   
});