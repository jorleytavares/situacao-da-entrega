<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'titulo',
        'subtitulo',
        'slug',
        'conteudo',
        'resumo',
        'sge_summary',
        'imagem_destaque',
        'imagem_alt',
        'imagem_title',
        'imagem_descricao',
        'imagem_legenda',
        'meta_schema',
        'tags',
        'autor_nome',
        'autor_perfil',
        'publicado',
        'published_at',
        'views'
    ];

    protected $casts = [
        'meta_schema' => 'array',
        'tags' => 'array',
        'publicado' => 'boolean',
        'published_at' => 'datetime'
    ];

    /**
     * Retorna o conteúdo com links inteligentes para SEO (Cross-linking)
     */
    public function getConteudoFormatadoAttribute()
    {
        $conteudo = $this->conteudo;

        $keywords = [
            'Correios' => route('transportadora.mostrar', 'correios'),
            'Jadlog' => route('transportadora.mostrar', 'jadlog'),
            'Azul Cargo' => route('transportadora.mostrar', 'azul-cargo'),
            'Loggi' => route('transportadora.mostrar', 'loggi'),
            'Total Express' => route('transportadora.mostrar', 'total-express'),
            'Encomenda Parada' => route('problema.mostrar', 'encomenda-parada-fiscalizacao'),
            'Taxas' => route('problema.mostrar', 'taxa-importacao-alfandega'),
            'Fiscalização' => route('problema.mostrar', 'fiscalizacao-aduaneira'),
            'Objeto não localizado' => route('problema.mostrar', 'objeto-nao-localizado'),
        ];

        foreach ($keywords as $keyword => $url) {
            // Substitui apenas a primeira ocorrência para não poluir (SEO Best Practice)
            // Usa regex para evitar substituir dentro de tags HTML já existentes
            $pattern = "/(?!(?:[^<]+>|[^>]+<\/a>))\b" . preg_quote($keyword, '/') . "\b/u";
            $conteudo = preg_replace($pattern, '<a href="' . $url . '" title="Saiba mais sobre ' . $keyword . '" style="color: var(--cor-primaria); text-decoration: underline;">' . $keyword . '</a>', $conteudo, 1);
        }

        return $conteudo;
    }
}
