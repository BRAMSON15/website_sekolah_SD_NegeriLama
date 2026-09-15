@extends('layouts.app')

@section('title', 'Pendaftaran Berhasil - ' . ($settings['school_name'] ?? 'SD Negeri Lama'))

@section('content')
<div class="page-header">
  <h1>Pendaftaran Berhasil</h1>
  <p>Data calon peserta didik telah kami terima</p>
</div>

<div class="page-content">
  <div class="card-box" style="max-width: 720px; margin: 0 auto; text-align: center;">
    <div style="width: 70px; height: 70px; margin: 0 auto 20px; border-radius: 50%; background: #dcfce7; color: #15803d; display: flex; align-items: center; justify-content: center; font-size: 2rem;">
      <i class="fa-solid fa-check"></i>
    </div>
    <h2 style="color: var(--primary); margin-bottom: 10px;">Terima kasih, {{ $registration->parent_name }}</h2>
    <p style="color: var(--muted); margin-bottom: 24px;">Simpan nomor pendaftaran berikut untuk keperluan verifikasi.</p>
    <div style="display: inline-block; background: var(--light-bg); border: 1px dashed var(--primary); border-radius: 10px; padding: 14px 24px; color: var(--primary); font-size: 1.4rem; font-weight: 800; letter-spacing: 1px; margin-bottom: 24px;">{{ $registration->registration_number }}</div>
    <p style="color: var(--muted);">Nama calon peserta didik: <strong>{{ $registration->student_name }}</strong></p>
    <div style="margin-top: 28px; display: flex; justify-content: center; gap: 12px; flex-wrap: wrap;">
      <a href="{{ route('ppdb') }}" class="btn-login" style="padding: 12px 22px;"><i class="fa-solid fa-arrow-left"></i> Kembali ke PPDB</a>
      <button type="button" onclick="window.print()" style="padding: 12px 22px; border: 1px solid var(--border); border-radius: 10px; background: #fff; color: var(--dark); font-weight: 700; cursor: pointer;"><i class="fa-solid fa-print"></i> Cetak Bukti</button>
    </div>
  </div>
</div>
@endsection
