<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            [
                'name' => 'admin',
                'display_name' => 'Administrator',
                'description' => 'System Administrator with full access'
            ],
            [
                'name' => 'user',
                'display_name' => 'Regular User',
                'description' => 'Regular user with basic access'
            ],
            [
                'name' => 'hrd',
                'display_name' => 'HRD',
                'description' => 'Human Resource Department'
            ],
            [
                'name' => 'kepala_unit',
                'display_name' => 'Kepala Unit',
                'description' => 'Unit Manager'
            ],
            [
                'name' => 'keuangan',
                'display_name' => 'Keuangan',
                'description' => 'Finance Department'
            ],
            [
                'name' => 'karyawan',
                'display_name' => 'Karyawan',
                'description' => 'Employee'
            ],
        ];

        foreach ($roles as $role) {
            Role::create($role);
        }
    }
}
