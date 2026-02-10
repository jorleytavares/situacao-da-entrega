<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Relato;
use App\Models\Problema;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PublicApiController extends Controller
{
    public function estatisticas()
    {
        $totalRelatos = Relato::count();

        $problemas = Problema::withCount('relatos')
            ->orderByDesc('relatos_count')
            ->limit(10)
            ->get()
            ->map(function ($p) {
                return [
                    'titulo' => $p->titulo,
                    'slug' => $p->slug,
                    'total' => $p->relatos_count
                ];
            });

        $estados = Relato::join('regioes', 'regioes.id', '=', 'relatos.regiao_id')
            ->select('regioes.uf', DB::raw('count(*) as total'))
            ->whereNotNull('regioes.uf')
            ->groupBy('regioes.uf')
            ->orderByDesc('total')
            ->get();

        return response()->json([
            'geral' => [
                'total_relatos' => $totalRelatos,
                'atualizado_em' => Carbon::now()
            ],
            'top_problemas' => $problemas,
            'estados' => $estados
        ]);
    }
}
