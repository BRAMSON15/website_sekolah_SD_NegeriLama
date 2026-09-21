@extends('layouts.guru')

@section('title', 'Video Edukasi - ' . ($settings['school_name'] ?? 'SD NEGERI LAMA'))

@section('content')
<!-- NOTIFICATION ALERTS -->
@if(session('success'))
<div style="background: #dcfce7; border: 1px solid #86efac; color: #166534; padding: 14px 18px; border-radius: 12px; margin-bottom: 22px; display: flex; align-items: center; gap: 12px; font-weight: 600; box-shadow: 0 4px 12px rgba(22, 163, 74, 0.08);">
    <i class="fa-solid fa-circle-check" style="font-size: 1.3rem; color: #16a34a;"></i>
    <span>{{ session('success') }}</span>
</div>
@endif

@if(isset($errors) && $errors->any())
<div style="background: #fee2e2; border: 1px solid #fca5a5; color: #991b1b; padding: 14px 18px; border-radius: 12px; margin-bottom: 22px;">
    <div style="font-weight: 700; margin-bottom: 6px; display: flex; align-items: center; gap: 8px;">
        <i class="fa-solid fa-circle-exclamation"></i> Terjadi kesalahan input video:
    </div>
    <ul style="margin: 0; padding-left: 20px; font-size: 0.9rem;">
        @foreach($errors->all() as $err)
            <li>{{ $err }}</li>
        @endforeach
    </ul>
</div>
@endif

<!-- BREADCRUMB / HERO -->
<div class="welcome" style="margin-bottom: 25px;">
    <div class="welcome-text">
        <h1>
            <i class="fa-solid fa-circle-play"></i> Video Edukasi & Pembelajaran
        </h1>
        <p>
            Media video interaktif untuk mempermudah penjelasan materi pembelajaran secara visual bagi peserta didik.
        </p>
    </div>
    <div class="teacher-illustration">
        <div class="teacher">
            <div class="teacher-head"></div>
            <div class="teacher-body"></div>
        </div>
        <div class="board">
            <span>{{ count($videos) }} Video</span>
            <small>Media Interaktif</small>
        </div>
    </div>
</div>

<!-- ACTIONS BAR -->
<div class="section-card" style="margin-bottom: 25px; padding: 18px 24px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 15px;">
    <div style="display: flex; align-items: center; gap: 10px;">
        <span style="font-size: 0.95rem; font-weight: 700; color: var(--text);">
            <i class="fa-solid fa-clapperboard" style="color: #8b5cf6;"></i> Total Koleksi: {{ count($videos) }} Media Video
        </span>
    </div>

    <button type="button" onclick="openModalVideo()" style="background: #8b5cf6; color: white; border: none; padding: 10px 20px; border-radius: 9px; font-weight: 700; font-size: 13px; cursor: pointer; display: inline-flex; align-items: center; gap: 8px; box-shadow: 0 4px 12px rgba(139, 92, 246, 0.25);">
        <i class="fa-solid fa-video"></i> Tambah Video Baru
    </button>
</div>

