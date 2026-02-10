<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Problema;
use App\Models\Transportadora;
use App\Models\Post;
use App\Models\SearchLog;
use Illuminate\Support\Str;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('q');

        if (empty($query)) {
            return redirect()->route('home');
        }

        // Search Problemas
        $problemas = Problema::where('titulo', 'LIKE', "%{$query}%")
            ->orWhere('descricao_curta', 'LIKE', "%{$query}%")
            ->get();

        // Search Transportadoras
        $transportadoras = Transportadora::where('nome', 'LIKE', "%{$query}%")
            ->get();

        // Search Blog Posts
        $posts = Post::where('publicado', true)
            ->where(function ($q) use ($query) {
                $q->where('titulo', 'LIKE', "%{$query}%")
                  ->orWhere('resumo', 'LIKE', "%{$query}%");
            })
            ->get();

        // Log Search
        try {
            $totalResults = $problemas->count() + $transportadoras->count() + $posts->count();
            
            SearchLog::create([
                'term' => $query,
                'results_count' => $totalResults,
                'ip' => $request->ip()
            ]);
        } catch (\Exception $e) {
            // Silently fail logging to not disrupt user experience
        }

        return view('pages.busca', compact('query', 'problemas', 'transportadoras', 'posts'));
    }
}
