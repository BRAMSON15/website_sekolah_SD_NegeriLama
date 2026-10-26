@extends('layouts.guru')

@section('title', 'Materi Pembelajaran - ' . ($settings['school_name'] ?? 'SD Negeri Negeri Lama'))

@section('content')
<!-- NOTIFICATION ALERTS -->
@if(session('success'))
<div style="background: #dcfce7; border: 1px solid #86efac; color: #166534; padding: 11px 14px; border-radius: 10px; margin-bottom: 16px; display: flex; align-items: center; gap: 10px; font-weight: 600; box-shadow: 0 2px 8px rgba(22, 163, 74, 0.08); @media (max-width: 576px) { padding: 8px 10px; margin-bottom: 12px; font-size: 0.85rem; }">
    <i class="fa-solid fa-circle-check" style="font-size: 1.1rem; color: #16a34a;"></i>
    <span>{{ session('success') }}</span>
</div>
@endif

@if(isset($errors) && $errors->any())
<div style="background: #fee2e2; border: 1px solid #fca5a5; color: #991b1b; padding: 11px 14px; border-radius: 10px; margin-bottom: 16px; @media (max-width: 576px) { padding: 8px 10px; margin-bottom: 12px; }">
    <div style="font-weight: 700; margin-bottom: 5px; display: flex; align-items: center; gap: 8px; @media (max-width: 576px) { font-size: 0.9rem; }">
        <i class="fa-solid fa-circle-exclamation"></i> Terjadi kesalahan upload:
    </div>
    <ul style="margin: 0; padding-left: 18px; font-size: 0.88rem; @media (max-width: 576px) { font-size: 0.8rem; }">
        @foreach($errors->all() as $err)
            <li>{{ $err }}</li>
        @endforeach
    </ul>
</div>
@endif

<!-- BREADCRUMB / HERO -->
<div class="welcome" style="margin-bottom: 18px;">
    <div class="welcome-text">
        <h1 style="@media (max-width: 576px) { font-size: 1.3rem; margin-bottom: 6px; }">
            <i class="fa-solid fa-book-open"></i> Materi Pembelajaran
        </h1>
        <p style="@media (max-width: 576px) { font-size: 0.85rem; }">
            Kelola modul digital, lembar kerja siswa (LKS), rangkuman bahan ajar, dan media pembelajaran interaktif.
        </p>
    </div>
    <div class="teacher-illustration" style="@media (max-width: 576px) { display: none; }">
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
<div class="section-card" style="margin-bottom: 18px; padding: 14px 16px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 12px; @media (max-width: 576px) { padding: 10px 12px; gap: 8px; flex-direction: column; align-items: flex-start; }">
    @php
        $currClass = request('class', '');
    @endphp
    <div style="display: flex; gap: 6px; flex-wrap: wrap; align-items: center; @media (max-width: 576px) { gap: 4px; width: 100%; }">
        <a href="{{ route('guru.materi') }}" style="padding: 7px 12px; border-radius: 7px; font-size: 12px; font-weight: 700; text-decoration: none; {{ empty($currClass) ? 'background: #2875dc; color: #fff;' : 'background: #f1f5fa; color: #475569;' }} @media (max-width: 576px) { font-size: 11px; padding: 6px 10px; }">
            Semua ({{ \App\Models\LearningMaterial::count() }})
        </a>
        @foreach($classOptions as $classOption)
        <a href="{{ route('guru.materi', ['class' => $classOption]) }}" style="padding: 7px 12px; border-radius: 7px; font-size: 12px; font-weight: 600; text-decoration: none; {{ $currClass === $classOption ? 'background: #2875dc; color: #fff;' : 'background: #f1f5fa; color: #475569;' }} @media (max-width: 576px) { font-size: 11px; padding: 6px 10px; }">
            {{ $classOption }}
        </a>
        @endforeach
    </div>

    <div style="display: flex; align-items: center; gap: 8px; @media (max-width: 576px) { width: 100%; gap: 6px; }">
        <form action="{{ route('guru.materi') }}" method="GET" style="display: flex; align-items: center; background: var(--background); border: 1px solid var(--border); border-radius: 7px; padding: 3px 10px; @media (max-width: 576px) { flex: 1; padding: 2px 8px; }">
            @if($currClass)
                <input type="hidden" name="class" value="{{ $currClass }}">
            @endif
            <i class="fa-solid fa-magnifying-glass" style="color: var(--muted); margin-right: 6px; font-size: 0.8rem;"></i>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari materi..." style="border: none; background: transparent; outline: none; font-size: 0.82rem; width: 120px; color: var(--text); @media (max-width: 576px) { font-size: 0.8rem; width: auto; flex: 1; }">
        </form>

        <button type="button" onclick="openModalMateri()" style="background: #16a34a; color: white; border: none; padding: 8px 14px; border-radius: 7px; font-weight: 700; font-size: 12px; cursor: pointer; display: inline-flex; align-items: center; gap: 6px; box-shadow: 0 2px 8px rgba(22, 163, 74, 0.2); @media (max-width: 576px) { font-size: 11px; padding: 7px 10px; gap: 4px; }">
            <i class="fa-solid fa-cloud-arrow-up"></i> Unggah Materi
        </button>
    </div>
