@extends('layouts.admin')

@section('title', 'Kelola Data Pendaftar PPDB - ' . ($settings['school_name'] ?? 'SD Negeri Lama'))

@section('content')
<div class="information-home">
    <div class="information-hero">
        <div>
            <span class="panel-eyebrow">PENERIMAAN PESERTA DIDIK BARU</span>
            <h2>Kelola Data PPDB</h2>
            <p>Data calon peserta didik baru yang mendaftar melalui sistem PPDB online {{ $settings['school_name'] ?? 'SD Negeri Lama' }}.</p>
        </div>
        <div style="display: flex; gap: 10px; align-items: center; flex-wrap: wrap;">
            <a href="{{ route('admin.ppdb.export.pdf') }}" class="btn btn-danger" style="background: #ef4444; border-color: #ef4444; color: #fff; display: inline-flex; align-items: center; gap: 8px; text-decoration: none;">
                <i class="fa fa-file-pdf"></i> Unduh PDF
            </a>
            <a href="{{ route('admin.ppdb.export.excel') }}" class="btn btn-success" style="background: #10b981; border-color: #10b981; color: #fff; display: inline-flex; align-items: center; gap: 8px; text-decoration: none;">
                <i class="fa fa-file-excel"></i> Unduh Excel
            </a>
            <a href="{{ route('ppdb') }}" target="_blank" class="btn btn-primary" style="display: inline-flex; align-items: center; gap: 8px; text-decoration: none;">
                <i class="fa fa-external-link-alt"></i> Halaman PPDB Publik
            </a>
        </div>
    </div>

    <div class="information-panel admin-table-panel">
        <div class="information-panel-heading">
            <div>
                <span class="panel-eyebrow">DATA PENDAFTAR</span>
                <h4>Daftar Calon Siswa Terdaftar</h4>
            </div>
            <div style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap;">
                <a href="{{ route('admin.ppdb.export.pdf') }}" style="background: #fee2e2; color: #dc2626; border: 1px solid #fca5a5; padding: 6px 14px; border-radius: 8px; font-weight: 700; font-size: 0.82rem; text-decoration: none; display: inline-flex; align-items: center; gap: 6px; box-shadow: 0 2px 4px rgba(220, 38, 38, 0.08);">
                    <i class="fa-solid fa-file-pdf"></i> PDF
                </a>
                <a href="{{ route('admin.ppdb.export.excel') }}" style="background: #dcfce7; color: #166534; border: 1px solid #86efac; padding: 6px 14px; border-radius: 8px; font-weight: 700; font-size: 0.82rem; text-decoration: none; display: inline-flex; align-items: center; gap: 6px; box-shadow: 0 2px 4px rgba(22, 101, 52, 0.08);">
                    <i class="fa-solid fa-file-excel"></i> Excel
                </a>
                <span class="information-count">{{ $registrations->total() }} Pendaftar</span>
            </div>
        </div>

        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>Nomor Pendaftaran</th>
                        <th>Nama Siswa</th>
                        <th>Orang Tua/Wali</th>
                        <th>Kontak</th>
                        <th>Tanggal</th>
                        <th class="text-right">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($registrations as $registration)
                    <tr>
                        <td>
                            <code style="background: #eef4ff; color: #1769d9; padding: 4px 8px; border-radius: 6px; font-weight: 700;">{{ $registration->registration_number }}</code>
                        </td>
                        <td>
                            <strong>{{ $registration->student_name }}</strong>
                            <small class="table-subtext">{{ $registration->gender === 'L' ? 'Laki-laki' : 'Perempuan' }} &bull; Asal: {{ $registration->previous_school ?? 'TK/PAUD' }}</small>
                        </td>
                        <td>{{ $registration->parent_name }}</td>
                        <td>{{ $registration->phone }}</td>
                        <td>{{ $registration->created_at ? $registration->created_at->format('d M Y') : '-' }}</td>
                        <td class="text-right">
                            <span class="information-status information-status-active">{{ ucfirst($registration->status) }}</span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center" style="padding: 24px; color: #8aa0bc;">Belum ada calon siswa yang mendaftar.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($registrations->hasPages())
        <div style="margin-top: 20px;">
            {{ $registrations->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
