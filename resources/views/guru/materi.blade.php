@extends('layouts.guru')

@section('title', 'Materi Pembelajaran - ' . ($settings['school_name'] ?? 'SD NEGERI LAMA'))

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
        <i class="fa-solid fa-circle-exclamation"></i> Terjadi kesalahan upload:
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
    @php
        $currClass = request('class', '');
    @endphp
    <div style="display: flex; gap: 8px; flex-wrap: wrap; align-items: center;">
        <a href="{{ route('guru.materi') }}" style="padding: 8px 16px; border-radius: 8px; font-size: 13px; font-weight: 700; text-decoration: none; {{ empty($currClass) ? 'background: #2875dc; color: #fff;' : 'background: #f1f5fa; color: #475569;' }}">
            Semua ({{ \App\Models\LearningMaterial::count() }})
        </a>
        <a href="{{ route('guru.materi', ['class' => 'Kelas 4A']) }}" style="padding: 8px 16px; border-radius: 8px; font-size: 13px; font-weight: 600; text-decoration: none; {{ $currClass === 'Kelas 4A' ? 'background: #2875dc; color: #fff;' : 'background: #f1f5fa; color: #475569;' }}">
            Kelas 4A
        </a>
        <a href="{{ route('guru.materi', ['class' => 'Kelas 5A']) }}" style="padding: 8px 16px; border-radius: 8px; font-size: 13px; font-weight: 600; text-decoration: none; {{ $currClass === 'Kelas 5A' ? 'background: #2875dc; color: #fff;' : 'background: #f1f5fa; color: #475569;' }}">
            Kelas 5A
        </a>
        <a href="{{ route('guru.materi', ['class' => 'Kelas 6B']) }}" style="padding: 8px 16px; border-radius: 8px; font-size: 13px; font-weight: 600; text-decoration: none; {{ $currClass === 'Kelas 6B' ? 'background: #2875dc; color: #fff;' : 'background: #f1f5fa; color: #475569;' }}">
            Kelas 6B
        </a>
    </div>

    <div style="display: flex; align-items: center; gap: 10px;">
        <form action="{{ route('guru.materi') }}" method="GET" style="display: flex; align-items: center; background: var(--background); border: 1px solid var(--border); border-radius: 8px; padding: 4px 12px;">
            @if($currClass)
                <input type="hidden" name="class" value="{{ $currClass }}">
            @endif
            <i class="fa-solid fa-magnifying-glass" style="color: var(--muted); margin-right: 8px; font-size: 0.85rem;"></i>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari materi..." style="border: none; background: transparent; outline: none; font-size: 0.85rem; width: 130px; color: var(--text);">
        </form>

        <button type="button" onclick="openModalMateri()" style="background: #16a34a; color: white; border: none; padding: 10px 18px; border-radius: 9px; font-weight: 700; font-size: 13px; cursor: pointer; display: inline-flex; align-items: center; gap: 8px; box-shadow: 0 4px 12px rgba(22, 163, 74, 0.2);">
            <i class="fa-solid fa-cloud-arrow-up"></i> Unggah Materi Baru
        </button>
    </div>
</div>

<!-- MATERIALS GRID -->
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 20px; margin-bottom: 30px;">
    @forelse($materials as $mat)
    <div class="section-card" style="display: flex; flex-direction: column; justify-content: space-between; transition: transform 0.2s;" onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='none'">
        <div>
            <div style="display: flex; align-items: flex-start; gap: 16px; margin-bottom: 14px;">
                <div style="width: 50px; height: 50px; border-radius: 12px; background: #f8fafc; border: 1px solid var(--border); display: flex; align-items: center; justify-content: center; font-size: 1.6rem; color: {{ $mat->icon_color }}; flex-shrink: 0;">
                    <i class="{{ $mat->icon }}"></i>
                </div>
                <div style="flex: 1; min-width: 0;">
                    <span style="display: inline-block; background: #e0f2fe; color: #0369a1; padding: 2px 10px; border-radius: 15px; font-size: 0.75rem; font-weight: 700; margin-bottom: 4px;">
                        {{ $mat->class_level }} • {{ $mat->subject }}
                    </span>
                    <h3 style="font-size: 1.05rem; font-weight: 700; color: var(--text); margin-bottom: 4px; line-height: 1.4;">{{ $mat->title }}</h3>
                    <p style="font-size: 0.8rem; color: var(--muted); margin: 0 0 8px 0;">
                        {{ $mat->file_type }} • {{ $mat->file_size }} • {{ $mat->created_at ? $mat->created_at->format('d M Y') : '-' }}
                    </p>
                    <p style="font-size: 0.83rem; color: #475569; line-height: 1.4; margin: 0;">
                        {{ Str::limit($mat->description, 90) }}
                    </p>
                </div>
            </div>
        </div>

        <div style="display: flex; align-items: center; justify-content: space-between; border-top: 1px solid var(--border); padding-top: 14px; margin-top: 10px;">
            <span style="font-size: 0.82rem; color: var(--muted);">
                <i class="fa-solid fa-download"></i> {{ $mat->downloads }}x diunduh
            </span>
            <div style="display: flex; gap: 8px;">
                <a href="{{ route('guru.materi.download', $mat->id) }}" style="background: #2875dc; color: #fff; text-decoration: none; padding: 6px 14px; border-radius: 7px; font-size: 12px; font-weight: 700; display: inline-flex; align-items: center; gap: 6px;">
                    <i class="fa-solid fa-download"></i> Unduh
                </a>
                <form action="{{ route('guru.materi.destroy', $mat->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus materi ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" style="background: #fee2e2; color: #dc2626; border: none; padding: 6px 10px; border-radius: 7px; font-size: 12px; font-weight: 700; cursor: pointer;" title="Hapus Materi">
                        <i class="fa-solid fa-trash-can"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>
    @empty
    <div class="section-card" style="grid-column: 1 / -1; padding: 40px; text-align: center; color: var(--muted);">
        <i class="fa-solid fa-folder-open" style="font-size: 2.5rem; margin-bottom: 12px; color: #cbd5e1; display: block;"></i>
        <h3 style="font-size: 1.1rem; color: var(--text); margin-bottom: 6px;">Belum Ada Materi Pembelajaran</h3>
        <p style="font-size: 0.9rem; margin-bottom: 16px;">Klik tombol "Unggah Materi Baru" di atas untuk menambahkan bahan ajar.</p>
        <button type="button" onclick="openModalMateri()" style="background: #16a34a; color: white; border: none; padding: 10px 20px; border-radius: 8px; font-weight: 700; font-size: 13px; cursor: pointer;">
            <i class="fa-solid fa-plus"></i> Unggah Materi Pertama
        </button>
    </div>
    @endforelse