</div>

<!-- MATERIALS GRID -->
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 16px; margin-bottom: 24px; @media (max-width: 576px) { grid-template-columns: 1fr; gap: 12px; }">
    @forelse($materials as $mat)
    <div class="section-card" style="display: flex; flex-direction: column; justify-content: space-between; transition: transform 0.2s; @media (max-width: 576px) { padding: 12px; }" onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='none'">
        <div>
            <div style="display: flex; align-items: flex-start; gap: 12px; margin-bottom: 10px; @media (max-width: 576px) { gap: 10px; }">
                <div style="width: 48px; height: 48px; border-radius: 10px; background: #f8fafc; border: 1px solid var(--border); display: flex; align-items: center; justify-content: center; font-size: 1.4rem; color: {{ $mat->icon_color }}; flex-shrink: 0;">
                    <i class="{{ $mat->icon }}"></i>
                </div>
                <div style="flex: 1; min-width: 0;">
                    <span style="display: inline-block; background: #e0f2fe; color: #0369a1; padding: 2px 8px; border-radius: 12px; font-size: 0.7rem; font-weight: 700; margin-bottom: 3px; @media (max-width: 576px) { font-size: 0.65rem; padding: 1px 6px; }">
                        {{ $mat->class_level }} • {{ $mat->subject }}
                    </span>
                    <h3 style="font-size: 0.98rem; font-weight: 700; color: var(--text); margin-bottom: 3px; line-height: 1.3; @media (max-width: 576px) { font-size: 0.9rem; }">{{ $mat->title }}</h3>
                    <p style="font-size: 0.75rem; color: var(--muted); margin: 0 0 6px 0; @media (max-width: 576px) { font-size: 0.72rem; }">
                        {{ $mat->file_type }} • {{ $mat->file_size }} • {{ $mat->created_at ? $mat->created_at->format('d M Y') : '-' }}
                    </p>
                    <p style="font-size: 0.8rem; color: #475569; line-height: 1.3; margin: 0; @media (max-width: 576px) { font-size: 0.75rem; }">
                        {{ Str::limit($mat->description, 90) }}
                    </p>
                </div>
            </div>
        </div>

        <div style="display: flex; align-items: center; justify-content: space-between; border-top: 1px solid var(--border); padding-top: 10px; margin-top: 8px; @media (max-width: 576px) { padding-top: 8px; margin-top: 6px; }">
            <span style="font-size: 0.78rem; color: var(--muted); @media (max-width: 576px) { font-size: 0.72rem; }">
                <i class="fa-solid fa-download"></i> {{ $mat->downloads }}x
            </span>
            <div style="display: flex; gap: 6px; @media (max-width: 576px) { gap: 4px; }">
                <a href="{{ route('guru.materi.download', $mat->id) }}" style="background: #2875dc; color: #fff; text-decoration: none; padding: 5px 11px; border-radius: 6px; font-size: 11px; font-weight: 700; display: inline-flex; align-items: center; gap: 5px; @media (max-width: 576px) { font-size: 10px; padding: 4px 8px; }">
                    <i class="fa-solid fa-download"></i> Unduh
                </a>
                <form action="{{ route('guru.materi.destroy', $mat->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus materi ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" style="background: #fee2e2; color: #dc2626; border: none; padding: 5px 9px; border-radius: 6px; font-size: 11px; font-weight: 700; cursor: pointer; @media (max-width: 576px) { font-size: 10px; padding: 4px 7px; }" title="Hapus Materi">
                        <i class="fa-solid fa-trash-can"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>
    @empty
    <div class="section-card" style="grid-column: 1 / -1; padding: 30px 20px; text-align: center; color: var(--muted); @media (max-width: 576px) { padding: 20px 14px; }">
        <i class="fa-solid fa-folder-open" style="font-size: 2rem; margin-bottom: 10px; color: #cbd5e1; display: block; @media (max-width: 576px) { font-size: 1.6rem; margin-bottom: 8px; }"></i>
        <h3 style="font-size: 1rem; color: var(--text); margin-bottom: 5px; @media (max-width: 576px) { font-size: 0.95rem; }">Belum Ada Materi Pembelajaran</h3>
        <p style="font-size: 0.88rem; margin-bottom: 12px; @media (max-width: 576px) { font-size: 0.82rem; margin-bottom: 10px; }">Klik tombol "Unggah Materi" di atas untuk menambahkan bahan ajar.</p>
        <button type="button" onclick="openModalMateri()" style="background: #16a34a; color: white; border: none; padding: 8px 16px; border-radius: 7px; font-weight: 700; font-size: 12px; cursor: pointer; @media (max-width: 576px) { font-size: 11px; padding: 7px 12px; }">
            <i class="fa-solid fa-plus"></i> Unggah Materi Pertama
        </button>
    </div>
    @endforelse
