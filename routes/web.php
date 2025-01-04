<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\JadwalController;
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
use App\Http\Middleware\AjaxSessionHandler;
use App\Http\Middleware\Authenticated;
use App\Http\Middleware\Guest;
use App\Http\Middleware\RoleMustNull;
use App\Http\Middleware\VerifyOwnership;
use App\Http\Middleware\VerifyRole;
use App\Models\ProgramKelas;
use Illuminate\Container\Attributes\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

use function Illuminate\Log\log;

Route::get('/', function () {
    if(!Auth::check()){
        return redirect()->route('auth.loginPage');
    }
    switch(Auth::user()->current_role_id){
        case null:
            return redirect()->route('auth.loginRoles');
        case 1:
            return redirect()->route('kelas.index');
        case 2:
            return redirect()->route('kelas.index');
        case 3:
            return redirect()->route('kelas.index');
        case 4:
            return redirect()->route('tes.index');
        case 5:
            return redirect()->route('tes.index');
    }
})->name('home');

// Guest
Route::middleware(Guest::class)->group(function(){
    Route::get('/login', [AuthController::class, 'loginPage'])->name('auth.loginPage');
    Route::post('/login', [AuthController::class, 'handleLoginRequest'])->name('auth.handleLoginRequest');
    Route::get('/jadwal', [JadwalController::class, 'index'])->name('jadwal.index');
});

