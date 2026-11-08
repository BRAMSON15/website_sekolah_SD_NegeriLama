@extends('layouts.admin')

@section('title', 'Dashboard Admin - ' . ($settings['school_name'] ?? 'SD Negeri Negeri Lama'))

@section('content')
@if (session('success'))
<div class="ad-flash">
    <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
</div>
@endif

@php
    $ppdbTotal = $stats['ppdbTotal'] ?? 0;
    $ppdbPending = $stats['ppdbPending'] ?? 0;
    $ppdbAccepted = $stats['ppdbAccepted'] ?? 0;
    $ppdbOther = max($ppdbTotal - $ppdbPending - $ppdbAccepted, 0);
    $pctAccepted = $ppdbTotal > 0 ? (int) round($ppdbAccepted / $ppdbTotal * 100) : 0;
    $pctPending = $ppdbTotal > 0 ? (int) round($ppdbPending / $ppdbTotal * 100) : 0;
    $pctOther = $ppdbTotal > 0 ? max(100 - $pctAccepted - $pctPending, 0) : 0;
@endphp

<!-- HERO -->
<section class="ad-hero">
    <div class="ad-hero-glow ad-hero-glow--sky" aria-hidden="true"></div>
    <div class="ad-hero-glow ad-hero-glow--indigo" aria-hidden="true"></div>

    <div class="ad-hero-main">
        <span class="ad-hero-chip">
            <i class="fa-solid fa-shield-halved"></i> Panel Administrator
        </span>
        <h1>Selamat datang, <span>{{ $user->name }}</span>!</h1>
        <p>
            Kelola data sekolah, akun pengguna, dan konten website
            {{ $settings['school_name'] ?? 'SD Negeri Negeri Lama' }} dari satu pusat kendali.
        </p>
        <div class="ad-hero-meta">
            <span><i class="fa-regular fa-calendar-days"></i> {{ now()->locale('id')->translatedFormat('l, d F Y') }}</span>
            <span><i class="fa-solid fa-user-shield"></i> Administrator</span>
            <span class="ad-hero-status"><span class="ad-pulse"></span> Sistem aktif</span>
        </div>

        <div class="ad-hero-actions">
            <a href="{{ route('admin.informasi') }}" class="ad-btn ad-btn--primary">
                <i class="fa-solid fa-circle-info"></i> Kelola Informasi Sekolah
            </a>
            <a href="{{ route('admin.ppdb.index') }}" class="ad-btn ad-btn--ghost">
                <i class="fa-solid fa-id-card"></i> Data PPDB
            </a>
        </div>
    </div>

    <div class="ad-console" aria-hidden="true">
        <div class="ad-console-top">
            <span></span><span></span><span></span>
            <em>admin panel</em>
        </div>
        <div class="ad-console-metrics">
            <div class="ad-console-metric">
                <i class="fa-solid fa-user-tie"></i>
                <b></b>
                <small></small>
            </div>
            <div class="ad-console-metric ad-console-metric--amber">
                <i class="fa-solid fa-clipboard-list"></i>
                <b></b>
                <small></small>
            </div>
        </div>
        <div class="ad-console-chart">
            <span style="--h: 42%"></span>
            <span style="--h: 66%"></span>
            <span style="--h: 52%"></span>
            <span style="--h: 84%"></span>
            <span style="--h: 72%"></span>
            <span style="--h: 96%"></span>
        </div>
        <div class="ad-console-foot">
            <span></span><span></span>
        </div>
    </div>
</section>

