@extends('layouts.admin')

@section('title', 'Kelola Fasilitas Sekolah - ' . ($settings['school_name'] ?? 'SD Negeri Lama'))

@section('content')
<div class="information-home">
    <div class="information-hero">
        <div>
            <span class="panel-eyebrow">KELOLA WEBSITE / FASILITAS</span>
            <h2>Kelola Fasilitas & Sarana Prasarana</h2>
            <p>Atur daftar laboratorium, perpustakaan, sarana olahraga, dan fasilitas unggulan sekolah.</p>
        </div>
        <div style="display: flex; gap: 10px; align-items: center;">
            <a href="{{ route('fasilitas') }}" target="_blank" class="btn btn-secondary" style="background: rgba(255, 255, 255, 0.2); color: #ffffff; border: 1px solid rgba(255, 255, 255, 0.4); text-decoration: none; padding: 10px 18px; border-radius: 8px; font-weight: 600; display: inline-flex; align-items: center; gap: 8px;">
                <i class="fa-solid fa-arrow-up-right-from-square"></i> Lihat Halaman Fasilitas
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

    <form action="{{ route('admin.website.fasilitas.update') }}" method="POST">
        @csrf

        <div class="information-panel">
            <div class="information-panel-heading" style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 15px;">
                <div>
                    <h3><i class="fa-solid fa-building-columns" style="color: #1769d9;"></i> Daftar Fasilitas Sekolah</h3>
                    <p>Ubah atau tambahkan item sarana dan prasarana yang ingin ditampilkan ke publik.</p>
                </div>
                <button type="button" class="btn btn-primary" onclick="addFacilityRow()" style="font-size: 13px; padding: 8px 16px;">
                    <i class="fa-solid fa-plus"></i> Tambah Fasilitas Baru
                </button>
            </div>

            <div id="facilitiesContainer" style="display: flex; flex-direction: column; gap: 18px; margin-top: 15px;">
                @foreach($facilities as $index => $fac)
                <div class="facility-card-item" id="facility_row_{{ $index }}" style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; padding: 20px; position: relative;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 14px;">
                        <span style="font-weight: 700; color: #1e3a8a; font-size: 14px; display: flex; align-items: center; gap: 8px;">
                            <span class="facility-badge" style="width: 26px; height: 26px; border-radius: 50%; background: #2563eb; color: #fff; display: inline-flex; align-items: center; justify-content: center; font-size: 12px;">{{ $loop->iteration }}</span>
                            Fasilitas #{{ $loop->iteration }}
                        </span>
                        <button type="button" class="btn btn-grey" onclick="removeFacilityRow('facility_row_{{ $index }}')" style="padding: 5px 12px; font-size: 12px; color: #ef4444; border-color: #fecaca; background: #fff;">
                            <i class="fa-solid fa-trash-can"></i> Hapus
                        </button>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Nama Fasilitas</label>
                                <input type="text" name="facilities[{{ $index }}][title]" class="form-control" value="{{ $fac['title'] ?? '' }}" required placeholder="Contoh: Laboratorium Komputer">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Ikon FontAwesome</label>
                                <input type="text" name="facilities[{{ $index }}][icon]" class="form-control" value="{{ $fac['icon'] ?? 'fa-solid fa-desktop' }}" required placeholder="fa-solid fa-desktop">
                                <span class="form-hint">Contoh: <code>fa-solid fa-desktop</code>, <code>fa-solid fa-book-bookmark</code>, <code>fa-solid fa-flask</code>, <code>fa-solid fa-volleyball</code>, <code>fa-solid fa-mosque</code>, <code>fa-solid fa-utensils</code></span>
                            </div>
                        </div>
                    </div>

                    <div class="form-group" style="margin-bottom: 0;">
                        <label>Deskripsi Fasilitas</label>
                        <textarea name="facilities[{{ $index }}][desc]" class="form-control" rows="2" required placeholder="Deskripsi ringkas sarana dan fungsinya...">{{ $fac['desc'] ?? '' }}</textarea>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <div class="form-actions" style="margin-top: 25px;">
            <a href="{{ route('dashboard') }}" class="btn btn-grey">Kembali ke Dashboard</a>
            <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Simpan Semua Fasilitas</button>
        </div>
    </form>
</div>

<script>
    let facilityIndex = {{ count($facilities) }};

    function addFacilityRow() {
        facilityIndex++;
        const container = document.getElementById('facilitiesContainer');
        const rowId = 'facility_row_' + facilityIndex;

        const html = `
            <div class="facility-card-item" id="${rowId}" style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; padding: 20px; position: relative;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 14px;">
                    <span style="font-weight: 700; color: #1e3a8a; font-size: 14px; display: flex; align-items: center; gap: 8px;">
                        <span class="facility-badge" style="width: 26px; height: 26px; border-radius: 50%; background: #2563eb; color: #fff; display: inline-flex; align-items: center; justify-content: center; font-size: 12px;">+</span>
                        Fasilitas Baru
                    </span>
                    <button type="button" class="btn btn-grey" onclick="removeFacilityRow('${rowId}')" style="padding: 5px 12px; font-size: 12px; color: #ef4444; border-color: #fecaca; background: #fff;">
                        <i class="fa-solid fa-trash-can"></i> Hapus
                    </button>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Nama Fasilitas</label>
                            <input type="text" name="facilities[${facilityIndex}][title]" class="form-control" required placeholder="Contoh: Perpustakaan Modern">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Ikon FontAwesome</label>
                            <input type="text" name="facilities[${facilityIndex}][icon]" class="form-control" value="fa-solid fa-school" required placeholder="fa-solid fa-school">
                        </div>
                    </div>
                </div>

                <div class="form-group" style="margin-bottom: 0;">
                    <label>Deskripsi Fasilitas</label>
                    <textarea name="facilities[${facilityIndex}][desc]" class="form-control" rows="2" required placeholder="Deskripsi ringkas sarana..."></textarea>
                </div>
            </div>
        `;

        container.insertAdjacentHTML('beforeend', html);
    }

    function removeFacilityRow(id) {
        const row = document.getElementById(id);
        const container = document.getElementById('facilitiesContainer');
        if (container.getElementsByClassName('facility-card-item').length <= 1) {
            alert('Minimal harus ada satu fasilitas yang terdaftar.');
            return;
        }
        if (row && confirm('Apakah Anda yakin ingin menghapus fasilitas ini?')) {
            row.remove();
        }
    }
</script>
@endsection
