@extends('layouts.admin')

@section('content')
<div class="container-fluid p-0">

    <header class="admin-header">
        <div class="d-flex justify-content-between align-items-center h-100 px-4">
            <div class="h5 mb-0 fw-bold">
                <i class="fas fa-film me-2 text-primary"></i> CineFeel Admin Panel
            </div>
            <div class="text-white">
                Welcome, *{{ auth()->user()->name ?? 'Admin' }}* </div>
        </div>
    </header>

    <div class="row g-0">
        <nav class="col-md-3 d-none d-md-block bg-dark admin-sidebar sidebar">
            <div class="sidebar-sticky">
                <div class="p-3 text-white-50 small text-uppercase fw-bold">
                    CineFeel Content
                </div>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('admin.dashboard') }}">
                            <i class="fas fa-tachometer-alt me-2"></i> Dashboard
                        </a>
                    </li>
                    {{-- Assuming you will add dedicated pages for managing Movies and Moods --}}
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.movies.index') }}">
                            <i class="fas fa-film me-2"></i> Manage Movies
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.moods.index') }}">
                            <i class="fas fa-smile me-2"></i> Manage Moods
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.reviews.index') }}">
                            <i class="fas fa-star me-2"></i> Manage Reviews
                        </a>
                    </li>

                    <li class="nav-item mt-3 border-top pt-2">
                        <a class="nav-link text-danger" href="#" data-bs-toggle="modal" data-bs-target="#logoutModal">
                            <i class="fas fa-sign-out-alt me-2"></i> Logout
                        </a>
                    </li>
                </ul>
            </div>
        </nav>

        <main class="col-md-9 offset-md-3 col-lg-9 px-md-4 dashboard-content">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-4 border-bottom">
                <h1 class="h2 text-dark fw-bold">Movie Admin Dashboard</h1>
                {{-- Search Bar - Remains --}}
                <div class="input-group shadow-sm" style="width: 300px;">
                    <input type="text" class="form-control" id="searchInput" placeholder="Search movies by title, mood...">
                    <button class="btn btn-outline-secondary" type="button" id="searchButton">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            {{-- Metric Cards: Total Movies and Total Moods --}}
            <h2 class="h5 mb-3 text-muted">Content Overview</h2>
            <div class="row g-4 mb-5">
                <div class="col-lg-6">
                    <div class="card shadow-sm border-0 stat-card bg-primary text-white">
                        <div class="card-body">
                            <h6 class="text-uppercase fw-bold opacity-75">Total Movies</h6>
                            {{-- Placeholder for actual movie count --}}
                            <h2 class="display-4">{{ $movieCount ?? '0' }}</h2>
                        </div>
                        <i class="fas fa-film stat-icon-lg"></i>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card shadow-sm border-0 stat-card bg-info text-white">
                        <div class="card-body">
                            <h6 class="text-uppercase fw-bold opacity-75">Total Mood Selections</h6>
                            {{-- Placeholder for actual mood count --}}
                            <h2 class="display-4">{{ $moodCount ?? '0' }}</h2>
                        </div>
                        <i class="fas fa-smile stat-icon-lg"></i>
                    </div>
                </div>
            </div>


            {{-- Movies Table --}}
            <div class="card shadow-lg border-0" id="movieList">
                <div class="card-header bg-secondary text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="fas fa-list me-2"></i> All Movie Entries</h5>
                    <div class="dropdown">
                        <button class="btn btn-sm btn-outline-light dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-sort me-1"></i> Sort By
                        </button>
                        <ul class="dropdown-menu dropdown-menu-dark">
                            {{-- FIX: Use request()->fullUrlWithQuery to maintain filters and correctly apply sorting --}}
                            <li><a class="dropdown-item" href="{{ request()->fullUrlWithQuery(['sort' => 'title', 'page' => 1]) }}">Title (A-Z)</a></li>
                            <li><a class="dropdown-item" href="{{ request()->fullUrlWithQuery(['sort' => 'release_year', 'page' => 1]) }}">Release Year</a></li>
                            <li><a class="dropdown-item" href="{{ request()->fullUrlWithQuery(['sort' => 'mood', 'page' => 1]) }}">Mood</a></li>
                        </ul>
                    </div>
                </div>
                {{-- Added max-height and overflow-y to make the table body scrollable --}}
                <div class="card-body p-0 table-scroll-wrapper">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover align-middle mb-0" id="movieTable">
                            <thead class="table-dark sticky-header">
                                <tr>
                                    <th style="width: 5%;"><i class="fas fa-hashtag"></i> ID</th>
                                    <th style="width: 35%;"><i class="fas fa-heading"></i> Title</th>
                                    <th style="width: 20%;"><i class="fas fa-smile"></i> Mood</th>
                                    <th style="width: 15%;"><i class="fas fa-calendar-alt"></i> Year</th>
                                    <th style="width: 25%;"><i class="fas fa-cogs"></i> Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- Loop through the movies data --}}
                                @forelse($movies as $movie)
                                    <tr>
                                        <td>{{ $movie->id }}</td>
                                        <td>{{ $movie->title }}</td>
                                        <td><span class="badge bg-secondary">{{ $movie->mood->name ?? 'N/A' }}</span></td>
                                        <td>{{ $movie->release_year }}</td>
                                        <td>
                                            {{-- Example action links --}}
                                            <a href="{{ route('admin.movies.edit', $movie->id) }}" class="btn btn-sm btn-outline-primary me-2">
                                                <i class="fas fa-edit"></i> Edit
                                            </a>
                                            <form method="POST" action="{{ route('admin.movies.delete', $movie->id) }}" style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete movie: {{ $movie->title }}?')">
                                                    <i class="fas fa-trash"></i> Delete
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-4 text-muted">No movies found in the database. Start by adding one!</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="logoutModalLabel">Confirm Logout</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to log out from the admin panel?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                        @csrf
                        <button type="submit" class="btn btn-danger">Logout</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Define the header height for offsets */
