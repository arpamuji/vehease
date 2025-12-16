<?php

namespace App\Http\Controllers;

use App\Enums\RoleType;
use Barryvdh\Debugbar\Facades\Debugbar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class AuthController extends Controller
{
    public function show()
    {
        return Inertia::render('Auth/Login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if (!Auth::attempt($credentials)) {
            return back()->withErrors([
                'email' => 'Please check your credentials and try again.',
            ])->onlyInput('email');
        }

        $request->session()->regenerate();
        $user = Auth::user();

        if (!in_array($user->role, RoleType::cases())) {
            return redirect()->route('auth.show')->with('error', 'Please try login again.');
        }

        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }
        if ($user->isManager()) {
            return redirect()->route('manager.dashboard');
        }
        if ($user->isStaff()) {
            return redirect()->route('staff.dashboard');
        }
    }

    public function logout(Request $request)
    {
        // Handle user logout
    }
}
