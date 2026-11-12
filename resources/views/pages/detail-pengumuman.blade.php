@extends('layouts.app')

@section('title', $announcement->title . ' - ' . ($settings['school_name'] ?? 'SD Negeri Lama'))

@section('content')
<!-- Modern Header Banner with School Image -->
<div class="page-header announcement-page-header" style="background-image: linear-gradient(rgba(15, 23, 42, 0.58), rgba(30, 64, 175, 0.58)), url('{{ asset('mentahan2/img/image1.png') }}'); background-size: cover; background-position: center; background-repeat: no-repeat;">
  <div class="announcement-header-inner">
    <div class="announcement-badge-pill">
      <i class="fa-solid fa-bullhorn"></i> Pengumuman Resmi Sekolah
    </div>
    <h1 class="announcement-main-title">{{ $announcement->title }}</h1>
    
    <div class="announcement-meta-chips">
      <div class="announcement-meta-chip">
        <i class="fa-regular fa-calendar-check"></i>
        <span>{{ $announcement->published_at ? $announcement->published_at->locale('id')->isoFormat('dddd, D MMMM Y') : 'Terbaru' }}</span>
      </div>
      <div class="announcement-meta-chip">
        <i class="fa-solid fa-building-columns"></i>
        <span>Bagian Humas & Tata Usaha</span>
      </div>
      <div class="announcement-meta-chip">
        <i class="fa-regular fa-clock"></i>
        <span>± {{ max(1, ceil(str_word_count(strip_tags($announcement->content)) / 160)) }} Menit Baca</span>
      </div>
      <div class="announcement-meta-chip chip-active">
        <span class="pulse-dot-green"></span>
        <span>Aktif & Terverifikasi</span>
      </div>
    </div>
  </div>
</div>

<div class="page-content">
  <div class="announcement-detail-wrapper">

    <!-- Breadcrumbs Navigation -->
    <nav class="announcement-breadcrumbs" aria-label="Breadcrumb">
      <a href="{{ route('home') }}"><i class="fa-solid fa-house-chimney"></i> Beranda</a>
      <span class="sep"><i class="fa-solid fa-chevron-right"></i></span>
      <a href="{{ route('pengumuman.index') }}"><i class="fa-solid fa-bullhorn"></i> Pengumuman</a>
      <span class="sep"><i class="fa-solid fa-chevron-right"></i></span>
      <span class="current" title="{{ $announcement->title }}">{{ $announcement->title }}</span>
    </nav>

    <div class="announcement-detail-grid">
      <!-- Main Content Column -->
      <article class="announcement-card-main">
        <!-- Circular Notice Memo Callout -->
        <div class="announcement-memo-callout">
          <div class="announcement-memo-icon">
            <i class="fa-solid fa-clipboard-check"></i>
          </div>
          <div class="announcement-memo-content">
            <h4>Pemberitahuan Resmi Sekolah</h4>
            <p>Mohon seluruh siswa, orang tua/wali murid, dan tenaga kependidikan memperhatikan informasi berikut dengan saksama demi kelancaran kegiatan sekolah.</p>
          </div>
        </div>

        <!-- Article Content -->
        <div class="announcement-article-body">
          {!! nl2br(e($announcement->content)) !!}
        </div>

        <!-- Formal Verification & Stamp Box -->
        <div class="announcement-formal-signoff">
          <div class="announcement-formal-left">
            <div class="announcement-school-seal">
              <img src="{{ asset('mentahan2/img/Logo1.svg') }}?v={{ @filemtime(public_path('mentahan2/img/Logo1.svg')) ?: time() }}" alt="Logo {{ $settings['school_name'] ?? 'SD Negeri Lama' }}" onerror="this.onerror=null; this.src='{{ asset('mentahan2/img/Logo1.png') }}';">
            </div>
            <div class="announcement-formal-details">
              <h5>{{ $settings['school_name'] ?? 'SD Negeri Lama' }}</h5>
              <p>Dikeluarkan secara resmi melalui Sistem Informasi Akademik & Portal Warta Sekolah</p>
            </div>
          </div>
          <div class="announcement-formal-stamp">
            <i class="fa-solid fa-circle-check"></i>
            <span>Dokumen Sah & Terverifikasi</span>
          </div>
        </div>
      </article>

      <!-- Sidebar Column -->
      <aside class="announcement-sidebar">
        <!-- Recent Announcements Card -->
        <div class="sidebar-widget-card">
          <div class="sidebar-widget-header">
            <div class="sidebar-widget-title">
              <i class="fa-solid fa-bullhorn"></i>
              <span>Pengumuman Lainnya</span>
            </div>
            <span class="sidebar-count-badge">{{ $recentAnnouncements->count() }} Warta</span>
          </div>

          <ul class="sidebar-announcement-list">
            @forelse($recentAnnouncements as $recent)
            <li>
              <a href="{{ route('pengumuman.show', $recent->slug) }}" class="sidebar-announcement-item">
                <div class="sidebar-date-badge">
                  <div class="sidebar-date-day">{{ $recent->published_at ? $recent->published_at->format('d') : date('d') }}</div>
                  <div class="sidebar-date-month">{{ $recent->published_at ? $recent->published_at->locale('id')->isoFormat('MMM') : 'OKT' }}</div>
                </div>
                <div class="sidebar-announcement-info">
                  <div class="sidebar-announcement-title">{{ $recent->title }}</div>
                  <div class="sidebar-announcement-time">
                    <i class="fa-regular fa-calendar"></i>
                    <span>{{ $recent->published_at ? $recent->published_at->locale('id')->isoFormat('D MMM Y') : '-' }}</span>
                  </div>
                </div>
              </a>
            </li>
            @empty
            <li style="color: var(--muted); font-size: 0.88rem; text-align: center; padding: 10px 0;">
              Tidak ada pengumuman lainnya saat ini.
            </li>
            @endforelse
          </ul>
        </div>
      </aside>
    </div>
  </div>
</div>
<script>
function copyAnnouncementLink() {
  const url = window.location.href;
  if (navigator.clipboard && window.isSecureContext) {
    navigator.clipboard.writeText(url).then(showToast);
  } else {
    // Fallback for non-https or older browsers
    const textArea = document.createElement("textarea");
    textArea.value = url;
    textArea.style.position = "fixed";
    textArea.style.left = "-999999px";
    document.body.appendChild(textArea);
    textArea.focus();
    textArea.select();
    try {
      document.execCommand('copy');
      showToast();
    } catch (err) {
      alert("Tautan: " + url);
    }
    document.body.removeChild(textArea);
  }
}

function showToast() {
  const toast = document.getElementById('toast-notification');
  if (toast) {
    toast.classList.add('show');
    setTimeout(() => {
      toast.classList.remove('show');
    }, 3000);
  }
}
</script>
@endsection
