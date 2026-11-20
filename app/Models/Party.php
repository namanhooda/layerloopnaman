<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Party extends Model
{
    protected $fillable = ['name', 'party_type', 'phone', 'email', 'address', 'partyable_type', 'partyable_id'];

    public function partyable(): MorphTo
    {
        return $this->morphTo();
    }

    public function advanceReceived(): HasMany
    {
        return $this->hasMany(AdvanceReceived::class);
    }

    public function advancePaid(): HasMany
    {
        return $this->hasMany(AdvancePaid::class);
    }
}
