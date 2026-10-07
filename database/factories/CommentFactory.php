<?php

namespace Database\Factories;

use App\Models\Comment;
use App\Models\Photo;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Comment>
 */
class CommentFactory extends Factory
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
            'parent_id' => null,
            'content' => $this->faker->paragraph(),
        ];
    }

    /**
     * Make the comment a reply to the given comment, on the same photo.
     */
    public function replyTo(Comment $parent): static
    {
        return $this->state(fn (array $attributes) => [
            'photo_id' => $parent->photo_id,
            'parent_id' => $parent->id,
        ]);
    }
}
