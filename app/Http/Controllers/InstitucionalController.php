<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Relato;
use App\Models\Problema;

class InstitucionalController extends Controller
{
    public function comoFunciona()
    {
        return view('pages.como-funciona');
    }

    public function sobre()
    {
        $totalRelatos = Relato::count();
        $totalProblemas = Problema::count();
        $totalEstados = Relato::join('regioes', 'regioes.id', '=', 'relatos.regiao_id')
            ->whereNotNull('regioes.uf')
            ->distinct('regioes.uf')
            ->count('regioes.uf');

        return view('pages.sobre-projeto', compact('totalRelatos', 'totalProblemas', 'totalEstados'));
    }

    public function avisoLegal()
    {
        return view('pages.aviso-legal');
    }

    public function privacidade()
    {
        return view('pages.privacidade');
    }

    public function contato()
    {
        return view('pages.contato');
    }

    public function metodologia()
    {
        return view('institucional.metodologia-dos-dados');
    }
}
