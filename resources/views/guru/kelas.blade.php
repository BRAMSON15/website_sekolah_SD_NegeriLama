@extends('layouts.guru')

@section('title', 'Kelas Saya - ' . ($settings['school_name'] ?? 'SD NEGERI LAMA'))

@section('content')
<!-- BREADCRUMB / HERO -->
<div class="welcome" style="margin-bottom: 25px;">
    <div class="welcome-text">
        <h1>
            <i class="fa-solid fa-users-rectangle"></i> Kelas Saya
        </h1>
        <p>
            Informasi kelas, jadwal mengajar, dan daftar siswa yang diampu oleh {{ Auth::user()->name }} pada Tahun Ajaran {{ date('Y') }}/{{ date('Y') + 1 }}.
        </p>
    </div>
    <div class="teacher-illustration">
        <div class="teacher">
            <div class="teacher-head"></div>
            <div class="teacher-body"></div>
        </div>
        <div class="board">
            <span>{{ count($classes) }} Kelas</span>
            <small>Tahun Ajaran {{ date('Y') }}/{{ date('Y') + 1 }}</small>
        </div>
    </div>
</div>

<!-- STATS -->
<div class="stats" style="margin-bottom: 30px;">
    <div class="stat-card blue">
        <div class="stat-icon"><i class="fa-solid fa-chalkboard-user"></i></div>
        <h2>{{ count($classes) }}</h2>
        <p>Kelas Diampu</p>
        <span style="font-size: 11px; color: var(--muted);"><i class="fa-solid fa-check"></i> Aktif Semester Ini</span>
    </div>
    <div class="stat-card green">
        <div class="stat-icon"><i class="fa-solid fa-graduation-cap"></i></div>
        <h2>84</h2>
        <p>Total Peserta Didik</p>
        <span style="font-size: 11px; color: var(--muted);"><i class="fa-solid fa-user-group"></i> Siswa Terdaftar</span>
    </div>
    <div class="stat-card purple">
        <div class="stat-icon"><i class="fa-solid fa-clock"></i></div>
        <h2>18</h2>
        <p>Jam Mengajar / Minggu</p>
        <span style="font-size: 11px; color: var(--muted);"><i class="fa-solid fa-calendar-check"></i> Terjadwal Penuh</span>
    </div>
    <div class="stat-card orange">
        <div class="stat-icon"><i class="fa-solid fa-star"></i></div>
        <h2>{{ Auth::user()->subject ?: 'Wali Kelas' }}</h2>
        <p>Mata Pelajaran Utama</p>
        <span style="font-size: 11px; color: var(--muted);"><i class="fa-solid fa-award"></i> Kurikulum Merdeka</span>
    </div>
</div>

<!-- CLASS CARDS -->
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 24px; margin-bottom: 30px;">
    @foreach($classes as $class)
    <div class="section-card" style="display: flex; flex-direction: column; justify-content: space-between;">
        <div>
            <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 16px;">
                <div style="display: flex; align-items: center; gap: 14px;">
                    <div class="class-icon {{ $class['badge_color'] }}" style="width: 46px; height: 46px; font-size: 1.1rem; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-weight: 800;">
                        {{ $class['badge'] }}
                    </div>
                    <div>
                        <h3 style="font-size: 1.25rem; font-weight: 800; color: var(--text); margin-bottom: 2px;">{{ $class['name'] }}</h3>
                        <span style="font-size: 0.85rem; color: var(--muted);"><i class="fa-solid fa-user-tie"></i> Wali Kelas: {{ $class['homeroom'] }}</span>
                    </div>
                </div>
                <span style="background: #e0f2fe; color: #0284c7; padding: 4px 12px; border-radius: 20px; font-size: 0.8rem; font-weight: 700;">
                    {{ $class['students_count'] }} Siswa
                </span>
            </div>

            <div style="background: var(--background); padding: 14px 16px; border-radius: 10px; margin-bottom: 16px; display: flex; flex-direction: column; gap: 8px; font-size: 0.88rem;">
                <div style="display: flex; align-items: center; gap: 10px; color: var(--text);">
                    <i class="fa-solid fa-calendar-days" style="color: var(--primary); width: 16px;"></i>
                    <span><strong>Jadwal:</strong> {{ $class['schedule'] }}</span>
                </div>
                <div style="display: flex; align-items: center; gap: 10px; color: var(--text);">
                    <i class="fa-solid fa-door-open" style="color: var(--primary); width: 16px;"></i>
                    <span><strong>Ruangan:</strong> {{ $class['room'] }}</span>
                </div>
            </div>
        </div>

        <div style="display: flex; gap: 10px; border-top: 1px solid var(--border); padding-top: 15px; margin-top: 5px;">
            <a href="{{ route('guru.tugas') }}" class="menu-item" style="flex: 1; height: 38px; justify-content: center; background: #2875dc; color: #fff; font-size: 12px; font-weight: 700;">
                <i class="fa-solid fa-clipboard-list"></i> Tugas Kelas
            </a>
            <a href="{{ route('guru.materi') }}" class="menu-item" style="flex: 1; height: 38px; justify-content: center; background: #f1f5fa; color: #334155; font-size: 12px; font-weight: 700;">
                <i class="fa-solid fa-book"></i> Materi
            </a>
        </div>
    </div>
    @endforeach
