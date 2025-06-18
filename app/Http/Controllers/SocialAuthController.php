<?php

namespace App\Http\Controllers;

use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;

class SocialAuthController extends Controller
{
    public function callback($provider)
    {
        $socialUser = Socialite::driver($provider)->stateless()->user();

        $user = User::where('email', $socialUser->getEmail())->first();
        // dd($user);

        if (!$user) {
            $user = User::create([
                'name' => $socialUser->getName(),
                'email' => $socialUser->getEmail(),
                'username' => explode('@', $socialUser->getEmail())[0],
                'password' => bcrypt('oauth_' . $provider),
                'role' => 'user', // default role
            ]);
        }

        Auth::login($user);

        Session::put('user_id', $user->id);
        Session::put('username', $user->username);
        Session::put('role', $user->role);

        return redirect()->route($user->role === 'admin' ? 'auth.profile' : 'home');
    }

    public function redirect($provider)
    {
        return Socialite::driver($provider)->redirect();
    }
}
