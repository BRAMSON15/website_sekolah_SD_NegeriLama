<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\InformationController;
use App\Http\Controllers\PpdbController;

// Public Front Page Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/profil', [HomeController::class, 'profil'])->name('profil');
Route::get('/akademik', [HomeController::class, 'akademik'])->name('akademik');
Route::get('/fasilitas', [HomeController::class, 'fasilitas'])->name('fasilitas');
Route::get('/ppdb', [HomeController::class, 'ppdb'])->name('ppdb');
Route::get('/ppdb/daftar', [PpdbController::class, 'create'])->name('ppdb.register');
Route::post('/ppdb/daftar', [PpdbController::class, 'store'])->name('ppdb.store');
Route::get('/ppdb/berhasil/{registration}', [PpdbController::class, 'success'])->name('ppdb.success');
Route::get('/pengumuman', [HomeController::class, 'pengumuman'])->name('pengumuman.index');
Route::get('/pengumuman/{slug}', [HomeController::class, 'detailPengumuman'])->name('pengumuman.show');
Route::get('/kontak', [HomeController::class, 'kontak'])->name('kontak');

// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');
    Route::get('/admin/informasi', [AuthController::class, 'information'])->name('admin.informasi');
    Route::get('/admin/ppdb', [PpdbController::class, 'index'])->name('admin.ppdb.index');
    Route::get('/admin/informasi/pengumuman', [InformationController::class, 'announcements'])->name('admin.pengumuman.index');
    Route::get('/admin/informasi/pengumuman/tambah', [InformationController::class, 'createAnnouncement'])->name('admin.pengumuman.create');
    Route::post('/admin/informasi/pengumuman', [InformationController::class, 'storeAnnouncement'])->name('admin.pengumuman.store');
    Route::get('/admin/informasi/pengumuman/{announcement}/edit', [InformationController::class, 'editAnnouncement'])->name('admin.pengumuman.edit');
    Route::put('/admin/informasi/pengumuman/{announcement}', [InformationController::class, 'updateAnnouncement'])->name('admin.pengumuman.update');
    Route::delete('/admin/informasi/pengumuman/{announcement}', [InformationController::class, 'destroyAnnouncement'])->name('admin.pengumuman.destroy');
    Route::get('/admin/informasi/fitur', [InformationController::class, 'features'])->name('admin.fitur.index');
    Route::get('/admin/informasi/fitur/tambah', [InformationController::class, 'createFeature'])->name('admin.fitur.create');
    Route::post('/admin/informasi/fitur', [InformationController::class, 'storeFeature'])->name('admin.fitur.store');
    Route::get('/admin/informasi/fitur/{feature}/edit', [InformationController::class, 'editFeature'])->name('admin.fitur.edit');
    Route::put('/admin/informasi/fitur/{feature}', [InformationController::class, 'updateFeature'])->name('admin.fitur.update');
    Route::delete('/admin/informasi/fitur/{feature}', [InformationController::class, 'destroyFeature'])->name('admin.fitur.destroy');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});
