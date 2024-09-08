<?php

namespace App\Http\Controllers;
use App\Models\Bus;
use App\Models\Category;

class BusController extends Controller
{
    public function getBusesWithRoutes()
    {
        // Fetch buses with related routes
        $buses = Bus::with('routes')->get();

        return response()->json($buses);
    }

    public function getBusesByCategory($categoryId)
    {
        $category = Category::find($categoryId);

        if (!$category) {
            return response()->json(['error' => 'Category not found'], 404);
        }

        $buses = $category->buses;

        return response()->json($buses);
    }
}
