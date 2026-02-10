<?php

namespace App\Services;

use App\Models\Problema;
use App\Models\Regiao;
use App\Models\Relato;
use Illuminate\Support\Collection;

class RelatoService
{
    /**
     * Lista todos os problemas para o formulário
     */
    public function listarProblemas(): Collection
    {
        return Problema::orderBy('titulo')->get();
    }

    /**
     * Lista todos os estados para o formulário
     */
    public function listarEstados(): array
    {
        return Regiao::todosEstados();
    }

    /**
     * Cria um novo relato
     */
    public function criarRelato(array $dados): Relato
    {
        // Busca ou cria a região se UF foi informada
        $regiaoId = null;
        if (!empty($dados['uf'])) {
            $regiao = Regiao::porUf($dados['uf']);
            if ($regiao) {
                $regiaoId = $regiao->id;
            }
        }

        return Relato::create([
            'problema_id' => $dados['problema_id'],
            'descricao' => $dados['descricao'],
            'uf' => $dados['uf'] ?? null,
            'cidade' => $dados['cidade'] ?? null,
            'regiao_id' => $regiaoId,
        ]);
    }

    /**
     * Lista relatos recentes
     */
    public function relatosRecentes(int $limite = 10): Collection
    {
        return Relato::with(['problema', 'regiao'])
            ->orderByDesc('created_at')
            ->limit($limite)
            ->get();
    }
}
