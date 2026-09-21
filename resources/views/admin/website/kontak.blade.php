@extends('layouts.admin')

@section('title', 'Kelola Informasi Kontak - ' . ($settings['school_name'] ?? 'SD Negeri Lama'))

@section('content')
<div class="information-home">
    <div class="information-hero">
        <div>
            <span class="panel-eyebrow">KELOLA WEBSITE / KONTAK</span>
            <h2>Kelola Informasi Kontak & Lokasi</h2>
            <p>Atur alamat sekolah, nomor telepon, WhatsApp, email resmi, dan tautan akun media sosial.</p>
        </div>
        <div style="display: flex; gap: 10px; align-items: center;">
            <a href="{{ route('kontak') }}" target="_blank" class="btn btn-secondary" style="background: rgba(255, 255, 255, 0.2); color: #ffffff; border: 1px solid rgba(255, 255, 255, 0.4); text-decoration: none; padding: 10px 18px; border-radius: 8px; font-weight: 600; display: inline-flex; align-items: center; gap: 8px;">
                <i class="fa-solid fa-arrow-up-right-from-square"></i> Lihat Halaman Kontak
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

    <form action="{{ route('admin.website.kontak.update') }}" method="POST">
        @csrf

        <!-- Panel 1: Kontak Utama -->
        <div class="information-panel">
            <div class="information-panel-heading">
                <h3><i class="fa-solid fa-address-card" style="color: #1769d9;"></i> Informasi Kontak Sekolah</h3>
                <p>Alamat fisik dan saluran komunikasi resmi sekolah</p>
            </div>
            
            <div class="form-group">
                <label>Alamat Lengkap Sekolah</label>
                <textarea name="address" class="form-control" rows="3" required placeholder="Jalan, Nomor, RT/RW, Kelurahan, Kecamatan, Kota...">{{ old('address', $settings['address'] ?? 'Jl. Pendidikan No. 45, Indonesia') }}</textarea>
                <span class="form-hint">Ditampilkan di footer semua halaman dan halaman kontak utama.</span>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Nomor Telepon / WhatsApp</label>
                        <input type="text" name="phone" class="form-control" value="{{ old('phone', $settings['phone'] ?? '(021) 555-0192') }}" required placeholder="Contoh: (021) 555-0192 atau +62 812-3456-7890">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Alamat Email Resmi Sekolah</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email', $settings['email'] ?? 'info@sdnegerilama.sch.id') }}" required placeholder="info@sdnegerilama.sch.id">
                    </div>
                </div>
            </div>
        </div>

        <!-- Panel 2: Akun Media Sosial -->
        <div class="information-panel">
            <div class="information-panel-heading">
                <h3><i class="fa-solid fa-share-nodes" style="color: #1769d9;"></i> Tautan Media Sosial Resmi</h3>
                <p>Koneksikan saluran media sosial resmi sekolah agar wali murid dan publik dapat mengikuti kegiatan</p>
            </div>

            <div class="form-group">
                <label><i class="fa-brands fa-facebook" style="color: #1877f2;"></i> Tautan Facebook</label>
                <input type="url" name="facebook" class="form-control" value="{{ old('facebook', $settings['facebook'] ?? 'https://facebook.com') }}" placeholder="https://facebook.com/namahalaman">
            </div>

            <div class="form-group">
                <label><i class="fa-brands fa-instagram" style="color: #e1306c;"></i> Tautan Instagram</label>
                <input type="url" name="instagram" class="form-control" value="{{ old('instagram', $settings['instagram'] ?? 'https://instagram.com') }}" placeholder="https://instagram.com/namapengguna">
            </div>

            <div class="form-group" style="margin-bottom: 0;">
                <label><i class="fa-brands fa-youtube" style="color: #ff0000;"></i> Tautan YouTube</label>
                <input type="url" name="youtube" class="form-control" value="{{ old('youtube', $settings['youtube'] ?? 'https://youtube.com') }}" placeholder="https://youtube.com/@channelsekolah">
            </div>
        </div>

        <!-- Panel 3: Embed Google Maps -->
        <div class="information-panel">
            <div class="information-panel-heading">
                <h3><i class="fa-solid fa-map-location-dot" style="color: #1769d9;"></i> Sematan Google Maps (Opsional)</h3>
                <p>Tautan Google Maps atau iframe peta lokasi sekolah</p>
            </div>

            <div class="form-group" style="margin-bottom: 0;">
                <label>Kode Embed / URL Google Maps</label>
                <textarea name="maps_embed" class="form-control" rows="3" placeholder="Contoh: https://maps.google.com/... atau <iframe>...</iframe>">{{ old('maps_embed', $settings['maps_embed'] ?? '') }}</textarea>
                <span class="form-hint">Dapat berupa URL langsung atau iframe sematan dari Google Maps.</span>
            </div>
        </div>

        <div class="form-actions" style="margin-top: 25px;">
            <a href="{{ route('dashboard') }}" class="btn btn-grey">Kembali ke Dashboard</a>
            <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Simpan Informasi Kontak</button>
        </div>
    </form>
</div>
@endsection
