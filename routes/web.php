<?php

use App\Http\Controllers\AdminTeacherController;
use App\Http\Controllers\AdminStudentController;
use App\Http\Controllers\AdminWebsiteController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InformationController;
use App\Http\Controllers\KepalaSekolahController;
use App\Http\Controllers\PpdbController;
use App\Http\Controllers\SiswaController;
use Illuminate\Support\Facades\Route;

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
Route::get('/materi/{material}/download', [SiswaController::class, 'downloadMateri'])->name('materi.download')->middleware('auth');
Route::post('/siswa/akses-nisn', [SiswaController::class, 'aksesNisn'])->name('siswa.akses.nisn');

// Authentication Routes (Dedicated hidden access links per role)
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::get('/login/guru', [AuthController::class, 'showGuruLoginForm'])->name('login.guru');
Route::get('/login/admin', [AuthController::class, 'showAdminLoginForm'])->name('login.admin');
Route::get('/login/kepsek', [AuthController::class, 'showKepsekLoginForm'])->name('login.kepsek');
Route::post('/login', [AuthController::class, 'login']);
Route::match(['get', 'post'], '/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');

    // Kepala Sekolah Monitoring Routes
    Route::get('/kepsek/dashboard', [KepalaSekolahController::class, 'dashboard'])->name('kepsek.dashboard');
    Route::get('/kepsek/monitoring/guru', [KepalaSekolahController::class, 'monitoringGuru'])->name('kepsek.monitoring.guru');
    Route::get('/kepsek/monitoring/pembelajaran', [KepalaSekolahController::class, 'monitoringPembelajaran'])->name('kepsek.monitoring.pembelajaran');
    Route::get('/kepsek/monitoring/ppdb', [KepalaSekolahController::class, 'monitoringPpdb'])->name('kepsek.monitoring.ppdb');
    Route::get('/kepsek/monitoring/sistem', [KepalaSekolahController::class, 'monitoringSistem'])->name('kepsek.monitoring.sistem');

    // Portal Siswa Routes (Khusus Siswa Terdaftar)
    Route::get('/siswa/beranda', [SiswaController::class, 'beranda'])->name('siswa.beranda');
    Route::get('/siswa/materi/{material}/download', [SiswaController::class, 'downloadMateri'])->name('siswa.materi.download');

    // Guru Portal Routes
    Route::get('/guru/dashboard', [GuruController::class, 'dashboard'])->name('guru.dashboard');
    Route::get('/guru/kelas', [GuruController::class, 'kelas'])->name('guru.kelas.index');
    Route::get('/guru/kelas/tambah', [GuruController::class, 'createKelas'])->name('guru.kelas.create');
    Route::post('/guru/kelas', [GuruController::class, 'storeKelas'])->name('guru.kelas.store');
    Route::get('/guru/kelas/{classroom}/edit', [GuruController::class, 'editKelas'])->name('guru.kelas.edit');
    Route::put('/guru/kelas/{classroom}', [GuruController::class, 'updateKelas'])->name('guru.kelas.update');
    Route::delete('/guru/kelas/{classroom}', [GuruController::class, 'destroyKelas'])->name('guru.kelas.destroy');

    // Materi Pembelajaran
    Route::get('/guru/materi', [GuruController::class, 'materi'])->name('guru.materi');
    Route::post('/guru/materi', [GuruController::class, 'storeMateri'])->name('guru.materi.store');
    Route::get('/guru/materi/{material}/download', [GuruController::class, 'downloadMateri'])->name('guru.materi.download');
    Route::delete('/guru/materi/{material}', [GuruController::class, 'destroyMateri'])->name('guru.materi.destroy');

    // Video Edukasi
    Route::get('/guru/video', [GuruController::class, 'video'])->name('guru.video');
    Route::post('/guru/video', [GuruController::class, 'storeVideo'])->name('guru.video.store');
    Route::put('/guru/video/{video}', [GuruController::class, 'updateVideo'])->name('guru.video.update');
    Route::delete('/guru/video/{video}', [GuruController::class, 'destroyVideo'])->name('guru.video.destroy');

    // Pengumuman Guru
    Route::get('/guru/pengumuman', [GuruController::class, 'pengumuman'])->name('guru.pengumuman');

    // Admin Routes
    Route::get('/admin/informasi', [AuthController::class, 'information'])->name('admin.informasi');
    Route::get('/admin/ppdb', [PpdbController::class, 'index'])->name('admin.ppdb.index');
    Route::get('/admin/ppdb/export/pdf', [PpdbController::class, 'exportPdf'])->name('admin.ppdb.export.pdf');
    Route::get('/admin/ppdb/export/excel', [PpdbController::class, 'exportExcel'])->name('admin.ppdb.export.excel');

    // Kelola Akun Guru (Admin Only)
    Route::get('/admin/guru', [AdminTeacherController::class, 'index'])->name('admin.teachers.index');
    Route::get('/admin/guru/tambah', [AdminTeacherController::class, 'create'])->name('admin.teachers.create');
    Route::post('/admin/guru', [AdminTeacherController::class, 'store'])->name('admin.teachers.store');
    Route::get('/admin/guru/{teacher}/edit', [AdminTeacherController::class, 'edit'])->name('admin.teachers.edit');
    Route::put('/admin/guru/{teacher}', [AdminTeacherController::class, 'update'])->name('admin.teachers.update');
    Route::delete('/admin/guru/{teacher}', [AdminTeacherController::class, 'destroy'])->name('admin.teachers.destroy');

    // Kelola Siswa
    Route::get('/admin/siswa', [AdminStudentController::class, 'index'])->name('admin.students.index');
    Route::get('/admin/siswa/tambah', [AdminStudentController::class, 'create'])->name('admin.students.create');
    Route::post('/admin/siswa', [AdminStudentController::class, 'store'])->name('admin.students.store');
    Route::get('/admin/siswa/{student}/edit', [AdminStudentController::class, 'edit'])->name('admin.students.edit');
    Route::put('/admin/siswa/{student}', [AdminStudentController::class, 'update'])->name('admin.students.update');
    Route::delete('/admin/siswa/{student}', [AdminStudentController::class, 'destroy'])->name('admin.students.destroy');

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
});
