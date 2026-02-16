<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FerramentasController extends Controller
{
    public function declaracaoConteudo()
    {
        return view('pages.ferramentas.declaracao-conteudo');
    }
}
