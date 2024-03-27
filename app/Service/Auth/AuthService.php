<?php

namespace App\Service\Auth;

use App\Models\User;

class AuthService
{
    public function registrarUsuario($data)
    {
        return User::create($data);
    }
}
