<div class="container-fluid py-4">
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div>
                    <h2 class="h3 fw-bold text-dark">
                        <i class="fas fa-chart-line me-2 text-success"></i>Statistik Performa Guru
                    </h2>
                    <p class="text-muted small">Dashboard analitik real-time untuk memonitor performa dan produktivitas guru</p>
                </div>
                <div class="text-end">
                    <span class="badge bg-success me-2">
                        <i class="fas fa-sync-alt me-1"></i>Live Update
                    </span>
                    <small class="text-muted">Refresh: {{ $pollingInterval / 1000 }}s</small>
                </div>
            </div>
        </div>
    </div>

    <!-- Overall Metrics Cards -->
    <div class="row mb-4">
        <div class="col-md-2 mb-3">
            <div class="card text-center shadow-sm">
                <div class="card-body">
                    <h6 class="text-muted text-uppercase fw-bold small mb-2">Rata-rata Score</h6>
                    <h2 class="fw-bold text-primary">
                        {{ number_format($this->overallMetrics()['average_activity_score'], 0) }}
                    </h2>
                    <small class="text-muted">/100</small>
                </div>
            </div>
        </div>
        <div class="col-md-2 mb-3">
            <div class="card text-center shadow-sm">
                <div class="card-body">
                    <h6 class="text-muted text-uppercase fw-bold small mb-2">Total Material</h6>
                    <h2 class="fw-bold text-info">{{ $this->overallMetrics()['total_materials'] }}</h2>
                    <small class="text-muted">Uploaded</small>
                </div>
            </div>
        </div>
        <div class="col-md-2 mb-3">
            <div class="card text-center shadow-sm">
                <div class="card-body">
                    <h6 class="text-muted text-uppercase fw-bold small mb-2">Total Video</h6>
                    <h2 class="fw-bold text-warning">{{ $this->overallMetrics()['total_videos'] }}</h2>
                    <small class="text-muted">Uploaded</small>
                </div>
            </div>
        </div>
        <div class="col-md-2 mb-3">
            <div class="card text-center shadow-sm">
                <div class="card-body">
                    <h6 class="text-muted text-uppercase fw-bold small mb-2">Total Tugas</h6>
                    <h2 class="fw-bold text-danger">{{ $this->overallMetrics()['total_assignments'] }}</h2>
                    <small class="text-muted">Created</small>
                </div>
            </div>
        </div>
        <div class="col-md-2 mb-3">
            <div class="card text-center shadow-sm border-success">
                <div class="card-body">
                    <h6 class="text-muted text-uppercase fw-bold small mb-2">Aktif</h6>
                    <h2 class="fw-bold text-success">{{ $this->overallMetrics()['active_teachers'] }}</h2>
                    <small class="text-muted">Guru</small>
                </div>
            </div>
        </div>
        <div class="col-md-2 mb-3">
            <div class="card text-center shadow-sm">
                <div class="card-body">
                    <h6 class="text-muted text-uppercase fw-bold small mb-2">Inactive</h6>
                    <h2 class="fw-bold text-danger">{{ $this->overallMetrics()['inactive_teachers'] }}</h2>
                    <small class="text-muted">Guru</small>
                </div>
            </div>
        </div>
    </div>

    <!-- Status Distribution & Top Performers -->
    <div class="row mb-4">
        <!-- Status Distribution Chart -->
        <div class="col-md-6 mb-3">
            <div class="card shadow-sm">
                <div class="card-header bg-light border-bottom">
                    <h5 class="mb-0 fw-bold"><i class="fas fa-chart-pie text-primary me-2"></i>Distribusi Status Guru</h5>
                </div>
                <div class="card-body">
                    @php
                        $distribution = $this->statusDistribution();
                    @endphp
                    
                    <!-- Active -->
                    <div class="mb-3">
                        <div class="d-flex justify-content-between mb-1">
                            <span class="fw-bold">
                                <i class="fas fa-circle text-success me-2" style="font-size: 0.5rem;"></i>Aktif
                            </span>
                            <span class="badge bg-success">{{ $distribution['active']['count'] }} ({{ number_format($distribution['active']['percentage'], 1) }}%)</span>
                        </div>
                        <div class="progress" role="progressbar" style="height: 20px;">
                            <div class="progress-bar bg-success" style="width: {{ $distribution['active']['percentage'] }}%">
                                {{ number_format($distribution['active']['percentage'], 0) }}%
                            </div>
                        </div>
                    </div>

                    <!-- Pending -->
                    <div class="mb-3">
                        <div class="d-flex justify-content-between mb-1">
                            <span class="fw-bold">
                                <i class="fas fa-circle text-warning me-2" style="font-size: 0.5rem;"></i>Pending
                            </span>
                            <span class="badge bg-warning">{{ $distribution['pending']['count'] }} ({{ number_format($distribution['pending']['percentage'], 1) }}%)</span>
                        </div>
                        <div class="progress" role="progressbar" style="height: 20px;">
                            <div class="progress-bar bg-warning" style="width: {{ $distribution['pending']['percentage'] }}%">
                                {{ number_format($distribution['pending']['percentage'], 0) }}%
                            </div>
                        </div>
                    </div>

                    <!-- Inactive -->
                    <div class="mb-3">
                        <div class="d-flex justify-content-between mb-1">
                            <span class="fw-bold">
                                <i class="fas fa-circle text-danger me-2" style="font-size: 0.5rem;"></i>Inactive
                            </span>
                            <span class="badge bg-danger">{{ $distribution['inactive']['count'] }} ({{ number_format($distribution['inactive']['percentage'], 1) }}%)</span>
                        </div>
                        <div class="progress" role="progressbar" style="height: 20px;">
                            <div class="progress-bar bg-danger" style="width: {{ $distribution['inactive']['percentage'] }}%">
                                {{ number_format($distribution['inactive']['percentage'], 0) }}%
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Top Performers -->
        <div class="col-md-6 mb-3">
            <div class="card shadow-sm">
                <div class="card-header bg-light border-bottom">
                    <h5 class="mb-0 fw-bold"><i class="fas fa-trophy text-warning me-2"></i>Top 3 Performa Terbaik</h5>
                </div>
                <div class="card-body">
                    @forelse($this->topPerformers() as $index => $performer)
                        <div class="mb-3 pb-3 @if(!$loop->last) border-bottom @endif">
                            <div class="d-flex align-items-start">
                                <div class="me-3">
                                    <span class="badge @switch($index)
                                        @case(0) bg-warning @break
                                        @case(1) bg-secondary @break
                                        @case(2) bg-info @break
                                    @endswitch" style="font-size: 0.9rem;">
                                        #{{ $index + 1 }}
                                    </span>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-1 fw-bold">{{ $performer->teacher->name }}</h6>
                                    <p class="mb-2 small text-muted">
                                        {{ $performer->teacher->subject ?? 'N/A' }} • 
                                        <i class="fas fa-envelope me-1"></i>{{ $performer->teacher->email }}
                                    </p>
                                    <div class="d-flex justify-content-between small mb-2">
                                        <span>Score: <strong>{{ $performer->activity_score }}/100</strong></span>
                                        <span class="badge bg-{{ $performer->getStatusBadgeAttribute() }}">{{ ucfirst($performer->status) }}</span>
                                    </div>
                                    <div class="d-flex gap-2 small">
                                        <span><i class="fas fa-file-alt text-info me-1"></i>{{ $performer->materials_count }} Material</span>
                                        <span><i class="fas fa-video text-warning me-1"></i>{{ $performer->videos_count }} Video</span>
                                        <span><i class="fas fa-tasks text-danger me-1"></i>{{ $performer->assignments_count }} Tugas</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <p class="text-muted text-center py-4">
                            <i class="fas fa-inbox"></i> Tidak ada data guru
                        </p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- Teachers Need Attention -->
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card shadow-sm border-danger">
                <div class="card-header bg-light border-bottom border-danger">
                    <h5 class="mb-0 fw-bold text-danger">
                        <i class="fas fa-exclamation-triangle me-2"></i>Guru yang Perlu Perhatian
                    </h5>
                </div>
                <div class="card-body">
                    @forelse($this->needsAttention() as $teacher)
                        <div class="alert alert-warning mb-2 py-2" role="alert">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <strong>{{ $teacher->teacher->name }}</strong> 
                                    <small class="text-muted">({{ $teacher->teacher->subject ?? 'N/A' }})</small>
                                    <br>
                                    <small class="text-muted">
                                        <i class="fas fa-clock me-1"></i>
                                        @if($teacher->last_activity_at)
                                            Terakhir aktif: {{ $teacher->last_activity_at->diffForHumans() }}
                                        @else
                                            Belum pernah aktif
                                        @endif
                                    </small>
                                </div>
                                <div class="text-end">
                                    <span class="badge bg-danger">Inactive</span>
                                    <br>
                                    <small class="text-muted">Score: {{ $teacher->activity_score }}</small>
                                </div>
                            </div>
                        </div>
                    @empty
                        <p class="text-muted text-center py-3">
                            <i class="fas fa-check-circle text-success me-2"></i>Semua guru dalam status baik
                        </p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- Full Teachers Table with Sorting -->
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow-sm">
                <div class="card-header bg-light border-bottom">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 fw-bold"><i class="fas fa-table me-2"></i>Tabel Performa Semua Guru</h5>
                        <small class="text-muted">
                            <i class="fas fa-sync-alt fa-spin"></i> Updating setiap {{ $pollingInterval / 1000 }}s
                        </small>
                    </div>
                </div>
                <div class="card-body p-0 table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th style="cursor: pointer;" wire:click="updateSort('activity_score')">
                                    <i class="fas fa-arrow-sort me-1"></i>Score
                                </th>
                                <th>Nama Guru</th>
                                <th>Mata Pelajaran</th>
                                <th>Status</th>
                                <th style="cursor: pointer;" wire:click="updateSort('materials_count')">
                                    <i class="fas fa-arrow-sort me-1"></i>Material
                                </th>
                                <th style="cursor: pointer;" wire:click="updateSort('videos_count')">
                                    <i class="fas fa-arrow-sort me-1"></i>Video
                                </th>
                                <th>Tugas</th>
                                <th style="cursor: pointer;" wire:click="updateSort('last_activity_at')">
                                    <i class="fas fa-arrow-sort me-1"></i>Aktivitas Terakhir
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($this->teacherPerformances() as $performance)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="progress me-2" style="width: 60px; height: 20px;">
                                                <div 
                                                    class="progress-bar @switch($performance->activity_score)
                                                        @case($performance->activity_score >= 80) bg-success @break
                                                        @case($performance->activity_score >= 50) bg-warning @break
                                                        @default bg-danger
                                                    @endswitch" 
                                                    style="width: {{ $performance->activity_score }}%"
                                                >
                                                    {{ $performance->activity_score }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <strong>{{ $performance->teacher->name }}</strong>
                                        <br>
                                        <small class="text-muted">{{ $performance->teacher->email }}</small>
                                    </td>
                                    <td>{{ $performance->teacher->subject ?? 'N/A' }}</td>
                                    <td>
                                        <span class="badge bg-{{ $performance->getStatusBadgeAttribute() }}">
                                            {{ ucfirst($performance->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge bg-info">{{ $performance->materials_count }}</span>
                                    </td>
                                    <td>
                                        <span class="badge bg-warning">{{ $performance->videos_count }}</span>
                                    </td>
                                    <td>
                                        <span class="badge bg-danger">{{ $performance->assignments_count }}</span>
                                    </td>
                                    <td>
                                        <small class="text-muted">
                                            @if($performance->last_activity_at)
                                                {{ $performance->last_activity_at->diffForHumans() }}
                                            @else
                                                Belum ada
                                            @endif
                                        </small>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center py-4">
                                        <i class="fas fa-inbox fa-2x text-muted mb-3"></i>
                                        <p class="text-muted">Tidak ada data guru</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Highlight animasi saat data diupdate
    Livewire.on('performance-refreshed', () => {
        const tableRows = document.querySelectorAll('table tbody tr');
        if (tableRows.length > 0) {
            tableRows.forEach(row => {
                row.style.backgroundColor = '#fff3cd';
                setTimeout(() => {
                    row.style.backgroundColor = '';
                }, 1000);
            });
        }
    });
</script>
@endpush

<style>
    table tbody tr:hover {
        background-color: #f8f9fa !important;
    }

    thead th {
        vertical-align: middle;
        font-weight: 600;
    }

    .card {
        border: none;
        border-radius: 0.5rem;
    }

    .card-header {
        border-radius: 0.5rem 0.5rem 0 0;
    }

    .badge {
        font-size: 0.75rem;
        padding: 0.4rem 0.6rem;
    }
</style>
