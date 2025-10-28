@extends('layouts.app')

@section('title', 'Discover Movies for Your Mood')

@section('content')

@section('content')

{{-- ------------------------------------------------------------------------------------------------ --}}
{{-- START: TOAST CONTAINER FOR FLASH MESSAGES (Centered Horizontally)                                --}}
{{-- ------------------------------------------------------------------------------------------------ --}}
@php
    $message = session('success') ?? session('deleted');
    $status_type = session('success') ? 'success' : (session('deleted') ? 'deleted' : null);
    
    // Determine the Bootstrap classes based on the message type
    $bg_class = $status_type === 'success' ? 'bg-success' : ($status_type === 'deleted' ? 'bg-danger' : 'bg-secondary');
    $icon_class = $status_type === 'success' ? 'fas fa-check-circle' : ($status_type === 'deleted' ? 'fas fa-trash-alt' : 'fas fa-info-circle');
    $header_text = $status_type === 'success' ? 'Success!' : ($status_type === 'deleted' ? 'Deleted!' : 'Notice');
@endphp

@if ($message)
{{-- The styles below center the container: top-0, start-50, and translate-middle-x --}}
<div aria-live="polite" aria-atomic="true" class="position-fixed top-0 start-50 translate-middle-x p-3" style="z-index: 1050; min-width: 350px;">
    <div class="toast {{ $bg_class }} text-white border-0" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="5000">
        <div class="toast-header {{ $bg_class }} text-white border-0">
            <i class="{{ $icon_class }} me-2"></i>
            <strong class="me-auto">{{ $header_text }}</strong>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body">
            {{ $message }}
        </div>
    </div>
</div>
@endif
{{-- ------------------------------------------------------------------------------------------------ --}}
{{-- END: TOAST CONTAINER                                                                             --}}
{{-- ------------------------------------------------------------------------------------------------ --}}

