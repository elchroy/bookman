<?php

namespace App\Repositories\V1;

use App\Models\V1\User;

class UserRepository
{
    public static function createUser(string $email, string $token)
    {
        return User::create([
            'email' => $email,
            'token' => $token,
        ]);
    }

    public static function findUserByEmail(string $email)
    {
        return User::where('email', $email)->first();
    }

    public static function updateUser(User $user, string $newEmail, string $token)
    {
        $user->update([
            'email' => $newEmail,
        ]);
        $user->token = $token;
        $user->save();

        return $user;
    }

    public static function findUserByToken(string $token)
    {
        return User::where('token', $token)->first();
    }
}
