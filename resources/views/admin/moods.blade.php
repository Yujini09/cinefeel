@extends('layouts.app')

@section('title', 'Manage Moods')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
@endpush
@push('scripts')
    <script src="{{ asset('js/admin.js') }}"></script>
    {{-- Inline script for emoji preview moved here --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const emojiSelects = document.querySelectorAll('.emoji-select');

            emojiSelects.forEach(select => {
                const preview = document.createElement('div');
                preview.className = 'emoji-preview fs-3 mb-2 text-center';
                preview.textContent = select.value || '😊';
                select.parentNode.insertBefore(preview, select);

                select.addEventListener('change', function() {
                    preview.textContent = this.value;
                });
            });
        });
    </script>
@endpush

@php
    $isAdminPage = true;
@endphp

<div class="admin-container">
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h2 class="h5 mb-0">Manage Moods</h2>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addMoodModal">
                <i class="fas fa-plus me-1"></i> Add New Mood
            </button>
        </div>
        <div class="card-body">
            <div id="messageContainer"></div>

            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Mood</th>
                            <th>Emoji</th>
                            <th>Mapped Genre</th>
                            <th>Description</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($moods as $mood)
                        <tr id="mood-{{ $mood->mood_id }}">
                            <td>{{ $mood->mood_name }}</td>
                            <td class="fs-4">{{ $mood->emoji }}</td>
                            <td>{{ $mood->mapped_genre }}</td>
                            <td>{{ $mood->description }}</td>
                            <td>
                                <button class="btn btn-sm btn-outline-primary edit-mood"
                                        data-mood-id="{{ $mood->mood_id }}"
                                        data-mood-name="{{ $mood->mood_name }}"
                                        data-mapped-genre="{{ $mood->mapped_genre }}"
                                        data-emoji="{{ $mood->emoji }}"
                                        data-description="{{ $mood->description }}">
                                    <i class="fas fa-edit"></i> Edit
                                </button>
                                <form class="d-inline delete-mood-form">
                                    @csrf
                                    @method('DELETE') {{-- Use DELETE method for RESTful API --}}
                                    <input type="hidden" name="mood_id" value="{{ $mood->mood_id }}">
                                    <button type="submit" name="delete_mood" class="btn btn-sm btn-outline-danger">
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

{{-- Add Mood Modal (Form simplified to use a single route and method) --}}
<div class="modal fade" id="addMoodModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="addMoodForm">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Add New Mood</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="mood_name" class="form-label">Mood Name</label>
                        <input type="text" class="form-control" id="mood_name" name="mood_name" required>
                    </div>
                    <div class="mb-3">
                        <label for="emoji" class="form-label">Emoji</label>
                        <select class="form-select emoji-select" id="emoji" name="emoji" required>
                            <option value="">Select Emoji</option>
                            {{-- ... large emoji select list (omitted for brevity, copied from original file) ... --}}
                            <optgroup label="Happy Moods">
                                <option value="😊">😊 Smiling</option>
                                <option value="😂">😂 Laughing</option>
                            </optgroup>
                        </select>
                        <small class="text-muted">Select from popular mood emojis</small>
                    </div>
                    <div class="mb-3">
                        <label for="mapped_genre" class="form-label">Mapped Genre</label>
                        <input type="text" class="form-control" id="mapped_genre" name="mapped_genre" required>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" name="add_mood" class="btn btn-primary">Add Mood</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Edit Mood Modal --}}
<div class="modal fade" id="editMoodModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="editMoodForm">
                @csrf
                @method('PUT') {{-- Use PUT method for RESTful API --}}
                <input type="hidden" name="mood_id" id="edit_mood_id">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Mood</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="edit_mood_name" class="form-label">Mood Name</label>
                        <input type="text" class="form-control" id="edit_mood_name" name="mood_name" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_emoji" class="form-label">Emoji</label>
                        <input type="text" class="form-control" id="edit_emoji" name="emoji" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_mapped_genre" class="form-label">Mapped Genre</label>
                        <input type="text" class="form-control" id="edit_genre" name="mapped_genre" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_description" class="form-label">Description</label>
                        <textarea class="form-control" id="edit_description" name="description" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" name="update_mood" class="btn btn-primary">Update Mood</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
