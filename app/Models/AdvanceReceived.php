<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class AdvanceReceived extends Model
{
    protected $table = 'advance_received';

    protected $fillable = [
        'advance_no', 'party_id', 'advance_date', 'amount', 'status',
        'payment_mode', 'reference_no', 'remarks', 'created_by',
    ];

    protected $casts = [
        'advance_date' => 'date',
        'amount' => 'decimal:2',
    ];

    public function party(): BelongsTo
    {
        return $this->belongsTo(Party::class);
    }

    public function settlements(): MorphMany
    {
        return $this->morphMany(AdvanceSettlement::class, 'settleable');
    }

    public function getSettledAmountAttribute(): string
    {
        return number_format((float) ($this->settlements_sum_amount ?? $this->settlements()->sum('amount')), 2, '.', '');
    }

    public function getBalanceAmountAttribute(): string
    {
        return number_format(max(0, (float) $this->amount - (float) $this->settled_amount), 2, '.', '');
    }

    public function refreshSettlementStatus(): void
    {
        $settled = (float) $this->settlements()->sum('amount');
        $amount = (float) $this->amount;

        $this->forceFill([
            'status' => $settled <= 0 ? 'pending' : ($settled >= $amount ? 'fully_settled' : 'partially_settled'),
        ])->saveQuietly();
    }
}
