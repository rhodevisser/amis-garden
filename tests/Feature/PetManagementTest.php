<?php

namespace Tests\Feature;

use App\Models\Pet;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class PetManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_add_pet_to_profile(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('pets.create'));
        $response->assertOk();
    }

    public function test_user_can_store_new_pet(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('pets.store'), [
            'name' => 'Buddy',
            'species' => 'Dog',
            'breed' => 'Golden Retriever',
            'age' => 3,
            'gender' => 1,
            'description' => 'A friendly dog',
            'image' => UploadedFile::fake()->image('pet.jpg'),
        ]);

        $response->assertRedirect(route('user.show', $user));

        $this->assertDatabaseHas('pets', [
            'name' => 'Buddy',
            'species' => 'Dog',
            'user_id' => $user->id,
        ]);
    }

    public function test_pet_is_linked_to_owner(): void
    {
        $user = User::factory()->create();
        $pet = Pet::factory()->create(['user_id' => $user->id]);

        $this->assertTrue($user->pets->contains($pet));
        $this->assertEquals($user->id, $pet->owner->id);
    }

    public function test_user_can_view_pet_profile(): void
    {
        $user = User::factory()->create();
        $pet = Pet::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->get(route('pets.show', $pet));
        $response->assertOk();
    }

    public function test_user_can_edit_own_pet(): void
    {
        $user = User::factory()->create();
        $pet = Pet::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->get(route('pets.edit', $pet));
        $response->assertStatus(200);
    }

    public function test_user_cannot_edit_other_users_pet(): void
    {
        $owner = User::factory()->create();
        $otherUser = User::factory()->create();
        $pet = Pet::factory()->create(['user_id' => $owner->id]);

        $response = $this->actingAs($otherUser)->get(route('pets.edit', $pet));
        $response->assertForbidden();
    }

    public function test_user_can_update_own_pet(): void
    {
        $user = User::factory()->create();
        $pet = Pet::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->patch(route('pets.update', $pet), [
            'name' => 'Max',
            'species' => 'Cat',
            'breed' => 'Persian',
            'age' => 2,
            'gender' => 0,
            'description' => 'A beautiful cat',
        ]);

        $response->assertRedirect(route('pets.show', $pet));

        $this->assertDatabaseHas('pets', [
            'id' => $pet->id,
            'name' => 'Max',
            'species' => 'Cat',
        ]);
    }

    public function test_user_can_delete_own_pet(): void
    {
        $user = User::factory()->create();
        $pet = Pet::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->delete(route('pets.destroy', $pet));
        $response->assertRedirect(route('user.show', $user));

        $this->assertDatabaseMissing('pets', ['id' => $pet->id]);
    }

    public function test_user_cannot_have_more_than_5_pets(): void
    {
        $user = User::factory()->create();
        Pet::factory()->count(5)->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->post(route('pets.store'), [
            'name' => 'Extra Pet',
            'species' => 'Dog',
            'breed' => 'Labrador',
            'age' => 1,
            'gender' => 1,
            'description' => 'Too many pets',
            'image' => UploadedFile::fake()->image('pet.jpg'),
        ]);

        $response->assertForbidden();
    }

    public function test_user_profile_shows_pets(): void
    {
        $user = User::factory()->create();
        $pet = Pet::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->get(route('user.show', $user));
        $response->assertOk();
        $response->assertSee($pet->name);
    }

    public function test_add_pet_button_only_shows_when_under_limit(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('user.show', $user));
        $response->assertSee('Add Pet');

        Pet::factory()->count(5)->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->get(route('user.show', $user));
        $response->assertDontSee('Add Pet');
    }

    public function test_only_logged_in_users_can_access_pets(): void
    {
        $response = $this->get(route('pets.create'));
        $response->assertRedirect(route('login'));

        $pet = Pet::factory()->create();
        $response = $this->get(route('pets.show', $pet));
        $response->assertRedirect(route('login'));
    }
}
