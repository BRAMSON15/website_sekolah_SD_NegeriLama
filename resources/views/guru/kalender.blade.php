@extends('layouts.guru')

@section('title', 'Kalender Akademik - ' . ($settings['school_name'] ?? 'SD NEGERI LAMA'))

@section('content')
<!-- BREADCRUMB / HERO -->
<div class="welcome" style="margin-bottom: 25px;">
    <div class="welcome-text">
        <h1>
            <i class="fa-solid fa-calendar-days"></i> Kalender Akademik Sekolah
        </h1>
        <p>
            Agenda kegiatan belajar mengajar, jadwal penilaian sumatif, hari libur nasional, dan rapat dewan guru Tahun Ajaran {{ date('Y') }}/{{ date('Y') + 1 }}.
        </p>
    </div>
    <div class="teacher-illustration">
        <div class="teacher">
            <div class="teacher-head"></div>
            <div class="teacher-body"></div>
        </div>
        <div class="board">
            <span>Semester Ganjil</span>
            <small>{{ date('Y') }}/{{ date('Y') + 1 }}</small>
        </div>
    </div>
</div>

<div class="dashboard-grid">
    <!-- LEFT CONTENT: AGENDA LIST -->
    <div class="left-content">
        <div class="section-card">
            <div class="section-header" style="margin-bottom: 20px;">
                <div class="section-title">
                    <div class="title-icon green-icon">
                        <i class="fa-solid fa-calendar-check"></i>
                    </div>
                    <div>
                        <h2>Agenda & Kegiatan Terdekat</h2>
                        <p>Kegiatan akademik dan operasional sekolah bulan ini</p>
                    </div>
                </div>
            </div>

            <div style="display: flex; flex-direction: column; gap: 16px;">
                @foreach($events as $event)
                <div style="display: flex; gap: 16px; padding: 18px; border-radius: 12px; background: var(--background); border-left: 4px solid {{ $event['badge_color'] }};">
                    <div style="min-width: 90px; text-align: center; background: #fff; padding: 10px; border-radius: 10px; border: 1px solid var(--border); display: flex; flex-direction: column; justify-content: center;">
                        <span style="font-size: 1.3rem; font-weight: 800; color: var(--primary); line-height: 1;">{{ date('d', strtotime($event['date'])) }}</span>
                        <span style="font-size: 0.75rem; text-transform: uppercase; font-weight: 700; color: var(--muted); margin-top: 4px;">{{ date('M Y', strtotime($event['date'])) }}</span>
                    </div>

                    <div style="flex: 1;">
                        <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 4px;">
                            <span style="background: {{ $event['badge_color'] }}15; color: {{ $event['badge_color'] }}; padding: 2px 10px; border-radius: 12px; font-size: 0.75rem; font-weight: 700;">
                                {{ $event['type'] }}
                            </span>
                        </div>
                        <h3 style="font-size: 1.05rem; font-weight: 700; color: var(--text); margin-bottom: 6px;">{{ $event['title'] }}</h3>
                        <p style="font-size: 0.85rem; color: var(--muted); margin: 0; line-height: 1.5;">{{ $event['desc'] }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- RIGHT CONTENT: CALENDAR DOWNLOAD & NOTICE -->
    <div class="right-content">
        <div class="section-card" style="margin-bottom: 25px;">
            <div class="section-header" style="margin-bottom: 16px;">
                <h2><i class="fa-solid fa-file-arrow-down" style="color: var(--primary);"></i> Berkas Kalender</h2>
            </div>
            <p style="font-size: 0.88rem; color: var(--muted); line-height: 1.6; margin-bottom: 18px;">
                Unduh file resmi Kalender Pendidikan (Kaldik) Provinsi Maluku / Kota Ambon Tahun Ajaran {{ date('Y') }}/{{ date('Y') + 1 }} format PDF.
            </p>
            <button type="button" onclick="alert('Mengunduh Kalender Pendidikan PDF resmi...');" style="width: 100%; background: #2875dc; color: #fff; border: none; padding: 12px; border-radius: 9px; font-weight: 700; font-size: 13px; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 8px;">
                <i class="fa-solid fa-download"></i> Unduh Kaldik PDF (1.2 MB)
            </button>
        </div>

        <div class="section-card quick-card">
            <div class="section-header" style="margin-bottom: 14px;">
                <h2><i class="fa-solid fa-circle-info" style="color: #ea580c;"></i> Informasi Penting</h2>
            </div>
            <ul style="font-size: 0.85rem; color: var(--muted); line-height: 1.8; padding-left: 18px; margin: 0;">
                <li>Setiap hari Senin seluruh guru dan siswa wajib mengikuti Upacara Bendera.</li>
                <li>Projek Penguatan Profil Pelajar Pancasila (P5) dilaksanakan terjadwal setiap Jumat pagi.</li>
                <li>Pengisian nilai rapor tengah semester ditutup H-3 sebelum penerimaan rapor.</li>
            </ul>
        </div>
    </div>
</div>
@endsection
