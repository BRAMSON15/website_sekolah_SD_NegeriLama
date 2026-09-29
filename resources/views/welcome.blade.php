@extends('layouts.app')

@section('title', $settings['school_name'] ?? 'SD Negeri Lama - Modern & Berkarakter')

@section('content')
<!-- Hero Section -->
<section class="hero home-hero" style="position: relative; padding: 90px 6% 120px; background-image: url('{{ asset('mentahan2/img/image1.png') }}'); background-size: cover; background-position: center; background-repeat: no-repeat; display: grid; grid-template-columns: 1.2fr 0.8fr; align-items: center; gap: 40px; overflow: hidden;">
  <!-- Dark Dimming Overlay -->
  <div class="hero-overlay" style="position: absolute; inset: 0; background: linear-gradient(105deg, rgba(11, 23, 44, 0.75) 0%, rgba(16, 37, 74, 0.62) 55%, rgba(11, 23, 44, 0.48) 100%); pointer-events: none; z-index: 1;"></div>

  <div class="hero-content" style="position: relative; z-index: 2;">
    <!-- <div class="hero-badge" style="display: inline-flex; align-items: center; gap: 8px; background: rgb(255, 255, 255); color: var(--primary); padding: 6px 16px; border-radius: 30px; font-size: 0.85rem; font-weight: 700; margin-bottom: 20px; border: 1px solid rgba(59, 130, 246, 0.2);">
      <i class="fa-solid fa-award"></i> {{ $settings['hero_badge'] ?? 'Sekolah Penggerak & Akreditasi A' }}
    </div> -->
    <h1 style="font-size: clamp(1.75rem, 5.5vw, 3.2rem); line-height: 1.2; font-weight: 800; color: #ffffff; margin-bottom: 18px; letter-spacing: -0.5px; text-shadow: 0 2px 8px rgba(15, 23, 42, 0.55);">
      {!! $settings['hero_title'] ?? 'Mewujudkan Generasi <span>Cerdas, Kreatif & Berkarakter</span>' !!}
    </h1>
    <p style="font-size: clamp(0.92rem, 2.5vw, 1.1rem); color: #ffffff; margin-bottom: 28px; max-width: 580px; text-shadow: 0 2px 6px rgba(15, 23, 42, 0.55); line-height: 1.6;">
      {{ $settings['hero_description'] ?? 'Selamat datang di portal resmi SD Negeri Lama.' }}
    </p>
    <div class="hero-buttons" style="display: flex; gap: 16px; flex-wrap: wrap;">
      <a href="{{ route('ppdb') }}" class="btn-login" style="padding: 14px 28px; font-size: 1rem; border-radius: 12px;">
        <i class="fa-solid fa-user-plus"></i> Informasi PPDB
      </a>
      <a href="{{ route('profil') }}" style="background: #ffffff; color: var(--primary); border: 2px solid var(--border); padding: 14px 28px; border-radius: 12px; font-weight: 700; display: inline-flex; align-items: center; gap: 10px;">
        <i class="fa-solid fa-circle-info"></i> Jelajahi Profil
      </a>
    </div>
  </div>
</section>

<!-- Quick Features Bar -->
<section class="home-features" style="margin-top: -60px; padding: 0 6%; position: relative; z-index: 10;">
  <div class="features-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 20px;">
    @forelse($features as $feature)
    <div style="background: var(--card-bg); padding: 24px; border-radius: var(--radius); box-shadow: var(--shadow-md); border: 1px solid var(--border); display: flex; align-items: flex-start; gap: 16px;">
      <div style="width: 50px; height: 50px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.3rem; flex-shrink: 0;" class="{{ $feature->icon_color_class }}">
        <i class="{{ $feature->icon }}"></i>
      </div>
      <div>
        <h3 style="font-size: 1.05rem; font-weight: 700; margin-bottom: 4px; color: var(--dark);">{{ $feature->title }}</h3>
        <p style="font-size: 0.85rem; color: var(--muted);">{{ $feature->description }}</p>
      </div>
    </div>
    @empty
    <div style="background: var(--card-bg); padding: 24px; border-radius: var(--radius); box-shadow: var(--shadow-md); border: 1px solid var(--border); display: flex; align-items: flex-start; gap: 16px;">
      <div style="width: 50px; height: 50px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.3rem; flex-shrink: 0;" class="icon-blue">
        <i class="fa-solid fa-laptop-code"></i>
      </div>
      <div>
        <h3 style="font-size: 1.05rem; font-weight: 700; margin-bottom: 4px; color: var(--dark);">Kelas Digital</h3>
        <p style="font-size: 0.85rem; color: var(--muted);">Pembelajaran interaktif berbasis teknologi modern.</p>
      </div>
    </div>
    @endforelse
  </div>
