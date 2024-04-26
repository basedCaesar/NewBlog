<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Comment;

class CommentController extends Controller
{
    /**
     * Adiciona um novo comentário a um post.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $postId
     * @return \Illuminate\Http\Response
     */
    public function addComment(Request $request, $postId)
    {
        // Valida os dados recebidos
        $request->validate([
            'content' => 'required|string',
        ]);

        // Obtém o usuário autenticado
        $user = Auth::user();

        // Cria um novo comentário
        $comment = new Comment();
        $comment->content = $request->input('content');
        $comment->user_id = $user->id; // Associa ao usuário autenticado
        $comment->blog_post_id = $postId;
        $comment->save();

        // Retorna o comentário criado com o código de status 201 (Created)
        return response()->json($comment, 201);
    }

    /**
     * Recupera todos os comentários de um post.
     *
     * @param  int  $postId
     * @return \Illuminate\Http\Response
     */
    public function getAllComments($postId)
    {
        // Retorna todos os comentários para um post específico
        $comments = Comment::where('blog_post_id', $postId)->get();
        return response()->json($comments);
    }
}
