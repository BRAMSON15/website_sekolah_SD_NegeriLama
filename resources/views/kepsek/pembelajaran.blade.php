@extends('layouts.kepsek')

@section('title', 'Monitoring Media Pembelajaran')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 bg-white p-6 rounded-2xl shadow-sm border border-slate-100">
        <div>
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200 mb-2">
                <i class="fa-solid fa-graduation-cap"></i> Supervisi Konten Digital
            </span>
            <h1 class="text-2xl font-bold text-slate-900 tracking-tight">Monitoring Media Pembelajaran</h1>
            <p class="text-sm text-slate-500 mt-1">Supervisi seluruh modul materi dan video edukasi yang dipublikasikan dewan guru.</p>
        </div>
        <div class="flex items-center gap-3">
            <span class="text-xs bg-slate-100 text-slate-600 px-3 py-1.5 rounded-lg font-medium">
                <i class="fa-solid fa-clock mr-1 text-slate-400"></i> Diperbarui Realtime
            </span>
        </div>
    </div>

    <!-- Stat Cards -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-indigo-50 border border-indigo-100 text-indigo-600 flex items-center justify-center text-xl shrink-0">
                <i class="fa-solid fa-layer-group"></i>
            </div>
            <div>
                <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Total Media</p>
                <h3 class="text-2xl font-bold text-slate-800">{{ $totalCombined }}</h3>
            </div>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-red-50 border border-red-100 text-red-600 flex items-center justify-center text-xl shrink-0">
                <i class="fa-solid fa-circle-play"></i>
            </div>
            <div>
                <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Video Edukasi</p>
                <h3 class="text-2xl font-bold text-slate-800">{{ $totalVideoCount }}</h3>
            </div>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-amber-50 border border-amber-100 text-amber-600 flex items-center justify-center text-xl shrink-0">
                <i class="fa-solid fa-book-open"></i>
            </div>
            <div>
                <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Modul & File</p>
                <h3 class="text-2xl font-bold text-slate-800">{{ $totalMaterialCount }}</h3>
            </div>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-emerald-50 border border-emerald-100 text-emerald-600 flex items-center justify-center text-xl shrink-0">
                <i class="fa-solid fa-download"></i>
            </div>
            <div>
                <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Total Unduhan</p>
                <h3 class="text-2xl font-bold text-slate-800">{{ $totalDownloads }}</h3>
            </div>
        </div>
    </div>

    <!-- Filter & Search Bar -->
    <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm">
        <form action="{{ route('kepsek.monitoring.pembelajaran') }}" method="GET" class="flex flex-col md:flex-row items-stretch md:items-center justify-between gap-4">
            <!-- Tabs -->
            <div class="flex items-center p-1 bg-slate-100 rounded-xl">
                <a href="{{ route('kepsek.monitoring.pembelajaran', ['tab' => 'all', 'class_level' => $classLevel, 'search' => $search]) }}"
                   class="px-4 py-2 rounded-lg text-xs font-semibold transition-all {{ ($tab === 'all') ? 'bg-white text-slate-900 shadow-sm' : 'text-slate-500 hover:text-slate-900' }}">
                   Semua ({{ $totalCombined }})
                </a>
                <a href="{{ route('kepsek.monitoring.pembelajaran', ['tab' => 'video', 'class_level' => $classLevel, 'search' => $search]) }}"
                   class="px-4 py-2 rounded-lg text-xs font-semibold transition-all {{ ($tab === 'video') ? 'bg-white text-slate-900 shadow-sm' : 'text-slate-500 hover:text-slate-900' }}">
                   <i class="fa-solid fa-video text-red-500 mr-1"></i> Video ({{ $totalVideoCount }})
                </a>
                <a href="{{ route('kepsek.monitoring.pembelajaran', ['tab' => 'materi', 'class_level' => $classLevel, 'search' => $search]) }}"
                   class="px-4 py-2 rounded-lg text-xs font-semibold transition-all {{ ($tab === 'materi') ? 'bg-white text-slate-900 shadow-sm' : 'text-slate-500 hover:text-slate-900' }}">
                   <i class="fa-solid fa-file-pdf text-amber-500 mr-1"></i> Modul ({{ $totalMaterialCount }})
                </a>
            </div>

            <!-- Controls -->
            <input type="hidden" name="tab" value="{{ $tab }}">
            <div class="flex flex-wrap items-center gap-3">
                <select name="class_level" onchange="this.form.submit()" class="px-3 py-2 text-xs border border-slate-200 rounded-xl bg-slate-50 text-slate-700 font-medium focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    @foreach($availableClasses as $cls)
                        <option value="{{ $cls }}" {{ ($classLevel == $cls) ? 'selected' : '' }}>{{ $cls }}</option>
                    @endforeach
                </select>

                <div class="relative min-w-[200px]">
                    <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                    <input type="text" name="search" value="{{ $search }}" placeholder="Cari judul, mapel..."
                           class="w-full pl-8 pr-3 py-2 text-xs border border-slate-200 rounded-xl bg-slate-50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-all">
                </div>

                <button type="submit" class="px-4 py-2 bg-slate-900 hover:bg-slate-800 text-white rounded-xl text-xs font-semibold transition-all shadow-sm">
                    Terapkan
                </button>

                @if($search || ($classLevel && $classLevel !== 'Semua Kelas') || $tab !== 'all')
                    <a href="{{ route('kepsek.monitoring.pembelajaran') }}" class="px-3 py-2 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-xl text-xs font-medium transition-all" title="Reset filter">
                        <i class="fa-solid fa-rotate-left"></i>
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Section 1: Video Pembelajaran -->
    @if($tab === 'all' || $tab === 'video')
        <div class="space-y-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <span class="w-2.5 h-2.5 rounded-full bg-red-500"></span>
                    <h2 class="text-lg font-bold text-slate-800">Koleksi Video Pembelajaran</h2>
                    <span class="text-xs font-semibold px-2 py-0.5 rounded-full bg-red-50 text-red-600 border border-red-100">
                        {{ $videos->count() }} Video Ditemukan
                    </span>
                </div>
            </div>

            @if($videos->isEmpty())
                <div class="bg-white p-12 text-center rounded-2xl border border-slate-100 text-slate-400">
                    <i class="fa-solid fa-film text-4xl mb-3 text-slate-300"></i>
                    <p class="font-medium text-slate-600">Tidak ada video pembelajaran ditemukan</p>
                    <p class="text-xs mt-1">Coba gunakan kata kunci atau pilihan kelas yang berbeda.</p>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
                    @foreach($videos as $video)
                        <div class="bg-white rounded-2xl border border-slate-100 overflow-hidden shadow-sm hover:shadow-md transition-all flex flex-col group">
                            <!-- Thumbnail / Player Preview -->
                            <div class="relative bg-slate-900 aspect-video flex items-center justify-center overflow-hidden">
                                @if($video->source_type === 'youtube' && $video->embed_url)
                                    @php
                                        // Ekstrak Youtube ID sederhana untuk thumbnail
                                        preg_match('/embed\/([a-zA-Z0-9_-]+)/', $video->embed_url, $ytMatches);
                                        $ytId = $ytMatches[1] ?? null;
                                    @endphp
                                    @if($ytId)
                                        <img src="https://img.youtube.com/vi/{{ $ytId }}/mqdefault.jpg" alt="{{ $video->title }}" class="w-full h-full object-cover opacity-80 group-hover:opacity-100 group-hover:scale-105 transition-all duration-300">
                                    @else
                                        <div class="w-full h-full bg-gradient-to-br from-red-600 to-slate-900 opacity-80"></div>
                                    @endif
                                @else
                                    <div class="w-full h-full bg-gradient-to-br from-blue-700 to-slate-900 opacity-80 flex items-center justify-center">
                                        <i class="fa-brands fa-google-drive text-4xl text-white/40"></i>
                                    </div>
                                @endif

                                <div class="absolute inset-0 bg-black/30 group-hover:bg-black/10 transition-colors"></div>

                                <!-- Source Badge -->
                                <div class="absolute top-3 left-3 flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-bold text-white shadow-sm {{ $video->source_type === 'youtube' ? 'bg-red-600' : 'bg-blue-600' }}">
                                    @if($video->source_type === 'youtube')
                                        <i class="fa-brands fa-youtube"></i> YouTube
                                    @else
                                        <i class="fa-brands fa-google-drive"></i> G-Drive
                                    @endif
                                </div>

                                <!-- Class Badge -->
                                <div class="absolute top-3 right-3 px-2.5 py-1 rounded-full text-[10px] font-bold bg-white/90 text-slate-800 backdrop-blur shadow-sm">
                                    {{ $video->class_level ?? 'Semua Kelas' }}
                                </div>

                                <!-- Play Button overlay -->
                                <button type="button"
                                        onclick="openVideoModal('{{ $video->title }}', '{{ $video->embed_url ?? $video->video_url }}', '{{ $video->source_type }}')"
                                        class="absolute inset-0 m-auto w-12 h-12 rounded-full bg-white/90 hover:bg-white text-slate-900 flex items-center justify-center shadow-lg transform group-hover:scale-110 transition-all">
                                    <i class="fa-solid fa-play ml-1 text-base text-red-600"></i>
                                </button>
                            </div>

                            <!-- Content Info -->
                            <div class="p-4 flex-1 flex flex-col justify-between">
                                <div>
                                    <div class="flex items-center gap-2 mb-2">
                                        <span class="text-[11px] font-semibold text-indigo-600 bg-indigo-50 px-2 py-0.5 rounded">
                                            {{ $video->subject }}
                                        </span>
                                        <span class="text-[11px] text-slate-400">
                                            <i class="fa-regular fa-calendar mr-1"></i>{{ $video->created_at->format('d M Y') }}
                                        </span>
                                    </div>
                                    <h3 class="font-bold text-slate-800 text-sm line-clamp-2 mb-1.5 group-hover:text-indigo-600 transition-colors">
                                        {{ $video->title }}
                                    </h3>
                                    <p class="text-xs text-slate-500 line-clamp-2 leading-relaxed mb-3">
                                        {{ $video->description ?: 'Tidak ada deskripsi tambahan.' }}
                                    </p>
                                </div>

                                <div class="pt-3 border-t border-slate-100 flex items-center justify-between text-xs">
                                    <div class="flex items-center gap-2">
                                        <div class="w-6 h-6 rounded-full bg-slate-200 text-slate-700 flex items-center justify-center font-bold text-[10px]">
                                            {{ substr($video->user->name ?? 'G', 0, 1) }}
                                        </div>
                                        <span class="font-medium text-slate-600 truncate max-w-[130px]">{{ $video->user->name ?? 'Dewan Guru' }}</span>
                                    </div>
                                    <button type="button"
                                            onclick="openVideoModal('{{ $video->title }}', '{{ $video->embed_url ?? $video->video_url }}', '{{ $video->source_type }}')"
                                            class="text-indigo-600 hover:text-indigo-800 font-semibold inline-flex items-center gap-1">
                                        Supervisi <i class="fa-solid fa-arrow-right text-[10px]"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    @endif

    <!-- Section 2: Modul & File Materi Pembelajaran -->
    @if($tab === 'all' || $tab === 'materi')
        <div class="space-y-4 pt-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <span class="w-2.5 h-2.5 rounded-full bg-amber-500"></span>
                    <h2 class="text-lg font-bold text-slate-800">Daftar Modul & Materi Pembelajaran</h2>
                    <span class="text-xs font-semibold px-2 py-0.5 rounded-full bg-amber-50 text-amber-700 border border-amber-200">
                        {{ $materials->count() }} File Tersedia
                    </span>
                </div>
            </div>

            @if($materials->isEmpty())
                <div class="bg-white p-12 text-center rounded-2xl border border-slate-100 text-slate-400">
                    <i class="fa-regular fa-folder-open text-4xl mb-3 text-slate-300"></i>
                    <p class="font-medium text-slate-600">Tidak ada modul materi ditemukan</p>
                    <p class="text-xs mt-1">Coba sesuaikan pilihan kelas atau kata kunci filter.</p>
                </div>
            @else
                <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-xs">
                            <thead class="bg-slate-50 border-b border-slate-100 text-slate-500 font-semibold uppercase tracking-wider">
                                <tr>
                                    <th class="px-5 py-3.5">Materi & Judul</th>
                                    <th class="px-4 py-3.5">Mata Pelajaran</th>
                                    <th class="px-4 py-3.5">Target Kelas</th>
                                    <th class="px-4 py-3.5">Guru Pengunggah</th>
                                    <th class="px-4 py-3.5 text-center">Unduhan</th>
                                    <th class="px-5 py-3.5 text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @foreach($materials as $material)
                                    <tr class="hover:bg-slate-50/70 transition-colors">
                                        <td class="px-5 py-4">
                                            <div class="flex items-start gap-3">
                                                <div class="w-9 h-9 rounded-xl bg-amber-50 border border-amber-100 text-amber-600 flex items-center justify-center shrink-0 text-base">
                                                    <i class="fa-solid fa-file-pdf"></i>
                                                </div>
                                                <div>
                                                    <p class="font-bold text-slate-800 text-sm">{{ $material->title }}</p>
                                                    <p class="text-slate-400 text-[11px] line-clamp-1 mt-0.5">{{ $material->description ?: 'Dokumen pembelajaran digital' }}</p>
                                                    <span class="text-[10px] text-slate-400 mt-1 inline-block">
                                                        Diunggah {{ $material->created_at->diffForHumans() }}
                                                    </span>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-4 py-4">
                                            <span class="inline-block px-2.5 py-1 rounded-md text-xs font-semibold bg-indigo-50 text-indigo-700 border border-indigo-100">
                                                {{ $material->subject }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-4">
                                            <span class="font-medium text-slate-700 bg-slate-100 px-2 py-0.5 rounded text-xs">
                                                {{ $material->class_level ?? 'Semua Kelas' }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-4">
                                            <div class="flex items-center gap-2">
                                                <div class="w-6 h-6 rounded-full bg-slate-200 text-slate-700 flex items-center justify-center text-[10px] font-bold">
                                                    {{ substr($material->user->name ?? 'G', 0, 1) }}
                                                </div>
                                                <div>
                                                    <p class="font-medium text-slate-800">{{ $material->user->name ?? 'Dewan Guru' }}</p>
                                                    <p class="text-[10px] text-slate-400">{{ $material->user->nip ?? '-' }}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-4 py-4 text-center">
                                            <span class="inline-flex items-center gap-1 font-semibold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded">
                                                <i class="fa-solid fa-arrow-down text-[10px]"></i> {{ $material->downloads }}x
                                            </span>
                                        </td>
                                        <td class="px-5 py-4 text-right">
                                            <a href="{{ asset('storage/' . $material->file_path) }}" target="_blank"
                                               class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-slate-100 hover:bg-indigo-600 hover:text-white text-slate-700 rounded-lg font-semibold text-xs transition-all shadow-sm">
                                                <i class="fa-solid fa-eye"></i> Tinjau File
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif
        </div>
    @endif
</div>

<!-- Video Supervisi Modal -->
<div id="videoModal" class="fixed inset-0 z-50 hidden bg-black/75 backdrop-blur-sm flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl w-full max-w-3xl overflow-hidden shadow-2xl animate-fade-in">
        <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100 bg-slate-900 text-white">
            <div class="flex items-center gap-2">
                <i class="fa-solid fa-circle-play text-red-500"></i>
                <h3 id="modalVideoTitle" class="font-bold text-sm truncate max-w-lg">Supervisi Video</h3>
            </div>
            <button onclick="closeVideoModal()" class="text-slate-400 hover:text-white text-lg transition-colors">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
        <div class="relative aspect-video bg-black">
            <iframe id="videoIframe" src="" class="w-full h-full" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
        </div>
        <div class="p-4 bg-slate-50 text-right">
            <button onclick="closeVideoModal()" class="px-4 py-2 bg-slate-200 hover:bg-slate-300 text-slate-700 rounded-xl text-xs font-semibold">
                Tutup Jendela
            </button>
        </div>
    </div>
</div>

@section('scripts')
  <script src="{{ asset('mentahan2/js/kepsek-video.js') }}?v={{ filemtime(public_path('mentahan2/js/kepsek-video.js')) }}"></script>
@endsection
@endsection
