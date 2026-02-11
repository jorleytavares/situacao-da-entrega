@extends('layouts.app')

@section('title', $post->titulo . ' - Situação da Entrega')
@section('description', $post->resumo ?? Str::limit(strip_tags($post->conteudo), 160))
@section('og_image', $post->imagem_destaque ? asset($post->imagem_destaque) : asset('logo.svg'))

@section('head')
<link rel="stylesheet" href="{{ asset('css/post-theme.css') }}?v={{ filemtime(public_path('css/post-theme.css')) }}">
<meta property="og:type" content="article" />
<meta property="og:title" content="{{ $post->titulo }}" />
<meta property="og:description" content="{{ $post->resumo ?? Str::limit(strip_tags($post->conteudo), 160) }}" />
<meta property="og:url" content="{{ request()->url() }}" />
<meta property="og:site_name" content="{{ config('app.name', 'Situação da Entrega') }}" />
<meta property="og:locale" content="pt_BR" />
<meta property="article:published_time" content="{{ $post->published_at->toIso8601String() }}" />
<meta property="article:modified_time" content="{{ $post->updated_at->toIso8601String() }}" />
<meta property="article:author" content="{{ $post->autor_nome }}" />

@if($post->imagem_destaque)
<meta property="og:image" content="{{ asset($post->imagem_destaque) }}" />
<meta property="og:image:alt" content="{{ $post->imagem_alt ?? $post->titulo }}" />
<meta property="og:image:type" content="image/webp" />
@endif

<meta name="twitter:card" content="summary_large_image" />
<meta name="twitter:title" content="{{ $post->titulo }}" />
<meta name="twitter:description" content="{{ $post->resumo ?? Str::limit(strip_tags($post->conteudo), 160) }}" />
@if($post->imagem_destaque)
<meta name="twitter:image" content="{{ asset($post->imagem_destaque) }}" />
<meta name="twitter:image:alt" content="{{ $post->imagem_alt ?? $post->titulo }}" />
@endif

<script type="application/ld+json">
    {!! json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
</script>
@endsection

@section('content')
<div class="post-container">
    <article class="post-single">
        <header class="post-header">
            <div class="post-meta">
                <span class="post-category">BLOG</span>
                <span class="separator">-</span>
                <time datetime="{{ $post->published_at->toIso8601String() }}">
                    {{ $post->published_at->format('d/m/Y') }}
                </time>
            </div>

            <h1 class="post-title">{{ $post->titulo }}</h1>
            
            @if($post->subtitulo)
            <h2 class="post-subtitle">{{ $post->subtitulo }}</h2>
            @endif

            @if($post->sge_summary)
            <div class="sge-summary">
                <div class="sge-header">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-cpu"><rect x="4" y="4" width="16" height="16" rx="2" ry="2"></rect><rect x="9" y="9" width="6" height="6"></rect><line x1="9" y1="1" x2="9" y2="4"></line><line x1="15" y1="1" x2="15" y2="4"></line><line x1="9" y1="20" x2="9" y2="23"></line><line x1="15" y1="20" x2="15" y2="23"></line><line x1="20" y1="9" x2="23" y2="9"></line><line x1="20" y1="14" x2="23" y2="14"></line><line x1="1" y1="9" x2="4" y2="9"></line><line x1="1" y1="14" x2="4" y2="14"></line></svg>
                    <strong>RESUMO RÁPIDO (IA)</strong>
                </div>
                <div class="sge-content">
                    {!! Str::markdown($post->sge_summary) !!}
                </div>
            </div>
            @endif

            @if($post->imagem_destaque)
            <figure class="post-featured-image">
                @if($post->imagem_legenda || $post->imagem_alt)
                <figcaption>{{ $post->imagem_legenda ?? $post->imagem_alt }}</figcaption>
                @endif
                
                <img src="{{ asset($post->imagem_destaque) }}" 
                     alt="{{ $post->imagem_alt ?? $post->titulo }}" 
                     title="{{ $post->imagem_title ?? $post->titulo }}"
                     width="720" height="405" style="width: 100%; height: auto; aspect-ratio: 16/9;">
                
                @if($post->imagem_descricao)
                <div class="sr-only" style="position:absolute; width:1px; height:1px; padding:0; margin:-1px; overflow:hidden; clip:rect(0,0,0,0); border:0;">
                    {{ $post->imagem_descricao }}
                </div>
                @endif
            </figure>
            @endif
        </header>

        <div class="conteudo-post">
            {!! $post->conteudo_formatado !!}
        </div>

        <footer class="post-footer">
            <div class="author-card">
                <div class="author-avatar">
                    {{ substr($post->autor_nome, 0, 1) }}
                </div>
                <div class="author-info">
                    <strong>{{ $post->autor_nome }}</strong>
                    <span>Especialista em Logística</span>
                </div>
            </div>
        </footer>
    </article>

    <div class="read-more-section">
        <h3>Continue Lendo</h3>
        <div class="read-more-links">
            <a href="{{ route('blog.index') }}" class="btn-secondary">Ver todos os artigos</a>
            <a href="{{ route('home') }}" class="btn-text">Voltar para a Home</a>
        </div>
    </div>
</div>
@endsection
