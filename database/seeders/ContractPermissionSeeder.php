<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class ContractPermissionSeeder extends Seeder
{
    public function run(): void
    {
        foreach ([
            'contracts.view','contracts.create','contracts.edit','contracts.delete',
            'contracts.approve','contracts.terminate','contracts.renew',
            'contracts.manage-types','contracts.manage-templates',
            'contracts.manage-notices','contracts.view-audit',
        ] as $permission) {
            Permission::firstOrCreate(['name'=>$permission, 'guard_name'=>'web']);
        }
    }
}
