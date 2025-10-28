<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('movies', function (Blueprint $table) {
            $table->id(); // primary key (unsigned BIGINT)
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('poster_path')->nullable();
            $table->string('backdrop_path')->nullable();
            $table->decimal('rating', 3, 1)->nullable();
            $table->integer('release_year')->nullable();
            $table->string('director')->nullable();
            $table->json('cast')->nullable();
            $table->string('trailer_url')->nullable();

            // foreign key must match 'moods.id' type
            $table->foreignId('mood_id')->constrained('moods')->onDelete('cascade');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('movies');
    }
};
