@extends('layouts.admin')

@section('title', 'Kelola Informasi - ' . ($settings['school_name'] ?? 'SD Negeri Lama'))

@section('content')
<div class="information-home">
    <div class="information-hero">
        <div>
            <span class="panel-eyebrow">PUSAT KONTEN SEKOLAH</span>
            <h2>Kelola Informasi</h2>
            <p>Atur pengumuman dan fitur layanan yang tampil pada website {{ $settings['school_name'] ?? 'SD Negeri Lama' }}.</p>
        </div>
        <i class="fa fa-bullhorn information-hero-icon" aria-hidden="true"></i>
    </div>

    <div class="row information-stats">
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
            <div class="information-stat-card">
                <div class="information-stat-icon information-stat-icon-green"><i class="fa fa-bullhorn"></i></div>
                <div><span>Total Pengumuman</span><strong>{{ $announcementCount }}</strong><small>Menampilkan 5 data terbaru</small></div>
            </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
            <div class="information-stat-card">
                <div class="information-stat-icon information-stat-icon-blue"><i class="fa fa-th-large"></i></div>
                <div><span>Fitur / Layanan</span><strong>{{ $featureCount }}</strong><small>Layanan unggulan website</small></div>
            </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
            <div class="information-stat-card">
                <div class="information-stat-icon information-stat-icon-purple"><i class="fa fa-user"></i></div>
                <div><span>Pengelola Aktif</span><strong>1</strong><small>{{ $user->name }}</small></div>
            </div>
        </div>
    </div>

    <div class="row information-panels">
        <div class="col-lg-7 col-md-7 col-sm-12 col-xs-12">
            <div class="information-panel">
                <div class="information-panel-heading">
                    <div><span class="panel-eyebrow">PUBLIKASI</span><h3>Pengumuman</h3><p>Informasi terbaru yang ditampilkan kepada warga sekolah.</p></div>
                    <a href="{{ route('admin.pengumuman.index') }}" class="btn btn-grey"><i class="fa fa-list"></i> Buka Daftar</a>
                </div>
                <div class="information-list">
                    @forelse($announcements as $announcement)
                    <div class="information-list-item">
                        <div class="information-list-icon"><i class="fa fa-bullhorn"></i></div>
                        <div class="information-list-content"><h4>{{ $announcement->title }}</h4><span>{{ $announcement->published_at ? $announcement->published_at->format('d M Y') : 'Belum dijadwalkan' }}</span></div>
                        <span class="information-status {{ $announcement->is_active ? 'information-status-active' : 'information-status-muted' }}">{{ $announcement->is_active ? 'Aktif' : 'Nonaktif' }}</span>
                    </div>
                    @empty
                    <div class="information-empty"><i class="fa fa-inbox"></i><p>Belum ada pengumuman.</p></div>
                    @endforelse
                </div>
                <a href="{{ route('admin.pengumuman.index') }}" class="information-panel-footer">Kelola seluruh pengumuman <i class="fa fa-arrow-right"></i></a>
            </div>
        </div>

        <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">
            <div class="information-panel information-features-panel res-mg-t-30">
                <div class="information-panel-heading">
                    <div><span class="panel-eyebrow">KONTEN UTAMA</span><h3>Fitur / Layanan</h3><p>Keunggulan yang ditampilkan di halaman depan.</p></div>
                </div>
                <div class="information-feature-list">
                    @forelse($features as $feature)
                    <div class="information-feature-item"><span class="information-feature-icon {{ $feature->icon_color_class ?: 'bg-blue' }}"><i class="{{ $feature->icon ?: 'fa fa-star' }}"></i></span><div><h4>{{ $feature->title }}</h4><p>{{ Str::limit($feature->description, 70) }}</p></div></div>
                    @empty
                    <div class="information-empty"><i class="fa fa-th-large"></i><p>Belum ada fitur atau layanan.</p></div>
                    @endforelse
                </div>
                <a href="{{ route('admin.fitur.index') }}" class="information-panel-footer">Kelola seluruh fitur / layanan <i class="fa fa-arrow-right"></i></a>
            </div>
        </div>
    </div>
</div>
@endsection
