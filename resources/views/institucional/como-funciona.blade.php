@extends('layouts.app')

@section('title', 'Como Funciona - Situação da Entrega')
@section('meta_description', 'Entenda como o Situação da Entrega funciona e como você pode contribuir.')

@section('content')
<article id="id-artigo-principal">
    <header style="margin-bottom: 1.5rem;">
        <h1>Como Funciona</h1>
    </header>

    <section>
        <h2>1. Encontre seu Problema</h2>
        <p>
            Na página inicial, você encontra os problemas de entrega mais comuns.
            Clique no que mais se parece com o que você está enfrentando para
            ver informações detalhadas e dicas do que fazer.
        </p>
    </section>

    <section>
        <h2>2. Veja as Tendências</h2>
        <p>
            Na página de <a href="{{ route('tendencias') }}">Tendências</a>, você pode
            acompanhar quais problemas estão acontecendo com mais frequência e
            quais estados estão sendo mais afetados.
        </p>
    </section>

    <section>
        <h2>3. Compartilhe sua Experiência</h2>
        <p>
            Se você está passando por algum problema,
            <a href="{{ route('relato.formulario') }}">faça um relato</a>.
            Sua contribuição é anônima e ajuda a mapear a situação das entregas
            em todo o Brasil.
        </p>
    </section>

    <section>
        <h2>4. Ajude Outros</h2>
        <p>
            Ao compartilhar sua experiência, você ajuda outras pessoas
            que podem estar passando pela mesma situação.
            Juntos, conseguimos entender melhor o panorama geral.
        </p>
    </section>
</article>
@endsection