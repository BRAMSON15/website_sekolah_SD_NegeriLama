@extends('layouts.guru')

@section('title', 'Dashboard Guru - ' . ($settings['school_name'] ?? 'SD Negeri Negeri Lama'))

@section('content')
@if (session('success'))
<div class="gd-flash">
    <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
</div>
@endif

<!-- WELCOME -->
<section class="gd-hero">
    <div class="gd-hero-glow gd-hero-glow--teal" aria-hidden="true"></div>
    <div class="gd-hero-glow gd-hero-glow--blue" aria-hidden="true"></div>

    <div class="gd-hero-main">
        <span class="gd-hero-chip">
            <i class="fa-solid fa-chalkboard-user"></i> Ruang Kerja Guru
        </span>
        <h1>Selamat datang, <span>{{ $user->name }}</span>!</h1>
        <p>
            Semoga hari ini penuh inspirasi dan semangat untuk mencerdaskan generasi bangsa
            di {{ $settings['school_name'] ?? 'SD Negeri Negeri Lama' }}.
        </p>
        <div class="gd-hero-meta">
            <span><i class="fa-regular fa-calendar-days"></i> {{ now()->locale('id')->translatedFormat('l, d F Y') }}</span>
            <span><i class="fa-solid fa-book-open"></i> {{ $user->subject ?: 'Guru Pengajar' }}</span>
            <span class="gd-hero-status"><span class="gd-pulse"></span> Siap mengajar</span>
        </div>

        <div class="gd-hero-actions">
            <a href="{{ route('guru.materi') }}" class="gd-btn gd-btn--primary">
                <i class="fa-solid fa-file-arrow-up"></i> Unggah Materi
            </a>
            <a href="{{ route('guru.video') }}" class="gd-btn gd-btn--ghost">
                <i class="fa-solid fa-video"></i> Tambah Video
            </a>
        </div>
    </div>

    <div class="teacher-illustration" aria-hidden="true">
        <div class="teacher">
            <div class="teacher-head"></div>
            <div class="teacher-body"></div>
        </div>

        <div class="board">
            <span>{{ $user->subject ?: 'Guru Pengajar' }}</span>
            <small>{{ $settings['school_name'] ?? 'SD Negeri Negeri Lama' }}</small>
        </div>
    </div>
</section>

<!-- DOWNLOAD APLIKASI DESKTOP -->
<div class="gd-desktop-download">
    <div class="gd-desktop-download-icon">
        <i class="fa-solid fa-desktop"></i>
    </div>
    <div class="gd-desktop-download-info">
        <h3><i class="fa-solid fa-download"></i> Download Aplikasi Desktop</h3>
        <p>Akses portal guru lebih mudah tanpa perlu membuka browser. Install aplikasi desktop khusus guru.</p>
        <div class="gd-desktop-features">
            <span><i class="fa-solid fa-check-circle"></i> Buka langsung dari desktop</span>
            <span><i class="fa-solid fa-check-circle"></i> Tanpa perlu buka browser</span>
            <span><i class="fa-solid fa-check-circle"></i> Windows 64-bit</span>
        </div>
    </div>
    <div class="gd-desktop-download-action">
        @if(file_exists(public_path('downloads/sd-negeri-lama-guru.zip')))
            <a href="{{ asset('downloads/sd-negeri-lama-guru.zip') }}" download class="gd-btn-download">
                <i class="fa-solid fa-download"></i>
                <span>
                    <strong>Download Aplikasi Guru</strong>
                    <small>{{ number_format(filesize(public_path('downloads/sd-negeri-lama-guru.zip')) / 1024 / 1024, 1) }} MB · Windows 64-bit</small>
                </span>
            </a>
            <p class="gd-download-hint"><i class="fa-solid fa-circle-info"></i> Ekstrak ZIP lalu jalankan file <code>.exe</code> di dalamnya.</p>
        @else
            <div class="gd-btn-download gd-btn-download--unavailable">
                <i class="fa-solid fa-clock"></i>
                <span>
                    <strong>Segera Tersedia</strong>
                    <small>Aplikasi sedang disiapkan</small>
                </span>
            </div>
        @endif
    </div>
</div>

