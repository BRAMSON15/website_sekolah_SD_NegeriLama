@extends('layouts.app')

@section('title', 'Bukti Pendaftaran PPDB - ' . ($settings['school_name'] ?? 'SD Negeri Lama'))

@section('content')
<style>
  /* Screen Presentation Styles */
  .success-header-banner {
    background-image: linear-gradient(rgba(15, 23, 42, 0.72), rgba(30, 64, 175, 0.72)), url('{{ asset('mentahan2/img/image1.png') }}');
    background-size: cover;
    background-position: center;
    padding: 50px 6% 85px;
    color: #ffffff;
    text-align: center;
  }
  .success-banner-chip {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: rgba(34, 197, 94, 0.25);
    border: 1px solid rgba(74, 222, 128, 0.5);
    color: #bbf7d0;
    padding: 6px 16px;
    border-radius: 999px;
    font-size: 0.82rem;
    font-weight: 700;
    margin-bottom: 12px;
  }
  .success-banner-title {
    font-size: 2rem;
    font-weight: 800;
    margin-bottom: 8px;
    color: #ffffff;
  }
  .success-banner-desc {
    font-size: 0.98rem;
    color: #cbd5e1;
    max-width: 650px;
    margin: 0 auto;
  }

  .success-content-wrapper {
    max-width: 900px;
    margin: -50px auto 60px;
    padding: 0 16px;
    position: relative;
    z-index: 5;
  }

  /* Action Bar Card */
  .action-box-card {
    background: #ffffff;
    border-radius: 14px;
    padding: 24px 28px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
    border: 1px solid #e2e8f0;
    margin-bottom: 24px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 16px;
    flex-wrap: wrap;
  }
  .action-box-info h3 {
    font-size: 1.25rem;
    font-weight: 800;
    color: #0f172a;
    margin-bottom: 4px;
  }
  .action-box-info p {
    font-size: 0.88rem;
    color: #64748b;
    margin: 0;
  }
  .action-btn-group {
    display: flex;
    align-items: center;
    gap: 10px;
    flex-wrap: wrap;
  }
  .btn-print-action {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 10px 20px;
    border-radius: 9px;
    font-size: 0.88rem;
    font-weight: 700;
    text-decoration: none;
    cursor: pointer;
    border: none;
    transition: all 0.2s;
  }
  .btn-print-primary {
    background: #1e3a8a;
    color: #ffffff;
    box-shadow: 0 4px 12px rgba(30, 58, 138, 0.2);
  }
  .btn-print-primary:hover {
    background: #1e40af;
    color: #ffffff;
    transform: translateY(-1px);
  }
  .btn-download-pdf {
    background: #059669;
    color: #ffffff;
    box-shadow: 0 4px 12px rgba(5, 150, 105, 0.2);
  }
  .btn-download-pdf:hover {
    background: #047857;
    color: #ffffff;
    transform: translateY(-1px);
  }
  .btn-back-link {
    background: #f1f5f9;
    color: #475569;
    border: 1px solid #cbd5e1;
  }
  .btn-back-link:hover {
    background: #e2e8f0;
    color: #0f172a;
  }

  /* Official Printable Sheet Container */
  .official-proof-sheet {
    background: #ffffff;
    border-radius: 12px;
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.08);
    border: 1px solid #cbd5e1;
    padding: 40px 48px;
    color: #0f172a;
  }

  .proof-kop-table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 6px;
  }
  .proof-kop-table td {
    vertical-align: middle;
    padding: 0;
  }
  .proof-kop-logo {
    width: 75px;
    height: 75px;
    object-fit: contain;
  }
  .proof-kop-center {
    text-align: center;
    padding: 0 12px;
  }
  .proof-kop-instansi {
    font-size: 11pt;
    font-weight: 700;
    letter-spacing: 0.8px;
    text-transform: uppercase;
    color: #0f172a;
    margin: 0;
  }
  .proof-kop-dinas {
    font-size: 10pt;
    font-weight: 700;
    letter-spacing: 0.5px;
    text-transform: uppercase;
    color: #0f172a;
    margin: 2px 0;
  }
  .proof-kop-school {
    font-size: 15.5pt;
    font-weight: 800;
    color: #1e3a8a;
    letter-spacing: 1px;
    text-transform: uppercase;
    margin: 2px 0 4px;
  }
  .proof-kop-meta {
    font-size: 8pt;
    color: #475569;
    line-height: 1.35;
  }
  .proof-kop-line {
    border-top: 2.5px solid #0f172a;
    border-bottom: 1px solid #0f172a;
    height: 2px;
    margin: 6px 0 16px;
  }

  .proof-title-area {
    text-align: center;
    margin-bottom: 16px;
  }
  .proof-title-area h2 {
    font-size: 12.5pt;
    font-weight: 800;
    text-transform: uppercase;
    color: #0f172a;
    margin: 0 0 3px;
    letter-spacing: 0.5px;
  }
  .proof-title-area p {
    font-size: 8.5pt;
    color: #64748b;
    margin: 0;
  }

  .proof-reg-banner {
    display: flex;
    align-items: center;
    justify-content: space-between;
    background: #f8fafc;
    border: 1.5px solid #cbd5e1;
    border-radius: 8px;
    padding: 10px 16px;
    margin-bottom: 16px;
  }
  .proof-reg-code {
    font-family: 'Courier New', monospace;
    font-size: 13.5pt;
    font-weight: 800;
    color: #1e40af;
    letter-spacing: 1px;
  }

  .proof-section-bar {
    background: #1e3a8a;
    color: #ffffff;
    font-size: 8.5pt;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    padding: 5px 10px;
    border-radius: 4px;
    margin: 14px 0 8px;
  }

  .proof-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 8.5pt;
    margin-bottom: 10px;
  }
  .proof-table td {
    padding: 4px 6px;
    vertical-align: top;
    border-bottom: 1px dashed #e2e8f0;
  }
  .proof-table td.lbl {
    width: 28%;
    font-weight: 600;
    color: #475569;
  }
  .proof-table td.sep {
    width: 3%;
    text-align: center;
    color: #64748b;
  }
  .proof-table td.val {
    width: 69%;
    color: #0f172a;
    font-weight: 500;
  }

  .proof-check-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 8pt;
    margin-bottom: 12px;
  }
  .proof-check-table th {
    background: #f1f5f9;
    color: #334155;
    font-weight: 700;
    padding: 6px 8px;
    border: 1px solid #cbd5e1;
    text-align: left;
  }
  .proof-check-table td {
    padding: 5px 8px;
    border: 1px solid #cbd5e1;
    vertical-align: middle;
  }

  .proof-notice {
    background: #f8fafc;
    border: 1px solid #cbd5e1;
    border-left: 4px solid #1e3a8a;
    border-radius: 6px;
    padding: 9px 12px;
    margin: 14px 0;
    font-size: 8pt;
    color: #334155;
    line-height: 1.45;
  }
  .proof-notice strong {
    color: #0f172a;
    display: block;
    margin-bottom: 4px;
  }
  .proof-notice ol {
    margin: 0;
    padding-left: 16px;
  }

  .proof-signature-grid {
    width: 100%;
    border-collapse: collapse;
    margin-top: 18px;
    page-break-inside: avoid;
  }
  .proof-signature-grid td {
    width: 50%;
    text-align: center;
    vertical-align: top;
    font-size: 8.5pt;
  }

  /* PRINT RULES */
  @media print {
    body {
      background: #ffffff !important;
      padding: 0 !important;
      margin: 0 !important;
    }
    .top-bar, .navbar, .mobile-nav-dropdown, .mobile-nav-overlay, footer, .success-header-banner, .action-box-card {
      display: none !important;
    }
    .success-content-wrapper {
      margin: 0 !important;
      padding: 0 !important;
      max-width: 100% !important;
      width: 100% !important;
    }
    .official-proof-sheet {
      box-shadow: none !important;
      border: none !important;
      border-radius: 0 !important;
      padding: 0 !important;
      max-width: 100% !important;
      width: 100% !important;
    }
    * {
      -webkit-print-color-adjust: exact !important;
      print-color-adjust: exact !important;
    }
    @page {
      size: A4 portrait;
      margin: 1.2cm 1.5cm;
    }
  }
