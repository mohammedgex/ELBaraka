<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CompanyHqPaymentRequestController;
use App\Http\Controllers\LocalNotificationController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\RepresentativePaymentRequestController;
use App\Http\Controllers\ReservationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BusController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::post('/register', [AuthController::class, 'register']);
Route::post('/verify-otp', [AuthController::class, 'verifyOtp']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);
Route::post('/reset-password', [AuthController::class, 'resetPassword']);
Route::middleware('auth:sanctum')->get('/user', [AuthController::class, 'getUserData']);

// get buses
Route::get('/buses-with-routes', [BusController::class, 'getBusesWithRoutes']);
Route::get('/categories/{categoryId}', [BusController::class, 'getBusesByCategory']);

// get category
Route::get('/categories', [CategoryController::class, 'index']);

Route::middleware('auth:sanctum')->post('/reservations/{reservationId}/cancel', [ReservationController::class, 'cancelReservation']);


// update user profile
Route::middleware('auth:sanctum')->post('/update-profile', [AuthController::class, 'updateProfile']);

// make a reservation
Route::middleware('auth:sanctum')->post('/user/reservations', [ReservationController::class, 'createReservation']);

// get user reservations
Route::middleware('auth:sanctum')->get('/user/reservations', [ReservationController::class, 'getUserReservations']);

//cancel reservation
Route::middleware('auth:sanctum')->post('/reservations/{reservationId}/cancel', [ReservationController::class, 'cancelReservation']);

// get user payments
Route::middleware('auth:sanctum')->get('/user/payments', [PaymentController::class, 'getUserPayments']);

// make a payment
Route::middleware('auth:sanctum')->post('/user/payments', [PaymentController::class, 'addPayment']);

Route::middleware('auth:sanctum')->get('/user/notifications', [LocalNotificationController::class, 'getCurrentUserNotifications']);




// storeArrivalDeparture
Route::middleware('auth:sanctum')->post('/arrival-departures', [ReservationController::class, 'storeArrivalDeparture']);
// storeVisit
Route::middleware('auth:sanctum')->post('/visits', [ReservationController::class, 'storeVisit']);
// storeInternalMovement
Route::middleware('auth:sanctum')->post('/internal-movements', [ReservationController::class, 'storeInternalMovement']);

// get user notifications
Route::middleware('auth:sanctum')->get('/notifications', [LocalNotificationController::class, 'getCurrentUserNotifications']);

// get paymetn requests
Route::middleware('auth:sanctum')->post('/company-hq-payment-requests', [CompanyHqPaymentRequestController::class, 'store']);
Route::middleware('auth:sanctum')->post('/representative-payment-requests', [RepresentativePaymentRequestController::class, 'store']);