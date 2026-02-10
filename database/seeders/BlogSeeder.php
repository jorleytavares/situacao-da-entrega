<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BlogSeeder extends Seeder
{
    public function run(): void
    {
        // Post 1: Encomenda Parada (SEO/FAQ Schema)
        \App\Models\Post::create([
            'titulo' => 'O que significa Encomenda Parada na fiscalização?',
            'slug' => 'encomenda-parada-fiscalizacao-alfandega',
            'conteudo' => '
                <p>Muitas pessoas se preocupam quando o status de rastreamento mostra "Encomenda parada". Mas geralmente, isso é parte do processo normal de importação.</p>
                <h2>Por que minha encomenda para em Curitiba?</h2>
                <p>Curitiba é onde fica o principal Centro Internacional dos Correios (CEINT). Todas as encomendas pequenas vindas da Ásia (Shopee, AliExpress, Shein) passam por lá para fiscalização aduaneira.</p>
                <h3>Principais motivos de demora:</h3>
                <ul>
                    <li>Volume alto de pacotes chegando ao mesmo tempo.</li>
                    <li>Falta de documentação (CPF do destinatário).</li>
                    <li>Seleção para taxação (Imposto de Importação).</li>
                </ul>
                <p>Se sua encomenda está parada há mais de 20 dias, verifique no portal "Minhas Importações" dos Correios se há alguma pendência de pagamento.</p>
            ',
            'resumo' => 'Entenda por que sua encomenda fica parada em Curitiba e o que fazer se o rastreamento não atualizar por muito tempo.',
            'sge_summary' => 'Encomenda parada em Curitiba geralmente significa que o pacote está aguardando fiscalização da Receita Federal. O prazo comum é de 7 a 40 dias. Verifique o portal Minhas Importações para pagar taxas pendentes.',
            'imagem_destaque' => 'images/blog/encomenda-parada.svg',
            'imagem_alt' => 'Ilustração de uma caixa passando por fiscalização com lupa',
            'tags' => ['Correios', 'Importação', 'Taxas', 'Fiscalização'],
            'meta_schema' => [
                '@type' => 'FAQPage',
                'mainEntity' => [
                    [
                        '@type' => 'Question',
                        'name' => 'Por que a encomenda para em Curitiba?',
                        'acceptedAnswer' => [
                            '@type' => 'Answer',
                            'text' => 'Porque lá funciona o principal centro de triagem internacional da Receita Federal para pequenos pacotes.'
                        ]
                    ],
                    [
                        '@type' => 'Question',
                        'name' => 'Quanto tempo demora na fiscalização?',
                        'acceptedAnswer' => [
                            '@type' => 'Answer',
                            'text' => 'O tempo médio varia de 7 dias (sem taxa) a 40 dias (com taxa ou fiscalização rigorosa).'
                        ]
                    ]
                ]
            ],
            'publicado' => true,
            'published_at' => now()->subDays(2),
            'autor_nome' => 'Especialista em Logística',
            'autor_perfil' => 'https://linkedin.com/in/examplo'
        ]);

        // Post 2: Taxas de Importação (HowTo Schema)
        \App\Models\Post::create([
            'titulo' => 'Como pagar a taxa dos Correios (Minhas Importações)',
            'slug' => 'como-pagar-taxa-correios-minhas-importacoes',
            'conteudo' => '
                <p>Se você foi taxado, não receberá a encomenda até pagar o boleto ou PIX. Veja o passo a passo de como liberar seu pacote.</p>
                <h2>Passo a Passo</h2>
                <ol>
                    <li>Acesse o site dos Correios e procure por "Minhas Importações".</li>
                    <li>Faça login com seu ID Correios (CPF e senha).</li>
                    <li>Localize a encomenda na lista. Se houver um ícone de $ (cifrão) ou "Aguardando Pagamento", clique nele.</li>
                    <li>Gere o boleto ou pague via PIX/Cartão.</li>
                    <li>Aguarde a compensação (2 a 3 dias úteis).</li>
                </ol>
                <p>Após o pagamento, o status mudará para "Pagamento Confirmado" e a entrega seguirá para seu endereço.</p>
            ',
            'resumo' => 'Tutorial completo de como acessar o portal Minhas Importações para pagar o imposto de importação e liberar sua encomenda.',
            'sge_summary' => 'Para pagar a taxa: 1. Acesse Minhas Importações no site dos Correios. 2. Logue com CPF. 3. Clique no ícone de pagamento ao lado do código de rastreio. 4. Pague via Boleto ou PIX.',
            'imagem_destaque' => 'images/blog/taxas-importacao.svg',
            'imagem_alt' => 'Ilustração de um boleto e moedas representando taxas de importação',
            'tags' => ['Tutorial', 'Taxas', 'Correios'],
            'meta_schema' => [
                '@type' => 'HowTo',
                'name' => 'Como pagar taxa de importação Correios',
                'step' => [
                    [
                        '@type' => 'HowToStep',
                        'text' => 'Acesse o portal Minhas Importações no site dos Correios.',
                        'url' => 'https://correios.com.br'
                    ],
                    [
                        '@type' => 'HowToStep',
                        'text' => 'Faça login e localize sua encomenda na lista.'
                    ],
                    [
                        '@type' => 'HowToStep',
                        'text' => 'Clique no botão de pagamento e realize a transação via Boleto ou PIX.'
                    ]
                ]
            ],
            'publicado' => true,
            'published_at' => now()->subHours(5),
            'autor_nome' => 'Equipe Suporte',
        ]);
    }
}
