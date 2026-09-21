@extends('layouts.guru')

@section('title', 'Video Edukasi - ' . ($settings['school_name'] ?? 'SD NEGERI LAMA'))

@section('content')
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
    <div style="display: flex; gap: 10px; flex-wrap: wrap;">
        <button type="button" class="btn" style="background: #2875dc; color: #fff; border: none; padding: 8px 16px; border-radius: 8px; font-size: 13px; font-weight: 700; cursor: pointer;">
            Semua Video ({{ count($videos) }})
        </button>
        <button type="button" class="btn" style="background: #f1f5fa; color: #475569; border: none; padding: 8px 16px; border-radius: 8px; font-size: 13px; font-weight: 600; cursor: pointer;">
            Matematika
        </button>
        <button type="button" class="btn" style="background: #f1f5fa; color: #475569; border: none; padding: 8px 16px; border-radius: 8px; font-size: 13px; font-weight: 600; cursor: pointer;">
            Sains & IPA
        </button>
        <button type="button" class="btn" style="background: #f1f5fa; color: #475569; border: none; padding: 8px 16px; border-radius: 8px; font-size: 13px; font-weight: 600; cursor: pointer;">
            Tematik / PPKn
        </button>
    </div>

    <button type="button" onclick="alert('Fitur tambah video edukasi baru siap digunakan.');" style="background: #8b5cf6; color: white; border: none; padding: 10px 20px; border-radius: 9px; font-weight: 700; font-size: 13px; cursor: pointer; display: inline-flex; align-items: center; gap: 8px; box-shadow: 0 4px 12px rgba(139, 92, 246, 0.25);">
        <i class="fa-solid fa-video"></i> Tambah Video Baru
    </button>
</div>

<!-- FEATURED VIDEO PLAYER -->
<div class="section-card video-section" style="margin-bottom: 30px;">
    <div class="section-header">
        <div class="section-title">
            <div class="title-icon purple-icon">
                <i class="fa-solid fa-circle-play"></i>
            </div>
            <div>
                <h2>Video Unggulan: {{ $videos[0]['title'] }}</h2>
                <p>Materi inti semester ganjil untuk pendalaman konsep belajar siswa.</p>
            </div>
        </div>
        <span style="background: #f3e8ff; color: #7e22ce; padding: 4px 12px; border-radius: 20px; font-size: 0.8rem; font-weight: 700;">
            {{ $videos[0]['duration'] }} Menit
        </span>
    </div>

    <div class="video-player">
        <div class="video-thumbnail">
            <div class="video-content">
                <div class="video-teacher">
                    <div class="person-head"></div>
                    <div class="person-body"></div>
                </div>

                <div class="whiteboard">
                    <h3>{{ $videos[0]['subject'] }}</h3>
                    <p>Pembelajaran Interaktif</p>
                    <span>SD NEGERI LAMA</span>
                </div>
            </div>

            <button class="play-button" id="btnPlayVideoPage">
                <i class="fa-solid fa-play"></i>
            </button>

            <div class="video-controls">
                <div class="progress">
                    <span style="width: 35%;"></span>
                </div>
                <div class="control-bottom">
                    <span>
                        <i class="fa-solid fa-play"></i> 03:40 / {{ $videos[0]['duration'] }}
                    </span>
                    <span>
                        <i class="fa-solid fa-volume-high"></i>
                        <i class="fa-solid fa-gear"></i>
                        <i class="fa-solid fa-expand"></i>
                    </span>
                </div>
            </div>
        </div>
    </div>

    <div class="video-info">
        <h3>{{ $videos[0]['title'] }}</h3>
        <p>{{ $videos[0]['desc'] }}</p>
        <div class="video-bottom">
            <div class="tags">
                <span>{{ $videos[0]['subject'] }}</span>
                <span>{{ $videos[0]['class'] }}</span>
                <span><i class="fa-regular fa-eye"></i> {{ $videos[0]['views'] }}x Ditonton</span>
                <span><i class="fa-regular fa-clock"></i> {{ $videos[0]['duration'] }}</span>
            </div>
        </div>
    </div>
</div>

<!-- MORE VIDEOS LIST -->
<h2 style="font-size: 1.3rem; font-weight: 800; color: var(--text); margin-bottom: 18px;">
    <i class="fa-solid fa-film" style="color: var(--primary);"></i> Daftar Koleksi Video Lainnya
</h2>

<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 20px; margin-bottom: 30px;">
    @foreach($videos as $vid)
    <div class="section-card" style="display: flex; flex-direction: column; justify-content: space-between;">
        <div>
            <div style="position: relative; border-radius: 12px; height: 160px; background: linear-gradient(135deg, #1e3a8a, #3b82f6); display: flex; align-items: center; justify-content: center; color: white; margin-bottom: 14px; overflow: hidden;">
                <div style="text-align: center;">
                    <i class="fa-solid fa-circle-play" style="font-size: 2.8rem; opacity: 0.9;"></i>
                    <div style="font-size: 0.85rem; font-weight: 700; margin-top: 6px;">{{ $vid['subject'] }}</div>
                </div>
                <span style="position: absolute; bottom: 10px; right: 10px; background: rgba(0,0,0,0.7); color: #fff; padding: 2px 8px; border-radius: 6px; font-size: 0.75rem; font-weight: 700;">
                    {{ $vid['duration'] }}
                </span>
            </div>

            <span style="background: #e0f2fe; color: #0369a1; padding: 2px 10px; border-radius: 15px; font-size: 0.75rem; font-weight: 700;">
                {{ $vid['class'] }} • {{ $vid['subject'] }}
            </span>
            <h3 style="font-size: 1.05rem; font-weight: 700; color: var(--text); margin: 8px 0 6px 0; line-height: 1.4;">{{ $vid['title'] }}</h3>
            <p style="font-size: 0.85rem; color: var(--muted); line-height: 1.5; margin-bottom: 10px;">{{ $vid['desc'] }}</p>
        </div>

        <div style="display: flex; align-items: center; justify-content: space-between; border-top: 1px solid var(--border); padding-top: 12px; margin-top: 6px;">
            <span style="font-size: 0.8rem; color: var(--muted);"><i class="fa-solid fa-eye"></i> {{ $vid['views'] }} tayangan</span>
            <button type="button" onclick="alert('Memutar video: {{ $vid['title'] }}');" class="watch-button" style="padding: 6px 14px; font-size: 12px;">
                <i class="fa-solid fa-play"></i> Putar Video
            </button>
        </div>
    </div>
    @endforeach
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const btnPlay = document.getElementById("btnPlayVideoPage");
        if (btnPlay) {
            btnPlay.addEventListener("click", function () {
                this.classList.toggle("playing");
                if (this.classList.contains("playing")) {
                    this.innerHTML = '<i class="fa-solid fa-pause"></i>';
                } else {
                    this.innerHTML = '<i class="fa-solid fa-play"></i>';
                }
            });
        }
    });
</script>
@endsection
