@extends('layouts.app')

@section('title', 'Entregas em ' . $nomeEstado . ' (' . $uf . ') | Situação da Entrega')
@section('description', 'Situação das entregas em ' . $nomeEstado . '. ' . $total . ' relatos de problemas.')

@section('content')

<section class="bloco" id="bloco-hero">
    <h1 class="bloco-titulo" style="font-size: 1.5rem;">Entregas em {{ $nomeEstado }}</h1>
    <p class="bloco-texto">
        @if($total > 0)
        <strong>{{ number_format($total, 0, ',', '.') }}</strong> relatos neste estado.
        @else
        Ainda não temos relatos para {{ $uf }}. Seja o primeiro!
        @endif
    </p>
</section>

@if($total > 0)
<x-estatisticas-relatos
    :totalRelatos="$total"
    :ultimos30Dias="$ultimos30Dias"
    titulo="Panorama em {{ $uf }}" />

@if($problemas->count() > 0)
<section class="bloco">
    <h2 style="font-size: 1.125rem; margin-bottom: 1rem;">Problemas mais comuns</h2>
    <ul style="list-style: none; padding: 0;">
        @foreach($problemas as $item)
        <li style="display: flex; justify-content: space-between; padding: 0.5rem 0; border-bottom: 1px solid var(--cor-borda);">
            <span>{{ $item->titulo }}</span>
            <strong>{{ $item->total }}</strong>
        </li>
        @endforeach
    </ul>
</section>
@endif

<section class="bloco">
    <h2 style="font-size: 1.125rem; margin-bottom: 0.5rem;">Taxa de resolução</h2>
    <p class="bloco-texto">
        <strong style="font-size: 1.25rem; color: var(--cor-primaria);">{{ $percentualResolvido }}%</strong>
        resolvido
    </p>
</section>
@endif

<section class="bloco" style="background: var(--cor-bolha);">
    <h2 style="font-size: 1.125rem; margin-bottom: 0.5rem;">Você está em {{ $uf }}?</h2>
    <p class="bloco-texto">Contribua com um relato anônimo.</p>
    <a href="{{ route('relato.formulario') }}" class="botao">Relatar problema</a>
</section>

<section class="bloco">
    <p class="bloco-texto texto-pequeno" style="color: var(--cor-texto-secundario);">
        ← <a href="{{ route('tendencias') }}">Ver tendências</a> · <a href="{{ route('home') }}">Início</a>
    </p>
</section>

@endsection