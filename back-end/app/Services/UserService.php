<?php
namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;


use App\Interfaces\UserServiceInterface;

class UserService implements UserServiceInterface
{
    public function loadUserProfile($id)
    {
        $user = User::findOrFail($id);
        $user->load('posts');
        return $user;
    }

    public function updateUserProfile($userId, array $data)
    {
        $user = User::findOrFail($userId);
        $user->update($data);
        return ['message' => 'Perfil atualizado com sucesso'];
    }

    public function deleteUserAccount($userId)
    {
        $user = User::findOrFail($userId);
        $user->tokens()->delete();
        $user->delete();
        return ['message' => 'Conta excluída com sucesso'];
    }
}