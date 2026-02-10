<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Configuracao extends Model
{
    protected $table = 'configuracoes';

    protected $fillable = [
        'chave',
        'valor',
        'ativo',
        'descricao'
    ];

    protected $casts = [
        'ativo' => 'boolean'
    ];

    /**
     * Busca valor de uma configuração ativa
     */
    public static function valor(string $chave): ?string
    {
        $config = static::where('chave', $chave)->where('ativo', true)->first();
        return $config?->valor;
    }

    /**
     * Retorna scripts para o HEAD
     */
    public static function scriptsHead(): array
    {
        return static::where('ativo', true)
            ->whereIn('chave', [
                'google_tag_manager',
                'google_analytics_4',
                'google_adsense',
                'custom_head'
            ])
            ->pluck('valor')
            ->filter()
            ->toArray();
    }

    /**
     * Retorna scripts para antes do </body>
     */
    public static function scriptsBody(): array
    {
        return static::where('ativo', true)
            ->whereIn('chave', [
                'google_tag_manager_body',
                'custom_body_end'
            ])
            ->pluck('valor')
            ->filter()
            ->toArray();
    }
}
