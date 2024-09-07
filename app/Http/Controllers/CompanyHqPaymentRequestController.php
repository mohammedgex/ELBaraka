<?php

namespace App\Http\Controllers;

use App\Models\CompanyHqPaymentRequest;
use Illuminate\Http\Request;

class CompanyHqPaymentRequestController extends Controller
{
    public function store(Request $request)
    {
        $user = $request->user();

        $request->validate([
            'user_id' => 'required',
            // Add any other necessary fields
        ]);

        $paymentRequest = CompanyHqPaymentRequest::create([
            'user_id' => $user->id
        ]);

        return response()->json([
            'success' => true,
            'payment_request' => $paymentRequest,
        ], 201);
    }
}
