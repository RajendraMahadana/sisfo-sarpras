<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLoginForm() {
        return view('user.login');
    }

    public function login(Request $request) {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // Cek autentikasi
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // Redirect berdasarkan role
            if (Auth::user()->role === 'admin') {
                return redirect()->route('show-dashboard-admin'); // Redirect admin ke dashboard admin
            } elseif (Auth::user()->role === 'user') {
                return redirect()->route('show-home-user'); // Redirect user ke dashboard user
            }
        }
      


        return back()->withErrors(['email' => 'Email atau password salah']);
    }

    public function logout()
    {
        Auth::logout(); // Logout user yang sedang login
        return redirect()->route('show-login')->with('success', 'Kamu sudah logout, sampai jumpaa! 🥰');
    }
}
