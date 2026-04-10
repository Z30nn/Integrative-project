<?php

namespace Tests\Feature\Api;

use App\Models\Room;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RoomApiTest extends TestCase
{
    use RefreshDatabase;

    protected string $adminToken;
    protected string $cashierToken;

    protected function setUp(): void
    {
        parent::setUp();

        $admin = User::create(['name' => 'Admin', 'email' => 'admin_test@test.com', 'role' => 'admin', 'password' => bcrypt('password')]);
        $cashier = User::create(['name' => 'Cashier', 'email' => 'cashier_test@test.com', 'role' => 'cashier', 'password' => bcrypt('password')]);

        $this->adminToken   = auth('api')->tokenById($admin->id);
        $this->cashierToken = auth('api')->tokenById($cashier->id);
    }

    /** @test */
    public function test_authenticated_user_can_list_rooms(): void
    {
        \Illuminate\Support\Facades\DB::table('rooms')->insert([
            'room_type' => 'Standard',
            'description' => 'A nice room',
            'image_path' => 'img/room.jpg',
            'room_price_id' => \Illuminate\Support\Facades\DB::table('room_prices')->insertGetId(['price' => 1000]),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $response = $this->withHeader('Authorization', "Bearer {$this->adminToken}")
            ->getJson('/api/v1/rooms');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'data' => ['data', 'total', 'per_page'],
            ]);
    }

    /** @test */
    public function test_unauthenticated_user_cannot_list_rooms(): void
    {
        $response = $this->getJson('/api/v1/rooms');
        $response->assertStatus(401);
    }

    /** @test */
    public function test_admin_can_create_room(): void
    {
        $priceId = \Illuminate\Support\Facades\DB::table('room_prices')->insertGetId(['price' => 2000]);

        $response = $this->withHeader('Authorization', "Bearer {$this->adminToken}")
            ->postJson('/api/v1/rooms', [
                'room_type'     => 'Standard V1',
                'description'   => 'A test room',
                'image_path'    => 'path/to/img.png',
                'room_price_id' => $priceId,
            ]);

        $response->assertStatus(201)
            ->assertJson([
                'success' => true,
                'data'    => ['room_type' => 'Standard V1'],
            ]);

        $this->assertDatabaseHas('rooms', ['room_type' => 'Standard V1']);
    }

    /** @test */
    public function test_cashier_cannot_create_room(): void
    {
        $priceId = \Illuminate\Support\Facades\DB::table('room_prices')->insertGetId(['price' => 2000]);

        $response = $this->withHeader('Authorization', "Bearer {$this->cashierToken}")
            ->postJson('/api/v1/rooms', [
                'room_type'     => 'Standard V1',
                'description'   => 'A test room',
                'image_path'    => 'path/to/img.png',
                'room_price_id' => $priceId,
            ]);

        $response->assertStatus(403);
    }

    /** @test */
    public function test_room_creation_fails_with_invalid_price_id(): void
    {
        $response = $this->withHeader('Authorization', "Bearer {$this->adminToken}")
            ->postJson('/api/v1/rooms', [
                'room_type'     => 'Standard',
                'description'   => 'A nice room',
                'room_price_id' => 99999, // Does not exist
            ]);

        $response->assertStatus(422);
    }

    /** @test */
    public function test_admin_can_delete_room(): void
    {
        $priceId = \Illuminate\Support\Facades\DB::table('room_prices')->insertGetId(['price' => 2000]);
        $roomId = \Illuminate\Support\Facades\DB::table('rooms')->insertGetId([
            'room_type' => 'Deluxe', 'description' => 'Test', 'image_path' => 'img.png', 'room_price_id' => $priceId
        ]);

        $response = $this->withHeader('Authorization', "Bearer {$this->adminToken}")
            ->deleteJson("/api/v1/rooms/{$roomId}");

        $response->assertStatus(200)->assertJson(['success' => true]);
        $this->assertDatabaseMissing('rooms', ['id' => $roomId]);
    }
}