@if($activeVideo)
<!-- ACTIVE / FEATURED VIDEO PLAYER -->
<div class="section-card" style="margin-bottom: 30px; overflow: hidden; padding: 0;">
    <div style="padding: 20px 24px; border-bottom: 1px solid var(--border); display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 12px;">
        <div class="section-title">
            <div class="title-icon purple-icon">
                <i class="fa-solid fa-circle-play"></i>
            </div>
            <div>
                <h2 style="font-size: 1.25rem;">Pemutar Video: {{ $activeVideo->title }}</h2>
                <p>Materi pembelajaran interaktif aktif ditayangkan</p>
            </div>
        </div>
        <div style="display: flex; align-items: center; gap: 10px;">
            <span style="background: #f3e8ff; color: #7e22ce; padding: 4px 12px; border-radius: 20px; font-size: 0.8rem; font-weight: 700;">
                <i class="fa-regular fa-clock"></i> {{ $activeVideo->duration }}
            </span>
            <form action="{{ route('guru.video.destroy', $activeVideo->id) }}" method="POST" onsubmit="return confirm('Hapus video ini dari koleksi?')">
                @csrf
                @method('DELETE')
                <button type="submit" style="background: #fee2e2; color: #dc2626; border: none; padding: 6px 12px; border-radius: 6px; font-size: 12px; font-weight: 700; cursor: pointer;">
                    <i class="fa-solid fa-trash-can"></i> Hapus Video
                </button>
            </form>
        </div>
    </div>

    <!-- RESPONSIVE YOUTUBE IFRAME -->
    <div style="position: relative; padding-bottom: 56.25%; height: 0; overflow: hidden; background: #000;">
        <iframe 
            src="{{ $activeVideo->embed_url }}" 
            title="{{ $activeVideo->title }}"
            style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; border: 0;" 
            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" 
            allowfullscreen>
        </iframe>
    </div>

    <!-- VIDEO INFO DETAILS -->
    <div style="padding: 22px 24px; background: #ffffff;">
        <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 8px; flex-wrap: wrap;">
            <span style="background: #e0f2fe; color: #0369a1; padding: 3px 12px; border-radius: 15px; font-size: 0.78rem; font-weight: 700;">
                {{ $activeVideo->class_level }}
            </span>
            <span style="background: #f1f5f9; color: #475569; padding: 3px 12px; border-radius: 15px; font-size: 0.78rem; font-weight: 700;">
                {{ $activeVideo->subject }}
            </span>
            <span style="font-size: 0.82rem; color: var(--muted);">
                <i class="fa-regular fa-eye"></i> {{ $activeVideo->views_count }}x ditonton
            </span>
        </div>
        <h3 style="font-size: 1.2rem; font-weight: 800; color: var(--text); margin-bottom: 8px;">{{ $activeVideo->title }}</h3>
        <p style="font-size: 0.9rem; color: #475569; line-height: 1.6; margin: 0;">{{ $activeVideo->description }}</p>
    </div>
</div>
@endif

<!-- MORE VIDEOS LIST -->
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 18px;">
    <h2 style="font-size: 1.25rem; font-weight: 800; color: var(--text); margin: 0;">
        <i class="fa-solid fa-film" style="color: var(--primary);"></i> Koleksi Video Edukasi Tersedia
    </h2>
</div>

