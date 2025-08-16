<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $permissions = [
            // Users
            'users read',
            'users create',
            'users edit',
            'users delete',

            // Roles
            'role read',
            'role create',
            'role edit',
            'role delete',

            // Permissions
            'permissions read',
            'permissions create',
            'permissions edit',
            'permissions delete',

            // Blog
            'blog read',
            'blog create',
            'blog edit',
            'blog delete',

            // Blog Categories
            'blog categories read',
            'blog categories create',
            'blog categories edit',
            'blog categories delete',

            // News
            'news read',
            'news create',
            'news edit',
            'news delete',

            // News Categories
            'news categories read',
            'news categories create',
            'news categories edit',
            'news categories delete',

            // Pages
            'pages read',
            'pages create',
            'pages edit',
            'pages delete',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }
    }
}
