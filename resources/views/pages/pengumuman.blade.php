@extends('layouts.app')

@section('title', 'Arsip Pengumuman - ' . ($settings['school_name'] ?? 'SD Negeri Lama'))

@section('content')
<!-- Modern Header Banner with School Image -->
<div class="page-header announcement-page-header" style="background-image: linear-gradient(rgba(15, 23, 42, 0.58), rgba(30, 64, 175, 0.58)), url('{{ asset('mentahan2/img/image1.png') }}'); background-size: cover; background-position: center; background-repeat: no-repeat;">
  <div class="announcement-header-inner">
    <div class="announcement-badge-pill">
      <i class="fa-solid fa-bullhorn"></i> Pusat Informasi Resmi
    </div>
    <h1 class="announcement-main-title">Warta & Pengumuman Sekolah</h1>
    <p style="color: #e2e8f0; font-size: 1.05rem; max-width: 650px; margin: 0 auto; line-height: 1.6; text-shadow: 0 1px 4px rgba(15, 23, 42, 0.55);">
      Informasi resmi, agenda kegiatan, dan surat edaran terkini dari {{ $settings['school_name'] ?? 'SD Negeri Lama' }}
    </p>
  </div>
</div>

<div class="page-content">
  <div class="announcement-detail-wrapper">

    <!-- Breadcrumbs Navigation -->
    <nav class="announcement-breadcrumbs" aria-label="Breadcrumb">
      <a href="{{ route('home') }}"><i class="fa-solid fa-house-chimney"></i> Beranda</a>
      <span class="sep"><i class="fa-solid fa-chevron-right"></i></span>
      <span class="current">Pengumuman Sekolah</span>
    </nav>

    <!-- Search & Filter Bar -->
    <div class="announcement-search-box">
      <i class="fa-solid fa-magnifying-glass"></i>
      <input type="text" id="announcementSearchInput" placeholder="Cari judul, topik, atau kata kunci pengumuman..." onkeyup="filterAnnouncements()">
      <span id="announcementSearchCount" style="font-size: 0.82rem; font-weight: 700; color: #64748b; white-space: nowrap;">
        Total: {{ $announcements->total() }} Pengumuman
      </span>
    </div>

    <!-- Announcement Feed Cards Grid -->
    <div class="announcement-feed-grid" id="announcementFeedList">
      @forelse($announcements as $announcement)
      <article class="announcement-feed-card" data-title="{{ strtolower($announcement->title) }}" data-content="{{ strtolower($announcement->content) }}">
        <!-- Date Badge -->
        <div class="announcement-feed-date-badge">
          <div class="announcement-feed-date-day">{{ $announcement->published_at ? $announcement->published_at->format('d') : date('d') }}</div>
          <div class="announcement-feed-date-month">{{ $announcement->published_at ? $announcement->published_at->locale('id')->isoFormat('MMM Y') : date('M Y') }}</div>
        </div>

        <!-- Content -->
        <div class="announcement-feed-content">
          <div class="announcement-feed-top-meta">
            <span class="announcement-feed-tag">
              <i class="fa-solid fa-bullhorn"></i> Pengumuman Resmi
            </span>
            <span class="announcement-feed-time">
              <i class="fa-regular fa-clock"></i> ± {{ max(1, ceil(str_word_count(strip_tags($announcement->content)) / 160)) }} Menit Baca
            </span>
          </div>

          <h2 class="announcement-feed-title">
            <a href="{{ route('pengumuman.show', $announcement->slug) }}">{{ $announcement->title }}</a>
          </h2>

          <p class="announcement-feed-excerpt">
            {{ Str::limit(strip_tags($announcement->content), 200) }}
          </p>

          <div class="announcement-feed-footer">
            <div class="announcement-feed-author">
              <i class="fa-solid fa-building-columns" style="color: #2563eb;"></i>
              <span>Humas & Tata Usaha</span>
            </div>
            <a href="{{ route('pengumuman.show', $announcement->slug) }}" class="announcement-feed-btn">
              <span>Baca Selengkapnya</span>
              <i class="fa-solid fa-arrow-right"></i>
            </a>
          </div>
        </div>
      </article>
      @empty
      <div style="background: #ffffff; border-radius: 16px; padding: 50px 20px; text-align: center; border: 1px dashed #cbd5e1;">
        <i class="fa-solid fa-bullhorn" style="font-size: 3rem; color: #cbd5e1; margin-bottom: 16px;"></i>
        <h3 style="font-size: 1.2rem; font-weight: 700; color: #334155;">Belum Ada Pengumuman</h3>
        <p style="color: #64748b; font-size: 0.95rem; margin-top: 6px;">Saat ini belum ada pengumuman resmi yang dipublikasikan oleh sekolah.</p>
      </div>
      @endforelse

      <!-- No Search Results Found Fallback (hidden by default) -->
      <div id="noSearchResults" style="display: none; background: #ffffff; border-radius: 16px; padding: 50px 20px; text-align: center; border: 1px dashed #cbd5e1;">
        <i class="fa-solid fa-magnifying-glass" style="font-size: 2.8rem; color: #94a3b8; margin-bottom: 14px;"></i>
        <h3 style="font-size: 1.15rem; font-weight: 700; color: #1e293b;">Tidak Ditemukan Pengumuman</h3>
        <p style="color: #64748b; font-size: 0.9rem; margin-top: 6px;">Coba gunakan kata kunci pencarian yang lain.</p>
      </div>
    </div>

    <!-- Pagination -->
    <div style="margin-top: 36px; display: flex; justify-content: center;">
      {{ $announcements->links() }}
    </div>

  </div>
</div>

<script>
function filterAnnouncements() {
  const query = document.getElementById('announcementSearchInput').value.toLowerCase().trim();
  const cards = document.querySelectorAll('#announcementFeedList .announcement-feed-card');
  const emptyState = document.getElementById('noSearchResults');
  let visibleCount = 0;

  cards.forEach(card => {
    const title = card.getAttribute('data-title') || '';
    const content = card.getAttribute('data-content') || '';
    if (query === '' || title.includes(query) || content.includes(query)) {
      card.style.display = 'flex';
      visibleCount++;
    } else {
      card.style.display = 'none';
    }
  });

  if (emptyState) {
    if (visibleCount === 0 && query !== '') {
      emptyState.style.display = 'block';
    } else {
      emptyState.style.display = 'none';
    }
  }

  const countBadge = document.getElementById('announcementSearchCount');
  if (countBadge) {
    if (query !== '') {
      countBadge.innerText = visibleCount + ' Ditemukan';
    } else {
      countBadge.innerText = 'Total: {{ $announcements->total() }} Pengumuman';
    }
  }
}
</script>
@endsection
