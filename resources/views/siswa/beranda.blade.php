@extends('layouts.app')

@section('title', 'Ruang Belajar Siswa - ' . ($settings['school_name'] ?? 'SD Negeri Lama'))

@section('content')
<!-- Hero Section -->
<section class="hero home-hero" style="position: relative; padding: 90px 6% 120px; background-image: url('{{ asset('mentahan2/img/image1.png') }}'); background-size: cover; background-position: center; background-repeat: no-repeat; display: grid; grid-template-columns: 1.2fr 0.8fr; align-items: center; gap: 40px; overflow: hidden;">
  <!-- Dark Dimming Overlay -->
  <div class="hero-overlay" style="position: absolute; inset: 0; background: linear-gradient(105deg, rgba(11, 23, 44, 0.78) 0%, rgba(16, 37, 74, 0.68) 55%, rgba(11, 23, 44, 0.55) 100%); pointer-events: none; z-index: 1;"></div>

  <div class="hero-content" style="position: relative; z-index: 2;">
    <div style="display: inline-flex; align-items: center; gap: 8px; background: rgba(255, 255, 255, 0.18); backdrop-filter: blur(8px); color: #ffffff; padding: 6px 18px; border-radius: 30px; font-size: 0.85rem; font-weight: 700; margin-bottom: 20px; border: 1px solid rgba(255, 255, 255, 0.28);">
      <i class="fa-solid fa-graduation-cap" style="color: #60a5fa;"></i> Portal Pembelajaran Siswa Terdaftar
    </div>

    <h1 style="font-size: clamp(1.75rem, 5.5vw, 3.2rem); line-height: 1.2; font-weight: 800; color: #ffffff; margin-bottom: 18px; letter-spacing: -0.5px; text-shadow: 0 2px 8px rgba(15, 23, 42, 0.55);">
      Ruang Belajar Digital <span style="color: #93c5fd;">{{ $settings['school_name'] ?? 'SD Negeri Lama' }}</span>
    </h1>

    <p style="font-size: clamp(0.92rem, 2.5vw, 1.1rem); color: #ffffff; margin-bottom: 26px; max-width: 620px; text-shadow: 0 2px 6px rgba(15, 23, 42, 0.55); line-height: 1.6;">
      Selamat datang, <strong>{{ $user->name }}</strong>{{ $studentProfile ? ' (' . $studentProfile->class_name . ' - NISN: ' . $studentProfile->nisn . ')' : '' }}! Akses seluruh video edukasi interaktif dan modul materi ajar digital persembahan bapak/ibu guru untuk kegiatan belajar mandirimu.
    </p>

    <div class="hero-buttons" style="display: flex; gap: 16px; flex-wrap: wrap;">
      <a href="#media-pembelajaran" class="btn-login" style="padding: 14px 28px; font-size: 1rem; border-radius: 12px; text-decoration: none;">
        <i class="fa-solid fa-circle-play"></i> Jelajahi Materi & Video
      </a>
      <a href="{{ route('home') }}" style="background: #ffffff; color: var(--primary); border: 2px solid var(--border); padding: 14px 28px; border-radius: 12px; font-weight: 700; display: inline-flex; align-items: center; gap: 10px; text-decoration: none;">
        <i class="fa-solid fa-house"></i> Beranda Sekolah
      </a>
    </div>
  </div>
</section>

