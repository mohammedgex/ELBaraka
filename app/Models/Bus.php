<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bus extends Model
{
    use HasFactory;
    protected $fillable = [
        'type', 'images', 'category_id', 'capacity', 'luggage_capacity', 
        'max_speed', 'is_available', 'features'
    ];

    protected $casts = [
        'images' => 'array',
        'features' => 'array',
        'is_available' => 'boolean',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function routes()
    {
        return $this->belongsToMany(Route::class, 'bus_routes')->withPivot('price');
    }

    public function busRoutes()
    {
        return $this->hasMany(BusRoute::class);
    }
    public function reservation()
    {
        return $this->hasMany(Reservation::class);
    }
}
