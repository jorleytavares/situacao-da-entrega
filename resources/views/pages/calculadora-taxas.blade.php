@extends('layouts.app')

@section('title', 'Calculadora de Taxas de Importação - Situação da Entrega')
@section('description', 'Calcule quanto você vai pagar de imposto em compras internacionais (Shein, AliExpress, Shopee). Simule ICMS e Imposto de Importação.')

@section('content')
<section class="bloco destaque" aria-labelledby="calc-title">
    <h1 class="bloco-titulo" id="calc-title">
        <x-icon name="calculator" size="28" color="#128C7E" />
        Calculadora de Taxas de Importação
    </h1>
    <p class="bloco-texto">
        Simule o valor final da sua compra internacional considerando as regras do <strong>Remessa Conforme</strong>.
    </p>

    <div class="calculadora-container" style="background: #fff; padding: 2rem; border-radius: 12px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1); max-width: 600px; margin: 2rem auto;">
        <div class="form-group" style="margin-bottom: 1.5rem;">
            <label for="valor_usd" style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Valor da Compra (em Dólares US$)</label>
            <div class="input-wrapper" style="position: relative;">
                <span style="position: absolute; left: 1rem; top: 50%; transform: translateY(-50%); color: #666;">$</span>
                <input type="number" id="valor_usd" placeholder="0.00" step="0.01" style="width: 100%; padding: 0.75rem 0.75rem 0.75rem 2.5rem; border: 1px solid #ddd; border-radius: 8px; font-size: 1.1rem;">
            </div>
        </div>

        <div class="form-group" style="margin-bottom: 1.5rem;">
            <label style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Estado de Destino (ICMS)</label>
            <select id="estado_icms" style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 8px; background: #fff;">
                <option value="0.17" selected>Padrão (17% - Maioria dos Estados)</option>
                <option value="0.17">SP, RJ, MG, RS, SC, PR...</option>
                <!-- Simplificado pois a maioria adotou 17% via convênio -->
            </select>
        </div>

        <button onclick="calcularTaxa()" class="botao" style="width: 100%; justify-content: center; font-size: 1.1rem;">Calcular Impostos</button>

        <div id="resultado" style="margin-top: 2rem; display: none; border-top: 1px solid #eee; padding-top: 1.5rem;">

            <div class="resultado-linha" style="display: flex; justify-content: space-between; margin-bottom: 0.5rem;">
                <span>Valor do Produto:</span>
                <strong id="res_produto">R$ 0,00</strong>
            </div>

            <div class="resultado-linha" style="display: flex; justify-content: space-between; margin-bottom: 0.5rem; color: #d32f2f;">
                <span>Imposto de Importação (60%):</span>
                <strong id="res_ii">R$ 0,00</strong>
            </div>

            <div class="resultado-linha" style="display: flex; justify-content: space-between; margin-bottom: 0.5rem; color: #ed6c02;">
                <span>ICMS (17%):</span>
                <strong id="res_icms">R$ 0,00</strong>
            </div>

            <div class="resultado-total" style="display: flex; justify-content: space-between; margin-top: 1rem; padding-top: 1rem; border-top: 2px dashed #ddd; font-size: 1.25rem;">
                <span>Total a Pagar:</span>
                <strong id="res_total" style="color: #128C7E;">R$ 0,00</strong>
            </div>

            <div id="aviso_isencao" style="background: #e8f5e9; color: #2e7d32; padding: 1rem; border-radius: 8px; margin-top: 1.5rem; display: none;">
                ✅ <strong>Isenção de Imposto de Importação!</strong><br>
                Compras abaixo de US$ 50 no Remessa Conforme pagam apenas ICMS.
            </div>
        </div>
    </div>
</section>

<section class="bloco">
    <h2 class="bloco-titulo">Como funciona o cálculo?</h2>
    <div style="display: grid; gap: 1rem;">
        <article>
            <strong>Abaixo de US$ 50 (Remessa Conforme)</strong>
            <p>Isento de imposto federal (60%). Paga apenas 17% de ICMS sobre o valor total (produto + frete).</p>
        </article>
        <article>
            <strong>Acima de US$ 50</strong>
            <p>Paga 60% de Imposto de Importação + 17% de ICMS. O cálculo é em "cascata" (o ICMS incide sobre o valor já taxado), o que eleva a taxa efetiva para quase 92%.</p>
        </article>
    </div>
</section>

<script>
    function calcularTaxa() {
        const usd = parseFloat(document.getElementById('valor_usd').value);
        if (!usd) return;

        const cotacao = 5.80; // Dólar fixo para simulação (ideal seria API, mas vamos simplificar)
        const icmsRate = 0.17;

        // Regra atualizada: Isenção até $50
        const isentoII = usd <= 50;

        let valorBRL = usd * cotacao;
        let impostoImportacao = isentoII ? 0 : valorBRL * 0.60;

        // Base de cálculo do ICMS: (Valor Produto + II) / (1 - Alíquota ICMS)
        let baseICMS = (valorBRL + impostoImportacao) / (1 - icmsRate);
        let valorICMS = baseICMS * icmsRate;

        let total = valorBRL + impostoImportacao + valorICMS;

        // Renderizar
        document.getElementById('res_produto').textContent = valorBRL.toLocaleString('pt-BR', {
            style: 'currency',
            currency: 'BRL'
        });
        document.getElementById('res_ii').textContent = impostoImportacao.toLocaleString('pt-BR', {
            style: 'currency',
            currency: 'BRL'
        });
        document.getElementById('res_icms').textContent = valorICMS.toLocaleString('pt-BR', {
            style: 'currency',
            currency: 'BRL'
        });
        document.getElementById('res_total').textContent = total.toLocaleString('pt-BR', {
            style: 'currency',
            currency: 'BRL'
        });

        const aviso = document.getElementById('aviso_isencao');

        if (isentoII) {
            document.getElementById('res_ii').parentElement.style.textDecoration = "line-through";
            document.getElementById('res_ii').parentElement.style.opacity = "0.6";
            aviso.style.display = "block";
        } else {
            document.getElementById('res_ii').parentElement.style.textDecoration = "none";
            document.getElementById('res_ii').parentElement.style.opacity = "1";
            aviso.style.display = "none";
        }

        document.getElementById('resultado').style.display = "block";
    }
</script>
@endsection