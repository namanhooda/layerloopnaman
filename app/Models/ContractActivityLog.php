<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class ContractActivityLog extends Model {
 protected $fillable=['contract_id','user_id','action','description','old_values','new_values','ip_address'];
 protected $casts=['old_values'=>'array','new_values'=>'array'];
 public function contract(){ return $this->belongsTo(Contract::class); }
}