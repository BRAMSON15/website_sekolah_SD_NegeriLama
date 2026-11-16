@extends('layouts.admin')

@section('title', 'Kelola Pengaturan PPDB - ' . ($settings['school_name'] ?? 'SD Negeri Lama'))

@section('content')
<div class="information-home">
    <div class="information-hero">
        <div>
            <span class="panel-eyebrow">KELOLA WEBSITE / PPDB</span>
            <h2>Kelola Pengaturan & Konten PPDB</h2>
            <p>Atur status pendaftaran baru, gelombang aktif, syarat berkas, dan langkah alur pendaftaran.</p>
        </div>
        <div style="display: flex; gap: 10px; align-items: center; flex-wrap: wrap;">
            <a href="{{ route('admin.ppdb.index') }}" class="btn btn-primary" style="background: #2563eb; color: #fff; text-decoration: none; padding: 10px 18px; border-radius: 8px; font-weight: 600; display: inline-flex; align-items: center; gap: 8px;">
                <i class="fa-solid fa-users"></i> Data Pendaftar Masuk ({{ $totalApplicants }})
            </a>
            <a href="{{ route('ppdb') }}" target="_blank" class="btn btn-secondary" style="background: rgba(255, 255, 255, 0.2); color: #ffffff; border: 1px solid rgba(255, 255, 255, 0.4); text-decoration: none; padding: 10px 18px; border-radius: 8px; font-weight: 600; display: inline-flex; align-items: center; gap: 8px;">
                <i class="fa-solid fa-arrow-up-right-from-square"></i> Lihat Halaman PPDB
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

    <form action="{{ route('admin.website.ppdb.update') }}" method="POST">
        @csrf

        <!-- Panel 1: Status & Banner Gelombang PPDB -->
        <div class="information-panel">
            <div class="information-panel-heading">
                <div>
                    <h3><i class="fa-solid fa-bullhorn" style="color: #1769d9;"></i> Status Pendaftaran & Judul Gelombang</h3>
                    <p>Status buka/tutup pendaftaran siswa baru secara otomatis mengontrol tombol formulir, banner publik, serta label status Buka/Tutup di menu mobile.</p>
                </div>
                <div style="display: flex; gap: 8px; flex-wrap: wrap;">
                    <button type="button" class="btn btn-xs btn-success" id="btnPresetOpen" style="cursor: pointer;">
                        <i class="fa-solid fa-circle-check"></i> Template Buka
                    </button>
                    <button type="button" class="btn btn-xs btn-danger" id="btnPresetClosed" style="cursor: pointer;">
                        <i class="fa-solid fa-circle-xmark"></i> Template Tutup
                    </button>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="ppdb_status">Status Penerimaan Peserta Didik Baru</label>
                        <select name="ppdb_status" id="ppdb_status" class="form-control" required style="font-weight: 700; font-size: 14px;">
                            <option value="open" {{ old('ppdb_status', $settings['ppdb_status'] ?? 'open') === 'open' ? 'selected' : '' }}>🟢 DIBUKA (Pendaftaran Online Aktif)</option>
                            <option value="closed" {{ old('ppdb_status', $settings['ppdb_status'] ?? 'open') === 'closed' ? 'selected' : '' }}>🔴 DITUTUP (Pendaftaran Sementara Ditutup)</option>
                        </select>
                        <span class="form-hint">Jika status DITUTUP: Menu navigasi mobile/desktop akan otomatis menampilkan badge "TUTUP", banner berwarna merah, dan formulir pendaftaran dinonaktifkan.</span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="ppdb_batch_title">Judul Pengumuman Gelombang / Status</label>
                        <input type="text" name="ppdb_batch_title" id="ppdb_batch_title" class="form-control" value="{{ old('ppdb_batch_title', $settings['ppdb_batch_title'] ?? 'PPDB Gelombang II Telah Dibuka!') }}" required placeholder="Contoh: PPDB Gelombang II Telah Dibuka!">
                        <span class="form-hint">Muncul sebagai judul utama banner informasi di halaman PPDB.</span>
                    </div>
                </div>
            </div>

            <div class="form-group" style="margin-bottom: 0;">
                <label for="ppdb_batch_desc">Keterangan Tambahan Gelombang / Penutupan</label>
                <textarea name="ppdb_batch_desc" id="ppdb_batch_desc" class="form-control" rows="2" required placeholder="Tuliskan pesan ajakan atau informasi jadwal gelombang...">{{ old('ppdb_batch_desc', $settings['ppdb_batch_desc'] ?? 'Segera daftarkan putra-putri Anda untuk mendapatkan pendidikan terbaik di lingkungan yang unggul dan berkarakter.') }}</textarea>
                <span class="form-hint">Pastikan keterangan selaras dengan status di atas agar tidak memuat pesan yang bertolak belakang.</span>
            </div>
        </div>

        <!-- Panel 2: Syarat Pendaftaran -->
        <div class="information-panel">
            <div class="information-panel-heading">
                <h3><i class="fa-solid fa-list-check" style="color: #1769d9;"></i> Syarat-Syarat Pendaftaran</h3>
                <p>Ketentuan usia dan berkas administratif yang harus disiapkan oleh calon siswa</p>
            </div>
            <div class="form-group" style="margin-bottom: 0;">
                <label>Daftar Syarat Berkas (1 Baris per Syarat)</label>
                @php
                    $defaultReqs = "Usia minimal 6 tahun per 1 Juli tahun ajaran berjalan.\nFotokopi Akta Kelahiran (2 Lembar).\nFotokopi Kartu Keluarga / KK (2 Lembar).\nFotokopi KTP Kedua Orang Tua / Wali (1 Lembar).\nPas Foto Ukuran 3x4 berwarna terbaru (4 Lembar).\nFotokopi Ijazah / Surat Keterangan Lulus TK / RA (Jika Ada).";
                @endphp
                <textarea name="ppdb_requirements" class="form-control" rows="7" required placeholder="Tuliskan tiap butir syarat pada baris baru...">{{ old('ppdb_requirements', $settings['ppdb_requirements'] ?? $defaultReqs) }}</textarea>
                <span class="form-hint">💡 Tips: Tekan <strong>Enter</strong> untuk membuat butir persyaratan baru. Akan otomatis tampil sebagai daftar bullet rapi.</span>
            </div>
        </div>

        <!-- Panel 3: Alur Pendaftaran (4 Langkah) -->
        <div class="information-panel">
            <div class="information-panel-heading">
                <h3><i class="fa-solid fa-timeline" style="color: #1769d9;"></i> Alur Tahapan Pendaftaran (4 Langkah)</h3>
                <p>Panduan langkah pendaftaran mulai dari pengisian form hingga daftar ulang</p>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 10px; padding: 15px; margin-bottom: 15px;">
                        <h4 style="margin: 0 0 10px 0; color: #1e40af; font-size: 14px;"><i class="fa-solid fa-circle-1"></i> Langkah 1</h4>
                        <div class="form-group">
                            <label>Judul Langkah</label>
                            <input type="text" name="ppdb_step_1_title" class="form-control" value="{{ old('ppdb_step_1_title', $settings['ppdb_step_1_title'] ?? 'Isi Formulir') }}" required>
                        </div>
                        <div class="form-group" style="margin-bottom: 0;">
                            <label>Keterangan Ringkas</label>
                            <input type="text" name="ppdb_step_1_desc" class="form-control" value="{{ old('ppdb_step_1_desc', $settings['ppdb_step_1_desc'] ?? 'Melalui portal online atau datang langsung ke sekolah.') }}" required>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 10px; padding: 15px; margin-bottom: 15px;">
                        <h4 style="margin: 0 0 10px 0; color: #1e40af; font-size: 14px;"><i class="fa-solid fa-circle-2"></i> Langkah 2</h4>
                        <div class="form-group">
                            <label>Judul Langkah</label>
                            <input type="text" name="ppdb_step_2_title" class="form-control" value="{{ old('ppdb_step_2_title', $settings['ppdb_step_2_title'] ?? 'Verifikasi Berkas') }}" required>
                        </div>
                        <div class="form-group" style="margin-bottom: 0;">
                            <label>Keterangan Ringkas</label>
                            <input type="text" name="ppdb_step_2_desc" class="form-control" value="{{ old('ppdb_step_2_desc', $settings['ppdb_step_2_desc'] ?? 'Penyerahan dokumen persyaratan ke panitia PPDB.') }}" required>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 10px; padding: 15px; margin-bottom: 15px;">
                        <h4 style="margin: 0 0 10px 0; color: #1e40af; font-size: 14px;"><i class="fa-solid fa-circle-3"></i> Langkah 3</h4>
                        <div class="form-group">
                            <label>Judul Langkah</label>
                            <input type="text" name="ppdb_step_3_title" class="form-control" value="{{ old('ppdb_step_3_title', $settings['ppdb_step_3_title'] ?? 'Pengumuman') }}" required>
                        </div>
                        <div class="form-group" style="margin-bottom: 0;">
                            <label>Keterangan Ringkas</label>
                            <input type="text" name="ppdb_step_3_desc" class="form-control" value="{{ old('ppdb_step_3_desc', $settings['ppdb_step_3_desc'] ?? 'Hasil seleksi diumumkan via portal & papan pengumuman.') }}" required>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 10px; padding: 15px; margin-bottom: 15px;">
                        <h4 style="margin: 0 0 10px 0; color: #1e40af; font-size: 14px;"><i class="fa-solid fa-circle-4"></i> Langkah 4</h4>
                        <div class="form-group">
                            <label>Judul Langkah</label>
                            <input type="text" name="ppdb_step_4_title" class="form-control" value="{{ old('ppdb_step_4_title', $settings['ppdb_step_4_title'] ?? 'Daftar Ulang') }}" required>
                        </div>
                        <div class="form-group" style="margin-bottom: 0;">
                            <label>Keterangan Ringkas</label>
                            <input type="text" name="ppdb_step_4_desc" class="form-control" value="{{ old('ppdb_step_4_desc', $settings['ppdb_step_4_desc'] ?? 'Konfirmasi kehadiran dan kelengkapan seragam.') }}" required>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="form-actions" style="margin-top: 25px;">
            <a href="{{ route('dashboard') }}" class="btn btn-grey">Kembali ke Dashboard</a>
            <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Simpan Pengaturan PPDB</button>
        </div>
    </form>
