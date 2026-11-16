<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tanda Bukti Pendaftaran PPDB - {{ $registration->registration_number }} - {{ $registration->student_name }}</title>
    <style>
        @page {
            size: A4 portrait;
            margin: 1.2cm 1.5cm;
        }
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            color: #0f172a;
            font-size: 9pt;
            line-height: 1.35;
            margin: 0;
            padding: 0;
        }
        .header-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 6px;
        }
        .header-table td {
            vertical-align: middle;
            padding: 0;
        }
        .kop-text {
            text-align: center;
        }
        .kop-text .instansi {
            font-size: 11pt;
            font-weight: bold;
            color: #0f172a;
            letter-spacing: 0.8px;
            margin: 0;
        }
        .kop-text .dinas {
            font-size: 10pt;
            font-weight: bold;
            color: #0f172a;
            letter-spacing: 0.5px;
            margin: 2px 0;
        }
        .kop-text .school-name {
            font-size: 15pt;
            font-weight: 800;
            color: #1e3a8a;
            margin: 2px 0;
            letter-spacing: 1px;
        }
        .kop-text .address {
            font-size: 8pt;
            color: #475569;
            margin: 0;
            line-height: 1.3;
        }
        .kop-divider {
            border-top: 2.5px solid #0f172a;
            border-bottom: 1px solid #0f172a;
            height: 2px;
            margin: 6px 0 14px 0;
        }
        .doc-title {
            text-align: center;
            margin-bottom: 12px;
        }
        .doc-title h2 {
            font-size: 12pt;
            font-weight: bold;
            color: #0f172a;
            margin: 0 0 3px 0;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .doc-title p {
            font-size: 8.5pt;
            color: #64748b;
            margin: 0;
        }
        .reg-badge-box {
            width: 100%;
            border-collapse: collapse;
            background-color: #f8fafc;
            border: 1.5px solid #cbd5e1;
            margin-bottom: 14px;
        }
        .reg-badge-box td {
            padding: 8px 12px;
            vertical-align: middle;
        }
        .reg-number {
            font-family: monospace;
            font-size: 13pt;
            font-weight: bold;
            color: #1e40af;
            letter-spacing: 1px;
        }
        .section-header {
            background-color: #1e3a8a;
            color: #ffffff;
            font-weight: bold;
            font-size: 8.5pt;
            padding: 5px 8px;
            margin-top: 10px;
            margin-bottom: 6px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 8px;
        }
        .data-table td {
            padding: 4px 6px;
            vertical-align: top;
            font-size: 8.5pt;
            border-bottom: 1px dashed #e2e8f0;
        }
        .data-table td.field-label {
            width: 28%;
            color: #475569;
            font-weight: 600;
        }
        .data-table td.field-separator {
            width: 3%;
            text-align: center;
            color: #64748b;
        }
        .data-table td.field-val {
            width: 69%;
            color: #0f172a;
            font-weight: 500;
        }
        .checklist-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 4px;
            margin-bottom: 8px;
            font-size: 8pt;
        }
        .checklist-table th {
            background-color: #f1f5f9;
            color: #334155;
            font-weight: bold;
            padding: 5px 7px;
            border: 1px solid #cbd5e1;
            text-align: left;
        }
        .checklist-table td {
            padding: 4px 7px;
            border: 1px solid #cbd5e1;
            vertical-align: middle;
        }
        .status-badge {
            display: inline-block;
            padding: 2px 6px;
            font-size: 7.5pt;
            font-weight: bold;
            border-radius: 3px;
        }
        .badge-verified {
            background-color: #dcfce7;
            color: #166534;
        }
        .badge-pending {
            background-color: #fef3c7;
            color: #92400e;
        }
        .notice-box {
            background-color: #f8fafc;
            border: 1px solid #cbd5e1;
            border-left: 3.5px solid #1e3a8a;
            padding: 7px 10px;
            margin-top: 10px;
            margin-bottom: 14px;
            font-size: 7.8pt;
            color: #334155;
            line-height: 1.4;
        }
        .notice-box strong {
            color: #0f172a;
            display: block;
            margin-bottom: 3px;
        }
        .notice-box ol {
            margin: 0;
            padding-left: 14px;
        }
        .signature-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 14px;
        }
        .signature-table td {
            width: 50%;
            vertical-align: top;
            text-align: center;
            font-size: 8.5pt;
        }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
    </style>
