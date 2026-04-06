<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'name' => 'Super Admin',
            'email' => 'superadmin@laraviel.com',
            'role' => 'super_admin',
            'password' => Hash::make('SuperAdmin@12345'),
        ]);

        DB::table('users')->insert([
            'name' => 'admin',
            'email' => 'admin@laraviel.com',
            'role' => 'admin',
            'password' => Hash::make('Admin@12345'),
        ]);

        DB::table('users')->insert([
            'name' => 'cashier',
            'email' => 'cashier@laraviel.com',
            'role' => 'cashier',
            'password' => Hash::make('Cashier@12345'),
        ]);

        $this->call([
            RoomPriceSeeder::class,
        ]);
    }
}
