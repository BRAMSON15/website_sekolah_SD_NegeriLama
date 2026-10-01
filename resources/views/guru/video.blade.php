@extends('layouts.guru')

@section('title', 'Kelola Video Edukasi & Pembelajaran - ' . ($settings['school_name'] ?? 'SD NEGERI LAMA'))

@section('content')
<!-- NOTIFICATION ALERTS -->
@if(session('success'))
<div style="background: #dcfce7; border: 1px solid #86efac; color: #166534; padding: 14px 18px; border-radius: 12px; margin-bottom: 22px; display: flex; align-items: center; gap: 12px; font-weight: 600; box-shadow: 0 4px 12px rgba(22, 163, 74, 0.08);">
    <i class="fa-solid fa-circle-check" style="font-size: 1.3rem; color: #16a34a; flex-shrink: 0;"></i>
    <span>{{ session('success') }}</span>
</div>
@endif

@if(isset($errors) && $errors->any())
<div style="background: #fee2e2; border: 1px solid #fca5a5; color: #991b1b; padding: 14px 18px; border-radius: 12px; margin-bottom: 22px; box-shadow: 0 4px 12px rgba(220, 38, 38, 0.08);">
    <div style="font-weight: 700; margin-bottom: 6px; display: flex; align-items: center; gap: 8px;">
        <i class="fa-solid fa-triangle-exclamation"></i> Terjadi kesalahan input video:
    </div>
    <ul style="margin: 0; padding-left: 20px; font-size: 0.9rem;">
        @foreach($errors->all() as $err)
            <li>{{ $err }}</li>
        @endforeach
    </ul>
</div>
@endif

<!-- BREADCRUMB / HERO BANNER -->
<div class="welcome" style="margin-bottom: 25px;">
    <div class="welcome-text">
        <h1>
            <i class="fa-solid fa-circle-play"></i> Video Edukasi & Pembelajaran
        </h1>
        <p>
            Kelola dan bagikan media pembelajaran visual interaktif untuk peserta didik. Mendukung integrasi video dari <strong>YouTube</strong> dan berkas video <strong>Google Drive</strong>.
        </p>
    </div>
    <div class="teacher-illustration">
        <div class="teacher">
            <div class="teacher-head"></div>
            <div class="teacher-body"></div>
        </div>
        <div class="board" style="min-width: 140px; text-align: center;">
            <span style="font-size: 1.25rem; font-weight: 800;">{{ $stats['total'] ?? count($videos) }} Video</span>
            <small style="font-size: 0.75rem; opacity: 0.9;">YouTube & G-Drive</small>
        </div>
    </div>
</div>

<!-- STATS SUMMARY CARDS -->
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px; margin-bottom: 25px;">
    <!-- Stat 1: Total -->
    <div class="section-card" style="padding: 16px 20px; display: flex; align-items: center; gap: 16px; margin-bottom: 0;">
        <div style="width: 48px; height: 48px; border-radius: 12px; background: #f3e8ff; color: #8b5cf6; display: flex; align-items: center; justify-content: center; font-size: 20px; flex-shrink: 0;">
            <i class="fa-solid fa-clapperboard"></i>
        </div>
        <div>
            <div style="font-size: 0.8rem; color: var(--muted); font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">Total Koleksi</div>
            <div style="font-size: 1.45rem; font-weight: 800; color: var(--text);">{{ $stats['total'] ?? count($videos) }}</div>
        </div>
    </div>

    <!-- Stat 2: YouTube -->
    <div class="section-card" style="padding: 16px 20px; display: flex; align-items: center; gap: 16px; margin-bottom: 0;">
        <div style="width: 48px; height: 48px; border-radius: 12px; background: #fee2e2; color: #dc2626; display: flex; align-items: center; justify-content: center; font-size: 20px; flex-shrink: 0;">
            <i class="fa-brands fa-youtube"></i>
        </div>
        <div>
            <div style="font-size: 0.8rem; color: var(--muted); font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">YouTube</div>
            <div style="font-size: 1.45rem; font-weight: 800; color: #dc2626;">{{ $stats['youtube'] ?? 0 }}</div>
        </div>
    </div>

    <!-- Stat 3: Google Drive -->
    <div class="section-card" style="padding: 16px 20px; display: flex; align-items: center; gap: 16px; margin-bottom: 0;">
        <div style="width: 48px; height: 48px; border-radius: 12px; background: #e0f2fe; color: #0284c7; display: flex; align-items: center; justify-content: center; font-size: 20px; flex-shrink: 0;">
            <i class="fa-brands fa-google-drive"></i>
        </div>
        <div>
            <div style="font-size: 0.8rem; color: var(--muted); font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">Google Drive</div>
            <div style="font-size: 1.45rem; font-weight: 800; color: #0284c7;">{{ $stats['google_drive'] ?? 0 }}</div>
        </div>
    </div>

    <!-- Stat 4: Tayangan -->
    <div class="section-card" style="padding: 16px 20px; display: flex; align-items: center; gap: 16px; margin-bottom: 0;">
        <div style="width: 48px; height: 48px; border-radius: 12px; background: #ecfdf5; color: #059669; display: flex; align-items: center; justify-content: center; font-size: 20px; flex-shrink: 0;">
            <i class="fa-solid fa-eye"></i>
        </div>
        <div>
            <div style="font-size: 0.8rem; color: var(--muted); font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">Total Tayangan</div>
            <div style="font-size: 1.45rem; font-weight: 800; color: #059669;">{{ number_format($stats['views'] ?? 0, 0, ',', '.') }}x</div>
        </div>
    </div>
</div>

