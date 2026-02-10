@extends('layouts.app')

@section('title', 'Política de Privacidade - Situação da Entrega')
@section('meta_description', 'Política de privacidade do Situação da Entrega. Saiba como tratamos seus dados.')

@section('content')
<article id="id-artigo-principal">
    <header style="margin-bottom: 1.5rem;">
        <h1>Política de Privacidade</h1>
    </header>

    <section>
        <h2>Coleta de Dados</h2>
        <p>
            O <strong>Situação da Entrega</strong> coleta apenas as informações
            fornecidas voluntariamente pelos usuários ao fazer relatos:
        </p>
        <ul>
            <li>Tipo de problema</li>
            <li>Descrição do relato</li>
            <li>Estado e cidade (opcionais)</li>
        </ul>
        <p>
            <strong>Não coletamos</strong> nome, e-mail, telefone, código de rastreamento
            ou qualquer informação que possa identificar você pessoalmente.
        </p>
    </section>

    <section>
        <h2>Uso dos Dados</h2>
        <p>
            Os dados coletados são utilizados exclusivamente para:
        </p>
        <ul>
            <li>Gerar estatísticas sobre problemas de entrega</li>
            <li>Identificar tendências e regiões afetadas</li>
            <li>Melhorar as informações disponibilizadas no site</li>
        </ul>
    </section>

    <section>
        <h2>Anonimato</h2>
        <p>
            Todos os relatos são <strong>completamente anônimos</strong>.
            Não armazenamos endereços IP, cookies de identificação
            ou qualquer outro dado que permita rastrear a origem do relato.
        </p>
    </section>

    <section>
        <h2>Compartilhamento</h2>
        <p>
            <strong>Não compartilhamos, vendemos ou alugamos</strong> dados a terceiros.
            As estatísticas geradas são de uso exclusivo deste site e podem ser
            apresentadas de forma agregada e anônima.
        </p>
    </section>

    <section>
        <h2>Cookies</h2>
        <p>
            Utilizamos apenas cookies essenciais para o funcionamento do site
            (como cookies de sessão). Não utilizamos cookies de rastreamento
            ou publicidade.
        </p>
    </section>

    <section>
        <h2>Alterações</h2>
        <p>
            Esta política pode ser atualizada periodicamente.
            Recomendamos que você a consulte regularmente para se manter informado.
        </p>
        <p style="color: #6b7280;">
            <em>Última atualização: {{ date('d/m/Y') }}</em>
        </p>
    </section>
</article>
@endsection