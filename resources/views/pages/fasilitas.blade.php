@extends('layouts.app')

@section('title', 'Fasilitas Sekolah - ' . ($settings['school_name'] ?? 'SD Negeri Negeri Lama'))

@section('content')
<style>
  .facilities-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(min(100%, 280px), 1fr)); gap: 24px; }
  .facility-card { }
  .facility-icon { font-size: 2.5rem; margin-bottom: 12px; }
  .facility-title { font-size: 1.2rem; margin-bottom: 8px; }
  .facility-text { font-size: 0.9rem; }
  
  @media (max-width: 768px) {
    .facilities-grid { gap: 18px; }
    .facility-icon { font-size: 2rem; margin-bottom: 10px; }
    .facility-title { font-size: 1.05rem; }
    .facility-text { font-size: 0.85rem; }
  }
  
  @media (max-width: 576px) {
    .facilities-grid { gap: 12px; }
    .facility-card { padding: 16px !important; }
    .facility-icon { font-size: 1.8rem; margin-bottom: 8px; }
    .facility-title { font-size: 0.95rem; margin-bottom: 6px; }
    .facility-text { font-size: 0.78rem; }
  }
  
  @media (max-width: 380px) {
    .facility-icon { font-size: 1.4rem; }
    .facility-title { font-size: 0.85rem; }
    .facility-text { font-size: 0.70rem; }
  }
  
  .empty-state { padding: 40px 20px; text-align: center; }
  @media (max-width: 576px) {
    .empty-state { padding: 30px 16px; }
    .empty-state i { font-size: 1.5rem !important; }
    .empty-state p { font-size: 0.8rem; }
  }
</style>

<div class="page-header">
  <h1>Fasilitas Sekolah</h1>
  <p>Sarana dan prasarana pendukung belajar mengajar yang nyaman dan modern</p>
</div>

<div class="page-content">
  @if(!empty($settings['facilities_data']))
  @php
    $facilities = json_decode($settings['facilities_data'], true) ?: [];
  @endphp

  <div class="facilities-grid">
    @foreach($facilities as $item)
    <div class="card-box facility-card">
      <div class="facility-icon" style="color: var(--primary);"><i class="{{ $item['icon'] ?? 'fa-solid fa-school' }}"></i></div>
      <h3 class="facility-title" style="font-weight: 700; margin: 0 0 8px 0;">{{ $item['title'] }}</h3>
      <p class="facility-text" style="color: var(--muted); margin: 0;">{{ $item['desc'] }}</p>
    </div>
    @endforeach
  </div>
  @else
  <div class="card-box empty-state" style="color: var(--muted); background: var(--light-bg); border-radius: 12px; border: 1px dashed var(--border);">
    <i class="fa-solid fa-inbox" style="font-size: 2rem; opacity: 0.3; margin-bottom: 10px; display: block;"></i>
    <p style="margin: 0;">Admin belum menambahkan data fasilitas sekolah. Silakan kembali kemudian.</p>
  </div>
  @endif
</div>
@endsection
