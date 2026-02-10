<?php

namespace App\Services;

use App\Models\Problema;
use App\Models\Relato;
use Illuminate\Support\Collection;

class ProblemaService
{
    /**
     * Busca problema pelo slug
     */
    public function buscarPorSlug(string $slug): ?Problema
    {
        return Problema::porSlug($slug);
    }

    /**
     * Lista todos os problemas
     */
    public function listarTodos(): Collection
    {
        return Problema::orderBy('titulo')->get();
    }

    /**
     * Busca relatos por estado
     */
    public function buscarRelatosPorEstado(string $uf): Collection
    {
        return Relato::porEstado($uf)
            ->with('problema')
            ->orderByDesc('created_at')
            ->limit(50)
            ->get();
    }

    /**
     * Busca relatos por cidade
     */
    public function buscarRelatosPorCidade(string $cidade): Collection
    {
        return Relato::porCidade($cidade)
            ->with('problema')
            ->orderByDesc('created_at')
            ->limit(50)
            ->get();
    }

    /**
     * Estatísticas por estado
     */
    public function estatisticasPorEstado(string $uf): array
    {
        $relatos = Relato::porEstado($uf)->get();

        return [
            'total' => $relatos->count(),
            'por_problema' => $relatos->groupBy('problema_id')
                ->map(fn($grupo) => $grupo->count())
                ->toArray(),
        ];
    }

    /**
     * Estatísticas por cidade
     */
    public function estatisticasPorCidade(string $cidade): array
    {
        $relatos = Relato::porCidade($cidade)->get();

        return [
            'total' => $relatos->count(),
            'por_problema' => $relatos->groupBy('problema_id')
                ->map(fn($grupo) => $grupo->count())
                ->toArray(),
        ];
    }
}
