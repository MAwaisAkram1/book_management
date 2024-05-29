<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public static function registerUser($data) {
        return self::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' =>  Hash::make($data['password'])
        ], 201);
    }

    public static function loginUser($data) {
        $user = self::where('email', $data['email'])->first();
        if (!$user || !Hash::check($data['password'], $user->password)) {
            return "Invalid Credentials";
        }
        return $user->createToken('authToken')->plainTextToken;
    }
}
