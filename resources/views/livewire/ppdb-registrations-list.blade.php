<div class="ppdb-registrations-container">
    <!-- Filter Bar -->
    <div style="background: #f8fafc; padding: 16px; border-radius: 8px; margin-bottom: 20px; border: 1px solid #e2e8f0;">
        <div style="display: flex; gap: 12px; flex-wrap: wrap; align-items: center;">
            <div style="flex: 1; min-width: 200px;">
                <input 
                    type="text" 
                    wire:model.live="search" 
                    placeholder="Cari nama siswa, orang tua, atau nomor pendaftaran..."
                    style="width: 100%; padding: 8px 12px; border: 1px solid #cbd5e1; border-radius: 6px; font-size: 14px;"
                >
            </div>
            <select 
                wire:model.live="statusFilter" 
                style="padding: 8px 12px; border: 1px solid #cbd5e1; border-radius: 6px; font-size: 14px; background: white; cursor: pointer;"
            >
                <option value="all">Semua Status</option>
                <option value="pending">Pending</option>
                <option value="diterima">Diterima</option>
                <option value="ditolak">Ditolak</option>
            </select>
            <span style="color: #64748b; font-size: 13px;">
                <i class="fas fa-sync-alt" @if (isset($wire->loading)) style="animation: spin 1s linear infinite;" @endif></i>
                Last updated: <span wire:poll-5000="$refresh">{{ now()->format('H:i:s') }}</span>
            </span>
        </div>
    </div>

    <!-- Auto-refresh indicator -->
    <div wire:poll-3000="$refresh" style="display: none;"></div>

    <!-- Table -->
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
                <tr style="animation: fadeIn 0.3s ease-in;">
                    <td>
                        <code style="background: #eef4ff; color: #1769d9; padding: 4px 8px; border-radius: 6px; font-weight: 700;">
                            {{ $registration->registration_number }}
                        </code>
                    </td>
                    <td>
                        <strong>{{ $registration->student_name }}</strong>
                        <small class="table-subtext" style="display: block; color: #8aa0bc; font-size: 12px;">
                            {{ $registration->gender === 'L' ? 'Laki-laki' : 'Perempuan' }} &bull; 
                            Asal: {{ $registration->previous_school ?? 'TK/PAUD' }}
                        </small>
                    </td>
                    <td>{{ $registration->parent_name }}</td>
                    <td>{{ $registration->phone }}</td>
                    <td>
                        <span title="{{ $registration->created_at }}">
                            {{ $registration->created_at ? $registration->created_at->format('d M Y H:i') : '-' }}
                        </span>
                    </td>
                    <td class="text-right">
                        <span class="information-status information-status-active" style="padding: 4px 12px; border-radius: 20px; display: inline-block; font-size: 12px; font-weight: 600;">
                            {{ ucfirst($registration->status) }}
                        </span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center" style="padding: 40px; color: #8aa0bc;">
                        <i class="fas fa-inbox" style="font-size: 32px; opacity: 0.3; margin-bottom: 12px; display: block;"></i>
                        Belum ada calon siswa yang mendaftar.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    @if($registrations->hasPages())
    <div style="margin-top: 20px; display: flex; justify-content: center;">
        {{ $registrations->links() }}
    </div>
    @endif

    <!-- Stats Summary -->
    <div style="margin-top: 24px; display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 12px;">
        <div style="background: #f0f9ff; border: 1px solid #7dd3fc; padding: 12px; border-radius: 8px; text-align: center;">
            <div style="font-size: 24px; font-weight: 700; color: #0284c7;">{{ $registrations->total() }}</div>
            <div style="font-size: 12px; color: #0c4a6e; margin-top: 4px;">Total Pendaftar</div>
        </div>
    </div>
</div>

<style>
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes spin {
        to {
            transform: rotate(360deg);
        }
    }

    .table-responsive {
        overflow-x: auto;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        background: white;
    }

    table thead tr {
        background: #f8fafc;
        border-bottom: 2px solid #e2e8f0;
    }

    table th {
        padding: 12px 16px;
        text-align: left;
        font-weight: 600;
        color: #475569;
        font-size: 13px;
    }

    table td {
        padding: 12px 16px;
        border-bottom: 1px solid #e2e8f0;
        font-size: 14px;
    }

    table tbody tr:hover {
        background: #f8fafc;
    }

    .text-right {
        text-align: right;
    }

    .text-center {
        text-align: center;
    }

    .information-status {
        display: inline-block;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
    }

    .information-status-active {
        background: #dcfce7;
        color: #166534;
    }
</style>
