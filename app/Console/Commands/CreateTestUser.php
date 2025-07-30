<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class CreateTestUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:create-test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a test admin user';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $adminRole = Role::where('name', 'admin')->first();
        
        $user = User::create([
            'name' => 'Admin Test',
            'email' => 'admin@test.com',
            'password' => Hash::make('password'),
            'role_id' => $adminRole ? $adminRole->id : null,
        ]);

        $this->info('Test admin user created successfully!');
        $this->info('Email: admin@test.com');
        $this->info('Password: password');
    }
}
