<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;

    protected $fillable=[
        'user_id', 
        'magazine_id', 
        'download_token',
        'expires_at'

    ];

    public function isValid()
    {
        return $this->expires_at > now() && 
               $this->download_count < 5; // Limit downloads
    }


}
