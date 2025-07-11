<?php

namespace App\Repositories;

use App\Models\AuthUser;
use Illuminate\Support\Facades\Hash;

class AuthRepository extends BaseRepository
{
    public function __construct(AuthUser $model)
    {
        parent::__construct($model);
    }

    public function findByLogin(string $login)
    {
        $loginField = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        return $this->model->where($loginField, $login)->first();
    }

    public function register(array $data)
    {
        return $this->model->create([
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }

    public function deleteCurrentToken($user)
    {
        return $user->currentAccessToken()->delete();
    }

    public function createAuthToken($user, string $tokenName = 'auth_token')
    {
        return $user->createToken($tokenName)->plainTextToken;
    }
}