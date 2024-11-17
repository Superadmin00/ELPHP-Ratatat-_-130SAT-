<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $fields = $request->validate([
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed',
            'user_first_name' => 'required',
            'user_last_name' => 'required'
        ]);

        $user = User::create($fields);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'user' => $user,
            'token' => $token
        ], 200);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users',
            'password' => 'required'
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'Invalid credentials.'
            ], 401);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'user' => $user,
            'token' => $token
        ], 200);
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json([
            'message' => 'Logged out successfully.'
        ], 200);
    }

    public function editProfile(Request $request)
    {
        $user = $request->user();

        $fields = $request->validate([
            'user_first_name' => 'sometimes|string|max:255',
            'user_mid_name' => 'sometimes|string|max:255',
            'user_last_name' => 'sometimes|string|max:255',
            'user_profile_pic_ref' => 'sometimes|image|mimes:jpeg,png,jpg,svg|max:512'
        ]);

        if ($request->hasFile('user_profile_pic_ref')) {
            if ($user->user_profile_pic_ref) {
                $existingImagePath = str_replace('/storage/', '', $user->user_profile_pic_ref);
                Storage::disk('public')->delete($existingImagePath);
            }

            $imagePath = $request->file('user_profile_pic_ref')->store("profile-pics/{$user->id}", 'public');
            $fields['user_profile_pic_ref'] = '/storage/' . $imagePath;
        }

        $user->update($fields);

        return response()->json([
            'message' => 'Profile updated successfully.',
            'user' => $user
        ], 201);
    }
    public function forgotPassword(Request $request)
    {
        // Validate the request input
        $fields = $request->validate([
            'email' => 'required|email|exists:users,email',
            'new_password' => 'required|confirmed',
        ]);

        // Find the user by email
        $user = User::where('email', $fields['email'])->first();

        // Update the user's password
        $user->update([
            'password' => Hash::make($fields['new_password']),
        ]);

        // Revoke all existing tokens (force the user to log in again)
        $user->tokens()->delete();

        return response()->json([
            'message' => 'Password reset successfully. Please log in with your new password.',
        ], 200);
    }
}
