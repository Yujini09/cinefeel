<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\User::create([
            'name' => 'Marie Eugenie Cabigas',
            'email' => 'marieeugeniecabigas@gmail.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
        ]);

        \App\Models\User::create([
            'name' => 'Labasan Zyramae',
            'email' => 'labasanzyramae24@gmail.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
        ]);
    }
}
