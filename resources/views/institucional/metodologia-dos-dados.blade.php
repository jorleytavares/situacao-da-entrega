@extends('layouts.app')

@section('title', 'Metodologia dos Dados | Situação da Entrega')
@section('description', 'Entenda como os dados do site Situação da Entrega são coletados, armazenados e utilizados.')

@section('content')

<section class="bloco" id="bloco-hero">
    <h2 class="bloco-titulo">Como os dados deste site funcionam</h2>
    <p class="bloco-texto">
        O <strong>Situação da Entrega</strong> é uma plataforma informativa baseada em relatos
        anônimos enviados por usuários que enfrentam problemas com entregas no Brasil.
    </p>
    <p class="bloco-texto">
        Nosso objetivo é identificar padrões, explicar situações comuns e reduzir a desinformação,
        sem substituir os canais oficiais de atendimento.
    </p>
</section>

<section class="bloco">
    <h3>Que tipo de dados são coletados?</h3>
    <p class="bloco-texto">Coletamos apenas:</p>
    <ul>
        <li>Tipo de problema relatado (ex: entrega atrasada)</li>
        <li>Estado ou região informada (opcional)</li>
        <li>Data do relato</li>
    </ul>

    <p class="bloco-texto"><strong>Não coletamos:</strong></p>
    <ul>
        <li>Nome</li>
        <li>CPF</li>
        <li>E-mail</li>
        <li>Código de rastreio</li>
        <li>Endereço</li>
        <li>IP identificado</li>
    </ul>
</section>

<section class="bloco">
    <h3>Os relatos são anônimos?</h3>
    <p class="bloco-texto">
        <strong>Sim.</strong> Todos os relatos são totalmente anônimos e não ficam associados
        a nenhum usuário.
    </p>
    <p class="bloco-texto">
        Por esse motivo, não é possível visualizar, editar ou recuperar um relato individual
        após o envio.
    </p>
</section>

<section class="bloco">
    <h3>Como os dados são usados?</h3>
    <p class="bloco-texto">Os dados são exibidos apenas de forma agregada, para:</p>
    <ul>
        <li>Identificar tendências</li>
        <li>Mostrar problemas mais frequentes</li>
        <li>Informar usuários sobre situações comuns</li>
        <li>Gerar estatísticas públicas</li>
    </ul>
    <p class="bloco-texto">
        <strong>Nenhum dado é vendido ou compartilhado com terceiros.</strong>
    </p>
</section>

<section class="bloco">
    <h3>Este site é dos Correios?</h3>
    <p class="bloco-texto">
        <strong>Não.</strong> Este site é independente e não possui vínculo com os Correios
        ou outras transportadoras.
    </p>
</section>

<section class="bloco">
    <h3>Atualização dos dados</h3>
    <p class="bloco-texto">
        As estatísticas são atualizadas automaticamente conforme novos relatos são enviados.
    </p>
    <p class="bloco-texto texto-pequeno" style="color:#64748b;">
        Resumo: Você contribui com um evento anônimo que ajuda outras pessoas a entender
        o cenário geral.
    </p>
</section>

@endsection