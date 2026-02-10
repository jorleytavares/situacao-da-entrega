<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Problema;
use App\Models\Relato;
use App\Models\Regiao;
use Illuminate\Support\Facades\DB;

class RelatoController extends Controller
{
    public function formulario()
    {
        $problemas = Problema::orderBy('titulo')->get();
        $transportadoras = \App\Models\Transportadora::orderBy('nome')->get();

        return view('pages.relatar', [
            'problemas' => $problemas,
            'transportadoras' => $transportadoras
        ]);
    }

    public function salvar(Request $request)
    {
        $dados = $request->validate([
            'problema_id' => 'required|exists:problemas,id',
            'transportadora_id' => 'nullable|exists:transportadoras,id',
            'uf' => 'nullable|string|size:2',
            'cidade' => 'nullable|string|max:120',
            'data_ocorrencia' => 'nullable|date',
            'resolvido' => 'nullable|boolean'
        ]);

        $regiaoId = null;

        if (!empty($dados['uf'])) {
            $regiao = Regiao::firstOrCreate([
                'uf' => strtoupper($dados['uf']),
                'cidade' => $dados['cidade'] ?? null
            ]);
            $regiaoId = $regiao->id;
        }

        Relato::create([
            'problema_id' => $dados['problema_id'],
            'transportadora_id' => $dados['transportadora_id'] ?? null,
            'regiao_id' => $regiaoId,
            'data_ocorrencia' => $dados['data_ocorrencia'] ?? null,
            'resolvido' => $dados['resolvido'] ?? false
        ]);

        // Métricas globais
        $totalRelatos = Relato::count();
        $ultimos30Dias = Relato::where('created_at', '>=', now()->subDays(30))->count();

        // Métricas do problema específico
        $problemaId = $dados['problema_id'];
        $totalProblema = Relato::where('problema_id', $problemaId)->count();
        $percentual = $totalRelatos > 0 ? round(($totalProblema / $totalRelatos) * 100) : 0;

        // Top 5 problemas para gráfico
        $problemasGrafico = Relato::select('problema_id', DB::raw('COUNT(*) as total'))
            ->groupBy('problema_id')
            ->orderByDesc('total')
            ->limit(5)
            ->with('problema:id,titulo')
            ->get();

        // Top 3 estados do problema
        $top3Estados = Relato::select('regioes.uf', DB::raw('COUNT(*) as total'))
            ->join('regioes', 'relatos.regiao_id', '=', 'regioes.id')
            ->where('problema_id', $problemaId)
            ->whereNotNull('regioes.uf')
            ->groupBy('regioes.uf')
            ->orderByDesc('total')
            ->limit(3)
            ->get();

        return redirect()
            ->route('relato.formulario')
            ->with('sucesso', true)
            ->with('totalRelatos', $totalRelatos)
            ->with('ultimos30Dias', $ultimos30Dias)
            ->with('totalProblema', $totalProblema)
            ->with('percentual', $percentual)
            ->with('problemasGrafico', $problemasGrafico)
            ->with('top3Estados', $top3Estados);
    }
}
