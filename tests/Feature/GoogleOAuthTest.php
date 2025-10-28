<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\User as SocialiteUser;
use Tests\TestCase;

class GoogleOAuthTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        // The RefreshDatabase trait will handle database setup with in-memory SQLite
    }

    public function test_google_login_creates_new_user_if_email_not_exists()
    {
        // Mock Google user
        $googleUser = $this->createMock(SocialiteUser::class);
        $googleUser->method('getId')->willReturn('123456789');
        $googleUser->method('getName')->willReturn('John Doe');
        $googleUser->method('getEmail')->willReturn('john.doe@example.com');
        $googleUser->method('getAvatar')->willReturn('https://example.com/avatar.jpg');

        Socialite::shouldReceive('driver->user')->andReturn($googleUser);

        // Make request to Google callback
        $response = $this->get('/auth/google/callback');

        // Assert user was created
        $this->assertDatabaseHas('users', [
            'email' => 'john.doe@example.com',
            'provider' => 'google',
            'provider_id' => '123456789',
        ]);

        // Assert user is authenticated
        $this->assertAuthenticated();

        // Assert redirect to home
        $response->assertRedirect(route('home'));
    }

    public function test_google_login_logs_in_existing_user_by_email()
    {
        // Create existing user with same email
        $existingUser = User::factory()->create([
            'email' => 'existing@example.com',
            'password' => bcrypt('password'),
        ]);

        // Mock Google user with same email
        $googleUser = $this->createMock(SocialiteUser::class);
        $googleUser->method('getId')->willReturn('987654321');
        $googleUser->method('getName')->willReturn('Jane Doe');
        $googleUser->method('getEmail')->willReturn('existing@example.com');
        $googleUser->method('getAvatar')->willReturn('https://example.com/avatar2.jpg');

        Socialite::shouldReceive('driver->user')->andReturn($googleUser);

        // Make request to Google callback
        $response = $this->get('/auth/google/callback');

        // Assert no new user was created
        $this->assertDatabaseCount('users', 1);

        // Assert the existing user is authenticated
        $this->assertAuthenticatedAs($existingUser);

        // Assert redirect to home
        $response->assertRedirect(route('home'));
    }

    public function test_google_login_handles_exception()
    {
        // Mock Socialite to throw exception
        Socialite::shouldReceive('driver->user')->andThrow(new \Exception('Google API error'));

        // Make request to Google callback
        $response = $this->get('/auth/google/callback');

        // Assert redirect to login with error
        $response->assertRedirect(route('login'));
        $response->assertSessionHas('error', 'Google login failed.');
    }
}
