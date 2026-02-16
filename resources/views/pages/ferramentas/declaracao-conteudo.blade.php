@extends('layouts.app')

@section('title', 'Gerador de Declaração de Conteúdo Correios | PDF Grátis')
@section('description', 'Preencha online e gere seu PDF da Declaração de Conteúdo para Correios em segundos. Formulário seguro, rápido e grátis. Ideal para envios sem nota fiscal.')

@section('head')
<style>
    .form-section {
        background: #fff;
        padding: 2rem;
        border-radius: var(--radius);
        margin-bottom: 2rem;
        border: 1px solid var(--sl-200);
    }

    .form-title {
        color: var(--brand);
        font-weight: 700;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .itens-grid {
        display: grid;
        grid-template-columns: 2fr 1fr 1fr auto;
        gap: 1rem;
        margin-bottom: 1rem;
        align-items: center;
    }

    @media (max-width: 768px) {
        .itens-grid {
            grid-template-columns: 1fr;
            border-bottom: 1px solid var(--sl-200);
            padding-bottom: 1rem;
        }
    }

    .btn-add {
        background: var(--bg-page);
        color: var(--brand);
        border: 1px dashed var(--brand);
        width: 100%;
        padding: 0.75rem;
        border-radius: var(--radius);
        cursor: pointer;
        transition: all 0.2s;
    }

    .btn-add:hover {
        background: var(--em-50);
    }

    .print-only {
        display: none;
    }

    @media print {
        body * {
            visibility: hidden;
        }

        #declaracao-print,
        #declaracao-print * {
            visibility: visible;
        }

        #declaracao-print {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
            display: block !important;
        }

        @page {
            margin: 0;
            size: A4;
        }
    }
</style>
@endsection

