@extends('layouts.app')

@section('title', 'Akademik & Pembelajaran Siswa - ' . ($settings['school_name'] ?? 'SD Negeri Negeri Lama'))

@section('content')
<div class="pv-hero" style="background-image: linear-gradient(rgba(15, 23, 42, 0.62), rgba(30, 64, 175, 0.6)), url('{{ asset('mentahan2/img/image1.png') }}');">
  <div class="pv-hero-inner">
    <span class="pv-hero-chip"><i class="fa-solid fa-book-open"></i> Portal Pembelajaran Digital</span>
    <h1>Akademik & Pembelajaran Siswa</h1>
    <p>Pusat media video edukasi interaktif, modul materi pembelajaran digital, serta informasi kurikulum dan ekstrakurikuler sekolah.</p>
  </div>
</div>

<div class="pv-wrap">
  <!-- ============ 1. PUSAT VIDEO & MATERI PEMBELAJARAN DIGITAL ============ -->
  @guest
  <div class="pv-card pv-card--gradient pv-gate">
    
    <div class="pv-icon pv-icon--blue"><i class="fa-solid fa-graduation-cap"></i></div>
    <h2 class="pv-title" style="justify-content: center;"><i class="fa-solid fa-lock" style="color: #d97706;"></i> Media Video Edukasi & Modul Pembelajaran Khusus Siswa</h2>
    <p style="color: var(--muted); font-size: 0.98rem; max-width: 650px; margin: 0 auto 24px; line-height: 1.65;">
      Video pembelajaran interaktif dan file bahan ajar bapak/ibu guru dilindungi dan dapat diakses oleh <strong>peserta didik terdaftar</strong> melalui Portal Belajar Siswa.
    </p>

    <form action="{{ route('siswa.akses.nisn') }}" method="POST" class="pv-gate-form">
      @csrf
      <div class="pv-gate-row">
        <div class="pv-input-wrap">
          <i class="fa-solid fa-id-badge"></i>
          <input type="text" name="nisn" value="{{ old('nisn') }}" placeholder="Masukkan Nomor NISN Terdaftar..." required autofocus class="pv-input">
        </div>
        <button type="submit" class="pv-btn pv-btn--primary pv-btn--inline"><i class="fa-solid fa-arrow-right-to-bracket"></i> Masuk Ruang Belajar</button>
      </div>

      @if(session('error_nisn'))
      <div class="pv-alert">
        <i class="fa-solid fa-circle-exclamation" style="font-size: 1.1rem; color: #ef4444;"></i>
        <span>{{ session('error_nisn') }}</span>
      </div>
      @endif

      <div class="pv-note">
        <i class="fa-solid fa-circle-info" style="color: #3b82f6;"></i>
        Akses khusus peserta didik aktif {{ $settings['school_name'] ?? 'SD Negeri Negeri Lama' }}. (Contoh NISN: <code>009123401</code>)
      </div>
    </form>

    <div style="margin-top: 8px;">
      <a href="{{ route('kontak') }}" class="pv-help-link">
        <i class="fa-solid fa-circle-question"></i> Belum tahu nomor NISN Anda? Hubungi Guru / Sekolah
      </a>
    </div>
  </div>
  @else
  <div class="pv-card">
    <div class="pv-auth-banner">
      <span><i class="fa-solid fa-circle-check" style="color: #2563eb;"></i> Anda sedang masuk sebagai <strong>{{ Auth::user()->name }}</strong>.</span>
      <a href="{{ route('siswa.beranda') }}">Buka Tampilan Ruang Belajar <i class="fa-solid fa-arrow-right"></i></a>
    </div>

    <div class="pv-head-row">
      <div>
        <span class="pv-eyebrow"><i class="fa-solid fa-graduation-cap"></i> Media Pembelajaran Digital</span>
        <h2 class="pv-title" style="margin-bottom: 6px;">Koleksi Video Edukasi & File Materi Pembelajaran</h2>
        <p style="color: var(--muted); margin: 0; font-size: 0.95rem; line-height: 1.6;">
          Disediakan oleh bapak/ibu guru untuk mempermudah siswa belajar mandiri di rumah maupun di kelas.
        </p>
      </div>
      <div class="pv-total">
        <i class="fa-solid fa-layer-group"></i>
        <div>
          <div class="pv-total-label">Total Tersedia</div>
          <div class="pv-total-count">{{ $totalCombinedCount }} Konten</div>
        </div>
      </div>
    </div>

    <!-- FILTER BAR: TABS & SEARCH -->
    <div class="pv-filter">
      <div class="pv-tabs">
        <a class="pv-tab pv-tab--all {{ ($tab === 'all' || !$tab) ? 'pv-tab--active' : '' }}" href="{{ route('akademik', array_merge(request()->query(), ['tab' => 'all'])) }}">
          <i class="fa-solid fa-shapes"></i> Semua Media ({{ $totalCombinedCount }})
        </a>
        <a class="pv-tab pv-tab--video {{ $tab === 'video' ? 'pv-tab--active' : '' }}" href="{{ route('akademik', array_merge(request()->query(), ['tab' => 'video'])) }}">
          <i class="fa-brands fa-youtube"></i> Video ({{ $totalVideoCount }})
        </a>
        <a class="pv-tab pv-tab--materi {{ $tab === 'materi' ? 'pv-tab--active' : '' }}" href="{{ route('akademik', array_merge(request()->query(), ['tab' => 'materi'])) }}">
          <i class="fa-solid fa-file-arrow-down"></i> Materi ({{ $totalMaterialCount }})
        </a>
      </div>

      <form method="GET" action="{{ route('akademik') }}" class="pv-filter-form">
        <input type="hidden" name="tab" value="{{ $tab }}">

        <select name="class_level" class="pv-select" onchange="this.form.submit()">
          @foreach($availableClasses as $cls)
            <option value="{{ $cls }}" {{ ($classLevel === $cls || (!$classLevel && $cls === 'Semua Kelas')) ? 'selected' : '' }}>
              {{ $cls === 'Semua Kelas' ? 'Semua Tingkat Kelas' : $cls }}
            </option>
          @endforeach
        </select>

        <div class="pv-search-wrap">
          <i class="fa-solid fa-magnifying-glass"></i>
          <input type="text" name="search" value="{{ $search }}" placeholder="Cari topik pembelajaran, judul materi, atau mapel..." class="pv-search">
        </div>

        <button type="submit" class="pv-btn pv-btn--primary pv-btn--inline" style="padding: 11px 20px; font-size: 0.9rem;"><i class="fa-solid fa-filter"></i> Terapkan</button>

        @if($search || ($classLevel && $classLevel !== 'Semua Kelas'))
        <a class="pv-reset" href="{{ route('akademik', ['tab' => $tab]) }}"><i class="fa-solid fa-rotate-left"></i> Reset</a>
        @endif
      </form>
    </div>

    <!-- BAGIAN 1: VIDEO PEMBELAJARAN -->
    @if($tab !== 'materi')
    <div style="margin-bottom: 8px;">
      <div class="pv-section-head">
        <h3><i class="fa-solid fa-circle-play" style="color: #ef4444;"></i> Video Pembelajaran Interaktif</h3>
        <span class="pv-count">{{ count($videos) }} Video Ditemukan</span>
      </div>

      <div class="pv-media-grid">
        @forelse($videos as $video)
        <div class="pv-vcard">
          <div>
            <div class="pv-vthumb">
              @if($video->thumbnail_url)
                <img src="{{ $video->thumbnail_url }}" alt="{{ $video->title }}" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                <div class="pv-vfallback" style="display: none; background: linear-gradient(135deg, {{ $video->is_drive ? '#0369a1, #0284c7' : '#991b1b, #ef4444' }});">
                  <i class="{{ $video->source_badge['icon'] }}"></i>
                  <span>{{ $video->source_badge['label'] }} Video</span>
                </div>
              @else
                <div class="pv-vfallback" style="background: linear-gradient(135deg, {{ $video->is_drive ? '#0284c7, #38bdf8' : '#dc2626, #f87171' }});">
                  <i class="{{ $video->source_badge['icon'] }}"></i>
                  <span>{{ $video->source_badge['label'] }} Video</span>
                </div>
              @endif

              <button type="button" class="pv-vplay"
                data-title="{{ $video->title }}" data-embed="{{ $video->embed_url }}" data-subject="{{ $video->subject }}"
                data-class-level="{{ $video->class_level }}" data-platform="{{ $video->source_badge['label'] }}"
                onclick="openPublicVideo(this)" title="Putar Video">
                <span><i class="fa-solid fa-play" style="margin-left: 2px;"></i></span>
              </button>

              <span class="pv-vbadge" style="background: {{ $video->is_drive ? 'rgba(2, 132, 199, 0.92)' : 'rgba(220, 38, 38, 0.92)' }};">
                <i class="{{ $video->source_badge['icon'] }}"></i> {{ $video->source_badge['label'] }}
              </span>

              <span class="pv-vduration">
                <i class="fa-regular fa-clock" style="font-size: 0.68rem;"></i> {{ $video->duration }}
              </span>
            </div>

            <div class="pv-vbody">
              <div class="pv-tags">
                <span class="pv-tag pv-tag--blue">{{ $video->class_level }}</span>
                <span class="pv-tag pv-tag--gray">{{ $video->subject }}</span>
              </div>

              <h4 class="pv-vtitle">{{ $video->title }}</h4>

              <p class="pv-vdesc">{{ $video->description ?: 'Tidak ada deskripsi materi video.' }}</p>

              <div class="pv-vmeta">
                <span><i class="fa-solid fa-chalkboard-user"></i> {{ $video->user ? $video->user->name : 'Guru ' . ($settings['school_name'] ?? 'SD Negeri Negeri Lama') }}</span>
                <span style="flex-shrink: 0;"><i class="fa-regular fa-eye"></i> {{ number_format($video->views_count, 0, ',', '.') }}x</span>
              </div>
            </div>
          </div>

          <div class="pv-vactions">
            <button type="button" class="pv-btn pv-btn--primary"
              data-title="{{ $video->title }}" data-embed="{{ $video->embed_url }}" data-subject="{{ $video->subject }}"
              data-class-level="{{ $video->class_level }}" data-platform="{{ $video->source_badge['label'] }}"
              onclick="openPublicVideo(this)">
              <i class="fa-solid fa-play"></i> Tonton Video
            </button>

            @if($video->effective_url)
            <a href="{{ $video->effective_url }}" target="_blank" rel="noopener noreferrer" class="pv-vopen" title="Buka tautan asli">
              <i class="fa-solid fa-arrow-up-right-from-square"></i>
            </a>
            @endif
          </div>
        </div>
        @empty
        <div class="pv-empty">
          <i class="fa-solid fa-video-slash"></i>
          <h4>Tidak Ada Video Pembelajaran</h4>
          <p>Tidak ditemukan video pembelajaran yang cocok dengan filter pencarian ini.</p>
        </div>
        @endforelse
      </div>
    </div>
    @endif

    <!-- BAGIAN 2: FILE MATERI PEMBELAJARAN -->
    @if($tab !== 'video')
    <div>
      <div class="pv-section-head">
        <h3><i class="fa-solid fa-folder-open" style="color: #2563eb;"></i> Berkas Materi & Modul Pembelajaran</h3>
        <span class="pv-count">{{ count($materials) }} Berkas Tersedia</span>
      </div>

      <div class="pv-media-grid">
        @forelse($materials as $material)
        <div class="pv-mcard">
          <div>
            <div class="pv-mtop">
              <div class="pv-micon" style="background: {{ $material->icon_color }}15; color: {{ $material->icon_color }};">
                <i class="{{ $material->icon }}"></i>
              </div>
              <span class="pv-msize">{{ $material->file_size ?: 'Dokumen Digital' }}</span>
            </div>

            <div class="pv-tags">
              <span class="pv-tag pv-tag--blue">{{ $material->class_level }}</span>
              <span class="pv-tag pv-tag--gray">{{ $material->subject }}</span>
            </div>

            <h4 class="pv-mtitle">{{ $material->title }}</h4>

            <p class="pv-mdesc">{{ $material->description ?: 'Bahan ajar materi mandiri untuk peserta didik.' }}</p>
          </div>

          <div class="pv-mfooter">
            <div class="pv-mmeta">
              <div><i class="fa-solid fa-chalkboard-user"></i> {{ $material->user ? $material->user->name : 'Guru Mapel' }}</div>
              <div><i class="fa-solid fa-download"></i> {{ number_format($material->downloads, 0, ',', '.') }} kali diunduh</div>
            </div>

            <a href="{{ route('materi.download', $material->id) }}" class="pv-mdl" title="Unduh Berkas Pembelajaran">
              <i class="fa-solid fa-cloud-arrow-down"></i> Unduh
            </a>
          </div>
        </div>
        @empty
        <div class="pv-empty">
          <i class="fa-solid fa-file-circle-xmark"></i>
          <h4>Tidak Ada Berkas Materi</h4>
          <p>Tidak ditemukan bahan ajar yang cocok dengan filter pencarian ini.</p>
        </div>
        @endforelse
      </div>
    </div>
    @endif
  </div>
  @endguest

  <!-- ============ 2. KURIKULUM ============ -->
  @if(!empty($settings['curriculum_title']))
  <div class="pv-card">
    <h2 class="pv-title"><i class="fa-solid fa-book-open-reader"></i> {{ $settings['curriculum_title'] }}</h2>
    <p style="color: var(--muted); line-height: 1.85; margin: 0; font-size: 0.95rem;">
      {!! nl2br(e($settings['curriculum_desc'] ?? '')) !!}
    </p>
  </div>
  @endif

  <!-- ============ 3. EKSTRAKURIKULER ============ -->
  <div class="pv-card" style="margin-bottom: 0;">
    <h2 class="pv-title"><i class="fa-solid fa-medal"></i> Ekstrakurikuler</h2>
    @if(!empty($settings['extracurriculars']))
    <p style="color: var(--muted); margin: 0 0 20px; font-size: 0.95rem;">Kami menyediakan berbagai wadah pengembangan bakat non-akademik bagi peserta didik:</p>
    @php
      $eskuls = array_filter(array_map('trim', explode("\n", $settings['extracurriculars'])));

      $getIcon = function($name) {
        $lower = strtolower($name);
        if (str_contains($lower, 'pramuka')) return 'fa-campground';
        if (str_contains($lower, 'bola') || str_contains($lower, 'futsal')) return 'fa-futbol';
        if (str_contains($lower, 'musik') || str_contains($lower, 'pianika') || str_contains($lower, 'suara')) return 'fa-music';
        if (str_contains($lower, 'lukis') || str_contains($lower, 'warna') || str_contains($lower, 'tari')) return 'fa-palette';
        if (str_contains($lower, 'komputer') || str_contains($lower, 'coding') || str_contains($lower, 'it')) return 'fa-microchip';
        if (str_contains($lower, 'silat') || str_contains($lower, 'karate') || str_contains($lower, 'taekwondo')) return 'fa-hand-fist';
        if (str_contains($lower, 'tangkis') || str_contains($lower, 'badminton')) return 'fa-baseball';
        if (str_contains($lower, 'dokter') || str_contains($lower, 'uks') || str_contains($lower, 'pmr')) return 'fa-notes-medical';
        if (str_contains($lower, 'qur') || str_contains($lower, 'rohis') || str_contains($lower, 'agama')) return 'fa-book-quran';
        return 'fa-medal';
      };
    @endphp
    <div class="pv-eskul-grid">
      @foreach($eskuls as $eskul)
      <div class="pv-eskul">
        <i class="fa-solid {{ $getIcon($eskul) }}"></i>
        <span>{{ $eskul }}</span>
      </div>
      @endforeach
    </div>
    @else
    <div class="pv-empty" style="grid-column: auto;">
      <i class="fa-solid fa-inbox"></i>
      <h4>Data Belum Tersedia</h4>
      <p>Admin belum menambahkan data ekstrakurikuler. Silakan kembali kemudian.</p>
    </div>
    @endif
  </div>
