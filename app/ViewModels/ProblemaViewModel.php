<?php

namespace App\ViewModels;

use App\Models\Problema;

class ProblemaViewModel
{
    protected Problema $problema;

    public function __construct(Problema $problema)
    {
        $this->problema = $problema;
    }

    /**
     * Título formatado
     */
    public function titulo(): string
    {
        return $this->problema->titulo;
    }

    /**
     * Descrição curta (primeiros 150 caracteres)
     */
    public function descricaoCurta(): string
    {
        return str($this->problema->descricao)->limit(150);
    }

    /**
     * Descrição completa
     */
    public function descricao(): string
    {
        return $this->problema->descricao;
    }

    /**
     * URL da página do problema
     */
    public function url(): string
    {
        return route('problema.show', $this->problema->slug);
    }

    /**
     * Ícone do problema (com fallback)
     */
    public function icone(): string
    {
        return $this->problema->icone ?? '📦';
    }

    /**
     * Total de relatos
     */
    public function totalRelatos(): int
    {
        return $this->problema->relatos()->count();
    }

    /**
     * Dados para SEO
     */
    public function seo(): array
    {
        return [
            'title' => $this->problema->titulo . ' - Situação da Entrega',
            'description' => $this->descricaoCurta(),
            'canonical' => $this->url(),
        ];
    }

    /**
     * Retorna array para uso em views
     */
    public function toArray(): array
    {
        return [
            'titulo' => $this->titulo(),
            'descricao' => $this->descricao(),
            'descricao_curta' => $this->descricaoCurta(),
            'url' => $this->url(),
            'icone' => $this->icone(),
            'total_relatos' => $this->totalRelatos(),
            'seo' => $this->seo(),
        ];
    }
}
