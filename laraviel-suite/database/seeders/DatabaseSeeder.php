<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'superadmin@laraviel.com'],
            [
                'name' => 'Super Admin',
                'role' => 'super_admin',
                'password' => Hash::make('SuperAdmin@12345'),
            ]
        );

        User::updateOrCreate(
            ['email' => 'admin@laraviel.com'],
            [
                'name' => 'admin',
                'role' => 'admin',
                'password' => Hash::make('Admin@12345'),
            ]
        );

        User::updateOrCreate(
            ['email' => 'cashier@laraviel.com'],
            [
                'name' => 'cashier',
                'role' => 'cashier',
                'password' => Hash::make('Cashier@12345'),
            ]
        );

        $this->call([
            RoomPriceSeeder::class,
        ]);
    }
}
