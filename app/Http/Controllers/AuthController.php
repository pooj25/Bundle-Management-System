<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function showLogin(): View|RedirectResponse
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }

        return view('auth.login');
    }

    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended(route('dashboard'))->with('toast', [
                'message' => 'Welcome back, ' . Auth::user()->name . '!',
                'type'    => 'success',
            ]);
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function quickLogin(string $role): RedirectResponse
    {
        $user = match ($role) {
            'supervisor' => User::updateOrCreate(
                ['email' => 'supervisor@apparel-erp.com'],
                ['name' => 'Sarah Smith', 'password' => Hash::make('password')]
            ),
            'qc' => User::updateOrCreate(
                ['email' => 'qc@apparel-erp.com'],
                ['name' => 'Robert Chen', 'password' => Hash::make('password')]
            ),
            default => User::updateOrCreate(
                ['email' => 'admin@apparel-erp.com'],
                ['name' => 'John Miller', 'password' => Hash::make('password')]
            ),
        };

        Auth::login($user, true);
        request()->session()->regenerate();

        return redirect()->route('dashboard')->with('toast', [
            'message' => 'Logged in as ' . $user->name,
            'type'    => 'success',
        ]);
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('toast', [
            'message' => 'You have been successfully logged out.',
            'type'    => 'info',
        ]);
    }
}