</section>

<!-- Sambutan Kepala Sekolah -->
<section class="principal-section" style="padding: 90px 6%; background: #ffffff;" id="profil">
  <div class="principal-grid" style="display: grid; grid-template-columns: 0.8fr 1.2fr; gap: 50px; align-items: center;">
    <div style="position: relative; text-align: center;">
      <div style="width: 280px; height: 320px; background: linear-gradient(135deg, #1e40af, #3b82f6); border-radius: 24px; margin: 0 auto; display: flex; flex-direction: column; align-items: center; justify-content: center; color: white; box-shadow: var(--shadow-lg);">
        <i class="fa-solid fa-user-tie" style="font-size: 5rem; margin-bottom: 10px;"></i>
        <span style="font-weight: 700;">Kepala Sekolah</span>
      </div>
    </div>
    <div>
      <span style="color: var(--primary); font-weight: 700; font-size: 1rem; margin-bottom: 20px; display: block;">
        <i class="fa-solid fa-quote-left"></i> SAMBUTAN KEPALA SEKOLAH
      </span>
      <h2 style="font-size: 2.2rem; font-weight: 800; color: var(--dark); margin-bottom: 10px;">Membimbing dengan Hati, Mendidik dengan Prestasi</h2>
      <p style="color: var(--muted); font-size: 1rem; line-height: 1.8; margin-bottom: 24px;">
        "{{ $settings['principal_message'] ?? 'Selamat datang di SD Negeri Lama.' }}"
      </p>
      <div style="font-size: 1.1rem; font-weight: 800; color: var(--dark);">{{ $settings['principal_name'] ?? 'Drs. H. Ahmad Dahlan, M.Pd.' }}</div>
      <div style="font-size: 0.85rem; color: var(--muted);">{{ $settings['principal_title'] ?? 'Kepala Sekolah SD Negeri Lama' }}</div>
    </div>
  </div>
</section>

