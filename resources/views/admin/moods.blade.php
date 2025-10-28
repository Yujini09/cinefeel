@extends('layouts.admin')

@section('content')
<div class="container-fluid p-0">

    <header class="admin-header">
        <div class="d-flex justify-content-between align-items-center h-100 px-4">
            <div class="h5 mb-0 fw-bold">
                <i class="fas fa-film me-2 text-primary"></i> CineFeel Admin Panel
            </div>
            <div class="text-white">
                Welcome, *{{ auth()->user()->name ?? 'Admin' }}*
            </div>
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
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.movies.index') }}">
                            <i class="fas fa-film me-2"></i> Manage Movies
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('admin.moods.index') }}">
                            <i class="fas fa-smile me-2"></i> Manage Moods
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

            {{-- ================================================================= --}}
            {{-- CONDITIONAL CONTENT: EDIT FORM (@isset($mood) && !isset($is_creating)) --}}
            {{-- This displays the form for editing an existing mood --}}
            {{-- ================================================================= --}}
            @isset($mood)
                @if (!isset($is_creating) || $is_creating !== true) {{-- Check if $is_creating is NOT set or not true --}}
                    <div class="pt-3 pb-2 mb-4 border-bottom">
                        <h1 class="h2 text-dark fw-bold">Edit Mood</h1>
                    </div>

                    @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
                            <strong>Whoops!</strong> There were some problems with your input.<br><br>
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <div class="row justify-content-center">
                        <div class="col-lg-8">
                            <div class="card shadow-lg border-0">
                                <div class="card-header bg-warning text-dark">
                                    <h5 class="mb-0"><i class="fas fa-edit me-2"></i>Edit Mood: {{ $mood->name }}</h5>
                                </div>
                                <div class="card-body p-4">
                                    <form action="{{ route('admin.moods.update', $mood->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')

                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label for="name" class="form-label fw-bold">Mood Name <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $mood->name) }}" required>
                                                @error('name')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <label for="slug" class="form-label fw-bold">Slug <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control @error('slug') is-invalid @enderror" id="slug" name="slug" value="{{ old('slug', $mood->slug) }}" required>
                                                @error('slug')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                                <small class="text-muted">URL-friendly version of the name</small>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label for="icon" class="form-label fw-bold">Emoji/Icon</label>
                                                {{-- The emoji select field is complex, I will only include it once in the Edit/Create section to avoid duplication --}}
                                                <select class="form-select emoji-select @error('icon') is-invalid @enderror" id="icon" name="icon">
                                                    <option value="">Select Emoji</option>
                                                    <optgroup label="Happy Moods">
                                                        <option value="😊" {{ old('icon', $mood->icon) == '😊' ? 'selected' : '' }}>😊 Smiling</option>
                                                        <option value="😂" {{ old('icon', $mood->icon) == '😂' ? 'selected' : '' }}>😂 Laughing</option>
                                                        <option value="🤣" {{ old('icon', $mood->icon) == '🤣' ? 'selected' : '' }}>🤣 ROFL</option>
                                                        <option value="😄" {{ old('icon', $mood->icon) == '😄' ? 'selected' : '' }}>😄 Grinning</option>
                                                        <option value="😁" {{ old('icon', $mood->icon) == '😁' ? 'selected' : '' }}>😁 Beaming</option>
                                                        <option value="😃" {{ old('icon', $mood->icon) == '😃' ? 'selected' : '' }}>😃 Smiley</option>
                                                        <option value="😍" {{ old('icon', $mood->icon) == '😍' ? 'selected' : '' }}>😍 Loving</option>
                                                        <option value="🥰" {{ old('icon', $mood->icon) == '🥰' ? 'selected' : '' }}>🥰 Adoring</option>
                                                        <option value="😎" {{ old('icon', $mood->icon) == '😎' ? 'selected' : '' }}>😎 Cool</option>
                                                        <option value="🤩" {{ old('icon', $mood->icon) == '🤩' ? 'selected' : '' }}>🤩 Starstruck</option>
                                                    </optgroup>
                                                    <optgroup label="Chill Moods">
                                                        <option value="😌" {{ old('icon', $mood->icon) == '😌' ? 'selected' : '' }}>😌 Relaxed</option>
                                                        <option value="😴" {{ old('icon', $mood->icon) == '😴' ? 'selected' : '' }}>😴 Sleepy</option>
                                                        <option value="🧘" {{ old('icon', $mood->icon) == '🧘' ? 'selected' : '' }}>🧘 Meditating</option>
                                                        <option value="🍃" {{ old('icon', $mood->icon) == '🍃' ? 'selected' : '' }}>🍃 Leaf</option>
                                                        <option value="🌊" {{ old('icon', $mood->icon) == '🌊' ? 'selected' : '' }}>🌊 Ocean</option>
                                                        <option value="🛀" {{ old('icon', $mood->icon) == '🛀' ? 'selected' : '' }}>🛀 Bath</option>
                                                        <option value="🌅" {{ old('icon', $mood->icon) == '🌅' ? 'selected' : '' }}>🌅 Sunrise</option>
                                                        <option value="🎧" {{ old('icon', $mood->icon) == '🎧' ? 'selected' : '' }}>🎧 Headphones</option>
                                                    </optgroup>
                                                    <optgroup label="Adventurous">
                                                        <option value="🏔️" {{ old('icon', $mood->icon) == '🏔️' ? 'selected' : '' }}>🏔️ Mountain</option>
                                                        <option value="🚀" {{ old('icon', $mood->icon) == '🚀' ? 'selected' : '' }}>🚀 Rocket</option>
                                                        <option value="🏄" {{ old('icon', $mood->icon) == '🏄' ? 'selected' : '' }}>🏄 Surfing</option>
                                                        <option value="🧗" {{ old('icon', $mood->icon) == '🧗' ? 'selected' : '' }}>🧗 Climbing</option>
                                                        <option value="🚴" {{ old('icon', $mood->icon) == '🚴' ? 'selected' : '' }}>🚴 Biking</option>
                                                        <option value="🌋" {{ old('icon', $mood->icon) == '🌋' ? 'selected' : '' }}>🌋 Volcano</option>
                                                        <option value="🏜️" {{ old('icon', $mood->icon) == '🏜️' ? 'selected' : '' }}>🏜️ Desert</option>
                                                    </optgroup>
                                                    <optgroup label="Romantic">
                                                        <option value="💕" {{ old('icon', $mood->icon) == '💕' ? 'selected' : '' }}>💕 Hearts</option>
                                                        <option value="💖" {{ old('icon', $mood->icon) == '💖' ? 'selected' : '' }}>💖 Sparkling Heart</option>
                                                        <option value="💘" {{ old('icon', $mood->icon) == '💘' ? 'selected' : '' }}>💘 Heart Arrow</option>
                                                        <option value="🌹" {{ old('icon', $mood->icon) == '🌹' ? 'selected' : '' }}>🌹 Rose</option>
                                                        <option value="💑" {{ old('icon', $mood->icon) == '💑' ? 'selected' : '' }}>💑 Couple</option>
                                                        <option value="💞" {{ old('icon', $mood->icon) == '💞' ? 'selected' : '' }}>💞 Revolving Hearts</option>
                                                    </optgroup>
                                                    <optgroup label="Sad / Thoughtful">
                                                        <option value="😔" {{ old('icon', $mood->icon) == '😔' ? 'selected' : '' }}>😔 Pensive</option>
                                                        <option value="😢" {{ old('icon', $mood->icon) == '😢' ? 'selected' : '' }}>😢 Crying</option>
                                                        <option value="😭" {{ old('icon', $mood->icon) == '😭' ? 'selected' : '' }}>😭 Sob</option>
                                                        <option value="🤔" {{ old('icon', $mood->icon) == '🤔' ? 'selected' : '' }}>🤔 Thinking</option>
                                                        <option value="😕" {{ old('icon', $mood->icon) == '😕' ? 'selected' : '' }}>😕 Confused</option>
                                                        <option value="🌧️" {{ old('icon', $mood->icon) == '🌧️' ? 'selected' : '' }}>🌧️ Rain Cloud</option>
                                                        <option value="☔" {{ old('icon', $mood->icon) == '☔' ? 'selected' : '' }}>☔ Umbrella</option>
                                                    </optgroup>
                                                    <optgroup label="Energetic / Party">
                                                        <option value="🥳" {{ old('icon', $mood->icon) == '🥳' ? 'selected' : '' }}>🥳 Celebrating</option>
                                                        <option value="🎉" {{ old('icon', $mood->icon) == '🎉' ? 'selected' : '' }}>🎉 Party Popper</option>
                                                        <option value="🎊" {{ old('icon', $mood->icon) == '🎊' ? 'selected' : '' }}>🎊 Confetti</option>
                                                        <option value="🍾" {{ old('icon', $mood->icon) == '🍾' ? 'selected' : '' }}>🍾 Champagne</option>
                                                        <option value="💃" {{ old('icon', $mood->icon) == '💃' ? 'selected' : '' }}>💃 Dance</option>
                                                        <option value="🕺" {{ old('icon', $mood->icon) == '🕺' ? 'selected' : '' }}>🕺 Disco Dance</option>
                                                        <option value="🔥" {{ old('icon', $mood->icon) == '🔥' ? 'selected' : '' }}>🔥 Fire</option>
                                                    </optgroup>
                                                    <optgroup label="Dreamy / Magical">
                                                        <option value="🌌" {{ old('icon', $mood->icon) == '🌌' ? 'selected' : '' }}>🌌 Galaxy</option>
                                                        <option value="🌠" {{ old('icon', $mood->icon) == '🌠' ? 'selected' : '' }}>🌠 Shooting Star</option>
                                                        <option value="🪐" {{ old('icon', $mood->icon) == '🪐' ? 'selected' : '' }}>🪐 Saturn</option>
                                                        <option value="✨" {{ old('icon', $mood->icon) == '✨' ? 'selected' : '' }}>✨ Sparkles</option>
                                                        <option value="🧚" {{ old('icon', $mood->icon) == '🧚' ? 'selected' : '' }}>🧚 Fairy</option>
                                                        <option value="🦄" {{ old('icon', $mood->icon) == '🦄' ? 'selected' : '' }}>🦄 Unicorn</option>
                                                    </optgroup>
                                                    <optgroup label="Dark / Mysterious">
                                                        <option value="🌑" {{ old('icon', $mood->icon) == '🌑' ? 'selected' : '' }}>🌑 New Moon</option>
                                                        <option value="🦇" {{ old('icon', $mood->icon) == '🦇' ? 'selected' : '' }}>🦇 Bat</option>
                                                        <option value="🕸️" {{ old('icon', $mood->icon) == '🕸️' ? 'selected' : '' }}>🕸️ Web</option>
                                                        <option value="🕷️" {{ old('icon', $mood->icon) == '🕷️' ? 'selected' : '' }}>🕷️ Spider</option>
                                                        <option value="👻" {{ old('icon', $mood->icon) == '👻' ? 'selected' : '' }}>👻 Ghost</option>
                                                        <option value="😈" {{ old('icon', $mood->icon) == '😈' ? 'selected' : '' }}>😈 Devilish</option>
                                                    </optgroup>
                                                </select>
                                                @error('icon')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                                <small class="text-muted">Select from popular mood emojis</small>
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <label for="mapped_genre" class="form-label fw-bold">Mapped Genre</label>
                                                <select class="form-select @error('mapped_genre') is-invalid @enderror" id="mapped_genre" name="mapped_genre">
                                                    <option value="">Select Genre</option>
                                                    @if(isset($genres))
                                                        @foreach($genres as $genre)
                                                            <option value="{{ $genre->name }}" {{ old('mapped_genre', $mood->mapped_genre) == $genre->name ? 'selected' : '' }}>
                                                                {{ $genre->name }}
                                                            </option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                                @error('mapped_genre')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                                <small class="text-muted">Genre this mood maps to (e.g., Action, Comedy)</small>
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label for="description" class="form-label fw-bold">Description</label>
                                            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="4">{{ old('description', $mood->description) }}</textarea>
                                            @error('description')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <small class="text-muted">Describe what this mood represents</small>
                                        </div>

                                        <div class="d-flex justify-content-end gap-2">
                                            <button type="submit" class="btn btn-warning">
                                                <i class="fas fa-save me-2"></i>Update Mood
                                            </button>
                                            <a href="{{ route('admin.moods.index') }}" class="btn btn-secondary">
                                                <i class="fas fa-arrow-left me-2"></i>Back to Moods
                                            </a>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            @endisset


            {{-- ================================================================= --}}
            {{-- CONDITIONAL CONTENT: CREATE FORM (@isset($is_creating) && $is_creating === true) --}}
            {{-- This displays the form for creating a new mood (assuming you pass a variable like $is_creating = true from your controller) --}}
            {{-- ================================================================= --}}
            @isset($is_creating)
                @if ($is_creating === true)
                    <div class="pt-3 pb-2 mb-4 border-bottom">
                        <h1 class="h2 text-dark fw-bold">Create New Mood</h1>
                    </div>

                    @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
                            <strong>Whoops!</strong> There were some problems with your input.<br><br>
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <div class="row justify-content-center">
                        <div class="col-lg-8">
                            <div class="card shadow-lg border-0">
                                <div class="card-header bg-primary text-white">
                                    <h5 class="mb-0"><i class="fas fa-plus-circle me-2"></i>Add a New Mood</h5>
                                </div>
                                <div class="card-body p-4">
                                    <form action="{{ route('admin.moods.store') }}" method="POST">
                                        @csrf

                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label for="name" class="form-label fw-bold">Mood Name <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name_create" name="name" value="{{ old('name') }}" required>
                                                @error('name')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <label for="slug" class="form-label fw-bold">Slug <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control @error('slug') is-invalid @enderror" id="slug_create" name="slug" value="{{ old('slug') }}" required>
                                                @error('slug')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                                <small class="text-muted">URL-friendly version of the name</small>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label for="icon" class="form-label fw-bold">Emoji/Icon</label>
                                                {{-- Using the same extensive select options as the edit form --}}
                                                <select class="form-select emoji-select @error('icon') is-invalid @enderror" id="icon_create" name="icon">
                                                    <option value="">Select Emoji</option>
                                                    <optgroup label="Happy Moods">
                                                        <option value="😊" {{ old('icon') == '😊' ? 'selected' : '' }}>😊 Smiling</option>
                                                        <option value="😂" {{ old('icon') == '😂' ? 'selected' : '' }}>😂 Laughing</option>
                                                        <option value="🤣" {{ old('icon') == '🤣' ? 'selected' : '' }}>🤣 ROFL</option>
                                                        <option value="😄" {{ old('icon') == '😄' ? 'selected' : '' }}>😄 Grinning</option>
                                                        <option value="😁" {{ old('icon') == '😁' ? 'selected' : '' }}>😁 Beaming</option>
                                                        <option value="😃" {{ old('icon') == '😃' ? 'selected' : '' }}>😃 Smiley</option>
                                                        <option value="😍" {{ old('icon') == '😍' ? 'selected' : '' }}>😍 Loving</option>
                                                        <option value="🥰" {{ old('icon') == '🥰' ? 'selected' : '' }}>🥰 Adoring</option>
                                                        <option value="😎" {{ old('icon') == '😎' ? 'selected' : '' }}>😎 Cool</option>
                                                        <option value="🤩" {{ old('icon') == '🤩' ? 'selected' : '' }}>🤩 Starstruck</option>
                                                    </optgroup>
                                                    <optgroup label="Chill Moods">
                                                        <option value="😌" {{ old('icon') == '😌' ? 'selected' : '' }}>😌 Relaxed</option>
                                                        <option value="😴" {{ old('icon') == '😴' ? 'selected' : '' }}>😴 Sleepy</option>
                                                        <option value="🧘" {{ old('icon') == '🧘' ? 'selected' : '' }}>🧘 Meditating</option>
                                                        <option value="🍃" {{ old('icon') == '🍃' ? 'selected' : '' }}>🍃 Leaf</option>
                                                        <option value="🌊" {{ old('icon') == '🌊' ? 'selected' : '' }}>🌊 Ocean</option>
                                                        <option value="🛀" {{ old('icon') == '🛀' ? 'selected' : '' }}>🛀 Bath</option>
                                                        <option value="🌅" {{ old('icon') == '🌅' ? 'selected' : '' }}>🌅 Sunrise</option>
                                                        <option value="🎧" {{ old('icon') == '🎧' ? 'selected' : '' }}>🎧 Headphones</option>
                                                    </optgroup>
                                                    <optgroup label="Adventurous">
                                                        <option value="🏔️" {{ old('icon') == '🏔️' ? 'selected' : '' }}>🏔️ Mountain</option>
                                                        <option value="🚀" {{ old('icon') == '🚀' ? 'selected' : '' }}>🚀 Rocket</option>
                                                        <option value="🏄" {{ old('icon') == '🏄' ? 'selected' : '' }}>🏄 Surfing</option>
                                                        <option value="🧗" {{ old('icon') == '🧗' ? 'selected' : '' }}>🧗 Climbing</option>
                                                        <option value="🚴" {{ old('icon') == '🚴' ? 'selected' : '' }}>🚴 Biking</option>
                                                        <option value="🌋" {{ old('icon') == '🌋' ? 'selected' : '' }}>🌋 Volcano</option>
                                                        <option value="🏜️" {{ old('icon') == '🏜️' ? 'selected' : '' }}>🏜️ Desert</option>
                                                    </optgroup>
                                                    <optgroup label="Romantic">
                                                        <option value="💕" {{ old('icon') == '💕' ? 'selected' : '' }}>💕 Hearts</option>
                                                        <option value="💖" {{ old('icon') == '💖' ? 'selected' : '' }}>💖 Sparkling Heart</option>
                                                        <option value="💘" {{ old('icon') == '💘' ? 'selected' : '' }}>💘 Heart Arrow</option>
                                                        <option value="🌹" {{ old('icon') == '🌹' ? 'selected' : '' }}>🌹 Rose</option>
                                                        <option value="💑" {{ old('icon') == '💑' ? 'selected' : '' }}>💑 Couple</option>
                                                        <option value="💞" {{ old('icon') == '💞' ? 'selected' : '' }}>💞 Revolving Hearts</option>
                                                    </optgroup>
                                                    <optgroup label="Sad / Thoughtful">
                                                        <option value="😔" {{ old('icon') == '😔' ? 'selected' : '' }}>😔 Pensive</option>
                                                        <option value="😢" {{ old('icon') == '😢' ? 'selected' : '' }}>😢 Crying</option>
                                                        <option value="😭" {{ old('icon') == '😭' ? 'selected' : '' }}>😭 Sob</option>
                                                        <option value="🤔" {{ old('icon') == '🤔' ? 'selected' : '' }}>🤔 Thinking</option>
                                                        <option value="😕" {{ old('icon') == '😕' ? 'selected' : '' }}>😕 Confused</option>
                                                        <option value="🌧️" {{ old('icon') == '🌧️' ? 'selected' : '' }}>🌧️ Rain Cloud</option>
                                                        <option value="☔" {{ old('icon') == '☔' ? 'selected' : '' }}>☔ Umbrella</option>
                                                    </optgroup>
                                                    <optgroup label="Energetic / Party">
                                                        <option value="🥳" {{ old('icon') == '🥳' ? 'selected' : '' }}>🥳 Celebrating</option>
                                                        <option value="🎉" {{ old('icon') == '🎉' ? 'selected' : '' }}>🎉 Party Popper</option>
                                                        <option value="🎊" {{ old('icon') == '🎊' ? 'selected' : '' }}>🎊 Confetti</option>
                                                        <option value="🍾" {{ old('icon') == '🍾' ? 'selected' : '' }}>🍾 Champagne</option>
                                                        <option value="💃" {{ old('icon') == '💃' ? 'selected' : '' }}>💃 Dance</option>
                                                        <option value="🕺" {{ old('icon') == '🕺' ? 'selected' : '' }}>🕺 Disco Dance</option>
                                                        <option value="🔥" {{ old('icon') == '🔥' ? 'selected' : '' }}>🔥 Fire</option>
                                                    </optgroup>
                                                    <optgroup label="Dreamy / Magical">
                                                        <option value="🌌" {{ old('icon') == '🌌' ? 'selected' : '' }}>🌌 Galaxy</option>
                                                        <option value="🌠" {{ old('icon') == '🌠' ? 'selected' : '' }}>🌠 Shooting Star</option>
                                                        <option value="🪐" {{ old('icon') == '🪐' ? 'selected' : '' }}>🪐 Saturn</option>
                                                        <option value="✨" {{ old('icon') == '✨' ? 'selected' : '' }}>✨ Sparkles</option>
                                                        <option value="🧚" {{ old('icon') == '🧚' ? 'selected' : '' }}>🧚 Fairy</option>
                                                        <option value="🦄" {{ old('icon') == '🦄' ? 'selected' : '' }}>🦄 Unicorn</option>
                                                    </optgroup>
                                                    <optgroup label="Dark / Mysterious">
                                                        <option value="🌑" {{ old('icon') == '🌑' ? 'selected' : '' }}>🌑 New Moon</option>
                                                        <option value="🦇" {{ old('icon') == '🦇' ? 'selected' : '' }}>🦇 Bat</option>
                                                        <option value="🕸️" {{ old('icon') == '🕸️' ? 'selected' : '' }}>🕸️ Web</option>
                                                        <option value="🕷️" {{ old('icon') == '🕷️' ? 'selected' : '' }}>🕷️ Spider</option>
                                                        <option value="👻" {{ old('icon') == '👻' ? 'selected' : '' }}>👻 Ghost</option>
                                                        <option value="😈" {{ old('icon') == '😈' ? 'selected' : '' }}>😈 Devilish</option>
                                                    </optgroup>
                                                </select>
                                                @error('icon')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                                <small class="text-muted">Select from popular mood emojis</small>
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <label for="mapped_genre" class="form-label fw-bold">Mapped Genre</label>
                                                <select class="form-select @error('mapped_genre') is-invalid @enderror" id="mapped_genre_create" name="mapped_genre">
                                                    <option value="">Select Genre</option>
                                                    @if(isset($genres))
                                                        @foreach($genres as $genre)
                                                            <option value="{{ $genre->name }}" {{ old('mapped_genre') == $genre->name ? 'selected' : '' }}>
                                                                {{ $genre->name }}
                                                            </option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                                @error('mapped_genre')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                                <small class="text-muted">Genre this mood maps to (e.g., Action, Comedy)</small>
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label for="description" class="form-label fw-bold">Description</label>
                                            <textarea class="form-control @error('description') is-invalid @enderror" id="description_create" name="description" rows="4">{{ old('description') }}</textarea>
                                            @error('description')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <small class="text-muted">Describe what this mood represents</small>
                                        </div>

                                        <div class="d-flex justify-content-end gap-2">
                                            <button type="submit" class="btn btn-primary">
                                                <i class="fas fa-plus-circle me-2"></i>Create Mood
                                            </button>
                                            <a href="{{ route('admin.moods.index') }}" class="btn btn-secondary">
                                                <i class="fas fa-arrow-left me-2"></i>Back to Moods
                                            </a>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            @endisset


            {{-- ================================================================= --}}
            {{-- CONDITIONAL CONTENT: INDEX LIST (@isset($moods)) --}}
            {{-- This displays the list of all moods (Index page) --}}
            {{-- ================================================================= --}}
            @isset($moods)
                @if (!isset($mood) && (!isset($is_creating) || $is_creating !== true)) {{-- Only show if NOT editing or creating --}}
                    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-4 border-bottom">
                        <h1 class="h2 text-dark fw-bold">Manage Moods</h1>
                        <div class="d-flex gap-2">
                            <a href="{{ route('admin.moods.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus me-2"></i>Add New Mood
                            </a>
                            <div class="input-group shadow-sm" style="width: 300px;">
                                <input type="text" class="form-control" id="searchInput" placeholder="Search moods by name...">
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

                    {{-- Moods Table --}}
                    <div class="card shadow-lg border-0" id="moodList">
                        <div class="card-header bg-secondary text-white d-flex justify-content-between align-items-center">
                            <h5 class="mb-0"><i class="fas fa-list me-2"></i> All Mood Entries</h5>
                        </div>
                        {{-- Added max-height and overflow-y to make the table body scrollable --}}
                        <div class="card-body p-0 table-scroll-wrapper">
                            <div class="table-responsive">
                                <table class="table table-striped table-hover align-middle mb-0" id="moodTable">
                                    <thead class="table-dark sticky-header">
                                        <tr>
                                            <th style="width: 5%;"><i class="fas fa-hashtag"></i> ID</th>
                                            <th style="width: 20%;"><i class="fas fa-heading"></i> Name</th>
                                            <th style="width: 10%;"><i class="fas fa-smile"></i> Emoji</th>
                                            <th style="width: 20%;"><i class="fas fa-tag"></i> Mapped Genre</th>
                                            <th style="width: 30%;"><i class="fas fa-info-circle"></i> Description</th>
                                            <th style="width: 15%;"><i class="fas fa-cogs"></i> Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {{-- Loop through the moods data --}}
                                        @forelse($moods as $mood_item)
                                            <tr>
                                                {{-- FIX: Using $loop->iteration to display sequential numbering instead of $mood_item->id --}}
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $mood_item->name }}</td>
                                                <td class="fs-4">{{ $mood_item->icon }}</td>
                                                <td>{{ $mood_item->mapped_genre }}</td>
                                                <td>{{ Str::limit($mood_item->description, 50) }}</td>
                                                <td>
                                                    {{-- Example action links --}}
                                                    <a href="{{ route('admin.moods.edit', $mood_item->id) }}" class="btn btn-sm btn-outline-primary me-2">
                                                        <i class="fas fa-edit"></i> Edit
                                                    </a>
                                                    <form method="POST" action="{{ route('admin.moods.destroy', $mood_item->id) }}" style="display: inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete mood: {{ $mood_item->name }}?')">
                                                            <i class="fas fa-trash"></i> Delete
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="6" class="text-center py-4 text-muted">No moods found in the database. Start by adding one!</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        {{-- Pagination --}}
                        <div class="card-footer bg-light">
                            {{ $moods->links() }}
                        </div>
                    </div>
                @endif
            @endisset
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

