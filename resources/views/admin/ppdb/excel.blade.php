<!DOCTYPE html>
<html lang="id">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Data Calon Peserta Didik Baru PPDB - {{ $settings['school_name'] ?? 'SD NEGERI LAMA' }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 10pt;
        }
        .kop-instansi {
            font-size: 11pt;
            font-weight: bold;
            text-align: center;
        }
        .kop-school {
            font-size: 14pt;
            font-weight: bold;
            color: #1e3a8a;
            text-align: center;
        }
        .kop-sub {
            font-size: 9.5pt;
            text-align: center;
            color: #475569;
        }
        .table-header {
            background-color: #1e3a8a;
            color: #ffffff;
            font-weight: bold;
            text-align: center;
            border: 1px solid #000000;
            padding: 8px 6px;
        }
        .table-cell {
            border: 1px solid #cbd5e1;
            padding: 6px 8px;
            vertical-align: middle;
        }
        .text-center {
            text-align: center;
        }
        .text-str {
            mso-number-format: "\@";
        }
        .text-date {
            mso-number-format: "dd\/mm\/yyyy";
            text-align: center;
        }
        .row-even {
            background-color: #f8fafc;
        }
    </style>
</head>
<body>
    <table border="1" cellpadding="5" cellspacing="0" style="border-collapse: collapse;">
        <tr>
            <td colspan="15" class="kop-instansi" style="border: none;">PEMERINTAH KOTA AMBON &bull; DINAS PENDIDIKAN</td>
        </tr>
        <tr>
            <td colspan="15" class="kop-school" style="border: none;">{{ strtoupper($settings['school_name'] ?? 'SD NEGERI LAMA') }}</td>
        </tr>
        <tr>
            <td colspan="15" class="kop-instansi" style="border: none;">REKAPITULASI PENDAFTARAN PESERTA DIDIK BARU (PPDB) ONLINE</td>
        </tr>
        <tr>
            <td colspan="15" class="kop-sub" style="border: none;">Tahun Ajaran {{ date('Y') }}/{{ date('Y') + 1 }} &bull; Tanggal Ekspor: {{ date('d F Y, H:i') }} WIT</td>
        </tr>
        <tr>
            <td colspan="15" style="border: none; height: 15px;"></td>
        </tr>
        <thead>
            <tr>
                <th class="table-header" style="width: 40px;">No</th>
                <th class="table-header" style="width: 150px;">Nomor Pendaftaran</th>
                <th class="table-header" style="width: 200px;">Nama Lengkap Siswa</th>
                <th class="table-header" style="width: 50px;">L/P</th>
                <th class="table-header" style="width: 140px;">Tempat Lahir</th>
                <th class="table-header" style="width: 110px;">Tanggal Lahir</th>
                <th class="table-header" style="width: 150px;">NIK Siswa</th>
                <th class="table-header" style="width: 150px;">No. Kartu Keluarga</th>
                <th class="table-header" style="width: 170px;">Nama Orang Tua/Wali</th>
                <th class="table-header" style="width: 140px;">Nomor HP/WA</th>
                <th class="table-header" style="width: 160px;">Email</th>
                <th class="table-header" style="width: 220px;">Alamat Rumah</th>
                <th class="table-header" style="width: 150px;">Asal Sekolah</th>
                <th class="table-header" style="width: 120px;">Tanggal Daftar</th>
                <th class="table-header" style="width: 100px;">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($registrations as $index => $reg)
            <tr class="{{ $index % 2 === 1 ? 'row-even' : '' }}">
                <td class="table-cell text-center">{{ $index + 1 }}</td>
                <td class="table-cell text-str text-center" style="font-weight: bold; color: #1e40af;">{{ $reg->registration_number }}</td>
                <td class="table-cell" style="font-weight: bold;">{{ $reg->student_name }}</td>
                <td class="table-cell text-center" style="font-weight: bold; color: {{ $reg->gender == 'L' ? '#1d4ed8' : '#db2777' }};">{{ $reg->gender }}</td>
                <td class="table-cell">{{ $reg->birth_place ?: '-' }}</td>
                <td class="table-cell text-date">{{ $reg->birth_date ? $reg->birth_date->format('d/m/Y') : '-' }}</td>
                <td class="table-cell text-str text-center">{{ $reg->nik ?: '-' }}</td>
                <td class="table-cell text-str text-center">{{ $reg->kk_number ?: '-' }}</td>
                <td class="table-cell">{{ $reg->parent_name ?: '-' }}</td>
                <td class="table-cell text-str">{{ $reg->phone ?: '-' }}</td>
                <td class="table-cell">{{ $reg->email ?: '-' }}</td>
                <td class="table-cell">{{ $reg->address ?: '-' }}</td>
                <td class="table-cell">{{ $reg->previous_school ?: 'TK/PAUD' }}</td>
                <td class="table-cell text-date">{{ $reg->created_at ? $reg->created_at->format('d/m/Y') : '-' }}</td>
                <td class="table-cell text-center" style="font-weight: bold;">{{ ucfirst($reg->status) }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="15" class="table-cell text-center" style="padding: 20px; color: #94a3b8;">
                    Belum ada data calon siswa yang mendaftar.
                </td>
            </tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr>
                <td colspan="15" style="border: none; height: 10px;"></td>
            </tr>
            <tr>
                <td colspan="3" class="table-cell" style="background-color: #f1f5f9; font-weight: bold;">Total Pendaftar:</td>
                <td colspan="12" class="table-cell" style="background-color: #f1f5f9; font-weight: bold;">{{ $registrations->count() }} Calon Siswa (Laki-laki: {{ $registrations->where('gender', 'L')->count() }}, Perempuan: {{ $registrations->where('gender', 'P')->count() }})</td>
            </tr>
        </tfoot>
    </table>
</body>
</html>
