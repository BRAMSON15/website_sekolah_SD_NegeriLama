@extends('layouts.app')

@section('title', 'Pendaftaran PPDB - ' . ($settings['school_name'] ?? 'SD Negeri Lama'))

@section('content')
<div class="page-header">
  <h1>Penerimaan Peserta Didik Baru (PPDB)</h1>
  <p>Tahun Ajaran {{ date('Y') }}/{{ date('Y') + 1 }} - {{ $settings['school_name'] ?? 'SD Negeri Lama' }}</p>
</div>

<div class="page-content">
  <div class="card-box" style="background: linear-gradient(135deg, #eff6ff, #ffffff); border-color: var(--primary-light);">
    <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 20px;">
      <div>
        <h2 style="font-size: 1.5rem; color: var(--primary); margin-bottom: 8px;"><i class="fa-solid fa-bullhorn"></i> PPDB Gelombang II Telah Dibuka!</h2>
        <p style="color: var(--muted);">Segera daftarkan putra-putri Anda untuk mendapatkan pendidikan terbaik.</p>
      </div>
      <a href="#" class="btn-login" style="padding: 14px 28px; font-size: 1rem;"><i class="fa-solid fa-paper-plane"></i> Daftar Sekarang Online</a>
    </div>
  </div>

  <div class="card-box">
    <h2 style="font-size: 1.3rem; color: var(--dark); margin-bottom: 16px;"><i class="fa-solid fa-list-check"></i> Syarat Pendaftaran</h2>
    <ul style="color: var(--muted); padding-left: 20px; line-height: 2;">
      <li>Usia minimal 6 tahun per 1 Juli {{ date('Y') }}.</li>
      <li>Fotokopi Akta Kelahiran (2 Lembar).</li>
      <li>Fotokopi Kartu Keluarga / KK (2 Lembar).</li>
      <li>Fotokopi KTP Kedua Orang Tua / Wali (1 Lembar).</li>
      <li>Pas Foto Ukuran 3x4 berwarna (4 Lembar).</li>
      <li>Fotokopi Ijazah TK / RA (Jika Ada).</li>
    </ul>
  </div>

  <div class="card-box">
    <h2 style="font-size: 1.3rem; color: var(--dark); margin-bottom: 16px;"><i class="fa-solid fa-timeline"></i> Alur Pendaftaran</h2>
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px; text-align: center;">
      <div style="background: var(--light-bg); padding: 20px; border-radius: 12px;">
        <div style="width: 40px; height: 40px; background: var(--primary); color: #fff; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 10px; font-weight: 800;">1</div>
        <h4 style="font-size: 1rem; margin-bottom: 4px;">Isi Formulir</h4>
        <p style="font-size: 0.85rem; color: var(--muted);">Melalui portal online atau datang langsung ke sekolah.</p>
      </div>
      <div style="background: var(--light-bg); padding: 20px; border-radius: 12px;">
        <div style="width: 40px; height: 40px; background: var(--primary); color: #fff; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 10px; font-weight: 800;">2</div>
        <h4 style="font-size: 1rem; margin-bottom: 4px;">Verifikasi Berkas</h4>
        <p style="font-size: 0.85rem; color: var(--muted);">Penyerahan dokumen persyaratan ke panitia PPDB.</p>
      </div>
      <div style="background: var(--light-bg); padding: 20px; border-radius: 12px;">
        <div style="width: 40px; height: 40px; background: var(--primary); color: #fff; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 10px; font-weight: 800;">3</div>
        <h4 style="font-size: 1rem; margin-bottom: 4px;">Pengumuman</h4>
        <p style="font-size: 0.85rem; color: var(--muted);">Hasil seleksi diumumkan via portal & papan pengumuman.</p>
      </div>
      <div style="background: var(--light-bg); padding: 20px; border-radius: 12px;">
        <div style="width: 40px; height: 40px; background: var(--primary); color: #fff; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 10px; font-weight: 800;">4</div>
        <h4 style="font-size: 1rem; margin-bottom: 4px;">Daftar Ulang</h4>
        <p style="font-size: 0.85rem; color: var(--muted);">Konfirmasi kehadiran dan kelengkapan seragam.</p>
      </div>
    </div>
  </div>
</div>
@endsection
