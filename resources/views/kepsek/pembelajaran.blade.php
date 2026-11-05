@extends('layouts.kepsek')

@section('title', 'Monitoring Media Pembelajaran - Kepala Sekolah')
@section('page-title', 'Monitoring Media Pembelajaran')

@section('styles')
<link rel="stylesheet" href="{{ asset('mentahan2/css/dashboard.css') }}?v={{ filemtime(public_path('mentahan2/css/dashboard.css')) ?: time() }}">
<link rel="stylesheet" href="{{ asset('mentahan2/css/kepsek-pages.css') }}?v={{ filemtime(public_path('mentahan2/css/kepsek-pages.css')) ?: time() }}">
@endsection

@section('content')
<!-- Hero -->
<section class="exec-hero">
  <div class="exec-hero-glow exec-hero-glow--gold" aria-hidden="true"></div>
  <div class="exec-hero-glow exec-hero-glow--blue" aria-hidden="true"></div>

  <div class="exec-hero-main">
    <span class="exec-hero-chip">
      <i class="fa-solid fa-graduation-cap"></i> Supervisi Konten Digital
    </span>
    <h1>Media <span>Pembelajaran</span></h1>
    <p>
      Supervisi seluruh modul materi dan video edukasi yang dipublikasikan dewan guru
      untuk mendukung kegiatan belajar peserta didik.
    </p>
    <div class="exec-hero-meta">
      <span><i class="fa-regular fa-calendar-days"></i> {{ now()->locale('id')->translatedFormat('l, d F Y') }}</span>
      <span><i class="fa-solid fa-layer-group"></i> {{ $totalCombined }} media terbit</span>
      <span class="exec-hero-status"><span class="pulse-dot"></span> Data realtime</span>
    </div>
  </div>

  <div class="exec-hero-actions">
    <a href="{{ route('kepsek.monitoring.guru') }}" class="hero-btn hero-btn--gold">
      <i class="fa-solid fa-chalkboard-user"></i> Monitoring Guru
    </a>
    <a href="{{ route('kepsek.dashboard') }}" class="hero-btn hero-btn--ghost">
      <i class="fa-solid fa-gauge-high"></i> Dashboard
    </a>
  </div>
</section>

<!-- Metric Cards -->
<div class="metric-grid">
  <div class="metric-card metric-card--blue">
    <span class="metric-accent" aria-hidden="true"></span>
    <div class="metric-icon"><i class="fa-solid fa-layer-group"></i></div>
    <div class="metric-info">
      <span class="metric-label">Total Media</span>
      <h3>{{ $totalCombined }}</h3>
      <span class="metric-note"><i class="fa-solid fa-folder-tree"></i> Video &amp; modul ajar</span>
    </div>
    <i class="fa-solid fa-layer-group metric-ghost" aria-hidden="true"></i>
  </div>

  <div class="metric-card metric-card--rose">
    <span class="metric-accent" aria-hidden="true"></span>
    <div class="metric-icon"><i class="fa-solid fa-circle-play"></i></div>
    <div class="metric-info">
      <span class="metric-label">Video Edukasi</span>
      <h3>{{ $totalVideoCount }}</h3>
      <span class="metric-note"><i class="fa-solid fa-film"></i> Media video guru</span>
    </div>
    <i class="fa-solid fa-circle-play metric-ghost" aria-hidden="true"></i>
  </div>

  <div class="metric-card metric-card--amber">
    <span class="metric-accent" aria-hidden="true"></span>
    <div class="metric-icon"><i class="fa-solid fa-book-open"></i></div>
    <div class="metric-info">
      <span class="metric-label">Modul &amp; File</span>
      <h3>{{ $totalMaterialCount }}</h3>
      <span class="metric-note"><i class="fa-solid fa-file-lines"></i> Bahan ajar digital</span>
    </div>
    <i class="fa-solid fa-book-open metric-ghost" aria-hidden="true"></i>
  </div>

  <div class="metric-card metric-card--emerald">
    <span class="metric-accent" aria-hidden="true"></span>
    <div class="metric-icon"><i class="fa-solid fa-download"></i></div>
    <div class="metric-info">
      <span class="metric-label">Total Unduhan</span>
      <h3>{{ $totalDownloads }}</h3>
      <span class="metric-note"><i class="fa-solid fa-arrow-trend-up"></i> Akses materi siswa</span>
    </div>
    <i class="fa-solid fa-download metric-ghost" aria-hidden="true"></i>
  </div>
</div>