<!-- Main Content Grid -->
<section class="information-section" style="padding: 80px 6%;" id="akademik">
  <div style="text-align: center; margin-bottom: 50px;">
    <h2 style="font-size: 2.2rem; font-weight: 800; color: var(--dark); margin-bottom: 10px;">Pusat Informasi & Layanan</h2>
    <p style="color: var(--muted); font-size: 1rem;">Akses cepat informasi pengumuman, agenda kegiatan, dan portal akademik</p>
  </div>

  <div class="information-grid" style="display: grid; grid-template-columns: 2fr 1fr; gap: 30px;">
    <!-- Main Column -->
    <div>
      <!-- Announcements -->
      <div class="announcement-panel" style="background: var(--card-bg); border-radius: var(--radius); padding: 28px; border: 1px solid var(--border); box-shadow: var(--shadow-sm); margin-bottom: 30px;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; padding-bottom: 12px; border-bottom: 2px solid var(--light-bg);">
          <h3 style="font-size: 1.2rem; font-weight: 700; display: flex; align-items: center; gap: 10px; color: var(--dark);">
            <i class="fa-solid fa-bullhorn" style="color: var(--primary);"></i> Pengumuman Terbaru
          </h3>
          <a href="{{ route('pengumuman.index') }}" style="font-size: 0.85rem; font-weight: 700; color: var(--primary);">Lihat Semua <i class="fa-solid fa-arrow-right"></i></a>
        </div>

        <div style="display: flex; flex-direction: column; gap: 16px;">
          @forelse($announcements as $announcement)
          <div class="announcement-item" style="display: flex; gap: 16px; padding: 16px; border-radius: 12px; background: var(--light-bg);">
            <div style="background: var(--primary); color: #fff; border-radius: 10px; padding: 10px 14px; text-align: center; min-width: 65px; display: flex; flex-direction: column; justify-content: center;">
              <span style="font-size: 1.3rem; font-weight: 800; line-height: 1;">{{ $announcement->published_at ? $announcement->published_at->format('d') : date('d') }}</span>
              <span style="font-size: 0.7rem; text-transform: uppercase; font-weight: 700;">{{ $announcement->published_at ? $announcement->published_at->format('M') : date('M') }}</span>
            </div>
            <div>
              <h4 style="font-size: 1rem; font-weight: 700; margin-bottom: 4px; color: var(--dark);">
                <a href="{{ route('pengumuman.show', $announcement->slug) }}">{{ $announcement->title }}</a>
              </h4>
              <p style="font-size: 0.85rem; color: var(--muted); line-height: 1.5;">{{ Str::limit($announcement->content, 120) }}</p>
            </div>
          </div>
          @empty
          <p style="color: var(--muted); font-size: 0.9rem;">Belum ada pengumuman terbaru.</p>
          @endforelse
        </div>
      </div>
    </div>

    <!-- Sidebar Column -->
    <div>
      <div class="quick-access-panel" style="background: var(--card-bg); border-radius: var(--radius); padding: 28px; border: 1px solid var(--border); box-shadow: var(--shadow-sm);">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; padding-bottom: 12px; border-bottom: 2px solid var(--light-bg);">
          <h3 style="font-size: 1.2rem; font-weight: 700; display: flex; align-items: center; gap: 10px; color: var(--dark);">
            <i class="fa-solid fa-compass" style="color: var(--primary);"></i> Akses Cepat
          </h3>
        </div>
        <div style="display: flex; flex-direction: column; gap: 12px;">
          <a href="{{ route('akademik') }}" style="display: flex; align-items: center; justify-content: space-between; padding: 14px 18px; background: var(--light-bg); border-radius: 12px; font-weight: 600; font-size: 0.9rem; color: var(--dark);">
            <span><i class="fa-solid fa-calendar-days" style="color: var(--primary); width: 20px;"></i> Jadwal Pelajaran</span>
            <i class="fa-solid fa-chevron-right" style="font-size: 0.8rem; opacity: 0.5;"></i>
          </a>
          <a href="#" style="display: flex; align-items: center; justify-content: space-between; padding: 14px 18px; background: var(--light-bg); border-radius: 12px; font-weight: 600; font-size: 0.9rem; color: var(--dark);">
            <span><i class="fa-solid fa-clipboard-user" style="color: var(--primary); width: 20px;"></i> Presensi Online</span>
            <i class="fa-solid fa-chevron-right" style="font-size: 0.8rem; opacity: 0.5;"></i>
          </a>
          <a href="#" style="display: flex; align-items: center; justify-content: space-between; padding: 14px 18px; background: var(--light-bg); border-radius: 12px; font-weight: 600; font-size: 0.9rem; color: var(--dark);">
            <span><i class="fa-solid fa-file-invoice" style="color: var(--primary); width: 20px;"></i> E-Rapor Digital</span>
            <i class="fa-solid fa-chevron-right" style="font-size: 0.8rem; opacity: 0.5;"></i>
          </a>
          <a href="{{ route('fasilitas') }}" style="display: flex; align-items: center; justify-content: space-between; padding: 14px 18px; background: var(--light-bg); border-radius: 12px; font-weight: 600; font-size: 0.9rem; color: var(--dark);">
            <span><i class="fa-solid fa-book-reader" style="color: var(--primary); width: 20px;"></i> Perpustakaan Digital</span>
            <i class="fa-solid fa-chevron-right" style="font-size: 0.8rem; opacity: 0.5;"></i>
          </a>
          <a href="{{ route('ppdb') }}" style="display: flex; align-items: center; justify-content: space-between; padding: 14px 18px; background: var(--light-bg); border-radius: 12px; font-weight: 600; font-size: 0.9rem; color: var(--dark);">
            <span><i class="fa-solid fa-money-bill-wave" style="color: var(--primary); width: 20px;"></i> Informasi SPP / PPDB</span>
            <i class="fa-solid fa-chevron-right" style="font-size: 0.8rem; opacity: 0.5;"></i>
          </a>
        </div>
      </div>
    </div>
  </div>
</section>

