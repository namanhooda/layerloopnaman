<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class ContractCondition extends Model {
 protected $fillable=['contract_id','condition_title','condition_description','condition_type','is_mandatory','sort_order'];
 protected $casts=['is_mandatory'=>'boolean'];
 public function contract(){ return $this->belongsTo(Contract::class); }
}