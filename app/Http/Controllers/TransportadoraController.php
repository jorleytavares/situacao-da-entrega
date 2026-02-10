<?php

namespace App\Http\Controllers;

use App\Models\Relato;
use App\Models\Transportadora; // Importante
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TransportadoraController extends Controller
{
    public function index()
    {
        $transportadoras = Transportadora::all();
        return view('pages.transportadoras', compact('transportadoras'));
    }

    public function mostrar(string $slug)
    {
        $transportadora = Transportadora::where('slug', $slug)->firstOrFail();

        // Estatísticas filtradas por transportadora
        $totalRelatos = $transportadora->relatos()->count();
        $ultimos30Dias = $transportadora->relatos()
            ->where('created_at', '>=', Carbon::now()->subDays(30))
            ->count();

        $topProblemas = Relato::select('problemas.titulo', 'problemas.slug', DB::raw('COUNT(*) as total'))
            ->join('problemas', 'problemas.id', '=', 'relatos.problema_id')
            ->where('relatos.transportadora_id', $transportadora->id)
            ->groupBy('problemas.id', 'problemas.titulo', 'problemas.slug')
            ->orderByDesc('total')
            ->limit(5)
            ->get();

        return view('pages.transportadora', compact(
            'slug',
            'transportadora',
            'totalRelatos',
            'ultimos30Dias',
            'topProblemas'
        ));
    }
}
