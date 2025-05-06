<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User; // Sesuaikan jika nama model kamu masih UserModel
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new User(); // Ganti dengan UserModel jika belum rename
    }

    public function registerForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        if ($request->isMethod('post')) {
            $validated = $request->validate([
                'username' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'password' => 'required|min:6',
                'role' => 'required'
            ]);

            $result = $this->userModel->register(
                $validated['username'],
                $validated['email'],
                $validated['password'],
                $validated['role']
            );

            if ($result !== true) {
                return back()->withInput()->with('error', $result);
            }

            return redirect()->route('login.form')->with('success', 'Registrasi berhasil! Silakan login.');
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

            $user = $this->userModel->login($credentials['username'], $credentials['password']);

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
