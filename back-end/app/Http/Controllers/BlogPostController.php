<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BlogPost;
use Illuminate\Support\Facades\Auth;

class BlogPostController extends Controller
{
    /**
     * Lista todos os posts.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        // Retorna todos os posts
        $blogPosts = BlogPost::all();
        return response()->json($blogPosts);
    }

    /**
     * Armazena um novo post no banco de dados.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Valida os dados recebidos
        $request->validate([
            'title' => 'required|string',
            'content' => 'required|string',
        ]);

        // Obtém o usuário autenticado
        $user = Auth::user();

        // Cria um novo post
        $blogPost = new BlogPost();
        $blogPost->title = $request->input('title');
        $blogPost->content = $request->input('content');
        $blogPost->user_id = $user->id; // Associa ao usuário autenticado
        $blogPost->save();

        // Retorna o post criado com o código de status 201 (Created)
        return response()->json($blogPost, 201);
    }

    /**
     * Recupera um post específico.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Encontra o post pelo ID
        $blogPost = BlogPost::findOrFail($id);
        return response()->json($blogPost);
    }

    /**
     * Atualiza o post especificado no banco de dados.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Valida os dados recebidos
        $request->validate([
            'title' => 'required|string',
            'content' => 'required|string',
        ]);

        // Obtém o usuário autenticado
        $user = Auth::user();

        // Encontra o post pelo ID e pelo usuário autenticado
        $blogPost = BlogPost::where('id', $id)
            ->where('user_id', $user->id)
            ->firstOrFail();

        // Atualiza os dados do post
        $blogPost->title = $request->input('title');
        $blogPost->content = $request->input('content');
        $blogPost->save();

        // Retorna o post atualizado
        return response()->json($blogPost, 200);
    }

    /**
     * Remove o post especificado do banco de dados.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Obtém o usuário autenticado
        $user = Auth::user();

        // Encontra o post pelo ID e pelo usuário autenticado
        $blogPost = BlogPost::where('id', $id)
            ->where('user_id', $user->id)
            ->firstOrFail();

        // Deleta o post
        $blogPost->delete();
        
        // Retorna uma resposta de sucesso com o código de status 204 (No Content)
        return response()->json(null, 204);
    }

    

}
