<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ContractTemplate extends Model
{
    protected $fillable = ['contract_type_id', 'name', 'business_unit', 'body', 'default_conditions', 'is_active'];
    protected $casts = ['default_conditions' => 'array', 'is_active' => 'boolean'];

    public function contractType(): BelongsTo { return $this->belongsTo(ContractType::class); }
}
