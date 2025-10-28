@extends('layouts.app')

@section('title', "Movies for {$mood->name} Mood")

@section('content')
<div class="mb-4">
    <h1>Movies for your <span class="text-primary">{{ $mood->name }}</span> mood</h1>
    <p class="lead">{{ $mood->description }}</p>
    <div class="d-flex justify-content-between align-items-center">
        <a href="{{ route('mood.selection') }}" class="btn btn-outline-secondary">Choose a different mood</a>
        <!-- Search Bar -->
        <div class="input-group" style="width: 300px;">
            <input type="text" class="form-control" id="searchInput" placeholder="Search movies...">
            <button class="btn btn-outline-secondary" type="button" id="searchButton">
                <i class="fas fa-search"></i>
            </button>
        </div>
    </div>
</div>

@if($movies->isEmpty())
    <div class="alert alert-info">
        No movies found for this mood. Please check back later or try a different mood.
    </div>
@else
    @php
        function getYouTubeThumbnail($url) {
            if (!$url) return null;
            parse_str(parse_url($url, PHP_URL_QUERY), $params);
            return isset($params['v']) ? "https://img.youtube.com/vi/{$params['v']}/maxresdefault.jpg" : null;
        }
    @endphp
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 row-cols-xl-4 g-4" id="moviesContainer">
        @foreach($movies as $movie)
            <div class="col movie-item">
                <div class="card h-100 movie-card">
                    @php
                        $posterImage = getYouTubeThumbnail($movie->trailer_url) ?? asset($movie->poster_path);
                        $fallbackImage = asset('assets/images/logo.jpg');
                    @endphp
                    <img src="{{ $posterImage }}" class="card-img-top" alt="{{ $movie->title }}" onerror="this.onerror=null; this.src='{{ $fallbackImage }}';">
                    <div class="card-body">
                        <h5 class="card-title">{{ $movie->title }}</h5>
                        <p class="card-text text-muted">
                            @if($movie->genres->count() > 0)
                                {{ $movie->genres->pluck('name')->join(', ') }} •
                            @endif
                            {{ $movie->release_year }}
                        </p>
                        <p class="card-text">{{ Str::limit($movie->description, 100) }}</p>
                    </div>
                    <div class="card-footer bg-white">
                        <div class="d-flex justify-content-between align-items-center">
                            @if($movie->trailer_url)
                            <a href="{{ $movie->trailer_url }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                <i class="fas fa-play"></i> Trailer
                            </a>
                            @endif
                            <small class="text-muted">⭐ {{ $movie->rating }}/10</small>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endif

@push('scripts')
<script>
document.getElementById('searchInput').addEventListener('keyup', function() {
    const searchTerm = this.value.toLowerCase();
    const container = document.getElementById('moviesContainer');
    const movieItems = container.getElementsByClassName('movie-item');

    for (let i = 0; i < movieItems.length; i++) {
        const title = movieItems[i].querySelector('.card-title').textContent.toLowerCase();
        const description = movieItems[i].querySelector('.card-text').textContent.toLowerCase();
        const genres = movieItems[i].querySelector('.text-muted').textContent.toLowerCase();

        if (title.includes(searchTerm) || description.includes(searchTerm) || genres.includes(searchTerm)) {
            movieItems[i].style.display = '';
        } else {
            movieItems[i].style.display = 'none';
        }
    }
});

document.getElementById('searchButton').addEventListener('click', function() {
    document.getElementById('searchInput').focus();
});
</script>
@endpush
@endsection
