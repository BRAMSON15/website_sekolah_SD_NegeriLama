@extends('layouts.admin')

@section('title', 'Kelola Konten Akademik - ' . ($settings['school_name'] ?? 'SD Negeri Lama'))

@section('content')
<div class="information-home">
    <div class="information-hero">
        <div>
            <span class="panel-eyebrow">KELOLA WEBSITE / AKADEMIK</span>
            <h2>Kelola Konten Akademik & Kurikulum</h2>
            <p>Atur informasi kurikulum pembelajaran dan daftar kegiatan ekstrakurikuler sekolah.</p>
        </div>
        <div style="display: flex; gap: 10px; align-items: center;">
            <a href="{{ route('akademik') }}" target="_blank" class="btn btn-secondary" style="background: rgba(255, 255, 255, 0.2); color: #ffffff; border: 1px solid rgba(255, 255, 255, 0.4); text-decoration: none; padding: 10px 18px; border-radius: 8px; font-weight: 600; display: inline-flex; align-items: center; gap: 8px;">
                <i class="fa-solid fa-arrow-up-right-from-square"></i> Lihat Halaman Akademik
            </a>
        </div>
    </div>

    @if(session('success'))
    <div style="background: #ecfdf5; border-left: 4px solid #10b981; color: #065f46; padding: 14px 18px; border-radius: 9px; margin-bottom: 20px; display: flex; align-items: center; gap: 10px;">
        <i class="fa-solid fa-circle-check" style="font-size: 1.2rem;"></i>
        <span>{{ session('success') }}</span>
    </div>
    @endif

    @if (isset($errors) && $errors->any())
    <div style="background: #fef2f2; border-left: 4px solid #ef4444; color: #991b1b; padding: 14px 18px; border-radius: 9px; margin-bottom: 20px;">
        <strong style="display: block; margin-bottom: 6px;">Harap periksa kesalahan input berikut:</strong>
        <ul style="margin: 0; padding-left: 18px;">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('admin.website.akademik.update') }}" method="POST">
        @csrf

        <!-- Panel 1: Kurikulum -->
        <div class="information-panel">
            <div class="information-panel-heading">
                <h3><i class="fa-solid fa-book-open-reader" style="color: #1769d9;"></i> Kurikulum Pembelajaran</h3>
                <p>Informasi kurikulum yang diterapkan di sekolah saat ini</p>
            </div>
            <div class="form-group">
                <label>Nama / Judul Kurikulum</label>
                <input type="text" name="curriculum_title" class="form-control" value="{{ old('curriculum_title', $settings['curriculum_title'] ?? 'Kurikulum Merdeka') }}" required placeholder="Contoh: Kurikulum Merdeka">
                <span class="form-hint">Nama kurikulum yang ditampilkan sebagai tajuk utama di bagian akademik.</span>
            </div>
            <div class="form-group">
                <label>Deskripsi Pelaksanaan Kurikulum</label>
                @php
                    $defaultCurriculumDesc = ($settings['school_name'] ?? 'SD Negeri Lama') . " menerapkan Kurikulum Merdeka yang berfokus pada pengembangan minat, bakat, dan pembentukan Karakter Pelajar Pancasila. Sistem pembelajaran dirancang agar fleksibel dan interaktif melalui Projek Penguatan Profil Pelajar Pancasila (P5) serta penguasaan literasi dan numerasi yang berkesinambungan.";
                @endphp
                <textarea name="curriculum_desc" class="form-control" rows="5" required placeholder="Tuliskan deskripsi lengkap kurikulum...">{{ old('curriculum_desc', $settings['curriculum_desc'] ?? $defaultCurriculumDesc) }}</textarea>
                <span class="form-hint">Jelaskan fokus, metode, dan tujuan kurikulum bagi peserta didik.</span>
            </div>
        </div>

        <!-- Panel 2: Ekstrakurikuler -->
        <div class="information-panel">
            <div class="information-panel-heading">
                <h3><i class="fa-solid fa-medal" style="color: #1769d9;"></i> Ekstrakurikuler Sekolah</h3>
                <p>Wadah pengembangan bakat, kreativitas, dan keterampilan non-akademik siswa</p>
            </div>
            <div class="form-group">
                <label>Daftar Ekstrakurikuler (1 Baris per Kegiatan)</label>
                @php
                    $defaultEskul = "Pramuka (Wajib)\nSepak Bola & Futsal\nSeni Musik & Pianika\nSeni Lukis & Mewarnai\nEkskul Komputer / Coding\nPencak Silat\nBulu Tangkis\nDokter Kecil (UKS)";
                @endphp
                <textarea name="extracurriculars" class="form-control" rows="8" required placeholder="Tuliskan tiap ekstrakurikuler pada baris baru...">{{ old('extracurriculars', $settings['extracurriculars'] ?? $defaultEskul) }}</textarea>
                <span class="form-hint">💡 Tips: Tekan <strong>Enter</strong> untuk menambahkan kegiatan ekstrakurikuler baru. Tiap baris akan tampil rapi dalam kotak kartu kegiatan di halaman Akademik.</span>
            </div>
        </div>

        <div class="form-actions" style="margin-top: 25px;">
            <a href="{{ route('dashboard') }}" class="btn btn-grey">Kembali ke Dashboard</a>
            <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Simpan Perubahan Akademik</button>
        </div>
    </form>
</div>
@endsection
