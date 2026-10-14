<div>
  <!-- Search Input -->
  <div class="form-field" style="margin-bottom: 16px;">
    <label>Cari Registrasi</label>
    <input type="text" wire:model.debounce-500ms="search" placeholder="Nama calon, orang tua, atau nomor reg..." 
           style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 6px; font-size: 0.9rem;">
    <small style="display: block; color: #7f8c8d; margin-top: 4px;">Cari by nama calon, nama orang tua, atau nomor pendaftaran</small>
  </div>

  <!-- Status Filter -->
  <div class="form-field" style="margin-bottom: 16px;">
    <label>Status</label>
    <select wire:model="status" style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 6px; font-size: 0.9rem;">
      <option value="all">Semua Status</option>
      <option value="pending">Menunggu Review</option>
      <option value="diterima">Diterima</option>
      <option value="ditolak">Ditolak</option>
    </select>
  </div>

  <!-- Date Range Filter -->
  <div style="margin-bottom: 16px;">
    <label style="display: block; font-weight: 600; margin-bottom: 8px; font-size: 0.9rem;">Rentang Tanggal</label>
    <div style="display: flex; gap: 8px;">
      <div style="flex: 1;">
        <input type="date" wire:model="dateFrom" placeholder="Dari..." 
               style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 6px; font-size: 0.9rem;">
      </div>
      <div style="flex: 1;">
        <input type="date" wire:model="dateTo" placeholder="Sampai..." 
               style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 6px; font-size: 0.9rem;">
      </div>
    </div>
  </div>

  <!-- Clear Button -->
  <button wire:click="clearFilters" style="width: 100%; padding: 10px; background: #ecf0f1; border: 1px solid #bdc3c7; border-radius: 6px; cursor: pointer; font-weight: 600; color: #2c3e50;">
    <i class="fa-solid fa-times"></i> Bersihkan Filter
  </button>

  <!-- Results Count -->
  @if($this->results->count() > 0)
    <div style="margin-top: 16px; padding: 12px; background: #ecf9ff; border: 1px solid #bfdbfe; border-radius: 6px; color: #1e40af; font-size: 0.9rem;">
      <strong>{{ $this->results->count() }}</strong> registrasi ditemukan
    </div>

    <!-- Results Table -->
    <div style="margin-top: 16px; overflow-x: auto;">
      <table style="width: 100%; font-size: 0.85rem; border-collapse: collapse;">
        <thead>
          <tr style="background: #f0f4f8; border-bottom: 2px solid #cbd5e1;">
            <th style="padding: 10px; text-align: left; font-weight: 600;">Nama Calon</th>
            <th style="padding: 10px; text-align: left; font-weight: 600;">Status</th>
            <th style="padding: 10px; text-align: left; font-weight: 600;">Tgl Daftar</th>
          </tr>
        </thead>
        <tbody>
          @foreach($this->results->take(5) as $reg)
            <tr style="border-bottom: 1px solid #ecf0f1;">
              <td style="padding: 10px;"><strong>{{ $reg->student_name }}</strong></td>
              <td style="padding: 10px;">
                <span style="padding: 4px 8px; border-radius: 4px; font-size: 0.75rem; font-weight: 600;
                  background: {{ $reg->status === 'pending' ? '#fef2f2' : ($reg->status === 'diterima' ? '#ecf9ff' : '#fef2f2') }};
                  color: {{ $reg->status === 'pending' ? '#991b1b' : ($reg->status === 'diterima' ? '#1e40af' : '#991b1b') }};">
                  {{ ucfirst($reg->status) }}
                </span>
              </td>
              <td style="padding: 10px; color: #7f8c8d;">{{ $reg->created_at->format("d M Y") }}</td>
            </tr>
          @endforeach
        </tbody>
      </table>
      @if($this->results->count() > 5)
        <small style="display: block; color: #7f8c8d; margin-top: 8px; text-align: center;">
          +{{ $this->results->count() - 5 }} data lainnya
        </small>
      @endif
    </div>
  @endif
</div>
