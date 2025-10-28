@extends('layouts.app')

@section('title', 'Login - CineFeel')

@section('content')
{{-- Applying CSS to match the light card, bright gradient theme --}}
<style>
    body {
        /* Set a vibrant gradient background for the whole page */
        background: linear-gradient(135deg, #00c6ff, #0072ff, #a945d8, #e73c7e);
        background-size: 400% 400%;
        animation: gradient-animation 15s ease infinite;
        color: #333; /* Dark text on light background */
    }

    @keyframes gradient-animation {
        0% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
        100% { background-position: 0% 50%; }
    }

    .login-container {
        min-height: 100vh;
    }

    .card {
        background-color: #ffffff; /* White card */
        border: none;
        border-radius: 20px; /* Highly rounded corners */
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2); /* Strong shadow */
        transition: transform 0.3s ease;
    }
    .card:hover {
        transform: translateY(-5px);
    }

    .form-label {
        font-weight: 600;
        color: #333;
    }

    .form-control {
        border-radius: 10px;
        border: 1px solid #ddd;
        padding: 10px 15px;
        background-color: #f9f9f9;
        color: #333;
        transition: border-color 0.3s;
    }
    .form-control:focus {
        border-color: #6c5ce7;
        box-shadow: 0 0 0 0.15rem rgba(108, 92, 231, 0.2);
        background-color: #fff;
    }

    /* Style for the main Login button with the blue-to-pink gradient */
    .btn-gradient {
        /* Matching the blue-to-pink gradient from the reference image */
        background: linear-gradient(90deg, #00c6ff 0%, #a945d8 100%);
        border: none;
        color: white;
        font-weight: bold;
        letter-spacing: 0.5px;
        border-radius: 10px;
        padding: 10px 0;
        transition: all 0.3s ease;
        text-transform: uppercase;
        font-size: 1.1rem;
    }
    .btn-gradient:hover {
        opacity: 0.9;
        transform: scale(1.02);
    }

    /* Social Buttons - Base Styling (Hidden for brand buttons) */
    .btn-social {
        border-radius: 10px;
        transition: all 0.2s ease;
        font-weight: 500;
        color: #333;
        border: 1px solid #ddd;
        background-color: #f7f7f7;
    }
    .btn-social:hover {
        background-color: #eee;
    }
    .btn-social .fab {
        font-size: 1.2rem;
    }
    
    /* FIX: Specific styling for Facebook button */
    .btn-facebook {
        background-color: #4267B2;
        color: white;
        border: none;
    }
    .btn-facebook:hover {
        background-color: #365899;
        color: white;
    }

    /* FIX: Specific styling for Google button */
    .btn-google {
        background-color: #db4437;
        color: white;
        border: none;
    }
    .btn-google:hover {
        background-color: #c33d32;
        color: white;
    }
    
    .btn-social-icon {
        padding: 10px 15px;
        flex-grow: 1; /* Make buttons expand if using d-flex */
    }

</style>

<div class="container-fluid login-container d-flex justify-content-center align-items-center">
    <div class="row w-100 justify-content-center">
        {{-- FIX: Increased width by changing grid classes (col-lg-4 -> col-lg-6, col-md-6 -> col-md-8) --}}
        <div class="col-sm-10 col-md-8 col-lg-6">
            <div class="card shadow-lg border-0">
                {{-- FIX: Reduced vertical padding from p-5 to p-4 --}}
                <div class="card-body p-4">
                    <div class="text-center mb-4">
                        <h2 class="fw-bold text-dark">Welcome Back</h2>
                        <p class="text-muted">Login to discover movies for your mood</p>
                    </div>

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Email/Password Login Form -->
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror"
                                   id="email" name="email" value="{{ old('email') }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror"
                                   id="password" name="password" required>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-grid mb-4">
                            <button type="submit" class="btn btn-gradient btn-lg">
                                <i class="fas fa-sign-in-alt me-2"></i>Login
                            </button>
                        </div>
                    </form>

                    <div class="text-center mb-4">
                        <span class="text-muted small">or continue using</span>
                    </div>

                    <!-- Social Login Buttons -->
                    <div class="d-grid gap-3 mb-4 d-md-flex justify-content-center">
                        {{-- FIX: Applying branded color classes and removing general icon styling --}}
                        <a href="{{ route('auth.facebook') }}" class="btn btn-social-icon btn-facebook d-flex align-items-center justify-content-center">
                            <i class="fab fa-facebook-f me-2"></i>
                            Facebook
                        </a>
                        <a href="{{ route('auth.google') }}" class="btn btn-social-icon btn-google d-flex align-items-center justify-content-center">
                            <i class="fab fa-google me-2"></i>
                            Google
                        </a>
                    </div>

                    <div class="text-center mt-4">
                        <p class="mb-0 text-muted small">Don't have an account?
                            <a href="{{ route('register') }}" class="text-primary text-decoration-none fw-bold">Register here</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
