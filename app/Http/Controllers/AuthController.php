<?php

namespace App\Http\Controllers;
use App\Models\Otp;
use App\Models\User;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:11',
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:8',
            'image' => 'required|image|max:2048',
        ]);



        $old_user_email = User::where("email", $request->email)->first();
        if ($old_user_email) {
            return response()->json([
                'error' => 'The email already exists'
            ], 400);
        }
        $old_user_phone = User::where("phone", $request->phone)->first();
        if ($old_user_phone) {
            return response()->json([
                'error' => 'Phone number already exists'
            ], 400);
        }

        $user = new User();
        $user->name = $request->name;
        $user->phone = $request->phone;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->is_active = false;
        $user->is_blocked = false;
        if ($request->has('image')) {
            $filename = Str::random(32) . "." . $request->image->getClientOriginalExtension();
            $request->image->move('uploads/', $filename);
            $user->image = $filename;
        }

        $user->save();

        $otpCode = rand(100000, 999999);
        Otp::create([
            'phone' => $request->phone,
            'otp_code' => $otpCode,
            'expires_at' => now()->addMinutes(10),
        ]);

        return response()->json([
            "success" => true,
        ]);
    }



    public function verifyOtp(Request $request)
    {
        $request->validate([
            'phone' => 'required|string|max:11',
            'otp_code' => 'required|string|max:6',
        ]);

        $otp = Otp::where('phone', $request->phone)
            ->where('otp_code', $request->otp_code)
            ->where('expires_at', '>', now())
            ->first();

        if (!$otp) {
            return response()->json(['error' => 'Invalid or expired OTP'], 422);
        }

        // Activate the user
        $user = User::where('phone', $request->phone)->first();
        $user->is_active = true;
        $user->save();

        // Delete the OTP
        $otp->delete();

        // Generate token for user
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json(['message' => 'تم تأكيد الحساب بنجاح.', 'token' => $token], 200);
    }

    // login function
    public function login(Request $request)
    {
        $request->validate([
            'phone' => 'required|string|max:11',
            'password' => 'required|string|min:8',
        ]);

        $user = User::where('phone', $request->phone)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'بيانات دخول خاطئة'], 401);
        }

        if (!$user->is_active) {
            return response()->json(['message' => 'الحساب غير مفعل.'], 401);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json(['token' => $token,'user' => $user], 200);
    }

    // forget password
    public function forgotPassword(Request $request)
    {
        $request->validate([
            'phone' => 'required|string|max:11',
        ]);

        $user = User::where('phone', $request->phone)->first();

        if (!$user) {
            return response()->json(['error' => 'رقم الهاتف غير موجود.'], 404);
        }

        // Generate OTP
        $otpCode = rand(100000, 999999);
        Otp::updateOrCreate(
            ['phone' => $request->phone],
            ['otp_code' => $otpCode, 'expires_at' => now()->addMinutes(10)]
        );

        // Send OTP via SMS or any preferred method

        return response()->json(['message' => 'تم ارسال رمز التحقق الخاص بك في رسالى نصية.',], 200);
    }

    // reset api
    public function resetPassword(Request $request)
    {
        $request->validate([
            'phone' => 'required|string|max:11',
            'otp_code' => 'required|string|max:6',
            'password' => 'required|string|min:8',
        ]);

        $otp = Otp::where('phone', $request->phone)
            ->where('otp_code', $request->otp_code)
            ->where('expires_at', '>', now())
            ->first();

        if (!$otp) {
            return response()->json(['message' => 'Invalid or expired OTP'], 422);
        }

        $user = User::where('phone', $request->phone)->first();
        $user->password = Hash::make($request->password);
        $user->save();

        $otp->delete();

        return response()->json(['message' => 'Password reset successfully'], 200);
    }

    public function getUserData(Request $request)
    {
        // Retrieve the authenticated user
        $user = Auth::user();

        // Return the user data as a JSON response
        return response()->json([
            'status' => 'success',
            'user' => $user,
        ], 200);
    }


public function updateProfile(Request $request)
{
    $user = auth()->user();

    // Validate the request data
    $request->validate([
        'name' => 'required|string|max:255',
        // 'name' => 'required|string|max:255',
        'phone' => 'required|string|max:11,' . $user->id, // Ensure phone is unique except for the current user
        'email' => 'required|email|max:2048',
    ]);

    // Update the name if it's provided and not empty
    if ($request->filled('name')) {
        $user->name = $request->name;
    }

    // Update the phone if it's provided and not empty
    if ($request->filled('phone')) {
        $user->phone = $request->phone;
    }

    // Handle the image upload if provided
    if ($request->hasFile('image')) {
        // Delete the old image if it exists
        if ($user->image) {
            \Storage::delete('uploads/' . $user->image);
        }

        // Upload and save the new image
        $filename = Str::random(32) . "." . $request->image->getClientOriginalExtension();
        $request->image->move('uploads/', $filename);
        $user->image = $filename;
    }

    // Update the phone if it's provided and not empty
    if ($request->filled('email')) {
        $user->email = $request->email;
    }


    // Save the updated user information
    $user->save();

    return response()->json([
        'success' => true,
        'message' => 'Profile updated successfully',
        'user' => $user,
    ], 200);
}


}
