<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\User;
use App\Models\Comment;

class BlogPost extends Model
{
    use HasFactory;

    // Campos permitidos para atribuição em massa
    protected $fillable = [
        'title', 'content', 'user_id' 
    ];

    // Define o relacionamento "belongsTo" com o modelo User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Define o relacionamento "hasMany" com o modelo Comment
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
