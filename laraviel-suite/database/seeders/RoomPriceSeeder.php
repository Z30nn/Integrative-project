<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoomPriceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roomPrices = [
            ["room_type" => "Standard V1", "price" => 1000],
            ["room_type" => "Standard V2", "price" => 1200],
            ["room_type" => "Standard V3", "price" => 1400],
            ["room_type" => "Deluxe V1", "price" => 1800],
            ["room_type" => "Deluxe V2", "price" => 2000],
            ["room_type" => "Deluxe V3", "price" => 2200],
            ["room_type" => "Luxury V1", "price" => 2500],
            ["room_type" => "Luxury V2", "price" => 2800],
            ["room_type" => "Luxury V3", "price" => 3000],
        ];

        foreach ($roomPrices as $roomPrice) {
            DB::table('room_prices')->insert([
                'price' => $roomPrice['price'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
