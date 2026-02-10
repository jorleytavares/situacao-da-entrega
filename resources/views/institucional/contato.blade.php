@extends('layouts.app')

@section('title', 'Contato - Situação da Entrega')
@section('meta_description', 'Entre em contato com o Situação da Entrega.')

@section('content')
<article id="id-artigo-principal">
    <header style="margin-bottom: 1.5rem;">
        <h1>Contato</h1>
    </header>

    <section>
        <h2>Fale Conosco</h2>
        <p>
            O <strong>Situação da Entrega</strong> é um projeto informativo e colaborativo.
            Se você precisa de ajuda com uma encomenda específica, recomendamos entrar em
            contato diretamente com a transportadora ou vendedor responsável.
        </p>
    </section>

    <section>
        <h2>Sugestões e Feedback</h2>
        <p>
            Se você tem sugestões para melhorar o site ou identificou algum erro nas informações,
            ficaremos felizes em ouvir você.
        </p>
    </section>

    <section>
        <h2>Importante</h2>
        <p>
            <strong>Não somos os Correios nem transportadoras.</strong>
            Não temos acesso a informações sobre encomendas específicas e não podemos
            ajudar a localizar ou agilizar entregas.
        </p>
        <p>
            Para problemas com entregas, entre em contato com:
        </p>
        <ul>
            <li><strong>Correios:</strong> 0800 725 7282</li>
            <li><strong>Vendedor:</strong> Site ou app onde você comprou</li>
            <li><strong>Transportadora:</strong> Número informado no rastreamento</li>
        </ul>
    </section>

    <section class="bloco" style="text-align: center;">
        <h3 class="bloco-titulo">Quer contribuir?</h3>
        <p class="bloco-texto">Compartilhe sua experiência para ajudar outras pessoas!</p>
        <a href="{{ route('relato.formulario') }}" class="btn btn-primario">Fazer Relato</a>
    </section>
</article>
@endsection