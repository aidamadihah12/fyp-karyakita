<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (!Auth::check()) {
            return redirect('login');
        }

        $user = Auth::user();

        // Uncomment next line to debug user role and allowed roles
        // dd('User role:', $user->user_role, 'Allowed roles:', $roles);

        // Make role check case-insensitive
        $userRoleLower = strtolower($user->user_role);
        $allowedRolesLower = array_map('strtolower', $roles);

        if (in_array($userRoleLower, $allowedRolesLower)) {
            return $next($request);
        }

        abort(403, 'Unauthorized');
    }
}
