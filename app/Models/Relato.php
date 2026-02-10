<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Relato extends Model
{
    protected $fillable = [
        'problema_id',
        'transportadora_id',
        'regiao_id',
        'data_ocorrencia',
        'resolvido'
    ];

    public function problema()
    {
        return $this->belongsTo(\App\Models\Problema::class);
    }

    public function transportadora()
    {
        return $this->belongsTo(\App\Models\Transportadora::class);
    }
}
