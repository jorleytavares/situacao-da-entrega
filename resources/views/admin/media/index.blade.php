@extends('layouts.admin')

@section('title', 'Gerenciador de Mídia')

@section('content')

<div class="admin-layout">
    @include('admin.partials.sidebar')

    <main class="admin-main">
        <div class="admin-header">
            <h1>Gerenciador de Mídia</h1>
        </div>

        @if(session('sucesso'))
        <div class="alert alert-success">
            {{ session('sucesso') }}
        </div>
        @endif

        @if(session('erro'))
        <div class="alert alert-error">
            {{ session('erro') }}
        </div>
        @endif

        @if($errors->any())
        <div class="alert alert-error">
            <ul style="margin: 0; padding-left: 1rem;">
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <div class="grid-layout">
            <div class="card full-width">
                <div class="card-header">
                    <h2>Upload de Imagem</h2>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.media.store') }}" method="POST" enctype="multipart/form-data" class="upload-form">
                        @csrf
                        <div class="upload-grid">
                            <div class="form-group">
                                <label for="file">Arquivo (Max: 5MB)</label>
                                <input type="file" name="file" id="file" class="form-control" accept="image/*" required>
                            </div>
                            <div class="form-group">
                                <label for="alt_text">Texto Alternativo (Alt Text)</label>
                                <input type="text" name="alt_text" id="alt_text" class="form-control" placeholder="Descrição da imagem para SEO">
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn-primary">Upload</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card full-width">
                <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
                    <h2>Biblioteca de Mídia</h2>
                    <form action="{{ route('admin.media.sync') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn-secondary" title="Buscar imagens existentes nas pastas">
                            🔄 Sincronizar Arquivos
                        </button>
                    </form>
                </div>
                <div class="card-body">
                    @if($media->count() > 0)
                        <div class="media-grid">
                            @foreach($media as $item)
                                <div class="media-item">
                                    <div class="media-preview">
                                        <img src="{{ asset($item->path) }}" alt="{{ $item->alt_text }}">
                                    </div>
                                    <div class="media-info">
                                        <span class="media-name" title="{{ $item->filename }}">{{ Str::limit($item->filename, 20) }}</span>
                                        <div class="media-actions">
                                            <button type="button" class="btn-copy" onclick="copyToClipboard('{{ asset($item->path) }}')" title="Copiar URL">
                                                📋
                                            </button>
                                            <button type="button" class="btn-edit" onclick='openEditModal({{ $item->id }}, @json($item->filename), @json($item->title), @json($item->alt_text), @json($item->description))' title="Editar Detalhes">
                                                ✏️
                                            </button>
                                            <form action="{{ route('admin.media.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir esta imagem?');" style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn-delete" title="Excluir">
                                                    🗑️
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        
                        <div class="pagination-container">
                            {{ $media->links('pagination::bootstrap-4') }}
                        </div>
                    @else
                        <p style="text-align: center; color: var(--admin-text-muted); padding: 2rem;">Nenhuma imagem encontrada.</p>
                    @endif
                </div>
            </div>
        </div>
        
        <!-- Edit Modal -->
        <div id="editMediaModal" class="modal">
            <div class="modal-content">
                <div class="modal-header">
                    <h3>Editar Imagem</h3>
                    <span class="close" onclick="closeEditModal()">&times;</span>
                </div>
                <form id="editMediaForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="edit_filename">Nome do Arquivo (apenas visualização)</label>
                            <input type="text" id="edit_filename" class="form-control" disabled style="background-color: #f5f5f5;">
                        </div>
                        <div class="form-group">
                            <label for="edit_title">Título</label>
                            <input type="text" name="title" id="edit_title" class="form-control" placeholder="Título da imagem">
                        </div>
                        <div class="form-group">
                            <label for="edit_alt_text">Texto Alternativo (Alt Text)</label>
                            <input type="text" name="alt_text" id="edit_alt_text" class="form-control" placeholder="Texto alternativo para SEO">
                        </div>
                        <div class="form-group">
                            <label for="edit_description">Descrição</label>
                            <textarea name="description" id="edit_description" class="form-control" rows="3" placeholder="Descrição detalhada"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn-secondary" onclick="closeEditModal()">Cancelar</button>
                        <button type="submit" class="btn-primary" style="width: auto; padding: 0 1.5rem;">Salvar Alterações</button>
                    </div>
                </form>
            </div>
        </div>
    </main>
</div>

