@extends('layouts.app')

@section('title', 'Akademik & Pembelajaran Siswa - ' . ($settings['school_name'] ?? 'SD Negeri Lama'))

@section('content')
<!-- PAGE HEADER -->
<div class="page-header">
  <h1>Akademik & Pembelajaran Siswa</h1>
  <p>Pusat media video edukasi interaktif, modul materi pembelajaran digital, serta kurikulum sekolah</p>
</div>

<div class="page-content" style="max-width: 1200px; margin: 0 auto; padding: 40px 20px;">

  <!-- ============================================================== -->
  <!-- 1. PUSAT VIDEO & MATERI PEMBELAJARAN DIGITAL                   -->
  <!-- ============================================================== -->
  <div class="card-box" style="margin-bottom: 35px; padding: 30px; border-radius: 18px; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.04); border: 1px solid var(--border);">
    <div style="display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; gap: 16px; margin-bottom: 24px; padding-bottom: 20px; border-bottom: 2px solid var(--light-bg);">
      <div>
        <div style="display: inline-flex; align-items: center; gap: 8px; background: #e0f2fe; color: #0284c7; padding: 4px 14px; border-radius: 20px; font-size: 0.8rem; font-weight: 700; margin-bottom: 8px;">
          <i class="fa-solid fa-graduation-cap"></i> Media Pembelajaran Digital
        </div>
        <h2 style="font-size: 1.65rem; font-weight: 800; color: var(--dark); margin: 0 0 6px 0;">
          Koleksi Video Edukasi & File Materi Pembelajaran
        </h2>
        <p style="color: var(--muted); margin: 0; font-size: 0.95rem; line-height: 1.6;">
          Disediakan oleh bapak/ibu guru untuk mempermudah siswa belajar mandiri di rumah maupun di kelas.
        </p>
      </div>

      <!-- Quick Total Count Badge -->
      <div style="background: var(--light-bg); padding: 10px 18px; border-radius: 12px; display: flex; align-items: center; gap: 12px;">
        <i class="fa-solid fa-layer-group" style="font-size: 1.5rem; color: var(--primary);"></i>
        <div>
          <div style="font-size: 0.75rem; color: var(--muted); font-weight: 700; text-transform: uppercase;">Total Tersedia</div>
          <div style="font-size: 1.25rem; font-weight: 800; color: var(--dark);">{{ $totalCombinedCount }} Konten</div>
        </div>
      </div>
    </div>

    <!-- FILTER BAR: TABS & SEARCH FORM -->
    <div style="background: var(--light-bg); padding: 20px; border-radius: 14px; margin-bottom: 30px;">
      <!-- FILTER TABS (SEMUA / VIDEO / MATERI) -->
      <div style="display: flex; gap: 10px; flex-wrap: wrap; margin-bottom: 18px;">
        <!-- Tab 1: Semua Media -->
        <a href="{{ route('akademik', array_merge(request()->query(), ['tab' => 'all'])) }}" style="padding: 10px 18px; border-radius: 10px; font-weight: 700; font-size: 0.88rem; text-decoration: none; display: inline-flex; align-items: center; gap: 8px; transition: all 0.2s; {{ ($tab === 'all' || !$tab) ? 'background: var(--primary); color: #ffffff; box-shadow: 0 4px 12px rgba(37, 99, 235, 0.25);' : 'background: #ffffff; color: var(--dark); border: 1px solid var(--border);' }}">
          <i class="fa-solid fa-shapes"></i> Semua Media ({{ $totalCombinedCount }})
        </a>

        <!-- Tab 2: Video Pembelajaran -->
        <a href="{{ route('akademik', array_merge(request()->query(), ['tab' => 'video'])) }}" style="padding: 10px 18px; border-radius: 10px; font-weight: 700; font-size: 0.88rem; text-decoration: none; display: inline-flex; align-items: center; gap: 8px; transition: all 0.2s; {{ $tab === 'video' ? 'background: #dc2626; color: #ffffff; box-shadow: 0 4px 12px rgba(220, 38, 38, 0.25);' : 'background: #ffffff; color: var(--dark); border: 1px solid var(--border);' }}">
          <i class="fa-brands fa-youtube"></i> Video Pembelajaran ({{ $totalVideoCount }})
        </a>

        <!-- Tab 3: File Materi -->
        <a href="{{ route('akademik', array_merge(request()->query(), ['tab' => 'materi'])) }}" style="padding: 10px 18px; border-radius: 10px; font-weight: 700; font-size: 0.88rem; text-decoration: none; display: inline-flex; align-items: center; gap: 8px; transition: all 0.2s; {{ $tab === 'materi' ? 'background: #0284c7; color: #ffffff; box-shadow: 0 4px 12px rgba(2, 132, 199, 0.25);' : 'background: #ffffff; color: var(--dark); border: 1px solid var(--border);' }}">
          <i class="fa-solid fa-file-arrow-down"></i> File Materi ({{ $totalMaterialCount }})
        </a>
      </div>

      <!-- FILTER CONTROLS: KELAS & SEARCH -->
      <form method="GET" action="{{ route('akademik') }}" style="display: flex; gap: 12px; flex-wrap: wrap; align-items: center;">
        <input type="hidden" name="tab" value="{{ $tab }}">

        <!-- Filter Kelas Dropdown -->
        <div style="min-width: 170px;">
          <select name="class_level" onchange="this.form.submit()" style="width: 100%; padding: 10px 14px; border: 1px solid var(--border); border-radius: 10px; font-size: 0.9rem; background: #ffffff; outline: none; font-weight: 600; cursor: pointer;">
            @foreach($availableClasses as $cls)
              <option value="{{ $cls }}" {{ ($classLevel === $cls || (!$classLevel && $cls === 'Semua Kelas')) ? 'selected' : '' }}>
                {{ $cls === 'Semua Kelas' ? '🎯 Semua Tingkat Kelas' : '🏫 ' . $cls }}
              </option>
            @endforeach
          </select>
        </div>

        <!-- Search Input -->
        <div style="position: relative; flex: 1; min-width: 220px;">
          <i class="fa-solid fa-magnifying-glass" style="position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: #94a3b8; font-size: 0.9rem;"></i>
          <input type="text" name="search" value="{{ $search }}" placeholder="Cari topik pembelajaran, judul materi, atau mapel..." style="width: 100%; padding: 10px 14px 10px 38px; border: 1px solid var(--border); border-radius: 10px; font-size: 0.9rem; outline: none; background: #ffffff; box-sizing: border-box;">
        </div>

        <!-- Filter Button -->
        <button type="submit" style="background: var(--primary); color: #ffffff; border: none; padding: 10px 20px; border-radius: 10px; font-weight: 700; font-size: 0.9rem; cursor: pointer; display: inline-flex; align-items: center; gap: 8px;">
          <i class="fa-solid fa-filter"></i> Terapkan
        </button>

        @if($search || ($classLevel && $classLevel !== 'Semua Kelas'))
        <a href="{{ route('akademik', ['tab' => $tab]) }}" style="background: #ffffff; color: #64748b; border: 1px solid var(--border); padding: 10px 16px; border-radius: 10px; font-weight: 600; font-size: 0.85rem; text-decoration: none; display: inline-flex; align-items: center; gap: 6px;">
          <i class="fa-solid fa-rotate-left"></i> Reset Filter
        </a>
        @endif
      </form>
    </div>

    <!-- ============================================================== -->
    <!-- BAGIAN 1: VIDEO PEMBELAJARAN                                   -->
    <!-- ============================================================== -->
    @if($tab !== 'materi')
    <div style="margin-bottom: 35px;">
      <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 18px; flex-wrap: wrap; gap: 10px;">
        <h3 style="font-size: 1.25rem; font-weight: 800; color: var(--dark); margin: 0; display: flex; align-items: center; gap: 10px;">
          <i class="fa-solid fa-circle-play" style="color: #ef4444;"></i> Video Pembelajaran Interaktif
        </h3>
        <span style="font-size: 0.85rem; color: var(--muted); font-weight: 600;">
          {{ count($videos) }} Video Ditemukan
        </span>
      </div>

      <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(min(100%, 280px), 1fr)); gap: 20px;">
        @forelse($videos as $video)
        <div style="background: #ffffff; border: 1px solid var(--border); border-radius: 14px; overflow: hidden; display: flex; flex-direction: column; justify-content: space-between; box-shadow: 0 4px 14px rgba(0, 0, 0, 0.04); transition: transform 0.2s, box-shadow 0.2s;" onmouseover="this.style.transform='translateY(-3px)'; this.style.boxShadow='0 10px 25px rgba(0,0,0,0.08)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 14px rgba(0,0,0,0.04)';">
          <div>
            <!-- Thumbnail Preview with Play Overlay -->
            <div style="position: relative; height: 165px; background: #0f172a; overflow: hidden;">
              @if($video->thumbnail_url)
                <img src="{{ $video->thumbnail_url }}" alt="{{ $video->title }}" style="width: 100%; height: 100%; object-fit: cover;" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                <div style="display: none; width: 100%; height: 100%; background: linear-gradient(135deg, {{ $video->is_drive ? '#0369a1, #0284c7' : '#991b1b, #ef4444' }}); align-items: center; justify-content: center; flex-direction: column; color: white;">
                  <i class="{{ $video->source_badge['icon'] }}" style="font-size: 2.8rem; margin-bottom: 6px;"></i>
                  <span style="font-size: 0.8rem; font-weight: 700;">{{ $video->source_badge['label'] }} Video</span>
                </div>
              @else
                <div style="width: 100%; height: 100%; background: linear-gradient(135deg, {{ $video->is_drive ? '#0284c7, #38bdf8' : '#dc2626, #f87171' }}); display: flex; align-items: center; justify-content: center; flex-direction: column; color: white;">
                  <i class="{{ $video->source_badge['icon'] }}" style="font-size: 2.8rem; margin-bottom: 6px;"></i>
                  <span style="font-size: 0.8rem; font-weight: 700;">{{ $video->source_badge['label'] }} Video</span>
                </div>
              @endif

              <!-- Play Button Trigger (Modal) -->
              <div style="position: absolute; inset: 0; background: rgba(0,0,0,0.32); display: flex; align-items: center; justify-content: center;">
                <button type="button" onclick="playPublicVideo('{{ addslashes($video->title) }}', '{{ $video->embed_url }}', '{{ $video->subject }}', '{{ $video->class_level }}', '{{ $video->source_badge['label'] }}')" style="width: 48px; height: 48px; border-radius: 50%; background: rgba(255,255,255,0.95); border: none; color: {{ $video->is_drive ? '#0284c7' : '#dc2626' }}; display: flex; align-items: center; justify-content: center; font-size: 1.25rem; cursor: pointer; box-shadow: 0 4px 14px rgba(0,0,0,0.35); transition: transform 0.2s;" onmouseover="this.style.transform='scale(1.1)'" onmouseout="this.style.transform='scale(1)'" title="Putar Video">
                  <i class="fa-solid fa-play" style="margin-left: 2px;"></i>
                </button>
              </div>

              <!-- Platform Badge (Top-Right) -->
              <span style="position: absolute; top: 8px; right: 8px; background: {{ $video->is_drive ? 'rgba(2, 132, 199, 0.92)' : 'rgba(220, 38, 38, 0.92)' }}; color: #ffffff; padding: 3px 8px; border-radius: 6px; font-size: 0.72rem; font-weight: 700; display: inline-flex; align-items: center; gap: 4px; box-shadow: 0 2px 6px rgba(0,0,0,0.25);">
                <i class="{{ $video->source_badge['icon'] }}"></i> {{ $video->source_badge['label'] }}
              </span>

              <!-- Duration Badge (Bottom-Right) -->
              <span style="position: absolute; bottom: 8px; right: 8px; background: rgba(15, 23, 42, 0.85); color: #ffffff; padding: 2px 7px; border-radius: 5px; font-size: 0.72rem; font-weight: 700;">
                <i class="fa-regular fa-clock" style="font-size: 0.68rem;"></i> {{ $video->duration }}
              </span>
            </div>

            <!-- Content Area -->
            <div style="padding: 16px;">
              <!-- Tags -->
              <div style="display: flex; gap: 6px; flex-wrap: wrap; margin-bottom: 8px;">
                <span style="background: #e0f2fe; color: #0369a1; padding: 2px 9px; border-radius: 12px; font-size: 0.72rem; font-weight: 700;">
                  {{ $video->class_level }}
                </span>
                <span style="background: #f1f5f9; color: #475569; padding: 2px 9px; border-radius: 12px; font-size: 0.72rem; font-weight: 700;">
                  {{ $video->subject }}
                </span>
              </div>

              <!-- Title -->
              <h4 style="font-size: 1rem; font-weight: 800; color: var(--dark); margin: 0 0 6px 0; line-height: 1.45; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; min-height: 2.9em;">
                {{ $video->title }}
              </h4>

              <!-- Description -->
              <p style="font-size: 0.82rem; color: var(--muted); line-height: 1.5; margin: 0 0 10px 0; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                {{ $video->description ?: 'Tidak ada deskripsi materi video.' }}
              </p>

              <!-- Teacher Uploader & Views -->
              <div style="display: flex; justify-content: space-between; align-items: center; font-size: 0.76rem; color: #94a3b8; border-top: 1px dashed var(--border); padding-top: 8px;">
                <span><i class="fa-solid fa-chalkboard-user"></i> {{ $video->user ? $video->user->name : 'Guru SD Negeri Lama' }}</span>
                <span><i class="fa-regular fa-eye"></i> {{ number_format($video->views_count, 0, ',', '.') }}x</span>
              </div>
            </div>
          </div>

          <!-- Card Actions Footer -->
          <div style="padding: 12px 16px; background: #f8fafc; border-top: 1px solid var(--border); display: flex; align-items: center; justify-content: space-between; gap: 8px;">
            <button type="button" onclick="playPublicVideo('{{ addslashes($video->title) }}', '{{ $video->embed_url }}', '{{ $video->subject }}', '{{ $video->class_level }}', '{{ $video->source_badge['label'] }}')" style="flex: 1; padding: 7px 12px; font-size: 0.8rem; background: var(--primary); color: #fff; border: none; border-radius: 8px; font-weight: 700; cursor: pointer; display: inline-flex; align-items: center; justify-content: center; gap: 6px;">
              <i class="fa-solid fa-play"></i> Tonton Video
            </button>

            @if($video->effective_url)
            <a href="{{ $video->effective_url }}" target="_blank" rel="noopener noreferrer" style="background: #ffffff; color: #475569; border: 1px solid var(--border); padding: 7px 10px; border-radius: 8px; font-size: 0.8rem; text-decoration: none; display: inline-flex; align-items: center; justify-content: center;" title="Buka tautan asli">
              <i class="fa-solid fa-arrow-up-right-from-square"></i>
            </a>
            @endif
          </div>
        </div>
        @empty
        <div style="grid-column: 1 / -1; padding: 36px 20px; background: #ffffff; border: 1px dashed var(--border); border-radius: 14px; text-align: center; color: var(--muted);">
          <i class="fa-solid fa-video-slash" style="font-size: 2.2rem; color: #cbd5e1; margin-bottom: 10px; display: block;"></i>
          <h4 style="font-size: 1.05rem; font-weight: 700; color: var(--dark); margin-bottom: 4px;">Tidak Ada Video Pembelajaran</h4>
          <p style="font-size: 0.88rem; margin: 0;">Tidak ditemukan video pembelajaran yang cocok dengan filter pencarian ini.</p>
        </div>
        @endforelse
      </div>
    </div>
    @endif

    <!-- ============================================================== -->
    <!-- BAGIAN 2: FILE MATERI PEMBELAJARAN (PDF, DOCX, PPTX)           -->
    <!-- ============================================================== -->
    @if($tab !== 'video')
    <div>
      <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 18px; flex-wrap: wrap; gap: 10px;">
        <h3 style="font-size: 1.25rem; font-weight: 800; color: var(--dark); margin: 0; display: flex; align-items: center; gap: 10px;">
          <i class="fa-solid fa-folder-open" style="color: #2563eb;"></i> Berkas Materi & Modul Pembelajaran
        </h3>
        <span style="font-size: 0.85rem; color: var(--muted); font-weight: 600;">
          {{ count($materials) }} Berkas Tersedia
        </span>
      </div>

      <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(min(100%, 280px), 1fr)); gap: 20px;">
        @forelse($materials as $material)
        <div style="background: #ffffff; border: 1px solid var(--border); border-radius: 14px; padding: 20px; display: flex; flex-direction: column; justify-content: space-between; box-shadow: 0 4px 14px rgba(0, 0, 0, 0.04); transition: transform 0.2s, box-shadow 0.2s;" onmouseover="this.style.transform='translateY(-3px)'; this.style.boxShadow='0 10px 25px rgba(0,0,0,0.08)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 14px rgba(0,0,0,0.04)';">
          <div>
            <!-- File Type Header -->
            <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 14px;">
              <div style="width: 44px; height: 44px; border-radius: 10px; background: {{ $material->icon_color }}15; color: {{ $material->icon_color }}; display: flex; align-items: center; justify-content: center; font-size: 1.4rem;">
                <i class="{{ $material->icon }}"></i>
              </div>
              <span style="background: #f1f5f9; color: #475569; padding: 4px 10px; border-radius: 20px; font-size: 0.72rem; font-weight: 700;">
                {{ $material->file_size ?: 'Dokumen Digital' }}
              </span>
            </div>

            <!-- Tags -->
            <div style="display: flex; gap: 6px; flex-wrap: wrap; margin-bottom: 8px;">
              <span style="background: #e0f2fe; color: #0369a1; padding: 2px 9px; border-radius: 12px; font-size: 0.72rem; font-weight: 700;">
                {{ $material->class_level }}
              </span>
              <span style="background: #f1f5f9; color: #475569; padding: 2px 9px; border-radius: 12px; font-size: 0.72rem; font-weight: 700;">
                {{ $material->subject }}
              </span>
            </div>

            <!-- Title -->
            <h4 style="font-size: 1.02rem; font-weight: 800; color: var(--dark); margin: 0 0 6px 0; line-height: 1.45; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; min-height: 2.9em;">
              {{ $material->title }}
            </h4>

            <!-- Description -->
            <p style="font-size: 0.84rem; color: var(--muted); line-height: 1.5; margin: 0 0 12px 0; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
              {{ $material->description ?: 'Bahan ajar materi mandiri untuk peserta didik.' }}
            </p>
          </div>

          <!-- Card Footer & Download Button -->
          <div style="border-top: 1px solid var(--border); padding-top: 12px; margin-top: 8px; display: flex; align-items: center; justify-content: space-between; gap: 8px;">
            <div style="font-size: 0.75rem; color: #94a3b8;">
              <div><i class="fa-solid fa-chalkboard-user"></i> {{ $material->user ? $material->user->name : 'Guru Mapel' }}</div>
              <div style="margin-top: 2px;"><i class="fa-solid fa-download"></i> {{ number_format($material->downloads, 0, ',', '.') }} kali diunduh</div>
            </div>

            <a href="{{ route('materi.download', $material->id) }}" style="padding: 8px 14px; font-size: 0.8rem; background: #0284c7; color: #fff; text-decoration: none; border-radius: 8px; font-weight: 700; display: inline-flex; align-items: center; gap: 6px; box-shadow: 0 2px 8px rgba(2, 132, 199, 0.25);" title="Unduh Berkas Pembelajaran">
              <i class="fa-solid fa-cloud-arrow-down"></i> Unduh
            </a>
          </div>
        </div>
        @empty
        <div style="grid-column: 1 / -1; padding: 36px 20px; background: #ffffff; border: 1px dashed var(--border); border-radius: 14px; text-align: center; color: var(--muted);">
          <i class="fa-solid fa-file-circle-xmark" style="font-size: 2.2rem; color: #cbd5e1; margin-bottom: 10px; display: block;"></i>
          <h4 style="font-size: 1.05rem; font-weight: 700; color: var(--dark); margin-bottom: 4px;">Tidak Ada Berkas Materi</h4>
          <p style="font-size: 0.88rem; margin: 0;">Tidak ditemukan bahan ajar yang cocok dengan filter pencarian ini.</p>
        </div>
        @endforelse
      </div>
    </div>
    @endif
  </div>

  <!-- ============================================================== -->
  <!-- 2. KURIKULUM MERDEKA                                           -->
  <!-- ============================================================== -->
  <div class="card-box" style="margin-bottom: 30px; padding: 30px; border-radius: 18px; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.04); border: 1px solid var(--border);">
    <h2 style="font-size: 1.5rem; color: var(--primary); margin-bottom: 16px;"><i class="fa-solid fa-book-open-reader"></i> {{ $settings['curriculum_title'] ?? 'Kurikulum Merdeka' }}</h2>
    <p style="color: var(--muted); line-height: 1.8; margin-bottom: 0;">
      {!! nl2br(e($settings['curriculum_desc'] ?? (($settings['school_name'] ?? 'SD Negeri Lama') . ' menerapkan Kurikulum Merdeka yang berfokus pada pengembangan minat, bakat, dan pembentukan Karakter Pelajar Pancasila. Sistem pembelajaran dirancang agar fleksibel dan interaktif melalui Projek Penguatan Profil Pelajar Pancasila (P5).'))) !!}
    </p>
  </div>

  <!-- ============================================================== -->
  <!-- 3. EKSTRAKURIKULER                                             -->
  <!-- ============================================================== -->
  <div class="card-box" style="padding: 30px; border-radius: 18px; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.04); border: 1px solid var(--border);">
    <h2 style="font-size: 1.5rem; color: var(--primary); margin-bottom: 16px;"><i class="fa-solid fa-medal"></i> Ekstrakurikuler</h2>
    <p style="color: var(--muted); margin-bottom: 20px;">Kami menyediakan berbagai wadah pengembangan bakat non-akademik bagi peserta didik:</p>
    @php
      $defaultEskuls = [
        'Pramuka (Wajib)',
        'Sepak Bola & Futsal',
        'Seni Musik & Pianika',
        'Seni Lukis & Mewarnai',
        'Ekskul Komputer / Coding',
        'Pencak Silat'
      ];
      if (!empty($settings['extracurriculars'])) {
        $eskuls = array_filter(array_map('trim', explode("\n", $settings['extracurriculars'])));
      } else {
        $eskuls = $defaultEskuls;
      }

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
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px;">
      @foreach($eskuls as $eskul)
      <div style="background: var(--light-bg); padding: 16px; border-radius: 12px; font-weight: 700; display: flex; align-items: center; gap: 10px;">
        <i class="fa-solid {{ $getIcon($eskul) }}" style="color: var(--primary); font-size: 1.1rem; width: 22px; text-align: center;"></i>
        <span>{{ $eskul }}</span>
      </div>
      @endforeach
    </div>
  </div>
