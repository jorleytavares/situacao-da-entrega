<?php

namespace App\Http\Controllers;

use App\Services\ProblemaService;
use Illuminate\Http\Request;

class RegiaoController extends Controller
{
    protected ProblemaService $problemaService;

    public function __construct(ProblemaService $problemaService)
    {
        $this->problemaService = $problemaService;
    }

    /**
     * Exibe página de um estado específico
     */
    public function estado(string $uf)
    {
        $uf = strtoupper($uf);
        $relatos = $this->problemaService->buscarRelatosPorEstado($uf);
        $estatisticas = $this->problemaService->estatisticasPorEstado($uf);

        return view('pages.estado', compact('uf', 'relatos', 'estatisticas'));
    }

    /**
     * Exibe página de uma cidade específica
     */
    public function cidade(string $cidade)
    {
        $relatos = $this->problemaService->buscarRelatosPorCidade($cidade);
        $estatisticas = $this->problemaService->estatisticasPorCidade($cidade);

        return view('pages.cidade', compact('cidade', 'relatos', 'estatisticas'));
    }
}
