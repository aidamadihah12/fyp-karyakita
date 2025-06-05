<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    /**
     * Handle user registration for both web and API.
     */
public function register(Request $request)
{
    // Validate incoming request
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'phone' => 'required|string|max:15',
        'user_role' => 'required|string', // e.g., admin, staff, freelance, customer
        'password' => 'required|string|min:6|confirmed',
    ]);

    // Create user
    $user = User::create([
        'name' => $validated['name'],
        'email' => $validated['email'],
        'phone' => $validated['phone'],
        'user_role' => $validated['user_role'],
        'password' => Hash::make($validated['password']),
    ]);

    // Determine and assign the correct Spatie role
    $role = in_array(strtolower($validated['user_role']), ['admin', 'staff', 'freelance'])
        ? ucfirst(strtolower($validated['user_role']))
        : 'Customer';

    $user->assignRole($role); // This assumes roles already exist

    // If the request is API, return token
    if ($request->expectsJson()) {
        $token = $user->createToken('API Token')->plainTextToken;
        return response()->json(['user' => $user, 'token' => $token]);
    }

    // Otherwise, handle web registration redirect
    return redirect()->route('login')->with('success', 'Registration successful! Please login.');
}


    /**
     * Handle login for both web and API.
     */
    public function login(Request $request)
    {
        // Validate login credentials
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        // Attempt login
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // Redirect based on user role for web requests
            $role = Auth::user()->user_role;
            switch ($role) {
                case 'admin':
                    return redirect()->route('admin.dashboard')->with('success', 'Welcome Admin!');
                case 'staff':
                    return redirect()->route('staff.dashboard')->with('success', 'Welcome Staff!');
                case 'freelance':
                    return redirect()->route('freelance.dashboard')->with('success', 'Welcome Freelancer!');
                default:
                    return redirect()->route('home');
            }
        }

        // If it's an API request, respond with unauthorized error
        if ($request->expectsJson()) {
            $user = User::where('email', $request->email)->first();

            // Validate credentials for API
            if (!$user || !Hash::check($request->password, $user->password)) {
                return response()->json(['message' => 'Unauthorized'], 401);
            }

            // Generate API token for successful login
            $token = $user->createToken('API Token')->plainTextToken;
            return response()->json(['user' => $user, 'token' => $token]);
        }

        // If credentials are incorrect, throw validation exception
        throw ValidationException::withMessages([
            'email' => __('auth.failed'),
        ]);
    }

    /**
     * Handle user logout for both web and API.
     */
    public function logout(Request $request)
    {
        // Logout user and invalidate session for web
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Revoke the token for API requests
        if ($request->user()) {
            $request->user()->tokens->each(function ($token) {
                $token->delete();
            });
        }

        // Redirect or return response based on request type
        if ($request->expectsJson()) {
            return response()->json(['message' => 'Logged out successfully']);
        }

        return redirect()->route('login');
    }

    /**
     * Send password reset link.
     */
    public function sendResetLink(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink($request->only('email'));

        return $status === Password::RESET_LINK_SENT
            ? back()->with(['status' => __($status)])
            : back()->withErrors(['email' => __($status)]);
    }

    /**
     * Show the reset password form.
     */
    public function showResetForm($token)
    {
        return view('auth.reset-password', ['token' => $token]);
    }

    /**
     * Handle resetting the password.
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

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('login')->with('success', __($status))
            : back()->withErrors(['email' => [__($status)]]);
    }


}
