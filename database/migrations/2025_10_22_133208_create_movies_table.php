<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('movies', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('poster_path')->nullable();
            $table->string('backdrop_path')->nullable();
            $table->decimal('rating', 3, 1)->nullable();
            $table->integer('release_year')->nullable();
            $table->string('director')->nullable();
            $table->json('cast')->nullable();
            $table->string('trailer_url')->nullable();
            $table->unsignedBigInteger('mood_id');
            $table->foreign('mood_id')->references('id')->on('moods')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movies');
    }
};
