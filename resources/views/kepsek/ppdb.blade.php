@extends('layouts.kepsek')

@section('title', 'Monitoring PPDB Online')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 bg-white p-6 rounded-2xl shadow-sm border border-slate-100">
        <div>
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-sky-50 text-sky-700 border border-sky-200 mb-2">
                <i class="fa-solid fa-id-card-clip"></i> Penerimaan Peserta Didik Baru
            </span>
            <h1 class="text-2xl font-bold text-slate-900 tracking-tight">Monitoring PPDB Online</h1>
            <p class="text-sm text-slate-500 mt-1">Supervisi pendaftaran siswa baru, verifikasi berkas, dan kuota penerimaan jalur seleksi.</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('kepsek.monitoring.ppdb', array_merge(request()->query(), ['print' => 1])) }}" target="_blank"
               class="px-4 py-2.5 bg-slate-900 hover:bg-slate-800 text-white rounded-xl text-xs font-semibold shadow-sm transition-all flex items-center gap-2">
                <i class="fa-solid fa-print"></i> Cetak Rekap PPDB
            </a>
        </div>
    </div>

    <!-- Stat Metrics -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-blue-50 border border-blue-100 text-blue-600 flex items-center justify-center text-xl shrink-0">
                <i class="fa-solid fa-users"></i>
            </div>
            <div>
                <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Total Pendaftar</p>
                <h3 class="text-2xl font-bold text-slate-800">{{ $totalAll }}</h3>
            </div>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-amber-50 border border-amber-100 text-amber-600 flex items-center justify-center text-xl shrink-0">
                <i class="fa-solid fa-hourglass-half"></i>
            </div>
            <div>
                <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Verifikasi Berkas</p>
                <h3 class="text-2xl font-bold text-amber-600">{{ $totalPending }}</h3>
            </div>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-emerald-50 border border-emerald-100 text-emerald-600 flex items-center justify-center text-xl shrink-0">
                <i class="fa-solid fa-circle-check"></i>
            </div>
            <div>
                <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Siswa Diterima</p>
                <h3 class="text-2xl font-bold text-emerald-600">{{ $totalApproved }}</h3>
            </div>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-rose-50 border border-rose-100 text-rose-600 flex items-center justify-center text-xl shrink-0">
                <i class="fa-solid fa-circle-xmark"></i>
            </div>
            <div>
                <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Tidak Lolos</p>
                <h3 class="text-2xl font-bold text-rose-600">{{ $totalRejected }}</h3>
            </div>
        </div>
    </div>

    <!-- Filter Bar -->
    <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm">
        <form action="{{ route('kepsek.monitoring.ppdb') }}" method="GET" class="flex flex-col md:flex-row items-stretch md:items-center justify-between gap-4">
            <!-- Status Tabs -->
            <div class="flex items-center p-1 bg-slate-100 rounded-xl overflow-x-auto">
                <a href="{{ route('kepsek.monitoring.ppdb', ['status' => 'all', 'track' => $track, 'search' => $search]) }}"
                   class="px-4 py-2 rounded-lg text-xs font-semibold transition-all whitespace-nowrap {{ ($status === 'all') ? 'bg-white text-slate-900 shadow-sm' : 'text-slate-500 hover:text-slate-900' }}">
                   Semua ({{ $totalAll }})
                </a>
                <a href="{{ route('kepsek.monitoring.ppdb', ['status' => 'menunggu', 'track' => $track, 'search' => $search]) }}"
                   class="px-4 py-2 rounded-lg text-xs font-semibold transition-all whitespace-nowrap {{ ($status === 'menunggu') ? 'bg-white text-amber-700 shadow-sm' : 'text-slate-500 hover:text-slate-900' }}">
                   Menunggu ({{ $totalPending }})
                </a>
                <a href="{{ route('kepsek.monitoring.ppdb', ['status' => 'diterima', 'track' => $track, 'search' => $search]) }}"
                   class="px-4 py-2 rounded-lg text-xs font-semibold transition-all whitespace-nowrap {{ ($status === 'diterima') ? 'bg-white text-emerald-700 shadow-sm' : 'text-slate-500 hover:text-slate-900' }}">
                   Diterima ({{ $totalApproved }})
                </a>
                <a href="{{ route('kepsek.monitoring.ppdb', ['status' => 'ditolak', 'track' => $track, 'search' => $search]) }}"
                   class="px-4 py-2 rounded-lg text-xs font-semibold transition-all whitespace-nowrap {{ ($status === 'ditolak') ? 'bg-white text-rose-700 shadow-sm' : 'text-slate-500 hover:text-slate-900' }}">
                   Ditolak ({{ $totalRejected }})
                </a>
            </div>

            <!-- Controls -->
            <input type="hidden" name="status" value="{{ $status }}">
            <div class="flex flex-wrap items-center gap-3">
                <select name="track" onchange="this.form.submit()" class="px-3 py-2 text-xs border border-slate-200 rounded-xl bg-slate-50 text-slate-700 font-medium focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    <option value="all" {{ ($track === 'all') ? 'selected' : '' }}>Semua Jalur Pendaftaran</option>
                    <option value="Zonasi" {{ ($track === 'Zonasi') ? 'selected' : '' }}>Jalur Zonasi</option>
                    <option value="Afirmasi" {{ ($track === 'Afirmasi') ? 'selected' : '' }}>Jalur Afirmasi</option>
                    <option value="Perpindahan Tugas Orang Tua" {{ ($track === 'Perpindahan Tugas Orang Tua') ? 'selected' : '' }}>Perpindahan Tugas</option>
                    <option value="Prestasi" {{ ($track === 'Prestasi') ? 'selected' : '' }}>Jalur Prestasi</option>
                </select>

                <div class="relative min-w-[200px]">
                    <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                    <input type="text" name="search" value="{{ $search }}" placeholder="Cari nama, nomor reg, asal TK..."
                           class="w-full pl-8 pr-3 py-2 text-xs border border-slate-200 rounded-xl bg-slate-50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-all">
                </div>

                <button type="submit" class="px-4 py-2 bg-slate-900 hover:bg-slate-800 text-white rounded-xl text-xs font-semibold transition-all shadow-sm">
                    Terapkan
                </button>

                @if($search || $track !== 'all' || $status !== 'all')
                    <a href="{{ route('kepsek.monitoring.ppdb') }}" class="px-3 py-2 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-xl text-xs font-medium transition-all" title="Reset filter">
                        <i class="fa-solid fa-rotate-left"></i>
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Registrations Table -->
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="p-5 border-b border-slate-100 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <span class="w-2.5 h-2.5 rounded-full bg-sky-500"></span>
                <h2 class="text-base font-bold text-slate-800">Daftar Berkas Calon Siswa Baru</h2>
                <span class="text-xs font-semibold px-2 py-0.5 rounded-full bg-slate-100 text-slate-600">
                    {{ $registrations->count() }} Pendaftar
                </span>
            </div>
        </div>

        @if($registrations->isEmpty())
            <div class="p-12 text-center text-slate-400">
                <i class="fa-solid fa-folder-open text-4xl mb-3 text-slate-300"></i>
                <p class="font-medium text-slate-600">Tidak ada data pendaftaran PPDB ditemukan</p>
                <p class="text-xs mt-1">Coba sesuaikan filter status atau kata pencarian Anda.</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead class="bg-slate-50 border-b border-slate-100 text-slate-500 font-semibold uppercase tracking-wider">
                        <tr>
                            <th class="px-5 py-3.5">No. Registrasi</th>
                            <th class="px-4 py-3.5">Nama Calon Siswa</th>
                            <th class="px-4 py-3.5 text-center">L/P</th>
                            <th class="px-4 py-3.5">Jalur Pendaftaran</th>
                            <th class="px-4 py-3.5">Asal Sekolah / TK</th>
                            <th class="px-4 py-3.5">Wali / No. Kontak</th>
                            <th class="px-4 py-3.5 text-center">Status</th>
                            <th class="px-5 py-3.5 text-right">Waktu Daftar</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($registrations as $reg)
                            <tr class="hover:bg-slate-50/70 transition-colors">
                                <td class="px-5 py-4">
                                    <span class="font-mono font-bold text-slate-800 bg-slate-100 px-2 py-1 rounded text-[11px]">
                                        {{ $reg->registration_number }}
                                    </span>
                                </td>
                                <td class="px-4 py-4">
                                    <div class="font-bold text-slate-800 text-sm">{{ $reg->full_name }}</div>
                                    <p class="text-slate-400 text-[11px]">NISN: {{ $reg->nisn ?: '-' }}</p>
                                </td>
                                <td class="px-4 py-4 text-center">
                                    <span class="font-semibold text-xs {{ $reg->gender === 'L' ? 'text-blue-600' : 'text-pink-600' }}">
                                        {{ $reg->gender ?? '-' }}
                                    </span>
                                </td>
                                <td class="px-4 py-4">
                                    <span class="inline-block px-2.5 py-1 rounded-md text-xs font-semibold bg-sky-50 text-sky-700 border border-sky-100">
                                        {{ $reg->registration_track ?? 'Zonasi' }}
                                    </span>
                                </td>
                                <td class="px-4 py-4 text-slate-700 font-medium">
                                    {{ $reg->previous_school ?: '-' }}
                                </td>
                                <td class="px-4 py-4">
                                    <div class="font-medium text-slate-800">{{ $reg->parent_name ?: 'Orang Tua / Wali' }}</div>
                                    <p class="text-slate-500 text-[11px]">{{ $reg->phone ?? '-' }}</p>
                                </td>
                                <td class="px-4 py-4 text-center">
                                    @if($reg->status === 'diterima')
                                        <span class="inline-flex items-center gap-1 font-bold text-[11px] px-2.5 py-1 rounded-md bg-emerald-50 text-emerald-700 border border-emerald-200 uppercase">
                                            <i class="fa-solid fa-check"></i> Diterima
                                        </span>
                                    @elseif($reg->status === 'ditolak')
                                        <span class="inline-flex items-center gap-1 font-bold text-[11px] px-2.5 py-1 rounded-md bg-rose-50 text-rose-700 border border-rose-200 uppercase">
                                            <i class="fa-solid fa-xmark"></i> Ditolak
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 font-bold text-[11px] px-2.5 py-1 rounded-md bg-amber-50 text-amber-700 border border-amber-200 uppercase">
                                            <i class="fa-solid fa-clock"></i> Menunggu
                                        </span>
                                    @endif
                                </td>
                                <td class="px-5 py-4 text-right text-slate-500">
                                    {{ $reg->created_at->format('d/m/Y H:i') }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>
@endsection
