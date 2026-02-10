<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Problema extends Model
{
    protected $fillable = [
        'slug',
        'titulo',
        'descricao_curta',
        'descricao_completa'
    ];
}
