<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        \App\Models\User::factory()->create([
            'name' => 'Test User',
            'email' => 'user2@gmail.com',
            'roles' => 'admin',
            'password' => '$2y$10$v4ZEHaMnJfhQ/cdEBLbche.9oZBMdsUPi6LY5r.hUO8So.tt9ipoC', //user2@gmail
        ]);
        \App\Models\User::factory()->create([
            'name' => 'Test User',
            'email' => 'user1@gmail.com',
            'roles' => 'user',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        ]);
        $this->call([
            CategorySeeder::class,
        ]);
    }
}