<!-- STATISTICS -->
<div class="ad-stats">
    <a href="{{ route('admin.teachers.index') }}" class="ad-stat ad-stat--blue">
        <span class="ad-stat-accent" aria-hidden="true"></span>
        <div class="ad-stat-icon"><i class="fa-solid fa-user-tie"></i></div>
        <div class="ad-stat-info">
            <span class="ad-stat-label">Akun Guru</span>
            <h2>{{ $stats['teachers'] ?? 0 }}</h2>
            <span class="ad-stat-note"><i class="fa-solid fa-chalkboard-user"></i> Guru terdaftar</span>
        </div>
        <i class="fa-solid fa-user-tie ad-stat-ghost" aria-hidden="true"></i>
    </a>

    <a href="{{ route('admin.students.index') }}" class="ad-stat ad-stat--emerald">
        <span class="ad-stat-accent" aria-hidden="true"></span>
        <div class="ad-stat-icon"><i class="fa-solid fa-user-graduate"></i></div>
        <div class="ad-stat-info">
            <span class="ad-stat-label">Data Siswa</span>
            <h2>{{ $stats['students'] ?? 0 }}</h2>
            <span class="ad-stat-note"><i class="fa-solid fa-users"></i> Siswa aktif terdata</span>
        </div>
        <i class="fa-solid fa-user-graduate ad-stat-ghost" aria-hidden="true"></i>
    </a>

    <a href="{{ route('admin.ppdb.index') }}" class="ad-stat ad-stat--amber">
        <span class="ad-stat-accent" aria-hidden="true"></span>
        <div class="ad-stat-icon"><i class="fa-solid fa-id-card"></i></div>
        <div class="ad-stat-info">
            <span class="ad-stat-label">Pendaftar PPDB</span>
            <h2>{{ $stats['ppdbTotal'] ?? 0 }}</h2>
            <span class="ad-stat-note"><i class="fa-solid fa-hourglass-half"></i> {{ $stats['ppdbPending'] ?? 0 }} menunggu verifikasi</span>
        </div>
        <i class="fa-solid fa-id-card ad-stat-ghost" aria-hidden="true"></i>
    </a>

    <a href="{{ route('admin.pengumuman.index') }}" class="ad-stat ad-stat--violet">
        <span class="ad-stat-accent" aria-hidden="true"></span>
        <div class="ad-stat-icon"><i class="fa-solid fa-bullhorn"></i></div>
        <div class="ad-stat-info">
            <span class="ad-stat-label">Pengumuman</span>
            <h2>{{ $stats['announcements'] ?? 0 }}</h2>
            <span class="ad-stat-note"><i class="fa-solid fa-envelope-open-text"></i> {{ $stats['activeAnnouncements'] ?? 0 }} aktif dipublikasikan</span>
        </div>
        <i class="fa-solid fa-bullhorn ad-stat-ghost" aria-hidden="true"></i>
    </a>
</div>