<!-- CONTROLS & FILTER BAR -->
<div class="section-card" style="margin-bottom: 25px; padding: 18px 20px;">
    <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 14px;">
        <!-- Filter Form -->
        <form method="GET" action="{{ route('guru.video') }}" style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap; flex: 1; max-width: 800px;">
            @if(request('play'))
                <input type="hidden" name="play" value="{{ request('play') }}">
            @endif

            <!-- Search input -->
            <div style="position: relative; flex: 1; min-width: 180px;">
                <i class="fa-solid fa-magnifying-glass" style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: #94a3b8; font-size: 13px;"></i>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari judul, mapel, deskripsi..." style="width: 100%; padding: 8px 12px 8px 34px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 13px; outline: none; box-sizing: border-box; background: #fff;">
            </div>

            <!-- Class filter -->
            <div style="min-width: 130px;">
                <select name="class_level" onchange="this.form.submit()" style="width: 100%; padding: 8px 12px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 13px; outline: none; background: #fff; cursor: pointer;">
                    <option value="">Semua Kelas</option>
                    @foreach($classOptions as $classOption)
                    <option value="{{ $classOption }}" {{ request('class_level') === $classOption ? 'selected' : '' }}>{{ $classOption }}</option>
                    @endforeach
                    <option value="Semua Kelas" {{ request('class_level') == 'Semua Kelas' ? 'selected' : '' }}>Umum (Semua Kelas)</option>
                </select>
            </div>

            <!-- Platform Source filter -->
            <div style="min-width: 140px;">
                <select name="source_type" onchange="this.form.submit()" style="width: 100%; padding: 8px 12px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 13px; outline: none; background: #fff; cursor: pointer;">
                    <option value="">Semua Sumber</option>
                    <option value="youtube" {{ request('source_type') == 'youtube' ? 'selected' : '' }}>YouTube</option>
                    <option value="google_drive" {{ request('source_type') == 'google_drive' ? 'selected' : '' }}>Google Drive</option>
                </select>
            </div>

            <button type="submit" style="background: #2563eb; color: #fff; border: none; padding: 8px 14px; border-radius: 8px; font-size: 13px; font-weight: 700; cursor: pointer; display: inline-flex; align-items: center; gap: 6px;">
                <i class="fa-solid fa-filter"></i> Filter
            </button>

            @if(request('search') || request('class_level') || request('source_type'))
            <a href="{{ route('guru.video') }}" style="background: #f1f5f9; color: #475569; border: 1px solid #cbd5e1; padding: 7px 12px; border-radius: 8px; font-size: 12px; font-weight: 600; text-decoration: none; display: inline-flex; align-items: center; gap: 4px;">
                <i class="fa-solid fa-xmark"></i> Reset
            </a>
            @endif
        </form>

        <!-- Add Button -->
        <button type="button" onclick="openModalVideo()" style="background: linear-gradient(135deg, #8b5cf6, #6366f1); color: white; border: none; padding: 10px 18px; border-radius: 10px; font-weight: 700; font-size: 13px; cursor: pointer; display: inline-flex; align-items: center; gap: 8px; box-shadow: 0 4px 14px rgba(99, 102, 241, 0.28); transition: transform 0.2s, box-shadow 0.2s;" onmouseover="this.style.transform='translateY(-1px)'" onmouseout="this.style.transform='translateY(0)'">
            <i class="fa-solid fa-video"></i> Tambah Video Baru
        </button>
    </div>
</div>

@if($activeVideo)
<!-- ACTIVE / FEATURED VIDEO PLAYER (COMPACT & BALANCED) -->
<style>
    .active-video-grid {
        display: grid;
        grid-template-columns: minmax(320px, 520px) minmax(0, 1fr);
        gap: 22px;
        align-items: start;
    }
    .active-video-grid.mode-wide {
        grid-template-columns: 1fr !important;
        max-width: 760px;
        margin: 0 auto;
    }
    .active-player-wrapper {
        width: 100%;
        aspect-ratio: 16/9;
        border-radius: 12px;
        overflow: hidden;
        background: #000;
        box-shadow: 0 4px 18px rgba(0, 0, 0, 0.16);
        position: relative;
    }
    @media (max-width: 900px) {
        .active-video-grid {
            grid-template-columns: 1fr !important;
            gap: 16px;
        }
    }
</style>

