<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Role;

class UpdateUserRole extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:update-role';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update user role to admin';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $user = User::where('email', 'admin@test.com')->first();
        $adminRole = Role::where('name', 'admin')->first();
        
        if ($user && $adminRole) {
            $user->role_id = $adminRole->id;
            $user->save();
            $this->info('User role updated to admin successfully!');
        } else {
            $this->error('User or admin role not found');
        }
    }
}
