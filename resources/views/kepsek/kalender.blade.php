@extends('layouts.kepsek')

@section('title', 'Supervisi Kalender Pendidikan')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 bg-white p-6 rounded-2xl shadow-sm border border-slate-100">
        <div>
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-blue-50 text-blue-700 border border-blue-200 mb-2">
                <i class="fa-solid fa-calendar-days"></i> Kalender Akademik Resmi
            </span>
            <h1 class="text-2xl font-bold text-slate-900 tracking-tight">Supervisi Kalender Pendidikan (Kaldik)</h1>
            <p class="text-sm text-slate-500 mt-1">Pantau agenda kegiatan belajar mengajar, jadwal penilaian sumatif, P5, rapat dinas, dan hari libur sekolah TA {{ date('Y') }}/{{ date('Y') + 1 }}.</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('kepsek.monitoring.kalender.download') }}"
               class="px-4 py-2.5 bg-slate-900 hover:bg-slate-800 text-white rounded-xl text-xs font-semibold shadow-sm transition-all flex items-center gap-2">
                <i class="fa-solid fa-file-arrow-down"></i> Unduh Kaldik Resmi (.txt)
            </a>
        </div>
    </div>

    <!-- Quick Stat Cards -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-blue-50 border border-blue-100 text-blue-600 flex items-center justify-center text-xl shrink-0">
                <i class="fa-solid fa-calendar-check"></i>
            </div>
            <div>
                <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Total Agenda</p>
                <h3 class="text-2xl font-bold text-slate-800">{{ count($events) }} <span class="text-xs text-slate-400 font-normal">Kegiatan</span></h3>
            </div>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-red-50 border border-red-100 text-red-600 flex items-center justify-center text-xl shrink-0">
                <i class="fa-solid fa-pen-ruler"></i>
            </div>
            <div>
                <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Jadwal Ujian</p>
                <h3 class="text-2xl font-bold text-slate-800">{{ collect($events)->where('type', 'Ujian')->count() }} <span class="text-xs text-slate-400 font-normal">Sesi</span></h3>
            </div>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-indigo-50 border border-indigo-100 text-indigo-600 flex items-center justify-center text-xl shrink-0">
                <i class="fa-solid fa-users-gear"></i>
            </div>
            <div>
                <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Rapat Pleno</p>
                <h3 class="text-2xl font-bold text-slate-800">{{ collect($events)->where('type', 'Rapat Guru')->count() }} <span class="text-xs text-slate-400 font-normal">Rapat</span></h3>
            </div>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-emerald-50 border border-emerald-100 text-emerald-600 flex items-center justify-center text-xl shrink-0">
                <i class="fa-solid fa-masks-theater"></i>
            </div>
            <div>
                <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Projek P5 & Seni</p>
                <h3 class="text-2xl font-bold text-slate-800">{{ collect($events)->where('type', 'Kegiatan')->count() }} <span class="text-xs text-slate-400 font-normal">Event</span></h3>
            </div>
        </div>
    </div>

    <!-- Main Content Layout (Agenda Timeline & Official Document Panel) -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Left: Agenda Timeline (2 Columns) -->
        <div class="lg:col-span-2 space-y-4">
            <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm">
                <div class="flex items-center justify-between pb-4 mb-4 border-b border-slate-100">
                    <div class="flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-blue-600"></span>
                        <h2 class="text-base font-bold text-slate-800">Linimasa Agenda Akademik Semester Ganjil</h2>
                    </div>
                    <span class="text-xs font-bold text-blue-700 bg-blue-50 px-2.5 py-1 rounded-full border border-blue-200">
                        TA {{ date('Y') }}/{{ date('Y') + 1 }}
                    </span>
                </div>

                <div class="space-y-4">
                    @foreach($events as $event)
                    <div class="flex items-start gap-4 p-4 rounded-xl bg-slate-50/70 border border-slate-200/70 hover:bg-white hover:shadow-md transition-all">
                        <!-- Date Badge -->
                        <div class="w-16 h-16 rounded-xl bg-white border border-slate-200 flex flex-col items-center justify-center shrink-0 shadow-sm">
                            <span class="text-xl font-extrabold text-slate-800 leading-none">
                                {{ $event['day'] ?? (isset($event['raw_date']) ? \Carbon\Carbon::parse($event['raw_date'])->format('d') : '25') }}
                            </span>
                            <span class="text-[10px] font-bold text-slate-500 uppercase mt-1">
                                {{ $event['month_year'] ?? (isset($event['raw_date']) ? \Carbon\Carbon::parse($event['raw_date'])->locale('id')->translatedFormat('M Y') : 'Sep 2026') }}
                            </span>
                        </div>

                        <!-- Event Info -->
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center gap-2 mb-1.5 flex-wrap">
                                <span class="px-2.5 py-0.5 rounded-md text-[11px] font-bold"
                                      style="background-color: {{ $event['badge_color'] }}18; color: {{ $event['badge_color'] }};">
                                    {{ $event['type'] }}
                                </span>
                                <span class="text-xs text-slate-400">
                                    <i class="fa-regular fa-clock mr-1"></i> Terjadwal Resmi
                                </span>
                            </div>

                            <h3 class="text-sm font-bold text-slate-800 mb-1 leading-snug">{{ $event['title'] }}</h3>
                            <p class="text-xs text-slate-500 leading-relaxed">{{ $event['desc'] }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Right: Official Notice & Kaldik File Info -->
        <div class="space-y-6">
            <!-- Kaldik Document Card -->
            <div class="bg-gradient-to-br from-slate-900 to-indigo-950 text-white p-6 rounded-2xl shadow-md">
                <div class="w-12 h-12 rounded-xl bg-white/10 text-amber-400 flex items-center justify-center text-xl mb-4">
                    <i class="fa-solid fa-file-shield"></i>
                </div>
                <h3 class="font-bold text-base mb-1">Dokumen Kaldik Resmi</h3>
                <p class="text-xs text-slate-300 leading-relaxed mb-5">
                    Surat Keputusan Kepala Sekolah tentang Pedoman Penyusunan Kalender Pendidikan SD Negeri Lama Ambon Tahun Ajaran {{ date('Y') }}/{{ date('Y') + 1 }}.
                </p>
                <a href="{{ route('kepsek.monitoring.kalender.download') }}"
                   class="w-full py-3 bg-amber-500 hover:bg-amber-600 text-slate-950 rounded-xl font-bold text-xs flex items-center justify-center gap-2 transition-all shadow-sm">
                    <i class="fa-solid fa-download"></i> Unduh Lembar Jadwal Kaldik
                </a>
            </div>

            <!-- Petunjuk Supervisi Kepala Sekolah -->
            <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm">
                <h3 class="font-bold text-slate-800 text-sm mb-3 flex items-center gap-2">
                    <i class="fa-solid fa-circle-check text-emerald-500"></i> Catatan Supervisi Kepala Sekolah
                </h3>
                <ul class="text-xs text-slate-600 space-y-2.5 leading-relaxed">
                    <li class="flex items-start gap-2">
                        <i class="fa-solid fa-check text-blue-500 mt-0.5 shrink-0"></i>
                        <span>Pastikan guru kelas telah menyiapkan kisi-kisi dan naskah soal asesmen H-7 sebelum ujian dimulai.</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <i class="fa-solid fa-check text-blue-500 mt-0.5 shrink-0"></i>
                        <span>Kegiatan Gelar Karya P5 melibatkan partisipasi aktif orang tua dan komite sekolah.</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <i class="fa-solid fa-check text-blue-500 mt-0.5 shrink-0"></i>
                        <span>Entri nilai rapor di sistem e-Rapor wajib diverifikasi tuntas sebelum tanggal pembagian rapor resmi.</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
