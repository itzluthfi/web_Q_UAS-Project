<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'username',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Mutator untuk mengenkripsi password saat disimpan.
     */
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }

    /**
     * Static method untuk registrasi user.
     */
    public static function register($username, $email, $password, $role)
    {
        try {
            self::create([
                'username' => $username,
                'email' => $email,
                'password' => $password, // otomatis dienkripsi oleh mutator
                'role' => $role,
            ]);
            return true;
        } catch (\Exception $e) {
            return 'Registrasi gagal: ' . $e->getMessage();
        }
    }

    /**
     * Static method untuk login user.
     */
    public static function login($username, $password)
{
    $user = self::where('username', $username)->first();

    if ($user && Hash::check($password, $user->password)) {
        return $user;
    }

    return false;
}
}