<?php
namespace App\Services;

use App\Interfaces\BlogPostServiceInterface;
use App\Models\BlogPost;

class BlogPostService implements BlogPostServiceInterface
{
    public function getAllPosts()
    {
        return BlogPost::all();
    }

    public function createPost(array $data, $userId)
    {
        $blogPost = new BlogPost();
        $blogPost->fill($data); // Assuming $data has already been validated
        $blogPost->user_id = $userId;
        $blogPost->save();
        return $blogPost;
    }

    public function getPostById($id)
    {
        return BlogPost::findOrFail($id);
    }

    public function updatePost($id, array $data, $userId)
    {
        $blogPost = BlogPost::ofUser($userId)->findOrFail($id);
        $blogPost->fill($data);
        $blogPost->save();
        return $blogPost;
    }

    public function deletePost($id, $userId)
    {
        $blogPost = BlogPost::ofUser($userId)->findOrFail($id);
        $blogPost->delete();
    }
}
