@extends('layouts.app')

@section('title', 'Pendaftaran PPDB - ' . ($settings['school_name'] ?? 'SD Negeri Lama'))

@section('content')
<div class="page-header">
  <h1>Penerimaan Peserta Didik Baru (PPDB)</h1>
  <p>Tahun Ajaran {{ date('Y') }}/{{ date('Y') + 1 }} - {{ $settings['school_name'] ?? 'SD Negeri Lama' }}</p>
</div>

<div class="page-content">
  @php
    $isOpen = ($settings['ppdb_status'] ?? 'open') === 'open';
  @endphp

  <div class="card-box" style="background: {{ $isOpen ? 'linear-gradient(135deg, #eff6ff, #ffffff)' : 'linear-gradient(135deg, #fef2f2, #ffffff)' }}; border-color: {{ $isOpen ? 'var(--primary-light)' : '#fca5a5' }};">
    <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 20px;">
      <div>
        <div style="margin-bottom: 6px;">
          @if($isOpen)
            <span style="background: #dcfce7; color: #166534; padding: 4px 12px; border-radius: 20px; font-weight: 700; font-size: 0.8rem; display: inline-flex; align-items: center; gap: 6px;">
              <i class="fa-solid fa-circle-check"></i> PENDAFTARAN DIBUKA
            </span>
          @else
            <span style="background: #fee2e2; color: #991b1b; padding: 4px 12px; border-radius: 20px; font-weight: 700; font-size: 0.8rem; display: inline-flex; align-items: center; gap: 6px;">
              <i class="fa-solid fa-circle-xmark"></i> PENDAFTARAN DITUTUP
            </span>
          @endif
        </div>
        <h2 style="font-size: 1.5rem; color: {{ $isOpen ? 'var(--primary)' : '#b91c1c' }}; margin-bottom: 8px;">
          <i class="fa-solid fa-bullhorn"></i> {{ $settings['ppdb_batch_title'] ?? 'PPDB Gelombang II Telah Dibuka!' }}
        </h2>
        <p style="color: var(--muted);">{{ $settings['ppdb_batch_desc'] ?? 'Segera daftarkan putra-putri Anda untuk mendapatkan pendidikan terbaik.' }}</p>
      </div>

      @if($isOpen)
        <a href="{{ route('ppdb.register') }}" class="btn-login" style="padding: 14px 28px; font-size: 1rem;"><i class="fa-solid fa-paper-plane"></i> Daftar Sekarang Online</a>
      @else
        <button type="button" class="btn-login" style="padding: 14px 28px; font-size: 1rem; background: #94a3b8; cursor: not-allowed;" disabled><i class="fa-solid fa-lock"></i> Pendaftaran Ditutup</button>
      @endif
    </div>
  </div>

  <div class="card-box">
    <h2 style="font-size: 1.3rem; color: var(--dark); margin-bottom: 16px;"><i class="fa-solid fa-list-check"></i> Syarat Pendaftaran</h2>
    @php
      $defaultRequirements = [
        'Usia minimal 6 tahun per 1 Juli ' . date('Y') . '.',
        'Fotokopi Akta Kelahiran (2 Lembar).',
        'Fotokopi Kartu Keluarga / KK (2 Lembar).',
        'Fotokopi KTP Kedua Orang Tua / Wali (1 Lembar).',
        'Pas Foto Ukuran 3x4 berwarna (4 Lembar).',
        'Fotokopi Ijazah TK / RA (Jika Ada).'
      ];
      if (!empty($settings['ppdb_requirements'])) {
        $reqs = array_filter(array_map('trim', explode("\n", $settings['ppdb_requirements'])));
      } else {
        $reqs = $defaultRequirements;
      }
    @endphp
    <ul style="color: var(--muted); padding-left: 20px; line-height: 2;">
      @foreach($reqs as $req)
        <li>{{ $req }}</li>
      @endforeach
    </ul>
  </div>

  <div class="card-box">
    <h2 style="font-size: 1.3rem; color: var(--dark); margin-bottom: 16px;"><i class="fa-solid fa-timeline"></i> Alur Pendaftaran</h2>
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px; text-align: center;">
      <div style="background: var(--light-bg); padding: 20px; border-radius: 12px;">
        <div style="width: 40px; height: 40px; background: var(--primary); color: #fff; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 10px; font-weight: 800;">1</div>
        <h4 style="font-size: 1rem; margin-bottom: 4px;">{{ $settings['ppdb_step_1_title'] ?? 'Isi Formulir' }}</h4>
        <p style="font-size: 0.85rem; color: var(--muted);">{{ $settings['ppdb_step_1_desc'] ?? 'Melalui portal online atau datang langsung ke sekolah.' }}</p>
      </div>
      <div style="background: var(--light-bg); padding: 20px; border-radius: 12px;">
        <div style="width: 40px; height: 40px; background: var(--primary); color: #fff; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 10px; font-weight: 800;">2</div>
        <h4 style="font-size: 1rem; margin-bottom: 4px;">{{ $settings['ppdb_step_2_title'] ?? 'Verifikasi Berkas' }}</h4>
        <p style="font-size: 0.85rem; color: var(--muted);">{{ $settings['ppdb_step_2_desc'] ?? 'Penyerahan dokumen persyaratan ke panitia PPDB.' }}</p>
      </div>
      <div style="background: var(--light-bg); padding: 20px; border-radius: 12px;">
        <div style="width: 40px; height: 40px; background: var(--primary); color: #fff; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 10px; font-weight: 800;">3</div>
        <h4 style="font-size: 1rem; margin-bottom: 4px;">{{ $settings['ppdb_step_3_title'] ?? 'Pengumuman' }}</h4>
        <p style="font-size: 0.85rem; color: var(--muted);">{{ $settings['ppdb_step_3_desc'] ?? 'Hasil seleksi diumumkan via portal & papan pengumuman.' }}</p>
      </div>
      <div style="background: var(--light-bg); padding: 20px; border-radius: 12px;">
        <div style="width: 40px; height: 40px; background: var(--primary); color: #fff; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 10px; font-weight: 800;">4</div>
        <h4 style="font-size: 1rem; margin-bottom: 4px;">{{ $settings['ppdb_step_4_title'] ?? 'Daftar Ulang' }}</h4>
        <p style="font-size: 0.85rem; color: var(--muted);">{{ $settings['ppdb_step_4_desc'] ?? 'Konfirmasi kehadiran dan kelengkapan seragam.' }}</p>
      </div>
    </div>
  </div>
</div>
@endsection
