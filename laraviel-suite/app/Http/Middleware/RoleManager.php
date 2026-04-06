<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class RoleManager
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if(!Auth::check()){
            return redirect()->route('login');
        }

        $userRole = Auth::user()->role;

        // Check if user's role is in the allowed roles list
        if (in_array($userRole, $roles)) {
            return $next($request);
        }

        // Redirect to appropriate dashboard based on their role
        if ($userRole === 'admin') {
            return redirect()->route('admin');
        } elseif ($userRole === 'cashier') {
            return redirect()->route('cashier');
        }

        return redirect()->route('landing');
    }
}
