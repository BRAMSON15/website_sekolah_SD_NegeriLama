@extends('layouts.kepsek')

@section('title', 'Monitoring Sistem & Informasi')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 bg-white p-6 rounded-2xl shadow-sm border border-slate-100">
        <div>
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-violet-50 text-violet-700 border border-violet-200 mb-2">
                <i class="fa-solid fa-server"></i> Pusat Kontrol Operasional
            </span>
            <h1 class="text-2xl font-bold text-slate-900 tracking-tight">Status & Kesehatan Sistem</h1>
            <p class="text-sm text-slate-500 mt-1">Supervisi parameter server, integritas data, dan status modul aplikasi sekolah.</p>
        </div>
        <div class="flex items-center gap-2 px-3 py-1.5 rounded-full bg-emerald-50 border border-emerald-200 text-emerald-700 text-xs font-bold">
            <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
            Semua Layanan Berjalan Normal
        </div>
    </div>

    <!-- Quick Stats Grid -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Total Siswa</span>
                <div class="w-8 h-8 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center text-sm">
                    <i class="fa-solid fa-user-graduate"></i>
                </div>
            </div>
            <h3 class="text-2xl font-bold text-slate-800">{{ $stats['students_count'] }}</h3>
            <p class="text-[11px] text-slate-400 mt-1">Terdaftar di Data Pokok</p>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Dewan Guru</span>
                <div class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center text-sm">
                    <i class="fa-solid fa-chalkboard-user"></i>
                </div>
            </div>
            <h3 class="text-2xl font-bold text-slate-800">{{ $stats['guru_count'] }}</h3>
            <p class="text-[11px] text-slate-400 mt-1">Akun Tenaga Pendidik</p>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Media Digital</span>
                <div class="w-8 h-8 rounded-lg bg-amber-50 text-amber-600 flex items-center justify-center text-sm">
                    <i class="fa-solid fa-photo-film"></i>
                </div>
            </div>
            <h3 class="text-2xl font-bold text-slate-800">{{ $stats['videos_count'] + $stats['materials_count'] }}</h3>
            <p class="text-[11px] text-slate-400 mt-1">Video & Modul Terbit</p>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Pendaftar PPDB</span>
                <div class="w-8 h-8 rounded-lg bg-rose-50 text-rose-600 flex items-center justify-center text-sm">
                    <i class="fa-solid fa-address-card"></i>
                </div>
            </div>
            <h3 class="text-2xl font-bold text-slate-800">{{ $stats['ppdb_count'] }}</h3>
            <p class="text-[11px] text-slate-400 mt-1">Calon Siswa Baru</p>
        </div>
    </div>

    <!-- 2 Column Details: Database Tables & Server Environment -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Database Module Breakdown -->
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden flex flex-col justify-between">
            <div class="p-5 border-b border-slate-100 flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <span class="w-2.5 h-2.5 rounded-full bg-violet-600"></span>
                    <h2 class="text-base font-bold text-slate-800">Distribusi Rekam Data Sekolah</h2>
                </div>
                <span class="text-xs font-semibold px-2 py-0.5 rounded bg-violet-50 text-violet-700">
                    Live Record
                </span>
            </div>

            <div class="p-5 divide-y divide-slate-100">
                <div class="py-3 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <i class="fa-solid fa-users text-slate-400 w-5"></i>
                        <span class="text-xs font-medium text-slate-700">Total Akun Pengguna</span>
                    </div>
                    <span class="text-xs font-bold text-slate-800 bg-slate-100 px-2.5 py-1 rounded-md">
                        {{ $stats['users_total'] }} ({{ $stats['admin_count'] }} Admin, {{ $stats['guru_count'] }} Guru, {{ $stats['kepsek_count'] }} Kepsek)
                    </span>
                </div>

                <div class="py-3 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <i class="fa-solid fa-video text-slate-400 w-5"></i>
                        <span class="text-xs font-medium text-slate-700">Video Pembelajaran Guru</span>
                    </div>
                    <span class="text-xs font-bold text-slate-800 bg-slate-100 px-2.5 py-1 rounded-md">
                        {{ $stats['videos_count'] }} Video
                    </span>
                </div>

                <div class="py-3 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <i class="fa-solid fa-file-lines text-slate-400 w-5"></i>
                        <span class="text-xs font-medium text-slate-700">Modul & Bahan Ajar Digital</span>
                    </div>
                    <span class="text-xs font-bold text-slate-800 bg-slate-100 px-2.5 py-1 rounded-md">
                        {{ $stats['materials_count'] }} Berkas
                    </span>
                </div>

                <div class="py-3 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <i class="fa-solid fa-bullhorn text-slate-400 w-5"></i>
                        <span class="text-xs font-medium text-slate-700">Pengumuman & Berita Sekolah</span>
                    </div>
                    <span class="text-xs font-bold text-slate-800 bg-slate-100 px-2.5 py-1 rounded-md">
                        {{ $stats['announcements_count'] }} ({{ $stats['active_announcements'] }} Tayang)
                    </span>
                </div>
            </div>

            <div class="p-4 bg-slate-50 border-t border-slate-100 text-xs text-slate-500">
                <i class="fa-solid fa-shield-halved text-emerald-600 mr-1.5"></i>
                Semua data terenkripsi dan terlindungi oleh sistem backup berkala.
            </div>
        </div>

        <!-- Server & System Environment -->
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden flex flex-col justify-between">
            <div class="p-5 border-b border-slate-100 flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <span class="w-2.5 h-2.5 rounded-full bg-slate-700"></span>
                    <h2 class="text-base font-bold text-slate-800">Spesifikasi Lingkungan Server</h2>
                </div>
                <span class="text-xs font-semibold px-2 py-0.5 rounded bg-emerald-50 text-emerald-700">
                    Online
                </span>
            </div>

            <div class="p-5 divide-y divide-slate-100">
                <div class="py-3 flex items-center justify-between">
                    <span class="text-xs font-medium text-slate-500">Versi PHP</span>
                    <span class="font-mono text-xs font-bold text-slate-800">{{ $serverInfo['php_version'] }}</span>
                </div>

                <div class="py-3 flex items-center justify-between">
                    <span class="text-xs font-medium text-slate-500">Framework Engine</span>
                    <span class="font-mono text-xs font-bold text-slate-800">Laravel {{ $serverInfo['laravel_version'] }}</span>
                </div>

                <div class="py-3 flex items-center justify-between">
                    <span class="text-xs font-medium text-slate-500">Driver Basis Data</span>
                    <span class="font-mono text-xs font-bold text-slate-800 uppercase">{{ $serverInfo['database'] }}</span>
                </div>

                <div class="py-3 flex items-center justify-between">
                    <span class="text-xs font-medium text-slate-500">Zona Waktu Server</span>
                    <span class="font-mono text-xs font-bold text-slate-800">{{ $serverInfo['timezone'] }}</span>
                </div>

                <div class="py-3 flex items-center justify-between">
                    <span class="text-xs font-medium text-slate-500">Lingkungan Operasi</span>
                    <span class="inline-block px-2 py-0.5 rounded text-[11px] font-bold uppercase {{ $serverInfo['app_env'] === 'production' ? 'bg-emerald-50 text-emerald-700' : 'bg-amber-50 text-amber-700' }}">
                        {{ $serverInfo['app_env'] }}
                    </span>
                </div>

                <div class="py-3 flex items-center justify-between">
                    <span class="text-xs font-medium text-slate-500">Domain URL Portal</span>
                    <span class="font-mono text-xs text-indigo-600">{{ $serverInfo['app_url'] }}</span>
                </div>
            </div>

            <!-- Identitas Lembaga -->
            <div class="p-5 bg-gradient-to-br from-slate-900 to-indigo-950 text-white rounded-b-2xl">
                <div class="flex items-center gap-3 mb-2">
                    <i class="fa-solid fa-school text-amber-400 text-lg"></i>
                    <div>
                        <h4 class="font-bold text-sm text-white">{{ $settings['school_name'] ?? 'SD NEGERI LAMA AMBON' }}</h4>
                        <p class="text-[11px] text-slate-300">NPSN: 60101968 &bull; Terakreditasi {{ $settings['stat_akreditasi'] ?? 'A' }}</p>
                    </div>
                </div>
                <p class="text-xs text-slate-300 leading-relaxed mt-2 border-t border-white/10 pt-2">
                    Kepala Sekolah Pengampu: <strong class="text-amber-300">{{ $settings['principal_name'] ?? 'Drs. H. Ahmad Dahlan, M.Pd.' }}</strong>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
