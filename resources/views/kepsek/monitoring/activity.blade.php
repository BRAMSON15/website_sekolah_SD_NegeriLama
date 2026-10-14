@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('kepsek.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="#">Monitoring</a></li>
                    <li class="breadcrumb-item active">Aktivitas Guru</li>
                </ol>
            </nav>
        </div>
    </div>

    @livewire('teacher-activity-monitor', ['pollingInterval' => $pollingInterval])
</div>
@endsection

@push('styles')
<style>
    .breadcrumb {
        background-color: #f8f9fa;
        border-radius: 0.5rem;
        padding: 0.75rem 1rem;
    }
</style>
@endpush