@section('content')
<div class="container" style="max-width: 1000px; margin: 4rem auto; padding: 0 1.5rem;">

    <div style="text-align: center; margin-bottom: 3rem;">
        <h1 style="font-size: 2.5rem; color: var(--text-h); margin-bottom: 1rem;">Gerador de Declaração de Conteúdo</h1>
        <p style="color: var(--text-body); max-width: 600px; margin: 0 auto;">
            Obrigatória para envios via Correios sem Nota Fiscal. Preencha os dados abaixo e clique em "Gerar PDF" para imprimir.
        </p>
    </div>

    <form id="declaracaoForm" onsubmit="gerarDeclaracao(event)">
        <div class="grid-2">
            <!-- Remetente -->
            <div class="form-section">
                <h3 class="form-title">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                        <circle cx="12" cy="7" r="4"></circle>
                    </svg>
                    Remetente
                </h3>
                <div class="form-group mb-3">
                    <label class="calc-label">Nome Completo / Razão Social</label>
                    <input type="text" id="rem_nome" class="calc-input" required>
                </div>
                <div class="grid-2 mb-3">
                    <div class="form-group">
                        <label class="calc-label">CPF / CNPJ</label>
                        <input type="text" id="rem_doc" class="calc-input" required>
                    </div>
                    <div class="form-group">
                        <label class="calc-label">CEP</label>
                        <input type="text" id="rem_cep" class="calc-input" required onblur="viaCep(this.value, 'rem')">
                    </div>
                </div>
                <div class="form-group mb-3">
                    <label class="calc-label">Endereço</label>
                    <input type="text" id="rem_end" class="calc-input" required>
                </div>
                <div class="grid-2">
                    <div class="form-group">
                        <label class="calc-label">Cidade</label>
                        <input type="text" id="rem_cidade" class="calc-input" required>
                    </div>
                    <div class="form-group">
                        <label class="calc-label">UF</label>
                        <input type="text" id="rem_uf" class="calc-input" required maxlength="2" style="text-transform: uppercase;">
                    </div>
                </div>
            </div>

            <!-- Destinatário -->
            <div class="form-section">
                <h3 class="form-title">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path>
                        <polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline>
                        <line x1="12" y1="22.08" x2="12" y2="12"></line>
                    </svg>
                    Destinatário
                </h3>
                <div class="form-group mb-3">
                    <label class="calc-label">Nome Completo / Razão Social</label>
                    <input type="text" id="dest_nome" class="calc-input" required>
                </div>
                <div class="grid-2 mb-3">
                    <div class="form-group">
                        <label class="calc-label">CPF / CNPJ</label>
                        <input type="text" id="dest_doc" class="calc-input" required>
                    </div>
                    <div class="form-group">
                        <label class="calc-label">CEP</label>
                        <input type="text" id="dest_cep" class="calc-input" required onblur="viaCep(this.value, 'dest')">
                    </div>
                </div>
                <div class="form-group mb-3">
                    <label class="calc-label">Endereço</label>
                    <input type="text" id="dest_end" class="calc-input" required>
                </div>
                <div class="grid-2">
                    <div class="form-group">
                        <label class="calc-label">Cidade</label>
                        <input type="text" id="dest_cidade" class="calc-input" required>
                    </div>
                    <div class="form-group">
                        <label class="calc-label">UF</label>
                        <input type="text" id="dest_uf" class="calc-input" required maxlength="2" style="text-transform: uppercase;">
                    </div>
                </div>
            </div>
        </div>

        <!-- Itens -->
        <div class="form-section">
            <h3 class="form-title">Identificação dos Bens</h3>

            <div id="lista-itens">
                <div class="itens-grid item-row">
                    <div class="form-group">
                        <label class="calc-label">Descrição do Conteúdo</label>
                        <input type="text" name="item_desc[]" class="calc-input" placeholder="Ex: Camiseta Algodão" required>
                    </div>
                    <div class="form-group">
                        <label class="calc-label">Qtd.</label>
                        <input type="number" name="item_qtd[]" class="calc-input" value="1" min="1" required oninput="calcTotal()">
                    </div>
                    <div class="form-group">
                        <label class="calc-label">Valor (R$)</label>
                        <input type="number" name="item_val[]" class="calc-input" step="0.01" placeholder="0,00" required oninput="calcTotal()">
                    </div>
                </div>
            </div>

            <button type="button" class="btn-add" onclick="addItem()">+ Adicionar outro item</button>

            <div style="margin-top: 1.5rem; text-align: right; font-size: 1.25rem; font-weight: 700; color: var(--text-h);">
                Total: R$ <span id="total-valor">0,00</span>
            </div>
        </div>

        <div style="text-align: center; margin-top: 2rem;">
            <button type="submit" class="btn-cta-green" style="padding: 1rem 3rem; font-size: 1.1rem;">
                🖨️ Gerar PDF para Impressão
            </button>
            <p style="margin-top: 1rem; color: var(--text-meta); font-size: 0.9rem;">
                Ao gerar, você confirma que as informações são verdadeiras. Este site não armazena seus dados.
            </p>
        </div>
    </form>
</div>