<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(min(100%, 280px), 1fr)); gap: 20px; margin-bottom: 25px;">
    @forelse($videos as $vid)
    @php
        $isPlaying = ($activeVideo && $activeVideo->id === $vid->id);
    @endphp
    <div class="section-card" style="display: flex; flex-direction: column; justify-content: space-between; {{ $isPlaying ? 'border: 2px solid #8b5cf6;' : '' }}">
        <div>
            <!-- THUMBNAIL / PREVIEW -->
            <div style="position: relative; border-radius: 10px; height: 170px; background: #0f172a; overflow: hidden; margin-bottom: 14px;">
                @if($vid->thumbnail_url)
                    <img src="{{ $vid->thumbnail_url }}" alt="{{ $vid->title }}" style="width: 100%; height: 100%; object-fit: cover;">
                @else
                    <div style="width: 100%; height: 100%; background: linear-gradient(135deg, #1e3a8a, #3b82f6); display: flex; align-items: center; justify-content: center; color: white;">
                        <i class="fa-solid fa-circle-play" style="font-size: 3rem; opacity: 0.9;"></i>
                    </div>
                @endif
                <div style="position: absolute; inset: 0; background: rgba(0,0,0,0.3); display: flex; align-items: center; justify-content: center;">
                    <a href="{{ route('guru.video', ['play' => $vid->id]) }}" style="width: 46px; height: 46px; border-radius: 50%; background: rgba(255,255,255,0.9); color: #8b5cf6; display: flex; align-items: center; justify-content: center; font-size: 1.2rem; text-decoration: none; box-shadow: 0 4px 12px rgba(0,0,0,0.4); transition: transform 0.2s;" onmouseover="this.style.transform='scale(1.1)'" onmouseout="this.style.transform='scale(1)'">
                        <i class="fa-solid fa-play" style="margin-left: 2px;"></i>
                    </a>
                </div>
                <span style="position: absolute; bottom: 8px; right: 8px; background: rgba(0,0,0,0.8); color: #fff; padding: 2px 8px; border-radius: 6px; font-size: 0.75rem; font-weight: 700;">
                    {{ $vid->duration }}
                </span>
                @if($isPlaying)
                    <span style="position: absolute; top: 8px; left: 8px; background: #8b5cf6; color: #fff; padding: 2px 8px; border-radius: 6px; font-size: 0.72rem; font-weight: 700;">
                        <i class="fa-solid fa-circle-play"></i> Sedang Diputar
                    </span>
                @endif
            </div>

            <span style="background: #e0f2fe; color: #0369a1; padding: 2px 10px; border-radius: 15px; font-size: 0.75rem; font-weight: 700;">
                {{ $vid->class_level }} • {{ $vid->subject }}
            </span>
            <h3 style="font-size: 1.05rem; font-weight: 700; color: var(--text); margin: 8px 0 6px 0; line-height: 1.4;">{{ $vid->title }}</h3>
            <p style="font-size: 0.85rem; color: var(--muted); line-height: 1.5; margin-bottom: 10px;">
                {{ Str::limit($vid->description, 85) }}
            </p>
        </div>

        <div style="display: flex; align-items: center; justify-content: space-between; border-top: 1px solid var(--border); padding-top: 12px; margin-top: 6px;">
            <span style="font-size: 0.8rem; color: var(--muted);"><i class="fa-solid fa-eye"></i> {{ $vid->views_count }} tayangan</span>
            <div style="display: flex; gap: 8px;">
                <a href="{{ route('guru.video', ['play' => $vid->id]) }}" class="watch-button" style="padding: 6px 14px; font-size: 12px; text-decoration: none; background: #8b5cf6; color: #fff; border-radius: 6px; font-weight: 700; display: inline-flex; align-items: center; gap: 6px;">
                    <i class="fa-solid fa-play"></i> Tonton
                </a>
                <form action="{{ route('guru.video.destroy', $vid->id) }}" method="POST" onsubmit="return confirm('Hapus video ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" style="background: #fee2e2; color: #dc2626; border: none; padding: 6px 10px; border-radius: 6px; font-size: 12px; font-weight: 700; cursor: pointer;" title="Hapus Video">
                        <i class="fa-solid fa-trash-can"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>
    @empty
    <div class="section-card" style="grid-column: 1 / -1; padding: 40px; text-align: center; color: var(--muted);">
        <i class="fa-solid fa-video-slash" style="font-size: 2.5rem; margin-bottom: 12px; color: #cbd5e1; display: block;"></i>
        <h3 style="font-size: 1.1rem; color: var(--text); margin-bottom: 6px;">Belum Ada Video Edukasi</h3>
        <p style="font-size: 0.9rem; margin-bottom: 16px;">Tambahkan link video edukasi dari YouTube untuk memudahkan pembelajaran siswa.</p>
        <button type="button" onclick="openModalVideo()" style="background: #8b5cf6; color: white; border: none; padding: 10px 20px; border-radius: 8px; font-weight: 700; font-size: 13px; cursor: pointer;">
            <i class="fa-solid fa-plus"></i> Tambah Video Baru
        </button>
    </div>
    @endforelse
</div>

