<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\User;
use App\Models\BlogPost;

class Comment extends Model
{
    // Atributos que podem ser atribuídos em massa
    protected $fillable = [
        'content', 'user_id', 'blog_post_id' 
    ];

    // Relacionamento com o modelo User (um comentário pertence a um usuário)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relacionamento com o modelo BlogPost (um comentário pertence a um post)
    public function blogPost()
    {
        return $this->belongsTo(BlogPost::class);
    }
}

