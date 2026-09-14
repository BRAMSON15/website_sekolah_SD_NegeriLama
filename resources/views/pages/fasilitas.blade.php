@extends('layouts.app')

@section('title', 'Fasilitas Sekolah - ' . ($settings['school_name'] ?? 'SD Negeri Lama'))

@section('content')
<div class="page-header">
  <h1>Fasilitas Sekolah</h1>
  <p>Sarana dan prasarana pendukung belajar mengajar yang nyaman dan modern</p>
</div>

<div class="page-content">
  <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 24px;">
    <div class="card-box">
      <div style="font-size: 2.5rem; color: var(--primary); margin-bottom: 12px;"><i class="fa-solid fa-desktop"></i></div>
      <h3 style="font-size: 1.2rem; font-weight: 700; margin-bottom: 8px;">Laboratorium Komputer</h3>
      <p style="color: var(--muted); font-size: 0.9rem;">Dilengkapi perangkat PC terbaru dan koneksi internet cepat untuk ANBK dan literasi digital.</p>
    </div>

    <div class="card-box">
      <div style="font-size: 2.5rem; color: var(--primary); margin-bottom: 12px;"><i class="fa-solid fa-book-bookmark"></i></div>
      <h3 style="font-size: 1.2rem; font-weight: 700; margin-bottom: 8px;">Perpustakaan Digital</h3>
      <p style="color: var(--muted); font-size: 0.9rem;">Koleksi ribuan buku pelajaran, novel anak, dan e-book yang dapat diakses siswa kapan saja.</p>
    </div>

    <div class="card-box">
      <div style="font-size: 2.5rem; color: var(--primary); margin-bottom: 12px;"><i class="fa-solid fa-flask"></i></div>
      <h3 style="font-size: 1.2rem; font-weight: 700; margin-bottom: 8px;">Laboratorium IPA</h3>
      <p style="color: var(--muted); font-size: 0.9rem;">Fasilitas praktek sains lengkap untuk melatih rasa ingin tahu dan eksperimen sains siswa.</p>
    </div>

    <div class="card-box">
      <div style="font-size: 2.5rem; color: var(--primary); margin-bottom: 12px;"><i class="fa-solid fa-volleyball"></i></div>
      <h3 style="font-size: 1.2rem; font-weight: 700; margin-bottom: 8px;">Lapangan Olahraga</h3>
      <p style="color: var(--muted); font-size: 0.9rem;">Lapangan serbaguna untuk upacara, sepak bola, bola voli, basket, dan kegiatan senam bersama.</p>
    </div>

    <div class="card-box">
      <div style="font-size: 2.5rem; color: var(--primary); margin-bottom: 12px;"><i class="fa-solid fa-mosque"></i></div>
      <h3 style="font-size: 1.2rem; font-weight: 700; margin-bottom: 8px;">Musholla Sekolah</h3>
      <p style="color: var(--muted); font-size: 0.9rem;">Tempat ibadah bersih dan nyaman untuk kegiatan sholat dzuhur berjamaah dan hafalan Al-Qur'an.</p>
    </div>

    <div class="card-box">
      <div style="font-size: 2.5rem; color: var(--primary); margin-bottom: 12px;"><i class="fa-solid fa-utensils"></i></div>
      <h3 style="font-size: 1.2rem; font-weight: 700; margin-bottom: 8px;">Kantin Sehat</h3>
      <p style="color: var(--muted); font-size: 0.9rem;">Menyediakan jajanan dan makanan bergizi yang terjamin kebersihan dan kesehatannya.</p>
    </div>
  </div>
</div>
@endsection
