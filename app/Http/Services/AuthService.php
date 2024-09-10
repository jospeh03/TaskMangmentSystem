<?php

namespace App\Http\Services;

use App\Models\User;
use Tymon\JWTAuth\Facades\JWTAuth;
use Hash;

class AuthService
{
    public function register(array $data)
    {
        // Ensure the role is passed correctly when registering a new user
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => $data['role'],  // Example: admin, user, or manager
        ]);

        // Generate JWT token for the newly registered user
        $token = JWTAuth::fromUser($user);

        return [
            'user' => $user,
            'token' => $token
        ];
    }

    public function login(array $data)
    {
        $credentials = ['email' => $data['email'], 'password' => $data['password']];
    
        // Ensure that $data['email'] and $data['password'] are being passed correctly.
        if (! $token = JWTAuth::attempt($credentials)) {
            return null;  // Return null if login fails
        }
    
        return $token;  // Return token if login succeeds
    }

    public function logout()
    {
        JWTAuth::invalidate(JWTAuth::getToken());
    }
}
