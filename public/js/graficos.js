/**
 * Situação da Entrega - Gráficos JS Puro
 * Sem dependências externas
 */

function renderGraficoBarras(canvasId, dados) {
    const canvas = document.getElementById(canvasId);
    if (!canvas || !dados || dados.length === 0) return;

    const ctx = canvas.getContext('2d');
    const largura = canvas.offsetWidth || 400;
    const altura = canvas.height || 120;

    // Ajusta canvas para resolução
    canvas.width = largura;
    canvas.height = altura;

    const max = Math.max(...dados.map(d => d.total));
    const barWidth = Math.min(60, (largura - 40) / dados.length - 10);
    const padding = 20;

    // Fundo
    ctx.fillStyle = '#f8fafc';
    ctx.fillRect(0, 0, largura, altura);

    dados.forEach((item, i) => {
        const barHeight = (item.total / max) * (altura - 50);
        const x = i * (barWidth + 10) + padding;
        const y = altura - barHeight - 25;

        // Barra
        ctx.fillStyle = '#2563eb';
        ctx.beginPath();
        ctx.roundRect(x, y, barWidth, barHeight, 4);
        ctx.fill();

        // Valor no topo
        ctx.fillStyle = '#1e293b';
        ctx.font = 'bold 11px -apple-system, BlinkMacSystemFont, sans-serif';
        ctx.textAlign = 'center';
        ctx.fillText(item.total, x + barWidth / 2, y - 5);

        // Label embaixo
        ctx.fillStyle = '#64748b';
        ctx.font = '9px -apple-system, BlinkMacSystemFont, sans-serif';
        const label = item.problema ? item.problema.titulo.substring(0, 8) : 'P' + item.problema_id;
        ctx.fillText(label, x + barWidth / 2, altura - 8);
    });
}

// Polyfill para roundRect em browsers antigos
if (!CanvasRenderingContext2D.prototype.roundRect) {
    CanvasRenderingContext2D.prototype.roundRect = function (x, y, w, h, r) {
        if (w < 2 * r) r = w / 2;
        if (h < 2 * r) r = h / 2;
        this.moveTo(x + r, y);
        this.arcTo(x + w, y, x + w, y + h, r);
        this.arcTo(x + w, y + h, x, y + h, r);
        this.arcTo(x, y + h, x, y, r);
        this.arcTo(x, y, x + w, y, r);
        this.closePath();
        return this;
    };
}
