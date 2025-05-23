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

    public function profile()
    {
        $users = User::all();
        return view('user.profile', compact('users'));
    }


    public function register(Request $request)
    {
        $validated = $request->validate([
        'username' => 'required|string|max:255',
        'email' => 'required|email|unique:users',
        'password' => 'required|min:6|confirmed',
        'profile_image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
         ]);
       
        if (!$validated) {
            return back()->with('error', 'Registrasi gagal. Mohon periksa input Anda.')
                         ->withErrors($validated)
                         ->withInput();
        }

        $imagePath = null;
        if ($request->hasFile('profile_image')) {
            $imagePath = $request->file('profile_image')->store('profile_images', 'public');
        }

        // Simpan user
        User::create([
            'username' => $request->username,
            'profile_image_url' => $imagePath,
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
            Session::put('user_id', $user->id);
            Session::put('username', $user->username);
            Session::put('role', $user->role);
            return redirect()->route('admin.dashboard');
        } else {
            Session::put('user_id', $user->id);
            Session::put('username', $user->username);
            Session::put('role', $user->role);
            // dd(session()->all());
            return redirect()->route('home');
        }
    }

    return back()->withErrors([
        'username' => 'Username atau password salah.',
    ]);
}


public function uploadProfileImage(Request $request){
    $user = Auth::user();

    if (!$user instanceof User) {
        return back()->withErrors('User tidak ditemukan atau bukan model Eloquent');
    }

    if ($request->hasFile('profile_image')) {
        $imagePath = $request->file('profile_image')->store('profile_images', 'public');
        $user->profile_image_url = $imagePath;
        $user->save(); // Ini akan berhasil
    }

    return back();
}


    public function logout()
    {
        Session::flush();
        return redirect()->route('home');
    }
}