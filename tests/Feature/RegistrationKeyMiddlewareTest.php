<?php

namespace Tests\Feature;

use App\Models\Key;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistrationKeyMiddlewareTest extends TestCase
{
    use RefreshDatabase;

    public function test_cannot_access_registration_form_without_key_in_session()
    {
        $response = $this->get(route('register.form'));

        $response->assertRedirect(route('register.key'));
        $response->assertSessionHasErrors(['key' => 'Please enter a valid registration key first.']);
    }

    public function test_cannot_access_registration_form_with_invalid_key_id_in_session()
    {
        session(['registration_key_id' => 999]);

        $response = $this->get(route('register.form'));

        $response->assertRedirect(route('register.key'));
        $response->assertSessionMissing('registration_key_id');
        $response->assertSessionHasErrors(['key' => 'Your registration key is no longer valid. Please try again.']);
    }

    public function test_cannot_access_registration_form_with_expired_key()
    {
        $key = Key::create([
            'key' => 'EXPIRED-KEY',
            'expires_at' => now()->subDay(),
        ]);

        session(['registration_key_id' => $key->id]);

        $response = $this->get(route('register.form'));

        $response->assertRedirect(route('register.key'));
        $response->assertSessionMissing('registration_key_id');
    }

    public function test_cannot_access_registration_form_with_used_key()
    {
        $user = User::factory()->create();
        $key = Key::create([
            'key' => 'USED-KEY',
            'used_at' => now(),
            'used_by' => $user->id,
        ]);

        session(['registration_key_id' => $key->id]);

        $response = $this->get(route('register.form'));

        $response->assertRedirect(route('register.key'));
        $response->assertSessionMissing('registration_key_id');
    }

    public function test_can_access_registration_form_with_valid_key()
    {
        $key = Key::create([
            'key' => 'VALID-KEY',
        ]);

        session(['registration_key_id' => $key->id]);

        $response = $this->get(route('register.form'));

        $response->assertStatus(200);
        $response->assertViewIs('register.register');
    }
}