<style>
/* --- Minimal aesthetic theme --- */
.hero-section {
    background: linear-gradient(135deg, #4b0082, #000000);
    color: #f8f9fa;
    border-radius: 20px;
}
.hero-section h1 {
    font-weight: 700;
    letter-spacing: 1px;
}
.hero-section p {
    color: #f8f9fa;
}
.hero-section .btn {
    transition: 0.3s;
}
.hero-section .btn:hover {
    background-color: #198754;
    color: #fff;
}

/* Cards & icons */
.card {
    background: linear-gradient(135deg, #4b0082, #000000) !important;
    border-radius: 16px;
    color: #f8f9fa;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}
.card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 20px rgba(0,0,0,0.2);
}
.icon-circle {
    width: 70px;
    height: 70px;
    display: flex;
    align-items: center;
    justify-content: center;
    background-color: #4b0082 !important;
    color: #ffffff;
}

/* Section titles */
section h2 {
    font-weight: 600;
    color: #2c2c2c;
}

/* Testimonials */
.card.bg-dark {
    background: #1f1f1f !important;
    border: 1px solid #2c2c2c;
}
.text-white-50 {
    color: #b3b3b3 !important;
}

/* Featured Movies */
.movie-card img {
    border-radius: 12px 12px 0 0;
    object-fit: cover;
    height: 380px;
}
.movie-card h5 {
    font-weight: 600;
    color: #fff;
}
.movie-card .card-text {
    color: #bfbfbf;
}

/* Call to Action */
.cta-section {
    background: linear-gradient(135deg, #4b0082, #000000);
    color: #fff;
    border-radius: 16px;
    padding: 60px 30px;
}
.cta-section .btn {
    transition: 0.3s;
}
.cta-section .btn:hover {
    background-color: #198754;
    color: #fff;
}
</style>

<!-- Hero Section -->
<section class="hero-section py-5 mb-5">
    <div class="container text-center py-5">
        <h1 class="display-4 mb-4">Find the Perfect Movie for Your Mood 🎬</h1>
        <p class="lead mb-4">
            CineFeel recommends movies that resonate with your emotions. Let your mood guide your next watch.
        </p>
        <div class="d-flex justify-content-center">
            @if(Auth::check())
                <a href="{{ route('mood.selection') }}" class="btn btn-light btn-lg px-4 py-2 rounded-pill">
                    <i class="fas fa-smile me-2"></i> Get Recommendations
                </a>
            @else
                <a href="{{ route('login') }}" class="btn btn-light btn-lg px-4 py-2 rounded-pill">
                    <i class="fas fa-smile me-2"></i> Get Recommendations
                </a>
            @endif
        </div>
    </div>
</section>
    </div>
</section>

<!-- How It Works Section -->
<section class="mb-5">
    <h2 class="text-center mb-5">How It Works</h2>
    <div class="row g-4 text-center">
        <div class="col-md-4">
            <div class="card text-light h-100 p-4">
                <div class="icon-circle mb-3 rounded-circle mx-auto text-white">
                    <i class="fas fa-sign-in-alt fs-4"></i>
                </div>
                <h5>1. Access Anytime</h5>
                <p class="">Access personalized movie recommendations.</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-light h-100 p-4">
                <div class="icon-circle mb-3 rounded-circle mx-auto text-white">
                    <i class="fas fa-smile-beam fs-4"></i>
                </div>
                <h5>2. Select Your Mood</h5>
                <p class="">Pick a mood that matches how you feel.</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-light h-100 p-4">
                <div class="icon-circle mb-3 rounded-circle mx-auto text-white">
                    <i class="fas fa-film fs-4"></i>
                </div>
                <h5>3. Get Recommendations</h5>
                <p class="">See movies that match your mood instantly.</p>
            </div>
        </div>
    </div>
</section>

<!-- Featured Movies Section -->
@if($featuredMovies->count() > 0)
<section id="featured-movies-section" class="mb-5">
    <h2 class="text-center mb-5">Featured Movies</h2>
    @php
        function getYouTubeThumbnail($url) {
            if (!$url) return null;
            parse_str(parse_url($url, PHP_URL_QUERY), $params);
            return isset($params['v']) ? "https://img.youtube.com/vi/{$params['v']}/maxresdefault.jpg" : null;
        }
    @endphp
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
        @foreach($featuredMovies as $movie)
        <div class="col">
            <div class="card bg-dark text-light movie-card h-100 border-0">
                @php
                    $posterImage = getYouTubeThumbnail($movie->trailer_url) ?? asset($movie->poster_path);
                    $fallbackImage = asset('/assets/images/shawshank.jpg');
                @endphp
                <img src="{{ $posterImage }}" alt="{{ $movie->title }}" onerror="this.onerror=null; this.src='{{ $fallbackImage }}';">
                <div class="card-body">
                    <h5>{{ $movie->title }}</h5>
                    <p class="">
                        @if($movie->genres->count() > 0)
                            {{ $movie->genres->pluck('name')->join(', ') }} •
                        @endif
                        {{ $movie->release_year }}
                    </p>
                    <p>{{ Str::limit($movie->description, 100) }}</p>
                </div>
                <div class="card-footer bg-transparent border-0 d-flex justify-content-between align-items-center">
                    @if($movie->trailer_url)
                    <a href="{{ $movie->trailer_url }}" target="_blank" class="btn btn-sm btn-outline-success">
                        <i class="fas fa-play"></i> Trailer
                    </a>
                    @endif
                    <small class="text-white-50">⭐ {{ $movie->rating }}/10</small>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</section>
@endif

<!-- Call to Action -->
<section class="cta-section text-center mt-5">
    <h2 class="text-white">Ready to Find Your Movie Match?</h2>
    <p class="lead mb-4">Discover films that fit your mood in seconds.</p>
        @if(Auth::check())
            <a href="{{ route('mood.selection') }}" class="btn btn-light btn-lg rounded-pill px-5">
                <i class="fas fa-play me-2"></i> Get Started
            </a>
        @else
            <a href="{{ route('login') }}" class="btn btn-light btn-lg rounded-pill px-5">
                <i class="fas fa-play me-2"></i> Get Started
            </a>
        @endif
</section>

<!-- Testimonials Section -->
<section class="my-5">
    <h2 class="text-center mb-5">What Users Say</h2>
    <div class="row g-4 justify-content-center">

    {{-- START: DYNAMIC REVIEWS LOOP --}}
    @foreach($reviews as $review)
    <div class="col-lg-4 col-md-6">
        <div class="card bg-dark text-light h-100 d-flex flex-column p-4">
            
            {{-- Card Body Content (Reviewer Info) --}}
            <div class="flex-grow-1">
                <div class="d-flex align-items-center mb-3">
                    <img src="{{ asset('images/logo.jpg') }}" class="rounded-circle me-3" width="50" height="50" alt="Reviewer Avatar">
                    <div>
                        <h6 class="mb-0">{{ $review->reviewer_name }}</h6>
                        <div class="text-warning small">
                            {{-- DISPLAY STAR RATING --}}
                            @for ($i = 1; $i <= 5; $i++)
                                @if ($i <= $review->rating)
                                    <i class="fas fa-star"></i>
                                @else
                                    <i class="far fa-star"></i>
                                @endif
                            @endfor
                        </div>
                    </div>
                </div>
                {{-- DISPLAY REVIEW TEXT --}}
                <p class="text-white-50">"{{ $review->review_text }}"</p>
            </div>
            
            {{-- DELETE BUTTON REMOVED: Now only admins can delete reviews from admin panel --}}
            
        </div>
    </div>
    @endforeach
    {{-- END: DYNAMIC REVIEWS LOOP --}}

    {{-- The Review Submission Form will follow here --}}
    <div class="col-12 mt-4"> 
        {{-- ... form code ... --}}
    </div>
</div>

</section>

<section class="mb-5">

    {{-- NEW: Write a Review Form --}}
    @if(Auth::check())
        {{-- We use col-12 and wrap the card in a row to allow for centered positioning and a wider width --}}
        <div class="col-12 mt-4">
            <div class="row justify-content-center">
                <div class="col-lg-6 col-md-8 col-sm-10"> {{-- Control the max width here --}}
                    <div class="card review-form-card text-light p-4">
                        <h5 class="mb-3 text-center text-white">Share Your Experience 👋</h5>

                        <form action="/submit-review" method="POST">
                            @csrf {{-- Laravel CSRF protection --}}

                            <div class="mb-3">
                                <label for="reviewer_name" class="form-label small text-white-50">Your Name</label>
                                <input type="text" class="form-control bg-dark text-white border-secondary" id="reviewer_name" name="reviewer_name" value="{{ Auth::user()->name ?? '' }}" required>
                            </div>

                            <div class="mb-3">
                                <label for="rating" class="form-label small text-white-50">Rating</label>
                                <select class="form-select bg-dark text-white border-secondary" id="rating" name="rating" required>
                                    <option value="5" selected>⭐⭐⭐⭐⭐ Amazing</option>
                                    <option value="4">⭐⭐⭐⭐ Great</option>
                                    <option value="3">⭐⭐⭐ Good</option>
                                    <option value="2">⭐⭐ Fair</option>
                                    <option value="1">⭐ Poor</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="review_text" class="form-label small text-white-50">Your Review</label>
                                <textarea class="form-control bg-dark text-white border-secondary" id="review_text" name="review_text" rows="3" required></textarea>
                            </div>

                            <button type="submit" class="btn btn-success w-100 mt-2">
                                <i class="fas fa-paper-plane me-2"></i> Submit Review
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @else
        {{-- Show login prompt for non-authenticated users --}}
        <div class="col-12 mt-4">
            <div class="row justify-content-center">
                <div class="col-lg-6 col-md-8 col-sm-10">
                    <div class="card review-form-card text-light p-4 text-center">
                        <h5 class="mb-3 text-white">Want to Share Your Experience? 👋</h5>
                        <p class="text-white-50 mb-3">Please log in to submit a review.</p>
                        <a href="{{ route('login') }}" class="btn btn-success">
                            <i class="fas fa-sign-in-alt me-2"></i> Login to Review
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @endif
    </div>
</section>

{{-- ----------------------------------------------------------- --}}
{{-- START: JAVASCRIPT TO SHOW TOAST --}}
{{-- ----------------------------------------------------------- --}}
@if (session('success') || session('deleted'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Find the single toast element
        const toastEl = document.querySelector('.toast');
        
        // If the element exists and Bootstrap JS is available (assumes Bootstrap 5)
        if (toastEl && typeof bootstrap !== 'undefined' && bootstrap.Toast) {
            const toast = new bootstrap.Toast(toastEl);
            toast.show();
        }
    });
</script>
@endif
{{-- ----------------------------------------------------------- --}}
{{-- END: JAVASCRIPT TO SHOW TOAST --}}
{{-- ----------------------------------------------------------- --}}
@endsection
