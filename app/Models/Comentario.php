<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Comentario extends Model
{
    use HasFactory;

    protected $fillable = [
        'post_id',
        'nome',
        'email',
        'mensagem',
        'status',
    ];

    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