<!-- Quick Stats / Learning Features Bar -->
<section class="home-features" style="margin-top: -60px; padding: 0 6%; position: relative; z-index: 10;">
  <div class="features-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 20px;">
    
    <div style="background: var(--card-bg); padding: 24px; border-radius: var(--radius); box-shadow: var(--shadow-md); border: 1px solid var(--border); display: flex; align-items: flex-start; gap: 16px;">
      <div style="width: 50px; height: 50px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.4rem; flex-shrink: 0; background: #fee2e2; color: #dc2626;">
        <i class="fa-brands fa-youtube"></i>
      </div>
      <div>
        <h3 style="font-size: 1.25rem; font-weight: 800; margin-bottom: 2px; color: var(--dark);">{{ $totalVideoCount }} Video</h3>
        <p style="font-size: 0.85rem; color: var(--muted); margin: 0;">Materi video interaktif guru</p>
      </div>
    </div>

    <div style="background: var(--card-bg); padding: 24px; border-radius: var(--radius); box-shadow: var(--shadow-md); border: 1px solid var(--border); display: flex; align-items: flex-start; gap: 16px;">
      <div style="width: 50px; height: 50px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.4rem; flex-shrink: 0; background: #e0f2fe; color: #0284c7;">
        <i class="fa-solid fa-file-lines"></i>
      </div>
      <div>
        <h3 style="font-size: 1.25rem; font-weight: 800; margin-bottom: 2px; color: var(--dark);">{{ $totalMaterialCount }} Modul</h3>
        <p style="font-size: 0.85rem; color: var(--muted); margin: 0;">File bahan ajar & dokumen</p>
      </div>
    </div>

    <div style="background: var(--card-bg); padding: 24px; border-radius: var(--radius); box-shadow: var(--shadow-md); border: 1px solid var(--border); display: flex; align-items: flex-start; gap: 16px;">
      <div style="width: 50px; height: 50px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.3rem; flex-shrink: 0; background: #f3e8ff; color: #9333ea;">
        <i class="fa-solid fa-book-open-reader"></i>
      </div>
      <div>
        <h3 style="font-size: 1.25rem; font-weight: 800; margin-bottom: 2px; color: var(--dark);">{{ count($availableSubjects) ?: 6 }} Mapel</h3>
        <p style="font-size: 0.85rem; color: var(--muted); margin: 0;">Kurikulum & silabus aktif</p>
      </div>
    </div>

    <div style="background: var(--card-bg); padding: 24px; border-radius: var(--radius); box-shadow: var(--shadow-md); border: 1px solid var(--border); display: flex; align-items: flex-start; gap: 16px;">
      <div style="width: 50px; height: 50px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.3rem; flex-shrink: 0; background: #dcfce7; color: #16a34a;">
        <i class="fa-solid fa-circle-check"></i>
      </div>
      <div>
        <h3 style="font-size: 1.25rem; font-weight: 800; margin-bottom: 2px; color: var(--dark);">Siswa Aktif</h3>
        <p style="font-size: 0.85rem; color: var(--muted); margin: 0;">Akses portal terverifikasi</p>
      </div>
    </div>

  </div>
</section>

