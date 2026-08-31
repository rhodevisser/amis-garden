<?php

namespace Database\Seeders;

use App\Models\Photo;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Catty Fluf',
            'email' => 'b.fluf@catweb.com',
            'password' => '87654321',
        ]);

        User::factory()->count(5)->create();

        Photo::factory()->count(10)->create();
    }
}
