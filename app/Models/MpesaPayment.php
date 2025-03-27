<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MpesaPayment extends Model
{
    use HasFactory;

    protected $table = 'mpesa_payments'; // Ensure the correct table name

    protected $fillable = [
        
        'receipt',
         'order_id',
        'name',
        'phone',
        'email',
        'amount',
        'created_at',
    ];
}
