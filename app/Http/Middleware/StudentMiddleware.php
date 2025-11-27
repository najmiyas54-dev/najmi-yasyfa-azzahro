<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check()) {
            return redirect()->route('student.login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $user = Auth::user();
        
        if ($user->role !== 'siswa') {
            Auth::logout();
            return redirect()->route('student.login')->withErrors(['email' => 'Akses ditolak. Hanya siswa yang dapat mengakses halaman ini.']);
        }

        // Check if user is approved
        if (!$user->is_approved) {
            Auth::logout();
            return redirect()->route('student.login')->withErrors(['email' => 'Akun Anda belum disetujui oleh admin.']);
        }

        return $next($request);
    }
}