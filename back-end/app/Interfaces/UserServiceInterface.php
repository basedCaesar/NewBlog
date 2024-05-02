<?php
namespace App\Interfaces;

interface UserServiceInterface
{
    public function loadUserProfile($id);
    public function updateUserProfile( $userId, array $data);
    public function deleteUserAccount($userId);
   
}
