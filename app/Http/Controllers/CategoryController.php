<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        // Get all categories with related buses
        $categories = Category::with('buses')->get();

        // Return the data as a JSON response
        return response()->json($categories);
    }
}
