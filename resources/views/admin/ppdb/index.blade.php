@extends('layouts.app')

@section('title', 'Data Pendaftar PPDB - ' . ($settings['school_name'] ?? 'SD Negeri Lama'))

@section('content')
<div class="page-header">
  <h1>Data Pendaftar PPDB</h1>
  <p>Kelola data pendaftar peserta didik baru</p>
</div>

<div class="page-content">
  <div class="card-box" style="overflow-x: auto;">
    <table style="width: 100%; border-collapse: collapse; min-width: 760px;">
      <thead>
        <tr style="border-bottom: 2px solid var(--border); text-align: left;">
          <th style="padding: 12px 10px;">Nomor Pendaftaran</th>
          <th style="padding: 12px 10px;">Nama Siswa</th>
          <th style="padding: 12px 10px;">Orang Tua/Wali</th>
          <th style="padding: 12px 10px;">Kontak</th>
          <th style="padding: 12px 10px;">Tanggal</th>
          <th style="padding: 12px 10px;">Status</th>
        </tr>
      </thead>
      <tbody>
        @forelse($registrations as $registration)
          <tr style="border-bottom: 1px solid var(--border);">
            <td style="padding: 14px 10px; color: var(--primary); font-weight: 700;">{{ $registration->registration_number }}</td>
            <td style="padding: 14px 10px;">{{ $registration->student_name }}</td>
            <td style="padding: 14px 10px;">{{ $registration->parent_name }}</td>
            <td style="padding: 14px 10px;">{{ $registration->phone }}</td>
            <td style="padding: 14px 10px;">{{ $registration->created_at->format('d/m/Y') }}</td>
            <td style="padding: 14px 10px;"><span style="background: #fef3c7; color: #92400e; padding: 5px 9px; border-radius: 20px; font-size: .78rem; font-weight: 700;">{{ ucfirst($registration->status) }}</span></td>
          </tr>
        @empty
          <tr><td colspan="6" style="padding: 24px; text-align: center; color: var(--muted);">Belum ada pendaftar.</td></tr>
        @endforelse
      </tbody>
    </table>
    <div style="margin-top: 20px;">{{ $registrations->links() }}</div>
  </div>
</div>
@endsection
