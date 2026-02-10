@extends('layouts.admin')

@section('title', 'Login | dash-hostamazonas')

@section('content')

<div class="login-container">
    <div class="login-card">
        <div class="login-logo">
            <div class="icon">📦</div>
            <h1>Situação da Entrega</h1>
            <p>Painel Administrativo</p>
        </div>

        @if(session('erro'))
        <div class="alert alert-error">
            ⚠️ {{ session('erro') }}
        </div>
        @endif

        @if(session('sucesso'))
        <div class="alert alert-success">
            ✓ {{ session('sucesso') }}
        </div>
        @endif

        <form method="POST" action="{{ route('admin.login.post') }}">
            @csrf

            <div class="form-group">
                <label for="email">E-mail</label>
                <input type="email" name="email" id="email" required autofocus
                    placeholder="seu@email.com" value="{{ old('email') }}">
            </div>

            <div class="form-group">
                <label for="senha">Senha</label>
                <input type="password" name="senha" id="senha" required
                    placeholder="••••••••">
            </div>

            <button type="submit" class="btn-primary">Entrar</button>
        </form>

        <div class="login-footer">
            <a href="{{ route('home') }}">← Voltar ao site</a>
        </div>
    </div>
</div>

@endsection