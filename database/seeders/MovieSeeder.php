<?php

namespace Database\Seeders;

use App\Models\Movie;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MovieSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $movies = [
            [
                'title' => 'The Shawshank Redemption',
                'description' => 'Two imprisoned men bond over a number of years, finding solace and eventual redemption through acts of common decency.',
                'poster_path' => '/assets/images/shawshank.jpg',
                'backdrop_path' => '/assets/images/shawshank-backdrop.jpg',
                'rating' => 9.3,
                'release_year' => 1994,
                'director' => 'Frank Darabont',
                'cast' => ['Tim Robbins', 'Morgan Freeman', 'Bob Gunton'],
                'trailer_url' => 'https://www.youtube.com/watch?v=6hB3S9bIaco',
                'mood_id' => 2, // Sad
                'genres' => [2, 4], // Drama, Crime (assuming IDs)
            ],
            [
                'title' => 'Inception',
                'description' => 'A thief who steals corporate secrets through the use of dream-sharing technology is given the inverse task of planting an idea into the mind of a C.E.O.',
                'poster_path' => '/assets/images/inception.jpg',
                'backdrop_path' => '/assets/images/inception-backdrop.jpg',
                'rating' => 8.8,
                'release_year' => 2010,
                'director' => 'Christopher Nolan',
                'cast' => ['Leonardo DiCaprio', 'Marion Cotillard', 'Tom Hardy'],
                'trailer_url' => 'https://www.youtube.com/watch?v=YoHD9XEInc0',
                'mood_id' => 3, // Excited
                'genres' => [1, 3, 5], // Action, Sci-Fi, Thriller
            ],
            [
                'title' => 'The Pursuit of Happyness',
                'description' => 'A struggling salesman takes custody of his son as he\'s poised to begin a life-changing professional career.',
                'poster_path' => '/assets/images/happyness.jpg',
                'backdrop_path' => '/assets/images/happyness-backdrop.jpg',
                'rating' => 8.0,
                'release_year' => 2006,
                'director' => 'Gabriele Muccino',
                'cast' => ['Will Smith', 'Jaden Smith', 'Thandiwe Newton'],
                'trailer_url' => 'https://www.youtube.com/watch?v=89Kq8SDyvfg',
                'mood_id' => 1, // Happy
                'genres' => [2, 6], // Drama, Biography
            ],
            [
                'title' => 'Planet Earth II',
                'description' => 'David Attenborough returns in this breathtaking documentary showcasing the beauty and diversity of life on Earth.',
                'poster_path' => '/assets/images/planet-earth.jpg',
                'backdrop_path' => '/assets/images/planet-earth-backdrop.jpg',
                'rating' => 9.5,
                'release_year' => 2016,
                'director' => 'Various',
                'cast' => ['David Attenborough'],
                'trailer_url' => 'https://www.youtube.com/watch?v=c8aFcHFu8QM',
                'mood_id' => 4, // Calming
                'genres' => [7], // Documentary
            ],
            [
                'title' => 'La La Land',
                'description' => 'A jazz pianist falls for an aspiring actress in Los Angeles.',
                'poster_path' => '/assets/images/la-la-land.jpg',
                'backdrop_path' => '/assets/images/la-la-land-backdrop.jpg',
                'rating' => 8.0,
                'release_year' => 2016,
                'director' => 'Damien Chazelle',
                'cast' => ['Ryan Gosling', 'Emma Stone', 'Rosemarie DeWitt'],
                'trailer_url' => 'https://www.youtube.com/watch?v=0pdqf4P9MB8',
                'mood_id' => 5, // Romantic
                'genres' => [2, 8, 9], // Drama, Musical, Comedy
            ],
            [
                'title' => 'Hereditary',
                'description' => 'A grieving family is haunted by tragic and disturbing occurrences.',
                'poster_path' => '/assets/images/hereditary.jpg',
                'backdrop_path' => '/assets/images/hereditary-backdrop.jpg',
                'rating' => 7.3,
                'release_year' => 2018,
                'director' => 'Ari Aster',
                'cast' => ['Toni Collette', 'Alex Wolff', 'Milly Shapiro'],
                'trailer_url' => 'https://www.youtube.com/watch?v=V6wWKNij_1M',
                'mood_id' => 6, // Scared
                'genres' => [10, 2, 5], // Horror, Drama, Thriller
            ],
            [
                'title' => 'Interstellar',
                'description' => 'A team of explorers travel through a wormhole in space in an attempt to ensure humanity\'s survival.',
                'poster_path' => '/assets/images/interstellar.jpg',
                'backdrop_path' => '/assets/images/interstellar-backdrop.jpg',
                'rating' => 8.6,
                'release_year' => 2014,
                'director' => 'Christopher Nolan',
                'cast' => ['Matthew McConaughey', 'Anne Hathaway', 'Jessica Chastain'],
                'trailer_url' => 'https://www.youtube.com/watch?v=zSWdZVtXT7E',
                'mood_id' => 7, // Curious
                'genres' => [1, 2, 3], // Adventure, Drama, Sci-Fi
            ],
        ];

        foreach ($movies as $movieData) {
            // Separate genres from movie data
            $genreIds = $movieData['genres'];
            unset($movieData['genres']); // Remove genres before creating the movie

            $movie = Movie::create($movieData);
            $movie->genres()->attach($genreIds); // Attach genres via the relationship
        }
    }
}
