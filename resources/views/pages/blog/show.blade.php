@extends('layouts.app')

@section('title', $post->titulo . ' - Situação da Entrega')
@section('description', $post->resumo ?? Str::limit(strip_tags($post->conteudo), 160))
@section('og_image', $post->imagem_destaque ? asset($post->imagem_destaque) : asset('logo.svg'))

@section('head')
<!-- Meta Tags SEO -->
<meta property="og:type" content="article" />
<meta property="og:title" content="{{ $post->titulo }}" />
<meta property="og:description" content="{{ $post->resumo ?? Str::limit(strip_tags($post->conteudo), 160) }}" />
<meta property="og:url" content="{{ request()->url() }}" />
<meta property="article:published_time" content="{{ $post->published_at->toIso8601String() }}" />
<meta property="article:author" content="{{ $post->autor_nome }}" />

<!-- Fontes: Inter (UI) e Outfit (Headings) -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Outfit:wght@500;700;800&display=swap" rel="stylesheet">

<style>
    /* 
     * THEME: SaaS Blog Clean
     * Baseado na referência visual: Fundo claro, cards brancos, verde teal + azul, sidebar com TOC.
     */

    :root {
        /* Palette */
        --c-bg-page: #f2f5f9;
        /* Fundo da página (cinza azulado bem claro) */
        --c-bg-card: #ffffff;
        /* Fundo dos cards */

        --c-text-primary: #1e293b;
        /* Títulos */
        --c-text-body: #475569;
        /* Texto corrido */
        --c-text-light: #94a3b8;
        /* Metadados */

        --c-brand: #10b981;
        /* Verde Principal (Botões, Links) */
        --c-brand-dark: #047857;
        /* Verde Escuro (Hover) */
        --c-brand-light: #d1fae5;
        /* Verde Fundo Claro */

        --c-accent-blue: #3b82f6;
        /* Azul (Destaques secundários) */
        --c-accent-yellow: #fbbf24;
        /* Amarelo (Alertas) */
        --c-bg-warning: #fffbeb;
        /* Fundo Alerta */

        --border-radius: 12px;
        --shadow-soft: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
        --shadow-hover: 0 10px 15px -3px rgba(0, 0, 0, 0.08);

        --font-ui: 'Inter', sans-serif;
        --font-heading: 'Outfit', sans-serif;
    }

    body {
        background-color: var(--c-bg-page);
        font-family: var(--font-ui);
        color: var(--c-text-body);
        line-height: 1.6;
        -webkit-font-smoothing: antialiased;
    }

    /* --- LAYOUT GRID --- */
    .blog-layout {
        max-width: 1280px;
        margin: 0 auto;
        padding: 2rem 1.5rem;
        display: grid;
        grid-template-columns: 1fr 360px;
        /* Conteúdo | Sidebar */
        gap: 2.5rem;
        align-items: start;
    }

    /* --- HEADER DO ARTIGO (Fora do card) --- */
    .post-header-simple {
        grid-column: 1 / -1;
        margin-bottom: 1rem;
    }

    .breadcrumbs {
        font-size: 0.85rem;
        color: var(--c-text-light);
        margin-bottom: 1rem;
        display: flex;
        gap: 0.5rem;
        align-items: center;
    }

    .breadcrumbs a {
        text-decoration: none;
        color: var(--c-text-light);
        transition: color 0.2s;
    }

    .breadcrumbs a:hover {
        color: var(--c-brand);
    }

    .post-title-main {
        font-family: var(--font-heading);
        font-size: 3rem;
        line-height: 1.1;
        font-weight: 800;
        color: var(--c-text-primary);
        margin-bottom: 0.5rem;
        letter-spacing: -0.03em;
    }

    .post-subtitle-main {
        font-size: 1.25rem;
        color: var(--c-text-body);
        font-weight: 400;
        max-width: 800px;
        opacity: 0.9;
    }

    /* --- CARD DE CONTEÚDO --- */
    .post-content-card {
        background: var(--c-bg-card);
        border-radius: var(--border-radius);
        padding: 3rem;
        box-shadow: var(--shadow-soft);
    }

    /* Estilização do Texto (Typography) */
    .content-body {
        font-size: 1.125rem;
    }

    .content-body h2 {
        font-family: var(--font-heading);
        font-size: 1.75rem;
        color: var(--c-text-primary);
        margin-top: 2.5rem;
        margin-bottom: 1.25rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .content-body h3 {
        font-family: var(--font-heading);
        font-size: 1.4rem;
        color: var(--c-text-primary);
        margin-top: 2rem;
        margin-bottom: 1rem;
    }

    .content-body p {
        margin-bottom: 1.5rem;
    }

    .content-body ul,
    .content-body ol {
        margin-bottom: 2rem;
        padding-left: 1.5rem;
    }

    .content-body li {
        margin-bottom: 0.5rem;
    }

    /* Elementos Especiais (Baseados no Print) */

    /* 1. Tabela Comparativa */
    .content-body table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
        margin: 2rem 0;
        border-radius: 8px;
        overflow: hidden;
        border: 1px solid #e2e8f0;
    }

    .content-body th {
        background: #ecfdf5;
        /* Verde bem claro */
        color: #065f46;
        font-weight: 700;
        padding: 1rem;
        text-align: left;
        border-bottom: 1px solid #d1fae5;
    }

    .content-body td {
        padding: 1rem;
        border-bottom: 1px solid #f1f5f9;
        font-size: 0.95rem;
    }

    .content-body tr:last-child td {
        border-bottom: none;
    }

    .content-body tr:nth-child(even) {
        background-color: #fafafa;
    }

    /* 2. Alert Box (Amarelo) -> Usando blockquote como hook ou classe especifica */
    .alert-box,
    blockquote {
        background-color: var(--c-bg-warning);
        border-left: 5px solid var(--c-accent-yellow);
        padding: 1.5rem;
        margin: 2rem 0;
        border-radius: 0 8px 8px 0;
        color: #92400e;
        position: relative;
    }

    .alert-box strong,
    blockquote strong {
        display: block;
        margin-bottom: 0.5rem;
        color: #b45309;
    }

    /* 3. CTA Box (Verde) */
    .cta-box {
        background-color: #f0fdf4;
        border: 1px solid #bbf7d0;
        border-radius: 12px;
        padding: 2rem;
        text-align: center;
        margin: 2.5rem 0;
    }

    .cta-box h4 {
        color: #166534;
        font-size: 1.25rem;
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
    }

    .btn-cta-green {
        display: inline-block;
        background-color: var(--c-brand);
        color: white;
        font-weight: 600;
        padding: 0.8rem 2rem;
        border-radius: 6px;
        text-decoration: none;
        transition: background 0.2s;
        box-shadow: 0 4px 6px -1px rgba(16, 185, 129, 0.4);
    }

    .btn-cta-green:hover {
        background-color: var(--c-brand-dark);
        transform: translateY(-1px);
    }

    /* --- SIDEBAR --- */
    .sidebar-widget {
        background: var(--c-bg-card);
        border-radius: var(--border-radius);
        padding: 1.5rem;
        margin-bottom: 2rem;
        box-shadow: var(--shadow-soft);
        border: 1px solid rgba(0, 0, 0, 0.03);
    }

    .widget-title {
        font-family: var(--font-heading);
        font-size: 1.1rem;
        font-weight: 700;
        color: var(--c-text-primary);
        margin-bottom: 1rem;
        display: block;
    }

    /* Table of Contents (TOC) */
    .toc-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .toc-list li {
        margin-bottom: 0.75rem;
        position: relative;
        padding-left: 1.2rem;
    }

    .toc-list li::before {
        content: '→';
        position: absolute;
        left: 0;
        color: var(--c-brand);
        font-size: 0.8rem;
        top: 2px;
    }

    .toc-list a {
        text-decoration: none;
        color: var(--c-text-body);
        font-size: 0.95rem;
        transition: color 0.2s;
    }

    .toc-list a:hover {
        color: var(--c-brand);
        font-weight: 500;
    }

    /* Calculadora Widget */
    .calc-input {
        width: 100%;
        padding: 0.8rem;
        border: 1px solid #e2e8f0;
        border-radius: 6px;
        margin-bottom: 1rem;
    }

    .btn-calc-sidebar {
        width: 100%;
        background-color: var(--c-brand);
        color: white;
        border: none;
        padding: 0.8rem;
        border-radius: 6px;
        font-weight: 600;
        cursor: pointer;
    }

    /* Floating CTA */
    .floating-cta {
        position: fixed;
        bottom: 2rem;
        right: 2rem;
        background: var(--c-brand);
        color: white;
        padding: 1rem 1.5rem;
        border-radius: 50px;
        font-weight: 600;
        box-shadow: 0 10px 15px -3px rgba(16, 185, 129, 0.4);
        display: flex;
        align-items: center;
        gap: 0.5rem;
        z-index: 100;
        transition: transform 0.2s;
        text-decoration: none;
    }

    .floating-cta:hover {
        transform: scale(1.05);
    }

    /* Responsividade */
    @media (max-width: 1024px) {
        .blog-layout {
            grid-template-columns: 1fr;
        }

        .post-content-card {
            padding: 2rem;
        }

        .sidebar {
            order: 2;
        }
    }

    @media (max-width: 768px) {
        .post-title-main {
            font-size: 2.2rem;
        }

        .blog-layout {
            padding: 1rem;
        }

        .post-content-card {
            padding: 1.5rem;
        }

        .breadcrumbs {
            display: none;
        }

        /* Simplificar no mobile */
    }
