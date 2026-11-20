<?php

namespace Database\Seeders;

use App\Models\ContractType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ContractTypeSeeder extends Seeder
{
    public function run(): void
    {
        $types = [
            'Intellectual Property Protection',
            'Exclusive Selling Agreement',
            'Franchise Agreement',
            'NDA / Confidentiality Agreement',
            'Custom Manufacturing Agreement',
            'Legal Notice / Violation Notice',
            'Distribution Agreement',
            'Reseller Agreement',
            'Custom Agreement',
        ];

        foreach ($types as $name) {
            ContractType::firstOrCreate(
                ['slug' => Str::slug($name)],
                ['name' => $name, 'is_active' => true]
            );
        }
    }
}
