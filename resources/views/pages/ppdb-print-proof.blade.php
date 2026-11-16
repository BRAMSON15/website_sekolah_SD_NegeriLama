<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Bukti Pendaftaran PPDB - {{ $registration->registration_number }} - {{ $registration->student_name }}</title>
    
    <!-- Google Font & FontAwesome -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    
    <style>
        :root {
            --primary: #1e3a8a;
            --primary-light: #2563eb;
            --text-dark: #0f172a;
            --text-muted: #64748b;
            --border-color: #cbd5e1;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Plus Jakarta Sans', Arial, sans-serif;
            background-color: #f1f5f9;
            color: var(--text-dark);
            line-height: 1.4;
            padding: 24px 16px;
        }

        /* TOOLBAR ATAS (HILANG SAAT DI-PRINT) */
        .no-print-toolbar {
            max-width: 820px;
            margin: 0 auto 20px;
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 14px 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            gap: 12px;
            flex-wrap: wrap;
        }

        .toolbar-left {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .toolbar-left .info-title {
            font-size: 0.92rem;
            font-weight: 700;
            color: var(--text-dark);
        }

        .toolbar-left .info-sub {
            font-size: 0.78rem;
            color: var(--text-muted);
        }

        .toolbar-actions {
            display: flex;
            align-items: center;
            gap: 10px;
            flex-wrap: wrap;
        }

        .btn-action {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 9px 18px;
            border-radius: 8px;
            font-weight: 700;
            font-size: 0.85rem;
            text-decoration: none;
            cursor: pointer;
            border: none;
            transition: all 0.2s;
        }

        .btn-print {
            background: #1e3a8a;
            color: #ffffff;
        }

        .btn-print:hover {
            background: #1e40af;
            transform: translateY(-1px);
        }

        .btn-download {
            background: #059669;
            color: #ffffff;
        }

        .btn-download:hover {
            background: #047857;
            transform: translateY(-1px);
        }

        .btn-back {
            background: #f1f5f9;
            color: #475569;
            border: 1px solid #cbd5e1;
        }

        .btn-back:hover {
            background: #e2e8f0;
            color: #1e293b;
        }

        /* LEMBAR KERTAS CETAK (A4 SIMULASI) */
        .paper-sheet {
            max-width: 820px;
            margin: 0 auto;
            background: #ffffff;
            padding: 40px 48px;
            border-radius: 8px;
            box-shadow: 0 6px 24px rgba(0, 0, 0, 0.08);
            border: 1px solid #e2e8f0;
        }

        /* KOP SURAT */
        .kop-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 8px;
        }

        .kop-table td {
            vertical-align: middle;
            padding: 0;
        }

        .kop-logo {
            width: 78px;
            height: 78px;
            object-fit: contain;
        }

        .kop-content {
            text-align: center;
            padding: 0 16px;
        }

        .kop-instansi {
            font-size: 11.5pt;
            font-weight: 700;
            color: #0f172a;
            letter-spacing: 0.8px;
            text-transform: uppercase;
            margin: 0;
        }

        .kop-dinas {
            font-size: 10.5pt;
            font-weight: 700;
            color: #0f172a;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            margin: 2px 0;
        }

        .kop-school {
            font-size: 16pt;
            font-weight: 800;
            color: #1e3a8a;
            letter-spacing: 1px;
            text-transform: uppercase;
            margin: 2px 0 4px;
        }

        .kop-meta {
            font-size: 8pt;
            color: #475569;
            line-height: 1.35;
        }

        .kop-divider {
            border-top: 2.5px solid #0f172a;
            border-bottom: 1px solid #0f172a;
            height: 2px;
            margin: 6px 0 16px;
        }

        /* JUDUL DOKUMEN */
        .doc-header {
            text-align: center;
            margin-bottom: 16px;
        }

        .doc-header h2 {
            font-size: 12.5pt;
            font-weight: 800;
            color: #0f172a;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin: 0 0 4px;
        }

        .doc-header p {
            font-size: 8.5pt;
            color: #64748b;
            font-weight: 500;
            margin: 0;
        }

        /* REGISTRATION BOX */
        .reg-highlight-box {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: #f8fafc;
            border: 1.5px solid #cbd5e1;
            border-radius: 8px;
            padding: 10px 16px;
            margin-bottom: 16px;
        }

        .reg-highlight-number {
            font-family: 'JetBrains Mono', monospace;
            font-size: 13.5pt;
            font-weight: 800;
            color: #1e40af;
            letter-spacing: 1px;
        }

        .reg-highlight-meta {
            font-size: 7.8pt;
            color: #64748b;
            margin-top: 2px;
        }

        .badge-status-pill {
            padding: 4px 10px;
            border-radius: 999px;
            font-size: 8pt;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        .status-diterima {
            background: #dcfce7;
            color: #15803d;
            border: 1px solid #86efac;
        }

        .status-ditolak {
            background: #fee2e2;
            color: #b91c1c;
            border: 1px solid #fca5a5;
        }

        .status-pending {
            background: #fef3c7;
            color: #b45309;
            border: 1px solid #fcd34d;
        }

        /* SECTION HEADINGS */
        .section-bar {
            background-color: #1e3a8a;
            color: #ffffff;
            font-size: 8.5pt;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 5px 10px;
            border-radius: 4px;
            margin: 14px 0 8px;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        /* DATA TABLES */
        .data-grid-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 8.5pt;
            margin-bottom: 10px;
        }

        .data-grid-table td {
            padding: 4px 6px;
            vertical-align: top;
            border-bottom: 1px dashed #e2e8f0;
        }

        .data-grid-table td.lbl {
            width: 28%;
            font-weight: 600;
            color: #475569;
        }

        .data-grid-table td.sep {
            width: 3%;
            text-align: center;
            color: #64748b;
        }

        .data-grid-table td.val {
            width: 69%;
            color: #0f172a;
            font-weight: 500;
        }

        /* CHECKLIST TABLE */
        .check-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 8pt;
            margin-bottom: 12px;
        }

        .check-table th {
            background: #f1f5f9;
            color: #334155;
            font-weight: 700;
            padding: 6px 8px;
            border: 1px solid #cbd5e1;
            text-align: left;
        }

        .check-table td {
            padding: 5px 8px;
            border: 1px solid #cbd5e1;
            vertical-align: middle;
        }

        .badge-check {
            display: inline-block;
            padding: 2px 7px;
            border-radius: 4px;
            font-weight: 700;
            font-size: 7.5pt;
        }

        .badge-uploaded {
            background: #dcfce7;
            color: #166534;
        }

        .badge-missing {
            background: #fee2e2;
            color: #991b1b;
        }

        .badge-optional {
            background: #f1f5f9;
            color: #64748b;
        }

        /* NOTICE BOX */
        .notice-card {
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

        .notice-card strong {
            color: #0f172a;
            font-size: 8.2pt;
            display: block;
            margin-bottom: 4px;
        }

        .notice-card ol {
            margin: 0;
            padding-left: 16px;
        }

        .notice-card li {
            margin-bottom: 2px;
        }

        /* SIGNATURE SECTION */
        .signature-grid {
            width: 100%;
            border-collapse: collapse;
            margin-top: 18px;
            page-break-inside: avoid;
        }

        .signature-grid td {
            width: 50%;
            vertical-align: top;
            text-align: center;
            font-size: 8.5pt;
        }

        .sig-date {
            margin-bottom: 6px;
            font-weight: 500;
        }

        .sig-title {
            font-weight: 700;
            color: #0f172a;
            margin-bottom: 65px;
        }

        .sig-name {
            font-weight: 800;
            color: #0f172a;
            text-decoration: underline;
        }

        .sig-sub {
            font-size: 7.8pt;
            color: #64748b;
            margin-top: 2px;
        }

        /* WATERMARK / VERIFICATION FOOTER */
        .doc-footer-meta {
            margin-top: 24px;
            padding-top: 8px;
            border-top: 1px solid #e2e8f0;
            display: flex;
            align-items: center;
            justify-content: space-between;
            font-size: 7pt;
            color: #94a3b8;
        }

        /* PRINT MEDIA STYLES */
        @media print {
            body {
                background: #ffffff !important;
                padding: 0 !important;
                margin: 0 !important;
            }

            .no-print-toolbar {
                display: none !important;
            }

            .paper-sheet {
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
</head>
<body>

    <!-- TOOLBAR (HANYA DITAMPILKAN DI LAYAR) -->
    <div class="no-print-toolbar">
        <div class="toolbar-left">
            <div style="width: 40px; height: 40px; border-radius: 8px; background: #eff6ff; color: #1e3a8a; display: grid; place-items: center; font-size: 1.2rem;">
                <i class="fa-solid fa-file-invoice"></i>
            </div>
            <div>
                <div class="info-title">Lembar Bukti Pendaftaran PPDB Online</div>
                <div class="info-sub">No. Registrasi: <strong>{{ $registration->registration_number }}</strong> &bull; {{ $registration->student_name }}</div>
            </div>
        </div>

        <div class="toolbar-actions">
            <a href="{{ route('ppdb.success', $registration) }}" class="btn-action btn-back">
                <i class="fa-solid fa-arrow-left"></i> Kembali
            </a>
            <a href="{{ route('ppdb.download.proof', $registration) }}" class="btn-action btn-download">
                <i class="fa-solid fa-download"></i> Unduh PDF
            </a>
            <button type="button" onclick="window.print()" class="btn-action btn-print">
                <i class="fa-solid fa-print"></i> Cetak / Simpan PDF
            </button>
        </div>
    </div>

    <!-- KERTAS DOKUMEN RESMI (A4) -->
    <div class="paper-sheet">

        <!-- KOP SURAT RESMI -->
        <table class="kop-table">
            <tr>
                <td style="width: 80px; text-align: left;">
                    <img src="{{ asset('mentahan2/img/Logo1.png') }}" class="kop-logo" alt="Logo Sekolah" onerror="this.src='{{ asset('mentahan/img/Logo1.png') }}'">
                </td>
                <td class="kop-content">
                    <div class="kop-instansi">PEMERINTAH KOTA AMBON</div>
                    <div class="kop-dinas">DINAS PENDIDIKAN</div>
                    <div class="kop-school">{{ strtoupper($settings['school_name'] ?? 'SD NEGERI LAMA') }}</div>
                    <div class="kop-meta">
                        {{ $settings['school_address'] ?? $settings['address'] ?? 'Jl. Guru L. Nanlohy, Desa Negeri Lama, Kec. Baguala, Kota Ambon, Maluku' }}<br>
                        Telepon: {{ $settings['phone'] ?? '(0911) 361234' }} &bull; Pos-el: {{ $settings['email'] ?? 'sdnegerilama@ambonkota.sch.id' }} &bull; NPSN: {{ $settings['npsn'] ?? '60101992' }}
                    </div>
                </td>
                <td style="width: 80px; text-align: right;">
                    <!-- Simulasi QR Code Verifikasi -->
                    <div style="display: inline-block; text-align: center; border: 1px solid #cbd5e1; border-radius: 6px; padding: 4px; background: #ffffff;">
                        <svg width="68" height="68" viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect width="100" height="100" fill="#FFFFFF"/>
                            <!-- QR Pattern Elements -->
                            <rect x="5" y="5" width="30" height="30" rx="3" fill="#0F172A"/>
                            <rect x="10" y="10" width="20" height="20" rx="2" fill="#FFFFFF"/>
                            <rect x="14" y="14" width="12" height="12" rx="1" fill="#1E3A8A"/>
                            
                            <rect x="65" y="5" width="30" height="30" rx="3" fill="#0F172A"/>
                            <rect x="70" y="10" width="20" height="20" rx="2" fill="#FFFFFF"/>
                            <rect x="74" y="14" width="12" height="12" rx="1" fill="#1E3A8A"/>
                            
                            <rect x="5" y="65" width="30" height="30" rx="3" fill="#0F172A"/>
                            <rect x="10" y="70" width="20" height="20" rx="2" fill="#FFFFFF"/>
                            <rect x="14" y="74" width="12" height="12" rx="1" fill="#1E3A8A"/>
                            
                            <!-- Internal Data Points -->
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
                        <div style="font-size: 6pt; color: #64748b; font-weight: 700; margin-top: 1px;">VERIFIKASI</div>
                    </div>
                </td>
            </tr>
        </table>

        <div class="kop-divider"></div>

        <!-- JUDUL DOKUMEN -->
        <div class="doc-header">
            <h2>Tanda Bukti Pendaftaran Peserta Didik Baru</h2>
            <p>Penerimaan Peserta Didik Baru (PPDB Online) &bull; Tahun Ajaran {{ date('Y') }}/{{ date('Y') + 1 }}</p>
        </div>

        <!-- REGISTRATION HIGHLIGHT BOX -->
        <div class="reg-highlight-box">
            <div>
                <span style="font-size: 7.5pt; color: #64748b; font-weight: 700; text-transform: uppercase; display: block;">Nomor Registrasi PPDB:</span>
                <span class="reg-highlight-number">{{ $registration->registration_number }}</span>
                <div class="reg-highlight-meta">
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
                    <span class="badge-status-pill status-diterima"><i class="fa-solid fa-circle-check"></i> DITERIMA</span>
                @elseif($st === 'ditolak' || $st === 'rejected')
                    <span class="badge-status-pill status-ditolak"><i class="fa-solid fa-circle-xmark"></i> DITOLAK</span>
                @else
                    <span class="badge-status-pill status-pending"><i class="fa-solid fa-clock"></i> MENUNGGU VERIFIKASI</span>
                @endif
            </div>
        </div>

        <!-- I. DATA CALON SISWA -->
        <div class="section-bar">
            <i class="fa-solid fa-user-graduate"></i> I. Data Calon Peserta Didik
        </div>
        <table class="data-grid-table">
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
        <div class="section-bar">
            <i class="fa-solid fa-users"></i> II. Data Orang Tua / Wali
        </div>
        <table class="data-grid-table">
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
        <div class="section-bar">
            <i class="fa-solid fa-clipboard-check"></i> III. Status Kelengkapan Berkas Persyaratan
        </div>
        <table class="check-table">
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
                        <span class="badge-check badge-uploaded"><i class="fa-solid fa-check"></i> Sudah Diunggah</span>
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
                            <span class="badge-check badge-uploaded"><i class="fa-solid fa-check"></i> Sudah Diunggah</span>
                        @else
                            <span class="badge-check badge-missing"><i class="fa-solid fa-xmark"></i> Belum Diunggah</span>
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
                            <span class="badge-check badge-uploaded"><i class="fa-solid fa-check"></i> Sudah Diunggah</span>
                        @else
                            <span class="badge-check badge-optional">Opsional / Belum</span>
                        @endif
                    </td>
                    <td style="text-align: center; color: #64748b; font-size: 7.5pt;">
                        [ &nbsp; ] Sesuai &nbsp; [ &nbsp; ] Tidak
                    </td>
                </tr>
            </tbody>
        </table>

        <!-- PETUNJUK VERIFIKASI -->
        <div class="notice-card">
            <strong><i class="fa-solid fa-circle-info" style="color: #1e3a8a; margin-right: 4px;"></i> PENTING &bull; PETUNJUK VERIFIKASI BERKAS FISIK DI SEKOLAH:</strong>
            <ol>
                <li>Lembar Tanda Bukti Pendaftaran ini <strong>wajib dicetak dan dibawa</strong> pada saat verifikasi berkas langsung ke sekolah.</li>
                <li>Membawa berkas asli beserta 1 rangkap fotokopi: <strong>Kartu Keluarga (KK), Akta Kelahiran, dan KTP Orang Tua/Wali</strong>.</li>
                <li>Waktu verifikasi berkas: <strong>Senin s.d. Jumat pukul 08.00 - 13.00 WIT</strong> di Ruang Sekretariat PPDB {{ $settings['school_name'] ?? 'SD Negeri Lama' }}.</li>
                <li>Pengumuman penetapan siswa diterima dapat dipantau secara berkala melalui portal website resmi: <strong>{{ url('/') }}</strong>.</li>
            </ol>
        </div>

        <!-- TANDA TANGAN -->
        <table class="signature-grid">
            <tr>
                <td>
                    <div class="sig-date">&nbsp;</div>
                    <div class="sig-title">Orang Tua / Wali Calon Siswa,</div>
                    <div class="sig-name">( {{ $registration->parent_name }} )</div>
                    <div class="sig-sub">Tanda Tangan & Nama Terang</div>
                </td>
                <td>
                    <div class="sig-date">Ambon, {{ date('d F Y') }}</div>
                    <div class="sig-title">Panitia Verifikasi PPDB Sekolah,</div>
                    <div class="sig-name">( ............................................................ )</div>
                    <div class="sig-sub">NIP. ....................................................</div>
                </td>
            </tr>
        </table>

        <!-- FOOTER DOKUMEN -->
        <div class="doc-footer-meta">
            <span>Dokumen dicetak secara resmi melalui Portal PPDB Online {{ $settings['school_name'] ?? 'SD Negeri Lama' }} &bull; {{ date('d/m/Y H:i') }} WIT</span>
            <span>ID Registrasi: #{{ $registration->id }} &bull; Hal: 1 / 1</span>
        </div>

    </div>

</body>
</html>
