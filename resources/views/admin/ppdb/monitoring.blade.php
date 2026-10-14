@extends("layouts.app")

@section("title", "Monitoring Registrasi PPDB - " . ($settings["school_name"] ?? "SD Negeri Lama"))

@section("content")
<div class="page-header">
  <h1><i class="fa-solid fa-chart-line"></i> Monitoring Registrasi PPDB Real-time</h1>
  <p>Dashboard monitoring live pendaftaran PPDB dengan polling otomatis</p>
</div>

<div class="page-content">
  <!-- Statistics Widgets -->
  <div class="row mb-4">
    <div class="col-12">
      <livewire:ppdb-monitoring-stats wire:key="stats-{{ time() }}" />
    </div>
  </div>

  <!-- Main Content -->
  <div class="row">
    <!-- Filter Sidebar -->
    <div class="col-lg-3">
      <div class="card-box" style="padding: 20px;">
        <h3 style="font-size: 1.1rem; color: var(--primary); margin-bottom: 16px; display: flex; align-items: center; gap: 8px;">
          <i class="fa-solid fa-filter"></i> Filter & Cari
        </h3>
        <livewire:ppdb-registration-search />
      </div>
    </div>

    <!-- Activity Feed -->
    <div class="col-lg-9">
      <div class="card-box" style="padding: 20px;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px;">
          <h3 style="font-size: 1.1rem; color: var(--primary); margin: 0; display: flex; align-items: center; gap: 8px;">
            <i class="fa-solid fa-list"></i> Aktivitas Terbaru
            <span style="background: #e0e7ff; color: #4338ca; padding: 2px 8px; border-radius: 12px; font-size: 0.8rem; font-weight: 600; margin-left: 8px;">
              Real-time 3s
            </span>
          </h3>
          <a href="{{ route("admin.ppdb.index") }}" class="btn-login" style="padding: 8px 16px; font-size: 0.9rem; text-decoration: none;">
            <i class="fa-solid fa-list"></i> Lihat Semua
          </a>
        </div>
        <livewire:ppdb-activity-feed wire:key="activities-{{ time() }}" />
      </div>
    </div>
  </div>

  <!-- Info Box -->
  <div style="margin-top: 24px; padding: 16px; background: #f0f9ff; border-left: 4px solid #0284c7; border-radius: 8px;">
    <p style="margin: 0; color: #0c4a6e; font-size: 0.9rem;">
      <i class="fa-solid fa-info-circle" style="margin-right: 8px;"></i>
      <strong>Informasi:</strong> Dashboard ini melakukan polling otomatis setiap 3-5 detik untuk menampilkan data registrasi terbaru. Semua aktivitas pendaftaran PPDB akan ditampilkan secara real-time.
    </p>
  </div>
</div>
@endsection
