<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class MemberAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Allow authenticated admin/organizer users to bypass member gate
        if (auth()->check()) {
            return $next($request);
        }

        // Allow if session has member ID OR if request contains access_code (for registration flow)
        if (!session()->has('member_access_id') && !$request->has('access_code')) {
            return redirect()->route('member.gate')->with('error', 'Please enter your Member ID to access this page.');
        }

        return $next($request);
    }
}
