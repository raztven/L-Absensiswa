<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/login', [AuthController::class, 'index'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Route khusus untuk perbaikan di tempat client (Jalankan sekali jika ada error 419/Cache)
Route::get('/fix-setup', function() {
    \Illuminate\Support\Facades\Artisan::call('optimize:clear');
    \Illuminate\Support\Facades\Artisan::call('config:clear');
    \Illuminate\Support\Facades\Artisan::call('cache:clear');
    \Illuminate\Support\Facades\Artisan::call('view:clear');
    \Illuminate\Support\Facades\Artisan::call('storage:link');
    return 'Setup berhasil! Cache dibersihkan. Silakan kembali ke login.';
});

Route::middleware(['auth'])->group(function () {
    
    // Admin Routes
    Route::middleware(['role:admin'])->prefix('admin')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
        Route::get('/siswa', [AdminController::class, 'siswa'])->name('admin.siswa.index');
        Route::post('/siswa', [AdminController::class, 'storeSiswa'])->name('admin.siswa.store');
        Route::get('/laporan', [AdminController::class, 'laporan'])->name('admin.laporan.index');
        Route::get('/laporan/cetak', [AdminController::class, 'cetakLaporan'])->name('admin.laporan.cetak');
    });

    // Siswa Routes
    Route::middleware(['role:siswa'])->group(function () {
        Route::get('/', [\App\Http\Controllers\AbsenController::class, 'index'])->name('siswa.absensi');
        Route::post('/absen/masuk', [\App\Http\Controllers\AbsenController::class, 'masuk'])->name('absensi.masuk');
        Route::patch('/absen/keluar', [\App\Http\Controllers\AbsenController::class, 'keluar'])->name('absensi.keluar');
        Route::post('/absen/izin', [\App\Http\Controllers\AbsenController::class, 'izin'])->name('absensi.izin');
    });
});