</div>

<!-- ============================================================== -->
<!-- MODAL PEMUTAR VIDEO DIGITAL (INTERAKTIF UNTUK SISWA/PENGUNJUNG) -->
<!-- ============================================================== -->
<div id="modalPublicVideo" style="display: none; position: fixed; inset: 0; background: rgba(15, 23, 42, 0.75); z-index: 99999; justify-content: center; align-items: center; padding: 16px; backdrop-filter: blur(4px);">
  <div style="background: #ffffff; width: 100%; max-width: 760px; border-radius: 16px; overflow: hidden; box-shadow: 0 25px 50px rgba(0,0,0,0.3); display: flex; flex-direction: column;">
    <!-- Modal Header -->
    <div style="padding: 16px 20px; background: #0f172a; color: #ffffff; display: flex; justify-content: space-between; align-items: center;">
      <div style="display: flex; align-items: center; gap: 10px; min-width: 0;">
        <i class="fa-solid fa-circle-play" style="color: #ef4444; font-size: 1.2rem; flex-shrink: 0;"></i>
        <h3 id="modalVideoTitle" style="margin: 0; font-size: 1.05rem; font-weight: 800; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; color: #ffffff;">
          Pemutar Video Edukasi
        </h3>
      </div>
      <button type="button" onclick="closePublicVideo()" style="background: transparent; border: none; color: #94a3b8; font-size: 1.5rem; cursor: pointer; line-height: 1; padding: 0 4px; transition: color 0.2s;" onmouseover="this.style.color='#ffffff'" onmouseout="this.style.color='#94a3b8'">&times;</button>
    </div>

    <!-- 16:9 Video Player Iframe Container -->
    <div style="position: relative; width: 100%; aspect-ratio: 16/9; background: #000000;">
      <iframe id="modalVideoIframe" src="" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; border: 0;" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
    </div>

    <!-- Modal Footer with Meta info -->
    <div style="padding: 14px 20px; background: #f8fafc; border-top: 1px solid var(--border); display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 10px;">
      <div style="display: flex; align-items: center; gap: 8px;">
        <span id="modalVideoSubject" style="background: #e0f2fe; color: #0369a1; padding: 3px 10px; border-radius: 12px; font-size: 0.75rem; font-weight: 700;">
          Mapel
        </span>
        <span id="modalVideoClass" style="background: #f1f5f9; color: #475569; padding: 3px 10px; border-radius: 12px; font-size: 0.75rem; font-weight: 700;">
          Kelas
        </span>
        <span id="modalVideoPlatform" style="font-size: 0.75rem; color: #94a3b8; font-weight: 600;">
          Platform
        </span>
      </div>

      <button type="button" onclick="closePublicVideo()" style="background: #e2e8f0; color: #334155; border: none; padding: 6px 14px; border-radius: 8px; font-weight: 700; font-size: 0.82rem; cursor: pointer;">
        Tutup Pemutar
      </button>
    </div>
  </div>
