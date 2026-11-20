<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class ContractNotice extends Model {
 protected $fillable=['contract_id','notice_number','notice_type','recipient_name','recipient_email','violation_description','requested_action','notice_date','response_deadline','response_details','status','resolution_date'];
 protected $casts=['notice_date'=>'date','response_deadline'=>'date','resolution_date'=>'date'];
 public function contract(){ return $this->belongsTo(Contract::class); }
}