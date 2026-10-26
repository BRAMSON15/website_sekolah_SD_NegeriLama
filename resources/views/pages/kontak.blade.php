@extends('layouts.app')

@section('title', 'Kontak & Lokasi - ' . ($settings['school_name'] ?? 'SD Negeri Negeri Lama'))

@section('content')
<style>
  .kontak-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 24px; }
  .kontak-card h2 { font-size: 1.5rem; margin-bottom: 20px; }
  .kontak-card h4 { font-size: 1rem; margin-bottom: 4px; }
  .kontak-item-icon { width: 44px; height: 44px; font-size: 1.2rem; }
  .kontak-item-text { font-size: 0.95rem; }
  .kontak-item-gap { gap: 20px; }
  .kontak-form-label { font-size: 0.9rem; }
  .kontak-form-input { padding: 12px; }
  .kontak-map { min-height: 350px; }
  
  @media (max-width: 768px) {
    .kontak-grid { grid-template-columns: 1fr; gap: 18px; }
    .kontak-card h2 { font-size: 1.3rem; margin-bottom: 16px; }
    .kontak-card h4 { font-size: 0.92rem; }
    .kontak-item-icon { width: 40px; height: 40px; font-size: 1rem; }
    .kontak-item-text { font-size: 0.88rem; }
    .kontak-item-gap { gap: 16px; }
  }
  
  @media (max-width: 576px) {
    .kontak-card { padding: 16px !important; margin-bottom: 16px !important; }
    .kontak-card h2 { font-size: 1.1rem; margin-bottom: 12px; }
    .kontak-card h4 { font-size: 0.82rem; }
    .kontak-item-icon { width: 36px; height: 36px; font-size: 0.9rem; }
    .kontak-item-text { font-size: 0.78rem; }
    .kontak-item-gap { gap: 12px; }
    .kontak-form-label { font-size: 0.80rem; }
    .kontak-form-input { padding: 10px; font-size: 0.85rem; }
    .kontak-map { min-height: 280px; }
  }
  
  @media (max-width: 380px) {
    .kontak-card h2 { font-size: 0.95rem; }
    .kontak-card h4 { font-size: 0.75rem; }
    .kontak-item-icon { width: 32px; height: 32px; font-size: 0.8rem; }
    .kontak-item-text { font-size: 0.70rem; }
    .kontak-form-label { font-size: 0.72rem; }
    .kontak-form-input { padding: 8px; font-size: 0.78rem; }
  }
</style>

<div class="page-header">
  <h1>Hubungi Kami</h1>
  <p>Layanan informasi dan alamat lokasi {{ $settings['school_name'] ?? 'SD Negeri Negeri Lama' }}</p>
</div>

