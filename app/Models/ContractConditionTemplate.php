<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class ContractConditionTemplate extends Model
{
    protected $fillable = ['title','description','condition_type','applies_to','is_active'];
    protected $casts = ['is_active'=>'boolean'];
}
