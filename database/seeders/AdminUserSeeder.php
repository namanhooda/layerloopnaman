<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin role
        $adminRole = Role::find(1);

        // Create basic permissions
   
        // Assign all permissions to admin role
        $adminRole->givePermissionTo(Permission::all());

        // Create admin user
        $adminUser = User::create([
            'name' => 'Admin User',
            'email' => 'admin@ailifebot.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);

        // Assign admin role to admin user
        $adminUser->assignRole($adminRole);

        $this->command->info('Admin user created successfully!');
        $this->command->info('Email: admin@ailifebot.com');
        $this->command->info('Password: password');
    }
}
