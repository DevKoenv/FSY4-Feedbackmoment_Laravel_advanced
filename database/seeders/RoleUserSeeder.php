<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();
        $roles = Role::all();

        $admin = User::where('email', 'admin@example.com')->first();
        $user = User::where('email', 'user@example.com')->first();

        $admin->roles()->attach(Role::where('name', 'Admin')->first());
        $user->roles()->attach(Role::where('name', 'User')->first());

        foreach ($users as $user) {
            $user->roles()->attach($roles->random());
        }
    }
}
