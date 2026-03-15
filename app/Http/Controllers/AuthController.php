<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use App\Models\User;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (Auth::check()) {
            return redirect()->route('shop.index');
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Rate limiting: max 5 attempts per minute per IP
        $key = 'login.' . $request->ip();
        if (RateLimiter::tooManyAttempts($key, 5)) {
            $seconds = RateLimiter::availableIn($key);
            return back()->withErrors([
                'email' => 'Too many login attempts. Please try again in ' . $seconds . ' seconds.',
            ])->withInput();
        }

        $credentials = $request->only('email', 'password');
        $remember = $request->has('remember');

        if (Auth::attempt($credentials, $remember)) {
            RateLimiter::clear($key);
            $request->session()->regenerate();

            // Redirect admin to dashboard, regular users to profile
            $default = Auth::user()->isAdmin()
                ? route('dashboard.index')
                : route('profile.show');

            return redirect()->intended($default);
        }

        RateLimiter::hit($key, 60); // Increment attempt, decay after 60 seconds

        return back()->withErrors([
            'email' => 'Invalid credentials.',
        ])->withInput();
    }

    public function showRegister()
    {
        if (Auth::check()) {
            return redirect()->route('shop.index');
        }
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => strtolower($request->email),
            'password' => Hash::make($request->password),
            'role' => 'user',
        ]);

        Auth::login($user);

        return redirect()->route('shop.index');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('shop.index');
    }
}
