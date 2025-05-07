<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth; // <--- WAJIB!
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function registerForm()
    {
        return view('auth.register');
    }

     public function loginForm()
    {
        return view('auth.login');
    }

    public function register(Request $request)
    {
       // Validasi input
        $validator = Validator::make($request->all(), [
        'username' => 'required|string|max:255|unique:users,username',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|min:6',
        ]);
       
        if ($validator->fails()) {
            return back()->with('error', 'Registrasi gagal. Mohon periksa input Anda.')
                         ->withErrors($validator)
                         ->withInput();
        }

        // Simpan user
        User::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'user', // Default role
        ]);

        // Redirect dengan pesan sukses
        return redirect()->route('login')->with('success', 'Registrasi berhasil! Silakan login.');
    }

   

 public function login(Request $request)
{
    $request->validate([
        'username' => 'required|string',
        'password' => 'required|string',
    ]);

    $credentials = $request->only('username', 'password');

    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();
        $user = Auth::user();

        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        } else {
            return redirect()->route('home');
        }
    }

    return back()->withErrors([
        'username' => 'Username atau password salah.',
    ]);
}



    public function logout()
    {
        Session::flush();
        return redirect()->route('home');
    }
}