<div class="page-content">
  <div class="kontak-grid">
    <div class="card-box kontak-card">
      <h2><i class="fa-solid fa-address-card"></i> Informasi Kontak</h2>
      <div style="display: flex; flex-direction: column;" class="kontak-item-gap">
        <div style="display: flex; gap: 16px; align-items: flex-start;">
          <div class="kontak-item-icon" style="background: #dbeafe; color: var(--primary); border-radius: 12px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;"><i class="fa-solid fa-location-dot"></i></div>
          <div style="min-width: 0; flex: 1;">
            <h4 style="color: var(--dark); margin: 0 0 4px 0;">Alamat Sekolah</h4>
            <p class="kontak-item-text" style="color: var(--muted); margin: 0; word-break: break-word;">{{ $settings['address'] ?? 'Jl. Pendidikan No. 45, Indonesia' }}</p>
          </div>
        </div>

        <div style="display: flex; gap: 16px; align-items: flex-start;">
          <div class="kontak-item-icon" style="background: #dbeafe; color: var(--primary); border-radius: 12px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;"><i class="fa-solid fa-phone"></i></div>
          <div style="min-width: 0; flex: 1;">
            <h4 style="color: var(--dark); margin: 0 0 4px 0;">Telepon / Whatsapp</h4>
            <p class="kontak-item-text" style="color: var(--muted); margin: 0;">{{ $settings['phone'] ?? '(021) 555-0192' }}</p>
          </div>
        </div>

        <div style="display: flex; gap: 16px; align-items: flex-start;">
          <div class="kontak-item-icon" style="background: #dbeafe; color: var(--primary); border-radius: 12px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;"><i class="fa-solid fa-envelope"></i></div>
          <div style="min-width: 0; flex: 1;">
            <h4 style="color: var(--dark); margin: 0 0 4px 0;">Email Resmi</h4>
            <p class="kontak-item-text" style="color: var(--muted); margin: 0; word-break: break-word;">{{ $settings['email'] ?? 'info@sdnegerilama.sch.id' }}</p>
          </div>
        </div>

        @if(!empty($settings['facebook']) || !empty($settings['instagram']) || !empty($settings['youtube']))
        <div style="display: flex; gap: 16px; align-items: flex-start;">
          <div class="kontak-item-icon" style="background: #dbeafe; color: var(--primary); border-radius: 12px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;"><i class="fa-solid fa-share-nodes"></i></div>
          <div style="min-width: 0; flex: 1;">
            <h4 style="color: var(--dark); margin: 0 0 4px 0;">Media Sosial</h4>
            <div style="display: flex; gap: 14px; margin-top: 8px; font-size: 1.3rem;">
              @if(!empty($settings['facebook']))
                <a href="{{ $settings['facebook'] }}" target="_blank" style="color: #1877f2;" title="Facebook"><i class="fa-brands fa-facebook"></i></a>
              @endif
              @if(!empty($settings['instagram']))
                <a href="{{ $settings['instagram'] }}" target="_blank" style="color: #e1306c;" title="Instagram"><i class="fa-brands fa-instagram"></i></a>
              @endif
              @if(!empty($settings['youtube']))
                <a href="{{ $settings['youtube'] }}" target="_blank" style="color: #ff0000;" title="YouTube"><i class="fa-brands fa-youtube"></i></a>
              @endif
            </div>
          </div>
        </div>
        @endif
      </div>
    </div>

    <div class="card-box kontak-card">
      <h2><i class="fa-solid fa-paper-plane"></i> Kirim Pesan</h2>
      <form action="#" method="POST" style="display: flex; flex-direction: column; gap: 16px;">
        <div>
          <label class="kontak-form-label" style="display: block; font-weight: 600; margin-bottom: 6px;">Nama Lengkap</label>
          <input type="text" placeholder="Masukkan nama Anda" class="kontak-form-input" style="width: 100%; box-sizing: border-box; border: 1px solid var(--border); border-radius: 8px; font-family: inherit;">
        </div>
        <div>
          <label class="kontak-form-label" style="display: block; font-weight: 600; margin-bottom: 6px;">Email / No. HP</label>
          <input type="text" placeholder="Masukkan kontak Anda" class="kontak-form-input" style="width: 100%; box-sizing: border-box; border: 1px solid var(--border); border-radius: 8px; font-family: inherit;">
        </div>
        <div>
          <label class="kontak-form-label" style="display: block; font-weight: 600; margin-bottom: 6px;">Pesan / Pertanyaan</label>
          <textarea rows="4" placeholder="Tuliskan pesan Anda..." class="kontak-form-input" style="width: 100%; box-sizing: border-box; border: 1px solid var(--border); border-radius: 8px; font-family: inherit;"></textarea>
        </div>
        <button type="button" class="btn-login" style="border: none; cursor: pointer; justify-content: center; padding: 12px; width: 100%; box-sizing: border-box;"><i class="fa-solid fa-paper-plane"></i> Kirim Pesan</button>
      </form>
    </div>
  </div>

  @if(!empty($settings['maps_embed']))
  <div class="card-box" style="margin-top: 30px;">
    <h2 style="color: var(--primary); margin-bottom: 16px;"><i class="fa-solid fa-map-location-dot"></i> Peta Lokasi Sekolah</h2>
    <div class="kontak-map" style="border-radius: 12px; overflow: hidden; width: 100%; border: 1px solid var(--border);">
      @if(str_contains($settings['maps_embed'], '<iframe'))
        {!! $settings['maps_embed'] !!}
      @else
        <iframe src="{{ $settings['maps_embed'] }}" width="100%" height="380" style="border:0; border-radius: 8px; max-width: 100%;" allowfullscreen="" loading="lazy"></iframe>
      @endif
    </div>
  </div>
  @endif
</div>
@endsection