<div class="section-card" style="margin-bottom: 28px; padding: 20px; border: 1px solid #e2e8f0; box-shadow: 0 8px 24px rgba(0, 0, 0, 0.05); border-radius: 16px; background: #ffffff;">
    <!-- TOP BAR IN ACTIVE CARD -->
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px; padding-bottom: 14px; border-bottom: 1px solid var(--border); flex-wrap: wrap; gap: 10px;">
        <div style="display: flex; align-items: center; gap: 10px;">
            <div class="title-icon" style="background: {{ $activeVideo->is_drive ? '#e0f2fe' : '#fee2e2' }}; color: {{ $activeVideo->is_drive ? '#0284c7' : '#dc2626' }}; width: 38px; height: 38px; border-radius: 10px; display: inline-flex; align-items: center; justify-content: center; font-size: 1.1rem;">
                <i class="{{ $activeVideo->source_badge['icon'] }}"></i>
            </div>
            <div>
                <span style="font-size: 0.72rem; font-weight: 700; color: var(--muted); text-transform: uppercase; letter-spacing: 0.5px;">Pemutar Aktif</span>
                <h2 style="font-size: 1.05rem; margin: 0; font-weight: 800; color: var(--text); line-height: 1.3;">
                    {{ $activeVideo->title }}
                </h2>
            </div>
        </div>

        <div style="display: flex; align-items: center; gap: 8px;">
            <!-- Toggle Size Button -->
            <button type="button" id="btnToggleMode" onclick="togglePlayerMode()" style="background: #f1f5f9; color: #334155; border: 1px solid #cbd5e1; padding: 6px 12px; border-radius: 8px; font-size: 12px; font-weight: 700; cursor: pointer; display: inline-flex; align-items: center; gap: 6px;" title="Ubah ukuran tampilan pemutar">
                <i class="fa-solid fa-expand"></i> Mode Lebar
            </button>

            <!-- Close Active Player -->
            <a href="{{ route('guru.video') }}" style="background: #f8fafc; color: #64748b; border: 1px solid #cbd5e1; padding: 6px 10px; border-radius: 8px; font-size: 12px; font-weight: 700; text-decoration: none; display: inline-flex; align-items: center; gap: 4px;" title="Tutup pemutar aktif">
                <i class="fa-solid fa-xmark"></i> Tutup
            </a>
        </div>
    </div>

    <!-- 2-COLUMN COMPACT LAYOUT -->
    <div id="activePlayerGrid" class="active-video-grid">
        <!-- LEFT: VIDEO PLAYER (COMPACT 16:9) -->
        <div>
            <div class="active-player-wrapper">
                <iframe 
                    src="{{ $activeVideo->embed_url }}" 
                    title="{{ $activeVideo->title }}"
                    style="width: 100%; height: 100%; border: 0; display: block;" 
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" 
                    allowfullscreen>
                </iframe>
            </div>

            <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 10px; font-size: 0.78rem; flex-wrap: wrap; gap: 8px;">
                @if($activeVideo->effective_url)
                <a href="{{ $activeVideo->effective_url }}" target="_blank" rel="noopener noreferrer" style="color: #4f46e5; text-decoration: none; font-weight: 700; display: inline-flex; align-items: center; gap: 5px;">
                    <i class="fa-solid fa-arrow-up-right-from-square"></i> Buka di {{ $activeVideo->source_badge['label'] }}
                </a>
                @endif
                <span style="color: #94a3b8; display: inline-flex; align-items: center; gap: 4px;">
                    <i class="fa-solid fa-expand"></i> Fullscreen tersedia di pemutar
                </span>
            </div>
        </div>

        <!-- RIGHT: VIDEO DETAILS & ACTIONS -->
        <div style="display: flex; flex-direction: column; justify-content: space-between; height: 100%;">
            <div>
                <!-- Badges Row -->
                <div style="display: flex; align-items: center; gap: 8px; flex-wrap: wrap; margin-bottom: 8px;">
                    <span style="display: inline-flex; align-items: center; gap: 5px; background: {{ $activeVideo->source_badge['bg_color'] }}; color: {{ $activeVideo->source_badge['color'] }}; border: 1px solid {{ $activeVideo->source_badge['border'] }}; padding: 3px 10px; border-radius: 20px; font-size: 0.75rem; font-weight: 700;">
                        <i class="{{ $activeVideo->source_badge['icon'] }}"></i> {{ $activeVideo->source_badge['label'] }}
                    </span>
                    <span style="background: #f3e8ff; color: #7e22ce; padding: 3px 10px; border-radius: 20px; font-size: 0.75rem; font-weight: 700; display: inline-flex; align-items: center; gap: 4px;">
                        <i class="fa-solid fa-circle-play"></i> Sedang Diputar
                    </span>
                    <span style="background: #f1f5f9; color: #475569; padding: 3px 10px; border-radius: 20px; font-size: 0.75rem; font-weight: 700; display: inline-flex; align-items: center; gap: 4px;">
                        <i class="fa-regular fa-clock"></i> {{ $activeVideo->duration }}
                    </span>
                </div>

                <!-- Video Title -->
                <h3 style="font-size: 1.15rem; font-weight: 800; color: var(--text); margin: 0 0 10px 0; line-height: 1.4;">
                    {{ $activeVideo->title }}
                </h3>

                <!-- Meta Pills -->
                <div style="display: flex; align-items: center; gap: 8px; flex-wrap: wrap; margin-bottom: 12px;">
                    <span style="background: #e0f2fe; color: #0369a1; padding: 3px 10px; border-radius: 8px; font-size: 0.75rem; font-weight: 700;">
                        <i class="fa-solid fa-graduation-cap"></i> {{ $activeVideo->class_level }}
                    </span>
                    <span style="background: #f1f5f9; color: #475569; padding: 3px 10px; border-radius: 8px; font-size: 0.75rem; font-weight: 700;">
                        <i class="fa-solid fa-book-bookmark"></i> {{ $activeVideo->subject }}
                    </span>
                    <span style="font-size: 0.8rem; color: var(--muted); font-weight: 600;">
                        <i class="fa-regular fa-eye"></i> {{ number_format($activeVideo->views_count, 0, ',', '.') }}x ditonton
                    </span>
                    <span style="font-size: 0.8rem; color: #94a3b8;">
                        <i class="fa-regular fa-calendar"></i> {{ $activeVideo->created_at ? $activeVideo->created_at->format('d M Y') : 'Baru' }}
                    </span>
                </div>

                <!-- Description Box -->
                <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 10px; padding: 12px 14px; margin-bottom: 14px; max-height: 110px; overflow-y: auto; font-size: 0.86rem; color: #334155; line-height: 1.6; white-space: pre-line;">
                    {{ $activeVideo->description ?: 'Tidak ada ringkasan materi tambahan untuk video ini.' }}
                </div>

                <!-- Google Drive Tip Notice (if Drive) -->
                @if($activeVideo->is_drive)
                <div style="background: #f0f9ff; border: 1px solid #bae6fd; border-radius: 10px; padding: 10px 14px; margin-bottom: 14px; display: flex; align-items: center; gap: 10px; font-size: 0.82rem; color: #0369a1;">
                    <i class="fa-brands fa-google-drive" style="font-size: 1.15rem; color: #0284c7; flex-shrink: 0;"></i>
                    <div>
                        <strong>Info Google Drive:</strong> Pastikan berkas video ini memiliki setelan akses <em>"Siapa saja yang memiliki link"</em> sebagai <em>"Pelihat"</em> agar dapat diputar langsung oleh siswa.
                    </div>
                </div>
                @endif
            </div>

            <!-- Action Buttons Footer -->
            <div style="display: flex; align-items: center; justify-content: flex-end; gap: 8px; border-top: 1px solid #f1f5f9; padding-top: 12px; margin-top: 4px;">
                <!-- Edit Button -->
                <button type="button" onclick="openEditModal({{ json_encode($activeVideo) }})" style="background: #eef2ff; color: #4f46e5; border: 1px solid #c7d2fe; padding: 7px 14px; border-radius: 8px; font-size: 12px; font-weight: 700; cursor: pointer; display: inline-flex; align-items: center; gap: 6px;">
                    <i class="fa-solid fa-pen-to-square"></i> Edit Video
                </button>

                <!-- Delete Form -->
                <form action="{{ route('guru.video.destroy', $activeVideo->id) }}" method="POST" onsubmit="return confirm('Hapus video {{ addslashes($activeVideo->title) }} dari koleksi pembelajaran?')" style="margin: 0;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" style="background: #fee2e2; color: #dc2626; border: 1px solid #fecaca; padding: 7px 14px; border-radius: 8px; font-size: 12px; font-weight: 700; cursor: pointer; display: inline-flex; align-items: center; gap: 6px;">
                        <i class="fa-solid fa-trash-can"></i> Hapus Video
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endif

<!-- GALLERY TITLE & CONTROLS -->
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 18px; flex-wrap: wrap; gap: 10px;">
    <div style="display: flex; align-items: center; gap: 10px;">
        <h2 style="font-size: 1.25rem; font-weight: 800; color: var(--text); margin: 0; display: flex; align-items: center; gap: 8px;">
            <i class="fa-solid fa-film" style="color: #8b5cf6;"></i> Koleksi Video Edukasi Tersedia
        </h2>
        <span style="background: #f1f5f9; color: #475569; padding: 2px 10px; border-radius: 20px; font-size: 0.78rem; font-weight: 700;">
            {{ count($videos) }} Video Ditemukan
        </span>
    </div>
</div>

