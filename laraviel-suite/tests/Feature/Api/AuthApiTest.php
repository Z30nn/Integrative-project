<?php

namespace Tests\Feature\Api;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthApiTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;
    protected string $token;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::create([
            'name' => 'Test User',
            'email' => 'test@user.com',
            'role' => 'admin',
            'password' => bcrypt('password')
        ]);
        $this->token = auth('api')->tokenById($this->user->id);
    }

    /** @test */
    public function test_user_can_login_with_valid_credentials(): void
    {
        $response = $this->postJson('/api/v1/auth/login', [
            'email'    => 'test@user.com',
            'password' => 'password',
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'access_token',
                'token_type',
                'expires_in',
                'user' => ['id', 'name', 'email', 'role'],
            ])
            ->assertJson(['success' => true, 'token_type' => 'Bearer']);
    }

    /** @test */
    public function test_login_fails_with_invalid_credentials(): void
    {
        $response = $this->postJson('/api/v1/auth/login', [
            'email'    => 'test@user.com',
            'password' => 'wrongpassword',
        ]);

        $response->assertStatus(401)
            ->assertJson(['success' => false]);
    }

    /** @test */
    public function test_login_fails_with_missing_fields(): void
    {
        $response = $this->postJson('/api/v1/auth/login', [
            'email' => 'admin@laraviel.com',
        ]);

        $response->assertStatus(422);
    }

    /** @test */
    public function test_authenticated_user_can_get_profile(): void
    {
        $token = auth('api')->tokenById($this->user->id);

        $response = $this->withHeader('Authorization', "Bearer $token")
            ->getJson('/api/v1/auth/me');

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'data'    => ['email' => 'test@user.com', 'role' => 'admin'],
            ]);
    }

    /** @test */
    public function test_unauthenticated_request_to_me_returns_401(): void
    {
        $response = $this->getJson('/api/v1/auth/me');
        $response->assertStatus(401);
    }

    /** @test */
    public function test_user_can_logout(): void
    {
        $token = auth('api')->tokenById($this->user->id);

        $response = $this->withHeader('Authorization', "Bearer $token")
            ->postJson('/api/v1/auth/logout');

        $response->assertStatus(200)
            ->assertJson(['success' => true, 'message' => 'Successfully logged out.']);
    }

    /** @test */
    public function test_admin_can_access_dashboard(): void
    {
        $response = $this->withHeader('Authorization', "Bearer $this->token")
            ->getJson('/api/v1/dashboard');

        $response->assertStatus(200);
    }

    /** @test */
    public function test_cashier_cannot_access_dashboard(): void
    {
        $cashier = User::create([
            'name' => 'Cashier User',
            'email' => 'cashier@user.com',
            'role' => 'cashier',
            'password' => bcrypt('password')
        ]);
        $cashierToken = auth('api')->tokenById($cashier->id);

        $response = $this->withHeader('Authorization', "Bearer $cashierToken")
            ->getJson('/api/v1/dashboard');

        $response->assertStatus(403);
    }
}
