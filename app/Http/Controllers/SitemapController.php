<?php

namespace App\Http\Controllers;

use App\Models\Problema;
use App\Models\Transportadora;
use App\Models\Post;
use App\Models\Relato;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SitemapController extends Controller
{
    public function index()
    {
        $transportadoras = Transportadora::pluck('slug');
        $problemas = Problema::pluck('slug');
        $posts = Post::where('publicado', true)->get();
        $estados = ['AC', 'AL', 'AP', 'AM', 'BA', 'CE', 'DF', 'ES', 'GO', 'MA', 'MT', 'MS', 'MG', 'PA', 'PB', 'PR', 'PE', 'PI', 'RJ', 'RN', 'RS', 'RO', 'RR', 'SC', 'SP', 'SE', 'TO'];
        $now = Carbon::now()->toIso8601String();

        return response()->view('sitemap', [
            'transportadoras' => $transportadoras,
            'problemas' => $problemas,
            'posts' => $posts,
            'estados' => $estados,
            'now' => $now
        ])->header('Content-Type', 'text/xml');
    }
}
