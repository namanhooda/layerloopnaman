<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ContractType extends Model
{
    protected $fillable = ['name', 'slug', 'description', 'default_validity_days', 'is_active'];
    protected $casts = ['is_active' => 'boolean'];

    public function contracts(): HasMany { return $this->hasMany(Contract::class); }
    public function templates(): HasMany { return $this->hasMany(ContractTemplate::class); }
}