<!-- ============================================================== -->
<!-- VIDEO PEMBELAJARAN & BAHAN AJAR DIGITAL SHOWCASE               -->
<!-- ============================================================== -->
<section id="media-pembelajaran" class="learning-media-section" style="padding: 85px 6% 60px; background: #ffffff; border-top: 1px solid var(--border); margin-top: 40px;">
  
  <div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 30px; flex-wrap: wrap; gap: 20px;">
    <div>
      <span style="color: var(--primary); font-weight: 700; font-size: 0.95rem; display: block; margin-bottom: 8px;">
        <i class="fa-solid fa-graduation-cap"></i> MEDIA PEMBELAJARAN DIGITAL SISWA
      </span>
      <h2 style="font-size: 2.2rem; font-weight: 800; color: var(--dark); margin: 0 0 8px 0;">
        Video Edukasi & Materi Pelajaran
      </h2>
      <p style="color: var(--muted); font-size: 1rem; margin: 0; max-width: 650px;">
        Materi dan video ini khusus untuk peserta didik terdaftar. Silakan tonton tayangan interaktif atau unduh materi rangkuman untuk belajar mandiri.
      </p>
    </div>

    <!-- Filter Tab Pills -->
    <div class="learning-filter-scroll" style="display: flex; gap: 10px; flex-wrap: wrap;">
      <a href="{{ route('siswa.beranda', array_merge(request()->query(), ['tab' => 'all'])) }}" style="padding: 10px 18px; border-radius: 10px; font-weight: 700; font-size: 0.88rem; text-decoration: none; {{ ($tab === 'all' || !$tab) ? 'background: var(--primary); color: #ffffff; box-shadow: 0 4px 12px rgba(37, 99, 235, 0.25);' : 'background: var(--light-bg); color: var(--dark); border: 1px solid var(--border);' }}">
        <i class="fa-solid fa-shapes"></i> Semua Media ({{ $totalCombinedCount }})
      </a>
      <a href="{{ route('siswa.beranda', array_merge(request()->query(), ['tab' => 'video'])) }}" style="padding: 10px 18px; border-radius: 10px; font-weight: 700; font-size: 0.88rem; text-decoration: none; {{ $tab === 'video' ? 'background: #dc2626; color: #ffffff; box-shadow: 0 4px 12px rgba(220, 38, 38, 0.25);' : 'background: #fee2e2; color: #dc2626; border: 1px solid #fecaca;' }}">
        <i class="fa-brands fa-youtube"></i> Video Edukasi ({{ $totalVideoCount }})
      </a>
      <a href="{{ route('siswa.beranda', array_merge(request()->query(), ['tab' => 'materi'])) }}" style="padding: 10px 18px; border-radius: 10px; font-weight: 700; font-size: 0.88rem; text-decoration: none; {{ $tab === 'materi' ? 'background: #0284c7; color: #ffffff; box-shadow: 0 4px 12px rgba(2, 132, 199, 0.25);' : 'background: #e0f2fe; color: #0284c7; border: 1px solid #bae6fd;' }}">
        <i class="fa-solid fa-file-arrow-down"></i> File Materi ({{ $totalMaterialCount }})
      </a>
    </div>
  </div>

  <!-- Filter & Search Controls Bar -->
  <div style="background: var(--light-bg); padding: 18px 20px; border-radius: 14px; margin-bottom: 35px; border: 1px solid var(--border);">
    <form method="GET" action="{{ route('siswa.beranda') }}" style="display: flex; gap: 12px; flex-wrap: wrap; align-items: center;">
      <input type="hidden" name="tab" value="{{ $tab }}">

      <!-- Class Filter Dropdown -->
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
      <div style="position: relative; flex: 1; min-width: 200px;">
        <i class="fa-solid fa-magnifying-glass" style="position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: #94a3b8; font-size: 0.9rem;"></i>
        <input type="text" name="search" value="{{ $search }}" placeholder="Cari topik pembelajaran, judul modul, atau mapel..." style="width: 100%; box-sizing: border-box; padding: 10px 14px 10px 38px; border: 1px solid var(--border); border-radius: 10px; font-size: 0.9rem; outline: none; background: #ffffff;">
      </div>

      <!-- Action Button -->
      <button type="submit" style="background: var(--primary); color: #ffffff; border: none; padding: 10px 20px; border-radius: 10px; font-weight: 700; font-size: 0.9rem; cursor: pointer; display: inline-flex; align-items: center; gap: 8px;">
        <i class="fa-solid fa-filter"></i> Terapkan
      </button>

      @if($search || ($classLevel && $classLevel !== 'Semua Kelas'))
      <a href="{{ route('siswa.beranda', ['tab' => $tab]) }}" style="background: #ffffff; color: #64748b; border: 1px solid var(--border); padding: 10px 16px; border-radius: 10px; font-weight: 600; font-size: 0.85rem; text-decoration: none; display: inline-flex; align-items: center; gap: 6px;">
        <i class="fa-solid fa-rotate-left"></i> Reset Filter
      </a>
      @endif
    </form>
  </div>

  <!-- Showcase Cards Grid -->
  <div class="learning-showcase-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 24px;">
    
    <!-- Render Videos -->
    @foreach($videos as $video)
    <div style="background: #ffffff; border: 1px solid var(--border); border-radius: 14px; overflow: hidden; box-shadow: var(--shadow-sm); display: flex; flex-direction: column; justify-content: space-between; transition: transform 0.2s, box-shadow 0.2s;" onmouseover="this.style.transform='translateY(-3px)'; this.style.boxShadow='var(--shadow-md)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='var(--shadow-sm)';">
      <div>
        <div style="position: relative; height: 165px; background: #0f172a; overflow: hidden;">
          @if($video->thumbnail_url)
            <img src="{{ $video->thumbnail_url }}" alt="{{ $video->title }}" style="width: 100%; height: 100%; object-fit: cover;" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
            <div style="display: none; width: 100%; height: 100%; background: linear-gradient(135deg, {{ $video->is_drive ? '#0369a1, #0284c7' : '#991b1b, #ef4444' }}); align-items: center; justify-content: center; flex-direction: column; color: white;">
              <i class="{{ $video->source_badge['icon'] }}" style="font-size: 2.5rem; margin-bottom: 6px;"></i>
              <span style="font-size: 0.8rem; font-weight: 700;">{{ $video->source_badge['label'] }}</span>
            </div>
          @else
            <div style="width: 100%; height: 100%; background: linear-gradient(135deg, {{ $video->is_drive ? '#0284c7, #38bdf8' : '#dc2626, #f87171' }}); display: flex; align-items: center; justify-content: center; flex-direction: column; color: white;">
              <i class="{{ $video->source_badge['icon'] }}" style="font-size: 2.5rem; margin-bottom: 6px;"></i>
              <span style="font-size: 0.8rem; font-weight: 700;">{{ $video->source_badge['label'] }}</span>
            </div>
          @endif

          <!-- Play button overlay -->
          <div style="position: absolute; inset: 0; background: rgba(0,0,0,0.3); display: flex; align-items: center; justify-content: center;">
            <button type="button" onclick="playStudentVideo('{{ addslashes($video->title) }}', '{{ $video->embed_url }}', '{{ $video->subject }}', '{{ $video->class_level }}', '{{ $video->source_badge['label'] }}')" style="width: 48px; height: 48px; border-radius: 50%; background: rgba(255,255,255,0.95); border: none; color: {{ $video->is_drive ? '#0284c7' : '#dc2626' }}; display: flex; align-items: center; justify-content: center; font-size: 1.25rem; cursor: pointer; box-shadow: 0 4px 14px rgba(0,0,0,0.35); transition: transform 0.2s;" onmouseover="this.style.transform='scale(1.1)'" onmouseout="this.style.transform='scale(1)'" title="Putar Video">
              <i class="fa-solid fa-play" style="margin-left: 2px;"></i>
            </button>
          </div>

          <!-- Platform Badge -->
          <span style="position: absolute; top: 8px; right: 8px; background: {{ $video->is_drive ? 'rgba(2, 132, 199, 0.92)' : 'rgba(220, 38, 38, 0.92)' }}; color: #ffffff; padding: 2px 7px; border-radius: 5px; font-size: 0.7rem; font-weight: 700;">
            <i class="{{ $video->source_badge['icon'] }}"></i> {{ $video->source_badge['label'] }}
          </span>

          <!-- Duration Badge -->
          <span style="position: absolute; bottom: 8px; right: 8px; background: rgba(15, 23, 42, 0.85); color: #ffffff; padding: 2px 6px; border-radius: 4px; font-size: 0.7rem; font-weight: 700;">
            <i class="fa-regular fa-clock" style="font-size: 0.65rem;"></i> {{ $video->duration }}
          </span>
        </div>

        <div style="padding: 16px;">
          <div style="display: flex; gap: 6px; margin-bottom: 6px; flex-wrap: wrap;">
            <span style="background: #e0f2fe; color: #0369a1; padding: 2px 8px; border-radius: 10px; font-size: 0.72rem; font-weight: 700;">
              {{ $video->class_level }}
            </span>
            <span style="background: #f1f5f9; color: #475569; padding: 2px 8px; border-radius: 10px; font-size: 0.72rem; font-weight: 700;">
              {{ $video->subject }}
            </span>
          </div>
          <h4 style="font-size: 0.98rem; font-weight: 700; color: var(--dark); margin: 0 0 6px 0; line-height: 1.4; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; min-height: 2.8em;">
            {{ $video->title }}
          </h4>
          <p style="font-size: 0.82rem; color: var(--muted); margin: 0; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
            {{ $video->description ?: 'Video materi pembelajaran interaktif persembahan bapak/ibu guru.' }}
          </p>
        </div>
      </div>

      <div style="padding: 12px 16px; background: var(--light-bg); border-top: 1px solid var(--border); display: flex; justify-content: space-between; align-items: center;">
        <span style="font-size: 0.75rem; color: var(--muted);">
          <i class="fa-solid fa-chalkboard-user"></i> {{ $video->user ? $video->user->name : 'Guru SD' }}
        </span>
        <button type="button" onclick="playStudentVideo('{{ addslashes($video->title) }}', '{{ $video->embed_url }}', '{{ $video->subject }}', '{{ $video->class_level }}', '{{ $video->source_badge['label'] }}')" style="background: var(--primary); color: #fff; border: none; padding: 6px 12px; font-size: 0.78rem; font-weight: 700; border-radius: 6px; cursor: pointer; display: inline-flex; align-items: center; gap: 4px;">
          <i class="fa-solid fa-play" style="font-size: 0.7rem;"></i> Tonton Sekarang
        </button>
      </div>
    </div>
    @endforeach

    <!-- Render Materials -->
    @foreach($materials as $material)
    <div style="background: #ffffff; border: 1px solid var(--border); border-radius: 14px; padding: 20px; box-shadow: var(--shadow-sm); display: flex; flex-direction: column; justify-content: space-between; transition: transform 0.2s, box-shadow 0.2s;" onmouseover="this.style.transform='translateY(-3px)'; this.style.boxShadow='var(--shadow-md)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='var(--shadow-sm)';">
      <div>
        <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 12px;">
          <div style="width: 44px; height: 44px; border-radius: 10px; background: {{ $material->icon_color }}15; color: {{ $material->icon_color }}; display: flex; align-items: center; justify-content: center; font-size: 1.35rem;">
            <i class="{{ $material->icon }}"></i>
          </div>
          <span style="background: #f1f5f9; color: #475569; padding: 3px 8px; border-radius: 15px; font-size: 0.72rem; font-weight: 700;">
            {{ $material->file_size ?: 'Dokumen Digital' }}
          </span>
        </div>

        <div style="display: flex; gap: 6px; margin-bottom: 6px; flex-wrap: wrap;">
          <span style="background: #e0f2fe; color: #0369a1; padding: 2px 8px; border-radius: 10px; font-size: 0.72rem; font-weight: 700;">
            {{ $material->class_level }}
          </span>
          <span style="background: #f1f5f9; color: #475569; padding: 2px 8px; border-radius: 10px; font-size: 0.72rem; font-weight: 700;">
            {{ $material->subject }}
          </span>
        </div>

        <h4 style="font-size: 0.98rem; font-weight: 700; color: var(--dark); margin: 0 0 6px 0; line-height: 1.4; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; min-height: 2.8em;">
          {{ $material->title }}
        </h4>
        <p style="font-size: 0.82rem; color: var(--muted); margin: 0; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
          {{ $material->description ?: 'Bahan ajar materi mandiri untuk peserta didik.' }}
        </p>
      </div>

      <div style="border-top: 1px solid var(--border); padding-top: 12px; margin-top: 12px; display: flex; align-items: center; justify-content: space-between;">
        <span style="font-size: 0.75rem; color: var(--muted);">
          <i class="fa-solid fa-download"></i> {{ number_format($material->downloads, 0, ',', '.') }}x diunduh
        </span>
        <a href="{{ route('siswa.materi.download', $material->id) }}" style="padding: 6px 12px; font-size: 0.78rem; background: #0284c7; color: #fff; text-decoration: none; border-radius: 6px; font-weight: 700; display: inline-flex; align-items: center; gap: 4px;">
          <i class="fa-solid fa-cloud-arrow-down"></i> Unduh Modul
        </a>
      </div>
    </div>
    @endforeach

  </div>

  @if($videos->isEmpty() && $materials->isEmpty())
  <div style="text-align: center; padding: 45px 20px; background: var(--light-bg); border-radius: 14px; border: 1px dashed var(--border); margin-top: 20px;">
    <i class="fa-solid fa-folder-open" style="font-size: 3rem; color: #cbd5e1; margin-bottom: 12px;"></i>
    <h3 style="font-size: 1.15rem; font-weight: 700; color: var(--dark); margin-bottom: 6px;">Tidak Ada Media Pembelajaran Ditemukan</h3>
    <p style="color: var(--muted); font-size: 0.9rem; margin: 0 0 16px 0;">Coba ganti filter kelas atau kata kunci pencarian Anda.</p>
    <a href="{{ route('siswa.beranda') }}" style="display: inline-flex; align-items: center; gap: 6px; padding: 8px 18px; border-radius: 8px; background: var(--primary); color: #fff; text-decoration: none; font-weight: 700; font-size: 0.85rem;">
      <i class="fa-solid fa-rotate-left"></i> Tampilkan Semua
    </a>
  </div>
  @endif