</div>

<!-- ============ MODAL PEMUTAR VIDEO ============ -->
<div id="modalPublicVideo" class="pv-modal">
  <div class="pv-modal-box">
    <div class="pv-modal-head">
      <h3 class="pv-modal-head-title">
        <i class="fa-solid fa-circle-play" style="color: #ef4444; flex-shrink: 0;"></i>
        <span id="modalVideoTitle" style="overflow: hidden; text-overflow: ellipsis;">Pemutar Video Edukasi</span>
      </h3>
      <button type="button" class="pv-modal-close" onclick="closePublicVideo()">&times;</button>
    </div>

    <div class="pv-modal-frame">
      <iframe id="modalVideoIframe" src="" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
    </div>

    <div class="pv-modal-foot">
      <div class="pv-modal-meta">
        <span id="modalVideoSubject" class="pv-tag pv-tag--blue">Mapel</span>
        <span id="modalVideoClass" class="pv-tag pv-tag--gray">Kelas</span>
        <span id="modalVideoPlatform" class="pv-modal-platform">Platform</span>
      </div>
      <button type="button" class="pv-modal-btn" onclick="closePublicVideo()">Tutup Pemutar</button>
    </div>
  </div>
</div>
@endsection

@section('scripts')
<script src="{{ asset('mentahan2/js/akademik.js') }}?v={{ filemtime(public_path('mentahan2/js/akademik.js')) ?: time() }}"></script>
@endsection
