@extends('layouts.guru')

@section('title', 'Materi Pembelajaran - ' . ($settings['school_name'] ?? 'SD NEGERI LAMA'))

@section('content')
<!-- BREADCRUMB / HERO -->
<div class="welcome" style="margin-bottom: 25px;">
    <div class="welcome-text">
        <h1>
            <i class="fa-solid fa-book-open"></i> Materi Pembelajaran
        </h1>
        <p>
            Kelola modul digital, lembar kerja siswa (LKS), rangkuman bahan ajar, dan media pembelajaran interaktif.
        </p>
    </div>
    <div class="teacher-illustration">
        <div class="teacher">
            <div class="teacher-head"></div>
            <div class="teacher-body"></div>
        </div>
        <div class="board">
            <span>{{ count($materials) }} Berkas</span>
            <small>Tersedia Online</small>
        </div>
    </div>
</div>

<!-- ACTIONS BAR -->
<div class="section-card" style="margin-bottom: 25px; padding: 18px 24px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 15px;">
    <div style="display: flex; gap: 10px; flex-wrap: wrap;">
        <button type="button" class="btn" style="background: #2875dc; color: #fff; border: none; padding: 8px 16px; border-radius: 8px; font-size: 13px; font-weight: 700; cursor: pointer;">
            Semua Materi ({{ count($materials) }})
        </button>
        <button type="button" class="btn" style="background: #f1f5fa; color: #475569; border: none; padding: 8px 16px; border-radius: 8px; font-size: 13px; font-weight: 600; cursor: pointer;">
            Kelas 4
        </button>
        <button type="button" class="btn" style="background: #f1f5fa; color: #475569; border: none; padding: 8px 16px; border-radius: 8px; font-size: 13px; font-weight: 600; cursor: pointer;">
            Kelas 5
        </button>
        <button type="button" class="btn" style="background: #f1f5fa; color: #475569; border: none; padding: 8px 16px; border-radius: 8px; font-size: 13px; font-weight: 600; cursor: pointer;">
            Kelas 6
        </button>
    </div>

    <button type="button" onclick="alert('Fitur upload berkas materi baru siap digunakan.');" style="background: #16a34a; color: white; border: none; padding: 10px 20px; border-radius: 9px; font-weight: 700; font-size: 13px; cursor: pointer; display: inline-flex; align-items: center; gap: 8px; box-shadow: 0 4px 12px rgba(22, 163, 74, 0.2);">
        <i class="fa-solid fa-cloud-arrow-up"></i> Unggah Materi Baru
    </button>
</div>

<!-- MATERIALS GRID -->
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 20px; margin-bottom: 30px;">
    @foreach($materials as $mat)
    <div class="section-card" style="display: flex; flex-direction: column; justify-content: space-between; transition: transform 0.2s;" onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='none'">
        <div>
            <div style="display: flex; align-items: flex-start; gap: 16px; margin-bottom: 14px;">
                <div style="width: 50px; height: 50px; border-radius: 12px; background: #f8fafc; border: 1px solid var(--border); display: flex; align-items: center; justify-content: center; font-size: 1.6rem; color: {{ $mat['color'] }}; flex-shrink: 0;">
                    <i class="{{ $mat['icon'] }}"></i>
                </div>
                <div style="flex: 1; min-width: 0;">
                    <span style="display: inline-block; background: #e0f2fe; color: #0369a1; padding: 2px 10px; border-radius: 15px; font-size: 0.75rem; font-weight: 700; margin-bottom: 4px;">
                        {{ $mat['class'] }} • {{ $mat['subject'] }}
                    </span>
                    <h3 style="font-size: 1.05rem; font-weight: 700; color: var(--text); margin-bottom: 4px; line-height: 1.4;">{{ $mat['title'] }}</h3>
                    <p style="font-size: 0.8rem; color: var(--muted); margin: 0;">
                        {{ $mat['type'] }} • {{ $mat['size'] }} • Diunggah: {{ $mat['date'] }}
                    </p>
                </div>
            </div>
        </div>

        <div style="display: flex; align-items: center; justify-content: space-between; border-top: 1px solid var(--border); padding-top: 14px; margin-top: 10px;">
            <span style="font-size: 0.82rem; color: var(--muted);">
                <i class="fa-solid fa-download"></i> {{ $mat['downloads'] }}x diunduh
            </span>
            <div style="display: flex; gap: 8px;">
                <button type="button" onclick="alert('Mengunduh materi: {{ $mat['title'] }}');" style="background: #2875dc; color: #fff; border: none; padding: 6px 14px; border-radius: 7px; font-size: 12px; font-weight: 700; cursor: pointer; display: inline-flex; align-items: center; gap: 6px;">
                    <i class="fa-solid fa-download"></i> Unduh
                </button>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endsection