</section>

<!-- Pesan Pembimbing / Panduan Belajar Siswa -->
<section class="principal-section" style="padding: 80px 6%; background: #ffffff;" id="panduan-belajar">
  <div class="principal-grid" style="display: grid; grid-template-columns: 0.8fr 1.2fr; gap: 50px; align-items: center;">
    <div style="position: relative; text-align: center;">
      <div style="width: 280px; height: 320px; background: linear-gradient(135deg, #1e40af, #3b82f6); border-radius: 24px; margin: 0 auto; display: flex; flex-direction: column; align-items: center; justify-content: center; color: white; box-shadow: var(--shadow-lg);">
        <i class="fa-solid fa-user-graduate" style="font-size: 5rem; margin-bottom: 10px;"></i>
        <span style="font-weight: 700; font-size: 1.1rem;">Belajar Mandiri</span>
        <span style="font-size: 0.8rem; opacity: 0.85; margin-top: 4px;">Generasi Berprestasi</span>
      </div>
    </div>
    <div>
      <span style="color: var(--primary); font-weight: 700; font-size: 1rem; margin-bottom: 16px; display: block;">
        <i class="fa-solid fa-lightbulb"></i> PANDUAN BELAJAR MANDIRI
      </span>
      <h2 style="font-size: 2.2rem; font-weight: 800; color: var(--dark); margin-bottom: 12px;">Raih Prestasi Terbaik dengan Belajar Teratur</h2>
      <p style="color: var(--muted); font-size: 1rem; line-height: 1.8; margin-bottom: 20px;">
        "Kunci keberhasilan belajar adalah konsistensi dan rasa ingin tahu. Manfaatkan video pembelajaran ini untuk mengulang penjelasan materi yang belum dipahami di kelas, serta pelajari modul latihan agar semakin menguasai topik bahasan."
      </p>
      <div style="font-size: 1.1rem; font-weight: 800; color: var(--dark);">Tim Dewan Guru {{ $settings['school_name'] ?? 'SD Negeri Lama' }}</div>
      <div style="font-size: 0.85rem; color: var(--muted);">Pendampingan Belajar Digital Peserta Didik</div>
    </div>
  </div>
