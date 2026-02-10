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

        return response()->view('sitemap', [
            'transportadoras' => $transportadoras,
            'problemas' => $problemas,
            'posts' => $posts
        ])->header('Content-Type', 'text/xml');
    }
}
