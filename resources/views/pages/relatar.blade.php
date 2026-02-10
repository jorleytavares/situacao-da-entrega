@extends('layouts.app')

@section('title', 'Relatar problema de entrega | Situação da Entrega')
@section('description', 'Relate de forma anônima um problema de entrega. Seus dados ajudam outras pessoas.')

@section('content')

@if(session('sucesso'))
<section class="bloco" style="border-left: 4px solid var(--cor-primaria); background: var(--cor-bolha);">
    <h2 class="bloco-titulo" style="color: var(--cor-primaria-escura);">✅ Relato registrado!</h2>
    <p class="bloco-texto">
        Obrigado por contribuir! Seu relato agora faz parte das estatísticas.
    </p>
</section>

<x-estatisticas-relatos
    :totalRelatos="session('totalRelatos', 0)"
    :ultimos30Dias="session('ultimos30Dias', 0)"
    :totalProblema="session('totalProblema')"
    :percentual="session('percentual')"
    :top3Estados="session('top3Estados')"
    :problemasGrafico="session('problemasGrafico')"
    :mostrarGrafico="true"
    graficoId="graficoProblemas"
    titulo="Panorama após seu envio" />

<section class="bloco" style="text-align: center;">
    <a href="{{ route('tendencias') }}">📊 Ver tendências completas</a>
</section>
@endif

<section class="bloco">
    <h2 class="bloco-titulo">Relatar problema de entrega</h2>
    <p class="bloco-texto">
        Seu relato é 100% anônimo. Não coletamos nome, e-mail ou código de rastreio.
    </p>

    <form method="POST" action="{{ route('relato.salvar') }}" class="form-relato">
        @csrf

        <div class="form-group">
            <label for="transportadora_id">Transportadora (opcional)</label>
            <select name="transportadora_id" id="transportadora_id">
                <option value="">Não sei / Não se aplica</option>
                @foreach($transportadoras as $transportadora)
                <option value="{{ $transportadora->id }}">{{ $transportadora->nome }}</option>
                @endforeach
            </select>
            <p class="texto-ajuda">Selecione a empresa responsável pela entrega, se souber.</p>
        </div>

        <div class="form-group">
            <label for="problema_id">Tipo de problema *</label>
            <select name="problema_id" id="problema_id" required>
                <option value="">Selecione o problema</option>
                @foreach($problemas as $problema)
                <option value="{{ $problema->id }}">{{ $problema->titulo }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-row">
            <div class="form-group metade">
                <label for="uf">Estado (opcional)</label>
                <input type="text" name="uf" id="uf" maxlength="2" placeholder="Ex: SP" style="text-transform: uppercase;">
            </div>

            <div class="form-group metade">
                <label for="cidade">Cidade (opcional)</label>
                <input type="text" name="cidade" id="cidade" placeholder="Ex: São Paulo">
            </div>
        </div>

        <div class="form-group">
            <label for="data_ocorrencia">Data aproximada (opcional)</label>
            <input type="date" name="data_ocorrencia" id="data_ocorrencia">
        </div>

        <div class="form-group">
            <label class="checkbox-card">
                <input type="checkbox" name="resolvido" value="1">
                <span class="checkbox-content">
                    <span class="checkbox-titulo">O problema já foi resolvido</span>
                    <span class="checkbox-desc">Marque se a entrega foi concluída ou o estorno realizado.</span>
                </span>
            </label>
        </div>

        <button type="submit" class="botao">Enviar relato anônimo</button>
    </form>
</section>

<section class="bloco">
    <p class="bloco-texto texto-pequeno" style="color: var(--cor-texto-secundario);">
        ← <a href="{{ route('home') }}">Voltar ao início</a>
    </p>
</section>

@endsection