<?php

namespace App\Services;

use App\Models\Contract;
use Illuminate\Validation\ValidationException;

class ContractExclusivityService
{
    /**
     * Conservative conflict check: same product, active-ish exclusivity,
     * intersecting dates, and same/overlapping territory scope.
     * Custom polygon/geospatial territory overlap requires a dedicated rule.
     */
    public function assertNoConflict(array $data, array $productIds = [], ?int $ignoreId = null): void
    {
        if (empty($data['is_exclusive']) || empty($productIds)) return;

        $query = Contract::query()
            ->where('is_exclusive', true)
            ->whereIn('status', ['issued', 'signed', 'active'])
            ->when($ignoreId, fn ($q) => $q->whereKeyNot($ignoreId))
            ->whereDate('start_date', '<=', $data['end_date'] ?? '9999-12-31')
            ->where(function ($q) use ($data) {
                if (!empty($data['start_date'])) $q->whereDate('end_date', '>=', $data['start_date']);
                else $q->whereNull('end_date')->orWhereDate('end_date', '>=', now()->toDateString());
            })
            ->whereHas('products', fn ($q) => $q->whereIn('product_id', $productIds));

        $territory = $data['territory_type'] ?? null;
        if ($territory) {
            $query->where('territory_type', $territory);
        }

        if ($query->exists()) {
            throw ValidationException::withMessages([
                'products' => 'An overlapping exclusive contract already exists for one or more selected products and this territory/date range. Review existing contracts before proceeding.',
            ]);
        }
    }
}
