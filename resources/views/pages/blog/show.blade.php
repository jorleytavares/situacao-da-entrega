@extends('layouts.app')

@section('title', $post->titulo . ' - Situação da Entrega')
@section('description', $post->resumo ?? Str::limit(strip_tags($post->conteudo), 160))
@section('og_image', $post->imagem_destaque ? asset($post->imagem_destaque) : asset('logo.svg'))

@section('head')
<!-- CSS do Tema do Post (Local e Versionado) -->
<link rel="stylesheet" href="{{ asset('css/post-theme.css') }}?v={{ filemtime(public_path('css/post-theme.css')) }}">

<!-- Meta Tags SEO -->
<meta property="og:type" content="article" />
<meta property="og:title" content="{{ $post->titulo }}" />
<meta property="og:description" content="{{ $post->resumo ?? Str::limit(strip_tags($post->conteudo), 160) }}" />
<meta property="og:url" content="{{ request()->url() }}" />
<meta property="article:published_time" content="{{ $post->published_at->toIso8601String() }}" />
<meta property="article:author" content="{{ $post->autor_nome }}" />
@endsection

@section('content')
<div class="blog-layout-wrapper">

    <!-- Coluna Principal -->
    <div class="post-main-column">
        <!-- Header -->
        <header class="post-header-simple">
            <nav class="breadcrumbs">
                <a href="{{ route('home') }}">Home</a>
                <span>/</span>
                <a href="{{ route('blog.index') }}">Blog</a>
                <span>/</span>
                <span>Artigo</span>
            </nav>

            <h1 class="post-title-main">{{ $post->titulo }}</h1>

            @if($post->subtitulo)
            <p class="post-subtitle-main">{{ $post->subtitulo }}</p>
            @endif
        </header>

        <!-- Card de Conteúdo -->
        <main class="post-content-card">
            <!-- Meta Header (Autor/Data) -->
            <div class="post-meta-header">
                <div class="author-avatar-sm">
                    {{ substr($post->autor_nome, 0, 1) }}
                </div>
                <div class="author-details">
                    <span class="author-name">{{ $post->autor_nome }}</span>
                    <span class="post-date">
                        Atualizado em {{ $post->updated_at->format('d/m/Y') }} ·
                        6 min de leitura
                    </span>
                </div>
            </div>

            @if($post->imagem_destaque)
            <figure style="margin-bottom: 2.5rem; border-radius: 0.75rem; overflow: hidden; box-shadow: var(--shadow-sm);">
                <img src="{{ asset($post->imagem_destaque) }}"
                    alt="{{ $post->imagem_alt ?? $post->titulo }}"
                    style="width: 100%; height: auto; display: block;"
                    width="800" height="450">
                @if($post->imagem_legenda)
                <figcaption style="text-align: center; color: var(--slate-500); font-size: 0.85rem; padding: 0.75rem; background: var(--slate-50);">
                    {{ $post->imagem_legenda }}
                </figcaption>
                @endif
            </figure>
            @endif

            <!-- Box SGE (Resumo) -->
            @if($post->sge_summary)
            <div class="cta-box-blue">
                <div class="cta-header-blue">
                    <!-- Ícone Raio -->
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z"></path>
                    </svg>
                    Resumo do Especialista
                </div>
                <div class="content-body" style="font-size: 1rem;">
                    {!! Str::markdown($post->sge_summary) !!}
                </div>
            </div>
            @endif

            <!-- Corpo do Texto -->
            <article class="content-body" id="post-body">
                {!! $post->conteudo_formatado !!}
            </article>

            <!-- CTA Final -->
            <div class="cta-box-green">
                <h3 style="color: var(--emerald-800); font-size: 1.5rem; margin-bottom: 0.5rem; font-weight: 700;">Ainda com dúvidas?</h3>
                <p style="color: var(--emerald-700);">Nossa comunidade de importadores está pronta para ajudar.</p>
                <a href="#comentarios" class="btn-cta-green">
                    Ver Comentários
                </a>
            </div>
        </main>
    </div>

    <!-- Sidebar Sticky -->
    <aside class="sidebar-sticky">

        <!-- Widget: Índice (TOC) -->
        <div class="sidebar-widget toc-widget" id="widget-toc" style="display: none;">
            <span class="widget-title">Neste artigo</span>
            <ul class="toc-list" id="toc-list">
                <!-- Preenchido via JS -->
            </ul>
        </div>

        <!-- Widget: Calculadora -->
        <div class="sidebar-widget">
            <span class="widget-title">Calculadora de Taxas</span>
            <p style="font-size: 0.9rem; color: var(--slate-500); margin-bottom: 1rem;">
                Simule quanto vai pagar de imposto antes de comprar.
            </p>
            <form action="{{ route('calculadora.taxas') }}" method="GET">
                <input type="number" name="valor" class="calc-input" placeholder="Valor do produto (USD)">
                <button type="submit" class="btn-calc-sidebar">
                    Simular Custo ›
                </button>
            </form>
        </div>

        <!-- Widget: Mais Lidos -->
        @if(isset($maisLidos) && $maisLidos->count() > 0)
        <div class="sidebar-widget">
            <span class="widget-title">Leia Também</span>
            <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                @foreach($maisLidos->take(3) as $postLido)
                <a href="{{ route('blog.show', $postLido->slug) }}" class="read-more-item">
                    <div class="read-more-thumb">
                        @if($postLido->imagem_destaque)
                        <img src="{{ asset($postLido->imagem_destaque) }}" alt="{{ $postLido->titulo }}">
                        @else
                        <div style="width:100%; height:100%; background: var(--color-brand); opacity: 0.1;"></div>
                        @endif
                    </div>
                    <div class="read-more-info">
                        <div class="read-more-title">{{ $postLido->titulo }}</div>
                        <span class="read-more-author">Por {{ Str::words($postLido->autor_nome, 1, '') }}</span>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
        @endif

    </aside>

</div>

<!-- Botão Flutuante (Mobile/Desktop) -->
<a href="{{ route('calculadora.taxas') }}" class="floating-cta" title="Simular Taxas">
    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <rect x="2" y="3" width="20" height="14" rx="2" ry="2"></rect>
        <line x1="8" y1="21" x2="16" y2="21"></line>
        <line x1="12" y1="17" x2="12" y2="21"></line>
    </svg>
    <span style="font-size: 0.9rem;">Simular Taxas</span>
</a>

<script>
    // Gerador de TOC (Table of Contents)
    document.addEventListener('DOMContentLoaded', function() {
        const content = document.getElementById('post-body');
        const tocList = document.getElementById('toc-list');
        const tocWidget = document.getElementById('widget-toc');

        if (!content || !tocList) return;

        const headings = content.querySelectorAll('h2, h3');

        if (headings.length > 0) {
            tocWidget.style.display = 'block'; // Mostra widget apenas se houver títulos

            headings.forEach((heading, index) => {
                const id = 'heading-' + index;
                heading.id = id;

                const li = document.createElement('li');
                const a = document.createElement('a');
                a.href = '#' + id;
                a.textContent = heading.innerText;

                // Indentação visual para subtítulos (h3)
                if (heading.tagName === 'H3') {
                    a.style.paddingLeft = '1.25rem';
                    a.style.fontSize = '0.9rem';
                    a.style.color = 'var(--text-meta)';
                }

                li.appendChild(a);
                tocList.appendChild(li);
            });
        }
    });
</script>
@endsection