@extends('layouts.app')

@section('title', $announcement->title . ' - ' . ($settings['school_name'] ?? 'SD Negeri Lama'))

@section('content')
<div class="page-header">
  <h1 style="font-size: 2rem;">{{ $announcement->title }}</h1>
  <p><i class="fa-solid fa-calendar-days"></i> Dipublikasikan pada: {{ $announcement->published_at ? $announcement->published_at->format('d F Y') : '-' }}</p>
</div>

<div class="page-content">
  <div style="display: grid; grid-template-columns: 2.5fr 1fr; gap: 30px;">
    <div class="card-box">
      <div style="font-size: 1.05rem; color: var(--dark); line-height: 1.8; white-space: pre-line;">
        {{ $announcement->content }}
      </div>
      <div style="margin-top: 40px; padding-top: 20px; border-top: 1px solid var(--border);">
        <a href="{{ route('pengumuman.index') }}" style="color: var(--primary); font-weight: 700;"><i class="fa-solid fa-arrow-left"></i> Kembali ke Daftar Pengumuman</a>
      </div>
    </div>

    <div>
      <div class="card-box">
        <h3 style="font-size: 1.1rem; font-weight: 700; margin-bottom: 16px;"><i class="fa-solid fa-bullhorn"></i> Pengumuman Lainnya</h3>
        <ul style="list-style: none;">
          @foreach($recentAnnouncements as $recent)
          <li style="margin-bottom: 12px; padding-bottom: 12px; border-bottom: 1px solid var(--light-bg);">
            <a href="{{ route('pengumuman.show', $recent->slug) }}" style="font-weight: 600; font-size: 0.9rem; color: var(--dark);">{{ $recent->title }}</a>
            <div style="font-size: 0.75rem; color: var(--muted); margin-top: 4px;">{{ $recent->published_at ? $recent->published_at->format('d M Y') : '' }}</div>
          </li>
          @endforeach
        </ul>
      </div>
    </div>
  </div>
</div>
@endsection
