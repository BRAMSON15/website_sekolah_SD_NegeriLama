<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/profil', [HomeController::class, 'profil'])->name('profil');
Route::get('/akademik', [HomeController::class, 'akademik'])->name('akademik');
Route::get('/fasilitas', [HomeController::class, 'fasilitas'])->name('fasilitas');
Route::get('/ppdb', [HomeController::class, 'ppdb'])->name('ppdb');
Route::get('/pengumuman', [HomeController::class, 'pengumuman'])->name('pengumuman.index');
Route::get('/pengumuman/{slug}', [HomeController::class, 'detailPengumuman'])->name('pengumuman.show');
Route::get('/kontak', [HomeController::class, 'kontak'])->name('kontak');
