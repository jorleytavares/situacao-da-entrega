<?php

namespace App\Http\Controllers;

use App\Models\Configuracao;
use Illuminate\Http\Request;

class ConfiguracaoController extends Controller
{
    public function codigos()
    {
        $configs = [
            'google_tag_manager' => [
                'titulo' => 'Google Tag Manager (HEAD)',
                'descricao' => 'Cole o código GTM que vai no <head>',
                'placeholder' => '<!-- Google Tag Manager -->...'
            ],
            'google_tag_manager_body' => [
                'titulo' => 'Google Tag Manager (BODY)',
                'descricao' => 'Cole o noscript do GTM que vai após <body>',
                'placeholder' => '<!-- Google Tag Manager (noscript) -->...'
            ],
            'google_analytics_4' => [
                'titulo' => 'Google Analytics 4',
                'descricao' => 'Cole o código GA4 completo',
                'placeholder' => '<!-- Google Analytics -->...'
            ],
            'google_adsense' => [
                'titulo' => 'Google AdSense',
                'descricao' => 'Cole o código AdSense',
                'placeholder' => '<script async src="https://pagead2.googlesyndication.com/..."></script>'
            ],
            'custom_head' => [
                'titulo' => 'Scripts personalizados (HEAD)',
                'descricao' => 'Outros scripts para o <head>',
                'placeholder' => '<!-- Seus scripts aqui -->'
            ],
            'custom_body_end' => [
                'titulo' => 'Scripts personalizados (antes de </body>)',
                'descricao' => 'Scripts que devem carregar no final',
                'placeholder' => '<!-- Seus scripts aqui -->'
            ]
        ];

        $valores = [];
        foreach (array_keys($configs) as $chave) {
            $config = Configuracao::where('chave', $chave)->first();
            $valores[$chave] = [
                'valor' => $config->valor ?? '',
                'ativo' => $config->ativo ?? false
            ];
        }

        return view('admin.codigos', compact('configs', 'valores'));
    }

    public function salvarCodigos(Request $request)
    {
        $chaves = [
            'google_tag_manager',
            'google_tag_manager_body',
            'google_analytics_4',
            'google_adsense',
            'custom_head',
            'custom_body_end'
        ];

        foreach ($chaves as $chave) {
            Configuracao::updateOrCreate(
                ['chave' => $chave],
                [
                    'valor' => $request->input("valor_{$chave}"),
                    'ativo' => $request->has("ativo_{$chave}")
                ]
            );
        }

        return redirect()->route('admin.codigos')->with('sucesso', 'Configurações salvas!');
    }
}
