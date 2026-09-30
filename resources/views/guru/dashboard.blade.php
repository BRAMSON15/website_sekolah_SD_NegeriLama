@extends('layouts.guru')

@section('title', 'Dashboard Guru - ' . ($settings['school_name'] ?? 'SD NEGERI LAMA'))

@section('content')
@if (session('success'))
<div style="background: #ddf7ed; border: 1px solid #27a879; color: #1e7e5a; padding: 14px 20px; border-radius: 12px; margin-bottom: 20px; font-weight: 600; display: flex; align-items: center; gap: 10px;">
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
    <div class="stat-card green">
        <div class="stat-icon">
            <i class="bi bi-book-half"></i>
        </div>
        <h2>{{ $stats['materials'] ?? 0 }}</h2>
        <p>Materi Pembelajaran</p>
        <a href="{{ route('guru.materi') }}">
            Kelola Materi
            <i class="bi bi-arrow-right"></i>
        </a>
    </div>

    <div class="stat-card purple">
        <div class="stat-icon">
            <i class="bi bi-play-circle-fill"></i>
        </div>
        <h2>{{ $stats['videos'] ?? 0 }}</h2>
        <p>Video Edukasi</p>
        <a href="{{ route('guru.video') }}">
            Lihat Semua
            <i class="bi bi-arrow-right"></i>
        </a>
    </div>

    <div class="stat-card blue">
        <div class="stat-icon">
            <i class="bi bi-calendar-event-fill"></i>
        </div>
        <h2>Kaldik</h2>
        <p>Kalender Akademik</p>
        <a href="{{ route('guru.kalender') }}">
            Lihat Agenda
            <i class="bi bi-arrow-right"></i>
        </a>
    </div>

    <div class="stat-card orange">
        <div class="stat-icon">
            <i class="bi bi-megaphone-fill"></i>
        </div>
        <h2>{{ $stats['announcements'] ?? 0 }}</h2>
        <p>Pengumuman Sekolah</p>
        <a href="{{ route('guru.pengumuman') }}">
            Lihat Pengumuman
            <i class="bi bi-arrow-right"></i>
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
                <a href="{{ route('guru.video') }}">
                    Lihat Semua
                    <i class="fa-solid fa-arrow-right"></i>
                </a>
            </div>

            @if(isset($featuredVideo) && $featuredVideo)
            <!-- VIDEO PLAYER -->
            <div style="border-radius: 16px; overflow: hidden; position: relative; background: #000; margin-bottom: 16px; aspect-ratio: 16/9; box-shadow: 0 8px 24px rgba(0,0,0,0.12);">
                <iframe src="{{ $featuredVideo->is_youtube ? $featuredVideo->embed_url . '?rel=0&modestbranding=1' : $featuredVideo->embed_url }}" style="width: 100%; height: 100%; border: none;" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
            </div>

            <div class="video-info">
                <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 6px; flex-wrap: wrap;">
                    <span style="display: inline-flex; align-items: center; gap: 5px; background: {{ $featuredVideo->source_badge['bg_color'] }}; color: {{ $featuredVideo->source_badge['color'] }}; border: 1px solid {{ $featuredVideo->source_badge['border'] }}; padding: 2px 9px; border-radius: 12px; font-size: 0.72rem; font-weight: 700;">
                        <i class="{{ $featuredVideo->source_badge['icon'] }}"></i> {{ $featuredVideo->source_badge['label'] }}
                    </span>
                    <h3 style="font-size: 1.15rem; font-weight: 700; color: var(--text); margin: 0;">{{ $featuredVideo->title }}</h3>
                </div>
                <p style="font-size: 0.88rem; color: var(--muted); line-height: 1.6; margin-bottom: 14px;">
                    {{ $featuredVideo->description }}
                </p>

                <div class="video-bottom">
                    <div class="tags">
                        <span>{{ $featuredVideo->subject }}</span>
                        <span>{{ $featuredVideo->class_level }}</span>
                        <span>
                            <i class="fa-regular fa-clock"></i> {{ $featuredVideo->duration }}
                        </span>
                        <span>
                            <i class="fa-regular fa-eye"></i> {{ $featuredVideo->views_count }}x ditonton
                        </span>
                    </div>

                    <a href="{{ route('guru.video', ['play' => $featuredVideo->id]) }}" class="watch-button" style="text-decoration: none;">
                        <i class="fa-solid fa-play"></i> Putar Lengkap
                    </a>
                </div>
            </div>
            @else
            <p style="color: var(--muted); font-size: 0.9rem;">Belum ada video edukasi yang ditambahkan.</p>
            @endif
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
                        <p>Materi dan modul ajar yang siap diunduh peserta didik</p>
                    </div>
                </div>
                <a href="{{ route('guru.materi') }}">
                    Lihat Semua
                    <i class="fa-solid fa-arrow-right"></i>
                </a>
            </div>

            <div class="materials">
                @forelse($recentMaterials as $mat)
                <div class="material">
                    <div class="material-icon green">
                        <i class="fa-solid fa-file-lines"></i>
                    </div>
                    <div style="flex: 1;">
                        <h3 style="font-size: 0.95rem; font-weight: 700; color: var(--text); margin-bottom: 2px;">{{ $mat->title }}</h3>
                        <p style="font-size: 0.8rem; color: var(--muted); margin: 0;">{{ $mat->subject }} • {{ $mat->class_level }} • {{ $mat->file_type }} ({{ $mat->file_size }})</p>
                    </div>
                    <a href="{{ route('guru.materi.download', $mat->id) }}" title="Unduh Materi" style="color: var(--primary); padding: 8px; font-size: 1.1rem;">
                        <i class="fa-solid fa-download"></i>
                    </a>
                </div>
                @empty
                <p style="color: var(--muted); font-size: 0.9rem;">Belum ada materi pembelajaran yang diunggah.</p>
                @endforelse
            </div>
        </div>

    </div>

    <!-- RIGHT CONTENT -->
    <div class="right-content">

        <!-- KELAS -->
        <div class="section-card">
            <div class="section-header">
                <h2>
                    <i class="fa-solid fa-users"></i> Jenjang Kelas
                </h2>
                <a href="{{ route('guru.materi') }}">
                    Materi Kelas <i class="fa-solid fa-arrow-right"></i>
                </a>
            </div>

            <div class="classes">
                @foreach($classesList as $c)
                <div class="class-item" style="cursor: default;">
                    <div class="class-icon {{ $c['badge_color'] }}">{{ $c['badge'] }}</div>
                    <div class="class-info">
                        <strong>{{ $c['name'] }}</strong>
                        <span>{{ $c['subject'] }}</span>
                    </div>
                    <small>{{ $c['students_count'] }} siswa</small>
                </div>
                @endforeach
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
                <a href="{{ route('guru.materi') }}" class="quick-item">
                    <div class="quick-icon blue">
                        <i class="bi bi-file-earmark-plus-fill"></i>
                    </div>
                    <div>
                        <strong>Buat Materi Baru</strong>
                        <span>Unggah materi pembelajaran</span>
                    </div>
                    <i class="bi bi-chevron-right"></i>
                </a>

                <a href="{{ route('guru.video') }}" class="quick-item">
                    <div class="quick-icon purple">
                        <i class="bi bi-camera-video-fill"></i>
                    </div>
                    <div>
                        <strong>Unggah Video Edukasi</strong>
                        <span>Tambah video pembelajaran</span>
                    </div>
                    <i class="bi bi-chevron-right"></i>
                </a>

                <a href="{{ route('guru.kalender') }}" class="quick-item">
                    <div class="quick-icon orange">
                        <i class="bi bi-calendar-event-fill"></i>
                    </div>
                    <div>
                        <strong>Kalender Akademik</strong>
                        <span>Cek agenda & unduh kaldik</span>
                    </div>
                    <i class="bi bi-chevron-right"></i>
                </a>

                <a href="{{ route('guru.pengumuman') }}" class="quick-item">
                    <div class="quick-icon green">
                        <i class="bi bi-megaphone-fill"></i>
                    </div>
                    <div>
                        <strong>Pengumuman Sekolah</strong>
                        <span>Info dan berita sekolah</span>
                    </div>
                    <i class="bi bi-chevron-right"></i>
                </a>
            </div>
        </div>

    </div>

</div>
@endsection
