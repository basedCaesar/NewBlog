<?php
namespace App\Interfaces;

interface BlogPostServiceInterface
{
    public function getAllPosts();
    public function createPost(array $data, $userId);
    public function getPostById($id);
    public function updatePost($id, array $data, $userId);
    public function deletePost($id, $userId);
}
