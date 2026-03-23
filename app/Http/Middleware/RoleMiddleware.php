<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if (! Auth::check()) {
            return redirect()->route('admin.login')->with('error', 'Please login to continue.');
        }

        $user = Auth::user();
        $hasRole = $user->roles->contains(function ($userRole) use ($role) {
            return strtolower($userRole->name) === strtolower($role);
        });

        if (! $hasRole) {
            abort(403, 'Unauthorized action.');
        }

        return $next($request);
    }
}