:root {
    --header-height: 56px; /* Standard Bootstrap navbar height */
    --sidebar-width: 25%;
}

/* --- Fixed Header --- */
.admin-header {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: var(--header-height);
    background-color: #2d3436; /* Dark theme */
    color: #fff;
    z-index: 1000; /* Ensure it stays on top */
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
}

/* --- Layout Fix with Header Offset --- */
.admin-sidebar {
    width: var(--sidebar-width);
    background-color: #2d3436 !important;
    position: fixed;
    top: var(--header-height); /* Starts right below the fixed header */
    bottom: 0;
    left: 0;
    z-index: 100;
    padding: 0;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
}

.dashboard-content {
    width: calc(100% - var(--sidebar-width));
    margin-left: var(--sidebar-width); /* Compensates for fixed sidebar width */
    padding: 20px;
    margin-top: var(--header-height); /* Pushes content down below the fixed header */
    background-color: #f5f6fa;
}

/* --- Sidebar Styling --- */
.sidebar-sticky {
    position: relative;
    top: 0;
    height: calc(100vh - var(--header-height)); /* Fills screen height minus header */
    padding-top: 1rem;
    overflow-x: hidden;
    overflow-y: auto;
}

.sidebar .nav-link {
    font-weight: 500;
    color: rgba(255, 255, 255, 0.7);
    padding: 0.75rem 1rem;
    transition: all 0.2s ease;
    border-radius: 6px;
    margin: 0 10px 2px;
}

.sidebar .nav-link:hover:not(.active) {
    color: #fff;
    background-color: rgba(108, 92, 231, 0.2);
}

.sidebar .nav-link.active {
    color: #fff;
    background-color: #6c5ce7;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
}

/* --- Sticky Table Header Fix --- */
.table-scroll-wrapper {
    max-height: 500px;
    overflow-y: auto;
}

.sticky-header {
    position: sticky;
    top: 0;
    z-index: 10;
    box-shadow: 0 2px 2px -1px rgba(0, 0, 0, 0.4);
}
.table-dark.sticky-header th {
    background-color: #343a40;
}
/* End Sticky Header Fix */


/* Card and Content Styling */
.card {
    border: none;
    border-radius: 12px;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.card:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1) !important;
}

.card-header {
    font-weight: bold;
    border-bottom: none;
    padding: 1rem 1.5rem;
    border-top-left-radius: 12px;
    border-top-right-radius: 12px;
}

.table-dark {
    background-color: #343a40;
}

/* Stat Cards */
.stat-card {
    position: relative;
    overflow: hidden;
    border-radius: 15px;
    background: linear-gradient(135deg, #0f172a, #1e3a8a);
    box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1.5rem;
}

.stat-card .card-body {
    z-index: 2;
    padding: 0;
}

.stat-icon-lg {
    position: absolute;
    right: 15px;
    bottom: -5px;
    font-size: 5rem;
    opacity: 0.2;
    color: white;
    z-index: 1;
}

/* Resetting Bootstrap's default margin on specific screen sizes */
@media (min-width: 768px) {
    .col-md-9.offset-md-3 {
        margin-left: var(--sidebar-width) !important;
    }
}
</style>

@push('scripts')
<script>
// Filter table rows on keyup (Adjusted to filter movies)
document.getElementById('searchInput').addEventListener('keyup', function() {
    const searchTerm = this.value.toLowerCase();
    const table = document.getElementById('movieTable'); // Changed from adminTable
    const rows = table.getElementsByTagName('tbody')[0].getElementsByTagName('tr');

    for (let i = 0; i < rows.length; i++) {
        const cells = rows[i].getElementsByTagName('td');
        let found = false;
        // Search across Title (index 1) and Mood (index 2)
        for (let j = 1; j <= 2; j++) {
            if (cells[j].textContent.toLowerCase().includes(searchTerm)) {
                found = true;
                break;
            }
        }
        rows[i].style.display = found ? '' : 'none';
    }
});

document.getElementById('searchButton').addEventListener('click', function() {
    document.getElementById('searchInput').focus();
});
</script>
@endpush
@endsection