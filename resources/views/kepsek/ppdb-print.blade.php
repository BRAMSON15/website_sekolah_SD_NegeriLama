<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Rekap PPDB Online - SD Negeri Lama Ambon</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Plus Jakarta Sans', Arial, sans-serif;
        }
        body {
            background-color: #f8fafc;
            color: #1e293b;
            padding: 24px;
        }
        .print-container {
            max-width: 900px;
            margin: 0 auto;
            background: #fff;
            padding: 36px 48px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.06);
            border-radius: 8px;
        }
        .no-print-bar {
            max-width: 900px;
            margin: 0 auto 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 20px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 14px;
            cursor: pointer;
            text-decoration: none;
            border: none;
            transition: all 0.2s;
        }
        .btn-primary { background: #0f172a; color: #fff; }
        .btn-primary:hover { background: #1e293b; }
        .btn-secondary { background: #e2e8f0; color: #334155; }
        .btn-secondary:hover { background: #cbd5e1; }

        .kop-surat {
            display: flex;
            align-items: center;
            gap: 20px;
            border-bottom: 3px double #0f172a;
            padding-bottom: 16px;
            margin-bottom: 24px;
        }
        .kop-logo {
            width: 80px;
            height: 80px;
            object-fit: contain;
        }
        .kop-text {
            flex: 1;
            text-align: center;
        }
        .kop-text h4 {
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-weight: 600;
            color: #475569;
        }
        .kop-text h2 {
            font-size: 20px;
            font-weight: 800;
            color: #0f172a;
            letter-spacing: 0.5px;
            margin: 2px 0;
        }
        .kop-text p {
            font-size: 12px;
            color: #64748b;
            line-height: 1.4;
        }
        .report-title {
            text-align: center;
            margin-bottom: 20px;
        }
        .report-title h3 {
            font-size: 16px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            text-decoration: underline;
        }
        .report-title span {
            font-size: 13px;
            color: #64748b;
            display: block;
            margin-top: 4px;
        }
        .meta-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 10px 24px;
            margin-bottom: 20px;
            font-size: 13px;
            background: #f8fafc;
            padding: 12px 18px;
            border-radius: 6px;
            border: 1px solid #e2e8f0;
        }
        .meta-item { display: flex; }
        .meta-item .label { width: 140px; font-weight: 600; color: #64748b; }
        .meta-item .val { font-weight: 700; color: #0f172a; }

        .stat-summary {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 10px;
            margin-bottom: 20px;
        }
        .stat-box {
            text-align: center;
            padding: 8px 10px;
            border-radius: 6px;
            border: 1px solid #e2e8f0;
            font-size: 12px;
        }
        .stat-box .count {
            font-size: 18px;
            font-weight: 800;
            margin-bottom: 2px;
        }
        .stat-all { background: #f0fdfa; border-color: #99f6e4; color: #0f766e; }
        .stat-approved { background: #f0fdf4; border-color: #bbf7d0; color: #166534; }
        .stat-pending { background: #fefce8; border-color: #fef08a; color: #854d0e; }
        .stat-rejected { background: #fef2f2; border-color: #fecaca; color: #991b1b; }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 11.5px;
            margin-bottom: 24px;
        }
        table th, table td {
            border: 1px solid #cbd5e1;
            padding: 7px 9px;
            text-align: left;
        }
        table th {
            background-color: #f1f5f9;
            font-weight: 700;
            text-transform: uppercase;
            font-size: 11px;
            color: #334155;
        }
        .text-center { text-align: center; }
        .badge-status {
            display: inline-block;
            padding: 2px 6px;
            border-radius: 4px;
            font-weight: 700;
            font-size: 10px;
            text-transform: uppercase;
        }
        .badge-diterima { background: #dcfce7; color: #15803d; }
        .badge-menunggu { background: #fef9c3; color: #a16207; }
        .badge-ditolak { background: #fee2e2; color: #b91c1c; }

        .signature-section {
            margin-top: 40px;
            display: flex;
            justify-content: flex-end;
            page-break-inside: avoid;
        }
        .sig-box {
            width: 250px;
            text-align: center;
            font-size: 13px;
        }
        .sig-box .date { margin-bottom: 8px; }
        .sig-box .role-title { font-weight: 600; margin-bottom: 75px; }
        .sig-box .principal-name { font-weight: 800; text-decoration: underline; color: #0f172a; }
        .sig-box .nip { font-size: 12px; color: #475569; margin-top: 2px; }

        @media print {
            body { background: #fff; padding: 0; }
            .no-print-bar { display: none !important; }
            .print-container { box-shadow: none; padding: 0; max-width: 100%; }
            table th { -webkit-print-color-adjust: exact; print-color-adjust: exact; }
        }
    </style>
</head>
<body>

    <div class="no-print-bar">
        <a href="{{ route('kepsek.monitoring.ppdb', ['status' => $status, 'track' => $track]) }}" class="btn btn-secondary">
            <i class="fa-solid fa-arrow-left"></i> Kembali ke Monitoring
        </a>
        <button onclick="window.print()" class="btn btn-primary">
            <i class="fa-solid fa-print"></i> Cetak / Simpan PDF
        </button>
    </div>

    <div class="print-container">
        <!-- Kop Surat Resmi -->
        <div class="kop-surat">
            <img src="{{ asset('mentahan2/logo_sekolah.png') }}" alt="Logo" class="kop-logo" onerror="this.src='{{ asset('mentahan2/logo_header.png') }}'">
            <div class="kop-text">
                <h4>Pemerintah Kota Ambon &bull; Dinas Pendidikan</h4>
                <h2>{{ $settings['school_name'] ?? 'SD NEGERI LAMA AMBON' }}</h2>
                <p>{{ $settings['address'] ?? 'Jl. Laksdya Leo Wattimena, Negeri Lama, Kec. Baguala, Kota Ambon, Maluku' }}</p>
                <p>Telp: {{ $settings['phone'] ?? '082328631457' }} | Pos-el: {{ $settings['email'] ?? 'sdnegerilama@ambon.com' }}</p>
            </div>
        </div>

        <!-- Judul Laporan -->
        <div class="report-title">
            <h3>Laporan Rekapitulasi Calon Peserta Didik Baru (PPDB)</h3>
            <span>Tahun Ajaran {{ date('Y') }}/{{ date('Y') + 1 }}</span>
        </div>

        <!-- Metadata -->
        <div class="meta-grid">
            <div class="meta-item">
                <span class="label">Jalur Pendaftaran:</span>
                <span class="val">{{ $track === 'all' ? 'Semua Jalur Seleksi' : $track }}</span>
            </div>
            <div class="meta-item">
                <span class="label">Status Berkas:</span>
                <span class="val">{{ ucfirst($status === 'all' ? 'Semua Status' : $status) }}</span>
            </div>
            <div class="meta-item">
                <span class="label">Total Terdaftar:</span>
                <span class="val">{{ $registrations->count() }} Pendaftar</span>
            </div>
            <div class="meta-item">
                <span class="label">Waktu Cetak:</span>
                <span class="val">{{ \Carbon\Carbon::now()->translatedFormat('d F Y, H:i') }} WIT</span>
            </div>
        </div>

        <!-- Rekap Ringkas -->
        <div class="stat-summary">
            <div class="stat-box stat-all">
                <div class="count">{{ $totalAll }}</div>
                <div>Total Pendaftar</div>
            </div>
            <div class="stat-box stat-approved">
                <div class="count">{{ $totalApproved }}</div>
                <div>Diterima / Lolos</div>
            </div>
            <div class="stat-box stat-pending">
                <div class="count">{{ $totalPending }}</div>
                <div>Menunggu Verifikasi</div>
            </div>
            <div class="stat-box stat-rejected">
                <div class="count">{{ $totalRejected }}</div>
                <div>Tidak Lolos</div>
            </div>
        </div>

        <!-- Tabel Data Siswa PPDB -->
        <table>
            <thead>
                <tr>
                    <th style="width: 35px;" class="text-center">No</th>
                    <th style="width: 100px;">No. Registrasi</th>
                    <th>Nama Calon Siswa</th>
                    <th style="width: 90px;">NISN</th>
                    <th style="width: 45px;" class="text-center">L/P</th>
                    <th style="width: 110px;">Jalur Seleksi</th>
                    <th>Asal Sekolah / TK</th>
                    <th style="width: 80px;" class="text-center">Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($registrations as $index => $reg)
                    <tr>
                        <td class="text-center">{{ $index + 1 }}</td>
                        <td><strong>{{ $reg->registration_number }}</strong></td>
                        <td>{{ $reg->full_name }}</td>
                        <td>{{ $reg->nisn ?: '-' }}</td>
                        <td class="text-center">{{ $reg->gender ?? '-' }}</td>
                        <td>{{ $reg->registration_track ?? 'Zonasi' }}</td>
                        <td>{{ $reg->previous_school ?: '-' }}</td>
                        <td class="text-center">
                            @if($reg->status === 'diterima')
                                <span class="badge-status badge-diterima">DITERIMA</span>
                            @elseif($reg->status === 'ditolak')
                                <span class="badge-status badge-ditolak">DITOLAK</span>
                            @else
                                <span class="badge-status badge-menunggu">MENUNGGU</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center" style="padding: 24px; color: #64748b;">
                            Tidak ada data pendaftaran untuk filter yang dipilih.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <!-- Tanda Tangan Kepala Sekolah -->
        <div class="signature-section">
            <div class="sig-box">
                <div class="date">Kota Ambon, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</div>
                <div class="role-title">Kepala SD Negeri Lama</div>
                <div class="principal-name">{{ $settings['principal_name'] ?? 'Drs. H. Ahmad Dahlan, M.Pd.' }}</div>
                <div class="nip">NIP. {{ Auth::user()->nip ?? '197505081999031001' }}</div>
            </div>
        </div>
    </div>

</body>
</html>
