<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'identifiant' => ['required', 'string'],
            'password' => ['required'],
        ]);

        if (Auth::attempt(['email' => $request->identifiant, 'password' => $request->password])) {
            $request->session()->regenerate();

            if (Auth::user()->role === 'admin') {
                return redirect()->intended('/admin/dashboard');
            } elseif (Auth::user()->role === 'verificateur') {
                return redirect()->intended('/verificateur/dashboard');
            } else {
                return redirect()->intended('/soldat/dashboard');
            }
        }

        return back()->withErrors([
            'identifiant' => 'Les identifiants sont incorrects.',
        ])->onlyInput('identifiant');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}