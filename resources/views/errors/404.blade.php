@extends('layouts.app')

@section('title', 'Página não encontrada | Situação da Entrega')

@section('content')
<div class="container" style="min-height: 60vh; display: flex; align-items: center; justify-content: center; text-align: center; padding: 2rem;">
    <div class="error-content" style="max-width: 600px;">
        <!-- Ilustração SVG Criativa -->
        <svg width="200" height="200" viewBox="0 0 200 200" fill="none" xmlns="http://www.w3.org/2000/svg" style="margin-bottom: 2rem;">
            <path d="M40 70L100 40L160 70V140L100 170L40 140V70Z" fill="#F3F4F6" stroke="#E5E7EB" stroke-width="4"/>
            <path d="M40 70L100 100L160 70" stroke="#E5E7EB" stroke-width="4"/>
            <path d="M100 100V170" stroke="#E5E7EB" stroke-width="4"/>
            <circle cx="100" cy="90" r="30" fill="#FEE2E2" />
            <path d="M90 80L110 100M110 80L90 100" stroke="#EF4444" stroke-width="4" stroke-linecap="round"/>
            <path d="M130 150C130 150 150 140 160 120" stroke="#9CA3AF" stroke-width="2" stroke-dasharray="4 4"/>
            <path d="M70 150C70 150 50 140 40 120" stroke="#9CA3AF" stroke-width="2" stroke-dasharray="4 4"/>
        </svg>

        <h1 style="font-size: 2.5rem; color: #1F2937; margin-bottom: 1rem; font-weight: 800;">Extraviado!</h1>
        
        <p style="font-size: 1.1rem; color: #4B5563; margin-bottom: 2rem; line-height: 1.6;">
            Ops! Parece que esta página ficou presa em Curitiba ou caiu do caminhão da entrega.<br>
            O link que você tentou acessar não existe ou foi movido.
        </p>

        <div style="display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap;">
            <a href="{{ route('home') }}" class="botao">
                Voltar para o Início
            </a>
            <a href="{{ route('relato.formulario') }}" class="botao" style="background-color: white; color: var(--cor-primaria); border: 1px solid var(--cor-primaria);">
                Relatar um Problema
            </a>
        </div>
        
        <div style="margin-top: 3rem; padding-top: 2rem; border-top: 1px solid #E5E7EB;">
            <p style="font-size: 0.9rem; color: #6B7280;">
                Procurando sua encomenda? <a href="{{ route('home') }}" style="color: var(--cor-primaria); text-decoration: underline;">Faça uma busca pelo código de rastreio</a>.
            </p>
        </div>
    </div>
</div>
@endsection
