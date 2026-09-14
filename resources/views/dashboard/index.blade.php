@extends('layouts.admin')

@section('title', 'Dashboard Admin - ' . ($settings['school_name'] ?? 'SD Negeri Lama'))

@section('content')
@if (session('success'))
<div class="alert alert-success alert-dismissible fade in" role="alert" style="margin-bottom: 20px;">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
    <i class="fa fa-check-circle"></i> {{ session('success') }}
</div>
@endif

<div class="section-admin container-fluid">
    <div class="row admin text-center">
        <div class="col-md-12">
            <div class="row">
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="admin-content analysis-progrebar-ctn res-mg-t-15">
                        <h4 class="text-left text-uppercase"><b>Pengumuman</b></h4>
                        <div class="row vertical-center-box vertical-center-box-tablet">
                            <div class="col-xs-3 mar-bot-15 text-left"><label class="label bg-green">Aktif <i class="fa fa-level-up"></i></label></div>
                            <div class="col-xs-9 cus-gh-hd-pro"><h2 class="text-right no-margin">{{ $stats['announcements'] }}</h2></div>
                        </div>
                        <div class="progress progress-mini"><div style="width: 78%;" class="progress-bar bg-green"></div></div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="admin-content analysis-progrebar-ctn res-mg-t-30">
                        <h4 class="text-left text-uppercase"><b>Fitur / Layanan</b></h4>
                        <div class="row vertical-center-box vertical-center-box-tablet">
                            <div class="col-xs-3 mar-bot-15 text-left"><label class="label bg-blue">Aktif <i class="fa fa-level-up"></i></label></div>
                            <div class="col-xs-9 cus-gh-hd-pro"><h2 class="text-right no-margin">{{ $stats['features'] }}</h2></div>
                        </div>
                        <div class="progress progress-mini"><div style="width: 62%;" class="progress-bar bg-blue"></div></div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="admin-content analysis-progrebar-ctn res-mg-t-30">
                        <h4 class="text-left text-uppercase"><b>Pengaturan</b></h4>
                        <div class="row vertical-center-box vertical-center-box-tablet">
                            <div class="col-xs-3 mar-bot-15 text-left"><label class="label bg-purple">Siap <i class="fa fa-check"></i></label></div>
                            <div class="col-xs-9 cus-gh-hd-pro"><h2 class="text-right no-margin">{{ $stats['settings'] }}</h2></div>
                        </div>
                        <div class="progress progress-mini"><div style="width: 88%;" class="progress-bar bg-purple"></div></div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="admin-content analysis-progrebar-ctn res-mg-t-30">
                        <h4 class="text-left text-uppercase"><b>Status Admin</b></h4>
                        <div class="row vertical-center-box vertical-center-box-tablet">
                            <div class="col-xs-3 mar-bot-15 text-left"><label class="label bg-green">Online <i class="fa fa-circle"></i></label></div>
                            <div class="col-xs-9 cus-gh-hd-pro"><h2 class="text-right no-margin">{{ ucfirst($user->role) }}</h2></div>
                        </div>
                        <div class="progress progress-mini"><div style="width: 100%;" class="progress-bar bg-green"></div></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="product-sales-area mg-tb-30">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
                <div class="product-sales-chart dashboard-map-panel">
                    <div class="portlet-title">
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <div class="caption pro-sl-hd"><span class="caption-subject text-uppercase"><b>Peta Pulau Ambon</b></span></div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <div class="actions graph-rp"><a href="https://www.openstreetmap.org/?mlat=-3.695&mlon=128.18#map=11/-3.695/128.18" target="_blank" rel="noopener" class="btn btn-grey"><i class="fa fa-external-link"></i> Buka Peta</a></div>
                            </div>
                        </div>
                    </div>
                    <div class="dashboard-map-frame">
                        <div id="ambon-map" aria-label="Peta interaktif Pulau Ambon"></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                <div class="white-box analytics-info-cs mg-b-30 res-mg-t-30"><h3 class="box-title">Total Pengumuman</h3><ul class="list-inline two-part-sp"><li><div id="sparklinedash"></div></li><li class="text-right sp-cn-r"><i class="fa fa-level-up"></i> <span class="counter sales-sts-ctn">{{ $stats['announcements'] }}</span></li></ul></div>
                <div class="white-box analytics-info-cs mg-b-30"><h3 class="box-title">Fitur Tersedia</h3><ul class="list-inline two-part-sp"><li><div id="sparklinedash2"></div></li><li class="text-right"><i class="fa fa-level-up"></i> <span class="counter sales-sts-ctn">{{ $stats['features'] }}</span></li></ul></div>
                <div class="white-box analytics-info-cs"><h3 class="box-title">Akun Aktif</h3><ul class="list-inline two-part-sp"><li><div id="sparklinedash3"></div></li><li class="text-right"><i class="fa fa-user"></i> <span class="sales-sts-ctn">{{ ucfirst($user->role) }}</span></li></ul></div>
            </div>
        </div>
    </div>
