<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Moods Table
        Schema::create('moods', function (Blueprint $table) {
            $table->id('mood_id'); // Laravel's default is `id`, but using mood_id for consistency
            $table->string('mood_name', 50)->unique();
            $table->string('mapped_genre', 50);
            $table->string('emoji', 10);
            $table->text('description')->nullable();
            $table->timestamps(); // For Created/Updated timestamps
        });

        // 2. Movies Table
        Schema::create('movies', function (Blueprint $table) {
            $table->id('movie_id'); // Using movie_id for consistency
            $table->string('title', 100);
            $table->unsignedBigInteger('mood_id')->nullable();
            $table->text('description')->nullable();
            $table->string('poster_url', 255)->nullable();
            $table->string('trailer_link', 255)->nullable();
            $table->integer('release_year')->nullable();
            $table->string('duration', 20)->nullable();
            $table->timestamps();

            // Foreign Key Constraint
            $table->foreign('mood_id')->references('mood_id')->on('moods')->onDelete('set null');
        });

        // 3. Genres Table
        Schema::create('genres', function (Blueprint $table) {
            $table->id('genre_id'); // Using genre_id for consistency
            $table->string('genre_name', 255)->unique();
            $table->timestamps();
        });

        // 4. Pivot Table for Movie and Genre (Many-to-Many)
        Schema::create('movie_genres', function (Blueprint $table) {
            $table->unsignedBigInteger('movie_id');
            $table->unsignedBigInteger('genre_id');

            $table->primary(['movie_id', 'genre_id']);

            $table->foreign('movie_id')->references('movie_id')->on('movies')->onDelete('cascade');
            $table->foreign('genre_id')->references('genre_id')->on('genres')->onDelete('cascade');
        });

        // 5. Favorites Table (Requires `users` table to exist, which Laravel skeleton provides, but we'll adapt the FK)
        // Assuming Laravel's default `users` table uses `id` for primary key, renamed to `user_id` here for clarity
        Schema::create('favorites', function (Blueprint $table) {
            $table->id('favorite_id');
            $table->unsignedBigInteger('user_id'); // Assuming the Laravel `users` table PK is compatible
            $table->unsignedBigInteger('movie_id');
            $table->timestamp('added_at')->useCurrent();
            $table->timestamps();

            $table->unique(['user_id', 'movie_id'], 'unique_favorite');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('movie_id')->references('movie_id')->on('movies')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('favorites');
        Schema::dropIfExists('movie_genres');
        Schema::dropIfExists('genres');
        Schema::dropIfExists('movies');
        Schema::dropIfExists('moods');
    }
};
