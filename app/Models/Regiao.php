<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Regiao extends Model
{
    protected $table = 'regioes';

    protected $fillable = [
        'uf',
        'cidade'
    ];
}
