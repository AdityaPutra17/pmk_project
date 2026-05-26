<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Menampilkan halaman login
     */
    public function login()
    {
        // kalau sudah login langsung ke dashboard
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }

        return view('auth.login');
    }

    /**
     * Proses login
     */
    public function loginProcess(Request $request)
    {
        // validasi input
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // data login
        $credentials = [
            'email' => $request->email,
            'password' => $request->password
        ];

        // cek login
        if (Auth::attempt($credentials)) {

            // regenerate session
            $request->session()->regenerate();

            return redirect()
                ->route('dashboard')
                ->with('success', 'Login berhasil');
        }

        // kalau gagal login
        return back()
            ->withInput()
            ->with('error', 'Email atau password salah');
    }

    /**
     * Logout user
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}