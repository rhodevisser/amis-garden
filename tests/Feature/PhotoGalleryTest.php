<?php

namespace Tests\Feature;

use App\Models\Photo;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PhotoGalleryTest extends TestCase
{
    use RefreshDatabase;

    public function test_only_logged_in_users_can_see_gallery()
    {
        $response = $this->get(route('photos.index'));
        $response->assertRedirect(route('login'));

        $user = User::factory()->create();
        $response = $this->actingAs($user)->get(route('photos.index'));
        $response->assertStatus(200);
    }

    public function test_photos_are_ordered_by_newest_first()
    {
        $user = User::factory()->create();
        $oldPhoto = Photo::factory()->create(['created_at' => now()->subDay()]);
        $newPhoto = Photo::factory()->create(['created_at' => now()]);

        $response = $this->actingAs($user)->get(route('photos.index'));

        $response->assertSeeInOrder([
            $newPhoto->title,
            $oldPhoto->title,
        ]);
    }
}
