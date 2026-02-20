<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Situação da Entrega')</title>
    <meta name="description" content="@yield('description', 'Entenda rapidamente o que está acontecendo com sua entrega.')">
    <meta name="robots" content="index, follow, max-image-preview:large">
    <meta name="revisit-after" content="7 days">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-Content-Type-Options" content="nosniff">
    <meta name="referrer" content="strict-origin-when-cross-origin">

    <meta property="og:title" content="@yield('title', 'Situação da Entrega')">
    <meta property="og:description" content="@yield('description', 'Entenda rapidamente o que está acontecendo com sua entrega.')">
    <meta property="og:type" content="website">
    <meta property="og:locale" content="pt_BR">
    <meta property="og:site_name" content="Situação da Entrega">
    <meta property="og:image" content="@yield('og_image', asset('logo.svg'))">
    <meta property="twitter:image" content="@yield('og_image', asset('logo.svg'))">
    <meta property="og:image:type" content="image/svg+xml">
    <meta property="og:image:width" content="512">
    <meta property="og:image:height" content="512">

    <link rel="icon" href="{{ asset('favicon.svg') }}" type="image/svg+xml">
    <link rel="apple-touch-icon" href="{{ asset('logo.svg') }}">
    <link rel="manifest" href="{{ asset('manifest.json') }}">

    <meta name="theme-color" content="#128C7E">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="#128C7E">
    <meta name="apple-mobile-web-app-title" content="Situação da Entrega">

    <meta name="keywords" content="rastreamento correios, encomenda parada, fiscalização aduaneira, minhas importações, taxas importação, loggi, jadlog, azul cargo">
    <meta name="author" content="Equipe Situação da Entrega">
    <meta name="publisher" content="Situação da Entrega">

    <!-- JSON-LD WebSite Schema -->
    <script type="application/ld+json">
        @php
        $jsonLd = [
            "@context" => "https://schema.org",
            "@type" => "WebSite",
            "name" => "Situação da Entrega",
            "url" => url('/'),
            "potentialAction" => [
                "@type" => "SearchAction",
                "target" => url('/').
                "/buscar?q={search_term_string}",
                "query-input" => "required name=search_term_string"
            ]
        ];
        @endphp {
            !!json_encode($jsonLd, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!
        }
    </script>

    <link rel="canonical" href="{{ url()->current() }}">
    <link rel="stylesheet" href="/css/index.css">
    <link rel="stylesheet" href="/css/search.css">

    <!-- GEO Tags -->
    <meta name="geo.region" content="BR">
    <meta name="geo.placename" content="Brasil">
    <meta name="geo.position" content="-14.235004;-51.92528">
    <meta name="ICBM" content="-14.235004, -51.92528">

    <!-- Schema.org Organization & Breadcrumb -->
    <!-- Schema.org Organization & Breadcrumb -->
    <!-- Schema.org Organization e Breadcrumb removidos temporariamente -->

    @if(isset($scriptsHead))
    @foreach($scriptsHead as $script)
    {!! $script !!}
    @endforeach
    @endif

    @yield('head')
</head>

<body>
    @if(isset($scriptsBodyStart))
    @foreach($scriptsBodyStart as $script)
    {!! $script !!}
    @endforeach
    @endif

    <div id="id-layout-principal">
        <header id="id-header" role="banner">
            <div class="header-container">
                <div class="site-title">
                    <a href="{{ route('home') }}" title="Ir para a página inicial">
                        <img src="{{ asset('favicon.svg') }}" alt="Situação da Entrega Logo" title="Situação da Entrega - Logo" width="36" height="36" style="vertical-align: middle; margin-right: 8px;">
                        Situação da Entrega
                    </a>
                </div>

                <!-- Busca Global -->
                <form action="{{ route('busca') }}" method="GET" class="header-search d-none d-md-flex" role="search">
                    <input type="search" name="q" placeholder="Buscar rastreio, problema..." aria-label="Buscar" required>
                    <button type="submit" aria-label="Buscar">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="11" cy="11" r="8"></circle>
                            <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                        </svg>
                    </button>
                </form>
            </div>
        </header>
        <main id="id-conteudo-principal" role="main">
            @yield('content')
        </main>
        <footer id="id-footer" role="contentinfo">
            <div style="margin-bottom: 1rem;">
                <a href="{{ route('home') }}" aria-label="Ir para a página inicial" title="Ir para a página inicial">
                    <img src="{{ asset('logo.svg') }}" alt="Situação da Entrega Logo" title="Situação da Entrega - Logo" width="48" height="48" style="opacity: 0.8; transition: opacity 0.2s;" onmouseover="this.style.opacity=1" onmouseout="this.style.opacity=0.8">
                </a>
            </div>
            <p>
                © {{ date('Y') }} Situação da Entrega ·
                <span class="d-none d-md-inline">
                    <strong>{{ number_format($totalRelatosGlobal ?? 0, 0, ',', '.') }}</strong> relatos ajudando pessoas ·
                </span>
                <a href="{{ route('blog.index') }}" style="font-weight: 500;">Blog & Dicas</a> ·
                <a href="{{ route('calculadora.taxas') }}" style="font-weight: 500; color: #128C7E;">Calculadora de Taxas</a> ·
                <a href="{{ route('metodologia') }}">Metodologia</a> ·
                <a href="{{ route('aviso_legal') }}">Aviso legal</a> ·
                <a href="{{ route('politica_privacidade') }}">Privacidade</a>
            </p>
            <div class="footer-credit">
                <a href="https://hostamazonas.com.br" target="_blank" rel="noopener noreferrer">
                    Host Amazonas - Criação de Sites
                </a>
            </div>
        </footer>
    </div>
    <script src="/js/graficos.js"></script>

    @if(isset($scriptsBody))
    @foreach($scriptsBody as $script)
    {!! $script !!}
    @endforeach
    @endif
</body>

</html>
