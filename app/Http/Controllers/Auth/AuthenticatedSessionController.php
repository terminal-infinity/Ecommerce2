<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
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
    public function store(LoginRequest $request): RedirectResponse
    {
 // Validate input
 $request->validate([
    'login' => 'required|string',
    'password' => 'required|string',
]);

// Determine the login field (email, phone, or name)
$loginField = filter_var($request->login, FILTER_VALIDATE_EMAIL) ? 'email' : 
              (preg_match('/^\+?\d{10,15}$/', $request->login) ? 'phone' : 'name');

// Find the user
$user = \App\Models\User::where($loginField, $request->login)->first();

if (!$user) {
    // If no user found, throw a validation error for login
    throw ValidationException::withMessages([
        'login' => ['The provided credentials do not match our records.'],
    ]);
}

// Check the password
if (!Hash::check($request->password, $user->password)) {
    // If password is incorrect, throw a validation error for password
    throw ValidationException::withMessages([
        'password' => ['The password is incorrect.'],
    ]);
}

// Log in the user
auth()->login($user);

// Regenerate session
$request->session()->regenerate();

// Redirect based on user role
$url = match ($user->role) {
    'admin' => 'admin/dashboard',
    'agent' => 'agent/dashboard',
    'user' => '/dashboard',
    default => '/',
};

return redirect()->intended($url);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
