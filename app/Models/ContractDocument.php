<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class ContractDocument extends Model {
 protected $fillable=['contract_id','document_type','original_name','file_path','mime_type','file_size','uploaded_by'];
 public function contract(){ return $this->belongsTo(Contract::class); }
}