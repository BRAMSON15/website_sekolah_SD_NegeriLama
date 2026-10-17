@extends('layouts.app')

@section('title', 'Fasilitas Sekolah - ' . ($settings['school_name'] ?? 'SD Negeri Negeri Lama'))

@section('content')
<div class="page-header">
  <h1>Fasilitas Sekolah</h1>
  <p>Sarana dan prasarana pendukung belajar mengajar yang nyaman dan modern</p>
</div>

<div class="page-content">
  @if(!empty($settings['facilities_data']))
  @php
    $facilities = json_decode($settings['facilities_data'], true) ?: [];
  @endphp

  <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(min(100%, 280px), 1fr)); gap: 24px;">
    @foreach($facilities as $item)
    <div class="card-box">
      <div style="font-size: 2.5rem; color: var(--primary); margin-bottom: 12px;"><i class="{{ $item['icon'] ?? 'fa-solid fa-school' }}"></i></div>
      <h3 style="font-size: 1.2rem; font-weight: 700; margin-bottom: 8px;">{{ $item['title'] }}</h3>
      <p style="color: var(--muted); font-size: 0.9rem;">{{ $item['desc'] }}</p>
    </div>
    @endforeach
  </div>
  @else
  <div style="padding: 40px; text-align: center; color: var(--muted); background: var(--light-bg); border-radius: 12px;">
    <i class="fa-solid fa-inbox" style="font-size: 2rem; opacity: 0.3; margin-bottom: 10px; display: block;"></i>
    <p>Admin belum menambahkan data fasilitas sekolah. Silakan kembali kemudian.</p>
  </div>
  @endif
</div>
@endsection
