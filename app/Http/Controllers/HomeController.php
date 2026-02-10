<?php

namespace App\Http\Controllers;

use App\Models\Problema;

class HomeController extends Controller
{
    public function index()
    {
        $problemas = Problema::orderBy('id')->get();

        // 3 Últimos Posts para a Home
        $postsRecentes = \App\Models\Post::where('publicado', true)
            ->where('published_at', '<=', now())
            ->orderBy('published_at', 'desc')
            ->take(3)
            ->get();

        return view('pages.home', [
            'problemas' => $problemas,
            'postsRecentes' => $postsRecentes
        ]);
    }
}
