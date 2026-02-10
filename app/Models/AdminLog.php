<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminLog extends Model
{
    protected $fillable = [
        'acao',
        'email',
        'ip',
        'user_agent'
    ];
}
