@extends('layouts.app')

@section('title', 'Manage Movies')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
@endpush
@push('scripts')
    <script src="{{ asset('js/admin.js') }}"></script>
@endpush

@php
    $isAdminPage = true;
@endphp

<div class="admin-container">
    <div class="card shadow-sm mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h2 class="h5 m-0">Manage Movies</h2>
            <button class="btn btn-main" data-bs-toggle="modal" data-bs-target="#addMovieModal">
                <i class="fas fa-plus me-1"></i> Add New Movie
            </button>
        </div>
        <div class="card-body">
            <div id="messageContainer"></div>

            <div class="table-responsive">
                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th>Poster</th>
                            <th>Title</th>
                            <th>Genre</th>
                            <th>Mood</th>
                            <th>Year</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($movies as $movie)
                        <tr id="movie-{{ $movie->movie_id }}">
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
                            <td>
                                <span class="badge bg-danger">
                                    {{ optional($movie->genres->first())->genre_name ?? 'Unknown' }}
                                </span>
                            </td>
                            <td>
                                <span class="badge bg-info">
                                    {{ optional($movie->mood)->mood_name ?? 'None' }}
                                </span>
                            </td>
                            <td>
                                <span class="badge bg-dark">{{ $movie->release_year ?? 'N/A' }}</span>
                            </td>
                            <td>
                                <button class="btn btn-sm btn-outline-primary edit-movie"
                                        data-bs-toggle="modal" data-bs-target="#editMovieModal"
                                        data-movie-id="{{ $movie->movie_id }}"
                                        data-title="{{ $movie->title }}"
                                        data-genre="{{ optional($movie->genres->first())->genre_name ?? '' }}"
                                        data-mood-id="{{ $movie->mood_id ?? '' }}"
                                        data-description="{{ $movie->description }}"
                                        data-poster-url="{{ $movie->poster_url }}"
                                        data-trailer-link="{{ $movie->trailer_link }}"
                                        data-release-year="{{ $movie->release_year }}"
                                        data-duration="{{ $movie->duration }}">
                                    <i class="fas fa-edit"></i> Edit
                                </button>

                                <form class="d-inline delete-movie-form">
                                    @csrf
                                    @method('DELETE') {{-- Use DELETE method for RESTful API --}}
                                    <input type="hidden" name="movie_id" value="{{ $movie->movie_id }}">
                                    <button type="submit" name="delete_movie" class="btn btn-sm btn-outline-danger">
                                        <i class="fas fa-trash"></i> Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


{{-- Add Movie Modal --}}
<div class="modal fade" id="addMovieModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="addMovieForm">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Add New Movie</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="title" class="form-label">Title *</label>
                                <input type="text" class="form-control" id="title" name="title" required>
                            </div>
                            <div class="mb-3">
                                <label for="genre" class="form-label">Genre *</label>
                                <input type="text" class="form-control" id="genre" name="genre" list="genres" required>
                                <datalist id="genres">
                                    @foreach ($genres as $genre)
                                        <option value="{{ $genre->genre_name }}">
                                    @endforeach
                                </datalist>
                            </div>
                            <div class="mb-3">
                                <label for="mood_id" class="form-label">Mood</label>
                                <select class="form-select" id="mood_id" name="mood_id">
                                    <option value="">Select Mood (Optional)</option>
                                    @foreach ($moods as $mood)
                                        <option value="{{ $mood->mood_id }}">
                                            {{ $mood->mood_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="release_year" class="form-label">Release Year *</label>
                                <input type="number" class="form-control" id="release_year" name="release_year"
                                    min="1900" max="{{ date('Y') + 5 }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="duration" class="form-label">Duration</label>
                                <input type="text" class="form-control" id="duration" name="duration"
                                    placeholder="e.g., 2h 15m">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="poster_url" class="form-label">Poster URL</label>
                                <input type="url" class="form-control" id="poster_url" name="poster_url">
                                <div class="form-text">Leave blank to use default poster</div>
                            </div>
                            <div class="mb-3">
                                <label for="trailer_link" class="form-label">Trailer Link</label>
                                <input type="url" class="form-control" id="trailer_link" name="trailer_link">
                            </div>
                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control" id="description" name="description" rows="5"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Add Movie</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Edit Movie Modal --}}
<div class="modal fade" id="editMovieModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="editMovieForm">
                @csrf
                @method('PUT') {{-- Use PUT method for RESTful API --}}
                <input type="hidden" name="movie_id" id="edit_movie_id">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Movie</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="edit_title" class="form-label">Title *</label>
                                <input type="text" class="form-control" id="edit_title" name="title" required>
                            </div>
                            <div class="mb-3">
                                <label for="edit_genre" class="form-label">Genre *</label>
                                <input type="text" class="form-control" id="edit_genre" name="genre" list="genres" required>
                            </div>
                            <div class="mb-3">
                                <label for="edit_mood_id" class="form-label">Mood</label>
                                <select class="form-select" id="edit_mood_id" name="mood_id">
                                    <option value="">Select Mood (Optional)</option>
                                    @foreach ($moods as $mood)
                                        <option value="{{ $mood->mood_id }}">
                                            {{ $mood->mood_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="edit_release_year" class="form-label">Release Year *</label>
                                <input type="number" class="form-control" id="edit_release_year" name="release_year"
                                    min="1900" max="{{ date('Y') + 5 }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="edit_duration" class="form-label">Duration</label>
                                <input type="text" class="form-control" id="edit_duration" name="duration">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="edit_poster_url" class="form-label">Poster URL</label>
                                <input type="url" class="form-control" id="edit_poster_url" name="poster_url">
                            </div>
                            <div class="mb-3">
                                <label for="edit_trailer_link" class="form-label">Trailer Link</label>
                                <input type="url" class="form-control" id="edit_trailer_link" name="trailer_link">
                            </div>
                            <div class="mb-3">
                                <label for="edit_description" class="form-label">Description</label>
                                <textarea class="form-control" id="edit_description" name="description" rows="5"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update Movie</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
