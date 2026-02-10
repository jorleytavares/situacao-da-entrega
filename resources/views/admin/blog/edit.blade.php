@extends('layouts.admin')

@section('title', 'Editar Artigo | Admin')

@section('content')

<div class="admin-layout">
    @include('admin.partials.sidebar')

    <main class="admin-main">
        <div class="admin-header">
            <h1>Editar Artigo</h1>
            <div class="user-menu">
                <a href="{{ route('admin.blog.index') }}" style="color: var(--admin-text-muted); text-decoration: none;">
                    ← Voltar
                </a>
            </div>
        </div>

        @if($errors->any())
        <div class="alert alert-error">
            <ul style="margin-left: 1.5rem;">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form action="{{ route('admin.blog.update', $post->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="admin-post-grid">
                <!-- Main Content Column -->
                <div class="admin-post-main">
                    <div class="card">
                        <div class="card-header">
                            <h2>Conteúdo Principal</h2>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label for="titulo">Título *</label>
                                <input type="text" name="titulo" id="titulo" class="form-control" value="{{ old('titulo', $post->titulo) }}" required>
                            </div>

                            <div class="form-group">
                                <label for="subtitulo">Subtítulo (Opcional)</label>
                                <input type="text" name="subtitulo" id="subtitulo" class="form-control" value="{{ old('subtitulo', $post->subtitulo) }}">
                            </div>

                            <div class="form-group">
                                <label for="conteudo">Conteúdo Completo (HTML) *</label>
                                <textarea name="conteudo" id="conteudo" rows="20" class="form-control" style="font-family: monospace;" required>{{ old('conteudo', $post->conteudo) }}</textarea>
                                <small>Use tags HTML para formatar (h2, p, strong, ul, li).</small>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <h2>SEO Avançado & AI</h2>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label for="tags">Tags (separadas por vírgula)</label>
                                <input type="text" name="tags" id="tags" class="form-control" value="{{ old('tags', is_array($post->tags) ? implode(', ', $post->tags) : $post->tags) }}" placeholder="Logística, Correios, Rastreamento">
                            </div>

                            <div class="form-group">
                                <label for="sge_summary">Resumo para IA (llms.txt)</label>
                                <textarea name="sge_summary" id="sge_summary" rows="4" class="form-control">{{ old('sge_summary', $post->sge_summary) }}</textarea>
                                <small>Texto otimizado para indexação por LLMs (ChatGPT, Claude, etc).</small>
                            </div>

                            <div class="form-group">
                                <label for="meta_schema">Dados Estruturados (JSON-LD)</label>
                                <textarea name="meta_schema" id="meta_schema" rows="6" class="form-control" style="font-family: monospace;">{{ old('meta_schema', is_array($post->meta_schema) ? json_encode($post->meta_schema, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) : $post->meta_schema) }}</textarea>
                                <small>Insira o JSON válido do Schema.org aqui.</small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sidebar Column -->
                <div class="admin-post-sidebar">
                    <!-- Publish Card -->
                    <div class="card">
                        <div class="card-header">
                            <h2>Publicação</h2>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <div class="toggle-wrapper">
                                    <label class="toggle" for="publicado">
                                        <input type="checkbox" name="publicado" id="publicado" value="1" {{ old('publicado', $post->publicado) ? 'checked' : '' }}>
                                        <span class="toggle-slider"></span>
                                    </label>
                                    <span>Publicado</span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="published_at">Data de Publicação</label>
                                <input type="datetime-local" name="published_at" id="published_at" class="form-control" value="{{ old('published_at', $post->published_at ? $post->published_at->format('Y-m-d\TH:i') : '') }}">
                            </div>

                            <button type="submit" class="btn-primary" style="width: 100%;">
                                Atualizar Artigo
                            </button>
                        </div>
                    </div>

                    <!-- Media Card -->
                    <div class="card">
                        <div class="card-header">
                            <h2>Mídia e Destaque</h2>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label for="imagem_title">Nome do Arquivo (SEO) *</label>
                                <input type="text" name="imagem_title" id="imagem_title" class="form-control" value="{{ old('imagem_title', $post->imagem_title) }}" placeholder="ex: rastreamento-correios-2025">
                                <small>Nome otimizado para o arquivo da imagem (sem extensão).</small>
                            </div>

                            <div class="form-group">
                                <label for="imagem_destaque">Imagem de Destaque</label>
                                
                                <div id="image-preview-container" style="{{ $post->imagem_destaque ? 'display: block;' : 'display: none;' }} margin: 0.5rem 0 1rem;">
                                    <img id="image-preview" src="{{ $post->imagem_destaque ? asset($post->imagem_destaque) : '' }}" alt="Preview" style="width: 100%; border-radius: 6px; border: 1px solid var(--admin-border); object-fit: cover;">
                                    <small style="display: block; margin-top: 0.5rem; color: var(--admin-text-muted);">
                                        {{ $post->imagem_destaque ? 'Imagem atual (será substituída se enviar nova)' : 'Preview da imagem selecionada' }}
                                    </small>
                                </div>

                                <input type="file" name="imagem_destaque" id="imagem_destaque" class="form-control" accept="image/*">
                            </div>

                            <div class="form-group">
                                <label for="imagem_alt">Texto Alternativo (Alt) *</label>
                                <input type="text" name="imagem_alt" id="imagem_alt" class="form-control" value="{{ old('imagem_alt', $post->imagem_alt) }}" placeholder="Descreva a imagem para leitores de tela...">
                            </div>

                            <div class="form-group">
                                <label for="imagem_descricao">Descrição Longa (SEO) *</label>
                                <textarea name="imagem_descricao" id="imagem_descricao" rows="3" class="form-control" placeholder="Contexto detalhado da imagem...">{{ old('imagem_descricao', $post->imagem_descricao) }}</textarea>
                            </div>

                            <div class="form-group">
                                <label for="imagem_legenda">Legenda (Visível)</label>
                                <input type="text" name="imagem_legenda" id="imagem_legenda" class="form-control" value="{{ old('imagem_legenda', $post->imagem_legenda) }}">
                            </div>
                        </div>
                    </div>

                    <!-- Author Card -->
                    <div class="card">
                        <div class="card-header">
                            <h2>Autor</h2>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label for="autor_nome">Nome do Autor *</label>
                                <input type="text" name="autor_nome" id="autor_nome" class="form-control" value="{{ old('autor_nome', $post->autor_nome) }}" required>
                            </div>

                            <div class="form-group">
                                <label for="autor_perfil">URL do Perfil</label>
                                <input type="url" name="autor_perfil" id="autor_perfil" class="form-control" value="{{ old('autor_perfil', $post->autor_perfil) }}">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </main>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const imageInput = document.getElementById('imagem_destaque');
        const previewContainer = document.getElementById('image-preview-container');
        const previewImage = document.getElementById('image-preview');

        imageInput.addEventListener('change', function(event) {
            const file = event.target.files[0];
            
            if (file) {
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    previewImage.src = e.target.result;
                    previewContainer.style.display = 'block';
                }
                
                reader.readAsDataURL(file);
            }
            // Note: If user cancels or selects nothing, we keep the old preview if it existed (edit mode) or clear it?
            // Standard behavior: input file clear might not be detectable easily on 'change' if cancelled in some browsers, 
            // but if file list is empty, we should revert or clear.
            // For simplicity, if no file, we do nothing or could revert to original src if tracked.
        });
    });
</script>

@endsection
