<?php

namespace App\Services;

use App\Models\AdvancePaid;
use App\Models\AdvanceReceived;
use App\Models\AdvanceSettlement;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class AdvancePaymentService
{
    public function createSettlement(Model $advance, array $data, ?int $userId = null): AdvanceSettlement
    {
        return DB::transaction(function () use ($advance, $data, $userId) {
            $locked = $advance->newQuery()->lockForUpdate()->findOrFail($advance->getKey());
            $settled = (float) $locked->settlements()->sum('amount');
            $remaining = (float) $locked->amount - $settled;
            $amount = (float) $data['amount'];

            if ($amount <= 0 || $amount > $remaining) {
                throw ValidationException::withMessages([
                    'amount' => ['Settlement must be greater than zero and cannot exceed the remaining balance.'],
                ]);
            }

            $settlement = $locked->settlements()->create([
                ...$data,
                'created_by' => $userId,
            ]);

            $locked->refreshSettlementStatus();

            return $settlement;
        });
    }

    public function updateSettlement(AdvanceSettlement $settlement, array $data): AdvanceSettlement
    {
        return DB::transaction(function () use ($settlement, $data) {
            $lockedSettlement = AdvanceSettlement::query()->lockForUpdate()->findOrFail($settlement->id);
            $advance = $lockedSettlement->settleable()->lockForUpdate()->firstOrFail();

            $otherSettled = (float) $advance->settlements()
                ->whereKeyNot($lockedSettlement->id)
                ->sum('amount');

            if ((float) $data['amount'] <= 0 || $otherSettled + (float) $data['amount'] > (float) $advance->amount) {
                throw ValidationException::withMessages([
                    'amount' => ['The revised settlement exceeds the available advance balance.'],
                ]);
            }

            $lockedSettlement->update($data);
            $advance->refreshSettlementStatus();

            return $lockedSettlement->fresh();
        });
    }

    public function deleteSettlement(AdvanceSettlement $settlement): void
    {
        DB::transaction(function () use ($settlement) {
            $lockedSettlement = AdvanceSettlement::query()->lockForUpdate()->findOrFail($settlement->id);
            $advance = $lockedSettlement->settleable()->lockForUpdate()->firstOrFail();
            $lockedSettlement->delete();
            $advance->refreshSettlementStatus();
        });
    }

    public function updateAdvance(Model $advance, array $data): Model
    {
        return DB::transaction(function () use ($advance, $data) {
            $locked = $advance->newQuery()->lockForUpdate()->findOrFail($advance->getKey());
            $settled = (float) $locked->settlements()->sum('amount');

            if ((float) $data['amount'] < $settled) {
                throw ValidationException::withMessages([
                    'amount' => ['Advance amount cannot be less than the amount already settled.'],
                ]);
            }

            $locked->update($data);
            $locked->refreshSettlementStatus();

            return $locked->fresh();
        });
    }

    public function deleteAdvance(Model $advance): void
    {
        DB::transaction(function () use ($advance) {
            $locked = $advance->newQuery()->lockForUpdate()->findOrFail($advance->getKey());

            if ($locked->settlements()->exists()) {
                throw ValidationException::withMessages([
                    'advance' => ['This advance has settlement history. Remove or reverse settlements before deleting it.'],
                ]);
            }

            $locked->delete();
        });
    }
}