</style>
@endsection

@section('content')
<div class="blog-layout">

    <!-- Header Full Width -->
    <header class="post-header-simple">
        <nav class="breadcrumbs">
            <a href="{{ route('home') }}">Home</a>
            <span>›</span>
            <a href="{{ route('blog.index') }}">Blog</a>
            <span>›</span>
            <span>{{ $post->titulo }}</span>
        </nav>

        <h1 class="post-title-main">{{ $post->titulo }}</h1>
        @if($post->subtitulo)
        <p class="post-subtitle-main">{{ $post->subtitulo }}</p>
        @endif
    </header>

    <!-- Main Content -->
    <main class="post-content-card">
        <!-- Meta Data Inline -->
        <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 2rem; border-bottom: 1px solid #f1f5f9; padding-bottom: 1.5rem;">
            <div style="width: 40px; height: 40px; background: #e2e8f0; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: bold; color: #64748b;">
                {{ substr($post->autor_nome, 0, 1) }}
            </div>
            <div>
                <div style="font-weight: 600; color: var(--c-text-primary);">{{ $post->autor_nome }}</div>
                <div style="font-size: 0.85rem; color: var(--c-text-light);">
                    Atualizado em {{ $post->updated_at->format('d/m/Y') }} · 6 min de leitura
                </div>
            </div>
        </div>

        @if($post->imagem_destaque)
        <img src="{{ asset($post->imagem_destaque) }}" alt="{{ $post->titulo }}" style="width: 100%; border-radius: 8px; margin-bottom: 2rem;">
        @endif

        <!-- SGE Summary Box (Estilo "Vale a Pena?" do print) -->
        @if($post->sge_summary)
        <div class="cta-box" style="background: #f0f9ff; border-color: #bae6fd; text-align: left;">
            <h4 style="color: #0369a1; justify-content: flex-start;">
                <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z"></path>
                </svg>
                Resumo do Especialista
            </h4>
            <p style="margin-bottom: 0;">{!! Str::markdown($post->sge_summary) !!}</p>
        </div>
        @endif

        <!-- Conteúdo do Post -->
        <div class="content-body" id="post-body">
            {!! $post->conteudo_formatado !!}

            <!-- Exemplo de CTA Injetado (Fim do post) -->
            <div class="cta-box">
                <h4>
                    <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10"></circle>
                        <path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"></path>
                        <line x1="12" y1="17" x2="12.01" y2="17"></line>
                    </svg>
                    Ainda com dúvidas?
                </h4>
                <p>Nossa comunidade de importadores está pronta para ajudar.</p>
                <a href="#comentarios" class="btn-cta-green">Ver Comentários</a>
            </div>
        </div>
    </main>

    <!-- Sidebar Sticky -->
    <aside class="sidebar">
        <!-- Widget: TOC (Índice) -->
        <div class="sidebar-widget">
            <span class="widget-title">Neste artigo</span>
            <ul class="toc-list" id="toc-list">
                <!-- Gerado via JS -->
            </ul>
        </div>

        <!-- Widget: Calculadora -->
        <div class="sidebar-widget">
            <span class="widget-title">Calculadora de Transporte</span>
            <p style="font-size: 0.9rem; margin-bottom: 1rem; color: #64748b;">Simule o custo real da sua encomenda.</p>
            <input type="text" class="calc-input" placeholder="Valor do item (R$)">
            <button class="btn-calc-sidebar">Simular custo › </button>
        </div>

        <!-- Widget: Leia Também -->
        @if(isset($maisLidos) && $maisLidos->count() > 0)
        <div class="sidebar-widget">
            <span class="widget-title">Leia também</span>
            <div style="display: flex; flex-direction: column; gap: 1rem;">
                @foreach($maisLidos->take(3) as $postLido)
                <a href="{{ route('blog.show', $postLido->slug) }}" style="display: flex; gap: 0.8rem; text-decoration: none; align-items: flex-start;">
                    <div style="width: 40px; height: 40px; background: #e2e8f0; border-radius: 4px; flex-shrink: 0; overflow: hidden;">
                        @if($postLido->imagem_destaque)
                        <img src="{{ asset($postLido->imagem_destaque) }}" style="width: 100%; height: 100%; object-fit: cover;">
                        @endif
                    </div>
                    <div>
                        <div style="font-weight: 600; font-size: 0.9rem; color: var(--c-text-primary); line-height: 1.3;">{{ $postLido->titulo }}</div>
                        <div style="font-size: 0.75rem; color: var(--c-text-light);">Por {{ Str::words($postLido->autor_nome, 1, '') }}</div>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
        @endif
    </aside>
