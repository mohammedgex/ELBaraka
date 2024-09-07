<?php

namespace App\Http\Controllers;

use App\Models\RepresentativePaymentRequest;
use Illuminate\Http\Request;

class RepresentativePaymentRequestController extends Controller
{
    // Store a new representative payment request
    public function store(Request $request)
    {
        $request->validate([
            'address_text' => 'required',
            'address_map' => 'required',
            'date' => 'required',
            'time' => 'required',
            'representative_fee' => 'required',
        ]);

        // Get the authenticated user
        $user = $request->user();

        // Create a new payment request with the authenticated user's ID
        $paymentRequest = RepresentativePaymentRequest::create([
            'user_id' => $user->id,
            'address_text' => $request->address_text,
            'address_map' => $request->address_map,
            'date' => $request->date,
            'time' => $request->time,
            'representative_fee' => $request->representative_fee,
        ]);

        return response()->json([
            'success' => true,
            'payment_request' => $paymentRequest,
        ], 201);
    }
}
