@extends('layouts.app')

@section('title', 'Discover Movies for Your Mood')

@section('content')
<!-- Hero Section -->
<section class="hero-section py-5 mb-5">
    <div class="container-fluid min-vh-100 d-flex justify-content-center align-items-center">
        <div class="col-lg-8">
            <div class="hero-content p-5 rounded shadow-lg text-center">
                <h1 class="display-3 fw-bold mb-5">Find the Perfect Movie for Your Mood</h1>
                <p class="lead fs-4 mb-5">
                    CineFeel analyzes your current emotions and recommends movies
                    that perfectly match how you're feeling right now. 🎬✨
                </p>
                @auth
                    <a href="{{ route('mood.selection') }}" class="btn btn-light btn-lg px-5 py-3 rounded-pill mt-4">
                        <i class="fas fa-smile me-2"></i> Get Recommendations
                    </a>
                @else
                    <a href="{{ route('login') }}" class="btn btn-light btn-lg px-5 py-3 rounded-pill mt-4">
                        <i class="fas fa-sign-in-alt me-2"></i> Login
                    </a>
                @endauth
            </div>
        </div>
    </div>
</section>

<div class="container">
    @if(session('message'))
        <div class="alert alert-{{ session('type', 'info') }} alert-dismissible fade show" role="alert">
            {{ session('message') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- How It Works Section -->
    <section class="mb-5">
        <h2 class="text-center mb-5">How CineFeel Works</h2>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm hover-effect">
                    <div class="card-body text-center p-4">
                        <div class="icon-circle bg-success text-white rounded-circle p-3 mb-3 mx-auto">
                            <i class="fas fa-sign-in-alt fs-4"></i>
                        </div>
                        <h4 class="mb-3">1. Login</h4>
                        <p class="text-muted mb-0">Login to access personalized movie recommendations.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm hover-effect">
                    <div class="card-body text-center p-4">
                        <div class="icon-circle bg-success text-white rounded-circle p-3 mb-3 mx-auto">
                            <i class="fas fa-smile-beam fs-4"></i>
                        </div>
                        <h4 class="mb-3">2. Select Your Mood</h4>
                        <p class="text-muted mb-0">Choose from various moods that match your current feeling.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm hover-effect">
                    <div class="card-body text-center p-4">
                        <div class="icon-circle bg-success text-white rounded-circle p-3 mb-3 mx-auto">
                            <i class="fas fa-film fs-4"></i>
                        </div>
                        <h4 class="mb-3">3. Get Recommendations</h4>
                        <p class="text-muted mb-0">Receive personalized movie suggestions based on your mood.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Featured Movies Section -->
    @if($featuredMovies->count() > 0)
    <section class="mb-5">
        <h2 class="text-center mb-5">Featured Movies</h2>
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            @foreach($featuredMovies as $movie)
            <div class="col">
                <div class="card h-100 movie-card">
                    <img src="{{ asset($movie->poster_path) }}" class="card-img-top" alt="{{ $movie->title }}">
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
    </section>
    @endif

    <!-- Testimonials Section -->
    <section class="mb-5">
        <h2 class="text-center mb-5">What Our Users Say</h2>
        <div class="row g-4">
            <div class="col-md-6">
                <div class="card h-100 border-0 shadow-sm bg-transparent text-white">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center mb-3">
                            <img src="{{ asset('assets/images/jck.jpg') }}" class="rounded-circle me-3" width="50" height="50" alt="User">
                            <div>
                                <h5 class="mb-0">Jerick Labasan</h5>
                                <div class="text-warning small">
                                    <i class="fas fa-star"></i><i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i><i class="fas fa-star"></i>
                                    <i class="fas fa-star-half-alt"></i>
                                </div>
                            </div>
                        </div>
                        <p class="mb-0">"No more endless scrolling. I get perfect recommendations in seconds."</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card h-100 border-0 shadow-sm bg-transparent text-white">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center mb-3">
                            <img src="{{ asset('assets/images/mau.jpg') }}" class="rounded-circle me-3" width="50" height="50" alt="User">
                            <div>
                                <h5 class="mb-0">Maureen Shaine</h5>
                                <div class="text-warning small">
                                    <i class="fas fa-star"></i><i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i><i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                </div>
                            </div>
                        </div>
                        <p class="mb-0">"The mood selection is so fun and accurate. Never watched so many great movies!"</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Call to Action -->
    <div class="text-center mt-5">
        <h2 class="mb-4">Ready to Find Your Perfect Movie Match?</h2>
        <p class="lead mb-4">Start exploring movies that fit your mood right now!</p>
        @auth
            <a href="{{ route('mood.selection') }}" class="btn btn-success btn-lg px-5 py-3 rounded-pill">
                <i class="fas fa-play me-2"></i> Get Started Now
            </a>
        @else
            <a href="{{ route('login') }}" class="btn btn-success btn-lg px-5 py-3 rounded-pill">
                <i class="fas fa-sign-in-alt me-2"></i> Login to Get Started
            </a>
        @endauth
    </div>
</div>
@endsection
