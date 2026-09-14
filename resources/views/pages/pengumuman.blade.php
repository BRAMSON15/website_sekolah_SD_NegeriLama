@extends('layouts.app')

@section('title', 'Arsip Pengumuman - ' . ($settings['school_name'] ?? 'SD Negeri Lama'))

@section('content')
<div class="page-header">
  <h1>Pengumuman Sekolah</h1>
  <p>Informasi dan pengumuman resmi terbaru dari {{ $settings['school_name'] ?? 'SD Negeri Lama' }}</p>
</div>

<div class="page-content">
  <div class="card-box">
    <div style="display: flex; flex-direction: column; gap: 20px;">
      @forelse($announcements as $announcement)
      <div style="display: flex; gap: 20px; padding-bottom: 20px; border-bottom: 1px solid var(--border);">
        <div style="background: var(--primary); color: #fff; border-radius: 12px; padding: 12px 18px; text-align: center; min-width: 80px; align-self: flex-start;">
          <div style="font-size: 1.5rem; font-weight: 800; line-height: 1;">{{ $announcement->published_at ? $announcement->published_at->format('d') : date('d') }}</div>
          <div style="font-size: 0.8rem; text-transform: uppercase; font-weight: 700;">{{ $announcement->published_at ? $announcement->published_at->format('M Y') : date('M Y') }}</div>
        </div>
        <div>
          <h3 style="font-size: 1.2rem; font-weight: 700; margin-bottom: 8px;">
            <a href="{{ route('pengumuman.show', $announcement->slug) }}" style="color: var(--dark); hover:color: var(--primary);">{{ $announcement->title }}</a>
          </h3>
          <p style="color: var(--muted); font-size: 0.95rem; margin-bottom: 12px;">{{ Str::limit($announcement->content, 180) }}</p>
          <a href="{{ route('pengumuman.show', $announcement->slug) }}" style="color: var(--primary); font-weight: 700; font-size: 0.85rem;">Baca Selengkapnya <i class="fa-solid fa-arrow-right"></i></a>
        </div>
      </div>
      @empty
      <p style="color: var(--muted);">Belum ada pengumuman.</p>
      @endforelse
    </div>

    <div style="margin-top: 30px;">
      {{ $announcements->links() }}
    </div>
  </div>
</div>
@endsection
