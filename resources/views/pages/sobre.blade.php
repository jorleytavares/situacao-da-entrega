@extends('layouts.app')

@section('title', 'Sobre o Situação da Entrega')
@section('description', 'Conheça o projeto Situação da Entrega.')

@section('content')

<div class="bloco">
    <h2 class="bloco-titulo">Sobre o projeto</h2>

    <p class="bloco-texto">
        O <strong>Situação da Entrega</strong> é uma plataforma brasileira criada para
        ajudar pessoas a entenderem o que está acontecendo com suas entregas.
    </p>

    <p class="bloco-texto">
        Reunimos relatos anônimos de usuários de todo o país e transformamos esses dados
        em informações úteis, como tendências por estado e problemas mais frequentes.
    </p>

    <h3>Nosso compromisso</h3>
    <p class="bloco-texto">
        O projeto é 100% independente. Não temos vínculo com empresas de logística,
        marketplaces ou órgãos públicos.
    </p>

    <h3>Privacidade em primeiro lugar</h3>
    <p class="bloco-texto">
        Não coletamos nome, e-mail, telefone ou código de rastreio.
        Todos os relatos são completamente anônimos.
    </p>
</div>

@endsection