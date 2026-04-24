<?php

use App\Http\Controllers\Auth\MasukController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\PenggunaController;
use Illuminate\Support\Facades\Route;

// ROUTE AUTENTIKASI (Belum Login)
Route::middleware('cek.belum.masuk')->group(function () {
    Route::get('/masuk',  [MasukController::class, 'tampilFormMasuk'])->name('masuk');
    Route::post('/masuk', [MasukController::class, 'prosesMasuk'])->name('masuk.proses');
});

Route::post('/keluar', [MasukController::class, 'prosesKeluar'])
    ->name('keluar')
    ->middleware('cek.sudah.masuk');

// ROUTE YANG MEMERLUKAN LOGIN
Route::middleware('cek.sudah.masuk')->group(function () {

    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Profil diri sendiri (semua role)
    Route::prefix('profil')->name('profil.')->group(function () {
        Route::get('/',                [PenggunaController::class, 'profilSaya'])         ->name('saya');
        Route::put('/perbarui',        [PenggunaController::class, 'perbaruiProfilSaya']) ->name('perbarui');
        Route::put('/ubah-kata-sandi', [PenggunaController::class, 'ubahKataSandiSaya'])  ->name('ubah-kata-sandi');
    });

    // Absensi — check-in/out untuk semua; CRUD hanya admin
    Route::prefix('absensi')->name('absensi.')->group(function () {
        Route::get('/',        [AbsensiController::class, 'index'])   ->name('indeks');
        Route::get('/laporan', [AbsensiController::class, 'laporan']) ->name('laporan');
        Route::post('/check-in',  [AbsensiController::class, 'checkIn'])  ->name('check-in');
        Route::post('/check-out', [AbsensiController::class, 'checkOut']) ->name('check-out');

        Route::middleware('cek.admin')->group(function () {
            Route::get('/tambah',             [AbsensiController::class, 'tambah'])   ->name('tambah');
            Route::post('/simpan',            [AbsensiController::class, 'simpan'])   ->name('simpan');
            Route::get('/{absensi}/ubah',     [AbsensiController::class, 'ubah'])     ->name('ubah');
            Route::put('/{absensi}/perbarui', [AbsensiController::class, 'perbarui']) ->name('perbarui');
            Route::delete('/{absensi}/hapus', [AbsensiController::class, 'hapus'])    ->name('hapus');
        });
    });

    // Karyawan — hanya admin
    Route::middleware('cek.admin')->prefix('karyawan')->name('karyawan.')->group(function () {
        Route::get('/',                    [KaryawanController::class, 'index'])    ->name('indeks');
        Route::get('/tambah',              [KaryawanController::class, 'tambah'])   ->name('tambah');
        Route::post('/simpan',             [KaryawanController::class, 'simpan'])   ->name('simpan');
        Route::get('/{karyawan}/detail',   [KaryawanController::class, 'detail'])   ->name('detail');
        Route::get('/{karyawan}/ubah',     [KaryawanController::class, 'ubah'])     ->name('ubah');
        Route::put('/{karyawan}/perbarui', [KaryawanController::class, 'perbarui']) ->name('perbarui');
        Route::delete('/{karyawan}/hapus', [KaryawanController::class, 'hapus'])    ->name('hapus');
    });

    // Pengguna — hanya admin
    Route::middleware('cek.admin')->prefix('pengguna')->name('pengguna.')->group(function () {
        Route::get('/',                            [PenggunaController::class, 'index'])          ->name('indeks');
        Route::get('/tambah',                      [PenggunaController::class, 'tambah'])         ->name('tambah');
        Route::post('/simpan',                     [PenggunaController::class, 'simpan'])         ->name('simpan');
        Route::get('/{pengguna}/detail',           [PenggunaController::class, 'detail'])         ->name('detail');
        Route::get('/{pengguna}/ubah',             [PenggunaController::class, 'ubah'])           ->name('ubah');
        Route::put('/{pengguna}/perbarui',         [PenggunaController::class, 'perbarui'])       ->name('perbarui');
        Route::put('/{pengguna}/reset-kata-sandi', [PenggunaController::class, 'resetKataSandi']) ->name('reset-kata-sandi');
        Route::patch('/{pengguna}/ubah-status',    [PenggunaController::class, 'ubahStatus'])     ->name('ubah-status');
        Route::delete('/{pengguna}/hapus',         [PenggunaController::class, 'hapus'])          ->name('hapus');
    });
});