</div>

<!-- Floating CTA -->
<a href="{{ route('calculadora.taxas') }}" class="floating-cta">
    <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2">
        <rect x="2" y="3" width="20" height="14" rx="2" ry="2"></rect>
        <line x1="8" y1="21" x2="16" y2="21"></line>
        <line x1="12" y1="17" x2="12" y2="21"></line>
    </svg>
    Simular custo do Valor Declarado
</a>

<script>
    // Gerar Índice (Table of Contents) Automaticamente
    document.addEventListener('DOMContentLoaded', function() {
        const content = document.getElementById('post-body');
        const tocList = document.getElementById('toc-list');
        const headings = content.querySelectorAll('h2, h3');

        if (headings.length === 0) {
            document.querySelector('.sidebar-widget').style.display = 'none'; // Esconde widget se não tiver títulos
            return;
        }

        headings.forEach((heading, index) => {
            const id = 'heading-' + index;
            heading.id = id;

            const li = document.createElement('li');
            const a = document.createElement('a');
            a.href = '#' + id;
            a.textContent = heading.textContent;

            // Indentação para H3
            if (heading.tagName === 'H3') {
                li.style.paddingLeft = '2.5rem';
                a.style.fontSize = '0.9rem';
            }

            li.appendChild(a);
            tocList.appendChild(li);
        });
    });
</script>
@endsection