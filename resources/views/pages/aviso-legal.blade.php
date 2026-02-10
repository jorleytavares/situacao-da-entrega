@extends('layouts.app')

@section('title', 'Aviso Legal')
@section('description', 'Termos de uso e aviso legal do Situação da Entrega.')

@section('content')

<div class="bloco">
    <h2 class="bloco-titulo">Aviso Legal</h2>

    <h3>Natureza do serviço</h3>
    <p class="bloco-texto">
        O Situação da Entrega é um site informativo, baseado em relatos anônimos de usuários.
        Não oferecemos atendimento, suporte ou consultoria sobre entregas específicas.
    </p>

    <h3>Sem vínculo institucional</h3>
    <p class="bloco-texto">
        Não temos qualquer relação com os Correios, transportadoras, marketplaces
        ou qualquer empresa de logística. Somos um projeto totalmente independente.
    </p>

    <h3>Precisão dos dados</h3>
    <p class="bloco-texto">
        Os dados apresentados são baseados em relatos voluntários e podem não refletir
        a totalidade das ocorrências. Não garantimos precisão absoluta.
    </p>

    <h3>Responsabilidade</h3>
    <p class="bloco-texto">
        O uso das informações é de responsabilidade exclusiva do usuário.
        Recomendamos sempre consultar os canais oficiais para resolução de problemas.
    </p>
</div>

@endsection