@extends("layouts.app")

@section("title", "Monitoring PPDB - " . ($settings["school_name"] ?? "SD Negeri Lama"))

@section("content")
<div class="page-header">
  <h1><i class="fa-solid fa-chart-line"></i> Monitoring Registrasi PPDB</h1>
  <p>Real-time monitoring aktivitas dan statistik pendaftaran PPDB</p>
</div>

<div class="page-content">
  <div class="row mb-4">
    <div class="col-lg-8">
      @livewire("ppdb-monitoring-stats", key(time()))
    </div>
    <div class="col-lg-4">
      <button type="button" class="btn btn-success w-100" onclick="document.querySelector(\"[wire:click='exportCSV']\")?.click()"
              style="padding: 12px; font-weight: 600; border-radius: 8px; border: 0; cursor: pointer;">
        <i class="fa-solid fa-download"></i> Export CSV
      </button>
    </div>
  </div>

  <div class="row">
    <div class="col-lg-4">
      <div class="card-box" style="padding: 20px; height: 100%;">
        <h3 style="font-size: 1.1rem; color: var(--primary); margin-bottom: 16px;">
          <i class="fa-solid fa-search"></i> Filter & Pencarian
        </h3>
        @livewire("ppdb-registration-search")
      </div>
    </div>

    <div class="col-lg-8">
      <div class="card-box" style="padding: 20px;">
        <h3 style="font-size: 1.1rem; color: var(--primary); margin-bottom: 16px;">
          <i class="fa-solid fa-list"></i> Aktivitas Terbaru
        </h3>
        @livewire("ppdb-activity-feed", key(time()))
      </div>
    </div>
  </div>
</div>
@endsection
