@extends('layouts.app')

@section('title', 'Transportadoras - Status e Problemas Recentes | Situação da Entrega')
@section('description', 'Acompanhe em tempo real os problemas mais comuns relatados nas principais transportadoras do Brasil: Correios, Jadlog, Loggi e mais.')

@section('content')

<div style="margin-bottom: 2rem;">
    <h1 class="bloco-titulo" style="font-size: 2rem; margin-bottom: 0.5rem;">
        Transportadoras
    </h1>
    <p style="color: var(--cor-texto-secundario); font-size: 1.1rem;">
        Selecione uma transportadora para ver os problemas mais relatados e dicas de solução.
    </p>
</div>

<div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 1.5rem;">
    @foreach($transportadoras as $transportadora)
    <a href="{{ route('transportadora.mostrar', $transportadora->slug) }}" 
       style="display: block; background: white; border-radius: 16px; padding: 1.5rem; text-decoration: none; border: 1px solid var(--cor-borda); transition: all 0.2s ease; box-shadow: 0 2px 4px rgba(0,0,0,0.02);"
       onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 12px 24px rgba(0,0,0,0.08)'; this.style.borderColor='var(--cor-primaria-clara)';"
       onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 2px 4px rgba(0,0,0,0.02)'; this.style.borderColor='var(--cor-borda)';"
    >
        <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 1rem;">
            <div style="width: 60px; height: 60px; background: var(--cor-fundo); border-radius: 12px; display: flex; align-items: center; justify-content: center; overflow: hidden; border: 1px solid var(--cor-borda);">
                @if(file_exists(public_path('images/logos/' . $transportadora->slug . '.svg')))
                    <img src="{{ asset('images/logos/' . $transportadora->slug . '.svg') }}" alt="Logo {{ $transportadora->nome }}" title="Logo {{ $transportadora->nome }}" style="width: 100%; height: 100%; object-fit: contain; padding: 4px;">
                @else
                    <div style="color: var(--cor-primaria);">
                        <x-icon name="truck" size="28" />
                    </div>
                @endif
            </div>
            <div>
                <h2 style="font-size: 1.25rem; font-weight: 700; color: var(--cor-texto); margin: 0;">
                    {{ $transportadora->nome }}
                </h2>
                <span style="font-size: 0.85rem; color: var(--cor-texto-secundario); background: var(--cor-fundo); padding: 2px 8px; border-radius: 4px;">
                    Ver status
                </span>
            </div>
        </div>
        
        <p style="color: var(--cor-texto-secundario); font-size: 0.95rem; line-height: 1.5; margin: 0;">
            {{ $transportadora->descricao }}
        </p>
    </a>
    @endforeach
</div>

@endsection