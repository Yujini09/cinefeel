$(document).ready(function() {
    // Function to display dynamic messages
    function displayMessage(message, type) {
        // Remove any existing alerts to prevent multiple messages stacking up
        $('#messageContainer .alert').remove();
        const alertHtml = `
            <div class="alert alert-${type} alert-dismissible fade show" role="alert">
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        `;
        // Append to a specific container, not just any .card-body
        $('#messageContainer').html(alertHtml);

        // Auto-dismiss after 5 seconds
        setTimeout(function() {
            $('#messageContainer .alert').alert('close');
        }, 5000);
    }

    // --- Moods Management ---
    $('#addMoodModal form').on('submit', function(e) {
        e.preventDefault();
        const formData = $(this).serialize();
        const csrfToken = $('meta[name="csrf-token"]').attr('content'); // Get Laravel CSRF token
        $.ajax({
            url: '/api/moods', // Corrected API endpoint to Laravel URL
            type: 'POST',
            data: formData, // Removed redundant '&action=add_mood'
            headers: {
                'X-CSRF-TOKEN': csrfToken // Send CSRF token
            },
            success: function(response) {
                if (response.success) {
                    displayMessage(response.message, 'success');
                    $('#addMoodModal').modal('hide');
                    $('#addMoodModal form')[0].reset();
                    const newRow = `
                        <tr id="mood-${response.mood.mood_id}">
                            <td>${response.mood.mood_name}</td>
                            <td class="fs-4">${response.mood.emoji}</td>
                            <td>${response.mood.mapped_genre}</td>
                            <td>${response.mood.description}</td>
                            <td>
                                <button class="btn btn-sm btn-outline-primary edit-mood"
                                        data-mood-id="${response.mood.mood_id}"
                                        data-mood-name="${response.mood.mood_name}"
                                        data-mapped-genre="${response.mood.mapped_genre}"
                                        data-emoji="${response.mood.emoji}"
                                        data-description="${response.mood.description}">
                                    <i class="fas fa-edit"></i> Edit
                                </button>
                                <form class="d-inline delete-mood-form">
                                    @csrf
                                    @method('DELETE') {{-- Use DELETE method for RESTful API --}}
                                    <input type="hidden" name="mood_id" value="${response.mood.mood_id}">
                                    <button type="submit" name="delete_mood" class="btn btn-sm btn-outline-danger">
                                        <i class="fas fa-trash"></i> Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    `;
                    $('table tbody').append(newRow);
                } else {
                    displayMessage(response.message, 'danger');
                }
            },
            error: function() {
                displayMessage('An error occurred while adding the mood.', 'danger');
            }
        });
    });

    $(document).on('click', '.edit-mood', function() {
        const moodId = $(this).data('mood-id');
        const moodName = $(this).data('mood-name');
        const mappedGenre = $(this).data('mapped-genre');
        const emoji = $(this).data('emoji');
        const description = $(this).data('description');

        $('#edit_mood_id').val(moodId);
        $('#edit_mood_name').val(moodName);
        $('#edit_emoji').val(emoji);
        $('#edit_genre').val(mappedGenre);
        $('#edit_description').val(description);

        const editMoodModal = new bootstrap.Modal(document.getElementById('editMoodModal'));
        editMoodModal.show();
    });

    $('#editMoodModal form').on('submit', function(e) {
        e.preventDefault();
        const formData = $(this).serialize();
        const csrfToken = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            url: '/api/moods/' + $('#edit_mood_id').val(), // Corrected to PUT request with ID
            type: 'PUT',
            data: formData,
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            success: function(response) {
                if (response.success) {
                    displayMessage(response.message, 'success');
                    $('#editMoodModal').modal('hide');
                    const updatedMood = response.mood;
                    const row = $(`#mood-${updatedMood.mood_id}`);
                    row.find('td:eq(0)').text(updatedMood.mood_name);
                    row.find('td:eq(1)').text(updatedMood.emoji);
                    row.find('td:eq(2)').text(updatedMood.mapped_genre);
                    row.find('td:eq(3)').text(updatedMood.description);
                    row.find('.edit-mood').data('mood-name', updatedMood.mood_name);
                    row.find('.edit-mood').data('mapped-genre', updatedMood.mapped_genre);
                    row.find('.edit-mood').data('emoji', updatedMood.emoji);
                    row.find('.edit-mood').data('description', updatedMood.description);

                } else {
                    displayMessage(response.message, 'danger');
                }
            },
            error: function() {
                displayMessage('An error occurred while updating the mood.', 'danger');
            }
        });
    });

    $(document).on('submit', '.delete-mood-form', function(e) {
        e.preventDefault();
        if (confirm('Are you sure you want to delete this mood?')) {
            const moodId = $(this).find('input[name="mood_id"]').val();
            const csrfToken = $('meta[name="csrf-token"]').attr('content');
            const row = $(this).closest('tr');
            $.ajax({
                url: '/api/moods/' + moodId, // Corrected to DELETE request with ID
                type: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                success: function(response) {
                    if (response.success) {
                        displayMessage(response.message, 'success');
                        row.remove();
                    } else {
                        displayMessage(response.message, 'danger');
                    }
                },
                error: function() {
                    displayMessage('An error occurred while deleting the mood.', 'danger');
                }
            });
        }
    });

    // --- Movies Management ---
    $('#addMovieModal form').on('submit', function(e) {
        e.preventDefault();
        const formData = $(this).serialize();
        const csrfToken = $('meta[name="csrf-token"]').attr('content');

        $.ajax({
            url: '/api/movies',
            type: 'POST',
            data: formData,
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            success: function(response) {
                if (response.success) {
                    displayMessage(response.message, 'success');
                    $('#addMovieModal').modal('hide');
                    $('#addMovieModal form')[0].reset();

                    // Refresh the page to show the new movie
                    location.reload();
                } else {
                    displayMessage(response.message, 'danger');
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX Error:', status, error, xhr.responseText);
                displayMessage('An error occurred while adding the movie. Check console for details.', 'danger');
            }
        });
    });

    $(document).on('click', '.edit-movie', function() {
        const data = $(this).data();
        $('#edit_movie_id').val(data.movieId);
        $('#edit_title').val(data.title);
        $('#edit_genre').val(data.genre);
        $('#edit_mood_id').val(data.moodId || '');
        $('#edit_description').val(data.description);
        $('#edit_poster_url').val(data.posterUrl);
        $('#edit_trailer_link').val(data.trailerLink);
        $('#edit_release_year').val(data.releaseYear);
        $('#edit_duration').val(data.duration);

        $('#editMovieModal').modal('show');
    });

    $('#editMovieModal form').on('submit', function(e) {
        e.preventDefault();
        const formData = $(this).serialize();
        const csrfToken = $('meta[name="csrf-token"]').attr('content');

        $.ajax({
            url: '/api/movies/' + $('#edit_movie_id').val(), // Corrected to PUT request with ID
            type: 'PUT',
            data: formData,
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            success: function(response) {
                if (response.success) {
                    displayMessage(response.message, 'success');
                    $('#editMovieModal').modal('hide');

                    // Refresh the page to show updated data
                    location.reload();
                } else {
                    displayMessage(response.message, 'danger');
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX Error:', status, error, xhr.responseText);
                displayMessage('An error occurred while updating the movie. Check console for details.', 'danger');
            }
        });
    });

    $(document).on('submit', '.delete-movie-form', function(e) {
        e.preventDefault();

        if (confirm('Are you sure you want to delete this movie?')) {
            const movieId = $(this).find('input[name="movie_id"]').val();
            const csrfToken = $('meta[name="csrf-token"]').attr('content');
            const row = $(this).closest('tr');

            $.ajax({
                url: '/api/movies/' + movieId, // Corrected to DELETE request with ID
                type: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                success: function(response) {
                    if (response.success) {
                        displayMessage(response.message, 'success');
                        row.remove();
                    } else {
                        displayMessage(response.message, 'danger');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error:', status, error, xhr.responseText);
                    displayMessage('An error occurred while deleting the movie. Check console for details.', 'danger');
                }
            });
        }
    });
});

