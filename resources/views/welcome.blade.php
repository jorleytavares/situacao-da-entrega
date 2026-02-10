@extends('layouts.app')

@section('title', 'Situação da Entrega - Rastreamento Simplificado')

@section('content')
<div class="hero">
    <h1>Entenda o Status da sua Encomenda</h1>
    <p>Informações claras sobre o que está acontecendo com seu pacote.</p>
    <a href="{{ route('report.create') }}" class="btn">Relatar Problema</a>
</div>

<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem;">
    <div>
        <h2>Situações Comuns</h2>
        <ul class="status-list">
            <li><a href="{{ route('problema.encomenda_parada') }}">📦 Encomenda Parada</a></li>
            <li><a href="{{ route('problema.entrega_atrasada') }}">🐢 Entrega Atrasada</a></li>
            <li><a href="{{ route('problema.objeto_nao_localizado') }}">🔍 Objeto Não Localizado</a></li>
            <li><a href="{{ route('problema.fiscalizacao') }}">🛂 Fiscalização Aduaneira</a></li>
            <li><a href="{{ route('problema.nao_saiu') }}">🏡 Não Saiu para Entrega</a></li>
        </ul>
    </div>
    <div>
        <h2>Por Região</h2>
        <p>Selecione seu estado para ver estatísticas locais:</p>
        <!-- Placeholder for states -->
        <select onchange="window.location.href='/estado/'+this.value" style="padding: 0.5rem; width: 100%;">
            <option value="">Selecione um Estado...</option>
            <option value="SP">São Paulo</option>
            <option value="RJ">Rio de Janeiro</option>
            <option value="MG">Minas Gerais</option>
            <option value="RS">Rio Grande do Sul</option>
        </select>
    </div>
</div>
@endsection