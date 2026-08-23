<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_login()
    {
        $user = User::factory()->create([
            'password' => bcrypt($password = 'i-love-laravel'),
        ]);

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => $password,
        ]);

        $response->assertRedirect('/');
        $this->assertAuthenticatedAs($user);

        $response = $this->get('/');
        $response->assertSee('Welcome back!');
        $response->assertSee('Log Out');
        $response->assertDontSee('Sign In');
        $response->assertDontSee('Register');
    }

    public function test_user_can_logout()
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $response = $this->post('/api/logout');

        $response->assertRedirect('/');
        $this->assertGuest();

        $response = $this->get('/');
        $response->assertSee('Goodbye!');
        $response->assertSee('Sign In');
        $response->assertSee('Register');
        $response->assertDontSee('Log Out');
    }
}
