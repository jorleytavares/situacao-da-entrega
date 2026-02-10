@extends('layouts.app')

@section('title', 'Sobre o Projeto | Situação da Entrega')
@section('description', 'Conheça o projeto Situação da Entrega: agregador de relatos anônimos sobre problemas de entrega no Brasil.')

@section('content')

<section class="hero">
    <h1>Sobre o Projeto</h1>
    <p>Transformando frustração logística em inteligência pública</p>
</section>

<section class="bloco">
    <h2 class="bloco-titulo">🎯 Nossa Missão</h2>
    <p class="bloco-texto">
        O <strong>Situação da Entrega</strong> nasceu para dar voz aos consumidores brasileiros que enfrentam
        problemas recorrentes com entregas. Agregamos relatos anônimos para criar uma base de dados pública,
        transparente e útil para todos.
    </p>
</section>

<section class="bloco">
    <h2 class="bloco-titulo">📊 Números do Projeto</h2>
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 1rem; margin-top: 1rem;">
        <div class="card-stat">
            <div class="card-stat-valor">{{ number_format($totalRelatos, 0, ',', '.') }}</div>
            <div class="card-stat-label">Relatos recebidos</div>
        </div>
        <div class="card-stat">
            <div class="card-stat-valor">{{ $totalProblemas }}</div>
            <div class="card-stat-label">Tipos de problemas</div>
        </div>
        <div class="card-stat">
            <div class="card-stat-valor">{{ $totalEstados }}</div>
            <div class="card-stat-label">Estados com dados</div>
        </div>
    </div>
</section>

<section class="bloco">
    <h2 class="bloco-titulo">🔒 Privacidade em Primeiro Lugar</h2>
    <ul class="lista-simples">
        <li>✅ Não coletamos dados pessoais</li>
        <li>✅ Relatos são 100% anônimos</li>
        <li>✅ Não rastreamos usuários</li>
        <li>✅ Dados agregados e públicos</li>
    </ul>
</section>

<section class="bloco">
    <h2 class="bloco-titulo">🤖 Feito para IA</h2>
    <p class="bloco-texto">
        Nossos dados são estruturados com Schema.org e disponibilizamos um arquivo
        <a href="/llms.txt">llms.txt</a> para facilitar o uso por sistemas de IA e LLMs.
    </p>
</section>

<section class="bloco">
    <h2 class="bloco-titulo">📈 Metodologia</h2>
    <p class="bloco-texto">
        Todos os dados são coletados de forma anônima através de formulários públicos.
        A metodologia completa está disponível na página
        <a href="{{ route('metodologia') }}">Metodologia dos Dados</a>.
    </p>
</section>

<section class="bloco" style="background: var(--cor-bolha);">
    <h2 class="bloco-titulo">📣 Contribua</h2>
    <p class="bloco-texto">Teve problema com uma entrega? Ajude outros consumidores relatando sua experiência.</p>
    <a href="{{ route('relato.formulario') }}" class="botao">Relatar problema</a>
</section>

@endsection