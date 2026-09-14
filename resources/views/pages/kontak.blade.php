@extends('layouts.app')

@section('title', 'Kontak & Lokasi - ' . ($settings['school_name'] ?? 'SD Negeri Lama'))

@section('content')
<div class="page-header">
  <h1>Hubungi Kami</h1>
  <p>Layanan informasi dan alamat lokasi {{ $settings['school_name'] ?? 'SD Negeri Lama' }}</p>
</div>

<div class="page-content">
  <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 30px;">
    <div class="card-box">
      <h2 style="font-size: 1.5rem; color: var(--primary); margin-bottom: 20px;"><i class="fa-solid fa-address-card"></i> Informasi Kontak</h2>
      <div style="display: flex; flex-direction: column; gap: 20px;">
        <div style="display: flex; gap: 16px; align-items: flex-start;">
          <div style="width: 44px; height: 44px; background: #dbeafe; color: var(--primary); border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.2rem;"><i class="fa-solid fa-location-dot"></i></div>
          <div>
            <h4 style="font-size: 1rem; font-weight: 700;">Alamat Sekolah</h4>
            <p style="color: var(--muted); font-size: 0.95rem;">{{ $settings['address'] ?? 'Jl. Pendidikan No. 45, Indonesia' }}</p>
          </div>
        </div>

        <div style="display: flex; gap: 16px; align-items: flex-start;">
          <div style="width: 44px; height: 44px; background: #dbeafe; color: var(--primary); border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.2rem;"><i class="fa-solid fa-phone"></i></div>
          <div>
            <h4 style="font-size: 1rem; font-weight: 700;">Telepon / Whatsapp</h4>
            <p style="color: var(--muted); font-size: 0.95rem;">{{ $settings['phone'] ?? '(021) 555-0192' }}</p>
          </div>
        </div>

        <div style="display: flex; gap: 16px; align-items: flex-start;">
          <div style="width: 44px; height: 44px; background: #dbeafe; color: var(--primary); border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.2rem;"><i class="fa-solid fa-envelope"></i></div>
          <div>
            <h4 style="font-size: 1rem; font-weight: 700;">Email Resmi</h4>
            <p style="color: var(--muted); font-size: 0.95rem;">{{ $settings['email'] ?? 'info@sdnegerilama.sch.id' }}</p>
          </div>
        </div>
      </div>
    </div>

    <div class="card-box">
      <h2 style="font-size: 1.5rem; color: var(--primary); margin-bottom: 20px;"><i class="fa-solid fa-paper-plane"></i> Kirim Pesan</h2>
      <form action="#" method="POST" style="display: flex; flex-direction: column; gap: 16px;">
        <div>
          <label style="display: block; font-weight: 600; font-size: 0.9rem; margin-bottom: 6px;">Nama Lengkap</label>
          <input type="text" placeholder="Masukkan nama Anda" style="width: 100%; padding: 12px; border: 1px solid var(--border); border-radius: 8px; font-family: inherit;">
        </div>
        <div>
          <label style="display: block; font-weight: 600; font-size: 0.9rem; margin-bottom: 6px;">Email / No. HP</label>
          <input type="text" placeholder="Masukkan kontak Anda" style="width: 100%; padding: 12px; border: 1px solid var(--border); border-radius: 8px; font-family: inherit;">
        </div>
        <div>
          <label style="display: block; font-weight: 600; font-size: 0.9rem; margin-bottom: 6px;">Pesan / Pertanyaan</label>
          <textarea rows="4" placeholder="Tuliskan pesan Anda..." style="width: 100%; padding: 12px; border: 1px solid var(--border); border-radius: 8px; font-family: inherit;"></textarea>
        </div>
        <button type="button" class="btn-login" style="border: none; cursor: pointer; justify-content: center; padding: 12px;"><i class="fa-solid fa-paper-plane"></i> Kirim Pesan</button>
      </form>
    </div>
  </div>
</div>
@endsection