</section>

<!-- Pusat Informasi & Pengumuman Siswa -->
<section class="information-section" style="padding: 80px 6%;" id="pengumuman-siswa">
  <div style="text-align: center; margin-bottom: 45px;">
    <h2 style="font-size: 2.2rem; font-weight: 800; color: var(--dark); margin-bottom: 8px;">Pusat Informasi & Pengumuman Siswa</h2>
    <p style="color: var(--muted); font-size: 1rem;">Informasi agenda sekolah, jadwal belajar, dan pengumuman terbaru untuk peserta didik</p>
  </div>

  <div class="information-grid" style="display: grid; grid-template-columns: 2fr 1fr; gap: 30px;">
    <!-- Main Column: Announcements -->
    <div>
      <div class="announcement-panel" style="background: var(--card-bg); border-radius: var(--radius); padding: 28px; border: 1px solid var(--border); box-shadow: var(--shadow-sm);">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; padding-bottom: 12px; border-bottom: 2px solid var(--light-bg);">
          <h3 style="font-size: 1.2rem; font-weight: 700; display: flex; align-items: center; gap: 10px; color: var(--dark);">
            <i class="fa-solid fa-bullhorn" style="color: var(--primary);"></i> Pengumuman Sekolah Terbaru
          </h3>
          <a href="{{ route('pengumuman.index') }}" style="font-size: 0.85rem; font-weight: 700; color: var(--primary); text-decoration: none;">Lihat Semua <i class="fa-solid fa-arrow-right"></i></a>
        </div>

        <div style="display: flex; flex-direction: column; gap: 16px;">
          @forelse($announcements as $announcement)
          <div class="announcement-item" style="display: flex; gap: 16px; padding: 16px; border-radius: 12px; background: var(--light-bg);">
            <div style="background: var(--primary); color: #fff; border-radius: 10px; padding: 10px 14px; text-align: center; min-width: 65px; display: flex; flex-direction: column; justify-content: center; flex-shrink: 0;">
              <span style="font-size: 1.3rem; font-weight: 800; line-height: 1;">{{ $announcement->published_at ? $announcement->published_at->format('d') : date('d') }}</span>
              <span style="font-size: 0.7rem; text-transform: uppercase; font-weight: 700;">{{ $announcement->published_at ? $announcement->published_at->format('M') : date('M') }}</span>
            </div>
            <div>
              <h4 style="font-size: 1rem; font-weight: 700; margin-bottom: 4px; color: var(--dark);">
                <a href="{{ route('pengumuman.show', $announcement->slug) }}" style="text-decoration: none; color: inherit;">{{ $announcement->title }}</a>
              </h4>
              <p style="font-size: 0.85rem; color: var(--muted); line-height: 1.5; margin: 0;">{{ Str::limit($announcement->content, 120) }}</p>
            </div>
          </div>
          @empty
          <p style="color: var(--muted); font-size: 0.9rem;">Belum ada pengumuman terbaru.</p>
          @endforelse
        </div>
      </div>
    </div>

    <!-- Sidebar Column: Quick Access -->
    <div>
      <div class="quick-access-panel" style="background: var(--card-bg); border-radius: var(--radius); padding: 28px; border: 1px solid var(--border); box-shadow: var(--shadow-sm);">
        <div style="margin-bottom: 24px; padding-bottom: 12px; border-bottom: 2px solid var(--light-bg);">
          <h3 style="font-size: 1.2rem; font-weight: 700; display: flex; align-items: center; gap: 10px; color: var(--dark);">
            <i class="fa-solid fa-compass" style="color: var(--primary);"></i> Navigasi Siswa
          </h3>
        </div>
        <div style="display: flex; flex-direction: column; gap: 12px;">
          <a href="{{ route('akademik') }}" style="display: flex; align-items: center; justify-content: space-between; padding: 14px 18px; background: var(--light-bg); border-radius: 12px; font-weight: 600; font-size: 0.9rem; color: var(--dark); text-decoration: none;">
            <span><i class="fa-solid fa-calendar-days" style="color: var(--primary); width: 20px;"></i> Kurikulum & Ekskul</span>
            <i class="fa-solid fa-chevron-right" style="font-size: 0.8rem; opacity: 0.5;"></i>
          </a>
          <a href="{{ route('fasilitas') }}" style="display: flex; align-items: center; justify-content: space-between; padding: 14px 18px; background: var(--light-bg); border-radius: 12px; font-weight: 600; font-size: 0.9rem; color: var(--dark); text-decoration: none;">
            <span><i class="fa-solid fa-laptop-code" style="color: var(--primary); width: 20px;"></i> Laboratorium & Fasilitas</span>
            <i class="fa-solid fa-chevron-right" style="font-size: 0.8rem; opacity: 0.5;"></i>
          </a>
          <a href="{{ route('profil') }}" style="display: flex; align-items: center; justify-content: space-between; padding: 14px 18px; background: var(--light-bg); border-radius: 12px; font-weight: 600; font-size: 0.9rem; color: var(--dark); text-decoration: none;">
            <span><i class="fa-solid fa-school" style="color: var(--primary); width: 20px;"></i> Profil Sekolah</span>
            <i class="fa-solid fa-chevron-right" style="font-size: 0.8rem; opacity: 0.5;"></i>
          </a>
          <a href="{{ route('kontak') }}" style="display: flex; align-items: center; justify-content: space-between; padding: 14px 18px; background: var(--light-bg); border-radius: 12px; font-weight: 600; font-size: 0.9rem; color: var(--dark); text-decoration: none;">
            <span><i class="fa-solid fa-phone" style="color: var(--primary); width: 20px;"></i> Hubungi Guru / Sekolah</span>
            <i class="fa-solid fa-chevron-right" style="font-size: 0.8rem; opacity: 0.5;"></i>
          </a>
          <form action="{{ route('logout') }}" method="POST" style="margin-top: 6px;">
            @csrf
            <button type="submit" style="width: 100%; display: flex; align-items: center; justify-content: center; gap: 8px; padding: 12px; background: #fee2e2; color: #dc2626; border: 1px solid #fecaca; border-radius: 10px; font-weight: 700; font-size: 0.88rem; cursor: pointer;">
              <i class="fa-solid fa-right-from-bracket"></i> Keluar Portal Siswa
            </button>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ============================================================== -->
