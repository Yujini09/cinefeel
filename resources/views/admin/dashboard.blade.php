@extends('layouts.app')

@section('title', 'Admin Dashboard')

{{-- Push admin.css and admin.js to the layout's stacks --}}
@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
@endpush
@push('scripts')
    <script src="{{ asset('js/admin.js') }}"></script>
@endpush

@php
    $isAdminPage = true; // Flag for conditional navigation links in the layout
@endphp

<div class="admin-container">
    {{-- Dashboard Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="dashboard-title">Admin Dashboard</h1>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.movies') }}" class="btn btn-main">
                <i class="fas fa-film me-1"></i> Manage Movies
            </a>
            <a href="{{ route('admin.moods') }}" class="btn btn-alt">
                <i class="fas fa-smile me-1"></i> Manage Moods
            </a>
        </div>
    </div>

    {{-- Stats Cards --}}
    <div class="row g-3 mb-4">
        <div class="col-md-6">
            <div class="stat-card">
                <div>
                    <p class="stat-label">Total Movies</p>
                    <h3 class="stat-value">{{ $moviesCount }}</h3>
                </div>
                <i class="fas fa-film stat-icon"></i>
            </div>
        </div>
        <div class="col-md-6">
            <div class="stat-card violet">
                <div>
                    <p class="stat-label">Total Moods</p>
                    <h3 class="stat-value">{{ $moodsCount }}</h3>
                </div>
                <i class="fas fa-smile stat-icon"></i>
            </div>
        </div>
    </div>

    {{-- Recently Added Movies --}}
    <div class="card shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h6 class="m-0">Recently Added Movies</h6>
            <a href="{{ route('admin.movies') }}" class="btn btn-small">View All</a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th>Poster</th>
                            <th>Title</th>
                            <th>Genre</th>
                            <th>Mood</th>
                            <th>Year</th>
                            <th>Duration</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($recentMovies->isEmpty())
                        <tr>
                            <td colspan="6" class="text-center py-4">
                                <i class="fas fa-film fa-3x text-muted mb-2"></i>
                                <p class="text-muted">No movies found. Add your first movie!</p>
                                <a href="{{ route('admin.movies') }}" class="btn btn-main">
                                    <i class="fas fa-plus me-1"></i> Add Movie
                                </a>
                            </td>
                        </tr>
                        @else
                            @foreach ($recentMovies as $movie)
                            <tr>
                                <td>
                                    @if ($movie->poster_url)
                                        <img src="{{ $movie->poster_url }}"
                                            alt="{{ $movie->title }}"
                                            class="poster-img">
                                    @else
                                        <div class="poster-placeholder">
                                            <i class="fas fa-film text-muted"></i>
                                        </div>
                                    @endif
                                </td>
                                <td>{{ $movie->title }}</td>
                                <td><span class="badge bg-danger">{{ optional($movie->genres->first())->genre_name ?? 'N/A' }}</span></td>
                                <td><span class="badge bg-info">{{ optional($movie->mood)->emoji . ' ' . optional($movie->mood)->mood_name ?? 'None' }}</span></td>
                                <td><span class="badge bg-dark">{{ $movie->release_year ?? 'N/A' }}</span></td>
                                <td><span class="text-muted">{{ $movie->duration ?? 'N/A' }}</span></td>
                            </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
