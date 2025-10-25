<?php

namespace Database\Seeders;

use App\Models\Genre;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GenreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $genres = [
            ['name' => 'Action', 'slug' => 'action'],
            ['name' => 'Comedy', 'slug' => 'comedy'],
            ['name' => 'Drama', 'slug' => 'drama'],
            ['name' => 'Fantasy', 'slug' => 'fantasy'],
            ['name' => 'Horror', 'slug' => 'horror'],
            ['name' => 'Romance', 'slug' => 'romance'],
            ['name' => 'Sci-Fi', 'slug' => 'sci-fi'],
            ['name' => 'Thriller', 'slug' => 'thriller'],
            ['name' => 'Documentary', 'slug' => 'documentary'],
            ['name' => 'Mystery', 'slug' => 'mystery'],
        ];

        foreach ($genres as $genre) {
            Genre::create($genre);
        }
    }
}
