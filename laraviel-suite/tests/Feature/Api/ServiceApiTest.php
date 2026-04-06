<?php

namespace Tests\Feature\Api;

use App\Models\AvailedService;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ServiceApiTest extends TestCase
{
    use RefreshDatabase;

    protected string $adminToken;
    protected string $cashierToken;

    protected function setUp(): void
    {
        parent::setUp();

        $admin   = User::create(['name' => 'Admin', 'email' => 'admin_test@test.com', 'role' => 'admin', 'password' => bcrypt('password')]);
        $cashier = User::create(['name' => 'Cashier', 'email' => 'cashier_test@test.com', 'role' => 'cashier', 'password' => bcrypt('password')]);

        $this->adminToken   = auth('api')->tokenById($admin->id);
        $this->cashierToken = auth('api')->tokenById($cashier->id);
    }

    /** @test */
    public function test_authenticated_user_can_list_availed_services(): void
    {
        $response = $this->withHeader('Authorization', "Bearer {$this->adminToken}")
            ->getJson('/api/v1/availed-services');

        $response->assertStatus(200)
            ->assertJsonStructure(['success', 'data']);
    }

    /** @test */
    public function test_cashier_can_mark_service_as_paid(): void
    {
        $guestId = \Illuminate\Support\Facades\DB::table('guests')->insertGetId([
            'booking_id' => 'BK-TEST-1', 'lastname' => 'A', 'firstname' => 'B', 'guest_count' => 1,
            'email' => 'a@b.com', 'contact_number' => '123', 'address' => 'X', 
            'check_in' => '2025-01-01', 'check_out' => '2025-01-02', 'booked_rooms' => 'Room', 'price_total' => 100
        ]);
        $serviceId = \Illuminate\Support\Facades\DB::table('services')->insertGetId([
            'service_name' => 'Spa', 'availed_service' => 'Massage', 'description' => 'A nice spa', 'price' => 100, 'created_at' => now(), 'updated_at' => now()
        ], 'service_id');
        $availedId = \Illuminate\Support\Facades\DB::table('availed_services')->insertGetId([
            'guest_name' => 'A B', 'service_id' => $serviceId, 'service_date' => '2025-01-01',
            'payment_method' => 'over_the_counter', 'payment_status' => 'pending', 'total_price' => 100, 
            'booking_id' => 'BK-TEST-1', 'created_at' => now(), 'updated_at' => now()
        ]);

        $response = $this->withHeader('Authorization', "Bearer {$this->cashierToken}")
            ->postJson("/api/v1/availed-services/{$availedId}/mark-paid");

        $response->assertStatus(200)
            ->assertJson(['success' => true]);

        $this->assertDatabaseHas('availed_services', [
            'id'             => $availedId,
            'payment_status' => 'Paid',
        ]);
    }

    /** @test */
    public function test_unauthenticated_user_cannot_list_services(): void
    {
        $response = $this->getJson('/api/v1/availed-services');
        $response->assertStatus(401);
    }

    /** @test */
    public function test_can_filter_availed_services_by_payment_status(): void
    {
        $guestId = \Illuminate\Support\Facades\DB::table('guests')->insertGetId([
            'booking_id' => 'BK-TEST-2', 'lastname' => 'A', 'firstname' => 'B', 'guest_count' => 1,
            'email' => 'a@b.com', 'contact_number' => '123', 'address' => 'X', 
            'check_in' => '2025-01-01', 'check_out' => '2025-01-02', 'booked_rooms' => 'Room', 'price_total' => 100
        ]);
        $serviceId = \Illuminate\Support\Facades\DB::table('services')->insertGetId([
            'service_name' => 'Massage', 'availed_service' => 'Massage', 'description' => 'A massage', 'price' => 50, 'created_at' => now(), 'updated_at' => now()
        ], 'service_id');
        \Illuminate\Support\Facades\DB::table('availed_services')->insert([
            ['guest_name' => 'A B', 'service_id' => $serviceId, 'service_date' => '2025-01-01', 'payment_method' => 'over_the_counter', 'payment_status' => 'paid', 'total_price' => 50, 'booking_id' => 'BK-TEST-2', 'created_at' => now(), 'updated_at' => now()],
            ['guest_name' => 'A B', 'service_id' => $serviceId, 'service_date' => '2025-01-01', 'payment_method' => 'over_the_counter', 'payment_status' => 'pending', 'total_price' => 50, 'booking_id' => 'BK-TEST-2', 'created_at' => now(), 'updated_at' => now()],
        ]);

        $response = $this->withHeader('Authorization', "Bearer {$this->adminToken}")
            ->getJson('/api/v1/availed-services?payment_status=Paid');

        $response->assertStatus(200)
                 ->assertJsonCount(1, 'data.data');

        $this->assertEquals('paid', $response->json('data.data.0.payment_status'));
    }
}
