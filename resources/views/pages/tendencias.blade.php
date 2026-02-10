@extends('layouts.app')

@section('title', 'Tendências de entregas no Brasil | Situação da Entrega')
@section('description', 'Problemas de entrega mais relatados no Brasil. Dados atualizados.')

@section('content')

<section class="bloco" id="bloco-hero">
    <h1 class="bloco-titulo" style="font-size: 1.5rem;">Tendências de entregas no Brasil</h1>
    <p class="bloco-texto">
        <strong>{{ number_format($totalRelatos, 0, ',', '.') }}</strong> relatos anônimos. Atualização automática.
    </p>
</section>

<x-estatisticas-relatos
    :totalRelatos="$totalRelatos"
    :ultimos30Dias="$ultimos30Dias"
    :problemasGrafico="$problemasGrafico"
    :mostrarGrafico="true"
    graficoId="graficoTendencias"
    titulo="Panorama geral" />

<section class="bloco">
    <h2 style="font-size: 1.125rem; margin-bottom: 1rem;">Problemas mais relatados</h2>
    <ul style="list-style: none; padding: 0;">
        @forelse($problemasMaisRelatados as $item)
        <li style="display: flex; justify-content: space-between; padding: 0.5rem 0; border-bottom: 1px solid var(--cor-borda);">
            <a href="{{ route('problema.mostrar', $item->problema->slug ?? 'problema') }}">
                {{ $item->problema->titulo ?? 'Problema #' . $item->problema_id }}
            </a>
            <strong>{{ $item->total }}</strong>
        </li>
        @empty
        <li style="color: var(--cor-texto-secundario);">Nenhum relato ainda.</li>
        @endforelse
    </ul>
</section>

<section class="bloco">
    <h2 style="font-size: 1.125rem; margin-bottom: 1rem;">Estados com mais ocorrências</h2>
    <ul style="list-style: none; padding: 0;">
        @forelse($estadosMaisAfetados as $estado)
        <li style="display: flex; justify-content: space-between; padding: 0.5rem 0; border-bottom: 1px solid var(--cor-borda);">
            <a href="{{ route('estado.mostrar', strtolower($estado->uf)) }}">{{ $estado->uf }}</a>
            <strong>{{ $estado->total }}</strong>
        </li>
        @empty
        <li style="color: var(--cor-texto-secundario);">Nenhum dado ainda.</li>
        @endforelse
    </ul>
</section>

<section class="bloco">
    <h2 style="font-size: 1.125rem; margin-bottom: 0.5rem;">Taxa de resolução</h2>
    <p class="bloco-texto">
        <strong style="font-size: 1.25rem; color: var(--cor-primaria);">{{ $percentualResolvido }}%</strong>
        resolvido
    </p>
</section>

<section class="bloco" style="background: var(--cor-bolha);">
    <h2 style="font-size: 1.125rem; margin-bottom: 0.5rem;">O que esses dados indicam?</h2>
    <p class="bloco-texto">
        Padrões observados a partir de relatos anônimos. Dados não oficiais.
    </p>
</section>

<section class="bloco">
    <h2 style="font-size: 1.125rem; margin-bottom: 1rem;">FAQ</h2>

    <article style="margin-bottom: 1rem;">
        <strong>Dados oficiais?</strong>
        <p class="bloco-texto" style="margin-top: 0.25rem;">Não. Relatos anônimos.</p>
    </article>

    <article style="margin-bottom: 1rem;">
        <strong>Relatos anônimos?</strong>
        <p class="bloco-texto" style="margin-top: 0.25rem;">Sim. Sem nome, e-mail ou CPF.</p>
    </article>

    <article>
        <strong>Como contribuir?</strong>
        <p class="bloco-texto" style="margin-top: 0.25rem;"><a href="{{ route('relato.formulario') }}">Envie um relato</a>.</p>
    </article>
</section>

<section class="bloco" style="text-align: center;">
    <a href="{{ route('relato.formulario') }}" class="botao">Relatar problema</a>
</section>

<section class="bloco">
    <p class="bloco-texto texto-pequeno" style="color: var(--cor-texto-secundario);">
        ← <a href="{{ route('home') }}">Início</a>
    </p>
</section>

@endsection