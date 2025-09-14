<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WalletTransaction extends Model
{
    use HasFactory;protected $fillable = [
        'user_id',        // Reference to user (optional but useful)
        'type', // credit / debit
        'amount',         // Transaction amount
        'source',     // Order ID, Payment ID, Invoice etc.
        'description',    // Extra info
    ];

    // Relationships
    public function wallet()
    {
        return $this->belongsTo(Wallet::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
