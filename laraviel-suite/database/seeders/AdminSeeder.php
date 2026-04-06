<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        // Admin user
        User::firstOrCreate(
            ['email' => 'admin@laraviel.com'],
            [
                'name'     => 'Admin',
                'role'     => 'admin',
                'password' => Hash::make('Admin@12345'),
                'email_verified_at' => now(),
            ]
        );

        // Cashier user
        User::firstOrCreate(
            ['email' => 'cashier@laraviel.com'],
            [
                'name'     => 'Cashier',
                'role'     => 'cashier',
                'password' => Hash::make('Cashier@12345'),
                'email_verified_at' => now(),
            ]
        );

        $this->command->info('Admin and Cashier users seeded.');
        $this->command->info('Admin: admin@laraviel.com / Admin@12345');
        $this->command->info('Cashier: cashier@laraviel.com / Cashier@12345');
    }
}
