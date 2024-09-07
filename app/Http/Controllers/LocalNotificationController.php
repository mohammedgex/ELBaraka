<?php

namespace App\Http\Controllers;
use App\Models\LocalNotification;
use Illuminate\Http\Request;

class LocalNotificationController extends Controller
{
    public function getCurrentUserNotifications(Request $request)
    {
        $user = $request->user();

        $notifications = LocalNotification::where('user_id', $user->id)->get();

        return response()->json([
            'success' => true,
            'notifications' => $notifications,
        ]);
    }
}
