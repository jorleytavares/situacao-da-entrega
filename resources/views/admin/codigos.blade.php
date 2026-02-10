@extends('layouts.admin')

@section('title', 'Códigos de Tracking | Admin')

@section('content')

<div class="admin-layout">
    @include('admin.partials.sidebar')

    <main class="admin-main">
        <div class="admin-header">
            <h1>Códigos de Tracking</h1>
            <div class="user-menu">
                <span style="color: var(--admin-text-muted); font-size: 0.875rem;">
                    {{ session('admin_email') }}
                </span>
            </div>
        </div>

        @if(session('sucesso'))
        <div class="alert alert-success" style="margin-bottom: 1.5rem;">
            ✓ {{ session('sucesso') }}
        </div>
        @endif

        <form method="POST" action="{{ route('admin.codigos.salvar') }}" class="admin-form">
            @csrf

            @foreach($configs as $chave => $config)
            <div class="card">
                <div class="card-header">
                    <h2>{{ $config['titulo'] }}</h2>
                    <div class="toggle-wrapper">
                        <label class="toggle">
                            <input type="checkbox" name="ativo_{{ $chave }}" value="1"
                                {{ $valores[$chave]['ativo'] ? 'checked' : '' }}>
                            <span class="toggle-slider"></span>
                        </label>
                        <span class="toggle-label">{{ $valores[$chave]['ativo'] ? 'Ativo' : 'Inativo' }}</span>
                    </div>
                </div>
                <div class="card-body">
                    <p class="form-hint" style="margin-bottom: 0.75rem;">{{ $config['descricao'] }}</p>
                    <textarea name="valor_{{ $chave }}" rows="4"
                        placeholder="{{ $config['placeholder'] }}">{{ $valores[$chave]['valor'] }}</textarea>
                </div>
            </div>
            @endforeach

            <div class="alert" style="background: rgba(245, 158, 11, 0.1); border: 1px solid rgba(245, 158, 11, 0.3); color: #fcd34d; margin-bottom: 1.5rem;">
                ⚠️ <strong>Atenção:</strong> Scripts incorretos podem quebrar o site. Teste antes de ativar.
            </div>

            <button type="submit" class="btn-save">💾 Salvar configurações</button>
        </form>
    </main>
</div>

@endsection