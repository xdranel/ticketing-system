<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Create 1 Admin
        User::factory()->role(UserRole::Admin)->create([
            'name' => 'System Admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
        ]);

        // 2. Create 1 Agent
        User::factory()->role(UserRole::Agent)->create([
            'name' => 'Support Agent',
            'email' => 'agent@example.com',
            'password' => bcrypt('password'),
        ]);

        // 3. Create Customer 1
        User::factory()->role(UserRole::Customer)->create([
            'name' => 'John Customer',
            'email' => 'customer1@example.com',
            'password' => bcrypt('password'),
        ]);

        // 4. Create Customer 2
        User::factory()->role(UserRole::Customer)->create([
            'name' => 'Jane Customer',
            'email' => 'customer2@example.com',
            'password' => bcrypt('password'),
        ]);
    }
}
