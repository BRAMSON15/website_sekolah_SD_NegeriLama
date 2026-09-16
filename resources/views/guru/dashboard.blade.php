@extends('layouts.guru')

@section('title', 'Dashboard Guru - ' . ($settings['school_name'] ?? 'SD NEGERI LAMA'))

@section('content')
@if (session('success'))
<div style="background: #ddf7ed; border: 1px solid #27a879; color: #1e7e5a; padding: 14px 20px; border-radius: 12px; margin-bottom: 20px; font-weight: 600;">
    <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
</div>
@endif

<!-- WELCOME -->
<div class="welcome">
    <div class="welcome-text">
        <h1>
            Selamat datang, {{ Auth::user()->name }}! 👋
        </h1>
        <p>
            Semoga hari ini penuh dengan inspirasi dan semangat untuk mencerdaskan generasi bangsa di {{ $settings['school_name'] ?? 'SD NEGERI LAMA' }}.
        </p>
    </div>

    <div class="teacher-illustration">
        <div class="teacher">
            <div class="teacher-head"></div>
            <div class="teacher-body"></div>
        </div>

        <div class="board">
            <span>{{ Auth::user()->subject ?: 'Guru Pengajar' }}</span>
            <small>{{ $settings['school_name'] ?? 'SD NEGERI LAMA' }}</small>
        </div>
    </div>
</div>

<!-- STATISTICS -->
<div class="stats">
    <div class="stat-card blue">
        <div class="stat-icon">
            <i class="fa-solid fa-users"></i>
        </div>
        <h2>5</h2>
        <p>Kelas yang Diampu</p>
        <a href="#">
            Lihat Detail
            <i class="fa-solid fa-arrow-right"></i>
        </a>
    </div>

    <div class="stat-card green">
        <div class="stat-icon">
            <i class="fa-solid fa-book-open"></i>
        </div>
        <h2>12</h2>
        <p>Materi Pembelajaran</p>
        <a href="#">
            Kelola Materi
            <i class="fa-solid fa-arrow-right"></i>
        </a>
    </div>

    <div class="stat-card purple">
        <div class="stat-icon">
            <i class="fa-solid fa-play"></i>
        </div>
        <h2>8</h2>
        <p>Video Edukasi</p>
        <a href="#">
            Lihat Semua
            <i class="fa-solid fa-arrow-right"></i>
        </a>
    </div>

    <div class="stat-card orange">
        <div class="stat-icon">
            <i class="fa-solid fa-clipboard-list"></i>
        </div>
        <h2>15</h2>
        <p>Tugas / Penilaian</p>
        <a href="#">
            Kelola Tugas
            <i class="fa-solid fa-arrow-right"></i>
        </a>
    </div>
</div>

