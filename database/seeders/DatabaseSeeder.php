<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(KeteranganSeeder::class);

        // Admin
        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'role' => 'admin',
            'password' => bcrypt('password'),
        ]);

        // Siswa
        User::factory()->create([
            'name' => 'Siswa User',
            'email' => 'siswa@example.com',
            'role' => 'siswa',
            'password' => bcrypt('password'),
        ]);
    }
}