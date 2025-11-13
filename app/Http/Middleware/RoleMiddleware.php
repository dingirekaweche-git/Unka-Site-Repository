<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $roles  Roles separated by | (e.g. corporate|system_admin)
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $roles)
    {
        // Redirect to login if not authenticated
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();
        $allowedRoles = explode('|', $roles); // Split roles by '|'

        // If user’s role is not in allowed list
        if (!in_array($user->role, $allowedRoles)) {
            // You can change this to a redirect if you prefer
            abort(403, 'Unauthorized Access');
        }

        return $next($request);
    }
}
