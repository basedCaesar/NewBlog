<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddCommentRequest;
use App\Http\Resources\CommentResource;
use App\Services\CommentService;
use App\Interfaces\CommentServiceInterface;
use Illuminate\Http\Response;

class CommentController extends Controller
{
    protected $commentService;

    public function __construct(CommentService $commentService)
    {
        $this->commentService = $commentService;
    }

    public function addComment(AddCommentRequest $request, $postId)
    {
        $comment = $this->commentService->createComment($request->validated(), $postId);
        return new CommentResource($comment);
    }

    public function getAllComments($postId)
    {
        $comments = $this->commentService->getCommentsByPostId($postId);
        return CommentResource::collection($comments);
    }
}
