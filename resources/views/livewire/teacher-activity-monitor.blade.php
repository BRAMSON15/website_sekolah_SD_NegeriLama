<div class="container-fluid py-4">
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div>
                    <h2 class="h3 fw-bold text-dark">
                        <i class="fas fa-eye me-2 text-primary"></i>Monitoring Aktivitas Guru
                    </h2>
                    <p class="text-muted small">Live monitoring aktivitas input/output guru secara real-time</p>
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

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-md-3 mb-3">
            <div class="card border-start border-primary border-3 shadow-sm">
                <div class="card-body">
                    <h6 class="text-muted text-uppercase fw-bold small">Total Aktif</h6>
                    <h3 class="fw-bold text-primary">{{ $this->teacherStats()['total_active'] }}</h3>
                    <small class="text-success"><i class="fas fa-arrow-up"></i> Guru aktif 24 jam</small>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card border-start border-warning border-3 shadow-sm">
                <div class="card-body">
                    <h6 class="text-muted text-uppercase fw-bold small">Pending</h6>
                    <h3 class="fw-bold text-warning">{{ $this->teacherStats()['total_pending'] }}</h3>
                    <small class="text-warning"><i class="fas fa-clock"></i> Belum aktif 24 jam</small>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card border-start border-danger border-3 shadow-sm">
                <div class="card-body">
                    <h6 class="text-muted text-uppercase fw-bold small">Inactive</h6>
                    <h3 class="fw-bold text-danger">{{ $this->teacherStats()['total_inactive'] }}</h3>
                    <small class="text-danger"><i class="fas fa-arrow-down"></i> Belum aktif > 7 hari</small>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card border-start border-info border-3 shadow-sm">
                <div class="card-body">
                    <h6 class="text-muted text-uppercase fw-bold small">Total Guru</h6>
                    <h3 class="fw-bold text-info">{{ $this->teacherStats()['total_all'] }}</h3>
                    <small class="text-info"><i class="fas fa-users"></i> Keseluruhan</small>
                </div>
            </div>
        </div>
    </div>

    <!-- Top Teachers Section -->
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header bg-light border-bottom">
                    <h5 class="mb-0 fw-bold"><i class="fas fa-star text-warning me-2"></i>Top 5 Guru Paling Aktif</h5>
                </div>
                <div class="card-body">
                    @forelse($this->topTeachers() as $top)
                        <div class="d-flex justify-content-between align-items-center mb-3 pb-3 border-bottom">
                            <div>
                                <h6 class="mb-1 fw-bold">{{ $top->teacher->name }}</h6>
                                <small class="text-muted">
                                    {{ $top->teacher->subject ?? 'N/A' }} • NIP: {{ $top->teacher->nip }}
                                </small>
                            </div>
                            <div class="text-end">
                                <span class="badge bg-success">Score: {{ $top->activity_score }}</span>
                                <br>
                                <small class="text-muted">
                                    📄 {{ $top->materials_count }} 🎥 {{ $top->videos_count }}
                                </small>
                            </div>
                        </div>
                    @empty
                        <p class="text-muted text-center py-4">
                            <i class="fas fa-inbox"></i> Tidak ada data guru aktif
                        </p>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Recent Activity Summary -->
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header bg-light border-bottom">
                    <h5 class="mb-0 fw-bold"><i class="fas fa-activity text-success me-2"></i>Ringkasan Aktivitas</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <div class="d-flex justify-content-between mb-2">
                            <span class="fw-bold">Aktivitas 24 Jam</span>
                            <span class="badge bg-primary">{{ $this->recentActivityCount() }}</span>
                        </div>
                        <div class="progress" role="progressbar" style="height: 8px;">
                            <div class="progress-bar bg-success" style="width: 100%"></div>
                        </div>
                    </div>
                    <div class="row text-center mt-4">
                        <div class="col-md-4">
                            <h6 class="text-muted small mb-2">Material Upload</h6>
                            <h4 class="fw-bold text-primary">
                                {{ $this->teacherActivities()->sum(function($a) { return $a->activity_type === 'material_upload' ? 1 : 0; }) }}
                            </h4>
                        </div>
                        <div class="col-md-4">
                            <h6 class="text-muted small mb-2">Video Upload</h6>
                            <h4 class="fw-bold text-warning">
                                {{ $this->teacherActivities()->sum(function($a) { return $a->activity_type === 'video_upload' ? 1 : 0; }) }}
                            </h4>
                        </div>
                        <div class="col-md-4">
                            <h6 class="text-muted small mb-2">Assignment Create</h6>
                            <h4 class="fw-bold text-info">
                                {{ $this->teacherActivities()->sum(function($a) { return $a->activity_type === 'assignment_create' ? 1 : 0; }) }}
                            </h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters Section -->
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-light border-bottom">
            <h5 class="mb-0 fw-bold"><i class="fas fa-filter me-2"></i>Filter & Pencarian</h5>
        </div>
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label fw-bold small">Pencarian</label>
                    <input 
                        type="text" 
                        class="form-control form-control-sm" 
                        placeholder="Cari nama guru, NIP, atau email..."
                        wire:model.live="search"
                    >
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-bold small">Status</label>
                    <select class="form-select form-select-sm" wire:model.live="filterStatus">
                        <option value="all">Semua Status</option>
                        <option value="active">Aktif</option>
                        <option value="pending">Pending</option>
                        <option value="inactive">Inactive</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-bold small">Tipe Aktivitas</label>
                    <select class="form-select form-select-sm" wire:model.live="filterActivityType">
                        <option value="all">Semua Tipe</option>
                        <option value="material_upload">Material Upload</option>
                        <option value="video_upload">Video Upload</option>
                        <option value="assignment_create">Assignment Create</option>
                    </select>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-md-12">
                    <button class="btn btn-sm btn-outline-secondary" wire:click="resetFilters">
                        <i class="fas fa-redo me-2"></i>Reset Filters
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Activities Table -->
    <div class="card shadow-sm">
        <div class="card-header bg-light border-bottom">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-bold"><i class="fas fa-list me-2"></i>Daftar Aktivitas Real-time</h5>
                <small class="text-muted">
                    <i class="fas fa-sync-alt fa-spin"></i> Updating setiap {{ $pollingInterval / 1000 }}s
                </small>
            </div>
        </div>
        <div class="card-body p-0">
            @forelse($this->teacherActivities() as $activity)
                <div class="d-flex justify-content-between align-items-start p-3 border-bottom activity-row hover" style="transition: background-color 0.3s;">
                    <div class="flex-grow-1">
                        <div class="d-flex align-items-center mb-2">
                            <img 
                                src="https://ui-avatars.com/api/?name={{ urlencode($activity->teacher->name) }}&background=0D8ABC&color=fff&size=32" 
                                alt="{{ $activity->teacher->name }}" 
                                class="rounded-circle me-2" 
                                width="32" 
                                height="32"
                            >
                            <div>
                                <h6 class="mb-0 fw-bold">{{ $activity->teacher->name }}</h6>
                                <small class="text-muted">{{ $activity->teacher->subject ?? 'N/A' }} • NIP: {{ $activity->teacher->nip }}</small>
                            </div>
                        </div>
                        <p class="mb-2 text-dark">{{ $activity->description }}</p>
                        <small class="text-muted">
                            <i class="far fa-clock me-1"></i>{{ $activity->created_at->diffForHumans() }}
                        </small>
                    </div>
                    <div class="text-end ms-3">
                        <span class="badge @switch($activity->activity_type)
                            @case('material_upload') bg-info @break
                            @case('video_upload') bg-warning @break
                            @case('assignment_create') bg-primary @break
                            @default bg-secondary
                        @endswitch">
                            {{ ucfirst(str_replace('_', ' ', $activity->activity_type)) }}
                        </span>
                    </div>
                </div>
            @empty
                <div class="p-4 text-center">
                    <i class="fas fa-inbox fa-2x text-muted mb-3"></i>
                    <p class="text-muted">Tidak ada aktivitas yang sesuai dengan filter</p>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($this->teacherActivities()->count() > 0)
            <div class="card-footer bg-light border-top">
                <nav aria-label="Page navigation">
                    {{ $this->teacherActivities()->links('pagination::bootstrap-4') }}
                </nav>
            </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
    // Auto-scroll ke aktivitas terbaru
    document.addEventListener('livewire:navigated', function() {
        const activityRows = document.querySelectorAll('.activity-row');
        if (activityRows.length > 0) {
            activityRows[0].scrollIntoView({ behavior: 'smooth', block: 'nearest' });
        }
    });

    // Pulse effect untuk highlight
    Livewire.on('activity-refreshed', () => {
        const activityRows = document.querySelectorAll('.activity-row');
        if (activityRows.length > 0) {
            activityRows[0].style.backgroundColor = '#fff3cd';
            setTimeout(() => {
                activityRows[0].style.backgroundColor = '';
            }, 2000);
        }
    });
</script>
@endpush

<style>
    .activity-row:hover {
        background-color: #f8f9fa !important;
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
