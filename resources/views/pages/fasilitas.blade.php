@extends('layouts.app')

@section('title', 'Fasilitas Sekolah - ' . ($settings['school_name'] ?? 'SD Negeri Negeri Lama'))

@section('content')
<div class="pv-hero" style="background-image: linear-gradient(rgba(15, 23, 42, 0.62), rgba(30, 64, 175, 0.6)), url('{{ asset('mentahan2/img/image1.png') }}');">
  <div class="pv-hero-inner">
    <span class="pv-hero-chip"><i class="fa-solid fa-building"></i> Sarana & Prasarana</span>
    <h1>Fasilitas Sekolah</h1>
    <p>Sarana dan prasarana pendukung belajar mengajar yang nyaman, aman, dan modern untuk peserta didik.</p>
  </div>
</div>

<div class="pv-wrap">
  @if(!empty($settings['facilities_data']))
  @php
    $facilities = json_decode($settings['facilities_data'], true) ?: [];
    $palette = ['pv-icon--blue', 'pv-icon--green', 'pv-icon--purple', 'pv-icon--orange', 'pv-icon--amber', 'pv-icon--rose'];
  @endphp

  <div class="pv-fac-grid">
    @foreach($facilities as $i => $item)
    <div class="pv-fac">
      <div class="pv-icon {{ $palette[$i % count($palette)] }}"><i class="{{ $item['icon'] ?? 'fa-solid fa-school' }}"></i></div>
      <h3>{{ $item['title'] }}</h3>
      <p>{{ $item['desc'] }}</p>
    </div>
    @endforeach
  </div>
  @else
  <div class="pv-empty">
    <i class="fa-solid fa-inbox"></i>
    <h4>Data Fasilitas Belum Tersedia</h4>
    <p>Admin belum menambahkan data fasilitas sekolah. Silakan kembali kemudian.</p>
  </div>
  @endif
</div>
@endsection
