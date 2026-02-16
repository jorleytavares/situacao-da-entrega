@extends('layouts.app')

@section('title', $post->titulo . ' - Situação da Entrega')
@section('description', $post->resumo ?? Str::limit(strip_tags($post->conteudo), 160))
@section('og_image', $post->imagem_destaque ? asset($post->imagem_destaque) : asset('logo.svg'))

@section('head')
<meta property="og:type" content="article" />
<meta property="og:title" content="{{ $post->titulo }}" />
<meta property="og:description" content="{{ $post->resumo ?? Str::limit(strip_tags($post->conteudo), 160) }}" />
<meta property="og:url" content="{{ request()->url() }}" />
<meta property="og:site_name" content="{{ config('app.name', 'Situação da Entrega') }}" />
<meta property="article:published_time" content="{{ $post->published_at->toIso8601String() }}" />
<meta property="article:author" content="{{ $post->autor_nome }}" />

<!-- Fonte Google (Sans Serif moderna + Serifada display opcional) -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Outfit:wght@500;700;800&display=swap" rel="stylesheet">

<style>
    /* --- CRITICAL CSS INJETADO --- */
    /* Garante que o layout carregue mesmo se o arquivo externo falhar */

    :root {
        --c-bg: #f8fafc;
        --c-card: #ffffff;
        --c-text-main: #1e293b;
        /* Slate 800 */
        --c-text-body: #334155;
        /* Slate 700 */
        --c-text-meta: #64748b;
        /* Slate 500 */
        --c-primary: #0f766e;
        /* Teal 700 */
        --c-accent: #14b8a6;
        /* Teal 500 */
        --c-border: #e2e8f0;

        --font-sans: 'Inter', system-ui, -apple-system, sans-serif;
        --font-display: 'Outfit', sans-serif;

        --shadow-card: 0 10px 15px -3px rgba(0, 0, 0, 0.03), 0 4px 6px -2px rgba(0, 0, 0, 0.02);
    }

    body {
        background-color: var(--c-bg) !important;
        font-family: var(--font-sans) !important;
        color: var(--c-text-body) !important;
        -webkit-font-smoothing: antialiased;
    }

    /* Layout Wrapper */
    .editorial-wrapper {
        max-width: 1200px;
        margin: 3rem auto;
        padding: 0 1.5rem;
        display: grid;
        grid-template-columns: 1fr 340px;
        gap: 3rem;
        align-items: start;
    }

    /* Main Article Card */
    .article-card {
        background: var(--c-card);
        border-radius: 16px;
        box-shadow: var(--shadow-card);
        border: 1px solid var(--c-border);
        overflow: hidden;
    }

    /* Header */
    .article-header {
        padding: 3rem 4rem 2rem;
        border-bottom: 1px solid var(--c-border);
        background: linear-gradient(to bottom, #fff, #f8fafc);
    }

    .breadcrumbs {
        display: flex;
        gap: 0.5rem;
        align-items: center;
        font-size: 0.85rem;
        font-weight: 600;
        color: var(--c-text-meta);
        margin-bottom: 1.5rem;
        text-transform: uppercase;
        letter-spacing: 0.02em;
    }

    .breadcrumbs a {
        color: var(--c-primary);
        text-decoration: none;
        background: #f0fdfa;
        padding: 2px 10px;
        border-radius: 20px;
    }

    .article-title {
        font-family: var(--font-display);
        font-size: 2.75rem;
        line-height: 1.1;
        letter-spacing: -0.02em;
        color: #0f172a;
        margin-bottom: 1rem;
        font-weight: 800;
    }

    .article-subtitle {
        font-size: 1.25rem;
        color: var(--c-text-meta);
        line-height: 1.5;
        margin-bottom: 2rem;
        font-weight: 400;
    }

    .article-meta {
        display: flex;
        gap: 1.5rem;
        font-size: 0.9rem;
        color: var(--c-text-meta);
        font-weight: 500;
        flex-wrap: wrap;
    }

    .meta-pill {
        display: flex;
        align-items: center;
        gap: 0.4rem;
    }

    /* Conteúdo */
    .article-content-wrapper {
        padding: 3rem 4rem;
        max-width: 720px;
        /* Largura ideal para leitura */
        margin: 0 auto;
    }

    .article-body {
        font-size: 1.125rem;
        /* 18px */
        line-height: 1.8;
        color: var(--c-text-body);
    }

    .article-body p {
        margin-bottom: 1.8em;
    }

    .article-body h2 {
        font-family: var(--font-display);
        font-size: 1.8rem;
        color: #1e293b;
        margin-top: 3rem;
        margin-bottom: 1.2rem;
        font-weight: 700;
        letter-spacing: -0.01em;
        position: relative;
    }

    .article-body h2::before {
        content: '';
        position: absolute;
        left: -1.5rem;
        top: 0.5rem;
        bottom: 0.5rem;
        width: 4px;
        background: var(--c-accent);
        opacity: 0.3;
        border-radius: 4px;
    }

    .article-body h3 {
        font-family: var(--font-display);
        font-size: 1.4rem;
        color: #334155;
        margin-top: 2.5rem;
        margin-bottom: 1rem;
        font-weight: 600;
    }

    .article-body ul {
        margin-bottom: 2rem;
        padding-left: 1.5rem;
    }

    .article-body li {
        margin-bottom: 0.75rem;
        position: relative;
    }

    .article-body li::marker {
        color: var(--c-accent);
        font-weight: bold;
    }

    /* Links Contextuais */
    .article-body a {
        color: var(--c-primary);
        text-decoration: underline;
        text-decoration-thickness: 2px;
        text-underline-offset: 3px;
        text-decoration-color: rgba(15, 118, 110, 0.2);
        font-weight: 600;
        transition: all 0.2s;
    }

    .article-body a:hover {
        background: #ccfbf1;
        text-decoration-color: var(--c-primary);
    }

    /* Entity Box (SGE Summary) */
    .entity-box {
        background: #effefb;
        border: 1px solid #ccfbf1;
        border-radius: 12px;
        padding: 2rem;
        margin: 2.5rem 0;
        box-shadow: 0 4px 6px -4px rgba(20, 184, 166, 0.1);
        position: relative;
    }

    .entity-label {
        display: inline-block;
        background: #fff;
        color: var(--c-primary);
        font-weight: 700;
        font-size: 0.8rem;
        padding: 0.4rem 1rem;
        border-radius: 20px;
        border: 1px solid #ccfbf1;
        margin-bottom: 1rem;
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
    }

    /* Sidebar */
    .sidebar-sticky {
        position: sticky;
        top: 2rem;
        display: flex;
        flex-direction: column;
        gap: 2rem;
    }

    .widget {
        background: #fff;
        padding: 1.5rem;
        border-radius: 12px;
        border: 1px solid var(--c-border);
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
    }

    .widget h3 {
        font-family: var(--font-display);
        font-size: 1.1rem;
        color: #1e293b;
        margin-bottom: 1.5rem;
        padding-bottom: 0.75rem;
        border-bottom: 2px solid #f1f5f9;
        font-weight: 700;
    }

    .widget-calc {
        background: linear-gradient(135deg, #0f766e, #115e59);
        color: white;
        text-align: center;
        border: none;
    }

    .widget-calc h3 {
        color: white;
        border-color: rgba(255, 255, 255, 0.2);
    }

    .btn-calc {
        display: block;
        background: white;
        color: #0f766e;
        padding: 1rem;
        border-radius: 8px;
        font-weight: 700;
        text-decoration: none;
        transition: transform 0.2s;
    }

    .btn-calc:hover {
        transform: translateY(-2px);
    }

    /* Mais Lidos */
    .popular-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .popular-item {
        display: flex;
        gap: 1rem;
        margin-bottom: 1.25rem;
        align-items: flex-start;
    }

    .popular-number {
        font-size: 1.5rem;
        font-weight: 900;
        color: #e2e8f0;
        line-height: 1;
        min-width: 1.5rem;
    }

    .popular-title {
        font-size: 0.95rem;
        color: #475569;
        font-weight: 600;
        text-decoration: none;
        line-height: 1.4;
    }

    .popular-title:hover {
        color: var(--c-primary);
    }

    /* Responsividade */
    @media (max-width: 1024px) {
        .editorial-wrapper {
            grid-template-columns: 1fr;
        }

        .article-content-wrapper {
            padding: 2rem;
        }
    }

    @media (max-width: 768px) {
        .editorial-wrapper {
            padding: 0 1rem;
            margin: 1.5rem auto;
            gap: 2rem;
        }

        .article-header {
            padding: 2rem 1.5rem;
        }

        .article-title {
            font-size: 2rem;
        }

        .article-content-wrapper {
            padding: 1.5rem;
        }
    }
</style>
@endsection

@section('content')
<div class="editorial-wrapper">
    <!-- Main Content -->
    <main class="article-card">
        <header class="article-header">
            <nav class="breadcrumbs">
                <a href="{{ route('home') }}">Home</a>
                <span>/</span>
                <a href="{{ route('blog.index') }}">Blog</a>
                <span>/</span>
                <span>Tutoriais</span>
            </nav>

            <h1 class="article-title">{{ $post->titulo }}</h1>

            @if($post->subtitulo)
            <p class="article-subtitle">{{ $post->subtitulo }}</p>
            @endif

            <div class="article-meta">
                <span class="meta-pill">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                        <line x1="16" y1="2" x2="16" y2="6"></line>
                        <line x1="8" y1="2" x2="8" y2="6"></line>
                        <line x1="3" y1="10" x2="21" y2="10"></line>
                    </svg>
                    {{ $post->published_at->format('d \d\e F, Y') }}
                </span>
                <span class="meta-pill">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10"></circle>
                        <polyline points="12 6 12 12 16 14"></polyline>
                    </svg>
                    6 min de leitura
                </span>
            </div>
        </header>

        @if($post->imagem_destaque)
        <div style="background: #f1f5f9; padding: 2rem 0; text-align: center; border-bottom: 1px solid #e2e8f0;">
            <img src="{{ asset($post->imagem_destaque) }}"
                alt="{{ $post->imagem_alt ?? $post->titulo }}"
                style="max-width: 90%; height: auto; max-height: 500px; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1); border-radius: 8px; display: inline-block;">
            @if($post->imagem_legenda)
            <div style="font-size: 0.85rem; color: #64748b; margin-top: 1rem; font-style: italic;">
                {{ $post->imagem_legenda }}
            </div>
            @endif
        </div>
        @endif

        <div class="article-content-wrapper">
            @if($post->sge_summary)
            <div class="entity-box">
                <div class="entity-label">RESUMO RÁPIDO</div>
                <div style="color: #334155;">
                    {!! Str::markdown($post->sge_summary) !!}
                </div>
            </div>
            @endif

            <article class="article-body">
                {!! $post->conteudo_formatado !!}
            </article>

            <!-- CTA Comments -->
            <div style="margin-top: 4rem; padding: 3rem; background: #f8fafc; border-radius: 12px; text-align: center; border: 1px dashed #cbd5e1;">
                <h3 style="font-family: var(--font-display); color: #1e293b; margin-bottom: 0.5rem; font-size: 1.5rem;">Dúvidas sobre sua entrega?</h3>
                <p style="color: #64748b; margin-bottom: 2rem;">Nossa comunidade e especialistas respondem em poucos minutos.</p>
                <a href="#comentarios" style="display: inline-block; background: #0f766e; color: white; padding: 1rem 2.5rem; border-radius: 99px; text-decoration: none; font-weight: 700; box-shadow: 0 4px 6px -1px rgba(15, 118, 110, 0.3); transition: transform 0.2s;">
                    Deixar Comentário
                </a>
            </div>

            <!-- Author -->
            <div style="margin-top: 3rem; padding-top: 2rem; border-top: 1px solid #e2e8f0; display: flex; align-items: center; gap: 1rem;">
                <div style="width: 60px; height: 60px; background: linear-gradient(135deg, #14b8a6, #0f766e); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-weight: 700; font-size: 1.5rem;">
                    {{ substr($post->autor_nome, 0, 1) }}
                </div>
                <div>
                    <strong style="display: block; color: #1e293b; font-size: 1.1rem; margin-bottom: 0.2rem;">{{ $post->autor_nome }}</strong>
                    <span style="color: #64748b; font-size: 0.95rem;">Especialista em Logística e Importação</span>
                </div>
            </div>
        </div>
    </main>

    <!-- Sidebar -->
    <aside class="sidebar-sticky">
        <div class="widget widget-calc">
            <h3>Calculadora de Importação</h3>
            <p style="color: #ccfbf1; margin-bottom: 1.5rem; font-size: 0.95rem;">Descubra exatamente quanto vai pagar de taxas antes do produto chegar.</p>
            <a href="{{ route('calculadora.taxas') }}" class="btn-calc">Simular Agora</a>
        </div>

        @if(isset($maisLidos) && $maisLidos->count() > 0)
        <div class="widget">
            <h3>Mais Lidos</h3>
            <ul class="popular-list">
                @foreach($maisLidos as $index => $postLido)
                <li class="popular-item">
                    <span class="popular-number">{{ $index + 1 }}</span>
                    <a href="{{ route('blog.show', $postLido->slug) }}" class="popular-title">
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