</head>
<body>

    <!-- KOP SURAT RESMI -->
    <table class="header-table">
        <tr>
            <td style="width: 75px; text-align: left;">
                @if(!empty($logoBase64))
                    <img src="{{ $logoBase64 }}" style="width: 65px; height: auto;" alt="Logo Sekolah">
                @endif
            </td>
            <td class="kop-text">
                <div class="instansi">PEMERINTAH KOTA AMBON</div>
                <div class="dinas">DINAS PENDIDIKAN</div>
                <div class="school-name">{{ strtoupper($settings['school_name'] ?? 'SD NEGERI LAMA') }}</div>
                <div class="address">
                    {{ $settings['school_address'] ?? $settings['address'] ?? 'Jl. Guru L. Nanlohy, Desa Negeri Lama, Kec. Baguala, Kota Ambon, Maluku' }}<br>
                    Telepon: {{ $settings['phone'] ?? '(0911) 361234' }} &bull; Pos-el: {{ $settings['email'] ?? 'sdnegerilama@ambonkota.sch.id' }} &bull; NPSN: {{ $settings['npsn'] ?? '60101992' }}
                </div>
            </td>
            <td style="width: 75px;"></td>
        </tr>
    </table>

    <div class="kop-divider"></div>

    <!-- JUDUL DOKUMEN -->
    <div class="doc-title">
        <h2>Tanda Bukti Pendaftaran Peserta Didik Baru</h2>
        <p>Penerimaan Peserta Didik Baru (PPDB Online) &bull; Tahun Ajaran {{ date('Y') }}/{{ date('Y') + 1 }}</p>
    </div>

    <!-- BOX NOMOR PENDAFTARAN -->
    <table class="reg-badge-box">
        <tr>
            <td style="width: 65%;">
                <span style="font-size: 7.5pt; color: #64748b; text-transform: uppercase; font-weight: bold; display: block;">Nomor Registrasi PPDB:</span>
                <span class="reg-number">{{ $registration->registration_number }}</span>
                <span style="display: block; font-size: 7.5pt; color: #475569; margin-top: 2px;">
                    Tanggal Daftar: {{ $registration->created_at ? $registration->created_at->format('d F Y, H:i') : date('d F Y, H:i') }} WIT
                </span>
            </td>
            <td style="width: 35%; text-align: right;">
                <span style="font-size: 7.5pt; color: #64748b; display: block; margin-bottom: 3px;">Status Pendaftaran:</span>
                @php
                    $st = strtolower($registration->status ?? 'pending');
                @endphp
                @if($st === 'diterima' || $st === 'accepted')
                    <span class="status-badge badge-verified" style="font-size: 8.5pt; padding: 4px 8px;">DITERIMA</span>
                @elseif($st === 'ditolak' || $st === 'rejected')
                    <span class="status-badge" style="background-color: #fee2e2; color: #991b1b; font-size: 8.5pt; padding: 4px 8px;">DITOLAK</span>
                @else
                    <span class="status-badge badge-pending" style="font-size: 8.5pt; padding: 4px 8px;">MENUNGGU VERIFIKASI</span>
                @endif
            </td>
        </tr>
    </table>

    <!-- I. DATA CALON SISWA -->
    <div class="section-header">I. Data Calon Peserta Didik</div>
    <table class="data-table">
        <tr>
            <td class="field-label">Nama Lengkap</td>
            <td class="field-separator">:</td>
            <td class="field-val"><strong>{{ strtoupper($registration->student_name) }}</strong></td>
        </tr>
        <tr>
            <td class="field-label">Nomor Induk Kependudukan (NIK)</td>
            <td class="field-separator">:</td>
            <td class="field-val">{{ $registration->nik ?: '-' }}</td>
        </tr>
        <tr>
            <td class="field-label">Nomor Kartu Keluarga (KK)</td>
            <td class="field-separator">:</td>
            <td class="field-val">{{ $registration->kk_number ?: '-' }}</td>
        </tr>
        <tr>
            <td class="field-label">Tempat, Tanggal Lahir</td>
            <td class="field-separator">:</td>
            <td class="field-val">
                {{ $registration->birth_place ?: 'Ambon' }}, 
                {{ $registration->birth_date ? $registration->birth_date->format('d F Y') : '-' }}
                @if($registration->birth_date)
                    <span style="color: #64748b; font-size: 8pt;"> (Usia: {{ $registration->age }})</span>
                @endif
            </td>
        </tr>
        <tr>
            <td class="field-label">Jenis Kelamin</td>
            <td class="field-separator">:</td>
            <td class="field-val">
                {{ $registration->gender === 'L' ? 'Laki-laki (L)' : 'Perempuan (P)' }}
            </td>
        </tr>
        <tr>
            <td class="field-label">Asal Sekolah (TK / PAUD)</td>
            <td class="field-separator">:</td>
            <td class="field-val">{{ $registration->previous_school ?: 'Belum pernah TK / PAUD' }}</td>
        </tr>
        <tr>
            <td class="field-label">Alamat Lengkap</td>
            <td class="field-separator">:</td>
            <td class="field-val">{{ $registration->address ?: '-' }}</td>
        </tr>
    </table>

    <!-- II. DATA ORANG TUA / WALI -->
    <div class="section-header">II. Data Orang Tua / Wali</div>
    <table class="data-table">
        <tr>
            <td class="field-label">Nama Orang Tua / Wali</td>
            <td class="field-separator">:</td>
            <td class="field-val"><strong>{{ $registration->parent_name }}</strong></td>
        </tr>
        <tr>
            <td class="field-label">Nomor Telepon / WhatsApp</td>
            <td class="field-separator">:</td>
            <td class="field-val">{{ $registration->phone }}</td>
        </tr>
        <tr>
            <td class="field-label">Alamat Email</td>
            <td class="field-separator">:</td>
            <td class="field-val">{{ $registration->email ?: '-' }}</td>
        </tr>
    </table>

    <!-- III. KELENGKAPAN BERKAS -->
    <div class="section-header">III. Status Kelengkapan Berkas Persyaratan</div>
    <table class="checklist-table">
        <thead>
            <tr>
                <th style="width: 25px;" class="text-center">No</th>
                <th>Nama Dokumen Persyaratan</th>
                <th style="width: 140px;" class="text-center">Status Unggah</th>
                <th style="width: 140px;" class="text-center">Verifikasi Fisik</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="text-center">1</td>
                <td>Scan / Foto Kartu Keluarga (KK)</td>
                <td class="text-center">
                    <span class="status-badge badge-verified">Sudah Diunggah</span>
                </td>
                <td class="text-center" style="color: #64748b;">[ &nbsp; ] Sesuai &nbsp; [ &nbsp; ] Tidak</td>
            </tr>
            <tr>
                <td class="text-center">2</td>
                <td>Scan / Foto Akta Kelahiran</td>
                <td class="text-center">
                    @if($registration->supporting_file_akte)
                        <span class="status-badge badge-verified">Sudah Diunggah</span>
                    @else
                        <span class="status-badge badge-pending">Belum Diunggah</span>
                    @endif
                </td>
                <td class="text-center" style="color: #64748b;">[ &nbsp; ] Sesuai &nbsp; [ &nbsp; ] Tidak</td>
            </tr>
            <tr>
                <td class="text-center">3</td>
                <td>Scan / Foto Rapor / Surat Keterangan TK</td>
                <td class="text-center">
                    @if($registration->supporting_file_rapor)
                        <span class="status-badge badge-verified">Sudah Diunggah</span>
                    @else
                        <span class="status-badge badge-pending">Opsional / Belum</span>
                    @endif
                </td>
                <td class="text-center" style="color: #64748b;">[ &nbsp; ] Sesuai &nbsp; [ &nbsp; ] Tidak</td>
            </tr>
        </tbody>
    </table>

    <!-- PETUNJUK VERIFIKASI -->
    <div class="notice-box">
        <strong>PENTING &bull; PETUNJUK VERIFIKASI BERKAS FISIK DI SEKOLAH:</strong>
        <ol>
            <li>Lembar Tanda Bukti Pendaftaran ini <strong>wajib dicetak dan dibawa</strong> pada saat verifikasi berkas langsung ke sekolah.</li>
            <li>Membawa dokumen asli beserta 1 rangkap fotokopi: <strong>Kartu Keluarga (KK), Akta Kelahiran, dan KTP Orang Tua/Wali</strong>.</li>
            <li>Waktu verifikasi berkas: <strong>Senin s.d. Jumat, pukul 08.00 - 13.00 WIT</strong> di Ruang Panitia PPDB {{ $settings['school_name'] ?? 'SD Negeri Lama' }}.</li>
            <li>Informasi kelulusan & seleksi dapat dipantau melalui portal resmi website sekolah: <strong>{{ url('/') }}</strong>.</li>
        </ol>
    </div>

    <!-- TANDA TANGAN -->
    <table class="signature-table">
        <tr>
            <td>
                Orang Tua / Wali Calon Siswa,<br><br><br><br><br>
                <strong><u>( {{ $registration->parent_name }} )</u></strong><br>
                <span>Tanda Tangan & Nama Terang</span>
            </td>
            <td>
                Ambon, {{ date('d F Y') }}<br>
                Panitia Verifikasi PPDB,<br><br><br><br><br>
                <strong><u>( &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; )</u></strong><br>
                <span>NIP. ....................................................</span>
            </td>
        </tr>
    </table>

</body>
</html>
