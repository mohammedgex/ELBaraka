<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArrivalDeparture extends Model
{
    use HasFactory;
    protected $fillable = [
        'reservation_id', 'date', 'time', 'flight_number', 'airline',
         'type'
    ];

    protected $casts = [
        'date' => 'date',
        // 'time' => TimeCast::class
    ];
    
    public function reservation()
    {
        return $this->belongsTo(Reservation::class);
    }
}
