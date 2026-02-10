@extends('layouts.app')

@section('title', 'Política de Privacidade')
@section('description', 'Política de privacidade do Situação da Entrega.')

@section('content')

<div class="bloco">
    <h2 class="bloco-titulo">Política de Privacidade</h2>

    <h3>Dados coletados</h3>
    <p class="bloco-texto">
        O Situação da Entrega coleta <strong>apenas</strong> dados agregados e anônimos
        através do formulário de relatos.
    </p>

    <h3>O que NÃO coletamos</h3>
    <ul>
        <li>Nome, e-mail ou telefone</li>
        <li>Código de rastreio</li>
        <li>Endereço IP</li>
        <li>Cookies de rastreamento</li>
    </ul>

    <h3>Uso dos dados</h3>
    <p class="bloco-texto">
        Os dados são utilizados exclusivamente para gerar estatísticas públicas,
        como tendências por estado e problemas mais relatados.
    </p>

    <h3>Compartilhamento</h3>
    <p class="bloco-texto">
        Não vendemos, compartilhamos ou transferimos dados a terceiros.
    </p>

    <h3>Contato</h3>
    <p class="bloco-texto">
        Para dúvidas sobre privacidade, acesse nossa <a href="{{ route('contato') }}">página de contato</a>.
    </p>
</div>

@endsection