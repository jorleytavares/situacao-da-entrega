@extends('layouts.app')

@section('title', 'Busca por: ' . $query . ' | Situação da Entrega')
@section('description', 'Resultados da busca por ' . $query . ' no Situação da Entrega.')

@section('content')

<div class="bloco" style="margin-bottom: 2rem; background: linear-gradient(to right, #f8fafc, #ffffff);">
    <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 1rem;">
        <div>
            <span style="font-size: 0.875rem; color: var(--cor-texto-secundario); text-transform: uppercase; letter-spacing: 0.05em;">Resultado da busca</span>
            <h1 class="bloco-titulo" style="font-size: 1.8rem; margin-bottom: 0.5rem; color: var(--cor-texto);">
                "{{ $query }}"
            </h1>
            <p class="bloco-texto">
                Encontramos <strong>{{ $problemas->count() + $transportadoras->count() + $posts->count() }}</strong> registros no nosso sistema.
            </p>
        </div>
        
        <!-- Refazer busca (Compacta) -->
        <form action="{{ route('busca') }}" method="GET" style="display: flex; gap: 0.5rem; width: 100%; max-width: 400px;">
            <div style="position: relative; width: 100%;">
                <input type="search" name="q" value="{{ $query }}" class="form-control" placeholder="Pesquisar novamente..." style="width: 100%; padding: 0.7rem 1rem 0.7rem 2.5rem; border: 1px solid var(--cor-borda); border-radius: 8px; font-size: 0.95rem;">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="position: absolute; left: 10px; top: 50%; transform: translateY(-50%); color: #9ca3af;"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
            </div>
            <button type="submit" class="botao" style="padding: 0.7rem 1.2rem; cursor: pointer;">Buscar</button>
        </form>
    </div>
</div>

@if($problemas->count() == 0 && $transportadoras->count() == 0 && $posts->count() == 0)
    <!-- Estado Vazio Criativo -->
    <section class="bloco" style="text-align: center; padding: 4rem 2rem; display: flex; flex-direction: column; align-items: center;">
        <svg width="180" height="180" viewBox="0 0 200 200" fill="none" xmlns="http://www.w3.org/2000/svg" style="margin-bottom: 2rem; opacity: 0.8;">
            <circle cx="100" cy="100" r="90" fill="#F3F4F6"/>
            <path d="M60 100H140" stroke="#D1D5DB" stroke-width="4" stroke-linecap="round"/>
            <path d="M100 60V140" stroke="#D1D5DB" stroke-width="4" stroke-linecap="round"/>
            <path d="M65 65L135 135" stroke="#E5E7EB" stroke-width="4" stroke-linecap="round"/>
            <path d="M135 65L65 135" stroke="#E5E7EB" stroke-width="4" stroke-linecap="round"/>
            <rect x="85" y="85" width="30" height="30" rx="4" fill="#9CA3AF" opacity="0.5"/>
            <path d="M120 130C120 130 140 160 170 160" stroke="#FCA5A5" stroke-width="3" stroke-dasharray="6 6"/>
            <circle cx="175" cy="160" r="5" fill="#EF4444"/>
        </svg>

        <h3 style="color: var(--cor-texto); font-size: 1.5rem; margin-bottom: 1rem;">Nada encontrado no galpão</h3>
        <p class="bloco-texto" style="max-width: 500px; margin: 0 auto 2rem auto;">
            Reviramos todas as prateleiras, mas não encontramos nada relacionado a "<strong>{{ $query }}</strong>".
        </p>

        <div style="background: #eff6ff; padding: 1.5rem; border-radius: 12px; max-width: 600px; width: 100%;">
            <p style="font-weight: 600; color: #1e40af; margin-bottom: 0.5rem;">Dicas para encontrar o que procura:</p>
            <ul style="text-align: left; color: #3b82f6; font-size: 0.95rem; line-height: 1.6; list-style-type: disc; padding-left: 1.5rem;">
                <li>Verifique se há erros de digitação (ex: "Coreios" em vez de "Correios").</li>
                <li>Tente usar termos mais genéricos (ex: "Taxa", "Atraso", "Reembolso").</li>
                <li>Se for um status específico, tente digitar apenas parte dele.</li>
            </ul>
        </div>
        
        <div style="margin-top: 2rem;">
            <a href="{{ route('home') }}" class="botao" style="display: inline-block;">Voltar ao Início</a>
        </div>
    </section>
