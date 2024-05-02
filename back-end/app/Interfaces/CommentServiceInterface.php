<?php

namespace App\Interfaces;

use Illuminate\Database\Eloquent\Collection;

interface CommentServiceInterface
{
    public function createComment(array $validatedData, $postId);
    public function getCommentsByPostId($postId): Collection;
}
