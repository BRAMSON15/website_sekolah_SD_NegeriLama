@extends('layouts.app')

@section('title', 'Pendaftaran Berhasil - ' . ($settings['school_name'] ?? 'SD Negeri Negeri Lama'))

@section('content')
<div class="pv-hero" style="background-image: linear-gradient(rgba(15, 23, 42, 0.62), rgba(30, 64, 175, 0.6)), url('{{ asset('mentahan2/img/image1.png') }}'); padding: 60px 6% 110px;">
  <div class="pv-hero-inner">
    <span class="pv-hero-chip" style="background: rgba(22, 163, 74, 0.25); border-color: rgba(74, 222, 128, 0.5);"><i class="fa-solid fa-circle-check"></i> Pendaftaran Terkirim</span>
    <h1>Bukti Pendaftaran PPDB</h1>
    <p>Data calon peserta didik telah kami terima dan akan segera diverifikasi oleh panitia.</p>
  </div>
</div>

<div class="pv-wrap" style="margin-top: -70px; position: relative; z-index: 2;">
  <div class="pv-card pv-success">
    <div class="pv-success-icon"><i class="fa-solid fa-check"></i></div>
    <h2 style="color: var(--primary); margin: 0 0 8px; font-size: 1.4rem;">Terima kasih, {{ $registration->parent_name }}</h2>
    <p style="color: var(--muted); margin: 0 0 18px;">Simpan nomor pendaftaran berikut untuk keperluan verifikasi.</p>
    <div class="pv-reg-number">{{ $registration->registration_number }}</div>
    <p style="color: var(--muted); margin: 0;">Nama calon peserta didik: <strong style="color: var(--dark);">{{ $registration->student_name }}</strong></p>
    <div class="pv-success-actions">
      <a href="{{ route('ppdb') }}" class="pv-btn pv-btn--primary pv-btn--inline"><i class="fa-solid fa-arrow-left"></i> Kembali ke PPDB</a>
      <button type="button" onclick="window.print()" class="pv-btn pv-btn--ghost pv-btn--inline"><i class="fa-solid fa-print"></i> Cetak Bukti</button>
    </div>
  </div>
</div>
@endsection