</div>

<!-- MODAL UNGGAH MATERI -->
<div id="modalMateri" class="modal-overlay">
    <div class="modal-dialog">
        <div class="modal-header" style="background: #2875dc;">
            <div style="display: flex; align-items: center; gap: 10px; font-weight: 700; font-size: 1.1rem;">
                <i class="fa-solid fa-cloud-arrow-up"></i> Unggah Materi Baru
            </div>
            <button type="button" onclick="closeModalMateri()" style="background: transparent; border: none; color: #ffffff; font-size: 1.4rem; cursor: pointer; line-height: 1;">&times;</button>
        </div>

        <form action="{{ route('guru.materi.store') }}" method="POST" enctype="multipart/form-data" class="modal-body-scroll">
            @csrf
            <div style="margin-bottom: 16px;">
                <label style="display: block; font-size: 0.88rem; font-weight: 700; color: #334155; margin-bottom: 6px;">Judul Materi / Modul *</label>
                <input type="text" name="title" required placeholder="Contoh: Modul Matematika Pecahan & Desimal" style="width: 100%; padding: 10px 14px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 0.9rem; outline: none; box-sizing: border-box;">
            </div>

            <div class="modal-form-row">
                <div>
                    <label style="display: block; font-size: 0.88rem; font-weight: 700; color: #334155; margin-bottom: 6px;">Mata Pelajaran *</label>
                    <input type="text" name="subject" required placeholder="Contoh: Matematika" value="{{ Auth::user()->subject ?: 'Matematika' }}" style="width: 100%; padding: 10px 14px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 0.9rem; outline: none; box-sizing: border-box;">
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
                <label style="display: block; font-size: 0.88rem; font-weight: 700; color: #334155; margin-bottom: 6px;">Berkas File (PDF, DOCX, PPTX - Max 10MB)</label>
                <input type="file" name="materi_file" style="width: 100%; padding: 8px; border: 1px dashed #94a3b8; border-radius: 8px; font-size: 0.85rem; background: #f8fafc; box-sizing: border-box;">
            </div>

            <div style="margin-bottom: 22px;">
                <label style="display: block; font-size: 0.88rem; font-weight: 700; color: #334155; margin-bottom: 6px;">Deskripsi / Petunjuk Belajar</label>
                <textarea name="description" rows="3" placeholder="Jelaskan ringkasan materi atau petunjuk belajar bagi siswa..." style="width: 100%; padding: 10px 14px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 0.9rem; outline: none; box-sizing: border-box; resize: vertical;"></textarea>
            </div>

            <div style="display: flex; justify-content: flex-end; gap: 10px;">
                <button type="button" onclick="closeModalMateri()" style="padding: 10px 18px; border: 1px solid #cbd5e1; background: #f1f5fa; color: #475569; border-radius: 8px; font-weight: 700; font-size: 13px; cursor: pointer;">
                    Batal
                </button>
                <button type="submit" style="padding: 10px 22px; background: #16a34a; border: none; color: #ffffff; border-radius: 8px; font-weight: 700; font-size: 13px; cursor: pointer; display: inline-flex; align-items: center; gap: 8px;">
                    <i class="fa-solid fa-cloud-arrow-up"></i> Simpan & Unggah
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function openModalMateri() {
        const modal = document.getElementById('modalMateri');
        modal.style.display = 'flex';
    }

    function closeModalMateri() {
        const modal = document.getElementById('modalMateri');
        modal.style.display = 'none';
    }

    // Close when clicking backdrop
    window.addEventListener('click', function(e) {
        const modal = document.getElementById('modalMateri');
        if (e.target === modal) {
            closeModalMateri();
        }
    });
</script>
@endsection