<!-- VIDEO CARDS GRID -->
<div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(290px, 1fr)); gap: 20px; margin-bottom: 30px;">
    @forelse($videos as $vid)
    @php
        $isPlaying = ($activeVideo && $activeVideo->id === $vid->id);
    @endphp
    <div class="section-card" style="display: flex; flex-direction: column; justify-content: space-between; margin-bottom: 0; padding: 14px; border-radius: 14px; position: relative; transition: transform 0.2s, box-shadow 0.2s; {{ $isPlaying ? 'border: 2px solid #8b5cf6; box-shadow: 0 8px 24px rgba(139, 92, 246, 0.18);' : 'border: 1px solid var(--border);' }}" onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='translateY(0)'">
        <div>
            <!-- THUMBNAIL / PREVIEW CONTAINER -->
            <div style="position: relative; border-radius: 10px; height: 165px; background: #0f172a; overflow: hidden; margin-bottom: 12px;">
                @if($vid->thumbnail_url)
                    <img src="{{ $vid->thumbnail_url }}" alt="{{ $vid->title }}" style="width: 100%; height: 100%; object-fit: cover;" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                    <div style="display: none; width: 100%; height: 100%; background: linear-gradient(135deg, {{ $vid->is_drive ? '#0369a1, #0284c7' : '#991b1b, #ef4444' }}); align-items: center; justify-content: center; flex-direction: column; color: white;">
                        <i class="{{ $vid->source_badge['icon'] }}" style="font-size: 2.8rem; margin-bottom: 6px;"></i>
                        <span style="font-size: 0.8rem; font-weight: 700;">{{ $vid->source_badge['label'] }} Video</span>
                    </div>
                @else
                    <div style="width: 100%; height: 100%; background: linear-gradient(135deg, {{ $vid->is_drive ? '#0284c7, #38bdf8' : '#dc2626, #f87171' }}); display: flex; align-items: center; justify-content: center; flex-direction: column; color: white;">
                        <i class="{{ $vid->source_badge['icon'] }}" style="font-size: 2.8rem; margin-bottom: 6px;"></i>
                        <span style="font-size: 0.8rem; font-weight: 700;">{{ $vid->source_badge['label'] }} Video</span>
                    </div>
                @endif

                <!-- Play Overlay Button -->
                <div style="position: absolute; inset: 0; background: rgba(0,0,0,0.32); display: flex; align-items: center; justify-content: center;">
                    <a href="{{ route('guru.video', array_merge(request()->query(), ['play' => $vid->id])) }}" style="width: 48px; height: 48px; border-radius: 50%; background: rgba(255,255,255,0.92); color: {{ $vid->is_drive ? '#0284c7' : '#dc2626' }}; display: flex; align-items: center; justify-content: center; font-size: 1.25rem; text-decoration: none; box-shadow: 0 4px 14px rgba(0,0,0,0.35); transition: transform 0.2s;" onmouseover="this.style.transform='scale(1.1)'" onmouseout="this.style.transform='scale(1)'" title="Putar Video Ini">
                        <i class="fa-solid fa-play" style="margin-left: 2px;"></i>
                    </a>
                </div>

                <!-- Platform Source Badge (Top-Right) -->
                <span style="position: absolute; top: 8px; right: 8px; background: {{ $vid->is_drive ? 'rgba(2, 132, 199, 0.92)' : 'rgba(220, 38, 38, 0.92)' }}; color: #ffffff; padding: 3px 8px; border-radius: 6px; font-size: 0.72rem; font-weight: 700; display: inline-flex; align-items: center; gap: 4px; box-shadow: 0 2px 6px rgba(0,0,0,0.25);">
                    <i class="{{ $vid->source_badge['icon'] }}"></i> {{ $vid->source_badge['label'] }}
                </span>

                <!-- Duration Badge (Bottom-Right) -->
                <span style="position: absolute; bottom: 8px; right: 8px; background: rgba(15, 23, 42, 0.85); color: #ffffff; padding: 2px 7px; border-radius: 5px; font-size: 0.72rem; font-weight: 700;">
                    <i class="fa-regular fa-clock" style="font-size: 0.68rem;"></i> {{ $vid->duration }}
                </span>

                <!-- Active Status Badge (Top-Left) -->
                @if($isPlaying)
                <span style="position: absolute; top: 8px; left: 8px; background: #8b5cf6; color: #fff; padding: 3px 9px; border-radius: 6px; font-size: 0.72rem; font-weight: 700; display: inline-flex; align-items: center; gap: 4px; box-shadow: 0 2px 6px rgba(139, 92, 246, 0.4);">
                    <i class="fa-solid fa-circle-play"></i> Sedang Diputar
                </span>
                @endif
            </div>

            <!-- Tags -->
            <div style="display: flex; gap: 6px; flex-wrap: wrap; margin-bottom: 8px;">
                <span style="background: #e0f2fe; color: #0369a1; padding: 2px 9px; border-radius: 12px; font-size: 0.73rem; font-weight: 700;">
                    {{ $vid->class_level }}
                </span>
                <span style="background: #f1f5f9; color: #475569; padding: 2px 9px; border-radius: 12px; font-size: 0.73rem; font-weight: 700;">
                    {{ $vid->subject }}
                </span>
            </div>

            <!-- Title & Description -->
            <h3 style="font-size: 1.02rem; font-weight: 800; color: var(--text); margin: 0 0 6px 0; line-height: 1.45; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; min-height: 2.9em;">
                {{ $vid->title }}
            </h3>
            <p style="font-size: 0.84rem; color: var(--muted); line-height: 1.5; margin: 0 0 12px 0; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                {{ $vid->description ?: 'Tidak ada deskripsi materi video.' }}
            </p>
        </div>

        <!-- Card Footer Actions -->
        <div style="border-top: 1px solid var(--border); padding-top: 10px; margin-top: 6px; display: flex; align-items: center; justify-content: space-between; gap: 8px;">
            <span style="font-size: 0.78rem; color: var(--muted); font-weight: 600;">
                <i class="fa-regular fa-eye"></i> {{ number_format($vid->views_count, 0, ',', '.') }} tayangan
            </span>

            <div style="display: flex; align-items: center; gap: 6px;">
                <!-- Play button -->
                <a href="{{ route('guru.video', array_merge(request()->query(), ['play' => $vid->id])) }}" class="watch-button" style="padding: 6px 12px; font-size: 11px; text-decoration: none; background: #8b5cf6; color: #fff; border-radius: 7px; font-weight: 700; display: inline-flex; align-items: center; gap: 5px;">
                    <i class="fa-solid fa-play"></i> Tonton
                </a>

                <!-- Edit Button -->
                <button type="button" onclick="openEditModal({{ json_encode($vid) }})" style="background: #eef2ff; color: #4f46e5; border: 1px solid #c7d2fe; padding: 6px 9px; border-radius: 7px; font-size: 12px; font-weight: 700; cursor: pointer;" title="Edit Data Video">
                    <i class="fa-solid fa-pen-to-square"></i>
                </button>

                <!-- Delete Button -->
                <form action="{{ route('guru.video.destroy', $vid->id) }}" method="POST" onsubmit="return confirm('Hapus video {{ addslashes($vid->title) }}?')" style="margin: 0;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" style="background: #fee2e2; color: #dc2626; border: 1px solid #fecaca; padding: 6px 9px; border-radius: 7px; font-size: 12px; font-weight: 700; cursor: pointer;" title="Hapus Video">
                        <i class="fa-solid fa-trash-can"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>
    @empty
    <div class="section-card" style="grid-column: 1 / -1; padding: 48px 24px; text-align: center; color: var(--muted); border-radius: 16px;">
        <div style="width: 72px; height: 72px; border-radius: 50%; background: #f1f5f9; display: inline-flex; align-items: center; justify-content: center; margin-bottom: 16px;">
            <i class="fa-solid fa-video-slash" style="font-size: 2rem; color: #94a3b8;"></i>
        </div>
        <h3 style="font-size: 1.15rem; color: var(--text); margin-bottom: 6px; font-weight: 800;">Tidak Ada Video Edukasi Ditemukan</h3>
        <p style="font-size: 0.9rem; margin-bottom: 20px; max-width: 480px; margin-left: auto; margin-right: auto;">
            @if(request('search') || request('class_level') || request('source_type'))
                Tidak ada video yang cocok dengan kriteria pencarian Anda. Silakan reset filter atau gunakan kata kunci lain.
            @else
                Belum ada video edukasi yang ditambahkan. Bagikan materi video melalui tautan YouTube atau Google Drive untuk peserta didik Anda.
            @endif
        </p>
        <div style="display: flex; justify-content: center; gap: 10px; flex-wrap: wrap;">
            @if(request('search') || request('class_level') || request('source_type'))
                <a href="{{ route('guru.video') }}" style="background: #f1f5f9; color: #475569; border: 1px solid #cbd5e1; padding: 10px 20px; border-radius: 8px; font-weight: 700; font-size: 13px; text-decoration: none;">
                    <i class="fa-solid fa-rotate-left"></i> Reset Filter
                </a>
            @endif
            <button type="button" onclick="openModalVideo()" style="background: #8b5cf6; color: white; border: none; padding: 10px 22px; border-radius: 8px; font-weight: 700; font-size: 13px; cursor: pointer; display: inline-flex; align-items: center; gap: 8px;">
                <i class="fa-solid fa-plus"></i> Tambah Video Baru
            </button>
        </div>
    </div>
    @endforelse
