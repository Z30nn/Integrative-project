<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(Request $request): RedirectResponse
    {
        // Validate the incoming request data
        $credentials = $request->validate([
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'string'],
        ]);


        // Retrieve the user by email (allow duplicates, so we fetch all matches)
        $users = User::where('email', $credentials['email'])->get();

        // Check each user to see if the password matches
        foreach ($users as $user) {
            if (Hash::check($credentials['password'], $user->password)) {
                // Log in the matched user
                Auth::login($user);

                $request->session()->regenerate();

                // Redirect based on the user's role
                if ($user->role == 'admin') {
                    return redirect()->intended(route('admin', absolute: false));
                } elseif ($user->role == 'cashier') {
                    return redirect()->intended(route('cashier', absolute: false));
                } elseif ($user->role == 'guest') {
                    $password = $credentials['password'];
                    session(['password' => $password]);
                    return redirect()->intended(route('view-booking', absolute: false));
                }
            }
        }

        // If no matching user is found, redirect back with an error
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->intended(route('landing', absolute: false));
    }

    public function registerEmployee(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->intended(route('register', absolute: false));
    }
}
