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
    <h1 style="font-size: clamp(2.5rem, 4vw, 3.5rem); line-height: 1.15; font-weight: 800; color: #ffffff; margin-bottom: 20px; letter-spacing: -1px; text-shadow: 0 2px 8px rgba(15, 23, 42, 0.55);">
      {!! $settings['hero_title'] ?? 'Mewujudkan Generasi <span>Cerdas, Kreatif & Berkarakter</span>' !!}
    </h1>
    <p style="font-size: 1.1rem; color: #ffffff; margin-bottom: 32px; max-width: 580px; text-shadow: 0 2px 6px rgba(15, 23, 42, 0.55);">
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
@endsection