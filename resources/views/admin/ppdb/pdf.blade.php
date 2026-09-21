<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Rekapitulasi Data Pendaftar PPDB - {{ $settings['school_name'] ?? 'SD NEGERI LAMA' }}</title>
    <style>
        @page {
            margin: 1.2cm 1.5cm;
        }
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            color: #1e293b;
            font-size: 9pt;
            line-height: 1.3;
            margin: 0;
            padding: 0;
        }
        .header-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 8px;
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
            color: #1e293b;
            letter-spacing: 0.5px;
            margin: 0;
        }
        .kop-text .dinas {
            font-size: 10pt;
            font-weight: bold;
            color: #1e293b;
            margin: 2px 0;
        }
        .kop-text .school-name {
            font-size: 15pt;
            font-weight: 800;
            color: #1e3a8a;
            margin: 2px 0 4px 0;
            letter-spacing: 1px;
        }
        .kop-text .address {
            font-size: 8pt;
            color: #475569;
            margin: 0;
            line-height: 1.3;
        }
        .kop-divider {
            border-top: 2.5px solid #1e293b;
            border-bottom: 1px solid #1e293b;
            height: 2px;
            margin: 6px 0 16px 0;
        }
        .doc-title {
            text-align: center;
            margin-bottom: 16px;
        }
        .doc-title h2 {
            font-size: 12pt;
            font-weight: bold;
            color: #0f172a;
            margin: 0 0 3px 0;
            text-transform: uppercase;
        }
        .doc-title p {
            font-size: 8.5pt;
            color: #64748b;
            margin: 0;
        }
        .data-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 8pt;
            margin-bottom: 16px;
        }
        .data-table th {
            background-color: #1e3a8a;
            color: #ffffff;
            font-weight: bold;
            text-align: left;
            padding: 6px 7px;
            border: 1px solid #1e3a8a;
        }
        .data-table td {
            padding: 5px 7px;
            border: 1px solid #cbd5e1;
            vertical-align: middle;
        }
        .data-table tr.even {
            background-color: #f8fafc;
        }
        .text-center {
            text-align: center;
        }
        .text-right {
            text-align: right;
        }
        .badge-status {
            padding: 2px 6px;
            border-radius: 4px;
            font-size: 7pt;
            font-weight: bold;
            display: inline-block;
            text-transform: uppercase;
        }
        .status-pending {
            background-color: #fef3c7;
            color: #92400e;
        }
        .status-accepted {
            background-color: #dcfce7;
            color: #166534;
        }
        .status-rejected {
            background-color: #fee2e2;
            color: #991b1b;
        }
        .summary-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            margin-bottom: 20px;
        }
        .summary-table td {
            vertical-align: top;
        }
        .signature-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        .signature-table td {
            vertical-align: top;
            text-align: center;
        }
    </style>
</head>
<body>

    <!-- KOP SURAT RESMI -->
    <table class="header-table">
        <tr>
            <td style="width: 75px; text-align: left;">
                @if($logoBase64)
                    <img src="{{ $logoBase64 }}" style="width: 65px; height: auto;" alt="Logo Tut Wuri">
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
        <h2>Laporan Data Calon Peserta Didik Baru (PPDB Online)</h2>
        <p>Tahun Ajaran {{ date('Y') }}/{{ date('Y') + 1 }} &bull; Tanggal Cetak: {{ date('d F Y, H:i') }} WIT</p>
    </div>

    <!-- TABEL DATA PENDAFTAR -->
    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 25px;" class="text-center">No</th>
                <th style="width: 110px;">No. Pendaftaran</th>
                <th>Nama Lengkap Calon Siswa</th>
                <th style="width: 30px;" class="text-center">L/P</th>
                <th style="width: 115px;">Tempat, Tgl Lahir</th>
                <th style="width: 100px;">Nama Orang Tua / Wali</th>
                <th style="width: 85px;">Kontak / HP</th>
                <th style="width: 90px;">Asal Sekolah</th>
                <th style="width: 75px;" class="text-center">Tgl Daftar</th>
                <th style="width: 60px;" class="text-center">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($registrations as $index => $reg)
            <tr class="{{ $index % 2 === 1 ? 'even' : '' }}">
                <td class="text-center">{{ $index + 1 }}</td>
                <td style="font-family: monospace; font-weight: bold; color: #1e40af;">{{ $reg->registration_number }}</td>
                <td>
                    <strong>{{ $reg->student_name }}</strong>
                    @if($reg->nik)
                        <br><span style="color: #64748b; font-size: 7pt;">NIK: {{ $reg->nik }}</span>
                    @endif
                </td>
                <td class="text-center" style="font-weight: bold; color: {{ $reg->gender == 'L' ? '#1d4ed8' : '#db2777' }};">
                    {{ $reg->gender }}
                </td>
                <td>
                    {{ $reg->birth_place ?: '-' }}, 
                    {{ $reg->birth_date ? $reg->birth_date->format('d/m/Y') : '-' }}
                </td>
                <td>{{ $reg->parent_name ?: '-' }}</td>
                <td>{{ $reg->phone ?: '-' }}</td>
                <td>{{ $reg->previous_school ?: 'TK/PAUD' }}</td>
                <td class="text-center">{{ $reg->created_at ? $reg->created_at->format('d/m/Y') : '-' }}</td>
                <td class="text-center">
                    @php
                        $st = strtolower($reg->status);
                    @endphp
                    @if($st === 'accepted' || $st === 'diterima')
                        <span class="badge-status status-accepted">Diterima</span>
                    @elseif($st === 'rejected' || $st === 'ditolak')
                        <span class="badge-status status-rejected">Ditolak</span>
                    @else
                        <span class="badge-status status-pending">Pending</span>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="10" class="text-center" style="padding: 20px; color: #94a3b8;">
                    Tidak ada data pendaftaran calon siswa terdaftar.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <!-- REKAPITULASI & TANDA TANGAN -->
    <table class="summary-table">
        <tr>
            <td style="width: 55%; font-size: 8pt;">
                <div style="background: #f1f5f9; border: 1px solid #cbd5e1; border-radius: 6px; padding: 10px 14px;">
                    <strong style="color: #1e3a8a; display: block; margin-bottom: 4px;">REKAPITULASI JUMLAH PENDAFTAR:</strong>
                    <table style="width: 100%; font-size: 8pt; border-collapse: collapse;">
                        <tr>
                            <td style="width: 45%;">Total Calon Pendaftar</td>
                            <td>: <strong>{{ $totalRegistrations }} Siswa</strong></td>
                        </tr>
                        <tr>
                            <td>Laki-laki (L)</td>
                            <td>: <strong>{{ $totalL }} Siswa</strong></td>
                        </tr>
                        <tr>
                            <td>Perempuan (P)</td>
                            <td>: <strong>{{ $totalP }} Siswa</strong></td>
                        </tr>
                    </table>
                </div>
            </td>
            <td style="width: 45%;">
                <table class="signature-table">
                    <tr>
                        <td>
                            Ambon, {{ date('d F Y') }}<br>
                            <strong>Kepala Sekolah / Panitia PPDB</strong>
                            <br><br><br><br>
                            <strong><u>{{ $settings['headmaster_name'] ?? 'Kepala SD Negeri Lama' }}</u></strong><br>
                            <span>NIP. {{ $settings['headmaster_nip'] ?? '19780512 200501 1 008' }}</span>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

</body>
</html>
