<?php

namespace App\Http\Controllers;

use App\Models\Relato;
use App\Models\Problema;
use App\Models\SearchLog;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Response;
use Carbon\Carbon;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $totalRelatos = Relato::count();

        $relatos7dias = Relato::where('created_at', '>=', Carbon::now()->subDays(7))->count();
        $relatos30dias = Relato::where('created_at', '>=', Carbon::now()->subDays(30))->count();

        $relatosSemanaPasada = Relato::whereBetween('created_at', [
            Carbon::now()->subDays(14),
            Carbon::now()->subDays(7)
        ])->count();

        $crescimentoSemanal = $relatosSemanaPasada > 0
            ? round((($relatos7dias - $relatosSemanaPasada) / $relatosSemanaPasada) * 100, 1)
            : 0;

        $top5Problemas = Relato::select('problema_id', DB::raw('count(*) as total'))
            ->groupBy('problema_id')
            ->orderByDesc('total')
            ->limit(5)
            ->with('problema')
            ->get();

        $top5Estados = Relato::select('regioes.uf', DB::raw('count(*) as total'))
            ->join('regioes', 'relatos.regiao_id', '=', 'regioes.id')
            ->whereNotNull('regioes.uf')
            ->groupBy('regioes.uf')
            ->orderByDesc('total')
            ->limit(5)
            ->get();

        // Dados para gráfico de tendência (últimos 30 dias)
        $tendencia = Relato::select(
            DB::raw('DATE(created_at) as data'),
            DB::raw('COUNT(*) as total')
        )
            ->where('created_at', '>=', Carbon::now()->subDays(30))
            ->groupBy('data')
            ->orderBy('data')
            ->get()
            ->keyBy('data');

        // Preencher dias sem relatos com zero
        $graficoData = [];
        for ($i = 29; $i >= 0; $i--) {
            $dia = Carbon::now()->subDays($i)->format('Y-m-d');
            $graficoData[] = [
                'data' => Carbon::now()->subDays($i)->format('d/m'),
                'total' => $tendencia[$dia]->total ?? 0
            ];
        }

        // --- Estatísticas de Busca ---
        
        // Termos mais buscados (que tiveram resultados)
        $termosBuscados = SearchLog::select('term', DB::raw('count(*) as total'))
            ->where('results_count', '>', 0)
            ->groupBy('term')
            ->orderByDesc('total')
            ->limit(5)
            ->get();

        // Oportunidades (buscas sem resultados)
        $oportunidadesConteudo = SearchLog::select('term', DB::raw('count(*) as total'))
            ->where('results_count', '=', 0)
            ->groupBy('term')
            ->orderByDesc('total')
            ->limit(5)
            ->get();

        return view('admin.visao-geral', compact(
            'totalRelatos',
            'relatos7dias',
            'relatos30dias',
            'crescimentoSemanal',
            'top5Problemas',
            'top5Estados',
            'graficoData',
            'termosBuscados',
            'oportunidadesConteudo'
        ));
    }

    public function exportarCsv()
    {
        $relatos = Relato::select(
            'relatos.created_at',
            'problemas.titulo as problema',
            'regioes.uf as estado',
            'relatos.resolvido'
        )
            ->join('problemas', 'problemas.id', '=', 'relatos.problema_id')
            ->leftJoin('regioes', 'regioes.id', '=', 'relatos.regiao_id')
            ->orderByDesc('relatos.created_at')
            ->get();

        $csv = "Data,Problema,Estado,Resolvido\n";
        foreach ($relatos as $relato) {
            $csv .= sprintf(
                "%s,%s,%s,%s\n",
                $relato->created_at->format('Y-m-d H:i'),
                str_replace(',', ' ', $relato->problema),
                $relato->estado ?? 'N/A',
                $relato->resolvido ? 'Sim' : 'Não'
            );
        }

        return response($csv, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="relatos_' . date('Y-m-d') . '.csv"'
        ]);
    }
}
