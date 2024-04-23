<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UserController extends Controller
{

    /**
     * Exibe o perfil de um usuário.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Encontra o usuário pelo ID
        $user = User::findOrFail($id);

        // Carrega os posts do usuário
        $user->load('posts');
        
        // Retorna as informações do usuário
        return $user;
    }

    /**
     * Atualiza o perfil do usuário autenticado.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        // Obtenha o usuário autenticado
        $user = $request->user();

        // Validação dos dados
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users')->ignore($user->id),
            ],
        ]);

        // Atualiza os dados do usuário
        $user->name = $request->name;
        $user->email = $request->email;
    
        $user->save();

        // Retorna resposta de êxito
        return response()->json(['message' => 'Perfil atualizado com sucesso']);
    }

   /**
     * Exclui a conta do usuário autenticado.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Obtém o usuário autenticado
        $authenticatedUser = Auth::user();

        // Verifica se o ID do usuário autenticado corresponde ao ID fornecido
        if ($authenticatedUser->id != $id) {
            return response()->json(['error' => 'Não autorizado'], 403);
        }

        // Encontra o usuário pelo ID
        $user = User::findOrFail($id);
        
        // Revoga todos os tokens associados ao usuário
        $user->tokens()->delete();
        
        // Exclui a conta do usuário
        $user->delete();

        // Retorna mensagem de sucesso
        return response()->json(['message' => 'Conta excluída com sucesso']);
    }
}
