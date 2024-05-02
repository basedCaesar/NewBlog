<?php

namespace App\Services;
use Illuminate\Support\Facades\Auth;
use App\Interfaces\AuthServiceInterface;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthService implements AuthServiceInterface
{
    public function registerUser(array $data): User
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }

    public function loginUser(array $credentials): ?User
    {
        if (!Auth::attempt($credentials)) {
            return null;
        }
        return Auth::user();
    }
}