/* --- Sticky Table Header Fix (Index) --- */
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


/* Card and Content Styling (Used for all forms/list) */
.card {
    border: none;
    border-radius: 12px;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.card:hover {
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

.emoji-select {
    font-size: 1.2rem;
    height: 50px;
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
// Function to slugify a string
function slugify(text) {
    return text.toString().toLowerCase()
        .replace(/\s+/g, '-')           // Replace spaces with -
        .replace(/[^\w\-]+/g, '')       // Remove all non-word chars
        .replace(/\-\-+/g, '-')         // Replace multiple - with single -
        .replace(/^-+/, '')             // Trim - from start of text
        .replace(/-+$/, '');            // Trim - from end of text
}

// Auto-generate slug from name for CREATE form
document.getElementById('name_create')?.addEventListener('input', function() {
    const slugInput = document.getElementById('slug_create');
    if (slugInput) {
        slugInput.value = slugify(this.value);
    }
});

// Auto-generate slug from name for EDIT form
document.getElementById('name')?.addEventListener('input', function() {
    const slugInput = document.getElementById('slug');
    if (slugInput) {
        slugInput.value = slugify(this.value);
    }
});

// Filter table rows on keyup (Index view functionality)
document.getElementById('searchInput')?.addEventListener('keyup', function() {
    const searchTerm = this.value.toLowerCase();
    const table = document.getElementById('moodTable');
    if (!table) return; // Exit if the table isn't present (i.e., we are on create/edit view)

    const rows = table.getElementsByTagName('tbody')[0].getElementsByTagName('tr');

    for (let i = 0; i < rows.length; i++) {
        const cells = rows[i].getElementsByTagName('td');
        let found = false;
        // Search across Name (index 1) and Mapped Genre (index 3)
        // Ensure index checks are safe based on the table structure
        if (cells.length > 3) {
            if (cells[1].textContent.toLowerCase().includes(searchTerm) ||
                cells[3].textContent.toLowerCase().includes(searchTerm)) {
                found = true;
            }
        }
        rows[i].style.display = found ? '' : 'none';
    }
});

document.getElementById('searchButton')?.addEventListener('click', function() {
    document.getElementById('searchInput').focus();
});
</script>
@endpush
@endsection