<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'John Doe',
            'email' => 'admin@example.com',
        ]);

        User::factory()->create([
            'name' => 'Jane Doe',
            'email' => 'user@example.com',
        ]);

        User::factory()->count(10)->create();
    }
}
