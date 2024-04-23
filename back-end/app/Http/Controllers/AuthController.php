<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Registra um novo usuário.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        // Validação dos dados de registro
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|min:6',
        ]);

        // Cria um novo registro de usuário
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Gera o token para o novo usuário
        $token = $user->createToken('authToken')->plainTextToken;

        // Retorna a resposta com o token e os dados do usuário com o código de status 201 (Created)
        return response()->json(['token' => $token, 'user' => $user], 201);
    }

    /**
     * Realiza a autenticação de um usuário.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        // Validação dos dados de login
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        // Tentativa de autenticar o usuário
        if (!Auth::attempt($request->only('email', 'password'))) {
            // Retorna uma resposta de erro com o código de status 401 (Unauthorized)
            return response()->json(['message' => 'Não autorizado'], 401);
        }

        // Recupera o usuário autenticado
        $user = Auth::user();

        // Gera o token para o usuário autenticado
        $token = $user->createToken('authToken')->plainTextToken;

        // Retorna a resposta com o token e os dados do usuário com o código de status 200 (OK)
        return response()->json(['token' => $token, 'user' => $user], 200);
    }

    /**
     * Realiza o logout do usuário.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        // Revoga todos os tokens associados ao usuário atual
        $request->user()->tokens()->delete();

        // Retorna a resposta com a mensagem de sucesso com o código de status 200 (OK)
        return response()->json(['message' => 'Logout realizado com sucesso'], 200);
    }
}
