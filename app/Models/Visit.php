<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visit extends Model
{
    use HasFactory;
    protected $fillable = [
        'reservation_id', 'visit_date', 'from_place', 'to_place', 
        'movement_time', 'bus_arrival_time'
    ];

    protected $casts = [
        'visit_date' => 'date',
        // 'movement_time' => TimeCast::class,
        // 'bus_arrival_time' => TimeCast::class
    ];



    public function reservation()
    {
        return $this->belongsTo(Reservation::class);
    }
}
