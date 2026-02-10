<?php

namespace App\Http\Controllers;

use App\Models\Relato;
use App\Models\Problema;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class EstadoController extends Controller
{
    public function mostrar(string $uf)
    {
        $uf = strtoupper($uf);

        $total = Relato::join('regioes', 'regioes.id', '=', 'relatos.regiao_id')
            ->where('regioes.uf', $uf)
            ->count();

        // Se não tem dados, mostra página vazia (não 404) para SEO
        $ultimos30Dias = Relato::join('regioes', 'regioes.id', '=', 'relatos.regiao_id')
            ->where('regioes.uf', $uf)
            ->where('relatos.created_at', '>=', Carbon::now()->subDays(30))
            ->count();

        $problemas = Relato::select(
            'problemas.id',
            'problemas.titulo',
            'problemas.slug',
            DB::raw('COUNT(relatos.id) as total')
        )
            ->join('problemas', 'problemas.id', '=', 'relatos.problema_id')
            ->join('regioes', 'regioes.id', '=', 'relatos.regiao_id')
            ->where('regioes.uf', $uf)
            ->groupBy('problemas.id', 'problemas.titulo', 'problemas.slug')
            ->orderByDesc('total')
            ->limit(10)
            ->get();

        $totalResolvidos = Relato::join('regioes', 'regioes.id', '=', 'relatos.regiao_id')
            ->where('regioes.uf', $uf)
            ->where('resolvido', true)
            ->count();
        $percentualResolvido = $total > 0 ? round(($totalResolvidos / $total) * 100) : 0;

        // Nome do estado para SEO
        $nomesEstados = [
            'AC' => 'Acre',
            'AL' => 'Alagoas',
            'AP' => 'Amapá',
            'AM' => 'Amazonas',
            'BA' => 'Bahia',
            'CE' => 'Ceará',
            'DF' => 'Distrito Federal',
            'ES' => 'Espírito Santo',
            'GO' => 'Goiás',
            'MA' => 'Maranhão',
            'MT' => 'Mato Grosso',
            'MS' => 'Mato Grosso do Sul',
            'MG' => 'Minas Gerais',
            'PA' => 'Pará',
            'PB' => 'Paraíba',
            'PR' => 'Paraná',
            'PE' => 'Pernambuco',
            'PI' => 'Piauí',
            'RJ' => 'Rio de Janeiro',
            'RN' => 'Rio Grande do Norte',
            'RS' => 'Rio Grande do Sul',
            'RO' => 'Rondônia',
            'RR' => 'Roraima',
            'SC' => 'Santa Catarina',
            'SP' => 'São Paulo',
            'SE' => 'Sergipe',
            'TO' => 'Tocantins'
        ];
        $nomeEstado = $nomesEstados[$uf] ?? $uf;

        return view('pages.estado', compact(
            'uf',
            'nomeEstado',
            'total',
            'ultimos30Dias',
            'problemas',
            'percentualResolvido'
        ));
    }
}
