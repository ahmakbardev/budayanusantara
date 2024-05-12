<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        if (Auth::check()) {
            // Jika sudah login, arahkan ke halaman sesuai role_id
            return redirect()->route('user.index');
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            // Jika berhasil login, arahkan ke halaman sesuai role_id
            return redirect()->route(Auth::user()->role->name . '.index');
        }

        // dd(Auth::user()->role_id);

        return redirect()->route('login')->with('error', 'Invalid credentials');
    }

    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        // Validasi data yang diterima dari form registrasi
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users|max:255',
            'password' => 'required|string|min:8|confirmed',
        ], [
            'name.required' => 'Nama harus diisi.',
            'email.required' => 'Email harus diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah digunakan.',
            'password.required' => 'Password harus diisi.',
            'password.min' => 'Password minimal terdiri dari :min karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.'
        ]);

        // Simpan data pengguna ke dalam database
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Lakukan proses autentikasi untuk langsung login setelah registrasi
        auth()->login($user);

        // Redirect ke halaman sesuai kebutuhan setelah registrasi
        return redirect('/');
    }


    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
