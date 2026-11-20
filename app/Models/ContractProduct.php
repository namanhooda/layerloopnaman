<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class ContractProduct extends Model {
 protected $fillable=['contract_id','product_id','product_name','product_code','stl_file_name','restriction_type','remarks'];
 public function contract(){ return $this->belongsTo(Contract::class); }
}