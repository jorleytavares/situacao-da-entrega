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
    {
        !!json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!
    }
</script>
@endsection

@section('content')
<div class="blog-layout-wrapper">
    <div class="post-container">
        <article class="post-single">
            <header class="post-header">
                <!-- Breadcrumbs -->
                <nav class="breadcrumbs" aria-label="Breadcrumb">
                    <a href="{{ route('home') }}">Home</a>
                    <span>/</span>
                    <a href="{{ route('blog.index') }}">Blog</a>
                    <span>/</span>
                    <span>Tutoriais</span>
                </nav>

                <h1 class="post-title">{{ $post->titulo }}</h1>

                @if($post->subtitulo)
                <p class="post-subtitle">{{ $post->subtitulo }}</p>
                @endif

                <div class="post-meta-info">
                    <span class="meta-item">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                            <line x1="16" y1="2" x2="16" y2="6"></line>
                            <line x1="8" y1="2" x2="8" y2="6"></line>
                            <line x1="3" y1="10" x2="21" y2="10"></line>
                        </svg>
                        {{ $post->published_at->format('d \d\e F, Y') }}
                    </span>
                    <span class="meta-dot">·</span>
                    <span class="meta-item">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10"></circle>
                            <polyline points="12 6 12 12 16 14"></polyline>
                        </svg>
                        6 min de leitura
                    </span>
                    <span class="meta-dot">·</span>
                    <span class="meta-item">
                        Por {{ $post->autor_nome }}
                    </span>
                </div>
            </header>

            @if($post->imagem_destaque)
            <div class="post-featured-wrapper">
                <img src="{{ asset($post->imagem_destaque) }}"
                    class="post-featured-image"
                    alt="{{ $post->imagem_alt ?? $post->titulo }}"
                    title="{{ $post->imagem_title ?? $post->titulo }}"
                    width="800" height="450">

                @if($post->imagem_legenda)
                <div class="post-featured-caption">
                    {{ $post->imagem_legenda }}
                </div>
                @endif
            </div>
            @endif

            <div class="conteudo-post-wrapper">
                @if($post->sge_summary)
                <div class="entity-box">
                    <div class="entity-header">
                        Resumo Rápido
                    </div>
                    <div class="entity-content">
                        {!! Str::markdown($post->sge_summary) !!}
                    </div>
                </div>
                @endif

                <div class="conteudo-post">
                    {!! $post->conteudo_formatado !!}
                </div>

                <div class="comments-cta">
                    <h3>Ficou com alguma dúvida sobre sua entrega?</h3>
                    <p style="margin-bottom: 2rem; color: var(--text-secondary);">Nossos especialistas respondem a todos os comentários da comunidade.</p>
                    <a href="#comentarios" class="btn-primary">Deixar uma Pergunta</a>
                </div>

                <div class="post-footer-section">
                    <div class="author-card">
                        <div class="author-avatar">
                            {{ substr($post->autor_nome, 0, 1) }}
                        </div>
                        <div class="author-info">
                            <strong>{{ $post->autor_nome }}</strong>
                            <span>Especialista em Logística e Importação</span>
                        </div>
                    </div>
                </div>
            </div>
        </article>
    </div>

    <aside class="blog-sidebar">
        <!-- Widget Calculadora -->
        <div class="sidebar-widget widget-calculadora">
            <h3>Calculadora de Importação</h3>
            <p>Descubra exatamente quanto vai pagar de taxas antes do produto chegar.</p>
            <a href="{{ route('calculadora.taxas') }}" class="btn-white">
                Simular Agora
            </a>
        </div>

        <!-- Widget Mais Lidos -->
        @if(isset($maisLidos) && $maisLidos->count() > 0)
        <div class="sidebar-widget widget-mais-lidos">
            <h3 class="widget-title">Mais Populares</h3>
            <ul class="mais-lidos-list">
                @foreach($maisLidos as $index => $postLido)
                <li class="mais-lidos-item">
                    <span class="mais-lidos-rank">{{ $index + 1 }}</span>
                    <a href="{{ route('blog.show', $postLido->slug) }}" class="mais-lidos-link">
                        {{ $postLido->titulo }}
                    </a>
                </li>
                @endforeach
            </ul>
        </div>
        @endif
    </aside>
</div>
@endsection