Route::middleware(Authenticated::class)->group(function(){
    Route::get('/login/roles', [AuthController::class, 'loginRoles'])->middleware(RoleMustNull::class)->name('auth.loginRoles');
    Route::patch('/switch-role', [AuthController::class, 'switchRole'])->name('auth.switchRole');
    Route::post('/logout', [AuthController::class, 'handleLogoutRequest'])->name('auth.handleLogoutRequest');

    Route::get('/kelas', [KelasController::class, 'index'])->middleware(VerifyRole::class.':1,2,3')->name('kelas.index');
    Route::get('/kelas/create', [KelasController::class, 'create'])->middleware(VerifyRole::class.':1,2')->name('kelas.create');
    Route::get('/kelas/{slug}', [KelasController::class, 'detail'])->middleware(VerifyRole::class.':1,2,3', VerifyOwnership::class.':pengajaran')->name('kelas.detail');
    Route::post('/kelas', [KelasController::class, 'store'])->middleware(VerifyRole::class.':1,2')->name('kelas.store');
    Route::get('/kelas/{slug}/edit', [KelasController::class, 'edit'])->middleware(VerifyRole::class.':1,2')->name('kelas.edit');
    Route::put('/kelas/{slug}', [KelasController::class, 'update'])->middleware(VerifyRole::class.':1,2')->name('kelas.update');
    Route::delete('/kelas/{slug}', [KelasController::class, 'destroy'])->middleware(VerifyRole::class.':1,2')->name('kelas.destroy');
    Route::get('/kelas/{slug}/daftar-peserta', [KelasController::class, 'daftarPeserta'])->middleware(VerifyRole::class.':1,2,3', VerifyOwnership::class.':pengajaran')->name('kelas.daftarPeserta');
    Route::get('/kelas/{slug}/daftar-peserta/tambah', [KelasController::class, 'tambahPeserta'])->middleware(VerifyRole::class.':1,2')->name('kelas.tambahPeserta');
    Route::post('/kelas/{slug}/daftar-peserta/tambah', [KelasController::class, 'storePeserta'])->middleware(VerifyRole::class.':1,2')->name('kelas.storePeserta');
    Route::patch('/kelas/{slug}/daftar-peserta/update', [KelasController::class, 'updatePeserta'])->middleware(VerifyRole::class.':1,2')->name('kelas.updatePeserta');
    Route::delete('/kelas/{slug}/delete-peserta', [KelasController::class, 'destroyPeserta'])->middleware(VerifyRole::class.':1,2')->name('kelas.destroyPeserta');

    Route::get('/kelas/{slug}/pertemuan/{id}', [PertemuanKelasController::class, 'detail'])->middleware(VerifyRole::class.':1,2,3', VerifyOwnership::class.':pengajaran')->name('kelas.pertemuan.detail');
    Route::get('/kelas/{slug}/pertemuan/{id}/edit', [PertemuanKelasController::class, 'edit'])->middleware(VerifyRole::class.':1,2')->name('kelas.pertemuan.edit');
    Route::post('/kelas/{slug}/pertemuan', [PertemuanKelasController::class, 'store'])->middleware(VerifyRole::class.':1,2,3', VerifyOwnership::class.':pengajaran')->name('kelas.pertemuan.store');
    Route::delete('/kelas/{slug}/pertemuan{id}', [PertemuanKelasController::class, 'destroy'])->middleware(VerifyRole::class.':1,2,3', VerifyOwnership::class.':pengajaran')->name('kelas.pertemuan.destroy');
    Route::put('/kelas/{slug}/pertemuan/{id}/update-detail', [PertemuanKelasController::class, 'updateDetail'])->middleware(VerifyRole::class.':1,2')->name('kelas.pertemuan.updateDetail');
    Route::patch('/kelas/{slug}/pertemuan/{id}/update-topik-catatan', [PertemuanKelasController::class, 'updateTopikCatatan'])->middleware(VerifyRole::class.':1,2,3', VerifyOwnership::class.':pengajaran')->name('kelas.pertemuan.updateTopikCatatan');
    Route::patch('/kelas/{slug}/pertemuan/{id}/reschedule', [PertemuanKelasController::class, 'reschedule'])->middleware(VerifyRole::class.':1,3', VerifyOwnership::class.':pengajaran')->name('kelas.pertemuan.reschedule');
    Route::patch('/kelas/{slug}/pertemuan/{id}/mulai-pertemuan', [PertemuanKelasController::class, 'mulaiPertemuan'])->middleware(VerifyRole::class.':1,3', VerifyOwnership::class.':pengajaran')->name('kelas.pertemuan.mulaiPertemuan');
    
    Route::post('/kelas/{slug}/pertemuan/{id}', [PresensiPertemuanKelasController::class, 'store'])->middleware(VerifyRole::class.':1,2,3', VerifyOwnership::class.':pengajaran')->name('presensi.store');
    Route::delete('/kelas/{slug}/pertemuan/{id}/presensi/destroy', [PresensiPertemuanKelasController::class, 'destroy'])->middleware(VerifyRole::class.':1,2,3', VerifyOwnership::class.':pengajaran')->name('presensi.destroy');
    Route::patch('/kelas/{slug}/pertemuan/{id}/presensi/{presensiId}', [PresensiPertemuanKelasController::class, 'updatePresensi'])->middleware(VerifyRole::class.':1,2,3', VerifyOwnership::class.':pengajaran')->name('presensi.updatePresensi');
    Route::put('/kelas/{slug}/pertemuan/{id}/presensi-all', [PresensiPertemuanKelasController::class, 'updatePresensiAll'])->middleware(VerifyRole::class.':1,2,3', VerifyOwnership::class.':pengajaran')->name('presensi.updatePresensiAll');

    Route::get('/tes', [TesController::class, 'index'])->middleware(VerifyRole::class.':1,4,5')->name('tes.index');
    Route::get('/tes/create', [TesController::class, 'create'])->middleware(VerifyRole::class.':1,4')->name('tes.create');
    Route::post('/tes', [TesController::class, 'store'])->middleware(VerifyRole::class.':1,4')->name('tes.store');
    Route::get('/tes/{slug}', [TesController::class, 'detail'])->middleware(VerifyRole::class.':1,4,5')->name('tes.detail');
    Route::get('/tes/{slug}/edit', [TesController::class, 'edit'])->middleware(VerifyRole::class.':1,4')->name('tes.edit');
    Route::put('/tes/{slug}', [TesController::class, 'update'])->middleware(VerifyRole::class.':1,4')->name('tes.update');
    Route::delete('/tes/{slug}', [TesController::class, 'destroy'])->middleware(VerifyRole::class.':1,4')->name('tes.destroy');
    Route::get('/tes/{slug}/daftar-peserta', [TesController::class, 'daftarPeserta'])->middleware(VerifyRole::class.':1,4,5')->name('tes.daftarPeserta');
    Route::get('/tes/{slug}/daftar-peserta/tambah', [TesController::class, 'tambahPeserta'])->middleware(VerifyRole::class.':1,4')->name('tes.tambahPeserta');
    Route::patch('/tes/{slug}/daftar-peserta/update-ruangan', [TesController::class, 'updateRuangan'])->middleware(VerifyRole::class.':1,4')->name('tes.updateRuangan');

    Route::patch('/tes/{slug}/presensi/{pesertaId}', [TesController::class, 'updatePresensi'])->middleware(VerifyRole::class.':1,4,5')->name('tes.updatePresensi');
    Route::delete('/tes/{slug}/presensi-delete', [TesController::class, 'destroyPresensi'])->middleware(VerifyRole::class.':1,4')->name('tes.destroyPresensi');

    Route::middleware(VerifyRole::class.':1,2,4')->group(function(){
      Route::get('/user', [UserController::class, 'index'])->name('user.index');
      Route::get('/user/create', [UserController::class, 'create'])->name('user.create');
      Route::post('/user', [UserController::class, 'store'])->name('user.store');
      Route::get('/user/{id}', [UserController::class, 'detail'])->name('user.detail');
      Route::patch('/user/{id}', [UserController::class, 'updateRole'])->name('user.updateRole');
  
      Route::get('/peserta', [PesertaController::class, 'index'])->name('peserta.index');
      Route::get('/peserta/{id}', [PesertaController::class, 'detail'])->name('peserta.detail');
      Route::put('/peserta/{id}', [PesertaController::class, 'update'])->name('peserta.update');
      Route::delete('/peserta/{id}', [PesertaController::class, 'destroy'])->name('peserta.destroy');

      Route::get('/ruangan', [RuanganController::class, 'index'])->name('ruangan.index');
      Route::post('/ruangan', [RuanganController::class, 'store'])->name('ruangan.store');
      Route::put('/ruangan/update', [RuanganController::class, 'update'])->name('ruangan.update');
      Route::delete('/ruangan', [RuanganController::class, 'destroy'])->name('ruangan.destroy');
      Route::patch('/ruangan/restore', [RuanganController::class, 'restore'])->name('ruangan.restore');
    });

    Route::middleware(VerifyRole::class.':1,2')->group(function(){
      Route::get('/program-kelas', [ProgramKelasController::class, 'index'])->name('program-kelas.index');
      Route::post('/program-kelas', [ProgramKelasController::class, 'store'])->name('program-kelas.store');
      Route::put('/program-kelas/update', [ProgramKelasController::class, 'update'])->name('program-kelas.update');
      Route::delete('/program-kelas', [ProgramKelasController::class, 'destroy'])->name('program-kelas.destroy');
      Route::patch('/program-kelas/restore', [ProgramKelasController::class, 'restore'])->name('program-kelas.restore');

      Route::get('/tipe-kelas', [TipeKelasController::class, 'index'])->name('tipe-kelas.index');
      Route::post('/tipe-kelas', [TipeKelasController::class, 'store'])->name('tipe-kelas.store');
      Route::put('/tipe-kelas/update', [TipeKelasController::class, 'update'])->name('tipe-kelas.update');
      Route::delete('/tipe-kelas', [TipeKelasController::class, 'destroy'])->name('tipe-kelas.destroy');
      Route::patch('/tipe-kelas/restore', [TipeKelasController::class, 'restore'])->name('tipe-kelas.restore');
  
      Route::get('/level-kelas', [LevelKelasController::class, 'index'])->name('level-kelas.index');
      Route::post('/level-kelas', [LevelKelasController::class, 'store'])->name('level-kelas.store');
      Route::put('/level-kelas/update', [LevelKelasController::class, 'update'])->name('level-kelas.update');
      Route::delete('/level-kelas', [LevelKelasController::class, 'destroy'])->name('level-kelas.destroy');
      Route::patch('/level-kelas/restore', [LevelKelasController::class, 'restore'])->name('level-kelas.restore');
    });
});

Route::get('/component-testing', function(){
    if(request()->ajax()){
        return view('dummy', [
            'name' => request('name'),
        ]);
    }
    return view('component-testing');   
});