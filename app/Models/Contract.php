<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\{BelongsTo, HasMany};

class Contract extends Model
{
    protected $fillable = [
        'contract_number','contract_type_id','contract_template_id','parent_contract_id','version',
        'title','business_unit','party_type','party_name','company_name','email','phone','address',
        'city','state','country','start_date','end_date','territory_type','territory_details',
        'is_exclusive','payment_amount','payment_type','payment_terms','description','scope_of_work',
        'special_restrictions','status','signed_at','issued_at','terminated_at','termination_reason',
        'created_by','approved_by','internal_notes'
    ];

    protected $casts = [
        'territory_details' => 'array', 'is_exclusive' => 'boolean',
        'start_date' => 'date', 'end_date' => 'date',
        'signed_at' => 'datetime', 'issued_at' => 'datetime', 'terminated_at' => 'datetime',
        'payment_amount' => 'decimal:2',
    ];

    public function type(): BelongsTo { return $this->belongsTo(ContractType::class, 'contract_type_id'); }
    public function template(): BelongsTo { return $this->belongsTo(ContractTemplate::class, 'contract_template_id'); }
    public function parent(): BelongsTo { return $this->belongsTo(self::class, 'parent_contract_id'); }
    public function products(): HasMany { return $this->hasMany(ContractProduct::class); }
    public function conditions(): HasMany { return $this->hasMany(ContractCondition::class)->orderBy('sort_order'); }
    public function parties(): HasMany { return $this->hasMany(ContractParty::class); }
    public function documents(): HasMany { return $this->hasMany(ContractDocument::class); }
    public function notices(): HasMany { return $this->hasMany(ContractNotice::class); }
    public function activityLogs(): HasMany { return $this->hasMany(ContractActivityLog::class); }

    public function logActivity(string $action, ?string $description = null, array $old = [], array $new = []): void
    {
        $this->activityLogs()->create([
            'user_id' => auth()->id(),
            'action' => $action,
            'description' => $description,
            'old_values' => $old ?: null,
            'new_values' => $new ?: null,
            'ip_address' => request()->ip(),
        ]);
    }

    public function isEditable(): bool
    {
        return ! in_array($this->status, ['signed', 'active', 'expired', 'terminated'], true);
    }
}
