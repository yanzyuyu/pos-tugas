<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:4',
        ]);

        if (str_contains($validated['email'], 'admin')) {
            return redirect()->route('admin.dashboard')->with('success', 'Selamat datang kembali, Admin!');
        }

        return redirect()->route('pos.index')->with('success', 'Selamat bertugas, Kasir!');
    }

    public function logout()
    {
        return redirect()->route('login');
    }
}
