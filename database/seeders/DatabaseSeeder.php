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
        User::factory()->role(UserRole::Admin)->create([
            'name' => 'System Admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
        ]);

        User::factory()->role(UserRole::Agent)->create([
            'name' => 'Support Agent 1',
            'email' => 'agent1@example.com',
            'password' => bcrypt('password'),
        ]);

        User::factory()->role(UserRole::Agent)->create([
            'name' => 'Support Agent 2',
            'email' => 'agent2@example.com',
            'password' => bcrypt('password'),
        ]);

        User::factory()->role(UserRole::Customer)->create([
            'name' => 'John Customer',
            'email' => 'customer1@example.com',
            'password' => bcrypt('password'),
        ]);

        User::factory()->role(UserRole::Customer)->create([
            'name' => 'Jane Customer',
            'email' => 'customer2@example.com',
            'password' => bcrypt('password'),
        ]);

        User::factory()->role(UserRole::Customer)->create([
            'name' => 'Bob Customer',
            'email' => 'customer3@example.com',
            'password' => bcrypt('password'),
        ]);

        $this->call([
            TicketSeeder::class,
        ]);
    }
}