<!-- CONTENT GRID -->
<div class="ad-grid">
    <div class="ad-col">
        <!-- ANNOUNCEMENTS -->
        <section class="ad-card">
            <div class="ad-card-head">
                <div class="ad-card-title">
                    <span class="ad-title-icon ad-title-icon--violet">
                        <i class="fa-solid fa-bullhorn"></i>
                    </span>
                    <div>
                        <h2>Pengumuman Terbaru</h2>
                        <p>Informasi yang baru dipublikasikan untuk warga sekolah</p>
                    </div>
                </div>
                <a href="{{ route('admin.pengumuman.index') }}" class="ad-card-link">
                    Kelola Semua <i class="fa-solid fa-arrow-right"></i>
                </a>
            </div>

            @forelse($recentAnnouncements as $item)
            <a href="{{ route('admin.pengumuman.edit', $item) }}" class="ad-item ad-item--link">
                <span class="ad-item-icon {{ $loop->index % 2 === 0 ? 'ad-item-icon--violet' : 'ad-item-icon--blue' }}">
                    <i class="fa-solid {{ $loop->index % 2 === 0 ? 'fa-bell' : 'fa-megaphone' }}"></i>
                </span>
                <span class="ad-item-body">
                    <span class="ad-item-title">{{ $item->title }}</span>
                    <span class="ad-item-meta">
                        <i class="fa-regular fa-calendar"></i>
                        {{ $item->published_at ? $item->published_at->locale('id')->translatedFormat('d F Y') : 'Belum dipublikasikan' }}
                        <span class="ad-dot"></span>
                        <span class="ad-chip {{ $item->is_active ? 'ad-chip--green' : 'ad-chip--slate' }}">
                            {{ $item->is_active ? 'Aktif' : 'Draf' }}
                        </span>
                    </span>
                </span>
                <i class="fa-solid fa-chevron-right ad-item-arrow" aria-hidden="true"></i>
            </a>
            @empty
            <div class="ad-empty">
                <i class="fa-solid fa-bullhorn"></i>
                <p>Belum ada pengumuman. Publikasikan informasi pertama untuk sekolah.</p>
                <a href="{{ route('admin.pengumuman.create') }}" class="ad-empty-btn">Buat Pengumuman</a>
            </div>
            @endforelse
        </section>

        <!-- PPDB SUMMARY -->
        <section class="ad-card">
            <div class="ad-card-head">
                <div class="ad-card-title">
                    <span class="ad-title-icon ad-title-icon--amber">
                        <i class="fa-solid fa-chart-simple"></i>
                    </span>
                    <div>
                        <h2>Ringkasan PPDB</h2>
                        <p>Status pendaftaran peserta didik baru tahun ini</p>
                    </div>
                </div>
                <a href="{{ route('admin.ppdb.index') }}" class="ad-card-link">
                    Data Pendaftar <i class="fa-solid fa-arrow-right"></i>
                </a>
            </div>

            <div class="ad-ppdb-top">
                <div class="ad-ppdb-total">
                    <strong>{{ $ppdbTotal }}</strong>
                    <span>Total pendaftar</span>
                </div>
                <span class="ad-ppdb-year">TA {{ now()->year }}/{{ now()->year + 1 }}</span>
            </div>

            <div class="ad-bar" role="img" aria-label="Diterima {{ $pctAccepted }}%, menunggu {{ $pctPending }}%, lainnya {{ $pctOther }}%">
                <span class="ad-bar-seg ad-bar-seg--green" style="width: {{ $pctAccepted }}%"></span>
                <span class="ad-bar-seg ad-bar-seg--amber" style="width: {{ $pctPending }}%"></span>
                <span class="ad-bar-seg ad-bar-seg--slate" style="width: {{ $pctOther }}%"></span>
            </div>

            <div class="ad-ppdb-rows">
                <div class="ad-ppdb-row">
                    <span class="ad-ppdb-dot ad-ppdb-dot--green"></span>
                    <span class="ad-ppdb-label">Diterima</span>
                    <strong>{{ $ppdbAccepted }}</strong>
                    <em>{{ $pctAccepted }}%</em>
                </div>
                <div class="ad-ppdb-row">
                    <span class="ad-ppdb-dot ad-ppdb-dot--amber"></span>
                    <span class="ad-ppdb-label">Menunggu verifikasi</span>
                    <strong>{{ $ppdbPending }}</strong>
                    <em>{{ $pctPending }}%</em>
                </div>
                <div class="ad-ppdb-row">
                    <span class="ad-ppdb-dot ad-ppdb-dot--slate"></span>
                    <span class="ad-ppdb-label">Belum diproses / lainnya</span>
                    <strong>{{ $ppdbOther }}</strong>
                    <em>{{ $pctOther }}%</em>
                </div>
            </div>
        </section>
    </div>

    <div class="ad-col">
        <!-- QUICK ACTIONS -->
        <section class="ad-card">
            <div class="ad-card-head">
                <div class="ad-card-title">
                    <span class="ad-title-icon ad-title-icon--blue">
                        <i class="fa-solid fa-bolt"></i>
                    </span>
                    <div>
                        <h2>Akses Cepat</h2>
                        <p>Pintasan pengelolaan harian</p>
                    </div>
                </div>
            </div>

            <div class="ad-quick">
                <a href="{{ route('admin.teachers.index') }}" class="ad-quick-item">
                    <span class="ad-quick-icon ad-quick-icon--blue"><i class="fa-solid fa-user-tie"></i></span>
                    <span class="ad-quick-body">
                        <strong>Kelola Akun Guru</strong>
                        <span>Tambah dan atur akun guru</span>
                    </span>
                    <i class="fa-solid fa-chevron-right ad-quick-arrow" aria-hidden="true"></i>
                </a>

                <a href="{{ route('admin.students.index') }}" class="ad-quick-item">
                    <span class="ad-quick-icon ad-quick-icon--green"><i class="fa-solid fa-user-graduate"></i></span>
                    <span class="ad-quick-body">
                        <strong>Kelola Data Siswa</strong>
                        <span>Perbarui data dan kelas siswa</span>
                    </span>
                    <i class="fa-solid fa-chevron-right ad-quick-arrow" aria-hidden="true"></i>
                </a>

                <a href="{{ route('admin.ppdb.index') }}" class="ad-quick-item">
                    <span class="ad-quick-icon ad-quick-icon--amber"><i class="fa-solid fa-id-card"></i></span>
                    <span class="ad-quick-body">
                        <strong>Verifikasi PPDB</strong>
                        <span>Tinjau pendaftar peserta didik baru</span>
                    </span>
                    <i class="fa-solid fa-chevron-right ad-quick-arrow" aria-hidden="true"></i>
                </a>

                <a href="{{ route('admin.pengumuman.create') }}" class="ad-quick-item">
                    <span class="ad-quick-icon ad-quick-icon--violet"><i class="fa-solid fa-bullhorn"></i></span>
                    <span class="ad-quick-body">
                        <strong>Buat Pengumuman</strong>
                        <span>Publikasikan informasi terbaru</span>
                    </span>
                    <i class="fa-solid fa-chevron-right ad-quick-arrow" aria-hidden="true"></i>
                </a>

                <a href="{{ route('admin.website.profil') }}" class="ad-quick-item">
                    <span class="ad-quick-icon ad-quick-icon--teal"><i class="fa-solid fa-school"></i></span>
                    <span class="ad-quick-body">
                        <strong>Kelola Profil Sekolah</strong>
                        <span>Perbarui identitas dan sambutan</span>
                    </span>
                    <i class="fa-solid fa-chevron-right ad-quick-arrow" aria-hidden="true"></i>
                </a>

                <a href="{{ route('admin.fitur.index') }}" class="ad-quick-item">
                    <span class="ad-quick-icon ad-quick-icon--indigo"><i class="fa-solid fa-star"></i></span>
                    <span class="ad-quick-body">
                        <strong>Fitur &amp; Layanan</strong>
                        <span>Atur program unggulan sekolah</span>
                    </span>
                    <i class="fa-solid fa-chevron-right ad-quick-arrow" aria-hidden="true"></i>
                </a>
            </div>
        </section>

        <!-- SYSTEM SUMMARY -->
        <section class="ad-card">
            <div class="ad-card-head">
                <div class="ad-card-title">
                    <span class="ad-title-icon ad-title-icon--slate">
                        <i class="fa-solid fa-sliders"></i>
                    </span>
                    <div>
                        <h2>Ringkasan Sistem</h2>
                        <p>Konten pendukung website sekolah</p>
                    </div>
                </div>
            </div>

            <div class="ad-list">
                <a href="{{ route('admin.fitur.index') }}" class="ad-mini-row">
                    <span class="ad-mini-icon ad-mini-icon--blue"><i class="fa-solid fa-star"></i></span>
                    <span class="ad-mini-body">
                        <strong>Fitur &amp; Layanan</strong>
                        <small>{{ $stats['features'] ?? 0 }} item terdaftar</small>
                    </span>
                    <i class="fa-solid fa-chevron-right" aria-hidden="true"></i>
                </a>

                <a href="{{ route('admin.informasi') }}" class="ad-mini-row">
                    <span class="ad-mini-icon ad-mini-icon--green"><i class="fa-solid fa-gear"></i></span>
                    <span class="ad-mini-body">
                        <strong>Pengaturan Sistem</strong>
                        <small>{{ $stats['settings'] ?? 0 }} pengaturan tersimpan</small>
                    </span>
                    <i class="fa-solid fa-chevron-right" aria-hidden="true"></i>
                </a>

                <a href="{{ route('home') }}" target="_blank" class="ad-mini-row">
                    <span class="ad-mini-icon ad-mini-icon--amber"><i class="fa-solid fa-globe"></i></span>
                    <span class="ad-mini-body">
                        <strong>Website Publik</strong>
                        <small>Lihat tampilan halaman sekolah</small>
                    </span>
                    <i class="fa-solid fa-arrow-up-right-from-square" aria-hidden="true"></i>
                </a>
            </div>
        </section>
    </div>
</div>
@endsection
