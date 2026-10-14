<div wire:poll-5000ms>
  <div class="row g-3">
    <!-- Total Widget -->
    <div class="col-lg-3 col-md-6">
      <div class="card-box" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 24px; text-align: center; border-radius: 12px; color: white; box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);">
        <i class="fa-solid fa-users" style="font-size: 2.5rem; margin-bottom: 12px; display: block;"></i>
        <p style="font-size: 0.9rem; opacity: 0.9; margin: 0;">Total Pendaftar</p>
        <h2 style="font-size: 2.5rem; font-weight: 700; margin: 8px 0 0;">{{ $this->stats[''total''] }}</h2>
      </div>
    </div>

    <!-- Pending Widget -->
    <div class="col-lg-3 col-md-6">
      <div class="card-box" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); padding: 24px; text-align: center; border-radius: 12px; color: white; box-shadow: 0 4px 15px rgba(245, 87, 108, 0.4);">
        <i class="fa-solid fa-clock" style="font-size: 2.5rem; margin-bottom: 12px; display: block;"></i>
        <p style="font-size: 0.9rem; opacity: 0.9; margin: 0;">Menunggu Review</p>
        <h2 style="font-size: 2.5rem; font-weight: 700; margin: 8px 0 0;">{{ $this->stats[''pending''] }}</h2>
        <small style="opacity: 0.8;">{{ $this->stats[''pending_percent''] }}%</small>
      </div>
    </div>

    <!-- Accepted Widget -->
    <div class="col-lg-3 col-md-6">
      <div class="card-box" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); padding: 24px; text-align: center; border-radius: 12px; color: white; box-shadow: 0 4px 15px rgba(79, 172, 254, 0.4);">
        <i class="fa-solid fa-check-circle" style="font-size: 2.5rem; margin-bottom: 12px; display: block;"></i>
        <p style="font-size: 0.9rem; opacity: 0.9; margin: 0;">Diterima</p>
        <h2 style="font-size: 2.5rem; font-weight: 700; margin: 8px 0 0;">{{ $this->stats[''accepted''] }}</h2>
        <small style="opacity: 0.8;">{{ $this->stats[''accepted_percent''] }}%</small>
      </div>
    </div>

    <!-- Rejected Widget -->
    <div class="col-lg-3 col-md-6">
      <div class="card-box" style="background: linear-gradient(135deg, #fa709a 0%, #fee140 100%); padding: 24px; text-align: center; border-radius: 12px; color: white; box-shadow: 0 4px 15px rgba(250, 112, 154, 0.4);">
        <i class="fa-solid fa-times-circle" style="font-size: 2.5rem; margin-bottom: 12px; display: block;"></i>
        <p style="font-size: 0.9rem; opacity: 0.9; margin: 0;">Ditolak</p>
        <h2 style="font-size: 2.5rem; font-weight: 700; margin: 8px 0 0;">{{ $this->stats[''rejected''] }}</h2>
        <small style="opacity: 0.8;">{{ $this->stats[''rejected_percent''] }}%</small>
      </div>
    </div>
  </div>
</div>
