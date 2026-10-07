<?php

namespace Database\Factories;

use App\Models\Photo;
use App\Models\PhotoSnack;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<PhotoSnack>
 */
class PhotoSnackFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'photo_id' => Photo::factory(),
        ];
    }
}
