@extends('layouts.app')

@section('title', 'Formulir Pendaftaran PPDB - ' . ($settings['school_name'] ?? 'SD Negeri Negeri Lama'))

@section('content')
<div class="page-header">
  <h1>Formulir Pendaftaran PPDB</h1>
  <p>Isi data calon peserta didik dengan benar dan lengkap</p>
</div>

<div class="page-content">
  <form action="{{ route('ppdb.store') }}" method="POST" class="card-box ppdb-form" enctype="multipart/form-data">
    @csrf

    @if ($errors->any())
      <div style="background: #fef2f2; color: #991b1b; border-left: 4px solid #ef4444; padding: 14px 16px; border-radius: 8px; margin-bottom: 24px;">
        <strong>Periksa kembali data berikut:</strong>
        <ul style="margin: 8px 0 0 18px;">
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <h2 style="font-size: 1.3rem; color: var(--primary); margin-bottom: 20px;"><i class="fa-solid fa-child"></i> Data Calon Peserta Didik</h2>
    <div class="ppdb-form-grid">
      <div class="form-field form-field-wide">
        <label for="student_name">Nama Lengkap *</label>
        <input id="student_name" type="text" name="student_name" value="{{ old('student_name') }}" required>
      </div>
      <div class="form-field">
        <label for="birth_place">Tempat Lahir *</label>
        <input id="birth_place" type="text" name="birth_place" value="{{ old('birth_place') }}" required>
      </div>
      <div class="form-field">
        <label for="birth_date">Tanggal Lahir *</label>
        <input id="birth_date" type="date" name="birth_date" value="{{ old('birth_date') }}" required>
      </div>
      <div class="form-field">
        <label for="gender">Jenis Kelamin *</label>
        <select id="gender" name="gender" required>
          <option value="">Pilih jenis kelamin</option>
          <option value="L" @selected(old('gender') === 'L')>Laki-laki</option>
          <option value="P" @selected(old('gender') === 'P')>Perempuan</option>
        </select>
      </div>
      <div class="form-field">
        <label for="previous_school">Asal TK/RA</label>
        <input id="previous_school" type="text" name="previous_school" value="{{ old('previous_school') }}">
      </div>
      <div class="form-field">
        <label for="nik">NIK (16 digit)</label>
        <input id="nik" type="text" name="nik" inputmode="numeric" maxlength="16" value="{{ old('nik') }}">
      </div>
      <div class="form-field">
        <label for="kk_number">Nomor KK (16 digit)</label>
        <input id="kk_number" type="text" name="kk_number" inputmode="numeric" maxlength="16" value="{{ old('kk_number') }}">
      </div>
      <div class="form-field form-field-wide">
        <label for="address">Alamat Lengkap *</label>
        <textarea id="address" name="address" rows="3" required>{{ old('address') }}</textarea>
      </div>
    </div>

    <h2 style="font-size: 1.3rem; color: var(--primary); margin: 30px 0 20px;"><i class="fa-solid fa-user-tie"></i> Data Orang Tua/Wali</h2>
    <div class="ppdb-form-grid">
      <div class="form-field form-field-wide">
        <label for="parent_name">Nama Orang Tua/Wali *</label>
        <input id="parent_name" type="text" name="parent_name" value="{{ old('parent_name') }}" required>
      </div>
      <div class="form-field">
        <label for="phone">Nomor WhatsApp *</label>
        <input id="phone" type="text" name="phone" value="{{ old('phone') }}" required>
      </div>
      <div class="form-field">
        <label for="email">Email</label>
        <input id="email" type="email" name="email" value="{{ old('email') }}">
      </div>
    </div>

    <h2 style="font-size: 1.3rem; color: var(--primary); margin: 30px 0 20px;"><i class="fa-solid fa-file-upload"></i> File Pendukung</h2>
    <div style="background: #f0f9ff; border: 1px solid #bfdbfe; border-radius: 12px; padding: 20px; margin-bottom: 24px;">
      <p style="font-size: 0.9rem; color: #1e40af; margin-bottom: 16px; line-height: 1.6;">
        <i class="fa-solid fa-info-circle" style="margin-right: 6px;"></i>
        <strong>File pendukung berikut diperlukan:</strong> Scan/fotocopy Kartu Keluarga (KK), Akte Kelahiran, dan Rapor terakhir. Format: PDF, JPG, PNG. Ukuran maksimal: 5MB per file.
      </p>
      
      <div class="ppdb-form-grid">
        <div class="form-field form-field-wide">
          <label for="supporting_file_kk">
            <i class="fa-solid fa-id-card" style="color: #1769d9; margin-right: 6px;"></i> Kartu Keluarga (KK) *
            <span style="font-size: 0.75rem; color: #7790b3; margin-left: 8px;">(PDF, JPG, PNG - Max 5MB)</span>
          </label>
          <input id="supporting_file_kk" type="file" name="supporting_file_kk" accept=".pdf,.jpg,.jpeg,.png" required 
                 style="padding: 10px; border: 2px dashed #cbd5e1; border-radius: 8px; width: 100%; box-sizing: border-box; background: #f8fafc; cursor: pointer;">
          <small style="display: block; color: #7790b3; margin-top: 6px;">Unggah scan atau fotocopy Kartu Keluarga</small>
        </div>

        <div class="form-field form-field-wide">
          <label for="supporting_file_akte">
            <i class="fa-solid fa-certificate" style="color: #10b981; margin-right: 6px;"></i> Akte Kelahiran (Akta Lahir)
            <span style="font-size: 0.75rem; color: #7790b3; margin-left: 8px;">(PDF, JPG, PNG - Max 5MB)</span>
          </label>
          <input id="supporting_file_akte" type="file" name="supporting_file_akte" accept=".pdf,.jpg,.jpeg,.png"
                 style="padding: 10px; border: 2px dashed #cbd5e1; border-radius: 8px; width: 100%; box-sizing: border-box; background: #f8fafc; cursor: pointer;">
          <small style="display: block; color: #7790b3; margin-top: 6px;">Unggah scan atau fotocopy Akte Kelahiran (opsional tapi disarankan)</small>
        </div>

        <div class="form-field form-field-wide">
          <label for="supporting_file_rapor">
            <i class="fa-solid fa-file-pdf" style="color: #ef4444; margin-right: 6px;"></i> Rapor / Nilai Terakhir
            <span style="font-size: 0.75rem; color: #7790b3; margin-left: 8px;">(PDF, JPG, PNG - Max 5MB)</span>
          </label>
          <input id="supporting_file_rapor" type="file" name="supporting_file_rapor" accept=".pdf,.jpg,.jpeg,.png"
                 style="padding: 10px; border: 2px dashed #cbd5e1; border-radius: 8px; width: 100%; box-sizing: border-box; background: #f8fafc; cursor: pointer;">
          <small style="display: block; color: #7790b3; margin-top: 6px;">Unggah scan rapor atau nilai terakhir dari TK/RA</small>
        </div>
      </div>
    </div>

    <div style="display: flex; justify-content: flex-end; gap: 12px; margin-top: 30px; flex-wrap: wrap;">
      <a href="{{ route('ppdb') }}" style="padding: 12px 22px; border: 1px solid var(--border); border-radius: 10px; font-weight: 700;">Batal</a>
      <button type="submit" class="btn-login" style="border: 0; cursor: pointer; padding: 12px 22px;"><i class="fa-solid fa-paper-plane"></i> Kirim Pendaftaran</button>
    </div>
  </form>
</div>
@endsection

@section('styles')
<link rel="stylesheet" href="{{ asset('mentahan2/css/ppdb-register.css') }}?v={{ filemtime(public_path('mentahan2/css/ppdb-register.css')) ?: time() }}">
@endsection