<!-- STATISTICS -->
<div class="gd-stats">
    <a href="{{ route('guru.kelas.index') }}" class="gd-stat gd-stat--blue">
        <span class="gd-stat-accent" aria-hidden="true"></span>
        <div class="gd-stat-icon"><i class="fa-solid fa-users-rectangle"></i></div>
        <div class="gd-stat-info">
            <span class="gd-stat-label">Kelas Diampu</span>
            <h2>{{ $stats['classes'] ?? 0 }}</h2>
            <span class="gd-stat-note"><i class="fa-solid fa-door-open"></i> Kelas yang Anda ampu</span>
        </div>
        <i class="fa-solid fa-users-rectangle gd-stat-ghost" aria-hidden="true"></i>
    </a>

    <a href="{{ route('guru.materi') }}" class="gd-stat gd-stat--emerald">
        <span class="gd-stat-accent" aria-hidden="true"></span>
        <div class="gd-stat-icon"><i class="fa-solid fa-book-open"></i></div>
        <div class="gd-stat-info">
            <span class="gd-stat-label">Materi Pembelajaran</span>
            <h2>{{ $stats['materials'] ?? 0 }}</h2>
            <span class="gd-stat-note"><i class="fa-solid fa-folder-open"></i> Modul siap dibagikan</span>
        </div>
        <i class="fa-solid fa-book-open gd-stat-ghost" aria-hidden="true"></i>
    </a>

    <a href="{{ route('guru.video') }}" class="gd-stat gd-stat--violet">
        <span class="gd-stat-accent" aria-hidden="true"></span>
        <div class="gd-stat-icon"><i class="fa-solid fa-circle-play"></i></div>
        <div class="gd-stat-info">
            <span class="gd-stat-label">Video Edukasi</span>
            <h2>{{ $stats['videos'] ?? 0 }}</h2>
            <span class="gd-stat-note"><i class="fa-solid fa-film"></i> Media pembelajaran</span>
        </div>
        <i class="fa-solid fa-circle-play gd-stat-ghost" aria-hidden="true"></i>
    </a>

    <a href="{{ route('guru.pengumuman') }}" class="gd-stat gd-stat--amber">
        <span class="gd-stat-accent" aria-hidden="true"></span>
        <div class="gd-stat-icon"><i class="fa-solid fa-bullhorn"></i></div>
        <div class="gd-stat-info">
            <span class="gd-stat-label">Pengumuman Sekolah</span>
            <h2>{{ $stats['announcements'] ?? 0 }}</h2>
            <span class="gd-stat-note"><i class="fa-solid fa-envelope-open-text"></i> Informasi terbaru</span>
        </div>
        <i class="fa-solid fa-bullhorn gd-stat-ghost" aria-hidden="true"></i>
    </a>
</div>