</div>

<!-- MODAL UNGGAH MATERI -->
<div id="modalMateri" class="modal-overlay">
    <div class="modal-dialog" style="@media (max-width: 576px) { width: 90%; max-height: 80vh; }">
        <div class="modal-header" style="background: #2875dc; @media (max-width: 576px) { padding: 12px 14px; }">
            <div style="display: flex; align-items: center; gap: 8px; font-weight: 700; font-size: 1rem; @media (max-width: 576px) { font-size: 0.95rem; gap: 6px; }">
                <i class="fa-solid fa-cloud-arrow-up"></i> Unggah Materi Baru
            </div>
            <button type="button" onclick="closeModalMateri()" style="background: transparent; border: none; color: #ffffff; font-size: 1.2rem; cursor: pointer; line-height: 1;">×</button>
        </div>

        <form action="{{ route('guru.materi.store') }}" method="POST" enctype="multipart/form-data" class="modal-body-scroll" style="@media (max-width: 576px) { padding: 12px; }">
            @csrf
            <div style="margin-bottom: 12px;">
                <label style="display: block; font-size: 0.82rem; font-weight: 700; color: #334155; margin-bottom: 5px; @media (max-width: 576px) { font-size: 0.78rem; }">Judul Materi / Modul *</label>
                <input type="text" name="title" required placeholder="Contoh: Modul Matematika Pecahan" style="width: 100%; padding: 9px 11px; border: 1px solid #cbd5e1; border-radius: 7px; font-size: 0.88rem; outline: none; box-sizing: border-box; @media (max-width: 576px) { font-size: 0.85rem; padding: 8px 10px; }">
            </div>

            <div class="modal-form-row" style="@media (max-width: 576px) { display: flex; flex-direction: column; gap: 10px; }">
                <div style="@media (max-width: 576px) { width: 100%; }">
                    <label style="display: block; font-size: 0.82rem; font-weight: 700; color: #334155; margin-bottom: 5px; @media (max-width: 576px) { font-size: 0.78rem; }">Mata Pelajaran *</label>
                    <input type="text" name="subject" required placeholder="Contoh: Matematika" value="{{ Auth::user()->subject ?: 'Matematika' }}" style="width: 100%; padding: 9px 11px; border: 1px solid #cbd5e1; border-radius: 7px; font-size: 0.88rem; outline: none; box-sizing: border-box; @media (max-width: 576px) { font-size: 0.85rem; padding: 8px 10px; }">
                </div>
                <div style="@media (max-width: 576px) { width: 100%; }">
                    <label style="display: block; font-size: 0.82rem; font-weight: 700; color: #334155; margin-bottom: 5px; @media (max-width: 576px) { font-size: 0.78rem; }">Tingkat Kelas *</label>
                    <select name="class_level" required style="width: 100%; padding: 9px 11px; border: 1px solid #cbd5e1; border-radius: 7px; font-size: 0.88rem; outline: none; background: #fff; box-sizing: border-box; @media (max-width: 576px) { font-size: 0.85rem; padding: 8px 10px; }">
                        @forelse($classOptions as $classOption)
                        <option value="{{ $classOption }}" {{ old('class_level', $classOptions->first()) === $classOption ? 'selected' : '' }}>{{ $classOption }}</option>
                        @empty
                        <option value="" selected disabled>Buat kelas terlebih dahulu</option>
                        @endforelse
                    </select>
                </div>
            </div>

            <div style="margin-bottom: 12px;">
                <label style="display: block; font-size: 0.82rem; font-weight: 700; color: #334155; margin-bottom: 5px; @media (max-width: 576px) { font-size: 0.78rem; }">Berkas File (PDF, DOCX, PPTX - Max 10MB)</label>
                <input type="file" name="materi_file" style="width: 100%; padding: 7px; border: 1px dashed #94a3b8; border-radius: 7px; font-size: 0.82rem; background: #f8fafc; box-sizing: border-box; @media (max-width: 576px) { font-size: 0.8rem; padding: 6px; }">
            </div>

            <div style="margin-bottom: 16px;">
                <label style="display: block; font-size: 0.82rem; font-weight: 700; color: #334155; margin-bottom: 5px; @media (max-width: 576px) { font-size: 0.78rem; }">Deskripsi / Petunjuk Belajar</label>
                <textarea name="description" rows="3" placeholder="Jelaskan ringkasan materi..." style="width: 100%; padding: 9px 11px; border: 1px solid #cbd5e1; border-radius: 7px; font-size: 0.88rem; outline: none; box-sizing: border-box; resize: vertical; @media (max-width: 576px) { font-size: 0.85rem; padding: 8px 10px; rows: 2; }"></textarea>
            </div>

            <div style="display: flex; justify-content: flex-end; gap: 8px; @media (max-width: 576px) { flex-direction: column; }">
                <button type="button" onclick="closeModalMateri()" style="padding: 8px 14px; border: 1px solid #cbd5e1; background: #f1f5fa; color: #475569; border-radius: 7px; font-weight: 700; font-size: 12px; cursor: pointer; @media (max-width: 576px) { font-size: 11px; padding: 7px 12px; order: 2; }">
                    Batal
                </button>
                @if($classOptions->isEmpty())
                <a href="{{ route('guru.kelas.create') }}" style="padding: 8px 12px; background: #eff6ff; color: #1d4ed8; border-radius: 7px; font-weight: 700; font-size: 12px; text-decoration: none; @media (max-width: 576px) { font-size: 11px; padding: 7px 10px; }">Buat kelas</a>
                @endif
                <button type="submit" {{ $classOptions->isEmpty() ? 'disabled' : '' }} style="padding: 8px 16px; background: {{ $classOptions->isEmpty() ? '#94a3b8' : '#16a34a' }}; border: none; color: #ffffff; border-radius: 7px; font-weight: 700; font-size: 12px; cursor: {{ $classOptions->isEmpty() ? 'not-allowed' : 'pointer' }}; display: inline-flex; align-items: center; gap: 6px; @media (max-width: 576px) { font-size: 11px; padding: 7px 12px; gap: 4px; width: 100%; justify-content: center; order: 1; }">
                    <i class="fa-solid fa-cloud-arrow-up"></i> Simpan & Unggah
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script src="{{ asset('mentahan2/js/guru-materi.js') }}?v={{ filemtime(public_path('mentahan2/js/guru-materi.js')) ?: time() }}"></script>
@endsection