</div>

<script>
  function playPublicVideo(title, embedUrl, subject, classLevel, platform) {
    const modal = document.getElementById('modalPublicVideo');
    const iframe = document.getElementById('modalVideoIframe');
    const titleEl = document.getElementById('modalVideoTitle');
    const subjectEl = document.getElementById('modalVideoSubject');
    const classEl = document.getElementById('modalVideoClass');
    const platformEl = document.getElementById('modalVideoPlatform');

    if (!modal || !iframe) return;

    titleEl.textContent = title;
    subjectEl.textContent = subject;
    classEl.textContent = classLevel;
    platformEl.textContent = 'Sumber: ' + platform;

    // Set autoplay if embed URL supports it
    const autoplayUrl = embedUrl.includes('?') ? (embedUrl + '&autoplay=1') : (embedUrl + '?autoplay=1');
    iframe.src = autoplayUrl;

    modal.style.display = 'flex';
  }

  function closePublicVideo() {
    const modal = document.getElementById('modalPublicVideo');
    const iframe = document.getElementById('modalVideoIframe');
    if (modal) modal.style.display = 'none';
    if (iframe) iframe.src = ''; // Clear src so video sound stops immediately
  }

  // Close modal when clicking on dark backdrop
  window.addEventListener('click', function(e) {
    const modal = document.getElementById('modalPublicVideo');
    if (e.target === modal) {
      closePublicVideo();
    }
  });
</script>
@endsection
