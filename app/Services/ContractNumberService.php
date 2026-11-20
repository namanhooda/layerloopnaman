<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class ContractNumberService
{
    public function next(): string
    {
        return DB::transaction(function () {
            $prefix = config('layerloop-contracts.contract_prefix', 'LL-CON');
            $year = now()->format('Y');
            $pattern = "{$prefix}-{$year}-";
            $last = DB::table('contracts')
                ->where('contract_number', 'like', $pattern.'%')
                ->lockForUpdate()
                ->orderByDesc('id')
                ->value('contract_number');

            $sequence = $last ? ((int) substr($last, -4)) + 1 : 1;
            return $pattern.str_pad((string) $sequence, 4, '0', STR_PAD_LEFT);
        });
    }
}
