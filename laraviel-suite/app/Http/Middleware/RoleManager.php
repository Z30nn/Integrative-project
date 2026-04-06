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
        // 1. Check if the user is authenticated via the API guard
        if (!Auth::check()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized: Please provide a valid JWT token.'
            ], 401);
        }

        $authUserType = Auth::user()->role;

        // 2. Validate the specific role required for the route
        switch($role) {
            case 'admin':
                if($authUserType === 'admin') {
                    return $next($request);
                }
                break;
                
            case 'cashier':
                if($authUserType === 'cashier') {
                    return $next($request);
                }
                break;

            case 'guest':
                if($authUserType === 'guest') {
                    return $next($request);
                }
                break;
        }

        // 3. If the role does not match, return a Forbidden JSON response
        // In a RESTful API, we do not redirect. We tell the client they are forbidden.
        return response()->json([
            'status' => 'error',
            'message' => 'Forbidden: You do not have [' . $role . '] permissions to access this resource.',
            'user_role' => $authUserType
        ], 403);
    }
}