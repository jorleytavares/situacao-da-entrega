@extends('layouts.app')

@section('title', $post->titulo . ' - Situação da Entrega')
@section('description', $post->resumo ?? Str::limit(strip_tags($post->conteudo), 160))
@section('og_image', $post->imagem_destaque ? asset($post->imagem_destaque) : asset('logo.svg'))

@section('head')
<!-- CSS Local do Post (Versionado) -->
<link rel="stylesheet" href="{{ asset('css/post-theme.css') }}?v={{ filemtime(public_path('css/post-theme.css')) }}">

<!-- Meta SEO -->
<meta property="og:type" content="article" />
<meta property="og:title" content="{{ $post->titulo }}" />
<meta property="og:description" content="{{ $post->resumo ?? Str::limit(strip_tags($post->conteudo), 160) }}" />
<meta property="og:url" content="{{ request()->url() }}" />
<meta property="article:published_time" content="{{ $post->published_at->toIso8601String() }}" />
<meta property="article:author" content="{{ $post->autor_nome }}" />
@endsection

@section('content')

{{-- ======== HEADER LARGURA TOTAL ======== --}}
<div class="blog-header-wrapper">
    <div class="blog-header-content">
        {{-- Breadcrumbs --}}
        <nav class="breadcrumbs">
            <a href="{{ route('home') }}">Home</a>
            <span>›</span>
            <a href="{{ route('blog.index') }}">Blog</a>
            <span>›</span>
            <span>Artigo</span>
        </nav>

        {{-- Título --}}
        <h1 class="post-title-main">{{ $post->titulo }}</h1>

        @if($post->subtitulo)
        <p class="post-subtitle-main">{{ $post->subtitulo }}</p>
        @endif
    </div>
</div>

