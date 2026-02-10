@extends('layouts.app')

@section('title', 'Contato')
@section('description', 'Entre em contato com o Situação da Entrega.')

@section('content')

<div class="bloco">
    <h2 class="bloco-titulo">Contato</h2>

    <p class="bloco-texto">
        O Situação da Entrega é um projeto informativo e não oferece atendimento individual.
    </p>

    <h3>Problemas com entregas?</h3>
    <p class="bloco-texto">
        Se você está com problemas em uma entrega, procure os canais oficiais:
    </p>
    <ul>
        <li>Site ou app da loja onde você comprou</li>
        <li>Central de atendimento da transportadora</li>
        <li>Correios: <a href="https://www.correios.com.br" target="_blank" rel="noopener">correios.com.br</a></li>
    </ul>

    <h3>Sugestões e parcerias</h3>
    <p class="bloco-texto">
        Para sugestões, parcerias comerciais ou dúvidas sobre o projeto,
        envie uma mensagem para o e-mail indicado em nossas redes sociais.
    </p>
</div>

@endsection