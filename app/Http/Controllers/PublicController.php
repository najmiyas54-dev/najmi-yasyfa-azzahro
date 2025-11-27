<?php

namespace App\Http\Controllers;

use App\Models\Visitor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class PublicController extends Controller
{
    public function showLogin()
    {
        return view('public.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::guard('visitor')->attempt($request->only('email', 'password'))) {
            // Update login tracking
            $visitor = Auth::guard('visitor')->user();
            $visitor->update([
                'last_login_at' => now(),
                'last_login_ip' => $request->ip(),
                'login_count' => $visitor->login_count + 1
            ]);
            
            return redirect()->intended('/')->with('success', 'Login berhasil!');
        }

        return back()->withErrors(['email' => 'Email atau password salah'])->withInput();
    }

    public function showRegister()
    {
        return view('public.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:visitors',
            'password' => 'required|min:6|confirmed'
        ]);

        Visitor::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        Auth::guard('visitor')->attempt($request->only('email', 'password'));

        return redirect('/')->with('success', 'Registrasi berhasil! Anda sudah login.');
    }

    public function logout()
    {
        Auth::guard('visitor')->logout();
        return redirect('/')->with('success', 'Logout berhasil!');
    }
}