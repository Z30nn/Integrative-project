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
    // Admin
    \App\Models\User::updateOrCreate(
        ['email' => 'admin@gmail.com'], // The unique check
        [
            'name' => 'admin',
            'role' => 'admin',
            'password' => Hash::make('password'),
        ]
    );

    // Cashier
    \App\Models\User::updateOrCreate(
        ['email' => 'cashier@gmail.com'],
        [
            'name' => 'cashier',
            'role' => 'cashier',
            'password' => Hash::make('password'),
        ]
    );
}
}