</style>

<!-- Banner Sukses -->
<div class="success-header-banner">
  <div class="success-banner-chip">
    <i class="fa-solid fa-circle-check"></i> Pendaftaran Berhasil Dikirim
  </div>
  <h1 class="success-banner-title">Bukti Pendaftaran PPDB Online</h1>
  <p class="success-banner-desc">
    Data calon peserta didik telah berhasil tersimpan di sistem. Silakan cetak atau unduh lembar tanda bukti pendaftaran di bawah ini untuk dibawa saat verifikasi berkas di sekolah.
  </p>
</div>

<!-- Konten & Bukti Pendaftaran -->
<div class="success-content-wrapper">

  <!-- Action Box -->
  <div class="action-box-card">
    <div class="action-box-info">
      <h3>Halo, {{ $registration->parent_name }}</h3>
      <p>Nomor Registrasi Calon Siswa: <strong style="color: #1e3a8a;">{{ $registration->registration_number }}</strong> ({{ $registration->student_name }})</p>
    </div>

    <div class="action-btn-group">
      <a href="{{ route('ppdb') }}" class="btn-print-action btn-back-link">
        <i class="fa-solid fa-arrow-left"></i> Kembali
      </a>
      <a href="{{ route('ppdb.download.proof', $registration) }}" class="btn-print-action btn-download-pdf">
        <i class="fa-solid fa-file-pdf"></i> Unduh PDF
      </a>
      <a href="{{ route('ppdb.print', $registration) }}" target="_blank" class="btn-print-action btn-print-primary">
        <i class="fa-solid fa-print"></i> Cetak Lembar Bukti
      </a>
    </div>
  </div>

  <!-- LEMBAR RESMI TANDA BUKTI PENDAFTARAN -->
  <div class="official-proof-sheet" id="printableProofSheet">

    <!-- KOP SURAT -->
    <table class="proof-kop-table">
      <tr>
        <td style="width: 75px; text-align: left;">
          <img src="{{ asset('mentahan2/img/Logo1.png') }}" class="proof-kop-logo" alt="Logo Sekolah" onerror="this.src='{{ asset('mentahan/img/Logo1.png') }}'">
        </td>
        <td class="proof-kop-center">
          <div class="proof-kop-instansi">PEMERINTAH KOTA AMBON</div>
          <div class="proof-kop-dinas">DINAS PENDIDIKAN</div>
          <div class="proof-kop-school">{{ strtoupper($settings['school_name'] ?? 'SD NEGERI LAMA') }}</div>
          <div class="proof-kop-meta">
            {{ $settings['school_address'] ?? $settings['address'] ?? 'Jl. Guru L. Nanlohy, Desa Negeri Lama, Kec. Baguala, Kota Ambon, Maluku' }}<br>
            Telepon: {{ $settings['phone'] ?? '(0911) 361234' }} &bull; Pos-el: {{ $settings['email'] ?? 'sdnegerilama@ambonkota.sch.id' }} &bull; NPSN: {{ $settings['npsn'] ?? '60101992' }}
          </div>
        </td>
        <td style="width: 75px; text-align: right;">
          <!-- SVG QR Code Verification Stamp -->
          <div style="display: inline-block; text-align: center; border: 1px solid #cbd5e1; border-radius: 6px; padding: 4px; background: #ffffff;">
            <svg width="65" height="65" viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg">
              <rect width="100" height="100" fill="#FFFFFF"/>
              <rect x="5" y="5" width="30" height="30" rx="3" fill="#0F172A"/>
              <rect x="10" y="10" width="20" height="20" rx="2" fill="#FFFFFF"/>
              <rect x="14" y="14" width="12" height="12" rx="1" fill="#1E3A8A"/>
              
              <rect x="65" y="5" width="30" height="30" rx="3" fill="#0F172A"/>
              <rect x="70" y="10" width="20" height="20" rx="2" fill="#FFFFFF"/>
              <rect x="74" y="14" width="12" height="12" rx="1" fill="#1E3A8A"/>
              
              <rect x="5" y="65" width="30" height="30" rx="3" fill="#0F172A"/>
              <rect x="10" y="70" width="20" height="20" rx="2" fill="#FFFFFF"/>
              <rect x="14" y="74" width="12" height="12" rx="1" fill="#1E3A8A"/>
              
              <rect x="42" y="10" width="8" height="8" fill="#1E3A8A"/>
              <rect x="53" y="18" width="6" height="6" fill="#0F172A"/>
              <rect x="42" y="27" width="8" height="8" fill="#1E3A8A"/>
              
              <rect x="12" y="44" width="6" height="6" fill="#0F172A"/>
              <rect x="24" y="48" width="8" height="8" fill="#1E3A8A"/>
              <rect x="42" y="44" width="18" height="18" rx="2" fill="#1E3A8A"/>
              <rect x="46" y="48" width="10" height="10" rx="1" fill="#FFFFFF"/>
              <rect x="68" y="44" width="8" height="8" fill="#0F172A"/>
              <rect x="82" y="48" width="8" height="8" fill="#1E3A8A"/>
              
              <rect x="44" y="70" width="8" height="8" fill="#0F172A"/>
              <rect x="56" y="74" width="8" height="8" fill="#1E3A8A"/>
              <rect x="70" y="66" width="10" height="10" fill="#1E3A8A"/>
              <rect x="84" y="78" width="8" height="8" fill="#0F172A"/>
            </svg>
            <div style="font-size: 6pt; color: #64748b; font-weight: 700; margin-top: 1px;">TERVERIFIKASI</div>
          </div>
        </td>
      </tr>
    </table>

    <div class="proof-kop-line"></div>

    <!-- JUDUL DOKUMEN -->
    <div class="proof-title-area">
      <h2>Tanda Bukti Pendaftaran Peserta Didik Baru</h2>
      <p>Penerimaan Peserta Didik Baru (PPDB Online) &bull; Tahun Ajaran {{ date('Y') }}/{{ date('Y') + 1 }}</p>
    </div>

    <!-- REGISTRATION HIGHLIGHT BOX -->
    <div class="proof-reg-banner">
      <div>
        <span style="font-size: 7.5pt; color: #64748b; font-weight: 700; text-transform: uppercase; display: block;">Nomor Registrasi PPDB:</span>
        <span class="proof-reg-code">{{ $registration->registration_number }}</span>
        <div style="font-size: 7.8pt; color: #64748b; margin-top: 2px;">
          <i class="fa-regular fa-calendar-check" style="color: #2563eb;"></i> Tanggal Registrasi: 
          <strong>{{ $registration->created_at ? $registration->created_at->translatedFormat('d F Y, H:i') : date('d F Y, H:i') }} WIT</strong>
        </div>
      </div>

      <div style="text-align: right;">
        <span style="font-size: 7.5pt; color: #64748b; display: block; margin-bottom: 3px;">Status Pengajuan:</span>
        @php
          $st = strtolower($registration->status ?? 'pending');
        @endphp
        @if($st === 'diterima' || $st === 'accepted')
          <span class="badge-status-pill status-diterima" style="background: #dcfce7; color: #15803d; border: 1px solid #86efac; padding: 4px 10px; border-radius: 999px; font-size: 8pt; font-weight: 800;">
            <i class="fa-solid fa-circle-check"></i> DITERIMA
          </span>
        @elseif($st === 'ditolak' || $st === 'rejected')
          <span class="badge-status-pill status-ditolak" style="background: #fee2e2; color: #b91c1c; border: 1px solid #fca5a5; padding: 4px 10px; border-radius: 999px; font-size: 8pt; font-weight: 800;">
            <i class="fa-solid fa-circle-xmark"></i> DITOLAK
          </span>
        @else
          <span class="badge-status-pill status-pending" style="background: #fef3c7; color: #b45309; border: 1px solid #fcd34d; padding: 4px 10px; border-radius: 999px; font-size: 8pt; font-weight: 800;">
            <i class="fa-solid fa-clock"></i> MENUNGGU VERIFIKASI
          </span>
        @endif
      </div>
    </div>

    <!-- I. DATA CALON SISWA -->
    <div class="proof-section-bar">
      <i class="fa-solid fa-user-graduate" style="margin-right: 5px;"></i> I. Data Calon Peserta Didik
    </div>
    <table class="proof-table">
      <tr>
        <td class="lbl">Nama Lengkap</td>
        <td class="sep">:</td>
        <td class="val"><strong style="color: #1e3a8a; font-size: 9pt;">{{ strtoupper($registration->student_name) }}</strong></td>
      </tr>
      <tr>
        <td class="lbl">Nomor Induk Kependudukan (NIK)</td>
        <td class="sep">:</td>
        <td class="val">{{ $registration->nik ?: '-' }}</td>
      </tr>
      <tr>
        <td class="lbl">Nomor Kartu Keluarga (KK)</td>
        <td class="sep">:</td>
        <td class="val">{{ $registration->kk_number ?: '-' }}</td>
      </tr>
      <tr>
        <td class="lbl">Tempat, Tanggal Lahir</td>
        <td class="sep">:</td>
        <td class="val">
          {{ $registration->birth_place ?: 'Ambon' }}, 
          {{ $registration->birth_date ? $registration->birth_date->translatedFormat('d F Y') : '-' }}
          @if($registration->birth_date)
            <span style="color: #64748b; font-size: 8pt; font-weight: normal;">(Usia saat mendaftar: <strong>{{ $registration->age }}</strong>)</span>
          @endif
        </td>
      </tr>
      <tr>
        <td class="lbl">Jenis Kelamin</td>
        <td class="sep">:</td>
        <td class="val">
          @if($registration->gender === 'L')
            <span style="font-weight: 700; color: #1e40af;"><i class="fa-solid fa-mars"></i> Laki-laki</span>
          @elseif($registration->gender === 'P')
            <span style="font-weight: 700; color: #db2777;"><i class="fa-solid fa-venus"></i> Perempuan</span>
          @else
            -
          @endif
        </td>
      </tr>
      <tr>
        <td class="lbl">Asal Sekolah (TK / PAUD)</td>
        <td class="sep">:</td>
        <td class="val">{{ $registration->previous_school ?: 'Belum pernah TK / PAUD' }}</td>
      </tr>
      <tr>
        <td class="lbl">Alamat Lengkap</td>
        <td class="sep">:</td>
        <td class="val">{{ $registration->address ?: '-' }}</td>
      </tr>
    </table>

    <!-- II. DATA ORANG TUA / WALI -->
    <div class="proof-section-bar">
      <i class="fa-solid fa-users" style="margin-right: 5px;"></i> II. Data Orang Tua / Wali
    </div>
    <table class="proof-table">
      <tr>
        <td class="lbl">Nama Orang Tua / Wali</td>
        <td class="sep">:</td>
        <td class="val"><strong>{{ $registration->parent_name }}</strong></td>
      </tr>
      <tr>
        <td class="lbl">Nomor HP / WhatsApp</td>
        <td class="sep">:</td>
        <td class="val"><strong>{{ $registration->phone }}</strong></td>
      </tr>
      <tr>
        <td class="lbl">Alamat Email</td>
        <td class="sep">:</td>
        <td class="val">{{ $registration->email ?: '-' }}</td>
      </tr>
    </table>

    <!-- III. KELENGKAPAN BERKAS -->
    <div class="proof-section-bar">
      <i class="fa-solid fa-clipboard-check" style="margin-right: 5px;"></i> III. Status Kelengkapan Berkas Persyaratan
    </div>
    <table class="proof-check-table">
      <thead>
        <tr>
          <th style="width: 30px; text-align: center;">No</th>
          <th>Nama Dokumen Persyaratan</th>
          <th style="width: 140px; text-align: center;">Status Unggah</th>
          <th style="width: 150px; text-align: center;">Paraf Verifikator Fisik</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td style="text-align: center;">1</td>
          <td>Scan / Foto Kartu Keluarga (KK) <span style="color: #dc2626;">*</span></td>
          <td style="text-align: center;">
            <span style="background: #dcfce7; color: #166534; padding: 2px 7px; border-radius: 4px; font-weight: 700; font-size: 7.5pt;">
              <i class="fa-solid fa-check"></i> Sudah Diunggah
            </span>
          </td>
          <td style="text-align: center; color: #64748b; font-size: 7.5pt;">
            [ &nbsp; ] Sesuai &nbsp; [ &nbsp; ] Tidak
          </td>
        </tr>
        <tr>
          <td style="text-align: center;">2</td>
          <td>Scan / Foto Akta Kelahiran</td>
          <td style="text-align: center;">
            @if($registration->supporting_file_akte)
              <span style="background: #dcfce7; color: #166534; padding: 2px 7px; border-radius: 4px; font-weight: 700; font-size: 7.5pt;">
                <i class="fa-solid fa-check"></i> Sudah Diunggah
              </span>
            @else
              <span style="background: #fee2e2; color: #991b1b; padding: 2px 7px; border-radius: 4px; font-weight: 700; font-size: 7.5pt;">
                <i class="fa-solid fa-xmark"></i> Belum Diunggah
              </span>
            @endif
          </td>
          <td style="text-align: center; color: #64748b; font-size: 7.5pt;">
            [ &nbsp; ] Sesuai &nbsp; [ &nbsp; ] Tidak
          </td>
        </tr>
        <tr>
          <td style="text-align: center;">3</td>
          <td>Scan / Foto Rapor / Ijazah TK / Surat Keterangan</td>
          <td style="text-align: center;">
            @if($registration->supporting_file_rapor)
              <span style="background: #dcfce7; color: #166534; padding: 2px 7px; border-radius: 4px; font-weight: 700; font-size: 7.5pt;">
                <i class="fa-solid fa-check"></i> Sudah Diunggah
              </span>
            @else
              <span style="background: #f1f5f9; color: #64748b; padding: 2px 7px; border-radius: 4px; font-weight: 700; font-size: 7.5pt;">
                Opsional / Belum
              </span>
            @endif
          </td>
          <td style="text-align: center; color: #64748b; font-size: 7.5pt;">
            [ &nbsp; ] Sesuai &nbsp; [ &nbsp; ] Tidak
          </td>
        </tr>
      </tbody>
    </table>

    <!-- PETUNJUK VERIFIKASI -->
    <div class="proof-notice">
      <strong><i class="fa-solid fa-circle-info" style="color: #1e3a8a; margin-right: 4px;"></i> PENTING &bull; PETUNJUK VERIFIKASI BERKAS FISIK DI SEKOLAH:</strong>
      <ol>
        <li>Lembar Tanda Bukti Pendaftaran ini <strong>wajib dicetak dan dibawa</strong> pada saat verifikasi berkas langsung ke sekolah.</li>
        <li>Membawa dokumen asli beserta 1 rangkap fotokopi: <strong>Kartu Keluarga (KK), Akta Kelahiran, dan KTP Orang Tua/Wali</strong>.</li>
        <li>Waktu verifikasi berkas: <strong>Senin s.d. Jumat pukul 08.00 - 13.00 WIT</strong> di Ruang Sekretariat PPDB {{ $settings['school_name'] ?? 'SD Negeri Lama' }}.</li>
        <li>Pengumuman penetapan siswa diterima dapat dipantau secara berkala melalui portal website resmi: <strong>{{ url('/') }}</strong>.</li>
      </ol>
    </div>

    <!-- TANDA TANGAN -->
    <table class="proof-signature-grid">
      <tr>
        <td>
          <div style="margin-bottom: 6px;">&nbsp;</div>
          <div style="font-weight: 700; color: #0f172a; margin-bottom: 65px;">Orang Tua / Wali Calon Siswa,</div>
          <div style="font-weight: 800; color: #0f172a; text-decoration: underline;">( {{ $registration->parent_name }} )</div>
          <div style="font-size: 7.8pt; color: #64748b; margin-top: 2px;">Tanda Tangan & Nama Terang</div>
        </td>
        <td>
          <div style="margin-bottom: 6px;">Ambon, {{ date('d F Y') }}</div>
          <div style="font-weight: 700; color: #0f172a; margin-bottom: 65px;">Panitia Verifikasi PPDB Sekolah,</div>
          <div style="font-weight: 800; color: #0f172a; text-decoration: underline;">( ............................................................ )</div>
          <div style="font-size: 7.8pt; color: #64748b; margin-top: 2px;">NIP. ....................................................</div>
        </td>
      </tr>
    </table>

    <!-- FOOTER DOKUMEN -->
    <div style="margin-top: 22px; padding-top: 8px; border-top: 1px solid #e2e8f0; display: flex; align-items: center; justify-content: space-between; font-size: 7pt; color: #94a3b8;">
      <span>Dokumen dicetak melalui Portal PPDB Online {{ $settings['school_name'] ?? 'SD Negeri Lama' }} &bull; {{ date('d/m/Y H:i') }} WIT</span>
      <span>ID Registrasi: #{{ $registration->id }} &bull; Hal: 1 / 1</span>
    </div>

  </div>

</div>
@endsection
