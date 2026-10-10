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
    <link rel="stylesheet" href="{{ asset('mentahan2/css/ppdb-print.css') }}?v={{ filemtime(public_path('mentahan2/css/ppdb-print.css')) }}">
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