<!-- POPUP MODAL PEMUTAR VIDEO EDUKASI SISWA                        -->
<!-- ============================================================== -->
<div id="modalStudentVideo" style="display: none; position: fixed; inset: 0; background: rgba(15, 23, 42, 0.82); backdrop-filter: blur(4px); z-index: 9999; align-items: center; justify-content: center; padding: 20px;">
  <div style="background: #ffffff; width: 100%; max-width: 820px; border-radius: 18px; overflow: hidden; box-shadow: 0 25px 50px -12px rgba(0,0,0,0.5); display: flex; flex-direction: column;">
    
    <!-- Modal Header -->
    <div style="padding: 16px 20px; background: #ffffff; border-bottom: 1px solid var(--border); display: flex; justify-content: space-between; align-items: center;">
      <h3 id="modalStudentVideoTitle" style="font-size: 1.05rem; font-weight: 800; color: var(--dark); margin: 0; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 90%;">
        Judul Video Pembelajaran
      </h3>
      <button type="button" onclick="closeStudentVideo()" style="background: transparent; border: none; font-size: 1.25rem; color: #64748b; cursor: pointer; padding: 4px;" title="Tutup">
        <i class="fa-solid fa-xmark"></i>
      </button>
    </div>

    <!-- Modal Video Player Container (16:9 Aspect Ratio) -->
    <div style="position: relative; width: 100%; aspect-ratio: 16/9; background: #000000;">
      <iframe id="modalStudentVideoIframe" src="" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; border: 0;" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
    </div>

    <!-- Modal Footer with Meta info -->
    <div style="padding: 14px 20px; background: #f8fafc; border-top: 1px solid var(--border); display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 10px;">
      <div style="display: flex; align-items: center; gap: 8px;">
        <span id="modalStudentVideoSubject" style="background: #e0f2fe; color: #0369a1; padding: 3px 10px; border-radius: 12px; font-size: 0.75rem; font-weight: 700;">
          Mapel
        </span>
        <span id="modalStudentVideoClass" style="background: #f1f5f9; color: #475569; padding: 3px 10px; border-radius: 12px; font-size: 0.75rem; font-weight: 700;">
          Kelas
        </span>
        <span id="modalStudentVideoPlatform" style="font-size: 0.75rem; color: #94a3b8; font-weight: 600;">
          Platform
        </span>
      </div>

      <button type="button" onclick="closeStudentVideo()" style="background: #e2e8f0; color: #334155; border: none; padding: 6px 14px; border-radius: 8px; font-weight: 700; font-size: 0.82rem; cursor: pointer;">
        Tutup Pemutar
      </button>
    </div>
  </div>
</div>

<script>
  function playStudentVideo(title, embedUrl, subject, classLevel, platform) {
    const modal = document.getElementById('modalStudentVideo');
    const iframe = document.getElementById('modalStudentVideoIframe');
    const titleEl = document.getElementById('modalStudentVideoTitle');
    const subjectEl = document.getElementById('modalStudentVideoSubject');
    const classEl = document.getElementById('modalStudentVideoClass');
    const platformEl = document.getElementById('modalStudentVideoPlatform');

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

  function closeStudentVideo() {
    const modal = document.getElementById('modalStudentVideo');
    const iframe = document.getElementById('modalStudentVideoIframe');
    if (modal) modal.style.display = 'none';
    if (iframe) iframe.src = '';
  }

  // Close modal when clicking outside
  window.addEventListener('click', function(e) {
    const modal = document.getElementById('modalStudentVideo');
    if (e.target === modal) {
      closeStudentVideo();
    }
  });

  // Close modal on Escape key
  document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
      closeStudentVideo();
    }
  });
</script>
@endsection
