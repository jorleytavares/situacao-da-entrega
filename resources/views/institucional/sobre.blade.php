@extends('layouts.app')

@section('title', 'Sobre - Situação da Entrega')
@section('meta_description', 'Conheça o projeto Situação da Entrega, uma plataforma para acompanhar problemas de entrega no Brasil.')

@section('content')
<article id="id-artigo-principal">
    <header style="margin-bottom: 1.5rem;">
        <h1>Sobre o Projeto</h1>
    </header>

    <section>
        <h2>O que é o Situação da Entrega?</h2>
        <p>
            O <strong>Situação da Entrega</strong> é uma plataforma colaborativa que reúne informações
            sobre problemas de entrega no Brasil. Nosso objetivo é ajudar pessoas que estão passando
            por dificuldades com suas encomendas, oferecendo informações claras e práticas.
        </p>
    </section>

    <section>
        <h2>Como Funciona?</h2>
        <p>
            Reunimos relatos de usuários de todo o Brasil sobre problemas com entregas.
            Com esses dados, identificamos tendências, mapeamos regiões com mais problemas
            e oferecemos orientações sobre o que fazer em cada situação.
        </p>
    </section>

    <section>
        <h2>Por Que Criamos Isso?</h2>
        <p>
            Sabemos como é frustrante esperar por uma encomenda que não chega.
            Muitas vezes as informações são confusas e não sabemos o que fazer.
            Este projeto nasceu para reunir a experiência coletiva e ajudar
            quem está passando pela mesma situação.
        </p>
    </section>

    <section>
        <h2>Contribua</h2>
        <p>
            Você pode ajudar compartilhando sua experiência.
            Cada relato ajuda a construir um panorama mais completo da situação das entregas no Brasil.
        </p>
        <a href="{{ route('relato.formulario') }}" class="btn btn-primario">Fazer Relato</a>
    </section>
</article>
@endsection