<style>
    .upload-grid {
        display: grid;
        grid-template-columns: 1fr 1fr 120px;
        gap: 1.5rem;
        align-items: end;
    }
    
    .upload-grid .form-group {
        margin-bottom: 0;
    }

    .form-control {
        width: 100%;
        padding: 0.75rem;
        border: 1px solid var(--admin-border);
        border-radius: 6px;
        background: #fff;
        font-size: 0.9rem;
        color: var(--admin-text);
        box-sizing: border-box;
    }

    input[type="file"].form-control {
        padding: 0.5rem;
        height: auto;
    }

    .btn-primary {
        width: 100%;
        height: 42px;
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: var(--admin-primary);
        color: white;
        border: none;
        border-radius: 6px;
        font-size: 1rem;
        cursor: pointer;
        transition: background-color 0.2s;
    }

    .btn-primary:hover {
        background-color: var(--admin-primary-hover);
    }

    .btn-secondary {
        height: 36px;
        padding: 0 1rem;
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: white;
        color: var(--admin-primary);
        border: 1px solid var(--admin-primary);
        border-radius: 6px;
        font-size: 0.9rem;
        cursor: pointer;
        transition: all 0.2s;
    }

    .btn-secondary:hover {
        background-color: #f0f7ff;
    }

    @media (max-width: 768px) {
        .upload-grid {
            grid-template-columns: 1fr;
            gap: 1rem;
        }
    }

    .media-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
        gap: 1.5rem;
        margin-top: 1rem;
    }
    
    .media-item {
        border: 1px solid var(--admin-border);
        border-radius: 8px;
        overflow: hidden;
        transition: box-shadow 0.2s;
        background: var(--admin-card-bg);
    }
    
    .media-item:hover {
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }
    
    /* Modal Styles */
    .modal {
        display: none;
        position: fixed;
        z-index: 1000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0,0,0,0.5);
        align-items: center;
        justify-content: center;
        backdrop-filter: blur(2px);
    }

    .modal-content {
        background-color: #fff;
        margin: auto;
        padding: 0;
        border-radius: 8px;
        width: 90%;
        max-width: 500px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.2);
        animation: slideIn 0.3s;
    }

    @keyframes slideIn {
        from {transform: translateY(-20px); opacity: 0;}
        to {transform: translateY(0); opacity: 1;}
    }

    .modal-header {
        padding: 1rem 1.5rem;
        border-bottom: 1px solid var(--admin-border);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .modal-header h3 {
        margin: 0;
        font-size: 1.25rem;
        color: var(--admin-text);
    }

    .close {
        color: #aaa;
        font-size: 28px;
        font-weight: bold;
        cursor: pointer;
        line-height: 1;
    }

    .close:hover {
        color: var(--admin-text);
    }

    .modal-body {
        padding: 1.5rem;
    }

    .modal-footer {
        padding: 1rem 1.5rem;
        border-top: 1px solid var(--admin-border);
        display: flex;
        justify-content: flex-end;
        gap: 1rem;
    }

    .btn-edit {
        background: none;
        border: none;
        cursor: pointer;
        font-size: 1.2rem;
        padding: 0.2rem;
        transition: transform 0.2s;
    }
    .btn-edit:hover {
        transform: scale(1.1);
    }

    .media-preview {
        height: 120px;
        background: #f5f5f5;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
    }

    .media-preview img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .media-info {
        padding: 0.75rem;
        border-top: 1px solid var(--admin-border);
    }

    .media-name {
        display: block;
        font-size: 0.8rem;
        color: var(--admin-text);
        margin-bottom: 0.5rem;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .media-actions {
        display: flex;
        justify-content: space-between;
    }

    .btn-copy, .btn-delete {
        background: none;
        border: none;
        cursor: pointer;
        padding: 4px;
        border-radius: 4px;
        transition: background 0.2s;
    }

    .btn-copy:hover {
        background: #e3f2fd;
    }

    .btn-delete:hover {
        background: #ffebee;
    }
</style>

<script>
    function copyToClipboard(text) {
        navigator.clipboard.writeText(text).then(function() {
            alert('URL copiada para a área de transferência!');
        }, function(err) {
            console.error('Erro ao copiar URL: ', err);
        });
    }

    function openEditModal(id, filename, title, alt, description) {
        document.getElementById('editMediaModal').style.display = 'flex';
        document.getElementById('edit_filename').value = filename;
        document.getElementById('edit_title').value = title || '';
        document.getElementById('edit_alt_text').value = alt || '';
        document.getElementById('edit_description').value = description || '';

        // Update form action
        document.getElementById('editMediaForm').action = "{{ url('admin/media') }}/" + id;
    }

    function closeEditModal() {
        document.getElementById('editMediaModal').style.display = 'none';
    }

    // Close modal when clicking outside
    window.onclick = function(event) {
        var modal = document.getElementById('editMediaModal');
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
</script>
@endsection
