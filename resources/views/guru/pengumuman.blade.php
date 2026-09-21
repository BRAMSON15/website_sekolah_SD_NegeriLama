@extends('layouts.guru')

@section('title', 'Pengumuman Sekolah - ' . ($settings['school_name'] ?? 'SD NEGERI LAMA'))

@section('content')
<!-- BREADCRUMB / HERO -->
<div class="welcome" style="margin-bottom: 25px;">
    <div class="welcome-text">
        <h1>
            <i class="fa-solid fa-bullhorn"></i> Pengumuman & Edaran Sekolah
        </h1>
        <p>
            Informasi resmi kedinasan, surat edaran kepala sekolah, dan berita agenda terbaru untuk seluruh tenaga pendidik.
        </p>
    </div>
    <div class="teacher-illustration">
        <div class="teacher">
            <div class="teacher-head"></div>
            <div class="teacher-body"></div>
        </div>
        <div class="board">
            <span>{{ $announcements->total() }} Pengumuman</span>
            <small>Informasi Resmi</small>
        </div>
    </div>
</div>

<div class="section-card">
    <div class="section-header" style="margin-bottom: 20px;">
        <div class="section-title">
            <div class="title-icon blue-icon">
                <i class="fa-solid fa-newspaper"></i>
            </div>
            <div>
                <h2>Warta & Surat Edaran Aktif</h2>
                <p>Pengumuman yang berlaku bagi guru dan tenaga kependidikan</p>
            </div>
        </div>
    </div>

    <div style="display: flex; flex-direction: column; gap: 16px;">
        @forelse($announcements as $announcement)
        <div class="announcement-item">
            <div class="announcement-date">
                <span style="font-size: 1.4rem; font-weight: 800; line-height: 1;">{{ $announcement->published_at ? $announcement->published_at->format('d') : date('d') }}</span>
                <span style="font-size: 0.72rem; text-transform: uppercase; font-weight: 700; margin-top: 4px;">{{ $announcement->published_at ? $announcement->published_at->format('M Y') : date('M Y') }}</span>
            </div>

            <div style="flex: 1;">
                <h3 style="font-size: 1.1rem; font-weight: 700; color: var(--text); margin-bottom: 6px;">
                    {{ $announcement->title }}
                </h3>
                <p style="font-size: 0.88rem; color: var(--muted); line-height: 1.6; margin-bottom: 12px;">
                    {{ $announcement->content }}
                </p>
                <div style="display: flex; align-items: center; justify-content: space-between; font-size: 0.8rem; color: var(--muted); border-top: 1px dashed #cbd5e1; padding-top: 8px;">
                    <span><i class="fa-solid fa-user-pen"></i> Diterbitkan oleh: Administrator Sekolah</span>
                    <a href="{{ route('pengumuman.show', $announcement->slug) }}" target="_blank" style="color: var(--primary); font-weight: 700; text-decoration: none;">
                        Lihat Selengkapnya <i class="fa-solid fa-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>
        @empty
        <div style="text-align: center; padding: 40px 20px; color: var(--muted);">
            <i class="fa-regular fa-folder-open" style="font-size: 3rem; margin-bottom: 12px; opacity: 0.5;"></i>
            <p>Belum ada pengumuman terbaru yang dipublikasikan.</p>
        </div>
        @endforelse
    </div>

    @if($announcements->hasPages())
    <div style="margin-top: 25px;">
        {{ $announcements->links() }}
    </div>
    @endif
</div>
@endsection
