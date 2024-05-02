<?php

namespace App\Services;

use App\Models\Comment;
use App\Interfaces\CommentServiceInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Collection;
class CommentService implements CommentServiceInterface
{
    public function createComment($validatedData, $postId)
    {
        $user = auth()->user();
        $comment = new Comment($validatedData);
        $comment->user()->associate($user);
        $comment->blog_post_id = $postId; // Ensure proper relationship handling
        $comment->save();

        return $comment;
    }

    public function getCommentsByPostId($postId): Collection
    {
        return Comment::where('blog_post_id', $postId)->get();
    }
}
