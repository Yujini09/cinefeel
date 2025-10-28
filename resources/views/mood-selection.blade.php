@extends('layouts.app')

@section('title', 'Select Your Mood')

@section('content')
<style>
    /* Page styling */
    body {
        background: #f8f9fa;
    }

    h1, .lead {
        color: #333;
    }

    /* Mood grid */
    .mood-card {
        background: #fff;
        border: none;
        border-radius: 16px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        transition: all 0.25s ease-in-out;
        text-align: center;
        padding: 2rem 1rem;
        height: 100%;
    }

    .mood-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.12);
    }

    .mood-emoji {
        font-size: 3rem;
        display: block;
    }

    .mood-name {
        font-size: 1.25rem;
        font-weight: 600;
        color: #222;
        margin-top: 1rem;
    }

    .mood-desc {
        color: #777;
        font-size: 0.9rem;
        margin-top: 0.5rem;
    }

    .mood-form button {
        border: none;
        background: transparent;
        width: 100%;
        text-align: center;
    }

    .mood-form button:focus {
        outline: none;
        box-shadow: none;
    }
</style>

<div class="container py-5">
    <div class="text-center mb-5">
        <h1 class="fw-bold">How are you feeling today?</h1>
        <p class="lead">Choose your current mood and we’ll recommend movies that match your vibe 🎬</p>
    </div>

    <div class="row justify-content-center g-4">
        @foreach($moods as $mood)
            <div class="col-6 col-md-4 col-lg-3 d-flex">
                <form action="{{ route('recommendations') }}" method="POST" class="mood-form w-100">
                    @csrf
                    <input type="hidden" name="mood_id" value="{{ $mood->id }}">
                    <button type="submit">
                        <div class="mood-card">
                            <span class="mood-emoji">{{ $mood->icon }}</span>
                            <div class="mood-name">{{ $mood->name }}</div>
                            <div class="mood-desc">{{ $mood->description }}</div>
                        </div>
                    </button>
                </form>
            </div>
        @endforeach
    </div>
</div>
@endsection
