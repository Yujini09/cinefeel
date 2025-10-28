@extends('layouts.admin')

@section('content')
<div class="container-fluid p-0">

    <header class="admin-header">
        <div class="d-flex justify-content-between align-items-center h-100 px-4">
            <div class="h5 mb-0 fw-bold">
                <i class="fas fa-film me-2 text-primary"></i> CineFeel Admin Panel
            </div>
            <div class="text-white">
                Welcome, **{{ auth()->user()->name ?? 'Admin' }}** </div>
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
                        <a class="nav-link" href="{{ route('admin.dashboard') }}">
                            <i class="fas fa-tachometer-alt me-2"></i> Dashboard
                        </a>
                    </li>
                    {{-- Assuming you will add dedicated pages for managing Movies and Moods --}}
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('admin.movies.index') }}">
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
            @if(request()->routeIs('admin.movies.create'))
                <div class="pt-3 pb-2 mb-4 border-bottom">
                    <h1 class="h2 text-dark fw-bold">Add New Movie</h1>
                </div>

                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
                        <strong>Errors:</strong>
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <div class="card shadow-lg border-0">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><i class="fas fa-plus me-2"></i> Movie Details</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.movies.store') }}" method="POST">
                            @csrf

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="title" name="title" value="{{ old('title') }}" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="release_year" class="form-label">Release Year <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control" id="release_year" name="release_year" value="{{ old('release_year') }}" min="1900" max="{{ date('Y') + 1 }}" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label">Description <span class="text-danger">*</span></label>
                                <textarea class="form-control" id="description" name="description" rows="4" required>{{ old('description') }}</textarea>
                            </div>



                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="poster_path" class="form-label">Poster URL</label>
                                    <input type="url" class="form-control" id="poster_path" name="poster_path" value="{{ old('poster_path') }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="backdrop_path" class="form-label">Backdrop URL</label>
                                    <input type="url" class="form-control" id="backdrop_path" name="backdrop_path" value="{{ old('backdrop_path') }}">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="trailer_url" class="form-label">Trailer URL</label>
                                <input type="url" class="form-control" id="trailer_url" name="trailer_url" value="{{ old('trailer_url') }}">
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="mood_id" class="form-label">Mood <span class="text-danger">*</span></label>
                                    <select class="form-select" id="mood_id" name="mood_id" required>
                                        <option value="">Select Mood</option>
                                        @foreach($moods as $mood)
                                            <option value="{{ $mood->id }}" {{ old('mood_id') == $mood->id ? 'selected' : '' }}>{{ $mood->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="genres" class="form-label">Genres</label>
                                    {{-- The 'form-select' class provides the desired aesthetic. 'multiple' and 'name="genres[]"' enable multi-selection. --}}
                                    <select class="form-select" id="genres" name="genres[]" multiple>
                                        @foreach($genres as $genre)
                                            <option value="{{ $genre->id }}" {{ in_array($genre->id, old('genres', [])) ? 'selected' : '' }}>{{ $genre->name }}</option>
                                        @endforeach
                                    </select>
                                    <small class="form-text text-muted">Hold Ctrl (Cmd on Mac) to select multiple.</small>
                                </div>
                            </div>



                            <div class="d-flex justify-content-end gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-2"></i>Create Movie
                                </button>
                                <a href="{{ route('admin.movies.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left me-2"></i>Back to Movies
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            @elseif(request()->routeIs('admin.movies.edit'))
                <div class="pt-3 pb-2 mb-4 border-bottom">
                    <h1 class="h2 text-dark fw-bold">Edit Movie: {{ $movie->title }}</h1>
                </div>

                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
                        <strong>Errors:</strong>
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <div class="card shadow-lg border-0">
                    <div class="card-header bg-warning text-dark">
                        <h5 class="mb-0"><i class="fas fa-edit me-2"></i> Edit Movie Details</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.movies.update', $movie->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="title" name="title" value="{{ old('title', $movie->title) }}" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="release_year" class="form-label">Release Year <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control" id="release_year" name="release_year" value="{{ old('release_year', $movie->release_year) }}" min="1900" max="{{ date('Y') + 1 }}" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label">Description <span class="text-danger">*</span></label>
                                <textarea class="form-control" id="description" name="description" rows="4" required>{{ old('description', $movie->description) }}</textarea>
                            </div>



                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="poster_path" class="form-label">Poster URL</label>
                                    <input type="url" class="form-control" id="poster_path" name="poster_path" value="{{ old('poster_path', $movie->poster_path) }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="backdrop_path" class="form-label">Backdrop URL</label>
                                    <input type="url" class="form-control" id="backdrop_path" name="backdrop_path" value="{{ old('backdrop_path', $movie->backdrop_path) }}">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="trailer_url" class="form-label">Trailer URL</label>
                                <input type="url" class="form-control" id="trailer_url" name="trailer_url" value="{{ old('trailer_url', $movie->trailer_url) }}">
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="mood_id" class="form-label">Mood <span class="text-danger">*</span></label>
                                    <select class="form-select" id="mood_id" name="mood_id" required>
                                        <option value="">Select Mood</option>
                                        @foreach($moods as $mood)
                                            <option value="{{ $mood->id }}" {{ old('mood_id', $movie->mood_id) == $mood->id ? 'selected' : '' }}>{{ $mood->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="genres" class="form-label">Genres</label>
                                    <select class="form-select" id="genres" name="genres[]" multiple>
                                        @foreach($genres as $genre)
                                            <option value="{{ $genre->id }}" {{ $movie->genres->contains($genre->id) || in_array($genre->id, old('genres', [])) ? 'selected' : '' }}>{{ $genre->name }}</option>
                                        @endforeach
                                    </select>
                                    <small class="form-text text-muted">Hold Ctrl (Cmd on Mac) to select multiple.</small>
                                </div>
                            </div>



                            <div class="d-flex justify-content-end gap-2">
                                <button type="submit" class="btn btn-warning">
                                    <i class="fas fa-save me-2"></i>Update Movie
                                </button>
                                <a href="{{ route('admin.movies.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left me-2"></i>Back to Movies
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            @else
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-4 border-bottom">
                    <h1 class="h2 text-dark fw-bold">Manage Movies</h1>
                    <div class="d-flex gap-2">
                        <a href="{{ route('admin.movies.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus me-2"></i>Add New Movie
                        </a>
                        <div class="input-group shadow-sm" style="width: 300px;">
                            <input type="text" class="form-control" id="searchInput" placeholder="Search movies by title, mood...">
                            <button class="btn btn-outline-secondary" type="button" id="searchButton">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                </div>

                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                {{-- Movies Table --}}
                <div class="card shadow-lg border-0" id="movieList">
                    <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                        <h5 class="mb-0"><i class="fas fa-list me-2"></i> All Movie Entries</h5>
                        <div class="dropdown">
                            <button class="btn btn-sm btn-outline-light dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-sort me-1"></i> Sort By
                            </button>
                            <ul class="dropdown-menu dropdown-menu-dark">
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
                                <thead class="table-secondary sticky-header">
                                    <tr>
                                        <th style="width: 5%;"><i class=""></i> ID</th>
                                        <th style="width: 35%;"><i class=""></i> Title</th>
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
                    {{-- Pagination --}}
                    <div class="card-footer bg-light">
                        {{ $movies->links() }}
                    </div>
                </div>
            @endif
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

@if(!request()->routeIs('admin.movies.create') && !request()->routeIs('admin.movies.edit'))
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
@endif
@endsection