<!-- Filter -->
<div class="box-card kp-toolbar">
  <form action="{{ route('kepsek.monitoring.pembelajaran') }}" method="GET" class="kp-filter-form">
    <div class="kp-tabs">
      <a href="{{ route('kepsek.monitoring.pembelajaran', ['tab' => 'all', 'class_level' => $classLevel, 'search' => $search]) }}"
         class="kp-tab {{ $tab === 'all' ? 'active' : '' }}">
        Semua <span class="kp-tab-count">{{ $totalCombined }}</span>
      </a>
      <a href="{{ route('kepsek.monitoring.pembelajaran', ['tab' => 'video', 'class_level' => $classLevel, 'search' => $search]) }}"
         class="kp-tab {{ $tab === 'video' ? 'active' : '' }}">
        <i class="fa-solid fa-video"></i> Video <span class="kp-tab-count">{{ $totalVideoCount }}</span>
      </a>
      <a href="{{ route('kepsek.monitoring.pembelajaran', ['tab' => 'materi', 'class_level' => $classLevel, 'search' => $search]) }}"
         class="kp-tab {{ $tab === 'materi' ? 'active' : '' }}">
        <i class="fa-solid fa-file-lines"></i> Modul <span class="kp-tab-count">{{ $totalMaterialCount }}</span>
      </a>
    </div>

    <input type="hidden" name="tab" value="{{ $tab }}">
    <div class="kp-filter-group">
      <select name="class_level" class="kp-select" onchange="this.form.submit()">
        @foreach($availableClasses as $cls)
          <option value="{{ $cls }}" {{ ($classLevel == $cls) ? 'selected' : '' }}>{{ $cls }}</option>
        @endforeach
      </select>

      <div class="kp-search">
        <i class="fa-solid fa-magnifying-glass"></i>
        <input type="text" name="search" value="{{ $search }}" placeholder="Cari judul atau mata pelajaran...">
      </div>

      <button type="submit" class="kp-btn kp-btn--primary">
        <i class="fa-solid fa-filter"></i> Terapkan
      </button>

      @if($search || ($classLevel && $classLevel !== 'Semua Kelas') || $tab !== 'all')
        <a href="{{ route('kepsek.monitoring.pembelajaran') }}" class="kp-btn kp-btn--soft" title="Reset filter">
          <i class="fa-solid fa-rotate-left"></i>
        </a>
      @endif
    </div>
  </form>
</div>