</div>

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const statusSelect = document.getElementById('ppdb_status');
        const titleInput = document.getElementById('ppdb_batch_title');
        const descInput = document.getElementById('ppdb_batch_desc');
        const btnOpen = document.getElementById('btnPresetOpen');
        const btnClosed = document.getElementById('btnPresetClosed');

        if (btnOpen) {
            btnOpen.addEventListener('click', function() {
                if (statusSelect) statusSelect.value = 'open';
                if (titleInput) titleInput.value = 'PPDB Gelombang II Telah Dibuka!';
                if (descInput) descInput.value = 'Segera daftarkan putra-putri Anda untuk mendapatkan pendidikan terbaik di lingkungan yang unggul dan berkarakter.';
            });
        }

        if (btnClosed) {
            btnClosed.addEventListener('click', function() {
                if (statusSelect) statusSelect.value = 'closed';
                if (titleInput) titleInput.value = 'PPDB Tahun Ajaran Baru telah DiTutup!';
                if (descInput) descInput.value = 'Pendaftaran online untuk periode ini resmi ditutup. Terima kasih atas partisipasi dan kepercayaan seluruh calon peserta didik baru.';
            });
        }

        // When status is manually changed, suggest matching texts if desired
        if (statusSelect) {
            statusSelect.addEventListener('change', function() {
                if (this.value === 'closed') {
                    if (titleInput && titleInput.value.toLowerCase().includes('dibuka')) {
                        titleInput.value = 'PPDB Tahun Ajaran Baru telah DiTutup!';
                    }
                    if (descInput && descInput.value.toLowerCase().includes('dibuka')) {
                        descInput.value = 'Pendaftaran online untuk periode ini resmi ditutup. Terima kasih atas partisipasi dan kepercayaan seluruh calon peserta didik baru.';
                    }
                } else if (this.value === 'open') {
                    if (titleInput && titleInput.value.toLowerCase().includes('ditutup')) {
                        titleInput.value = 'PPDB Gelombang II Telah Dibuka!';
                    }
                    if (descInput && descInput.value.toLowerCase().includes('ditutup')) {
                        descInput.value = 'Segera daftarkan putra-putri Anda untuk mendapatkan pendidikan terbaik di lingkungan yang unggul dan berkarakter.';
                    }
                }
            });
        }
    });
</script>
@endsection
@endsection
