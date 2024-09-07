<?php

namespace App\Http\Controllers;

use App\Models\ArrivalDeparture;
use App\Models\InternalMovement;
use App\Models\LocalNotification;
use App\Models\Reservation;
use App\Models\Visit;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    // Method to get all reservations for the authenticated user
    public function getUserReservations()
    {
        $user = auth()->user();

        // Retrieve all reservations associated with the current user
        $reservations = Reservation::where('user_id', $user->id)->with(['payments', 'arrivalDepartures', 'visits', 'internalMovements', 'bus', 'busRoute', 'bookingContact'])->get();

        return response()->json([
            'success' => true,
            'reservations' => $reservations,
        ], 200);
    }

    // Method to create a new reservation
    public function createReservation(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'bus_id' => 'required',
            'bus_route_id' => 'required',
            'num_pilgrims' => 'required',
            'num_buses' => 'required',
            'umrah_company' => 'required',
            'mecca_hotel_name' => 'required',
            'medina_hotel_name' => 'required',
        ]);

        // Create the reservation
        $reservation = Reservation::create([
            'user_id' => auth()->id(), // Set the user_id to the authenticated user's ID
            'bus_id' => $request->bus_id,
            'bus_route_id' => $request->bus_route_id,
            'num_pilgrims' => $request->num_pilgrims,
            'num_buses' => $request->num_buses,
            'umrah_company' => $request->umrah_company,
            'mecca_hotel_name' => $request->mecca_hotel_name,
            'medina_hotel_name' => $request->medina_hotel_name,
            'reservation_status' => 'جاري المعالجة',
        ]);

        LocalNotification::create([
            'user_id' => auth()->id(),
            'title' => 'تمت عملية حجز',
            'content' => 'تم بنجاح حجز وسيلة نقل ',
        ]);

        return response()->json([
            'success' => true,
            'reservation' => $reservation,
        ], 201);
    }

    // ArrivalDeparture
    public function storeArrivalDeparture(Request $request)
    {
        $request->validate([
            'reservation_id' => 'required',
            'date' => 'required',
            'time' => 'required',
            'flight_number' => 'required',
            'airline' => 'required',
            'type' => 'required',
        ]);

        $arrivalDeparture = ArrivalDeparture::create($request->all());

        return response()->json([
            'success' => true,
            'arrival_departure' => $arrivalDeparture,
        ], 201);
    }

    // Visit
    public function storeVisit(Request $request)
    {
        $request->validate([
            'reservation_id' => 'required',
            'visit_date' => 'required',
            'from_place' => 'required',
            'to_place' => 'required',
            'movement_time' => 'required',
            'bus_arrival_time' => 'required',
        ]);

        $visit = Visit::create($request->all());

        return response()->json([
            'success' => true,
            'visit' => $visit,
        ], 201);
    }


    // InternalMovement
    public function storeInternalMovement(Request $request)
    {
        $request->validate([
            'reservation_id' => 'required',
            'movement_date' => 'required',
            'from_place' => 'required',
            'to_place' => 'required',
            'movement_time' => 'required',
            'bus_arrival_time' => 'required',
        ]);

        $internalMovement = InternalMovement::create($request->all());

        return response()->json([
            'success' => true,
            'internal_movement' => $internalMovement,
        ], 201);
    }

    // Cancel a reservation
    public function cancelReservation(Request $request, $reservationId)
    {
        // Validate the request
        $reservation = Reservation::find($reservationId);
        
        if (!$reservation) {
            return response()->json([
                'error' => 'Reservation not found'
            ], 404);
        }

        // Check if there's any ArrivalDeparture with type "وصول" and date <= 48 hours from now
        $arrivalDeparture = ArrivalDeparture::where('reservation_id', $reservationId)
            ->where('type', 'وصول')
            ->first();

        if ($arrivalDeparture) {
            // Check if the date of ArrivalDeparture is within 48 hours from now
            if ($arrivalDeparture->date->lessThanOrEqualTo(Carbon::now()->addHours(48) /* 4-9 */)) {
                return response()->json([
                    'error' => 'You cannot cancel the reservation because the arrival is within 48 hours'
                ], 400);
            }
        }

        // Perform cancellation (mark as canceled or delete)
        // Example: updating the reservation status to "canceled"
        $reservation->reservation_status = 'ملغي';
        $reservation->save();

        return response()->json([
            'success' => true,
            'message' => 'Cancellation request sent successfully'
        ]);
    }

}
