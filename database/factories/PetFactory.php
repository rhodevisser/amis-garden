<?php

namespace Database\Factories;

use App\Models\Pet;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Pet>
 */
class PetFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->firstName(),
            'species' => $this->faker->randomElement(['Dog', 'Cat', 'Bird', 'Fish', 'Rabbit']),
            'breed' => $this->faker->word(),
            'age' => $this->faker->numberBetween(1, 15),
            'gender' => $this->faker->boolean(),
            'description' => $this->faker->sentence(),
            'image' => 'https://picsum.photos/seed/'.$this->faker->uuid.'/640/480',
            'user_id' => User::factory(),
        ];
    }
}
