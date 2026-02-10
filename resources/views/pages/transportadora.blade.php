@extends('layouts.app')

@section('title', $transportadora->nome . ': problemas de entrega | Situação da Entrega')
@section('description', 'Problemas com entregas ' . $transportadora->nome . '. Veja relatos e estatísticas.')

@section('content')

<section class="hero">
    <h1>{{ $transportadora->nome }}</h1>
    <p>{{ $transportadora->descricao }}</p>
</section>

<section class="bloco">
    <h2 class="bloco-titulo">📊 Estatísticas Gerais</h2>
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 1rem; margin-top: 1rem;">
        <div class="card-stat">
            <div class="card-stat-valor">{{ number_format($totalRelatos, 0, ',', '.') }}</div>
            <div class="card-stat-label">Total de relatos</div>
        </div>
        <div class="card-stat">
            <div class="card-stat-valor">{{ number_format($ultimos30Dias, 0, ',', '.') }}</div>
            <div class="card-stat-label">Últimos 30 dias</div>
        </div>
    </div>
</section>

<section class="bloco">
    <h2 class="bloco-titulo">🔥 Problemas Mais Comuns</h2>
    <ul class="lista-simples">
        @foreach($topProblemas as $problema)
        <li>
            <a href="{{ route('problema.mostrar', $problema->slug) }}">
                {{ $problema->titulo }}
            </a>
            <span class="texto-pequeno">({{ $problema->total }} relatos)</span>
        </li>
        @endforeach
    </ul>
</section>

<section class="bloco" style="background: var(--cor-bolha);">
    <h2 class="bloco-titulo">📣 Teve problema com {{ $transportadora->nome }}?</h2>
    <p class="bloco-texto">Contribua com sua experiência de forma anônima.</p>
    <a href="{{ route('relato.formulario') }}" class="botao">Relatar problema</a>
</section>

<section class="bloco">
    <h2 class="bloco-titulo">🚚 Outras Transportadoras</h2>
    <ul class="lista-simples">
        <li><a href="{{ route('transportadora.mostrar', 'correios') }}">Correios</a></li>
        <li><a href="{{ route('transportadora.mostrar', 'jadlog') }}">Jadlog</a></li>
        <li><a href="{{ route('transportadora.mostrar', 'azul-cargo') }}">Azul Cargo</a></li>
        <li><a href="{{ route('transportadora.mostrar', 'loggi') }}">Loggi</a></li>
        <li><a href="{{ route('transportadora.mostrar', 'total-express') }}">Total Express</a></li>
        <li><a href="{{ route('transportadora.mostrar', 'sequoia') }}">Sequoia</a></li>
    </ul>
</section>

@endsection