<?php

namespace App\Http\Controllers;

use App\Models\LocalNotification;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    // Method to get the current user's payments
    public function getUserPayments()
    {
        $user = auth()->user();

        // Retrieve all payments associated with the current user
        $payments = Payment::where('user_id', $user->id)->get();

        return response()->json([
            'success' => true,
            'payments' => $payments,
        ], 200);
    }

    // Method to add a new payment
    public function addPayment(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'reservation_id' => 'required',
            'amount' => 'required',
        ]);

        // Create a new payment for the authenticated user
        $payment = Payment::create([
            'reservation_id' => $request->reservation_id,
            'user_id' => auth()->id(), // Set the user_id to the authenticated user's ID
            'amount' => $request->amount,
            'remaining_amount' => 0, // Default to 0 if not provided
            'payment_type' => 'card',
            'payment_status' => 'تم الدفع',
        ]);

        LocalNotification::create([
            'user_id' => auth()->id(),
            'title' => 'تمت عملية دفع',
            'content' => 'تم بنجاح عملية دفع ',
        ]);

        // Return a success response with the created payment
        return response()->json([
            'success' => true,
            'payment' => $payment,
        ], 201);
    }
}