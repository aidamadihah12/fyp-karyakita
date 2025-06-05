<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Password;

class AuthController extends Controller
{
    /**
     * Handle user registration (default role: Customer).
     */
    public function register(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email',
            'phone' => 'nullable|string|max:15',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = User::create([
            'first_name' => $validated['first_name'],
            'last_name'  => $validated['last_name'],
            'name'       => $validated['first_name'] . ' ' . $validated['last_name'],
            'email'      => $validated['email'],
            'phone'      => $validated['phone'],
            'user_role'  => 'Customer',
            'password'   => Hash::make($validated['password']),
        ]);

        $user->assignRole('Customer');

        $token = $user->createToken('MyApp')->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'Customer registered successfully',
            'user' => $user,
            'token' => $token,
        ], 201);
    }

    /**
     * Handle user login.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        $token = $user->createToken('MyApp')->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'Login successful',
            'user' => $user,
            'token' => $token,
        ]);
    }

    /**
     * Handle user logout (invalidate all tokens).
     */
    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json(['message' => 'Logged out successfully']);
    }

    /**
     * Get the authenticated user.
     */
    public function user(Request $request)
    {
        return response()->json($request->user());
    }

    /**
     * Send password reset link (via email).
     */
    public function sendResetLink(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink($request->only('email'));

        return response()->json([
            'message' => __($status),
            'success' => $status === Password::RESET_LINK_SENT
        ], $status === Password::RESET_LINK_SENT ? 200 : 400);
    }

    /**
     * Handle password reset.
     */
    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:6',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                ])->save();

                Auth::login($user);
            }
        );

        return response()->json([
            'message' => __($status),
            'success' => $status === Password::PASSWORD_RESET
        ], $status === Password::PASSWORD_RESET ? 200 : 400);
    }
}
