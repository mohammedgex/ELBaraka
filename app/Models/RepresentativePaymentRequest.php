<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RepresentativePaymentRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'address_text',
        'address_map',
        'date',
        'time',
        'representative_fee',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
