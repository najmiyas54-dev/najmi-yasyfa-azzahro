<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function showStudentRegister()
    {
        return view('student.register');
    }

    public function studentRegister(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'nisn' => 'required|string|max:20|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        User::create([
            'name' => $request->name,
            'nama' => $request->name,
            'username' => $request->email,
            'email' => $request->email,
            'nisn' => $request->nisn,
            'role' => 'siswa',
            'password' => Hash::make($request->password),
            'is_approved' => false,
        ]);

        return redirect()->route('student.login')
            ->with('success', 'Registrasi berhasil! Akun Anda sedang menunggu persetujuan admin.');
    }

    public function showGuruRegister()
    {
        return view('guru.register');
    }

    public function guruRegister(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'nip' => 'required|string|max:20|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        User::create([
            'name' => $request->name,
            'nama' => $request->name,
            'username' => $request->email,
            'email' => $request->email,
            'nip' => $request->nip,
            'role' => 'guru',
            'password' => Hash::make($request->password),
            'is_approved' => false,
        ]);

        return redirect()->route('guru.login')
            ->with('success', 'Registrasi berhasil! Akun Anda sedang menunggu persetujuan admin.');
    }
}