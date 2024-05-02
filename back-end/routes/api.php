<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BlogPostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\UserController;


Route::prefix('auth')->group(function () {
    //Rotas para operações de autenticação
    Route::post('register', [AuthController::class, 'register'])->name('auth.register');
    Route::post('login', [AuthController::class, 'login'])->name('auth.login');
    Route::post('logout', [AuthController::class, 'logout'])->name('auth.logout')->middleware('auth:sanctum');
});



Route::prefix('user')->group(function () {
    // Rota acessível a qualquer pessoa para visualizar o perfil de qualquer usuário
    Route::get('/{user}', [UserController::class, 'show'])->name('user.show');

    // Rotas de perfil que requerem autenticação
    Route::middleware(['auth:sanctum'])->group(function () {
        Route::put('/profile/{user}', [UserController::class, 'update'])->name('user.update');
        Route::delete('/profile/{user}', [UserController::class, 'destroy'])->name('user.destroy');
    });
    
});



Route::prefix('posts')->group(function () {
    // Rotas para recuperar um post ou todos os posts, sem requerer autentiação
    Route::get('/', [BlogPostController::class, 'index'])->name('posts.index');
    Route::get('/{post}', [BlogPostController::class, 'show'])->name('posts.show');

    // Rota para recuperar os comentários de um post específico
    Route::get('/{post}/comments', [CommentController::class, 'getAllComments'])->name('posts.comments.index');

    // Grupo de rotas que requerem autenticação
    Route::middleware(['auth:sanctum'])->group(function () {
        // Define rotas para criar, atualizar e deletar posts
        Route::resource('', BlogPostController::class)->except(['index', 'show'])->parameters(['' => 'post']);

        // Rota para adicionar um comentário
        Route::post('/{post}/comments', [CommentController::class, 'addComment'])->name('posts.comments.store');;
    });
});


