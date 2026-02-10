<?php

namespace App\Http\Controllers;

use App\Models\Relato;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TendenciaController extends Controller
{
    public function index()
    {
        $totalRelatos = Relato::count();
        $ultimos30Dias = Relato::where('created_at', '>=', Carbon::now()->subDays(30))->count();

        $problemasMaisRelatados = Relato::select('problema_id', DB::raw('count(*) as total'))
            ->groupBy('problema_id')
            ->orderByDesc('total')
            ->limit(5)
            ->with('problema:id,titulo')
            ->get();

        $estadosMaisAfetados = Relato::select('regioes.uf', DB::raw('count(*) as total'))
            ->join('regioes', 'relatos.regiao_id', '=', 'regioes.id')
            ->whereNotNull('regioes.uf')
            ->groupBy('regioes.uf')
            ->orderByDesc('total')
            ->limit(5)
            ->get();

        $totalResolvidos = Relato::where('resolvido', true)->count();
        $percentualResolvido = $totalRelatos > 0 ? round(($totalResolvidos / $totalRelatos) * 100) : 0;

        // Dados para gráfico
        $problemasGrafico = $problemasMaisRelatados;

        return view('pages.tendencias', compact(
            'totalRelatos',
            'ultimos30Dias',
            'problemasMaisRelatados',
            'estadosMaisAfetados',
            'percentualResolvido',
            'problemasGrafico'
        ));
    }
}
