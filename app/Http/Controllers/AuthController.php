<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function registerForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        if ($request->isMethod('post')) {
            $validated = $request->validate([
                'username' => 'required|string|max:255|unique:users',
                'email' => 'required|email|max:255|unique:users',
                'password' => 'required|min:6',
                'role' => 'required'
            ]);

            $result = User::register(
                $validated['username'],
                $validated['email'],
                $validated['password'],
                $validated['role']
            );

            if ($result !== true) {
                return back()->withInput()->with('error', $result);
            }

            return redirect()->route('login')->with('success', 'Registrasi berhasil! Silakan login.');
        }

        return view('auth.register');
    }

    public function loginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        if ($request->isMethod('post')) {
            $credentials = $request->only('username', 'password');

            $user = User::login($credentials['username'], $credentials['password']);
            // dd($user);

            if ($user) {
                session(['user' => $user]);
                return redirect()->route('home')->with('success', 'Login berhasil!');
            } else {
                return back()->withInput()->with('error', 'Login gagal! Username atau password salah.');
            }
        }

        return view('auth.login');
    }

    public function logout()
    {
        Session::flush();
        return redirect()->route('home');
    }
}