@if((isset($featuredVideos) && $featuredVideos->isNotEmpty()) || (isset($featuredMaterials) && $featuredMaterials->isNotEmpty()))
<!-- ============================================================== -->
<!-- VIDEO PEMBELAJARAN & BAHAN AJAR DIGITAL SHOWCASE               -->
<!-- ============================================================== -->
<section class="learning-media-section" style="padding: 80px 6%; background: #ffffff; border-top: 1px solid var(--border);">
  <div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 40px; flex-wrap: wrap; gap: 20px;">
    <div>
      <span style="color: var(--primary); font-weight: 700; font-size: 0.95rem; display: block; margin-bottom: 8px;">
        <i class="fa-solid fa-graduation-cap"></i> MEDIA PEMBELAJARAN DIGITAL
      </span>
      <h2 style="font-size: 2.2rem; font-weight: 800; color: var(--dark); margin: 0 0 8px 0;">
        Video Edukasi & Materi Pelajaran
      </h2>
      <p style="color: var(--muted); font-size: 1rem; margin: 0; max-width: 600px;">
        Materi pembelajaran interaktif dan modul ajar persembahan bapak/ibu guru untuk menunjang kegiatan belajar mandiri peserta didik.
      </p>
    </div>

    <div class="learning-filter-scroll" style="display: flex; gap: 10px; flex-wrap: wrap;">
      <a href="{{ route('akademik', ['tab' => 'all']) }}" style="padding: 10px 18px; border-radius: 10px; font-weight: 700; font-size: 0.88rem; text-decoration: none; background: var(--light-bg); color: var(--dark); border: 1px solid var(--border);">
        <i class="fa-solid fa-shapes"></i> Semua Media
      </a>
      <a href="{{ route('akademik', ['tab' => 'video']) }}" style="padding: 10px 18px; border-radius: 10px; font-weight: 700; font-size: 0.88rem; text-decoration: none; background: #fee2e2; color: #dc2626; border: 1px solid #fecaca;">
        <i class="fa-brands fa-youtube"></i> Video Edukasi
      </a>
      <a href="{{ route('akademik', ['tab' => 'materi']) }}" style="padding: 10px 18px; border-radius: 10px; font-weight: 700; font-size: 0.88rem; text-decoration: none; background: #e0f2fe; color: #0284c7; border: 1px solid #bae6fd;">
        <i class="fa-solid fa-file-arrow-down"></i> File Materi
      </a>
      <a href="{{ route('akademik') }}" class="btn-login" style="padding: 10px 20px; font-size: 0.88rem; border-radius: 10px;">
        Lihat Semua <i class="fa-solid fa-arrow-right"></i>
      </a>
    </div>
  </div>


  <div class="learning-showcase-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 24px;">
    
    @foreach($featuredVideos as $video)
    <div style="background: #ffffff; border: 1px solid var(--border); border-radius: 14px; overflow: hidden; box-shadow: var(--shadow-sm); display: flex; flex-direction: column; justify-content: space-between;">
      <div>
        <div style="position: relative; height: 160px; background: #0f172a; overflow: hidden;">
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

          <span style="position: absolute; top: 8px; right: 8px; background: {{ $video->is_drive ? 'rgba(2, 132, 199, 0.92)' : 'rgba(220, 38, 38, 0.92)' }}; color: #ffffff; padding: 2px 7px; border-radius: 5px; font-size: 0.7rem; font-weight: 700;">
            <i class="{{ $video->source_badge['icon'] }}"></i> {{ $video->source_badge['label'] }}
          </span>

          <span style="position: absolute; bottom: 8px; right: 8px; background: rgba(15, 23, 42, 0.85); color: #ffffff; padding: 2px 6px; border-radius: 4px; font-size: 0.7rem; font-weight: 700;">
            {{ $video->duration }}
          </span>
        </div>

        <div style="padding: 16px;">
          <div style="display: flex; gap: 6px; margin-bottom: 6px;">
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
            {{ $video->description ?: 'Video materi pembelajaran interaktif.' }}
          </p>
        </div>
      </div>

      <div style="padding: 12px 16px; background: var(--light-bg); border-top: 1px solid var(--border); display: flex; justify-content: space-between; align-items: center;">
        <span style="font-size: 0.75rem; color: var(--muted);">
          <i class="fa-regular fa-eye"></i> {{ number_format($video->views_count, 0, ',', '.') }} tayangan
        </span>
        <a href="{{ route('akademik', ['tab' => 'video', 'search' => $video->title]) }}" style="font-size: 0.8rem; font-weight: 700; color: var(--primary); text-decoration: none;">
          Tonton di Akademik <i class="fa-solid fa-play" style="font-size: 0.7rem;"></i>
        </a>
      </div>
    </div>
    @endforeach

   
    @foreach($featuredMaterials as $material)
    <div style="background: #ffffff; border: 1px solid var(--border); border-radius: 14px; padding: 20px; box-shadow: var(--shadow-sm); display: flex; flex-direction: column; justify-content: space-between;">
      <div>
        <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 12px;">
          <div style="width: 42px; height: 42px; border-radius: 10px; background: {{ $material->icon_color }}15; color: {{ $material->icon_color }}; display: flex; align-items: center; justify-content: center; font-size: 1.3rem;">
            <i class="{{ $material->icon }}"></i>
          </div>
          <span style="background: #f1f5f9; color: #475569; padding: 3px 8px; border-radius: 15px; font-size: 0.72rem; font-weight: 700;">
            {{ $material->file_size ?: 'Dokumen Digital' }}
          </span>
        </div>

        <div style="display: flex; gap: 6px; margin-bottom: 6px;">
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
        <a href="{{ route('materi.download', $material->id) }}" style="padding: 6px 12px; font-size: 0.78rem; background: #0284c7; color: #fff; text-decoration: none; border-radius: 6px; font-weight: 700; display: inline-flex; align-items: center; gap: 4px;">
          <i class="fa-solid fa-cloud-arrow-down"></i> Unduh
        </a>
      </div>
    </div>
    @endforeach
  </div>
</section>
@endif
@endsection