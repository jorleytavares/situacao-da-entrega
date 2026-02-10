<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePostRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'titulo' => 'required|string|max:255',
            'subtitulo' => 'nullable|string|max:255',
            'conteudo' => 'required',
            'resumo' => 'nullable|string|max:500',
            'sge_summary' => 'nullable|string',
            'imagem_destaque' => 'nullable|image|max:10240',
            'imagem_alt' => 'required_with:imagem_destaque|string|max:255',
            'imagem_title' => 'required_with:imagem_destaque|string|max:255',
            'imagem_descricao' => 'required_with:imagem_destaque|string',
            'imagem_legenda' => 'nullable|string|max:255',
            'meta_schema' => 'nullable|string',
            'tags' => 'nullable|string',
            'autor_nome' => 'required|string|max:255',
            'autor_perfil' => 'nullable|url|max:255',
            'published_at' => 'nullable|date',
        ];
    }
}
