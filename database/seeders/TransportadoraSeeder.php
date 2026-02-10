<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TransportadoraSeeder extends Seeder
{
    public function run(): void
    {
        $transportadoras = [
            [
                'nome' => 'Correios',
                'descricao' => 'Empresa Brasileira de Correios e Telégrafos',
                'url_site' => 'https://www.correios.com.br',
                'cor' => '#ffe600'
            ],
            [
                'nome' => 'Jadlog',
                'descricao' => 'Jadlog Logística',
                'url_site' => 'https://www.jadlog.com.br',
                'cor' => '#ff0000'
            ],
            [
                'nome' => 'Azul Cargo',
                'descricao' => 'Azul Cargo Express',
                'url_site' => 'https://www.azulcargoexpress.com.br',
                'cor' => '#0055ff'
            ],
            [
                'nome' => 'Loggi',
                'descricao' => 'Loggi Tecnologia',
                'url_site' => 'https://www.loggi.com',
                'cor' => '#00a1ff'
            ],
            [
                'nome' => 'Total Express',
                'descricao' => 'Total Express',
                'url_site' => 'https://www.totalexpress.com.br',
                'cor' => '#000000'
            ],
            [
                'nome' => 'Sequoia',
                'descricao' => 'Sequoia Logística',
                'url_site' => 'https://www.sequoialog.com.br',
                'cor' => '#009933'
            ],
            [
                'nome' => 'Braspress',
                'descricao' => 'Braspress Transportes Urgentes',
                'url_site' => 'https://www.braspress.com.br',
                'cor' => '#003399'
            ]
        ];

        foreach ($transportadoras as $t) {
            DB::table('transportadoras')->updateOrInsert(
                ['slug' => Str::slug($t['nome'])],
                [
                    'nome' => $t['nome'],
                    'descricao' => $t['descricao'],
                    'url_site' => $t['url_site'],
                    'cor' => $t['cor'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }
    }
}
