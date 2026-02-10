@extends('layouts.admin')

@section('title', 'Blog | Admin')

@section('content')

<div class="admin-layout">
    @include('admin.partials.sidebar')

    <main class="admin-main">
        <div class="admin-header">
            <h1>Blog - Artigos</h1>
            <div class="user-menu">
                <a href="{{ route('admin.blog.create') }}" class="btn-primary" style="background-color: var(--admin-primary); color: white; padding: 0.5rem 1rem; border-radius: 6px; text-decoration: none; font-weight: 500;">
                    + Novo Artigo
                </a>
            </div>
        </div>

        @if(session('sucesso'))
        <div class="alert alert-success" style="margin-bottom: 1.5rem;">
            ✓ {{ session('sucesso') }}
        </div>
        @endif

        <div class="card">
            <div class="card-body" style="padding: 0;">
                <table class="table">
                    <thead>
                        <tr>
                            <th style="width: 80px">Thumb</th>
                            <th>Título</th>
                            <th>Autor</th>
                            <th>Views</th>
                            <th>Status</th>
                            <th>Publicação</th>
                            <th style="text-align: right;">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($posts as $post)
                        <tr>
                            <td>
                                @if($post->imagem_destaque)
                                    <img src="{{ asset($post->imagem_destaque) }}" alt="Thumb" style="width: 60px; height: 40px; object-fit: cover; border-radius: 4px; border: 1px solid #eee;">
                                @else
                                    <div style="width: 60px; height: 40px; background: #f3f4f6; border-radius: 4px; display: flex; align-items: center; justify-content: center; color: #9ca3af; font-size: 0.75rem; border: 1px solid #e5e7eb;">
                                        📷
                                    </div>
                                @endif
                            </td>
                            <td>
                                <div style="font-weight: 600;">{{ $post->titulo }}</div>
                                <div style="font-size: 0.85rem; color: var(--admin-text-muted);">/{{ $post->slug }}</div>
                            </td>
                            <td>{{ $post->autor_nome }}</td>
                            <td>
                                <span style="font-weight: 500; color: var(--admin-text-dark);">
                                    {{ number_format($post->views ?? 0, 0, ',', '.') }}
                                </span>
                            </td>
                            <td>
                                @if($post->publicado)
                                <span class="badge badge-success" style="background: #dcfce7; color: #166534; padding: 0.25rem 0.5rem; border-radius: 4px; font-size: 0.85rem;">Publicado</span>
                                @else
                                <span class="badge badge-warning" style="background: #fef9c3; color: #854d0e; padding: 0.25rem 0.5rem; border-radius: 4px; font-size: 0.85rem;">Rascunho</span>
                                @endif
                            </td>
                            <td>
                                @if($post->published_at)
                                {{ $post->published_at->format('d/m/Y H:i') }}
                                @else
                                -
                                @endif
                            </td>
                            <td style="text-align: right;">
                                <div style="display: flex; gap: 0.5rem; justify-content: flex-end;">
                                    <a href="{{ route('blog.show', $post->slug) }}" target="_blank" title="Ver" style="padding: 0.25rem; color: var(--admin-info);">
                                        👁️
                                    </a>
                                    <a href="{{ route('admin.blog.edit', $post->id) }}" title="Editar" style="padding: 0.25rem; color: var(--admin-warning);">
                                        ✏️
                                    </a>
                                    <form action="{{ route('admin.blog.destroy', $post->id) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir este artigo?');" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" title="Excluir" style="background: none; border: none; cursor: pointer; padding: 0.25rem;">
                                            🗑️
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" style="text-align: center; padding: 2rem; color: var(--admin-text-muted);">
                                Nenhum artigo encontrado.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($posts->hasPages())
            <div class="card-footer" style="padding: 1rem; border-top: 1px solid var(--admin-border);">
                {{ $posts->links() }}
            </div>
            @endif
        </div>
    </main>
</div>

@endsection
