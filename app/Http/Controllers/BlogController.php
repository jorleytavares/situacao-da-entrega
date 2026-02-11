<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BlogController extends Controller
{
    public function index()
    {
        // Posts recentes e publicados, com paginação para SEO (canonical)
        $posts = \App\Models\Post::where('publicado', true)
            ->where('published_at', '<=', now())
            ->orderBy('published_at', 'desc')
            ->orderBy('id', 'desc')
            ->paginate(10);

        // Posts mais lidos (Top 5)
        $maisLidos = \App\Models\Post::where('publicado', true)
            ->where('views', '>', 0)
            ->orderBy('views', 'desc')
            ->take(5)
            ->get();

        return view('pages.blog.index', compact('posts', 'maisLidos'));
    }

    public function show($slug)
    {
        // Encontra post por slug ou 404
        $post = \App\Models\Post::where('slug', $slug)
            ->where('publicado', true)
            ->firstOrFail();

        // Incrementa visualizações
        $post->increment('views');

        // Dados Estruturados (SGE/Schema)
        $schema = $this->generateSchema($post);

        return view('pages.blog.show', compact('post', 'schema'));
    }

    private function generateSchema($post)
    {
        // Schema Base (Article)
        $baseSchema = [
            '@context' => 'https://schema.org',
            '@type' => 'BlogPosting',
            'headline' => $post->titulo,
            'image' => $post->imagem_destaque ? asset($post->imagem_destaque) : asset('logo.svg'),
            'datePublished' => $post->published_at->toIso8601String(),
            'dateModified' => $post->updated_at->toIso8601String(),
            'author' => [
                '@type' => 'Person',
                'name' => $post->autor_nome,
                'url' => $post->autor_perfil
            ],
            'description' => $post->resumo ?? Str::limit(strip_tags($post->conteudo), 160),
            'mainEntityOfPage' => [
                '@type' => 'WebPage',
                '@id' => route('blog.show', $post->slug)
            ]
        ];

        // Mescla com schema customizado do banco (se houver, ex: FAQ, HowTo)
        if ($post->meta_schema) {
            $baseSchema = array_merge($baseSchema, $post->meta_schema);
        }

        return $baseSchema;
    }
}
