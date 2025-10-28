<?php

namespace Database\Seeders;

use App\Models\Mood;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MoodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $moods = [
            [
                'name' => 'Happy',
                'slug' => 'happy',
                'description' => 'Light-hearted and fun movies',
                'color' => '#FFD700',
                'icon' => '😊',
            ],
            [
                'name' => 'Sad',
                'slug' => 'sad',
                'description' => 'Emotional and touching stories',
                'color' => '#4682B4',
                'icon' => '😢',
            ],
            [
                'name' => 'Excited',
                'slug' => 'excited',
                'description' => 'High-energy thrillers',
                'color' => '#FF4500',
                'icon' => '🤩',
            ],
            [
                'name' => 'Calming',
                'slug' => 'calming',
                'description' => 'Peaceful and informative films',
                'color' => '#32CD32',
                'icon' => '😌',
            ],
            [
                'name' => 'Romantic',
                'slug' => 'romantic',
                'description' => 'Love stories and romantic comedies',
                'color' => '#FF69B4',
                'icon' => '🥰',
            ],
            [
                'name' => 'Scared',
                'slug' => 'scared',
                'description' => 'Spooky and thrilling movies',
                'color' => '#8B0000',
                'icon' => '😱',
            ],
            [
                'name' => 'Curious',
                'slug' => 'curious',
                'description' => 'Mysterious and intriguing films',
                'color' => '#9370DB',
                'icon' => '🤔',
            ],
        ];

        foreach ($moods as $mood) {
            Mood::create($mood);
        }
    }
}