</div>

<!-- DATA SISWA SAMPLE TABLE -->
<div class="section-card">
    <div class="section-header" style="margin-bottom: 20px;">
        <div class="section-title">
            <div class="title-icon green-icon">
                <i class="fa-solid fa-clipboard-user"></i>
            </div>
            <div>
                <h2>Presensi & Siswa Kelas 5A</h2>
                <p>Daftar contoh siswa aktif di kelas perwalian semester ini</p>
            </div>
        </div>
        <span style="font-size: 0.85rem; font-weight: 700; color: var(--primary);">Kehadiran Rata-rata: 98.2%</span>
    </div>

    <div style="overflow-x: auto;">
        <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 0.9rem;">
            <thead>
                <tr style="background: #f8fafc; border-bottom: 2px solid var(--border);">
                    <th style="padding: 12px 16px; color: var(--muted); font-weight: 700;">No</th>
                    <th style="padding: 12px 16px; color: var(--muted); font-weight: 700;">NISN</th>
                    <th style="padding: 12px 16px; color: var(--muted); font-weight: 700;">Nama Lengkap Siswa</th>
                    <th style="padding: 12px 16px; color: var(--muted); font-weight: 700;">L/P</th>
                    <th style="padding: 12px 16px; color: var(--muted); font-weight: 700;">Kehadiran</th>
                    <th style="padding: 12px 16px; color: var(--muted); font-weight: 700;">Status</th>
                </tr>
            </thead>
            <tbody>
                <tr style="border-bottom: 1px solid var(--border);">
                    <td style="padding: 12px 16px; font-weight: 700;">1</td>
                    <td style="padding: 12px 16px; color: var(--muted);">0089234121</td>
                    <td style="padding: 12px 16px; font-weight: 700; color: var(--text);">Aditya Pratama</td>
                    <td style="padding: 12px 16px;">L</td>
                    <td style="padding: 12px 16px; color: #16a34a; font-weight: 700;">100%</td>
                    <td style="padding: 12px 16px;"><span style="background: #dcfce7; color: #166534; padding: 4px 10px; border-radius: 15px; font-size: 0.78rem; font-weight: 700;">Hadir</span></td>
                </tr>
                <tr style="border-bottom: 1px solid var(--border);">
                    <td style="padding: 12px 16px; font-weight: 700;">2</td>
                    <td style="padding: 12px 16px; color: var(--muted);">0089234122</td>
                    <td style="padding: 12px 16px; font-weight: 700; color: var(--text);">Anisa Rahmawati</td>
                    <td style="padding: 12px 16px;">P</td>
                    <td style="padding: 12px 16px; color: #16a34a; font-weight: 700;">98%</td>
                    <td style="padding: 12px 16px;"><span style="background: #dcfce7; color: #166534; padding: 4px 10px; border-radius: 15px; font-size: 0.78rem; font-weight: 700;">Hadir</span></td>
                </tr>
                <tr style="border-bottom: 1px solid var(--border);">
                    <td style="padding: 12px 16px; font-weight: 700;">3</td>
                    <td style="padding: 12px 16px; color: var(--muted);">0089234123</td>
                    <td style="padding: 12px 16px; font-weight: 700; color: var(--text);">Bayu Nugroho</td>
                    <td style="padding: 12px 16px;">L</td>
                    <td style="padding: 12px 16px; color: #16a34a; font-weight: 700;">96%</td>
                    <td style="padding: 12px 16px;"><span style="background: #dcfce7; color: #166534; padding: 4px 10px; border-radius: 15px; font-size: 0.78rem; font-weight: 700;">Hadir</span></td>
                </tr>
                <tr style="border-bottom: 1px solid var(--border);">
                    <td style="padding: 12px 16px; font-weight: 700;">4</td>
                    <td style="padding: 12px 16px; color: var(--muted);">0089234124</td>
                    <td style="padding: 12px 16px; font-weight: 700; color: var(--text);">Citra Dewi Lestari</td>
                    <td style="padding: 12px 16px;">P</td>
                    <td style="padding: 12px 16px; color: #16a34a; font-weight: 700;">100%</td>
                    <td style="padding: 12px 16px;"><span style="background: #dcfce7; color: #166534; padding: 4px 10px; border-radius: 15px; font-size: 0.78rem; font-weight: 700;">Hadir</span></td>
                </tr>
                <tr>
                    <td style="padding: 12px 16px; font-weight: 700;">5</td>
                    <td style="padding: 12px 16px; color: var(--muted);">0089234125</td>
                    <td style="padding: 12px 16px; font-weight: 700; color: var(--text);">Dimas Arya Putra</td>
                    <td style="padding: 12px 16px;">L</td>
                    <td style="padding: 12px 16px; color: #16a34a; font-weight: 700;">97%</td>
                    <td style="padding: 12px 16px;"><span style="background: #dcfce7; color: #166534; padding: 4px 10px; border-radius: 15px; font-size: 0.78rem; font-weight: 700;">Hadir</span></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection
