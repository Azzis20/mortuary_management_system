<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\Package;
use App\Services\UserRedirectService;  // ⭐ ADD THIS

class AuthController extends Controller
{
    public function landingPage()
    {
        // Redirect if already logged in
        if (Auth::check()) {
            return UserRedirectService::redirectToDashboard(Auth::user());
        }

        // Get most popular package
        $mostPopular = Package::select('package_name')
            ->selectRaw('count(*) as total')
            ->groupBy('package_name')
            ->orderByDesc('total')
            ->value('package_name') ?? 'Standard Package';

        return view('landingpage', compact('mostPopular'));
    }

    public function showRegister()
    {
        if (Auth::check()) {
            return UserRedirectService::redirectToDashboard(Auth::user());
        }
        
        return view('pages.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|min:3|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'terms' => 'accepted',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'accountType' => 'client',
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        return UserRedirectService::redirectToDashboard($user)
            ->with('success', 'Registration successful! Welcome to Peaceful Rest.');
    }

    public function showLogin()
    {
        if (Auth::check()) {
            return UserRedirectService::redirectToDashboard(Auth::user());
        }
        
        return view('pages.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            return UserRedirectService::redirectToDashboard(Auth::user())
                ->with('success', 'Welcome back!');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')
            ->with('success', 'You have been logged out successfully.');
    }
}