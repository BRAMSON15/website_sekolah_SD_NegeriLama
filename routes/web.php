<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\InformationController;
use App\Http\Controllers\PpdbController;
use App\Http\Controllers\AdminTeacherController;
use App\Http\Controllers\AdminWebsiteController;
use App\Http\Controllers\GuruController;

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

    // Guru Portal Routes
    Route::get('/guru/dashboard', [GuruController::class, 'dashboard'])->name('guru.dashboard');
    Route::get('/guru/kelas', [GuruController::class, 'kelas'])->name('guru.kelas');
    Route::get('/guru/materi', [GuruController::class, 'materi'])->name('guru.materi');
    Route::get('/guru/video', [GuruController::class, 'video'])->name('guru.video');
    Route::get('/guru/tugas', [GuruController::class, 'tugas'])->name('guru.tugas');
    Route::get('/guru/kalender', [GuruController::class, 'kalender'])->name('guru.kalender');
    Route::get('/guru/pengumuman', [GuruController::class, 'pengumuman'])->name('guru.pengumuman');
    
    // Admin Routes
    Route::get('/admin/informasi', [AuthController::class, 'information'])->name('admin.informasi');
    Route::get('/admin/ppdb', [PpdbController::class, 'index'])->name('admin.ppdb.index');
    
    // Kelola Akun Guru (Admin Only)
    Route::get('/admin/guru', [AdminTeacherController::class, 'index'])->name('admin.teachers.index');
    Route::get('/admin/guru/tambah', [AdminTeacherController::class, 'create'])->name('admin.teachers.create');
    Route::post('/admin/guru', [AdminTeacherController::class, 'store'])->name('admin.teachers.store');
    Route::get('/admin/guru/{teacher}/edit', [AdminTeacherController::class, 'edit'])->name('admin.teachers.edit');
    Route::put('/admin/guru/{teacher}', [AdminTeacherController::class, 'update'])->name('admin.teachers.update');
    Route::delete('/admin/guru/{teacher}', [AdminTeacherController::class, 'destroy'])->name('admin.teachers.destroy');

    // Kelola Informasi Admin
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
    
    // Kelola Konten Halaman Website (Profil, Akademik, Fasilitas, PPDB, Kontak)
    Route::get('/admin/kelola/profil', [AdminWebsiteController::class, 'profil'])->name('admin.website.profil');
    Route::post('/admin/kelola/profil', [AdminWebsiteController::class, 'updateProfil'])->name('admin.website.profil.update');

    Route::get('/admin/kelola/akademik', [AdminWebsiteController::class, 'akademik'])->name('admin.website.akademik');
    Route::post('/admin/kelola/akademik', [AdminWebsiteController::class, 'updateAkademik'])->name('admin.website.akademik.update');

    Route::get('/admin/kelola/fasilitas', [AdminWebsiteController::class, 'fasilitas'])->name('admin.website.fasilitas');
    Route::post('/admin/kelola/fasilitas', [AdminWebsiteController::class, 'updateFasilitas'])->name('admin.website.fasilitas.update');

    Route::get('/admin/kelola/ppdb', [AdminWebsiteController::class, 'ppdb'])->name('admin.website.ppdb');
    Route::post('/admin/kelola/ppdb', [AdminWebsiteController::class, 'updatePpdb'])->name('admin.website.ppdb.update');

    Route::get('/admin/kelola/kontak', [AdminWebsiteController::class, 'kontak'])->name('admin.website.kontak');
    Route::post('/admin/kelola/kontak', [AdminWebsiteController::class, 'updateKontak'])->name('admin.website.kontak.update');

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});