<!-- GRID -->
<div class="gd-grid">

    <!-- LEFT CONTENT -->
    <div class="gd-col">

        <!-- VIDEO EDUKASI -->
        <section class="gd-card">
            <div class="gd-card-head">
                <div class="gd-card-title">
                    <span class="gd-title-icon gd-title-icon--violet">
                        <i class="fa-solid fa-circle-play"></i>
                    </span>
                    <div>
                        <h2>Video Edukasi Terbaru</h2>
                        <p>Tonton video pembelajaran untuk memperdalam materi yang diajarkan.</p>
                    </div>
                </div>
                <a href="{{ route('guru.video') }}" class="gd-card-link">
                    Lihat Semua <i class="fa-solid fa-arrow-right"></i>
                </a>
            </div>

            @if(isset($featuredVideo) && $featuredVideo)
            <!-- VIDEO PLAYER -->
            <div class="gd-player">
                <iframe src="{{ $featuredVideo->is_youtube ? $featuredVideo->embed_url . '?rel=0&modestbranding=1' : $featuredVideo->embed_url }}" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
            </div>

            <div class="gd-video-head">
                <span class="gd-source-badge" style="background: {{ $featuredVideo->source_badge['bg_color'] }}; color: {{ $featuredVideo->source_badge['color'] }}; border-color: {{ $featuredVideo->source_badge['border'] }};">
                    <i class="{{ $featuredVideo->source_badge['icon'] }}"></i> {{ $featuredVideo->source_badge['label'] }}
                </span>
                <h3>{{ $featuredVideo->title }}</h3>
            </div>
            <p class="gd-video-desc">{{ $featuredVideo->description }}</p>

            <div class="gd-video-foot">
                <div class="gd-tags">
                    <span>{{ $featuredVideo->subject }}</span>
                    <span>{{ $featuredVideo->class_level }}</span>
                    <span><i class="fa-regular fa-clock"></i> {{ $featuredVideo->duration }}</span>
                    <span><i class="fa-regular fa-eye"></i> {{ $featuredVideo->views_count }}x ditonton</span>
                </div>

                <a href="{{ route('guru.video', ['play' => $featuredVideo->id]) }}" class="gd-watch">
                    <i class="fa-solid fa-play"></i> Putar Lengkap
                </a>
            </div>
            @else
            <div class="gd-empty">
                <i class="fa-solid fa-video"></i>
                <p>Belum ada video edukasi yang ditambahkan.</p>
            </div>
            @endif
        </section>

        <!-- MATERI -->
        <section class="gd-card">
            <div class="gd-card-head">
                <div class="gd-card-title">
                    <span class="gd-title-icon gd-title-icon--emerald">
                        <i class="fa-solid fa-book-open"></i>
                    </span>
                    <div>
                        <h2>Materi Pembelajaran Terbaru</h2>
                        <p>Materi dan modul ajar yang siap diunduh peserta didik</p>
                    </div>
                </div>
                <a href="{{ route('guru.materi') }}" class="gd-card-link">
                    Lihat Semua <i class="fa-solid fa-arrow-right"></i>
                </a>
            </div>

            <div class="gd-list">
                @forelse($recentMaterials as $mat)
                <div class="gd-item">
                    <span class="gd-item-icon gd-item-icon--emerald">
                        <i class="fa-solid fa-file-lines"></i>
                    </span>
                    <div class="gd-item-body">
                        <div class="gd-item-title">{{ $mat->title }}</div>
                        <div class="gd-item-meta">{{ $mat->subject }} &bull; {{ $mat->class_level }} &bull; {{ $mat->file_type }} ({{ $mat->file_size }})</div>
                    </div>
                    <a href="{{ route('guru.materi.download', $mat->id) }}" class="gd-icon-btn" title="Unduh Materi" aria-label="Unduh {{ $mat->title }}">
                        <i class="fa-solid fa-download"></i>
                    </a>
                </div>
                @empty
                <div class="gd-empty">
                    <i class="fa-solid fa-folder-open"></i>
                    <p>Belum ada materi pembelajaran yang diunggah.</p>
                </div>
                @endforelse
            </div>
        </section>

    </div>

    <!-- RIGHT CONTENT -->
    <div class="gd-col">

        <!-- KELAS -->
        <section class="gd-card">
            <div class="gd-card-head">
                <div class="gd-card-title">
                    <span class="gd-title-icon gd-title-icon--blue">
                        <i class="fa-solid fa-users"></i>
                    </span>
                    <div>
                        <h2>Jenjang Kelas</h2>
                        <p>Kelas yang Anda ampu saat ini</p>
                    </div>
                </div>
                <a href="{{ route('guru.kelas.index') }}" class="gd-card-link">
                    Kelola Kelas <i class="fa-solid fa-arrow-right"></i>
                </a>
            </div>

            <div class="gd-list">
                @forelse($classesList as $c)
                <div class="gd-item">
                    <span class="gd-class-badge gd-class-badge--{{ $c['badge_color'] }}">{{ $c['badge'] }}</span>
                    <div class="gd-item-body">
                        <div class="gd-item-title">{{ $c['name'] }}</div>
                        <div class="gd-item-meta">{{ $c['subject'] }}</div>
                    </div>
                    <span class="gd-pill"><i class="fa-solid fa-user-group"></i> {{ $c['students_count'] }} siswa</span>
                </div>
                @empty
                <div class="gd-empty">
                    <i class="fa-solid fa-door-closed"></i>
                    <p>Belum ada kelas yang Anda ampu.</p>
                </div>
                @endforelse
            </div>
        </section>

        <!-- QUICK ACTION -->
        <section class="gd-card">
            <div class="gd-card-head">
                <div class="gd-card-title">
                    <span class="gd-title-icon gd-title-icon--amber">
                        <i class="fa-solid fa-bolt"></i>
                    </span>
                    <div>
                        <h2>Akses Cepat</h2>
                        <p>Pintasan aktivitas mengajar Anda</p>
                    </div>
                </div>
            </div>

            <div class="gd-quick">
                <a href="{{ route('guru.kelas.create') }}" class="gd-quick-item">
                    <span class="gd-quick-icon gd-quick-icon--blue">
                        <i class="fa-solid fa-users-rectangle"></i>
                    </span>
                    <div class="gd-quick-body">
                        <strong>Buat Kelas Baru</strong>
                        <span>Tambah kelas yang Anda ampu</span>
                    </div>
                    <i class="fa-solid fa-chevron-right gd-quick-arrow" aria-hidden="true"></i>
                </a>

                <a href="{{ route('guru.materi') }}" class="gd-quick-item">
                    <span class="gd-quick-icon gd-quick-icon--green">
                        <i class="bi bi-file-earmark-plus-fill"></i>
                    </span>
                    <div class="gd-quick-body">
                        <strong>Buat Materi Baru</strong>
                        <span>Unggah materi pembelajaran</span>
                    </div>
                    <i class="fa-solid fa-chevron-right gd-quick-arrow" aria-hidden="true"></i>
                </a>

                <a href="{{ route('guru.video') }}" class="gd-quick-item">
                    <span class="gd-quick-icon gd-quick-icon--violet">
                        <i class="bi bi-camera-video-fill"></i>
                    </span>
                    <div class="gd-quick-body">
                        <strong>Unggah Video Edukasi</strong>
                        <span>Tambah video pembelajaran</span>
                    </div>
                    <i class="fa-solid fa-chevron-right gd-quick-arrow" aria-hidden="true"></i>
                </a>

                <a href="{{ route('guru.pengumuman') }}" class="gd-quick-item">
                    <span class="gd-quick-icon gd-quick-icon--amber">
                        <i class="bi bi-megaphone-fill"></i>
                    </span>
                    <div class="gd-quick-body">
                        <strong>Pengumuman Sekolah</strong>
                        <span>Info dan berita sekolah</span>
                    </div>
                    <i class="fa-solid fa-chevron-right gd-quick-arrow" aria-hidden="true"></i>
                </a>
            </div>
        </section>

    </div>

</div>
@endsection
