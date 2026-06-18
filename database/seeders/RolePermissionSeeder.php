<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Roles (skip if already exists)
        \Spatie\Permission\Models\Role::firstOrCreate(['name' => 'admin']);
        \Spatie\Permission\Models\Role::firstOrCreate(['name' => 'petani']);
        \Spatie\Permission\Models\Role::firstOrCreate(['name' => 'pembeli']);

        // Create Admin User (skip if already exists)
        $admin = \App\Models\User::firstOrCreate(
            ['email' => 'admin@sipsh.com'],
            [
                'name' => 'Super Admin SIPSH',
                'password' => \Illuminate\Support\Facades\Hash::make('password'),
                'status' => 'aktif',
            ]
        );
        if (!$admin->hasRole('admin')) {
            $admin->assignRole('admin');
        }
    }
}