<!-- GRID -->
<div class="dashboard-grid">

    <!-- LEFT CONTENT -->
    <div class="left-content">

        <!-- VIDEO EDUKASI -->
        <div class="section-card video-section">
            <div class="section-header">
                <div class="section-title">
                    <div class="title-icon purple-icon">
                        <i class="fa-solid fa-circle-play"></i>
                    </div>
                    <div>
                        <h2>Video Edukasi Terbaru</h2>
                        <p>Tonton video pembelajaran untuk memperdalam materi yang diajarkan.</p>
                    </div>
                </div>
                <a href="#">
                    Lihat Semua
                    <i class="fa-solid fa-arrow-right"></i>
                </a>
            </div>

            <!-- VIDEO PLAYER -->
            <div class="video-player">
                <div class="video-thumbnail">
                    <div class="video-content">
                        <div class="video-teacher">
                            <div class="person-head"></div>
                            <div class="person-body"></div>
                        </div>

                        <div class="whiteboard">
                            <h3>{{ Auth::user()->subject ?: 'Materi Pelajaran' }}</h3>
                            <p>Pembelajaran Interaktif</p>
                            <span>SD NEGERI LAMA</span>
                        </div>
                    </div>

                    <button class="play-button" id="btnPlayVideo">
                        <i class="fa-solid fa-play"></i>
                    </button>

                    <div class="video-controls">
                        <div class="progress">
                            <span></span>
                        </div>
                        <div class="control-bottom">
                            <span>
                                <i class="fa-solid fa-play"></i> 0:00 / 10:24
                            </span>
                            <span>
                                <i class="fa-solid fa-volume-high"></i>
                                <i class="fa-solid fa-gear"></i>
                                <i class="fa-solid fa-expand"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="video-info">
                <h3>Konsep Dasar {{ Auth::user()->subject ?: 'Materi Pembelajaran' }}</h3>
                <p>
                    Video ini membahas konsep dasar, rumus penyelesaian, serta contoh soal yang mudah dipahami oleh peserta didik.
                </p>

                <div class="video-bottom">
                    <div class="tags">
                        <span>{{ Auth::user()->subject ?: 'Pelajaran' }}</span>
                        <span>Kelas V</span>
                        <span>
                            <i class="fa-regular fa-clock"></i> 10:24
                        </span>
                    </div>

                    <button class="watch-button">
                        <i class="fa-solid fa-play"></i> Tonton Sekarang
                    </button>
                </div>
            </div>
        </div>

        <!-- MATERI -->
        <div class="section-card">
            <div class="section-header">
                <div class="section-title">
                    <div class="title-icon green-icon">
                        <i class="fa-solid fa-book-open"></i>
                    </div>
                    <div>
                        <h2>Materi Pembelajaran Terbaru</h2>
                        <p>Materi yang baru ditambahkan minggu ini</p>
                    </div>
                </div>
                <a href="#">
                    Lihat Semua
                    <i class="fa-solid fa-arrow-right"></i>
                </a>
            </div>

            <div class="materials">
                <div class="material">
                    <div class="material-icon green">
                        <i class="fa-solid fa-square-root-variable"></i>
                    </div>
                    <div>
                        <h3>Modul Tematik & Karakter Siswa</h3>
                        <p>{{ Auth::user()->subject ?: 'Umum' }} • Kelas V</p>
                    </div>
                    <i class="fa-solid fa-chevron-right"></i>
                </div>

                <div class="material">
                    <div class="material-icon blue">
                        <i class="fa-solid fa-shapes"></i>
                    </div>
                    <div>
                        <h3>Latihan Soal & Ringkasan Bab 3</h3>
                        <p>{{ Auth::user()->subject ?: 'Umum' }} • Kelas IV</p>
                    </div>
                    <i class="fa-solid fa-chevron-right"></i>
                </div>

                <div class="material">
                    <div class="material-icon purple">
                        <i class="fa-solid fa-chart-pie"></i>
                    </div>
                    <div>
                        <h3>Panduan Evaluasi Pembelajaran</h3>
                        <p>{{ Auth::user()->subject ?: 'Umum' }} • Kelas VI</p>
                    </div>
                    <i class="fa-solid fa-chevron-right"></i>
                </div>
            </div>
        </div>

    </div>

    <!-- RIGHT CONTENT -->
    <div class="right-content">

        <!-- KELAS -->
        <div class="section-card">
            <div class="section-header">
                <h2>
                    <i class="fa-solid fa-users"></i> Kelas Saya
                </h2>
                <a href="#">
                    Lihat Semua <i class="fa-solid fa-arrow-right"></i>
                </a>
            </div>

            <div class="classes">
                <div class="class-item">
                    <div class="class-icon cyan">IV</div>
                    <div class="class-info">
                        <strong>Kelas 4A</strong>
                        <span>{{ Auth::user()->subject ?: 'Guru Pengajar' }}</span>
                    </div>
                    <small>28 siswa</small>
                    <i class="fa-solid fa-chevron-right"></i>
                </div>

                <div class="class-item">
                    <div class="class-icon purple">V</div>
                    <div class="class-info">
                        <strong>Kelas 5A</strong>
                        <span>{{ Auth::user()->subject ?: 'Guru Pengajar' }}</span>
                    </div>
                    <small>30 siswa</small>
                    <i class="fa-solid fa-chevron-right"></i>
                </div>

                <div class="class-item">
                    <div class="class-icon orange">VI</div>
                    <div class="class-info">
                        <strong>Kelas 6B</strong>
                        <span>{{ Auth::user()->subject ?: 'Guru Pengajar' }}</span>
                    </div>
                    <small>26 siswa</small>
                    <i class="fa-solid fa-chevron-right"></i>
                </div>
            </div>
        </div>

        <!-- QUICK ACTION -->
        <div class="section-card quick-card">
            <div class="section-header">
                <h2>
                    <i class="fa-solid fa-bolt"></i> Akses Cepat
                </h2>
            </div>

            <div class="quick-actions">
                <a href="#" class="quick-item">
                    <div class="quick-icon blue">
                        <i class="fa-solid fa-file-circle-plus"></i>
                    </div>
                    <div>
                        <strong>Buat Materi Baru</strong>
                        <span>Unggah materi pembelajaran</span>
                    </div>
                    <i class="fa-solid fa-chevron-right"></i>
                </a>

                <a href="#" class="quick-item">
                    <div class="quick-icon purple">
                        <i class="fa-solid fa-video"></i>
                    </div>
                    <div>
                        <strong>Unggah Video Edukasi</strong>
                        <span>Tambah video pembelajaran</span>
                    </div>
                    <i class="fa-solid fa-chevron-right"></i>
                </a>

                <a href="#" class="quick-item">
                    <div class="quick-icon orange">
                        <i class="fa-solid fa-clipboard-list"></i>
                    </div>
                    <div>
                        <strong>Buat Tugas</strong>
                        <span>Atur tugas untuk siswa</span>
                    </div>
                    <i class="fa-solid fa-chevron-right"></i>
                </a>

                <a href="{{ route('pengumuman.index') }}" class="quick-item">
                    <div class="quick-icon green">
                        <i class="fa-solid fa-calendar-days"></i>
                    </div>
                    <div>
                        <strong>Pengumuman Sekolah</strong>
                        <span>Info dan berita sekolah</span>
                    </div>
                    <i class="fa-solid fa-chevron-right"></i>
                </a>
            </div>
        </div>

    </div>

</div>
@endsection

@section('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const btnPlay = document.getElementById("btnPlayVideo");
        if (btnPlay) {
            btnPlay.addEventListener("click", function () {
                this.classList.toggle("playing");
                if (this.classList.contains("playing")) {
                    this.innerHTML = '<i class="fa-solid fa-pause"></i>';
                } else {
                    this.innerHTML = '<i class="fa-solid fa-play"></i>';
                }
            });
        }
    });
</script>
@endsection
