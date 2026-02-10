<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transportadora extends Model
{
    protected $fillable = ['nome', 'slug', 'descricao', 'url_site', 'cor'];

    public function relatos()
    {
        return $this->hasMany(Relato::class);
    }
}
