<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if (!$request->user()) {
            return redirect()->route('login');
        }

        $userRole = strtolower($request->user()->role);
        $requiredRole = strtolower($role);

        // Admins can access everything
        if ($userRole === 'admin') {
            return $next($request);
        }

        if ($userRole !== $requiredRole) {
            abort(403, 'Unauthorized action.');
        }

        return $next($request);
    }
}
