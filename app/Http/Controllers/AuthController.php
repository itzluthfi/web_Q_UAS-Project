<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth; // <--- WAJIB!
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;
use App\Notifications\UserNotification;

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


    public function kirimNotifikasi()
    {
        $user = Auth::user(); // Gunakan user yang sedang login

        if (!$user) {
            return 'User tidak ditemukan.';
        }

        $pesan = "Anda telah berhasil login sebagai $user->username";
        $user->notify(new UserNotification($pesan));

        return "Notifikasi email berhasil dikirim ke $user->email";
    }
    public function profile()
    {
        $users = User::all();
        return view('auth.profile', compact('users'));
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
            $cek = $this->kirimNotifikasi();
            if (!$cek) {
                return $cek;
            }
            if ($user->role === 'admin') {
                Session::put('user_id', $user->id);
                Session::put('username', $user->username);
                Session::put('role', $user->role);
                return redirect()->route('auth.profile');
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


    public function uploadProfileImage(Request $request)
    {
        // dd($request->all());
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

    public function favoriteList()
    {
        $user = Auth::user();
        $favorites = $user->favoriteAnimes()->get();
        return view('user.anime.animeFavoriteList', compact('favorites'));
    }

    public function favoriteListDashboard()
    {
        $user = Auth::user();
        $favorites = $user->favoriteAnimes()->get();
        return view('auth.animeFavoriteList', compact('favorites'));
    }

    public function addUser(Request $request)
    {
        try {
            // Validasi input (tanpa role & status)
            $validated = $request->validate([
                'username' => 'required|string|max:255|unique:users',
                'email' => 'required|email|max:255|unique:users',
                'password' => 'required|string|min:1|confirmed',
                'role' => 'required|in:user,moderator,admin', // Tambahkan validasi role
            ]);

            // Password di-hash
            $hashedPassword = Hash::make($request->password);

            // Simpan user baru dengan hanya 5 field yang tersedia di tabel users
            User::create([
                'username' => $request->username,
                'email' => $request->email,
                'password' => $hashedPassword,
                'profile_image_url' => null, // tidak ada upload dari modal
                'role' => $request->role, // default role seperti di register
            ]);

            return redirect()->back()->with('success', 'Pengguna berhasil ditambahkan!');

        } catch (ValidationException $e) {
            // Debugging error validasi
            dd($e->validator->errors());
        }
    }


    public function update(Request $request, $id)
    {
        // dd($request->all());
        
        // Validasi input - PERBAIKAN: Hapus 'confirmed' karena tidak ada password_confirmation
        $validated = $request->validate([
            'username' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $id,
            'password' => 'nullable|string|min:4', // Ubah dari min:1 ke min:4, hapus confirmed
            'role' => 'required|in:user,moderator,admin',
        ]);

        // Cari user atau error 404
        $user = User::findOrFail($id);

        // dd($user);
        
        // Siapkan data untuk update (tanpa profile_image_url)
        $data = $request->only(['username', 'email', 'role']);

        // Update password hanya jika diisi
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        // dd($data);
        
        // JANGAN ubah profile_image_url sama sekali

        // PERBAIKAN: Update user dengan error handling
        try {
            $user->fill($data);
            $saved = $user->save();
            
            // Debug untuk memastikan data tersimpan
            // dd([
            //     'saved' => $saved,
            //     'changes' => $user->getChanges(),
            //     'user_after' => $user->fresh()->toArray() // Ambil data terbaru dari DB
            // ]);
            
        } catch (\Exception $e) {
            // Log error jika terjadi masalah
            // \Log::error('Error updating user: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat memperbarui data.')
                ->withInput();
        }

        return redirect()->back()->with('success', 'Data pengguna berhasil diperbarui.');
    }

    public function destroy(Request $request, $id)
    {
        // dd($request->all());
        // Cari user atau error 404
        $user = User::findOrFail($id);

        // Hapus user dari database (permanent delete)
        $user->delete();

        // Redirect dengan pesan sukses
        return redirect()->back()->with('success', 'Pengguna berhasil dihapus.');
    }

}
