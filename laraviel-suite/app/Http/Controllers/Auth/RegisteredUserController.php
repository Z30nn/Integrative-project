<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // Validate the incoming request
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email'],
            'role' => ['required', 'string', 'in:super_admin,admin,cashier,guest'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        // Create the user with booking ID stored in password
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'password' => Hash::make($request->password), // Store booking ID as password
        ]);

        // Trigger the Registered event
        event(new Registered($user));

        // Check if an Admin is adding an employee or a guest is registering
        if (Auth::check() && Auth::user()->role === 'admin') {
            return redirect(route('admin', absolute: false))->with('success', "Employee {$user->name} successfully added!");
        }

        Auth::login($user);

        // Redirect based on the role
        if ($user->role == 'super_admin' || $user->role == 'admin') {
            return redirect(route('admin', absolute: false));
        } elseif ($user->role == 'cashier') {
            return redirect(route('cashier', absolute: false));
        } elseif ($user->role == 'guest') {
            return redirect(route('view-booking', absolute: false));
        }

        return redirect(route('landing', absolute: false));
    }
}
