@extends('layouts.app')

@section('title', 'Fasilitas Sekolah - ' . ($settings['school_name'] ?? 'SD Negeri Lama'))

@section('content')
<div class="page-header">
  <h1>Fasilitas Sekolah</h1>
  <p>Sarana dan prasarana pendukung belajar mengajar yang nyaman dan modern</p>
</div>

<div class="page-content">
  @php
    $defaultFacilities = [
      ['icon' => 'fa-solid fa-desktop', 'title' => 'Laboratorium Komputer', 'desc' => 'Dilengkapi perangkat PC terbaru dan koneksi internet cepat untuk ANBK dan literasi digital.'],
      ['icon' => 'fa-solid fa-book-bookmark', 'title' => 'Perpustakaan Digital', 'desc' => 'Koleksi ribuan buku pelajaran, novel anak, dan e-book yang dapat diakses siswa kapan saja.'],
      ['icon' => 'fa-solid fa-flask', 'title' => 'Laboratorium IPA', 'desc' => 'Fasilitas praktek sains lengkap untuk melatih rasa ingin tahu dan eksperimen sains siswa.'],
      ['icon' => 'fa-solid fa-volleyball', 'title' => 'Lapangan Olahraga', 'desc' => 'Lapangan serbaguna untuk upacara, sepak bola, bola voli, basket, dan kegiatan senam bersama.'],
      ['icon' => 'fa-solid fa-mosque', 'title' => 'Musholla Sekolah', 'desc' => 'Tempat ibadah bersih dan nyaman untuk kegiatan sholat dzuhur berjamaah dan hafalan Al-Qur\'an.'],
      ['icon' => 'fa-solid fa-utensils', 'title' => 'Kantin Sehat', 'desc' => 'Menyediakan jajanan dan makanan bergizi yang terjamin kebersihan dan kesehatannya.'],
    ];

    $facilities = [];
    if (!empty($settings['facilities_data'])) {
      $facilities = json_decode($settings['facilities_data'], true) ?: [];
    }
    if (empty($facilities)) {
      $facilities = $defaultFacilities;
    }
  @endphp

  <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 24px;">
    @foreach($facilities as $item)
    <div class="card-box">
      <div style="font-size: 2.5rem; color: var(--primary); margin-bottom: 12px;"><i class="{{ $item['icon'] ?? 'fa-solid fa-school' }}"></i></div>
      <h3 style="font-size: 1.2rem; font-weight: 700; margin-bottom: 8px;">{{ $item['title'] }}</h3>
      <p style="color: var(--muted); font-size: 0.9rem;">{{ $item['desc'] }}</p>
    </div>
    @endforeach
  </div>
</div>
@endsection
