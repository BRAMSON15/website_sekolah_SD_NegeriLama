@extends('layouts.admin')

@section('title', 'Kelola Konten Profil - ' . ($settings['school_name'] ?? 'SD Negeri Lama'))

@section('content')
<div class="information-home">
    <div class="information-hero">
        <div>
            <span class="panel-eyebrow">KELOLA WEBSITE / PROFIL</span>
            <h2>Kelola Konten Profil Sekolah</h2>
            <p>Atur visi, misi, sambutan kepala sekolah, dan ringkasan profil untuk halaman publik.</p>
        </div>
        <div style="display: flex; gap: 10px; align-items: center;">
            <a href="{{ route('profil') }}" target="_blank" class="btn btn-secondary" style="background: rgba(255, 255, 255, 0.2); color: #ffffff; border: 1px solid rgba(255, 255, 255, 0.4); text-decoration: none; padding: 10px 18px; border-radius: 8px; font-weight: 600; display: inline-flex; align-items: center; gap: 8px;">
                <i class="fa-solid fa-arrow-up-right-from-square"></i> Lihat Halaman Profil
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

    <form action="{{ route('admin.website.profil.update') }}" method="POST">
        @csrf

        <!-- Panel 1: Identitas Utama -->
        <div class="information-panel">
            <div class="information-panel-heading">
                <h3><i class="fa-solid fa-school" style="color: #1769d9;"></i> Identitas Sekolah</h3>
                <p>Nama dan motto resmi yang ditampilkan pada identitas website</p>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Nama Resmi Sekolah</label>
                        <input type="text" name="school_name" class="form-control" value="{{ old('school_name', $settings['school_name'] ?? 'SD NEGERI LAMA') }}" required>
                        <span class="form-hint">Contoh: SD NEGERI LAMA AMBON</span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Motto / Slogan Sekolah</label>
                        <input type="text" name="school_tagline" class="form-control" value="{{ old('school_tagline', $settings['school_tagline'] ?? 'Berilmu, Berkarakter, Berprestasi') }}">
                        <span class="form-hint">Slogan yang muncul di header atau footer website</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Panel 2: Visi & Misi -->
        <div class="information-panel">
            <div class="information-panel-heading">
                <h3><i class="fa-solid fa-bullseye" style="color: #1769d9;"></i> Visi & Misi Sekolah</h3>
                <p>Arah dan tujuan strategis pendidikan sekolah</p>
            </div>
            <div class="form-group">
                <label>Visi Sekolah</label>
                <textarea name="school_vision" class="form-control" rows="3" required placeholder="Tuliskan visi sekolah di sini...">{{ old('school_vision', $settings['school_vision'] ?? 'Terwujudnya Peserta Didik yang Bertaqwa, Berprestasi Tinggi, Berkarakter Pancasila, dan Berwawasan Lingkungan Global.') }}</textarea>
                <span class="form-hint">Visi akan ditampilkan dengan gaya kutipan utama di halaman Profil.</span>
            </div>

            <div class="form-group">
                <label>Misi Sekolah (1 Baris per Poin Misi)</label>
                @php
                    $defaultMission = "Menanamkan nilai-nilai keimanan dan ketaqwaan kepada Tuhan Yang Maha Esa melalui kegiatan keagamaan rutin.\nMenyelenggarakan proses pembelajaran yang aktif, kreatif, inovatif, dan menyenangkan berbasis teknologi informasi.\nMendorong dan memfasilitasi siswa untuk menguasai ilmu pengetahuan dan teknologi serta meraih prestasi dalam lomba akademik maupun non-akademik.\nMembentuk karakter siswa yang sopan, santun, jujur, serta memiliki kepedulian sosial dan lingkungan.";
                @endphp
                <textarea name="school_mission" class="form-control" rows="6" required placeholder="Tuliskan tiap butir misi pada baris baru...">{{ old('school_mission', $settings['school_mission'] ?? $defaultMission) }}</textarea>
                <span class="form-hint">💡 Tips: Tekan <strong>Enter</strong> untuk membuat butir poin misi baru. Tiap baris otomatis menjadi bullet point tersendiri di halaman publik.</span>
            </div>
        </div>

        <!-- Panel 3: Sambutan Kepala Sekolah -->
        <div class="information-panel">
            <div class="information-panel-heading">
                <h3><i class="fa-solid fa-user-tie" style="color: #1769d9;"></i> Sambutan Kepala Sekolah</h3>
                <p>Pesan sambutan resmi untuk menyapa pengunjung dan calon wali murid</p>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Nama Lengkap Kepala Sekolah</label>
                        <input type="text" name="principal_name" class="form-control" value="{{ old('principal_name', $settings['principal_name'] ?? 'Drs. H. Ahmad Dahlan, M.Pd.') }}" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Jabatan / Gelar</label>
                        <input type="text" name="principal_title" class="form-control" value="{{ old('principal_title', $settings['principal_title'] ?? 'Kepala Sekolah SD Negeri Lama') }}" required>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label>Isi Pesan Sambutan</label>
                <textarea name="principal_message" class="form-control" rows="5" required placeholder="Tuliskan kata sambutan kepala sekolah di sini...">{{ old('principal_message', $settings['principal_message'] ?? 'Selamat datang di SD Negeri Lama. Kami senantiasa berkomitmen untuk menciptakan lingkungan belajar yang aman, nyaman, dan menginspirasi bagi seluruh peserta didik. Dengan dukungan tenaga pendidik yang profesional serta sarana pembelajaran modern, kami siap mencetak generasi masa depan yang unggul dan berdaya saing.') }}</textarea>
                <span class="form-hint">Sambutan ini ditampilkan pada Beranda utama dan halaman Profil Sekolah.</span>
            </div>
        </div>

        <!-- Panel 4: Sejarah Singkat Sekolah -->
        <div class="information-panel">
            <div class="information-panel-heading">
                <h3><i class="fa-solid fa-landmark" style="color: #1769d9;"></i> Sejarah Singkat Sekolah (Opsional)</h3>
                <p>Cerita perjalanan dan dedikasi sekolah sejak didirikan</p>
            </div>
            <div class="form-group">
                <label>Ringkasan Sejarah</label>
                @php
                    $defaultHistory = "SD Negeri Lama didirikan dengan tekad luhur untuk mencerdaskan kehidupan bangsa di daerah ini. Berawal dari beberapa ruang kelas sederhana, sekolah kini telah berkembang pesat menjadi salah satu institusi pendidikan dasar unggulan yang melahirkan ribuan alumni berprestasi di berbagai bidang.";
                @endphp
                <textarea name="school_history" class="form-control" rows="4" placeholder="Tuliskan ringkasan sejarah sekolah...">{{ old('school_history', $settings['school_history'] ?? $defaultHistory) }}</textarea>
            </div>
        </div>

        <div class="form-actions" style="margin-top: 25px;">
            <a href="{{ route('dashboard') }}" class="btn btn-grey">Kembali ke Dashboard</a>
            <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Simpan Perubahan Profil</button>
        </div>
    </form>
</div>
@endsection
