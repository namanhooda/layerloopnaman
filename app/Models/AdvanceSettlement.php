<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class AdvanceSettlement extends Model
{
    protected $fillable = [
        'settlement_date', 'amount', 'payment_mode', 'reference_no', 'remarks', 'created_by',
    ];

    protected $casts = [
        'settlement_date' => 'date',
        'amount' => 'decimal:2',
    ];

    public function settleable(): MorphTo
    {
        return $this->morphTo();
    }
}
