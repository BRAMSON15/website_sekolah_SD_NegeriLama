@extends('layouts.guru')

@section('title', 'Tugas & Penilaian - ' . ($settings['school_name'] ?? 'SD NEGERI LAMA'))

@section('content')
<!-- BREADCRUMB / HERO -->
<div class="welcome" style="margin-bottom: 25px;">
    <div class="welcome-text">
        <h1>
            <i class="fa-solid fa-clipboard-check"></i> Tugas & Penilaian Siswa
        </h1>
        <p>
            Kelola pembuatan tugas harian, pekerjaan rumah (PR), lembar ujian, dan rekapitulasi penilaian peserta didik.
        </p>
    </div>
    <div class="teacher-illustration">
        <div class="teacher">
            <div class="teacher-head"></div>
            <div class="teacher-body"></div>
        </div>
        <div class="board">
            <span>{{ count($assignments) }} Tugas</span>
            <small>Semester Ini</small>
        </div>
    </div>
</div>

<!-- STATS -->
<div class="stats" style="margin-bottom: 25px;">
    <div class="stat-card orange">
        <div class="stat-icon"><i class="fa-solid fa-hourglass-half"></i></div>
        <h2>2</h2>
        <p>Tugas Berjalan (Aktif)</p>
        <span style="font-size: 11px; color: var(--muted);"><i class="fa-solid fa-clock"></i> Belum Melewati Deadline</span>
    </div>
    <div class="stat-card green">
        <div class="stat-icon"><i class="fa-solid fa-check-double"></i></div>
        <h2>1</h2>
        <p>Selesai Dinilai</p>
        <span style="font-size: 11px; color: var(--muted);"><i class="fa-solid fa-circle-check"></i> Nilai Masuk E-Rapor</span>
    </div>
    <div class="stat-card blue">
        <div class="stat-icon"><i class="fa-solid fa-users"></i></div>
        <h2>71 / 84</h2>
        <p>Total Siswa Mengumpulkan</p>
        <span style="font-size: 11px; color: var(--muted);"><i class="fa-solid fa-chart-simple"></i> Partisipasi 84.5%</span>
    </div>
    <div class="stat-card purple">
        <div class="stat-icon"><i class="fa-solid fa-award"></i></div>
        <h2>88.4</h2>
        <p>Rata-rata Nilai Kelas</p>
        <span style="font-size: 11px; color: var(--muted);"><i class="fa-solid fa-thumbs-up"></i> Tuntas KKM</span>
    </div>
</div>

<!-- ACTIONS BAR -->
<div class="section-card" style="margin-bottom: 25px; padding: 18px 24px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 15px;">
    <h2 style="font-size: 1.15rem; font-weight: 800; color: var(--text); margin: 0;">
        <i class="fa-solid fa-list-check" style="color: var(--primary);"></i> Daftar Tugas & Ulangan Siswa
    </h2>

    <button type="button" onclick="alert('Formulir buat tugas baru siap digunakan.');" style="background: #ea580c; color: white; border: none; padding: 10px 20px; border-radius: 9px; font-weight: 700; font-size: 13px; cursor: pointer; display: inline-flex; align-items: center; gap: 8px; box-shadow: 0 4px 12px rgba(234, 88, 12, 0.25);">
        <i class="fa-solid fa-plus"></i> Buat Tugas / Ulangan Baru
    </button>
</div>

<!-- ASSIGNMENT LIST -->
<div style="display: flex; flex-direction: column; gap: 18px; margin-bottom: 30px;">
    @foreach($assignments as $asg)
    <div class="section-card" style="padding: 22px;">
        <div style="display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; gap: 15px; margin-bottom: 16px;">
            <div>
                <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 6px;">
                    <span style="background: #e0f2fe; color: #0369a1; padding: 3px 12px; border-radius: 20px; font-size: 0.8rem; font-weight: 700;">
                        {{ $asg['class'] }} • {{ $asg['subject'] }}
                    </span>
                    @if($asg['status'] === 'Aktif')
                        <span style="background: #dcfce7; color: #15803d; padding: 3px 12px; border-radius: 20px; font-size: 0.8rem; font-weight: 700;">
                            <i class="fa-solid fa-circle-dot"></i> Aktif
                        </span>
                    @else
                        <span style="background: #ede9fe; color: #6d28d9; padding: 3px 12px; border-radius: 20px; font-size: 0.8rem; font-weight: 700;">
                            <i class="fa-solid fa-check"></i> Selesai Dinilai
                        </span>
                    @endif
                </div>
                <h3 style="font-size: 1.15rem; font-weight: 800; color: var(--text); margin: 0 0 6px 0;">{{ $asg['title'] }}</h3>
                <span style="font-size: 0.85rem; color: #ef4444; font-weight: 600;">
                    <i class="fa-regular fa-calendar-xmark"></i> Batas Pengumpulan: {{ $asg['deadline'] }}
                </span>
            </div>

            <div style="display: flex; gap: 10px;">
                <button type="button" onclick="alert('Membuka rekap pengumpulan siswa...');" style="background: #2875dc; color: #fff; border: none; padding: 8px 16px; border-radius: 8px; font-size: 13px; font-weight: 700; cursor: pointer; display: inline-flex; align-items: center; gap: 6px;">
                    <i class="fa-solid fa-user-check"></i> Periksa Pengumpulan ({{ $asg['submitted'] }})
                </button>
            </div>
        </div>

        <div style="background: var(--background); padding: 14px 18px; border-radius: 10px;">
            <div style="display: flex; justify-content: space-between; align-items: center; font-size: 0.85rem; margin-bottom: 8px;">
                <span style="font-weight: 600; color: var(--text);">Kemajuan Pengumpulan:</span>
                <span style="font-weight: 800; color: var(--primary);">{{ $asg['submitted'] }} dari {{ $asg['total'] }} Siswa ({{ round(($asg['submitted'] / $asg['total']) * 100) }}%)</span>
            </div>
            <div style="width: 100%; height: 8px; background: #e2e8f0; border-radius: 10px; overflow: hidden;">
                <div style="width: {{ ($asg['submitted'] / $asg['total']) * 100 }}%; height: 100%; background: #2875dc; border-radius: 10px;"></div>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endsection
