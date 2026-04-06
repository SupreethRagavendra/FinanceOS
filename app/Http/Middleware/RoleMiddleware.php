<?php

/**
 * RoleMiddleware - Enforces role-based access control.
 *
 * Checks that the user is authenticated, has an active status,
 * and possesses one of the allowed roles. Returns a 403 error
 * page if any check fails.
 */

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  ...$roles  Allowed roles (e.g., 'admin', 'analyst', 'viewer')
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        // Check if user is authenticated
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $user = auth()->user();

        // Check if user account is active
        if ($user->status !== 'active') {
            auth()->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect()->route('login')
                ->withErrors(['email' => 'Your account has been deactivated. Please contact an administrator.']);
        }

        // Check if user has one of the allowed roles
        if (!in_array($user->role, $roles)) {
            return response()->view('errors.403', [
                'userRole' => $user->role,
                'requiredRoles' => $roles,
            ], 403);
        }

        return $next($request);
    }
}
