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
    public function handle(Request $request, Closure $next, $role): Response
    {
        if(!Auth::check ()){
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $authUserType = Auth::user()->role;

        switch($role) {
            case 'admin':
                if($authUserType == 'admin') {
                    return $next($request);
                }
                break;
            case 'cashier':
                if($authUserType == 'cashier') {
                    return $next($request);
                }
                break;
        }

        switch($authUserType) {
            case 'admin':
                return redirect()->route('admin');

            case 'cashier':
                return redirect()->route('cashier');
            
            case 'guest':
                return redirect()->route('offers');
        }

        return redirect()->route('auth.login');

    }
}