</div>

<!-- ============================================================== -->
<!-- MODAL 1: TAMBAH VIDEO BARU                                     -->
<!-- ============================================================== -->
<div id="modalVideo" class="modal-overlay" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-header" style="background: linear-gradient(135deg, #7c3aed, #4f46e5);">
            <div style="display: flex; align-items: center; gap: 10px; font-weight: 700; font-size: 1.1rem;">
                <i class="fa-solid fa-cloud-arrow-up"></i> Tambah Video Edukasi Baru
            </div>
            <button type="button" onclick="closeModalVideo()" style="background: transparent; border: none; color: #ffffff; font-size: 1.4rem; cursor: pointer; line-height: 1;">&times;</button>
        </div>

        <form action="{{ route('guru.video.store') }}" method="POST" class="modal-body-scroll">
            @csrf

            <!-- PLATFORM SELECTOR TABS -->
            <div style="margin-bottom: 18px;">
                <label style="display: block; font-size: 0.88rem; font-weight: 700; color: #334155; margin-bottom: 8px;">
                    Pilih Platform Sumber Video *
                </label>
                <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 10px;">
                    <label style="cursor: pointer; position: relative;">
                        <input type="radio" name="source_type" value="auto" checked onchange="toggleSourceTypeHelp('create', this.value)" style="position: absolute; opacity: 0;">
                        <div class="source-pill" data-for="auto" style="border: 2px solid #8b5cf6; background: #f5f3ff; color: #6d28d9; padding: 10px 8px; border-radius: 10px; text-align: center; font-weight: 700; font-size: 0.82rem; transition: all 0.2s;">
                            <i class="fa-solid fa-wand-magic-sparkles" style="display: block; font-size: 1.25rem; margin-bottom: 4px;"></i>
                            Otomatis
                        </div>
                    </label>

                    <label style="cursor: pointer; position: relative;">
                        <input type="radio" name="source_type" value="youtube" onchange="toggleSourceTypeHelp('create', this.value)" style="position: absolute; opacity: 0;">
                        <div class="source-pill" data-for="youtube" style="border: 2px solid #e2e8f0; background: #ffffff; color: #64748b; padding: 10px 8px; border-radius: 10px; text-align: center; font-weight: 700; font-size: 0.82rem; transition: all 0.2s;">
                            <i class="fa-brands fa-youtube" style="display: block; font-size: 1.25rem; margin-bottom: 4px; color: #dc2626;"></i>
                            YouTube
                        </div>
                    </label>

                    <label style="cursor: pointer; position: relative;">
                        <input type="radio" name="source_type" value="google_drive" onchange="toggleSourceTypeHelp('create', this.value)" style="position: absolute; opacity: 0;">
                        <div class="source-pill" data-for="google_drive" style="border: 2px solid #e2e8f0; background: #ffffff; color: #64748b; padding: 10px 8px; border-radius: 10px; text-align: center; font-weight: 700; font-size: 0.82rem; transition: all 0.2s;">
                            <i class="fa-brands fa-google-drive" style="display: block; font-size: 1.25rem; margin-bottom: 4px; color: #0284c7;"></i>
                            Google Drive
                        </div>
                    </label>
                </div>
            </div>

            <!-- GOOGLE DRIVE STEP-BY-STEP GUIDANCE BOX -->
            <div id="driveHelpBox-create" style="display: none; background: #f0f9ff; border: 1px solid #bae6fd; border-radius: 10px; padding: 14px 16px; margin-bottom: 18px; font-size: 0.85rem; color: #0369a1;">
                <div style="font-weight: 800; margin-bottom: 8px; display: flex; align-items: center; gap: 8px;">
                    <i class="fa-brands fa-google-drive" style="color: #0284c7; font-size: 1.1rem;"></i>
                    Cara Mendapatkan Link Video dari Google Drive:
                </div>
                <ol style="margin: 0; padding-left: 20px; line-height: 1.6;">
                    <li>Unggah file video ke akun <strong>Google Drive</strong> Anda.</li>
                    <li>Klik kanan berkas video &gt; pilih menu <strong>Bagikan (Share)</strong>.</li>
                    <li>Pada opsi <em>Akses umum</em>, ubah dari "Dibatasi" menjadi <strong>"Siapa saja yang memiliki link"</strong> (<em>Anyone with the link</em>).</li>
                    <li>Pastikan peran akses adalah <strong>"Pelihat"</strong> (<em>Viewer</em>).</li>
                    <li>Klik <strong>Salin Tautan (Copy Link)</strong> lalu tempelkan pada kolom URL di bawah.</li>
                </ol>
            </div>

            <!-- JUDUL VIDEO -->
            <div style="margin-bottom: 16px;">
                <label style="display: block; font-size: 0.88rem; font-weight: 700; color: #334155; margin-bottom: 6px;">Judul Video Pembelajaran *</label>
                <input type="text" name="title" required placeholder="Contoh: Pembelajaran Interaktif Siklus Air & Hujan" style="width: 100%; padding: 10px 14px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 0.9rem; outline: none; box-sizing: border-box;">
            </div>

            <!-- MAPEL & KELAS -->
            <div class="modal-form-row">
                <div>
                    <label style="display: block; font-size: 0.88rem; font-weight: 700; color: #334155; margin-bottom: 6px;">Mata Pelajaran *</label>
                    <input type="text" name="subject" required placeholder="Contoh: IPA / Sains" value="{{ Auth::user()->subject ?: 'Sains' }}" style="width: 100%; padding: 10px 14px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 0.9rem; outline: none; box-sizing: border-box;">
                </div>
                <div>
                    <label style="display: block; font-size: 0.88rem; font-weight: 700; color: #334155; margin-bottom: 6px;">Tingkat Kelas *</label>
                    <select name="class_level" required style="width: 100%; padding: 10px 14px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 0.9rem; outline: none; background: #fff; box-sizing: border-box; cursor: pointer;">
                        @foreach($classOptions as $classOption)
                        <option value="{{ $classOption }}" {{ old('class_level', 'Kelas 5A') === $classOption ? 'selected' : '' }}>{{ $classOption }}</option>
                        @endforeach
                        <option value="Semua Kelas" {{ old('class_level') === 'Semua Kelas' ? 'selected' : '' }}>Semua Kelas</option>
                    </select>
                </div>
            </div>

            <!-- URL VIDEO / GOOGLE DRIVE LINK -->
            <div style="margin-bottom: 16px;">
                <label id="urlLabel-create" style="display: block; font-size: 0.88rem; font-weight: 700; color: #334155; margin-bottom: 6px;">
                    Tautan Video / Tautan Berkas (YouTube atau Google Drive) *
                </label>
                <input type="text" name="video_url" id="videoUrlInput-create" required placeholder="https://www.youtube.com/watch?v=... atau https://drive.google.com/file/d/.../view" style="width: 100%; padding: 10px 14px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 0.9rem; outline: none; box-sizing: border-box;">
                <small id="urlHelp-create" style="color: var(--muted); font-size: 0.78rem; display: block; margin-top: 5px;">
                    Mendukung tautan YouTube (Watch, Shorts, youtu.be) maupun tautan Google Drive (/file/d/.../view atau kode semat).
                </small>
            </div>

            <!-- DURASI -->
            <div style="margin-bottom: 16px;">
                <label style="display: block; font-size: 0.88rem; font-weight: 700; color: #334155; margin-bottom: 6px;">Estimasi Durasi Video *</label>
                <input type="text" name="duration" required placeholder="Contoh: 12:45 atau 15 Menit" style="width: 100%; padding: 10px 14px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 0.9rem; outline: none; box-sizing: border-box;">
            </div>

            <!-- DESKRIPSI -->
            <div style="margin-bottom: 22px;">
                <label style="display: block; font-size: 0.88rem; font-weight: 700; color: #334155; margin-bottom: 6px;">Deskripsi / Ringkasan Materi</label>
                <textarea name="description" rows="3" placeholder="Tuliskan petunjuk pembelajaran atau ringkasan topik video..." style="width: 100%; padding: 10px 14px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 0.9rem; outline: none; box-sizing: border-box; resize: vertical;"></textarea>
            </div>

            <!-- ACTION BUTTONS -->
            <div style="display: flex; justify-content: flex-end; gap: 10px; border-top: 1px solid #f1f5f9; padding-top: 16px;">
                <button type="button" onclick="closeModalVideo()" style="padding: 10px 18px; border: 1px solid #cbd5e1; background: #f1f5fa; color: #475569; border-radius: 8px; font-weight: 700; font-size: 13px; cursor: pointer;">
                    Batal
                </button>
                <button type="submit" style="padding: 10px 22px; background: linear-gradient(135deg, #7c3aed, #4f46e5); border: none; color: #ffffff; border-radius: 8px; font-weight: 700; font-size: 13px; cursor: pointer; display: inline-flex; align-items: center; gap: 8px; box-shadow: 0 4px 12px rgba(99, 102, 241, 0.25);">
                    <i class="fa-solid fa-save"></i> Simpan Video
                </button>
            </div>
        </form>
    </div>
</div>

<!-- ============================================================== -->
<!-- MODAL 2: EDIT DATA VIDEO                                       -->
<!-- ============================================================== -->
<div id="modalEditVideo" class="modal-overlay" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-header" style="background: linear-gradient(135deg, #4f46e5, #2563eb);">
            <div style="display: flex; align-items: center; gap: 10px; font-weight: 700; font-size: 1.1rem;">
                <i class="fa-solid fa-pen-to-square"></i> Edit Data Video Edukasi
            </div>
            <button type="button" onclick="closeEditModal()" style="background: transparent; border: none; color: #ffffff; font-size: 1.4rem; cursor: pointer; line-height: 1;">&times;</button>
        </div>

        <form id="formEditVideo" action="" method="POST" class="modal-body-scroll">
            @csrf
            @method('PUT')

            <!-- PLATFORM SELECTOR TABS -->
            <div style="margin-bottom: 18px;">
                <label style="display: block; font-size: 0.88rem; font-weight: 700; color: #334155; margin-bottom: 8px;">
                    Platform Sumber Video *
                </label>
                <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 10px;">
                    <label style="cursor: pointer; position: relative;">
                        <input type="radio" name="source_type" id="edit_source_auto" value="auto" onchange="toggleSourceTypeHelp('edit', this.value)" style="position: absolute; opacity: 0;">
                        <div class="source-pill-edit" data-for="auto" style="border: 2px solid #e2e8f0; background: #ffffff; color: #64748b; padding: 10px 8px; border-radius: 10px; text-align: center; font-weight: 700; font-size: 0.82rem; transition: all 0.2s;">
                            <i class="fa-solid fa-wand-magic-sparkles" style="display: block; font-size: 1.25rem; margin-bottom: 4px;"></i>
                            Otomatis
                        </div>
                    </label>

                    <label style="cursor: pointer; position: relative;">
                        <input type="radio" name="source_type" id="edit_source_youtube" value="youtube" onchange="toggleSourceTypeHelp('edit', this.value)" style="position: absolute; opacity: 0;">
                        <div class="source-pill-edit" data-for="youtube" style="border: 2px solid #e2e8f0; background: #ffffff; color: #64748b; padding: 10px 8px; border-radius: 10px; text-align: center; font-weight: 700; font-size: 0.82rem; transition: all 0.2s;">
                            <i class="fa-brands fa-youtube" style="display: block; font-size: 1.25rem; margin-bottom: 4px; color: #dc2626;"></i>
                            YouTube
                        </div>
                    </label>

                    <label style="cursor: pointer; position: relative;">
                        <input type="radio" name="source_type" id="edit_source_google_drive" value="google_drive" onchange="toggleSourceTypeHelp('edit', this.value)" style="position: absolute; opacity: 0;">
                        <div class="source-pill-edit" data-for="google_drive" style="border: 2px solid #e2e8f0; background: #ffffff; color: #64748b; padding: 10px 8px; border-radius: 10px; text-align: center; font-weight: 700; font-size: 0.82rem; transition: all 0.2s;">
                            <i class="fa-brands fa-google-drive" style="display: block; font-size: 1.25rem; margin-bottom: 4px; color: #0284c7;"></i>
                            Google Drive
                        </div>
                    </label>
                </div>
            </div>

            <!-- GOOGLE DRIVE STEP-BY-STEP GUIDANCE BOX (EDIT) -->
            <div id="driveHelpBox-edit" style="display: none; background: #f0f9ff; border: 1px solid #bae6fd; border-radius: 10px; padding: 14px 16px; margin-bottom: 18px; font-size: 0.85rem; color: #0369a1;">
                <div style="font-weight: 800; margin-bottom: 8px; display: flex; align-items: center; gap: 8px;">
                    <i class="fa-brands fa-google-drive" style="color: #0284c7; font-size: 1.1rem;"></i>
                    Pengaturan Google Drive:
                </div>
                <div style="font-size: 0.82rem; line-height: 1.5;">
                    Pastikan tautan berkas berasal dari opsi <strong>"Siapa saja yang memiliki link"</strong> dengan peran <strong>"Pelihat"</strong> di menu Berbagi Google Drive Anda.
                </div>
            </div>

            <!-- JUDUL VIDEO -->
            <div style="margin-bottom: 16px;">
                <label style="display: block; font-size: 0.88rem; font-weight: 700; color: #334155; margin-bottom: 6px;">Judul Video Pembelajaran *</label>
                <input type="text" name="title" id="edit_title" required placeholder="Judul video" style="width: 100%; padding: 10px 14px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 0.9rem; outline: none; box-sizing: border-box;">
            </div>

            <!-- MAPEL & KELAS -->
            <div class="modal-form-row">
                <div>
                    <label style="display: block; font-size: 0.88rem; font-weight: 700; color: #334155; margin-bottom: 6px;">Mata Pelajaran *</label>
                    <input type="text" name="subject" id="edit_subject" required placeholder="Mata pelajaran" style="width: 100%; padding: 10px 14px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 0.9rem; outline: none; box-sizing: border-box;">
                </div>
                <div>
                    <label style="display: block; font-size: 0.88rem; font-weight: 700; color: #334155; margin-bottom: 6px;">Tingkat Kelas *</label>
                    <select name="class_level" id="edit_class_level" required style="width: 100%; padding: 10px 14px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 0.9rem; outline: none; background: #fff; box-sizing: border-box; cursor: pointer;">
                        @foreach($classOptions as $classOption)
                        <option value="{{ $classOption }}">{{ $classOption }}</option>
                        @endforeach
                        <option value="Semua Kelas">Semua Kelas</option>
                    </select>
                </div>
            </div>

            <!-- URL VIDEO / GOOGLE DRIVE LINK -->
            <div style="margin-bottom: 16px;">
                <label id="urlLabel-edit" style="display: block; font-size: 0.88rem; font-weight: 700; color: #334155; margin-bottom: 6px;">
                    Tautan Video / Tautan Berkas *
                </label>
                <input type="text" name="video_url" id="edit_video_url" required placeholder="URL YouTube atau Google Drive" style="width: 100%; padding: 10px 14px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 0.9rem; outline: none; box-sizing: border-box;">
                <small id="urlHelp-edit" style="color: var(--muted); font-size: 0.78rem; display: block; margin-top: 5px;">
                    Mendukung URL YouTube (Watch, Shorts, youtu.be) maupun tautan Google Drive (/file/d/.../view).
                </small>
            </div>

            <!-- DURASI -->
            <div style="margin-bottom: 16px;">
                <label style="display: block; font-size: 0.88rem; font-weight: 700; color: #334155; margin-bottom: 6px;">Estimasi Durasi Video *</label>
                <input type="text" name="duration" id="edit_duration" required placeholder="Contoh: 12:45" style="width: 100%; padding: 10px 14px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 0.9rem; outline: none; box-sizing: border-box;">
            </div>

            <!-- DESKRIPSI -->
            <div style="margin-bottom: 22px;">
                <label style="display: block; font-size: 0.88rem; font-weight: 700; color: #334155; margin-bottom: 6px;">Deskripsi / Ringkasan Materi</label>
                <textarea name="description" id="edit_description" rows="3" placeholder="Ringkasan materi..." style="width: 100%; padding: 10px 14px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 0.9rem; outline: none; box-sizing: border-box; resize: vertical;"></textarea>
            </div>

            <!-- ACTION BUTTONS -->
            <div style="display: flex; justify-content: flex-end; gap: 10px; border-top: 1px solid #f1f5f9; padding-top: 16px;">
                <button type="button" onclick="closeEditModal()" style="padding: 10px 18px; border: 1px solid #cbd5e1; background: #f1f5fa; color: #475569; border-radius: 8px; font-weight: 700; font-size: 13px; cursor: pointer;">
                    Batal
                </button>
                <button type="submit" style="padding: 10px 22px; background: linear-gradient(135deg, #4f46e5, #2563eb); border: none; color: #ffffff; border-radius: 8px; font-weight: 700; font-size: 13px; cursor: pointer; display: inline-flex; align-items: center; gap: 8px; box-shadow: 0 4px 12px rgba(37, 99, 235, 0.25);">
                    <i class="fa-solid fa-check"></i> Perbarui Video
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // --- Active Video Player Size Mode Toggle ---
    function togglePlayerMode() {
        const grid = document.getElementById('activePlayerGrid');
        const btn = document.getElementById('btnToggleMode');
        if (!grid || !btn) return;

        const isWide = grid.classList.toggle('mode-wide');
        localStorage.setItem('guru_video_player_mode', isWide ? 'wide' : 'compact');
        btn.innerHTML = isWide 
            ? '<i class="fa-solid fa-compress"></i> Mode Ringkas' 
            : '<i class="fa-solid fa-expand"></i> Mode Lebar';
    }

    document.addEventListener('DOMContentLoaded', function() {
        const savedMode = localStorage.getItem('guru_video_player_mode');
        if (savedMode === 'wide') {
            const grid = document.getElementById('activePlayerGrid');
            const btn = document.getElementById('btnToggleMode');
            if (grid && btn) {
                grid.classList.add('mode-wide');
                btn.innerHTML = '<i class="fa-solid fa-compress"></i> Mode Ringkas';
            }
        }
    });

    // --- Modal Tambah Video Functions ---
    function openModalVideo() {
        const modal = document.getElementById('modalVideo');
        if (modal) {
            modal.style.display = 'flex';
        }
    }

    function closeModalVideo() {
        const modal = document.getElementById('modalVideo');
        if (modal) {
            modal.style.display = 'none';
        }
    }

    // --- Modal Edit Video Functions ---
    function openEditModal(video) {
        const modal = document.getElementById('modalEditVideo');
        const form = document.getElementById('formEditVideo');
        if (!modal || !form || !video) return;

        // Set action route dynamically
        form.action = "{{ url('/guru/video') }}/" + video.id;

        // Populate fields
        document.getElementById('edit_title').value = video.title || '';
        document.getElementById('edit_subject').value = video.subject || '';
        document.getElementById('edit_class_level').value = video.class_level || 'Kelas 5A';
        document.getElementById('edit_duration').value = video.duration || '';
        document.getElementById('edit_description').value = video.description || '';

        const effectiveUrl = video.video_url || video.youtube_url || '';
        document.getElementById('edit_video_url').value = effectiveUrl;

        // Set platform source radio
        const sourceType = video.source_type || 'youtube';
        if (sourceType === 'google_drive') {
            document.getElementById('edit_source_google_drive').checked = true;
            toggleSourceTypeHelp('edit', 'google_drive');
        } else if (sourceType === 'youtube') {
            document.getElementById('edit_source_youtube').checked = true;
            toggleSourceTypeHelp('edit', 'youtube');
        } else {
            document.getElementById('edit_source_auto').checked = true;
            toggleSourceTypeHelp('edit', 'auto');
        }

        modal.style.display = 'flex';
    }

    function closeEditModal() {
        const modal = document.getElementById('modalEditVideo');
        if (modal) {
            modal.style.display = 'none';
        }
    }

    // --- Toggle Platform Source Tabs & Guidance Box ---
    function toggleSourceTypeHelp(context, type) {
        const isCreate = (context === 'create');
        const pills = document.querySelectorAll(isCreate ? '.source-pill' : '.source-pill-edit');
        const helpBox = document.getElementById(isCreate ? 'driveHelpBox-create' : 'driveHelpBox-edit');
        const urlLabel = document.getElementById(isCreate ? 'urlLabel-create' : 'urlLabel-edit');
        const urlInput = document.getElementById(isCreate ? 'videoUrlInput-create' : 'edit_video_url');
        const urlHelp = document.getElementById(isCreate ? 'urlHelp-create' : 'urlHelp-edit');

        // Update pills active styling
        pills.forEach(pill => {
            const pillFor = pill.getAttribute('data-for');
            if (pillFor === type) {
                if (type === 'youtube') {
                    pill.style.border = '2px solid #ef4444';
                    pill.style.background = '#fef2f2';
                    pill.style.color = '#b91c1c';
                } else if (type === 'google_drive') {
                    pill.style.border = '2px solid #0284c7';
                    pill.style.background = '#f0f9ff';
                    pill.style.color = '#0369a1';
                } else {
                    pill.style.border = '2px solid #8b5cf6';
                    pill.style.background = '#f5f3ff';
                    pill.style.color = '#6d28d9';
                }
            } else {
                pill.style.border = '2px solid #e2e8f0';
                pill.style.background = '#ffffff';
                pill.style.color = '#64748b';
            }
        });

        // Toggle Google Drive Guidance Box & Input Placeholders
        if (type === 'google_drive') {
            if (helpBox) helpBox.style.display = 'block';
            if (urlLabel) urlLabel.textContent = 'Tautan Berkas Google Drive *';
            if (urlInput) urlInput.placeholder = 'https://drive.google.com/file/d/1A2b3C.../view?usp=sharing';
            if (urlHelp) urlHelp.textContent = 'Tempel tautan berkas video Google Drive dengan setelan akses "Siapa saja yang memiliki link".';
        } else if (type === 'youtube') {
            if (helpBox) helpBox.style.display = 'none';
            if (urlLabel) urlLabel.textContent = 'Tautan Video YouTube *';
            if (urlInput) urlInput.placeholder = 'https://www.youtube.com/watch?v=... atau https://youtu.be/...';
            if (urlHelp) urlHelp.textContent = 'Mendukung URL video YouTube standar, video Shorts, maupun link share youtu.be.';
        } else {
            if (helpBox) helpBox.style.display = 'none';
            if (urlLabel) urlLabel.textContent = 'Tautan Video (YouTube atau Google Drive) *';
            if (urlInput) urlInput.placeholder = 'https://www.youtube.com/watch?v=... atau https://drive.google.com/file/d/.../view';
            if (urlHelp) urlHelp.textContent = 'Sistem akan mendeteksi platform (YouTube / Google Drive) secara otomatis dari URL yang Anda masukkan.';
        }
    }

    // Close modals on clicking outside overlay
    window.addEventListener('click', function(e) {
        const modalCreate = document.getElementById('modalVideo');
        if (e.target === modalCreate) {
            closeModalVideo();
        }

        const modalEdit = document.getElementById('modalEditVideo');
        if (e.target === modalEdit) {
            closeEditModal();
        }
    });
</script>
@endsection
