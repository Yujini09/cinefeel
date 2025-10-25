@extends('layouts.app')

@section('title', 'Select Your Mood')

@section('content')
<div class="text-center mb-5">
    <h1>How are you feeling today?</h1>
    <p class="lead">Select your current mood to get personalized movie recommendations</p>
</div>

<div class="row justify-content-center">
    @foreach($moods as $mood)
        <div class="col-6 col-md-4 col-lg-3 mb-4">
            <form action="{{ route('recommendations') }}" method="POST" class="mood-form">
                @csrf
                <input type="hidden" name="mood_id" value="{{ $mood->id }}">
                <button type="submit" class="btn btn-outline-primary mood-btn w-100 h-100 py-4">
                    <span class="emoji-display" style="font-size: 2.5rem;">{{ $mood->icon }}</span>
                    <h3 class="mt-2">{{ $mood->name }}</h3>
                    <p class="text-muted">{{ $mood->description }}</p>
                </button>
            </form>
        </div>
    @endforeach
</div>
@endsection
