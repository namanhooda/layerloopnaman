<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class ContractParty extends Model {
 protected $fillable=['contract_id','party_role','name','company_name','email','phone','address','signature_path','signed_at'];
 protected $casts=['signed_at'=>'datetime'];
 public function contract(){ return $this->belongsTo(Contract::class); }
}