<div class="blog-layout-wrapper">

    {{-- ======== COLUNA PRINCIPAL ======== --}}
    <div class="post-main-column">

        {{-- Card de Conteúdo --}}
        <div class="post-content-card">

            {{-- Meta: Autor + Data --}}
            <div class="post-meta-header">
                <div class="author-avatar-sm">{{ substr($post->autor_nome, 0, 1) }}</div>
                <div class="author-details">
                    <span class="author-name">{{ $post->autor_nome }}</span>
                    <span class="post-date">Atualizado em {{ $post->updated_at->format('d/m/Y') }} · 6 min de leitura</span>
                </div>
            </div>

            {{-- Imagem Destaque --}}
            @if($post->imagem_destaque)
            <figure class="post-featured-figure">
                <img src="{{ asset($post->imagem_destaque) }}"
                    alt="{{ $post->imagem_alt ?? $post->titulo }}"
                    width="800" height="450">
                @if($post->imagem_legenda)
                <figcaption class="post-featured-caption">{{ $post->imagem_legenda }}</figcaption>
                @endif
            </figure>
            @endif

            {{-- Box: Resumo do Especialista --}}
            @if($post->sge_summary)
            <div class="cta-box-blue">
                <div class="cta-header-blue">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z"></path>
                    </svg>
                    Resumo do Especialista
                </div>
                <div class="content-body">
                    {!! Str::markdown($post->sge_summary) !!}
                </div>
            </div>
            @endif

            {{-- Corpo do Texto --}}
            <article class="content-body" id="post-body">
                {!! $post->conteudo_formatado !!}
            </article>

            {{-- CTA Final --}}
            <div class="cta-box-green">
                <h3>Ficou com alguma dúvida?</h3>
                <p>Nossa comunidade de importadores está pronta para ajudar.</p>
                <a href="#comentarios" class="btn-cta-green">Deixar Comentário</a>
            </div>

            {{-- Seção de Comentários --}}
            <section id="comentarios" class="comments-section">
                <h3 class="comments-title">Comentários (0)</h3>

                <div id="comment-success" style="display: none; background: var(--em-50); color: var(--em-800); padding: 2rem; border-radius: var(--radius); border: 1px solid var(--em-100); text-align: center;">
                    <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="margin-bottom: 1rem; color: var(--brand);">
                        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                        <polyline points="22 4 12 14.01 9 11.01"></polyline>
                    </svg>
                    <h3 style="margin-bottom: 0.5rem; font-size: 1.25rem;">Comentário enviado!</h3>
                    <p>Sua mensagem foi recebida e aparecerá aqui após a aprovação da nossa equipe.</p>
                </div>

                <form id="comment-form" class="comment-form" onsubmit="handleCommentSubmit(event)">
                    <div class="form-group">
                        <textarea name="mensagem" placeholder="Escreva sua dúvida ou experiência..." rows="4" class="calc-input" style="width: 100%; resize: vertical;" required></textarea>
                    </div>
                    <div class="form-row" style="gap: 1rem; margin-top: 1rem;">
                        <input type="text" name="nome" placeholder="Seu Nome" class="calc-input" style="flex: 1;" required>
                        <input type="email" name="email" placeholder="Seu E-mail (não será publicado)" class="calc-input" style="flex: 1;" required>
                    </div>
                    <button type="submit" class="btn-cta-green" style="margin-top: 1rem; width: auto; padding-left: 2rem; padding-right: 2rem;">
                        Publicar Comentário
                    </button>
                    <p style="font-size: 0.8rem; color: var(--text-meta); margin-top: 1rem;">
                        * Seus dados estão seguros. Comentários são moderados.
                    </p>
                </form>

                <script>
                    function handleCommentSubmit(e) {
                        e.preventDefault();
                        // Simulação visual de envio
                        const btn = e.target.querySelector('button[type="submit"]');
                        const originalText = btn.innerText;

                        btn.disabled = true;
                        btn.innerText = 'Enviando...';

                        setTimeout(() => {
                            document.getElementById('comment-form').style.display = 'none';
                            document.getElementById('comment-success').style.display = 'block';
                            // Rola suave para a mensagem
                            document.getElementById('comentarios').scrollIntoView({
                                behavior: 'smooth'
                            });
                        }, 1000);
                    }
                </script>

                <div class="comments-list">
                    <div style="text-align: center; padding: 2rem; color: var(--text-meta); background: var(--bg-page); border-radius: var(--radius); margin-top: 2rem;">
                        Seja o primeiro a comentar!
                    </div>
                </div>
            </section>
        </div>
    </div>

    {{-- ======== SIDEBAR ======== --}}
    <aside class="sidebar-sticky">

        {{-- Widget: Índice do Artigo (TOC) --}}
        <div class="sidebar-widget toc-widget" id="widget-toc" style="display:none">
            <span class="widget-title">Neste artigo</span>
            <ul class="toc-list" id="toc-list"></ul>
        </div>

        {{-- Widget: Calculadora --}}
        <div class="sidebar-widget">
            <span class="widget-title">Calculadora de Taxas</span>
            <span class="calc-label">Simule quanto vai pagar de imposto.</span>
            <form action="{{ route('calculadora.taxas') }}" method="GET">
                <input type="number" name="valor" class="calc-input" placeholder="Valor do item (R$)">
                <button type="submit" class="btn-calc-sidebar">Simular custo ›</button>
            </form>
        </div>

        {{-- Widget: Leia Também --}}
        @if(isset($maisLidos) && $maisLidos->count() > 0)
        <div class="sidebar-widget">
            <span class="widget-title">Leia também</span>
            <div class="read-more-list">
                @foreach($maisLidos->take(4) as $postLido)
                <a href="{{ route('blog.show', $postLido->slug) }}" class="read-more-item">
                    <div class="read-more-icon">
                        @if($postLido->imagem_destaque)
                        <img src="{{ asset($postLido->imagem_destaque) }}" alt="">
                        @else
                        <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V9a2 2 0 012-2h2a2 2 0 012 2v9a2 2 0 01-2 2h-2z"></path>
                        </svg>
                        @endif
                    </div>
                    <div class="read-more-info">
                        <div class="read-more-title">{{ $postLido->titulo }}</div>
                        <span class="read-more-author">Por {{ $postLido->autor_nome }}</span>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
        @endif

    </aside>
</div>

{{-- Botão Flutuante --}}
<a href="{{ route('calculadora.taxas') }}" class="floating-cta" title="Simular Taxas">
    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <rect x="2" y="3" width="20" height="14" rx="2"></rect>
        <line x1="8" y1="21" x2="16" y2="21"></line>
        <line x1="12" y1="17" x2="12" y2="21"></line>
    </svg>
    <span>Simular Taxas</span>
</a>

{{-- Script: Gerador de TOC --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var body = document.getElementById('post-body');
        var list = document.getElementById('toc-list');
        var widget = document.getElementById('widget-toc');
        if (!body || !list) return;

        var headings = body.querySelectorAll('h2, h3');
        if (headings.length === 0) return;

        widget.style.display = 'block';
        for (var i = 0; i < headings.length; i++) {
            var h = headings[i];
            var id = 'sec-' + i;
            h.id = id;

            var li = document.createElement('li');
            var a = document.createElement('a');
            a.href = '#' + id;
            a.textContent = h.textContent;

            if (h.tagName === 'H3') {
                a.style.paddingLeft = '1.5rem';
                a.style.fontSize = '0.85rem';
            }

            li.appendChild(a);
            list.appendChild(li);
        }
    });
</script>
@endsection