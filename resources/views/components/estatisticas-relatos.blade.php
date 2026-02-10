@props([
'totalRelatos' => 0,
'ultimos30Dias' => 0,
'totalProblema' => null,
'percentual' => null,
'top3Estados' => null,
'problemasGrafico' => null,
'graficoId' => 'graficoRelatos',
'titulo' => 'Panorama dos relatos',
'mostrarGrafico' => false
])

<section class="bloco" style="border-left: 4px solid #2563eb; background: #f8fafc;">
    <h3 class="bloco-titulo" style="font-size: 1.25rem;">📊 {{ $titulo }}</h3>
    <p class="bloco-texto" style="color: #64748b; font-size: 0.875rem;">
        Dados agregados de relatos anônimos enviados por usuários.
    </p>

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(120px, 1fr)); gap: 1rem; margin: 1.5rem 0;">
        <div style="text-align: center; padding: 1rem; background: #fff; border-radius: 8px; border: 1px solid #e2e8f0;">
            <span style="font-size: 1.75rem; font-weight: 700; color: #2563eb;">{{ number_format($totalRelatos, 0, ',', '.') }}</span>
            <p style="font-size: 0.75rem; color: #64748b; margin: 0.25rem 0 0;">Relatos totais</p>
        </div>

        <div style="text-align: center; padding: 1rem; background: #fff; border-radius: 8px; border: 1px solid #e2e8f0;">
            <span style="font-size: 1.75rem; font-weight: 700; color: #2563eb;">{{ $ultimos30Dias }}</span>
            <p style="font-size: 0.75rem; color: #64748b; margin: 0.25rem 0 0;">Últimos 30 dias</p>
        </div>

        @if(!is_null($totalProblema))
        <div style="text-align: center; padding: 1rem; background: #fff; border-radius: 8px; border: 1px solid #e2e8f0;">
            <span style="font-size: 1.75rem; font-weight: 700; color: #2563eb;">{{ $totalProblema }}</span>
            <p style="font-size: 0.75rem; color: #64748b; margin: 0.25rem 0 0;">Mesmo problema</p>
        </div>
        @endif

        @if(!is_null($percentual))
        <div style="text-align: center; padding: 1rem; background: #fff; border-radius: 8px; border: 1px solid #e2e8f0;">
            <span style="font-size: 1.75rem; font-weight: 700; color: #2563eb;">{{ $percentual }}%</span>
            <p style="font-size: 0.75rem; color: #64748b; margin: 0.25rem 0 0;">Do total</p>
        </div>
        @endif
    </div>

    @if($top3Estados && count($top3Estados) > 0)
    <div style="margin: 1rem 0;">
        <p style="font-size: 0.875rem; color: #64748b; margin-bottom: 0.5rem;">
            <strong>Top estados:</strong>
        </p>
        <div style="display: flex; gap: 0.5rem; flex-wrap: wrap;">
            @foreach($top3Estados as $estado)
            <span style="background: #e2e8f0; padding: 0.375rem 0.75rem; border-radius: 4px; font-size: 0.875rem;">
                <strong>{{ $estado->uf }}</strong> ({{ $estado->total }})
            </span>
            @endforeach
        </div>
    </div>
    @endif

    @if($mostrarGrafico && $problemasGrafico && count($problemasGrafico) > 0)
    <div style="margin-top: 1.5rem;">
        <canvas id="{{ $graficoId }}" width="100%" height="120" style="max-width: 100%;"></canvas>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            renderGraficoBarras('{{ $graficoId }}', @json($problemasGrafico));
        });
    </script>
    @endif

    <p style="font-size: 0.75rem; color: #94a3b8; margin-top: 1rem;">
        Esses dados representam relatos anônimos. Seu relato contribui para essas estatísticas.
    </p>
</section>