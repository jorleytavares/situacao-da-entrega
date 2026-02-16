<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Post;

class BlogSeeder extends Seeder
{
    public function run(): void
    {
        // Limpar posts existentes para evitar duplicidade ao rodar o seed novamente (opcional, mas recomendado para dev)
        // Post::truncate(); 

        // 1. Objeto em Transferência (Topo de Funil)
        Post::updateOrCreate(
            ['slug' => 'objeto-em-transferencia-correios'],
            [
                'titulo' => 'Objeto em Transferência nos Correios: O que Significa?',
                'conteudo' => '
                    <p>O status "Objeto em transferência - por favor aguarde" é um dos mais comuns no rastreamento dos Correios. Ele indica que sua encomenda saiu de uma unidade (agência ou centro de distribuição) e está a caminho da próxima.</p>
                    
                    <h2>Quanto Tempo Demora Essa Transferência?</h2>
                    <p>O tempo varia conforme a distância. Entre capitais, costuma levar de 1 a 3 dias úteis. Para o interior, pode chegar a 5 dias.</p>
                    <p>No entanto, existem prazos limites. Se a transferência demorar mais de 10 dias sem atualização, pode haver um problema. <a href="/blog/objeto-nao-localizado-fluxo-postal">Se o status não atualizar e mudar para objeto não localizado no fluxo postal, veja como proceder.</a></p>
                    
                    <h3>Por que demora tanto?</h3>
                    <p>Fatores como greves, alta demanda (Black Friday) ou problemas logísticos podem atrasar esse processo.</p>
                ',
                'resumo' => 'Entenda o que significa o status de objeto em transferência e quanto tempo normalmente demora para atualizar.',
                'sge_summary' => 'Objeto em transferência indica deslocamento entre unidades. O prazo normal é de 1 a 5 dias. Atrasos acima de 10 dias podem indicar extravio.',
                'imagem_destaque' => 'images/blog/transferencia.svg',
                'imagem_alt' => 'Caminhão dos correios em estrada representando transferência',
                'tags' => ['Rastreamento', 'Correios', 'Logística'],
                'autor_nome' => 'Equipe Situação da Entrega',
                'published_at' => now()->subDays(5),
                'publicado' => true
            ]
        );

        // 2. Objeto Não Localizado (Meio de Funil)
        Post::updateOrCreate(
            ['slug' => 'objeto-nao-localizado-fluxo-postal'],
            [
                'titulo' => 'Objeto Não Localizado no Fluxo Postal: Como Agir?',
                'conteudo' => '
                    <p>Receber a notificação de "Objeto não localizado" gera frustração e dúvidas. Isso significa, tecnicamente, que houve <a href="/blog/objeto-em-transferencia-correios">uma falha durante o processo de transferência entre unidades de tratamento</a>, onde a carga física não chegou ao destino esperado pelo sistema.</p>
                    
                    <h2>O que fazer agora?</h2>
                    <p>O primeiro passo é aguardar. Muitas vezes, o objeto é reencontrado em até 48 horas. Se não for, o status mudará para "Extraviado" ou "Roubo".</p>
                    
                    <h3>Passo a Passo para Abrir uma PI (Pedido de Informação)</h3>
                    <ol>
                        <li>Acesse o site dos Correios em "Fale Conosco".</li>
                        <li>Registre uma reclamação informando o código de rastreio.</li>
                        <li>Aguarde o prazo de resposta de 5 dias úteis.</li>
                    </ol>
                    
                    <p>Se confirmado o extravio, você terá direito a indenização. <strong><a href="/blog/valor-declarado-correios-vs-seguro-automatico">O valor da indenização dependerá se você contratou o Valor Declarado ou contou apenas com o Seguro Automático.</a></strong></p>
                ',
                'resumo' => 'Saiba o que fazer quando sua encomenda aparece como não localizada e como pedir indenização.',
                'sge_summary' => 'Objeto não localizado indica possível extravio. Abra uma PI no site dos Correios. A indenização depende do seguro contratado.',
                'imagem_destaque' => 'images/blog/nao-localizado.svg',
                'imagem_alt' => 'Ícone de lupa com ponto de interrogação sobre caixa',
                'tags' => ['Problemas', 'Indenização', 'Correios'],
                'autor_nome' => 'Especialista em Logística',
                'published_at' => now()->subDays(3),
                'publicado' => true
            ]
        );

        // 3. Valor Declarado vs Seguro Automático (Fundo de Funil)
        Post::updateOrCreate(
            ['slug' => 'valor-declarado-correios-vs-seguro-automatico'],
            [
                'titulo' => 'Valor Declarado Correios vs Seguro Automático',
                'conteudo' => '
                    <p>Ao enviar uma encomenda, você está protegendo seu patrimônio? Entenda as coberturas postais e garanta a indenização total da sua carga em caso de sinistro.</p>
                    
                    <h2>O Que é o Seguro Automático?</h2>
                    <p>Toda encomenda PAC ou SEDEX já possui um seguro básico automático, que cobre um valor mínimo (geralmente em torno de R$ 24,00 + valor da postagem). Isso pode ser insuficiente <a href="/blog/objeto-nao-localizado-fluxo-postal">caso sua encomenda sofra um sinistro ou termine como objeto não localizado pelos Correios</a>.</p>
                    
                    <h2>O Que é o Valor Declarado (VD)?</h2>
                    <p>É um serviço adicional onde você declara o valor real da nota fiscal do produto. É cobrada uma taxa (geralmente 1% do valor excedente ao seguro automático).</p>
                    
                    <h3>Quando vale a pena?</h3>
                    <p>Sempre que o valor da mercadoria for superior ao seguro automático (aprox. R$ 24,00). Sem declarar valor, você receberá apenas o mínimo em caso de perda.</p>
                ',
                'resumo' => 'Entenda a diferença entre o seguro automático dos Correios e o serviço de Valor Declarado para proteger suas encomendas.',
                'sge_summary' => 'Seguro Automático cobre apenas valores irrisórios. Valor Declarado (VD) custa 1% do valor da nota e garante indenização total em caso de extravio.',
                'imagem_destaque' => 'images/blog/seguro-valor.svg',
                'imagem_alt' => 'Escudo de proteção sobre caixas de encomenda',
                'tags' => ['Seguros', 'Dicas', 'E-commerce'],
                'autor_nome' => 'Equipe Situação da Entrega',
                'published_at' => now()->subDays(1),
                'publicado' => true
            ]
        );
    }
}
