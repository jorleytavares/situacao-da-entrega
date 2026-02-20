@extends('layouts.app')

@section('title', 'Situação da Entrega - Rastreamento Correios Nacional e Importação')
@section('description', 'Sua compra foi TAXADA na alfândega ou está PARADA em Curitiba? Entenda o rastreio internacional e nacional (Loggi, Jadlog, Azul). Saiba como resolver pendências e prazos. Consulte grátis!')

@section('content')
<!-- Schema removido para debug -->

<h1 class="sr-only">Situação da Entrega - Rastreamento e Soluções para Encomendas</h1>

<section class="bloco destaque" id="bloco-hero" aria-labelledby="hero-title">
    <h2 class="bloco-titulo" id="hero-title">
        <x-icon name="package-search" size="28" color="#128C7E" />
        Entenda sua encomenda
    </h2>
    <p class="bloco-texto">
        O <strong>Situação da Entrega</strong> reúne informações sobre os principais
        estágios e problemas de transporte no Brasil. Selecione abaixo o que está aparecendo no seu rastreio:
    </p>
</section>

<section class="bloco" aria-label="Situações comuns de problemas de entrega">
    <h2 class="bloco-titulo">
        <x-icon name="alert-triangle" color="#54656F" />
        Situações Comuns
    </h2>
    <div id="id-lista-problemas">
        @foreach($problemas as $problema)
        <a href="{{ route('problema.mostrar', $problema->slug) }}" class="card-problema" title="Entenda o status: {{ $problema->titulo }}">
            <x-icon name="{{ $problema->slug }}" size="28" color="#F15C6D" />
            <h3 style="margin: 0.5rem 0; display: block; color: var(--cor-texto); font-size: 1rem;">
                {{ $problema->titulo }}
            </h3>
            <span style="font-size: 0.9rem; color: var(--cor-texto-secundario);">Clique para entender</span>
        </a>
        @endforeach
    </div>
</section>

<section class="bloco" aria-label="Navegação por Transportadoras">
    <h2 class="bloco-titulo">
        <x-icon name="truck" color="#25D366" />
        Por Transportadora
    </h2>
    <ul class="lista-simples">
        <li><a href="{{ route('transportadora.mostrar', 'correios') }}">Correios</a></li>
        <li><a href="{{ route('transportadora.mostrar', 'jadlog') }}">Jadlog</a></li>
        <li><a href="{{ route('transportadora.mostrar', 'azul-cargo') }}">Azul Cargo</a></li>
        <li><a href="{{ route('transportadora.mostrar', 'loggi') }}">Loggi</a></li>
        <li><a href="{{ route('transportadora.mostrar', 'total-express') }}">Total Express</a></li>
        <li><a href="{{ route('transportadora.index') }}">Ver todas →</a></li>
    </ul>
</section>

@if(isset($postsRecentes) && $postsRecentes->count() > 0)
<section class="bloco" aria-label="Dicas e novidades do blog">
    <h2 class="bloco-titulo">
        <x-icon name="package-search" color="#128C7E" />
        Blog & Dicas
    </h2>
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 1rem;">
        @foreach($postsRecentes as $post)
        <a href="{{ route('blog.show', $post->slug) }}" class="card-problema" style="display: block;" title="Ler o artigo completo: {{ $post->titulo }}">
            @if($post->imagem_destaque)
            <div style="width: 100%; height: 140px; margin-bottom: 1rem; border-radius: 4px; overflow: hidden; background: #f0f0f0;">
                <img src="{{ asset($post->imagem_destaque) }}" alt="{{ $post->imagem_alt }}" title="{{ $post->titulo }}" width="300" height="140" loading="lazy" style="width: 100%; height: 100%; object-fit: cover;">
            </div>
            @endif
            <h3 style="display: block; margin-bottom: 0.5rem; color: var(--cor-texto); font-size: 1rem;">
                {{ $post->titulo }}
            </h3>
            <span style="font-size: 0.9rem; color: var(--cor-texto-secundario);">{{ Str::limit($post->resumo, 80) }}</span>
        </a>
        @endforeach
    </div>
    <div style="margin-top: 1rem; text-align: right;">
        <a href="{{ route('blog.index') }}" style="font-weight: 500; color: var(--cor-primaria);" aria-label="Ver todos os artigos do blog">Ver todos os artigos →</a>
    </div>
</section>
@endif

<section class="bloco" aria-label="Transportadoras mais buscadas">
    <h2 class="bloco-titulo">
        <x-icon name="check-circle" color="#54656F" />
        Dúvidas Rápidas
    </h2>

    <div style="display: grid; gap: 1rem; margin-bottom: 2rem;">
        <article>
            <h3 style="font-size: 1rem; margin-bottom: 0.25rem;">O que significa encomenda parada?</h3>
            <p class="bloco-texto" style="font-size: 0.95rem;">
                Geralmente significa que ela está aguardando processamento interno ou triagem.
            </p>
        </article>
        <article>
            <h3 style="font-size: 1rem; margin-bottom: 0.25rem;">Devo me preocupar com atraso?</h3>
            <p class="bloco-texto" style="font-size: 0.95rem;">
                Atrasos são comuns. A maioria é resolvida nos dias seguintes.
            </p>
        </article>
    </div>

    <hr style="border: 0; border-top: 1px solid var(--cor-borda); margin: 1rem 0;">

    <div style="text-align: center;">
        <h4 style="margin-bottom: 0.5rem;">Teve algum problema?</h4>
        <p class="bloco-texto">Ajude a comunidade compartilhando sua experiência.</p>
        <a href="{{ route('relato.formulario') }}" class="botao">Enviar relato anônimo</a>
    </div>
</section>

<section class="bloco">
    <p class="bloco-texto texto-pequeno" style="text-align: center;">
        <a href="{{ route('tendencias') }}">📊 Ver tendências de problemas</a>
    </p>
</section>

@endsection
