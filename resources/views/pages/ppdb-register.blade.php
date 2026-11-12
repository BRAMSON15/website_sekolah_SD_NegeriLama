@extends('layouts.app')

@section('title', 'Formulir Pendaftaran PPDB - ' . ($settings['school_name'] ?? 'SD Negeri Negeri Lama'))

@section('content')
<div class="page-header">
  <h1>Formulir Pendaftaran PPDB</h1>
  <p>Isi data calon peserta didik dengan benar dan lengkap</p>
</div>

<div class="page-content">
  <form action="{{ route('ppdb.store') }}" method="POST" class="card-box ppdb-form mf-form" enctype="multipart/form-data">
    @csrf

    @if ($errors->any())
      <div class="mf-error">
        <strong><i class="fa-solid fa-circle-exclamation" style="margin-right: 6px;"></i> Periksa kembali data berikut:</strong>
        <ul>
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <h2 class="mf-section-title"><span class="mf-step">1</span> Data Calon Peserta Didik</h2>
    <div class="mf-grid">
      <div class="mf-field mf-field-wide">
        <label for="student_name">Nama Lengkap <span class="mf-req">*</span></label>
        <input id="student_name" type="text" name="student_name" value="{{ old('student_name') }}" placeholder="Sesuai akte kelahiran" required>
      </div>
      <div class="mf-field">
        <label for="birth_place">Tempat Lahir <span class="mf-req">*</span></label>
        <input id="birth_place" type="text" name="birth_place" value="{{ old('birth_place') }}" placeholder="Contoh: Ambon" required>
      </div>
      <div class="mf-field">
        <label for="birth_date">Tanggal Lahir <span class="mf-req">*</span></label>
        <input id="birth_date" type="date" name="birth_date" value="{{ old('birth_date') }}" required>
      </div>
      <div class="mf-field">
        <label for="gender">Jenis Kelamin <span class="mf-req">*</span></label>
        <div class="mf-select-wrap">
          <select id="gender" name="gender" required>
            <option value="">Pilih jenis kelamin</option>
            <option value="L" @selected(old('gender') === 'L')>Laki-laki</option>
            <option value="P" @selected(old('gender') === 'P')>Perempuan</option>
          </select>
        </div>
      </div>
      <div class="mf-field">
        <label for="previous_school">Asal TK/RA</label>
        <input id="previous_school" type="text" name="previous_school" value="{{ old('previous_school') }}" placeholder="Nama TK/RA asal (opsional)">
      </div>
      <div class="mf-field">
        <label for="nik">NIK (16 digit)</label>
        <input id="nik" type="text" name="nik" inputmode="numeric" maxlength="16" value="{{ old('nik') }}" placeholder="16 digit sesuai KK">
        <span class="mf-hint">Nomor Induk Kependudukan calon siswa.</span>
      </div>
      <div class="mf-field">
        <label for="kk_number">Nomor KK (16 digit)</label>
        <input id="kk_number" type="text" name="kk_number" inputmode="numeric" maxlength="16" value="{{ old('kk_number') }}" placeholder="16 digit pada Kartu Keluarga">
      </div>
      <div class="mf-field mf-field-wide">
        <label for="address">Alamat Lengkap <span class="mf-req">*</span></label>
        <textarea id="address" name="address" rows="3" placeholder="Jalan, RT/RW, kelurahan, kecamatan" required>{{ old('address') }}</textarea>
      </div>
    </div>

    <h2 class="mf-section-title"><span class="mf-step">2</span> Data Orang Tua / Wali</h2>
    <div class="mf-grid">
      <div class="mf-field mf-field-wide">
        <label for="parent_name">Nama Orang Tua / Wali <span class="mf-req">*</span></label>
        <input id="parent_name" type="text" name="parent_name" value="{{ old('parent_name') }}" placeholder="Nama lengkap ayah/ibu/wali" required>
      </div>
      <div class="mf-field">
        <label for="phone">Nomor WhatsApp <span class="mf-req">*</span></label>
        <input id="phone" type="tel" name="phone" inputmode="tel" value="{{ old('phone') }}" placeholder="08xxxxxxxxxx" required>
        <span class="mf-hint">Aktif, untuk konfirmasi pendaftaran.</span>
      </div>
      <div class="mf-field">
        <label for="email">Email</label>
        <input id="email" type="email" name="email" value="{{ old('email') }}" placeholder="nama@email.com (opsional)">
      </div>
    </div>

    <h2 class="mf-section-title"><span class="mf-step">3</span> File Pendukung</h2>
    <div class="mf-info">
      <i class="fa-solid fa-circle-info" style="margin-right: 6px;"></i>
      <strong>Berkas yang diperlukan:</strong> scan/foto Kartu Keluarga (wajib), Akte Kelahiran, dan Rapor terakhir. Format PDF, JPG, atau PNG — maksimal 5MB per file.
    </div>

    <div class="mf-grid">
      <div class="mf-field mf-field-wide">
        <label for="supporting_file_kk"><i class="fa-solid fa-id-card" style="color: #2563eb; margin-right: 5px;"></i> Kartu Keluarga (KK) <span class="mf-req">*</span></label>
        <div class="mf-upload">
          <input id="supporting_file_kk" type="file" name="supporting_file_kk" accept=".pdf,.jpg,.jpeg,.png" required>
          <span class="mf-upload-hint">Unggah scan atau foto Kartu Keluarga. Wajib.</span>
        </div>
      </div>

      <div class="mf-field mf-field-wide">
        <label for="supporting_file_akte"><i class="fa-solid fa-certificate" style="color: #059669; margin-right: 5px;"></i> Akte Kelahiran</label>
        <div class="mf-upload">
          <input id="supporting_file_akte" type="file" name="supporting_file_akte" accept=".pdf,.jpg,.jpeg,.png">
          <span class="mf-upload-hint">Opsional, tetapi sangat disarankan.</span>
        </div>
      </div>

      <div class="mf-field mf-field-wide">
        <label for="supporting_file_rapor"><i class="fa-solid fa-file-lines" style="color: #ea580c; margin-right: 5px;"></i> Rapor / Nilai Terakhir</label>
        <div class="mf-upload">
          <input id="supporting_file_rapor" type="file" name="supporting_file_rapor" accept=".pdf,.jpg,.jpeg,.png">
          <span class="mf-upload-hint">Dari TK/RA asal, jika ada.</span>
        </div>
      </div>
    </div>

    <div class="mf-actions">
      <a href="{{ route('ppdb') }}" class="mf-btn mf-btn--ghost"><i class="fa-solid fa-arrow-left"></i> Batal</a>
      <button type="submit" class="mf-btn mf-btn--primary"><i class="fa-solid fa-paper-plane"></i> Kirim Pendaftaran</button>
    </div>
  </form>
</div>
@endsection
