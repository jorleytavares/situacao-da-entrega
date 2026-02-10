<?php

namespace App\Http\Controllers;

use App\Models\Problema;
use App\Models\Relato;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ProblemaController extends Controller
{
    public function mostrar($slug)
    {
        $problema = Problema::where('slug', $slug)->firstOrFail();

        $total = Relato::where('problema_id', $problema->id)->count();

        $ultimos30Dias = Relato::where('problema_id', $problema->id)
            ->where('created_at', '>=', Carbon::now()->subDays(30))
            ->count();

        $totalGeral = Relato::count();
        $percentual = $totalGeral > 0 ? round(($total / $totalGeral) * 100) : 0;

        $estados = Relato::select('regioes.uf', DB::raw('COUNT(*) as total'))
            ->join('regioes', 'relatos.regiao_id', '=', 'regioes.id')
            ->where('problema_id', $problema->id)
            ->whereNotNull('regioes.uf')
            ->groupBy('regioes.uf')
            ->orderByDesc('total')
            ->limit(10)
            ->get();

        $totalResolvidos = Relato::where('problema_id', $problema->id)
            ->where('resolvido', true)->count();
        $percentualResolvido = $total > 0 ? round(($totalResolvidos / $total) * 100) : 0;

        return view('pages.problema', compact(
            'problema',
            'total',
            'ultimos30Dias',
            'percentual',
            'estados',
            'percentualResolvido'
        ));
    }
}
