<?php

namespace App\Interfaces;

use App\Models\User;

interface AuthServiceInterface
{
    public function registerUser(array $data): User;
    public function loginUser(array $credentials): ?User;
}
