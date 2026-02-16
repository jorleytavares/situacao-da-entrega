@extends('layouts.admin')

@section('title', 'Comentários - Moderação')

@section('content')

<div class="admin-layout">
    @include('admin.partials.sidebar')

    <main class="admin-main">
        <div class="admin-header">
            <h1 class="h3 text-gray-800">Comentários ({{ $comentarios->total() }})</h1>
        </div>

        @if(session('success'))
        <div class="alert alert-success" style="margin-bottom: 1.5rem;">{{ session('success') }}</div>
        @endif

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Moderação de Comentários</h6>
            </div>
            <div class="card-body">

                @if($comentarios->isEmpty())
                <div class="text-center py-5">
                    <p class="text-muted">Nenhum comentário encontrado.</p>
                </div>
                @else
                <div class="table-responsive">
                    <table class="table table-bordered text-sm" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Status</th>
                                <th>Autor</th>
                                <th>Comentário</th>
                                <th>Artigo</th>
                                <th>Data</th>
                                <th width="150">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($comentarios as $comentario)
                            <tr class="@if($comentario->status == 'pendente') bg-light @endif">
                                <td>
                                    @if($comentario->status == 'pendente')
                                    <span class="badge badge-warning" style="background: #f6c23e; color: #fff;">Pendente</span>
                                    @elseif($comentario->status == 'aprovado')
                                    <span class="badge badge-success" style="background: #1cc88a; color: #fff;">Aprovado</span>
                                    @else
                                    <span class="badge badge-danger" style="background: #e74a3b; color: #fff;">Rejeitado</span>
                                    @endif
                                </td>
                                <td>
                                    <strong>{{ $comentario->nome }}</strong><br>
                                    <small class="text-muted">{{ $comentario->email }}</small>
                                </td>
                                <td>
                                    <p class="mb-0 text-break" style="max-width: 400px; font-size: 0.9rem;">{{ Str::limit($comentario->mensagem, 150) }}</p>
                                    @if(strlen($comentario->mensagem) > 150)
                                    <small><a href="#" onclick="alert('{{ js_escape($comentario->mensagem) }}'); return false;">Ler tudo</a></small>
                                    @endif
                                </td>
                                <td>
                                    <small>
                                        <a href="{{ route('blog.show', $comentario->post->slug) }}" target="_blank" style="color: var(--admin-primary);">
                                            {{ Str::limit($comentario->post->titulo, 30) }}
                                            ↗
                                        </a>
                                    </small>
                                </td>
                                <td>{{ $comentario->created_at->format('d/m H:i') }}</td>
                                <td>
                                    <div style="display: flex; gap: 0.5rem;">
                                        @if($comentario->status == 'pendente' || $comentario->status == 'rejeitado')
                                        <form action="{{ route('admin.comentarios.update', $comentario->id) }}" method="POST" style="display: inline;">
                                            @csrf @method('PUT')
                                            <input type="hidden" name="status" value="aprovado">
                                            <button type="submit" class="btn btn-success btn-sm" title="Aprovar" style="background: #1cc88a; border: none; color: white; padding: 0.25rem 0.5rem; cursor: pointer; border-radius: 4px;">
                                                ✓
                                            </button>
                                        </form>
                                        @endif

                                        @if($comentario->status == 'pendente' || $comentario->status == 'aprovado')
                                        <form action="{{ route('admin.comentarios.update', $comentario->id) }}" method="POST" style="display: inline;">
                                            @csrf @method('PUT')
                                            <input type="hidden" name="status" value="rejeitado">
                                            <button type="submit" class="btn btn-warning btn-sm" title="Rejeitar" style="background: #f6c23e; border: none; color: white; padding: 0.25rem 0.5rem; cursor: pointer; border-radius: 4px;">
                                                ✕
                                            </button>
                                        </form>
                                        @endif

                                        <form action="{{ route('admin.comentarios.destroy', $comentario->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Excluir este comentário permanentemente?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" title="Excluir" style="background: #e74a3b; border: none; color: white; padding: 0.25rem 0.5rem; cursor: pointer; border-radius: 4px;">
                                                🗑
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-center mt-4">
                    {{ $comentarios->links() }}
                </div>
                @endif
            </div>
        </div>
    </main>
</div>
@endsection