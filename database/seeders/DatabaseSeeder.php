<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create default roles
        $this->call(RoleSeeder::class);
        
        // Create master data
        $this->call(MasterDataSeeder::class);

        // Get role IDs
        $adminRole = Role::where('name', 'admin')->first();
        $userRole = Role::where('name', 'user')->first();
        $hrdRole = Role::where('name', 'hrd')->first();
        $kepalaUnitRole = Role::where('name', 'kepala_unit')->first();
        $keuanganRole = Role::where('name', 'keuangan')->first();
        $karyawanRole = Role::where('name', 'karyawan')->first();

        // Create default users
        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'role_id' => $adminRole->id
        ]);

        User::factory()->create([
            'name' => 'HRD User',
            'email' => 'hrd@example.com',
            'password' => bcrypt('password'),
            'role_id' => $hrdRole->id
        ]);

        User::factory()->create([
            'name' => 'Kepala Unit',
            'email' => 'kepalaunit@example.com',
            'password' => bcrypt('password'),
            'role_id' => $kepalaUnitRole->id
        ]);

        User::factory()->create([
            'name' => 'Keuangan User',
            'email' => 'keuangan@example.com',
            'password' => bcrypt('password'),
            'role_id' => $keuanganRole->id
        ]);

        User::factory()->create([
            'name' => 'Regular User',
            'email' => 'user@example.com',
            'password' => bcrypt('password'),
            'role_id' => $userRole->id
        ]);

        User::factory()->create([
            'name' => 'Karyawan User',
            'email' => 'karyawan@example.com',
            'password' => bcrypt('password'),
            'role_id' => $karyawanRole->id
        ]);
    }
}
