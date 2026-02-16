@extends('layouts.admin')

@section('title', 'Comentários - Moderação')

@section('content')
<div class="row mb-4">
    <div class="col-12 d-flex justify-content-between align-items-center">
        <h1 class="h3 text-gray-800">Comentários ({{ $comentarios->total() }})</h1>
    </div>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Moderação de Comentários</h6>
    </div>
    <div class="card-body">
        @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
        @endif

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
                            <span class="badge badge-warning">Pendente</span>
                            @elseif($comentario->status == 'aprovado')
                            <span class="badge badge-success">Aprovado</span>
                            @else
                            <span class="badge badge-danger">Rejeitado</span>
                            @endif
                        </td>
                        <td>
                            <strong>{{ $comentario->nome }}</strong><br>
                            <small class="text-muted">{{ $comentario->email }}</small>
                        </td>
                        <td>
                            <p class="mb-0 text-break" style="max-width: 400px;">{{ Str::limit($comentario->mensagem, 150) }}</p>
                            @if(strlen($comentario->mensagem) > 150)
                            <small><a href="#" data-toggle="modal" data-target="#modalMsg{{ $comentario->id }}">Ler tudo</a></small>

                            <!-- Modal -->
                            <div class="modal fade" id="modalMsg{{ $comentario->id }}" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Comentário Completo</h5>
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        </div>
                                        <div class="modal-body">
                                            {{ $comentario->mensagem }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif
                        </td>
                        <td>
                            <small>
                                <a href="{{ route('blog.show', $comentario->post->slug) }}" target="_blank">
                                    {{ Str::limit($comentario->post->titulo, 30) }}
                                    <i class="fas fa-external-link-alt text-xs"></i>
                                </a>
                            </small>
                        </td>
                        <td>{{ $comentario->created_at->format('d/m H:i') }}</td>
                        <td>
                            <div class="d-flex gap-2">
                                @if($comentario->status == 'pendente' || $comentario->status == 'rejeitado')
                                <form action="{{ route('admin.comentarios.update', $comentario->id) }}" method="POST" class="d-inline">
                                    @csrf @method('PUT')
                                    <input type="hidden" name="status" value="aprovado">
                                    <button type="submit" class="btn btn-success btn-sm" title="Aprovar">
                                        <i class="fas fa-check"></i>
                                    </button>
                                </form>
                                @endif

                                @if($comentario->status == 'pendente' || $comentario->status == 'aprovado')
                                <form action="{{ route('admin.comentarios.update', $comentario->id) }}" method="POST" class="d-inline ml-1">
                                    @csrf @method('PUT')
                                    <input type="hidden" name="status" value="rejeitado">
                                    <button type="submit" class="btn btn-warning btn-sm" title="Rejeitar">
                                        <i class="fas fa-ban"></i>
                                    </button>
                                </form>
                                @endif

                                <form action="{{ route('admin.comentarios.destroy', $comentario->id) }}" method="POST" class="d-inline ml-1" onsubmit="return confirm('Excluir este comentário permanentemente?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" title="Excluir">
                                        <i class="fas fa-trash"></i>
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
@endsection