@else
    <!-- Resultados Encontrados -->
    <div style="display: grid; gap: 2rem;">
        
        @if($problemas->count() > 0)
        <section>
            <h2 class="bloco-titulo" style="display: flex; align-items: center; gap: 0.5rem; font-size: 1.4rem; margin-bottom: 1rem;">
                <span style="background: #fee2e2; color: #ef4444; padding: 4px 8px; border-radius: 6px; font-size: 1.2rem;">⚠️</span>
                Problemas e Status
            </h2>
            <div id="id-lista-problemas">
                @foreach($problemas as $problema)
                <a href="{{ route('problema.mostrar', $problema->slug) }}" class="card-problema">
                    <div style="background: #fff1f2; padding: 8px; border-radius: 50%; display: flex;">
                        <x-icon name="{{ $problema->slug }}" size="24" color="#F15C6D" />
                    </div>
                    <div style="flex: 1;">
                        <strong style="display: block; font-size: 1.1rem; margin-bottom: 0.2rem;">{{ $problema->titulo }}</strong>
                        <span style="color: var(--cor-texto-secundario); font-size: 0.9rem;">{{ $problema->descricao_curta }}</span>
                    </div>
                    <x-icon name="chevron-right" size="20" color="#ccc" />
                </a>
                @endforeach
            </div>
        </section>
        @endif

        @if($transportadoras->count() > 0)
        <section>
            <h2 class="bloco-titulo" style="display: flex; align-items: center; gap: 0.5rem; font-size: 1.4rem; margin-bottom: 1rem;">
                <span style="background: #dcfce7; color: #22c55e; padding: 4px 8px; border-radius: 6px; font-size: 1.2rem;">🚚</span>
                Transportadoras
            </h2>
            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 1rem;">
                @foreach($transportadoras as $t)
                <a href="{{ route('transportadora.mostrar', $t->slug) }}" class="bloco" style="text-decoration: none; display: flex; align-items: center; gap: 1rem; transition: transform 0.2s; border: 1px solid var(--cor-borda);">
                    @if($t->logo)
                        <img src="{{ asset($t->logo) }}" alt="{{ $t->nome }}" width="40" height="40" style="object-fit: contain;">
                    @else
                        <div style="width: 40px; height: 40px; background: #f3f4f6; border-radius: 8px; display: flex; align-items: center; justify-content: center; font-weight: bold; color: #6b7280;">
                            {{ substr($t->nome, 0, 1) }}
                        </div>
                    @endif
                    <span style="font-weight: 600; color: var(--cor-texto);">{{ $t->nome }}</span>
                </a>
                @endforeach
            </div>
        </section>
        @endif

        @if($posts->count() > 0)
        <section>
            <h2 class="bloco-titulo" style="display: flex; align-items: center; gap: 0.5rem; font-size: 1.4rem; margin-bottom: 1rem;">
                <span style="background: #e0f2fe; color: #0ea5e9; padding: 4px 8px; border-radius: 6px; font-size: 1.2rem;">📝</span>
                Artigos e Dicas
            </h2>
            <div style="display: grid; gap: 1rem;">
                @foreach($posts as $post)
                <a href="{{ route('blog.show', $post->slug) }}" class="card-problema" style="flex-direction: row; align-items: center; gap: 1.5rem; padding: 1.5rem;">
                    @if($post->imagem_destaque)
                    <img src="{{ asset($post->imagem_destaque) }}" alt="" width="120" height="80" style="border-radius: 8px; object-fit: cover; display: block;">
                    @endif
                    <div style="flex: 1;">
                        <strong style="display: block; font-size: 1.2rem; margin-bottom: 0.5rem; color: var(--cor-texto);">{{ $post->titulo }}</strong>
                        <p style="color: var(--cor-texto-secundario); font-size: 0.95rem; margin: 0; line-height: 1.5;">{{ Str::limit($post->resumo, 150) }}</p>
                    </div>
                </a>
                @endforeach
            </div>
        </section>
        @endif

    </div>
@endif

@endsection
