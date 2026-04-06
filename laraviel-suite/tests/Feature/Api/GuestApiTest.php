<?php

namespace Tests\Feature\Api;

use App\Models\Guest;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use App\Events\BookingCreated;
use Tests\TestCase;

class GuestApiTest extends TestCase
{
    use RefreshDatabase;

    protected string $adminToken;
    protected string $cashierToken;

    protected function setUp(): void
    {
        parent::setUp();

        $admin = User::create(['name' => 'Admin', 'email' => 'admin_test@test.com', 'role' => 'admin', 'password' => bcrypt('password')]);
        $this->adminToken = auth('api')->tokenById($admin->id);

        $cashier = User::create(['name' => 'Cashier', 'email' => 'cashier_test@test.com', 'role' => 'cashier', 'password' => bcrypt('password')]);
        $this->cashierToken = auth('api')->tokenById($cashier->id);
    }

    /** @test */
    public function test_admin_can_list_guests(): void
    {
        \Illuminate\Support\Facades\DB::table('guests')->insert([
            'booking_id' => 'BK-100', 'lastname' => 'A', 'firstname' => 'B', 'guest_count' => 1,
            'email' => 'a@b.com', 'contact_number' => '123', 'address' => 'X', 
            'check_in' => '2025-01-01', 'check_out' => '2025-01-02', 'booked_rooms' => 'Room', 'price_total' => 100
        ]);

        $response = $this->withHeader('Authorization', "Bearer {$this->adminToken}")
            ->getJson('/api/v1/guests');

        $response->assertStatus(200)
            ->assertJsonStructure(['success', 'data' => ['data', 'total']]);
    }

    /** @test */
    public function test_can_create_guest_and_event_is_fired(): void
    {
        Event::fake([BookingCreated::class]);

        $response = $this->withHeader('Authorization', "Bearer {$this->adminToken}")
            ->postJson('/api/v1/guests', [
                'bookingId'     => 'BK-TEST-001',
                'lastname'      => 'Dela Cruz',
                'firstname'     => 'Juan',
                'guestCount'    => 2,
                'email'         => 'juan@example.com',
                'contactNumber' => '09171234567',
                'address'       => '123 Main St, Manila',
                'checkIn'       => now()->addDay()->toDateString(),
                'checkOut'      => now()->addDays(3)->toDateString(),
                'bookedRooms'   => 'Standard V1',
                'priceTotal'    => 5000,
            ]);

        $response->assertStatus(201)
            ->assertJson([
                'success' => true,
                'data'    => ['booking_id' => 'BK-TEST-001'],
            ]);

        $this->assertDatabaseHas('guests', ['booking_id' => 'BK-TEST-001']);
        $this->assertDatabaseHas('income_trackers', ['customer_name' => 'Juan Dela Cruz']);

        Event::assertDispatched(BookingCreated::class);
    }

    /** @test */
    public function test_guest_creation_fails_with_duplicate_booking_id(): void
    {
        \Illuminate\Support\Facades\DB::table('guests')->insert([
            'booking_id' => 'BK-DUPLICATE', 'lastname' => 'A', 'firstname' => 'B', 'guest_count' => 1,
            'email' => 'a@b.com', 'contact_number' => '123', 'address' => 'X', 
            'check_in' => '2025-01-01', 'check_out' => '2025-01-02', 'booked_rooms' => 'Room', 'price_total' => 100
        ]);

        $response = $this->withHeader('Authorization', "Bearer {$this->adminToken}")
            ->postJson('/api/v1/guests', [
                'bookingId'     => 'BK-DUPLICATE',
                'lastname'      => 'Test',
                'firstname'     => 'User',
                'guestCount'    => 1,
                'email'         => 'test@example.com',
                'contactNumber' => '09000000000',
                'address'       => 'Test Address',
                'checkIn'       => now()->addDay()->toDateString(),
                'checkOut'      => now()->addDays(3)->toDateString(),
                'bookedRooms'   => 'Standard V1',
                'priceTotal'    => 3000,
            ]);

        $response->assertStatus(422);
    }

    /** @test */
    public function test_admin_can_delete_guest(): void
    {
        $guestId = \Illuminate\Support\Facades\DB::table('guests')->insertGetId([
            'booking_id' => 'BK-DEL-100', 'lastname' => 'A', 'firstname' => 'B', 'guest_count' => 1,
            'email' => 'a@b.com', 'contact_number' => '123', 'address' => 'X', 
            'check_in' => '2025-01-01', 'check_out' => '2025-01-02', 'booked_rooms' => 'Room', 'price_total' => 100
        ]);

        $response = $this->withHeader('Authorization', "Bearer {$this->adminToken}")
            ->deleteJson("/api/v1/guests/{$guestId}");

        $response->assertStatus(200)->assertJson(['success' => true]);
        $this->assertDatabaseMissing('guests', ['id' => $guestId]);
    }

    /** @test */
    public function test_cashier_can_list_guests(): void
    {
        $response = $this->withHeader('Authorization', "Bearer {$this->cashierToken}")
            ->getJson('/api/v1/guests');

        $response->assertStatus(200);
    }

    /** @test */
    public function test_cashier_cannot_delete_guest(): void
    {
        $guestId = \Illuminate\Support\Facades\DB::table('guests')->insertGetId([
            'booking_id' => 'BK-NO-DEL', 'lastname' => 'A', 'firstname' => 'B', 'guest_count' => 1,
            'email' => 'a@b.com', 'contact_number' => '123', 'address' => 'X', 
            'check_in' => '2025-01-01', 'check_out' => '2025-01-02', 'booked_rooms' => 'Room', 'price_total' => 100
        ]);

        $response = $this->withHeader('Authorization', "Bearer {$this->cashierToken}")
            ->deleteJson("/api/v1/guests/{$guestId}");

        $response->assertStatus(403);
        $this->assertDatabaseHas('guests', ['id' => $guestId]);
    }
}
