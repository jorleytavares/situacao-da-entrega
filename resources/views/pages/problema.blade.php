@extends('layouts.app')

@section('title', $problema->titulo . ' | Situação da Entrega')
@section('description', 'Análise sobre ' . strtolower($problema->titulo) . '. ' . $total . ' relatos anônimos.')

@section('content')

<section class="bloco" id="bloco-hero">
    <h1 class="bloco-titulo" style="font-size: 1.5rem;">{{ $problema->titulo }}</h1>
    <p class="bloco-texto">
        Análise baseada em <strong>{{ number_format($total, 0, ',', '.') }}</strong> relatos anônimos.
    </p>
</section>

<x-estatisticas-relatos
    :totalRelatos="$total"
    :ultimos30Dias="$ultimos30Dias"
    :percentual="$percentual"
    :top3Estados="$estados->take(3)"
    titulo="Panorama deste problema" />

@if($problema->descricao_completa)
<section class="bloco" style="background: var(--cor-bolha);">
    <h2 style="font-size: 1.125rem; margin-bottom: 0.5rem;">O que significa?</h2>
    <p class="bloco-texto">{{ $problema->descricao_completa }}</p>
</section>
@endif

@if($estados->count() > 0)
<section class="bloco">
    <h2 style="font-size: 1.125rem; margin-bottom: 1rem;">Estados com mais ocorrências</h2>
    <ul style="list-style: none; padding: 0;">
        @foreach($estados as $estado)
        <li style="display: flex; justify-content: space-between; padding: 0.5rem 0; border-bottom: 1px solid var(--cor-borda);">
            <a href="{{ route('estado.mostrar', strtolower($estado->uf)) }}">{{ $estado->uf }}</a>
            <strong>{{ $estado->total }}</strong>
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

<section class="bloco" style="background: var(--cor-bolha);">
    <h2 style="font-size: 1.125rem; margin-bottom: 0.5rem;">Passou por isso?</h2>
    <p class="bloco-texto">Ajude outras pessoas relatando sua experiência.</p>
    <a href="{{ route('relato.formulario') }}" class="botao">Relatar problema</a>
</section>

<section class="bloco">
    <p class="bloco-texto texto-pequeno" style="color: var(--cor-texto-secundario);">
        ← <a href="{{ route('tendencias') }}">Ver tendências</a> · <a href="{{ route('home') }}">Início</a>
    </p>
</section>

@endsection