</div>

<div class="traffic-analysis-area admin-overview-area">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12"><div class="white-box tranffic-als-inner"><h3 class="box-title">Konten Website</h3><div class="stats-row"><div class="stat-item"><h6>Total Konten</h6><b>{{ $stats['announcements'] + $stats['features'] }}</b></div><div class="stat-item"><h6>Pengumuman</h6><b>{{ $stats['announcements'] }}</b></div><div class="stat-item"><h6>Layanan</h6><b>{{ $stats['features'] }}</b></div></div><div class="admin-status-line"><span class="text-success"><i class="fa fa-check-circle"></i> Konten terpantau</span></div></div></div>
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12"><div class="white-box tranffic-als-inner res-mg-t-30"><h3 class="box-title">Status Pengumuman</h3><div class="stats-row"><div class="stat-item"><h6>Aktif</h6><b>{{ $stats['activeAnnouncements'] }}</b></div><div class="stat-item"><h6>Nonaktif</h6><b>{{ $stats['announcements'] - $stats['activeAnnouncements'] }}</b></div><div class="stat-item"><h6>Terbaru</h6><b>{{ $recentAnnouncements->count() }}</b></div></div><div class="admin-status-line"><span class="text-success"><i class="fa fa-bullhorn"></i> Siap dipublikasikan</span></div></div></div>
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12"><div class="white-box tranffic-als-inner res-mg-t-30"><h3 class="box-title">Akses Cepat</h3><div class="admin-quick-actions"><a href="{{ route('pengumuman.index') }}"><i class="fa fa-bullhorn"></i><span>Kelola Pengumuman</span></a><a href="{{ route('home') }}" target="_blank"><i class="fa fa-external-link"></i><span>Lihat Website</span></a></div><div class="admin-status-line"><span><i class="fa fa-user"></i> Masuk sebagai {{ ucfirst($user->role) }}</span></div></div></div>
        </div>
    </div>
</div>

<div class="product-sales-area mg-tb-30 admin-lower-area">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
                <div class="product-status-wrap admin-table-panel">
                    <div class="admin-panel-heading"><div><span class="panel-eyebrow">PUSAT INFORMASI</span><h4>Pengumuman Terbaru</h4></div><a href="{{ route('pengumuman.index') }}" class="btn btn-grey"><i class="fa fa-list"></i> Lihat Semua</a></div>
                    <table>
                        <tr><th>Judul Pengumuman</th><th>Status</th><th>Tanggal Publikasi</th></tr>
                        @forelse($recentAnnouncements as $item)
                        <tr><td>{{ $item->title }}</td><td><button class="{{ $item->is_active ? 'pd-setting' : 'ds-setting' }}">{{ $item->is_active ? 'Aktif' : 'Non-Aktif' }}</button></td><td>{{ $item->published_at ? $item->published_at->format('d M Y') : '-' }}</td></tr>
                        @empty
                        <tr><td colspan="3" class="text-center">Belum ada pengumuman.</td></tr>
                        @endforelse
                    </table>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                <div class="personal-info-wrap res-mg-t-30 admin-profile-panel">
                    <div class="widget-head-info-box"><div class="persoanl-widget-hd"><h2>{{ $user->name }}</h2><p>{{ ucfirst($user->role) }} Panel</p></div><div class="img-circle circle-border m-b-md" style="width: 80px; height: 80px; margin: 18px auto; display: flex; align-items: center; justify-content: center; background: #152036; color: #3b82f6; font-size: 36px;"><i class="fa fa-user"></i></div><div class="social-widget-result"><span>{{ $user->email }}</span></div></div>
                    <div class="widget-text-box"><h4>Profil Administrator</h4><p>Kelola informasi sekolah dan publikasi terbaru dari panel admin.</p><div class="admin-profile-meta"><span><i class="fa fa-calendar"></i> Bergabung {{ $user->created_at->format('d M Y') }}</span><span><i class="fa fa-shield"></i> Akses {{ ucfirst($user->role) }}</span></div><form action="{{ route('logout') }}" method="POST">@csrf<button type="submit" class="btn btn-primary btn-block"><i class="fa fa-sign-out"></i> Log Out</button></form></div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        if (typeof L === 'undefined' || !document.getElementById('ambon-map')) {
            return;
        }

        const ambonMap = L.map('ambon-map', {
            scrollWheelZoom: false,
            zoomControl: true
        }).setView([-3.695, 128.18], 11);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors',
            maxZoom: 19
        }).addTo(ambonMap);

        L.marker([-3.695, 128.18]).addTo(ambonMap)
            .bindPopup('<strong>Ambon</strong><br>Pusat Kota Ambon')
            .openPopup();

        setTimeout(function () {
            ambonMap.invalidateSize();
        }, 100);
    });
</script>
@endsection
