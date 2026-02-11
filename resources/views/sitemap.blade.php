{!! '<?xml version="1.0" encoding="UTF-8"?>' !!}
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">

    <url>
        <loc>{{ url('/') }}</loc>
        <lastmod>{{ $now }}</lastmod>
        <priority>1.0</priority>
    </url>

    <url>
        <loc>{{ url('/tendencias') }}</loc>
        <lastmod>{{ $now }}</lastmod>
        <priority>0.9</priority>
    </url>

    <url>
        <loc>{{ url('/relatar') }}</loc>
        <priority>0.8</priority>
    </url>

    <url>
        <loc>{{ url('/metodologia-dos-dados') }}</loc>
        <priority>0.5</priority>
    </url>

    <url>
        <loc>{{ route('calculadora.taxas') }}</loc>
        <changefreq>weekly</changefreq>
        <priority>0.8</priority>
    </url>

@foreach($problemas as $problema)
    <url>
        <loc>{{ url('/problema/' . $problema->slug) }}</loc>
        <priority>0.7</priority>
    </url>
@endforeach

@foreach($estados as $uf)
    <url>
        <loc>{{ url('/estado/' . strtolower($uf)) }}</loc>
        <priority>0.6</priority>
    </url>
@endforeach

    @foreach($posts as $post)
    <url>
        <loc>{{ route('blog.show', $post->slug) }}</loc>
        <lastmod>{{ $post->updated_at->toIso8601String() }}</lastmod>
        <changefreq>monthly</changefreq>
        <priority>0.7</priority>
    </url>
    @endforeach

@foreach($transportadoras as $slug)
    <url>
        <loc>{{ url('/transportadora/' . $slug) }}</loc>
        <priority>0.8</priority>
    </url>
@endforeach

    <url>
        <loc>{{ url('/sobre') }}</loc>
        <priority>0.7</priority>
    </url>

    <url>
        <loc>{{ url('/como-funciona') }}</loc>
        <priority>0.6</priority>
    </url>

</urlset>