<!-- Template de Impressão (Oculto na tela, visível no print) -->
<div id="declaracao-print" class="print-only" style="font-family: Arial, sans-serif; padding: 20px; box-sizing: border-box; background: white; color: black;">
    <div style="border: 2px solid #000; padding: 10px; margin-bottom: 20px;">
        <h2 style="text-align: center; margin: 0; font-size: 18px; text-transform: uppercase;">Declaração de Conteúdo</h2>
        <p style="text-align: center; margin: 5px 0 0; font-size: 12px;">(Conforme art. 13 da Portaria nº 32/2021 do Ministério das Comunicações)</p>
    </div>

    <div style="display: flex; gap: 20px; margin-bottom: 20px;">
        <!-- Remetente Print -->
        <div style="flex: 1; border: 1px solid #000; padding: 10px;">
            <h3 style="margin: 0 0 10px; font-size: 14px; background: #eee; padding: 5px; border-bottom: 1px solid #000;">REMETENTE</h3>
            <div style="font-size: 12px; line-height: 1.4;">
                <p><strong>Nome:</strong> <span id="p_rem_nome"></span></p>
                <p><strong>CPF/CNPJ:</strong> <span id="p_rem_doc"></span></p>
                <p><strong>Endereço:</strong> <span id="p_rem_end"></span></p>
                <p><strong>Cidade/UF:</strong> <span id="p_rem_cidade"></span> / <span id="p_rem_uf"></span></p>
                <p><strong>CEP:</strong> <span id="p_rem_cep"></span></p>
            </div>
        </div>

        <!-- Destinatário Print -->
        <div style="flex: 1; border: 1px solid #000; padding: 10px;">
            <h3 style="margin: 0 0 10px; font-size: 14px; background: #eee; padding: 5px; border-bottom: 1px solid #000;">DESTINATÁRIO</h3>
            <div style="font-size: 12px; line-height: 1.4;">
                <p><strong>Nome:</strong> <span id="p_dest_nome"></span></p>
                <p><strong>CPF/CNPJ:</strong> <span id="p_dest_doc"></span></p>
                <p><strong>Endereço:</strong> <span id="p_dest_end"></span></p>
                <p><strong>Cidade/UF:</strong> <span id="p_dest_cidade"></span> / <span id="p_dest_uf"></span></p>
                <p><strong>CEP:</strong> <span id="p_dest_cep"></span></p>
            </div>
        </div>
    </div>

    <!-- Tabela Itens -->
    <table style="width: 100%; border-collapse: collapse; margin-bottom: 20px; font-size: 12px;">
        <thead>
            <tr style="background: #eee;">
                <th style="border: 1px solid #000; padding: 5px;">ITEM</th>
                <th style="border: 1px solid #000; padding: 5px; width: 60%;">CONTEÚDO</th>
                <th style="border: 1px solid #000; padding: 5px;">QUANT.</th>
                <th style="border: 1px solid #000; padding: 5px;">VALOR (R$)</th>
            </tr>
        </thead>
        <tbody id="p_itens_body">
            <!-- JS preenche aqui -->
        </tbody>
        <tfoot>
            <tr>
                <td colspan="3" style="border: 1px solid #000; padding: 5px; text-align: right; font-weight: bold;">TOTAL</td>
                <td style="border: 1px solid #000; padding: 5px; font-weight: bold;" id="p_total">0,00</td>
            </tr>
        </tfoot>
    </table>

    <!-- Declaração -->
    <div style="font-size: 11px; margin-bottom: 30px; text-align: justify;">
        <p>Declaro que não me enquadro no conceito de contribuinte previsto no art. 4º da Lei Complementar nº 87/1996, uma vez que não realizo, com habitualidade ou em volume que caracterize intuito comercial, operações de circulação de mercadoria, ainda que se iniciem no exterior, ou estou dispensado da emissão da nota fiscal por força da legislação tributária vigente, responsabilizando-me, nos termos da lei e a quem de direito, por informações inverídicas.</p>
        <p style="margin-top: 10px;">Declaro ainda que não estou postando conteúdo inflamável, explosivo, causador de combustão espontânea, tóxico, corrosivo, gás comprimido, sólido facilmente inflamável, oxidante e peróxido orgânico, infectante, radioativo, magnetizado ou qualquer outro item proibido pela legislação postal e/ou aérea.</p>
    </div>

    <!-- Assinatura -->
    <div style="display: flex; justify-content: space-between; align-items: flex-end; margin-top: 50px;">
        <div style="text-align: center;">
            <div style="border-bottom: 1px solid #000; width: 200px; margin-bottom: 5px;"></div>
            <span style="font-size: 12px;">Cidade / Data</span>
        </div>
        <div style="text-align: center;">
            <div style="border-bottom: 1px solid #000; width: 300px; margin-bottom: 5px;"></div>
            <span style="font-size: 12px;">Assinatura do Remetente</span>
        </div>
    </div>
