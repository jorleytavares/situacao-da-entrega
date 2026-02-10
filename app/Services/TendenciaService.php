<?php

namespace App\Services;

use App\Models\Problema;
use App\Models\Relato;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class TendenciaService
{
    /**
     * Lista tendências gerais
     */
    public function listarTendencias(): array
    {
        $ultimaSemana = now()->subWeek();

        $relatosSemana = Relato::where('created_at', '>=', $ultimaSemana)->count();
        $relatosTotal = Relato::count();

        return [
            'ultima_semana' => $relatosSemana,
            'total' => $relatosTotal,
            'media_diaria' => $relatosSemana / 7,
        ];
    }

    /**
     * Problemas mais frequentes
     */
    public function problemasFrequentes(int $limite = 5): Collection
    {
        return Problema::withCount('relatos')
            ->orderByDesc('relatos_count')
            ->limit($limite)
            ->get();
    }

    /**
     * Estados com mais relatos (críticos)
     */
    public function estadosCriticos(int $limite = 5): Collection
    {
        return Relato::select('uf', DB::raw('COUNT(*) as total'))
            ->whereNotNull('uf')
            ->groupBy('uf')
            ->orderByDesc('total')
            ->limit($limite)
            ->get();
    }

    /**
     * Evolução de relatos por dia (últimos 30 dias)
     */
    public function evolucaoDiaria(int $dias = 30): Collection
    {
        $dataInicio = now()->subDays($dias);

        return Relato::select(DB::raw('DATE(created_at) as data'), DB::raw('COUNT(*) as total'))
            ->where('created_at', '>=', $dataInicio)
            ->groupBy('data')
            ->orderBy('data')
            ->get();
    }
}
