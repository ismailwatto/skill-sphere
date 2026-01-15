<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Role;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Create System Roles
        $superAdminRole = Role::create([
            'name' => 'Super Admin',
            'business_id' => null,
        ]);

        Role::create([
            'name' => 'Business Owner',
            'business_id' => null,
        ]);

        Role::create([
            'name' => 'Staff',
            'business_id' => null,
        ]);

        // 3. Create Super Admin User
        User::create([
            'name' => 'Super Admin',
            'email' => 'admin@skillsphere.com',
            'password' => Hash::make('password'),
            'status' => 'active',
            'business_id' => null,
            'role_id' => $superAdminRole->id,
        ]);
    }
}
