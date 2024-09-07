<?php

namespace App\Http\Controllers;
use App\Models\Bus;

class BusController extends Controller
{
    public function getBusesWithRoutes()
    {
        // Fetch buses with related routes
        $buses = Bus::with('routes')->get();

        return response()->json($buses);
    }
}