<!-- MODAL TAMBAH VIDEO -->
<div id="modalVideo" class="modal-overlay">
    <div class="modal-dialog">
        <div class="modal-header" style="background: #8b5cf6;">
            <div style="display: flex; align-items: center; gap: 10px; font-weight: 700; font-size: 1.1rem;">
                <i class="fa-solid fa-video"></i> Tambah Video Edukasi Baru
            </div>
            <button type="button" onclick="closeModalVideo()" style="background: transparent; border: none; color: #ffffff; font-size: 1.4rem; cursor: pointer; line-height: 1;">&times;</button>
        </div>

        <form action="{{ route('guru.video.store') }}" method="POST" class="modal-body-scroll">
            @csrf
            <div style="margin-bottom: 16px;">
                <label style="display: block; font-size: 0.88rem; font-weight: 700; color: #334155; margin-bottom: 6px;">Judul Video *</label>
                <input type="text" name="title" required placeholder="Contoh: Pembelajaran Interaktif Siklus Air" style="width: 100%; padding: 10px 14px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 0.9rem; outline: none; box-sizing: border-box;">
            </div>

            <div class="modal-form-row">
                <div>
                    <label style="display: block; font-size: 0.88rem; font-weight: 700; color: #334155; margin-bottom: 6px;">Mata Pelajaran *</label>
                    <input type="text" name="subject" required placeholder="Contoh: IPA / Sains" value="{{ Auth::user()->subject ?: 'Sains' }}" style="width: 100%; padding: 10px 14px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 0.9rem; outline: none; box-sizing: border-box;">
                </div>
                <div>
                    <label style="display: block; font-size: 0.88rem; font-weight: 700; color: #334155; margin-bottom: 6px;">Tingkat Kelas *</label>
                    <select name="class_level" required style="width: 100%; padding: 10px 14px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 0.9rem; outline: none; background: #fff; box-sizing: border-box;">
                        <option value="Kelas 4A">Kelas 4A</option>
                        <option value="Kelas 5A" selected>Kelas 5A</option>
                        <option value="Kelas 6B">Kelas 6B</option>
                        <option value="Semua Kelas">Semua Kelas</option>
                    </select>
                </div>
            </div>

            <div style="margin-bottom: 16px;">
                <label style="display: block; font-size: 0.88rem; font-weight: 700; color: #334155; margin-bottom: 6px;">Tautan YouTube URL *</label>
                <input type="url" name="youtube_url" required placeholder="https://www.youtube.com/watch?v=... atau https://youtu.be/..." style="width: 100%; padding: 10px 14px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 0.9rem; outline: none; box-sizing: border-box;">
                <small style="color: var(--muted); font-size: 0.78rem;">Mendukung format link YouTube biasa, Shorts, atau link share youtu.be.</small>
            </div>

            <div style="margin-bottom: 16px;">
                <label style="display: block; font-size: 0.88rem; font-weight: 700; color: #334155; margin-bottom: 6px;">Estimasi Durasi (Menit:Detik) *</label>
                <input type="text" name="duration" required placeholder="Contoh: 12:45" style="width: 100%; padding: 10px 14px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 0.9rem; outline: none; box-sizing: border-box;">
            </div>

            <div style="margin-bottom: 22px;">
                <label style="display: block; font-size: 0.88rem; font-weight: 700; color: #334155; margin-bottom: 6px;">Deskripsi / Ringkasan Isi</label>
                <textarea name="description" rows="3" placeholder="Jelaskan ringkasan materi video untuk siswa..." style="width: 100%; padding: 10px 14px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 0.9rem; outline: none; box-sizing: border-box; resize: vertical;"></textarea>
            </div>

            <div style="display: flex; justify-content: flex-end; gap: 10px;">
                <button type="button" onclick="closeModalVideo()" style="padding: 10px 18px; border: 1px solid #cbd5e1; background: #f1f5fa; color: #475569; border-radius: 8px; font-weight: 700; font-size: 13px; cursor: pointer;">
                    Batal
                </button>
                <button type="submit" style="padding: 10px 22px; background: #8b5cf6; border: none; color: #ffffff; border-radius: 8px; font-weight: 700; font-size: 13px; cursor: pointer; display: inline-flex; align-items: center; gap: 8px;">
                    <i class="fa-solid fa-save"></i> Simpan Video
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function openModalVideo() {
        document.getElementById('modalVideo').style.display = 'flex';
    }

    function closeModalVideo() {
        document.getElementById('modalVideo').style.display = 'none';
    }

    window.addEventListener('click', function(e) {
        const modal = document.getElementById('modalVideo');
        if (e.target === modal) {
            closeModalVideo();
        }
    });
</script>
@endsection
