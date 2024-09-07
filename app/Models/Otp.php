<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Otp extends Model
{
    use HasFactory;
    
    // Fillable fields
    protected $fillable = [
        'phone',
        'otp_code',
        'expires_at',
    ];

    // Casts for date fields
    protected $casts = [
        'expires_at' => 'datetime',
    ];
}
