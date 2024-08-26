<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'bus_id',
        'bus_route_id',
        'num_pilgrims',
        'num_buses',
        'umrah_company',
        'mecca_hotel_name',
        'medina_hotel_name',
        'reservation_status'
    ];



    public function arrivalDepartures()
    {
        return $this->hasMany(ArrivalDeparture::class);
    }

    public function visits()
    {
        return $this->hasMany(Visit::class);
    }

    public function internalMovements()
    {
        return $this->hasMany(InternalMovement::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function bus()
    {
        return $this->belongsTo(Bus::class);
    }

    public function busRoute()
    {
        return $this->belongsTo(busRoute::class,'bus_route_id');
    }

    public function route()
    {
        return $this->belongsTo(Route::class);
    }

    public function bookingContact()
    {
        return $this->hasMany(BookingContact::class);
    }

}