</div>

@endsection

@section('scriptsBody')
<script>
    function addItem() {
        const div = document.createElement('div');
        div.className = 'itens-grid item-row';
        div.innerHTML = `
            <div class="form-group">
                <input type="text" name="item_desc[]" class="calc-input" placeholder="Descrição" required>
            </div>
            <div class="form-group">
                <input type="number" name="item_qtd[]" class="calc-input" value="1" min="1" required oninput="calcTotal()">
            </div>
            <div class="form-group">
                <input type="number" name="item_val[]" class="calc-input" step="0.01" placeholder="0,00" required oninput="calcTotal()">
            </div>
            <button type="button" onclick="this.parentElement.remove(); calcTotal()" style="color: red; background: none; border: none; cursor: pointer;">✕</button>
        `;
        document.getElementById('lista-itens').appendChild(div);
    }

    function calcTotal() {
        let total = 0;
        const vals = document.getElementsByName('item_val[]');
        const qtds = document.getElementsByName('item_qtd[]');

        for (let i = 0; i < vals.length; i++) {
            const val = parseFloat(vals[i].value) || 0;
            const qtd = parseInt(qtds[i].value) || 0;
            total += val * qtd; // Correios considera valor unitário * qtd
        }
        document.getElementById('total-valor').innerText = total.toLocaleString('pt-BR', {
            minimumFractionDigits: 2
        });
    }

    async function viaCep(cep, tipo) {
        cep = cep.replace(/\D/g, '');
        if (cep.length === 8) {
            try {
                const res = await fetch(`https://viacep.com.br/ws/${cep}/json/`);
                const data = await res.json();
                if (!data.erro) {
                    document.getElementById(`${tipo}_end`).value = `${data.logradouro}, ${data.bairro}`;
                    document.getElementById(`${tipo}_cidade`).value = data.localidade;
                    document.getElementById(`${tipo}_uf`).value = data.uf;
                }
            } catch (e) {
                console.error('Erro CEP', e);
            }
        }
    }

    function gerarDeclaracao(e) {
        e.preventDefault();

        // Mapear campos para o print
        const map = {
            'rem_nome': 'p_rem_nome',
            'rem_doc': 'p_rem_doc',
            'rem_end': 'p_rem_end',
            'rem_cidade': 'p_rem_cidade',
            'rem_uf': 'p_rem_uf',
            'rem_cep': 'p_rem_cep',
            'dest_nome': 'p_dest_nome',
            'dest_doc': 'p_dest_doc',
            'dest_end': 'p_dest_end',
            'dest_cidade': 'p_dest_cidade',
            'dest_uf': 'p_dest_uf',
            'dest_cep': 'p_dest_cep'
        };

        for (const [id, target] of Object.entries(map)) {
            document.getElementById(target).innerText = document.getElementById(id).value;
        }

        // Mapear Itens
        const tbody = document.getElementById('p_itens_body');
        tbody.innerHTML = '';
        const descs = document.getElementsByName('item_desc[]');
        const qtds = document.getElementsByName('item_qtd[]');
        const vals = document.getElementsByName('item_val[]');

        for (let i = 0; i < descs.length; i++) {
            const tr = document.createElement('tr');
            tr.innerHTML = `
                <td style="border: 1px solid #000; padding: 5px; text-align: center;">${i+1}</td>
                <td style="border: 1px solid #000; padding: 5px;">${descs[i].value}</td>
                <td style="border: 1px solid #000; padding: 5px; text-align: center;">${qtds[i].value}</td>
                <td style="border: 1px solid #000; padding: 5px; text-align: right;">${parseFloat(vals[i].value).toLocaleString('pt-BR', {minimumFractionDigits: 2})}</td>
            `;
            tbody.appendChild(tr);
        }

        document.getElementById('p_total').innerText = document.getElementById('total-valor').innerText;

        window.print();
    }
</script>
@endsection