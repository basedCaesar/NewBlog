<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\RegisterUserRequest;
use App\Http\Requests\LoginUserRequest;
use App\Interfaces\AuthServiceInterface;


class AuthController extends Controller
{
    protected $authService;

    public function __construct(AuthServiceInterface $authService)
    {
        $this->authService = $authService;
    }

    public function register(RegisterUserRequest $request)
    {
        $user = $this->authService->registerUser($request->validated());
        $token = $user->createToken('authToken')->plainTextToken;
        return response()->json(['token' => $token, 'user' => $user], 201);
    }

    public function login(LoginUserRequest $request)
    {
        $user = $this->authService->loginUser($request->only('email', 'password'));
        if (!$user) {
            return response()->json(['message' => 'Não autorizado'], 401);
        }
        $token = $user->createToken('authToken')->plainTextToken;
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