<div class="kp-section-stack">
  <!-- Video Section -->
  @if($tab === 'all' || $tab === 'video')
    <section>
      <div class="kp-section-head">
        <div class="kp-section-title">
          <span class="kp-dot kp-dot--rose"></span>
          Koleksi Video Pembelajaran
          <span class="badge-tag">{{ $videos->count() }} video ditemukan</span>
        </div>
        <span class="metric-note" style="color:#94a3b8;">
          <i class="fa-solid fa-circle-info"></i> Klik pratinjau untuk memutar video
        </span>
      </div>

      @if($videos->isEmpty())
        <div class="box-card">
          <div class="empty-state">
            <i class="fa-solid fa-film"></i>
            <p>Tidak ada video pembelajaran ditemukan.</p>
          </div>
        </div>
      @else
        <div class="kp-media-grid">
          @foreach($videos as $video)
            @php
                $isYoutube = $video->source_type === 'youtube' && $video->embed_url;
                $ytId = null;
                if ($isYoutube) {
                    preg_match('/embed\/([a-zA-Z0-9_-]+)/', $video->embed_url, $ytMatches);
                    $ytId = $ytMatches[1] ?? null;
                }
            @endphp
            <article class="kp-media-card">
              <div class="kp-media-thumb {{ $isYoutube ? '' : 'kp-media-thumb--drive' }}">
                @if($isYoutube)
                  @if($ytId)
                    <img src="https://img.youtube.com/vi/{{ $ytId }}/mqdefault.jpg" alt="Pratinjau {{ $video->title }}" loading="lazy">
                  @endif
                @else
                  <i class="fa-brands fa-google-drive"></i>
                @endif

                <span class="kp-media-source {{ $isYoutube ? 'kp-media-source--yt' : 'kp-media-source--drive' }}">
                  <i class="fa-brands {{ $isYoutube ? 'fa-youtube' : 'fa-google-drive' }}"></i>
                  {{ $isYoutube ? 'YouTube' : 'G-Drive' }}
                </span>
                <span class="kp-media-class">{{ $video->class_level ?? 'Semua Kelas' }}</span>

                <button type="button" class="kp-media-play"
                        data-title="{{ $video->title }}"
                        data-url="{{ $video->embed_url ?? $video->video_url }}"
                        data-source="{{ $video->source_type }}"
                        onclick="openVideoModal(this)"
                        aria-label="Putar {{ $video->title }}">
                  <i class="fa-solid fa-play"></i>
                </button>
              </div>

              <div class="kp-media-body">
                <div class="kp-media-meta">
                  <span class="kp-media-subject">{{ $video->subject }}</span>
                  <span class="kp-media-date"><i class="fa-regular fa-calendar"></i> {{ $video->created_at->format('d M Y') }}</span>
                </div>
                <h3 class="kp-media-title">{{ $video->title }}</h3>
                <p class="kp-media-desc">{{ $video->description ?: 'Tidak ada deskripsi tambahan.' }}</p>

                <div class="kp-media-footer">
                  <div class="kp-author">
                    <span class="kp-author-avatar">{{ mb_substr($video->user->name ?? 'G', 0, 1) }}</span>
                    <span>{{ $video->user->name ?? 'Dewan Guru' }}</span>
                  </div>
                  <button type="button" class="kp-link-btn"
                          data-title="{{ $video->title }}"
                          data-url="{{ $video->embed_url ?? $video->video_url }}"
                          data-source="{{ $video->source_type }}"
                          onclick="openVideoModal(this)">
                    Supervisi <i class="fa-solid fa-arrow-right"></i>
                  </button>
                </div>
              </div>
            </article>
          @endforeach
        </div>
      @endif
    </section>
  @endif

  <!-- Material Section -->
  @if($tab === 'all' || $tab === 'materi')
    <section>
      <div class="kp-section-head">
        <div class="kp-section-title">
          <span class="kp-dot kp-dot--amber"></span>
          Daftar Modul &amp; Materi Pembelajaran
          <span class="badge-tag">{{ $materials->count() }} file tersedia</span>
        </div>
      </div>

      <div class="box-card">
        @if($materials->isEmpty())
          <div class="empty-state">
            <i class="fa-regular fa-folder-open"></i>
            <p>Tidak ada modul materi ditemukan.</p>
          </div>
        @else
          <div class="table-wrap">
            <table class="table-clean">
              <thead>
                <tr>
                  <th>Materi &amp; Judul</th>
                  <th>Mata Pelajaran</th>
                  <th>Target Kelas</th>
                  <th>Guru Pengunggah</th>
                  <th class="text-center">Unduhan</th>
                  <th class="text-right">Aksi</th>
                </tr>
              </thead>
              <tbody>
                @foreach($materials as $material)
                  <tr>
                    <td>
                      <div class="teacher-cell" style="align-items:flex-start;">
                        <span class="kp-file-icon"><i class="fa-solid fa-file-lines"></i></span>
                        <div class="teacher-identity">
                          <div class="teacher-name" style="max-width:280px;">{{ $material->title }}</div>
                          <div class="teacher-mail" style="max-width:280px;">{{ $material->description ?: 'Dokumen pembelajaran digital' }}</div>
                          <div class="kp-media-date" style="margin-top:4px;">
                            <i class="fa-regular fa-clock"></i> Diunggah {{ $material->created_at->diffForHumans() }}
                          </div>
                        </div>
                      </div>
                    </td>
                    <td><span class="subject-badge">{{ $material->subject }}</span></td>
                    <td><span class="badge-tag">{{ $material->class_level ?? 'Semua Kelas' }}</span></td>
                    <td>
                      <div class="teacher-cell">
                        <span class="kp-author-avatar">{{ mb_substr($material->user->name ?? 'G', 0, 1) }}</span>
                        <div class="teacher-identity">
                          <div class="teacher-name">{{ $material->user->name ?? 'Dewan Guru' }}</div>
                          <div class="teacher-mail">{{ $material->user->nip ?? '-' }}</div>
                        </div>
                      </div>
                    </td>
                    <td class="text-center">
                      <span class="count-pill count-pill--blue"><i class="fa-solid fa-arrow-down" style="font-size:.65rem;"></i>&nbsp;{{ $material->downloads }}x</span>
                    </td>
                    <td class="text-right">
                      <a href="{{ asset('storage/' . $material->file_path) }}" target="_blank" rel="noopener" class="kp-btn kp-btn--soft kp-btn--sm">
                        <i class="fa-solid fa-eye"></i> Tinjau
                      </a>
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        @endif
      </div>
    </section>
  @endif
</div>

<!-- Video Supervisi Modal -->
<div id="videoModal" class="kp-modal hidden">
  <div class="kp-modal-card" role="dialog" aria-modal="true" aria-labelledby="modalVideoTitle">
    <div class="kp-modal-head">
      <div class="kp-modal-title">
        <i class="fa-solid fa-circle-play"></i>
        <span id="modalVideoTitle">Supervisi Video</span>
      </div>
      <button type="button" class="kp-modal-close" onclick="closeVideoModal()" aria-label="Tutup jendela">
        <i class="fa-solid fa-xmark"></i>
      </button>
    </div>
    <div class="kp-modal-body">
      <iframe id="videoIframe" src="" title="Pemutar video pembelajaran"
              allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
              allowfullscreen></iframe>
    </div>
    <div class="kp-modal-foot">
      <button type="button" class="kp-btn kp-btn--soft" onclick="closeVideoModal()">
        <i class="fa-solid fa-xmark"></i> Tutup Jendela
      </button>
    </div>
  </div>
</div>
@endsection

@section('scripts')
<script src="{{ asset('mentahan2/js/kepsek-video.js') }}?v={{ filemtime(public_path('mentahan2/js/kepsek-video.js')) ?: time() }}"></script>
@endsection
