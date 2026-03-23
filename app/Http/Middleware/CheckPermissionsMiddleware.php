<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class CheckPermissionsMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param Closure(Request): (Response) $next
     */
    public function handle(Request $request, Closure $next, string $module, string $can): Response
    {
//        dd(Auth::check());
        if (Auth::check()) {
            if (Gate::allows("$module.$can", Auth::user())) {
                return $next($request);
            } else {
                // User doesn't have permission, handle accordingly
                abort(403, 'Unauthorized action.');
            }
        } else {
            // User is not authenticated
            return redirect()->route('admin.login')->with('error', 'Please login to continue.');
        }
    }
}
