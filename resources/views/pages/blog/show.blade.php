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
<div class="blog-layout-wrapper">
    <div class="post-container">
        <article class="post-single">
            <header class="post-header">
                <!-- Breadcrumbs -->
                <nav class="breadcrumbs" aria-label="Breadcrumb">
                    <a href="{{ route('blog.index') }}">Blog</a>
                    <span>›</span>
                    <a href="{{ route('blog.index') }}">Tutoriais</a>
                </nav>

                <h1 class="post-title">{{ $post->titulo }}</h1>
                
                @if($post->subtitulo)
                <p class="post-subtitle">{{ $post->subtitulo }}</p>
                @endif

                <div class="post-meta-info">
                    <span class="meta-item">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-clock"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                        Atualizado em {{ $post->updated_at->format('d \d\e F \d\e Y') }}
                    </span>
                    <span class="meta-dot">·</span>
                    <span class="meta-item">6 Min de Leitura</span>
                </div>

                @if($post->imagem_destaque)
                <figure class="post-featured-image">
                    <img src="{{ asset($post->imagem_destaque) }}" 
                         alt="{{ $post->imagem_alt ?? $post->titulo }}" 
                         title="{{ $post->imagem_title ?? $post->titulo }}"
                         width="720" height="405" style="width: 100%; height: auto; aspect-ratio: 16/9;">
                    
                    @if($post->imagem_legenda)
                    <figcaption>{{ $post->imagem_legenda }}</figcaption>
                    @endif

                    @if($post->imagem_descricao)
                    <div class="sr-only" style="position:absolute; width:1px; height:1px; padding:0; margin:-1px; overflow:hidden; clip:rect(0,0,0,0); border:0;">
                        {{ $post->imagem_descricao }}
                    </div>
                    @endif
                </figure>
                @endif

                @if($post->sge_summary)
                <div class="entity-box">
                    <div class="entity-header">
                        Entidade: Status Rastreamento Correios
                    </div>
                    <div class="entity-content">
                        {!! Str::markdown($post->sge_summary) !!}
                    </div>
                </div>
                @endif
            </header>

            <div class="conteudo-post">
                {!! $post->conteudo_formatado !!}
            </div>

            <div class="comments-section">
                <h3>Ficou com alguma dúvida? Deixe seu comentário:</h3>
                <a href="#comentarios" class="btn-comment">Enviar Comentário</a>
            </div>

            <footer class="post-footer">
                <div class="author-card">
                    <div class="author-avatar">
                        {{ substr($post->autor_nome, 0, 1) }}
                    </div>
                    <div class="author-info">
                        <strong>Escrito por {{ $post->autor_nome }}</strong>
                        <span>Especialistas em Logística</span>
                    </div>
                    <div class="author-social">
                        <!-- Social Icons Placeholder -->
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

    <aside class="blog-sidebar">
        <!-- Widget Calculadora -->
        <div class="sidebar-widget widget-calculadora">
            <h3>Calculadora de Taxas</h3>
            <p>Vai importar? Simule agora quanto você vai pagar de impostos.</p>
            <a href="{{ route('calculadora.taxas') }}" class="btn-calc">
                Simular Agora
            </a>
        </div>

        <!-- Widget Mais Lidos -->
        @if(isset($maisLidos) && $maisLidos->count() > 0)
        <div class="sidebar-widget widget-mais-lidos">
            <h3>Mais Lidos</h3>
            <ul>
                @foreach($maisLidos as $index => $postLido)
                <li>
                    <span class="rank">#{{ $index + 1 }}</span>
                    <div>
                        <a href="{{ route('blog.show', $postLido->slug) }}">
                            {{ $postLido->titulo }}
                        </a>
                        <span class="views">{{ $postLido->views }} visualizações</span>
                    </div>
                </li>
                @endforeach
            </ul>
        </div>
        @endif
    </aside>
</div>
@endsection
