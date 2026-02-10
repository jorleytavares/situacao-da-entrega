<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Problema;

class ProblemaSeeder extends Seeder
{
    public function run(): void
    {
        $problemas = [
            [
                'slug' => 'encomenda-parada',
                'titulo' => 'Encomenda parada: o que significa?',
                'descricao_curta' => 'Entenda por que uma encomenda pode ficar parada por dias ou semanas.',
                'descricao_completa' => 'Quando uma encomenda aparece como parada, geralmente significa que ela está aguardando algum processamento interno, triagem logística, transferência entre unidades ou liberação operacional. Na maioria dos casos, não indica perda, mas sim atraso por volume elevado, problemas internos ou etapas intermediárias.'
            ],
            [
                'slug' => 'entrega-atrasada',
                'titulo' => 'Entrega atrasada: o que pode estar acontecendo?',
                'descricao_curta' => 'Veja os principais motivos para atrasos na entrega.',
                'descricao_completa' => 'Atrasos na entrega podem ocorrer por alta demanda, falhas operacionais, problemas de rota ou condições externas. Mesmo quando o prazo é ultrapassado, a entrega costuma ocorrer nos dias seguintes sem necessidade de ação imediata.'
            ],
            [
                'slug' => 'objeto-nao-localizado',
                'titulo' => 'Objeto não localizado: devo me preocupar?',
                'descricao_curta' => 'Saiba o que significa quando um objeto não é localizado.',
                'descricao_completa' => 'O status de objeto não localizado normalmente indica falha temporária de leitura, extravio interno ou inconsistência de sistema. Em muitos casos, o objeto reaparece após nova atualização. Recomenda-se aguardar alguns dias antes de buscar atendimento.'
            ],
            [
                'slug' => 'fiscalizacao',
                'titulo' => 'Entrega em fiscalização: o que quer dizer?',
                'descricao_curta' => 'Entenda o processo de fiscalização em entregas.',
                'descricao_completa' => 'Quando uma entrega entra em fiscalização, significa que ela está sendo verificada por órgãos responsáveis ou por processos internos. Isso pode acontecer de forma aleatória ou por critérios específicos. O prazo pode variar, mas geralmente a liberação ocorre sem necessidade de ação do destinatário.'
            ],
            [
                'slug' => 'nao-saiu-para-entrega',
                'titulo' => 'Não saiu para entrega: o que significa?',
                'descricao_curta' => 'Veja por que uma entrega pode não sair para entrega no dia previsto.',
                'descricao_completa' => 'Mesmo após chegar à unidade final, uma entrega pode não sair para entrega devido a limitação de rota, volume excessivo ou reprogramação interna. Normalmente, ela entra novamente em rota nos dias seguintes.'
            ]
        ];

        foreach ($problemas as $problema) {
            Problema::updateOrCreate(
                ['slug' => $problema['slug']],
                $problema
            );
        }
    }
}
