<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Route extends Model
{
    use HasFactory;
    protected $fillable = ['name','type'];

   
    public function buses()
    {
        return $this->belongsToMany(Bus::class, 'bus_routes')->withPivot('price');
    }

    public function route()
    {
        return $this->belongsTo(Route::class);
    }

    
    public function busRoutes()
    {
        return $this->belongsTo(BusRoute::class);
    }


}
