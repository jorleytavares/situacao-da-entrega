@extends('layouts.app')

@section('title', 'Blog Situação da Entrega - Dicas e Tutoriais')
@section('description', 'Artigos, tutoriais e explicações detalhadas sobre rastreamento, status de entrega e logística no Brasil.')

@section('content')
<section class="bloco destaque" id="bloco-hero-blog">
    <h2 class="bloco-titulo">
        <x-icon name="package-search" size="28" color="#128C7E" />
        Blog & Tutoriais
    </h2>
    <p class="bloco-texto">
        Entenda a fundo o que acontece nos bastidores da logística. Nossos artigos explicam status complexos, direitos do consumidor e dicas para resolver problemas.
    </p>
</section>

@if($posts->count() > 0)
<div class="blog-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 1.5rem; margin-top: 2rem;">
    @foreach($posts as $post)
    <article class="card-problema" style="height: 100%; display: flex; flex-direction: column; justify-content: space-between;">
        <div>
            @if($post->imagem_destaque)
            <img src="{{ asset($post->imagem_destaque) }}" alt="{{ $post->imagem_alt }}" title="{{ $post->titulo }}" style="width: 100%; height: 160px; object-fit: cover; border-radius: 8px; margin-bottom: 1rem;">
            @endif

            <h3 style="font-size: 1.25rem; margin-bottom: 0.5rem; line-height: 1.3;">
                <a href="{{ route('blog.show', $post->slug) }}" style="text-decoration: none; color: var(--cor-texto);">
                    {{ $post->titulo }}
                </a>
            </h3>

            <p style="color: var(--cor-texto-secundario); font-size: 0.95rem; margin-bottom: 1rem;">
                {{ $post->resumo ?? Str::limit(strip_tags($post->conteudo), 120) }}
            </p>
        </div>

        <div style="margin-top: auto; padding-top: 1rem; border-top: 1px solid var(--cor-borda); display: flex; justify-content: space-between; align-items: center; font-size: 0.85rem; color: var(--cor-texto-secundario);">
            <time datetime="{{ $post->published_at->toIso8601String() }}">
                {{ $post->published_at->format('d/m/Y') }}
            </time>
            <a href="{{ route('blog.show', $post->slug) }}" style="color: var(--cor-primaria); font-weight: 500;">Ler artigo →</a>
        </div>
    </article>
    @endforeach
</div>

<div style="margin-top: 2rem;">
    {{ $posts->links() }}
</div>
@else
<div class="bloco" style="text-align: center; padding: 4rem 2rem;">
    <x-icon name="search-x" size="48" color="#ccc" />
    <h3>Nenhum artigo encontrado</h3>
    <p class="bloco-texto">Estamos trabalhando em novos conteúdos. Volte em breve!</p>
</div>
@endif

<section class="bloco" style="margin-top: 2rem;">
    <h3 class="bloco-titulo">Tópicos Recentes</h3>
    <ul class="lista-simples">
        <li><a href="{{ route('problema.mostrar', 'encomenda-parada') }}">Encomenda Parada</a></li>
        <li><a href="{{ route('problema.mostrar', 'fiscalizacao') }}">Fiscalização Aduaneira</a></li>
        <li><a href="{{ route('transportadora.index') }}">Lista de Transportadoras</a></li>
    </ul>
</section>
@endsection