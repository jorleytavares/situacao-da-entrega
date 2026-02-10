

<?php $__env->startSection('title', 'Dashboard | Admin'); ?>

<?php $__env->startSection('content'); ?>

<div class="admin-layout">
    <?php echo $__env->make('admin.partials.sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <main class="admin-main">
        <div class="admin-header">
            <h1>Dashboard</h1>
            <div class="user-menu">
                <a href="<?php echo e(route('admin.exportar_csv')); ?>" class="btn-export">
                    📥 Exportar CSV
                </a>
            </div>
        </div>

        <?php if(session('sucesso')): ?>
        <div class="alert alert-success" style="margin-bottom: 1.5rem;">
            ✓ <?php echo e(session('sucesso')); ?>

        </div>
        <?php endif; ?>

        <!-- Stats -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="label">Total de Relatos</div>
                <div class="value"><?php echo e(number_format($totalRelatos, 0, ',', '.')); ?></div>
            </div>

            <div class="stat-card">
                <div class="label">Últimos 7 dias</div>
                <div class="value"><?php echo e(number_format($relatos7dias, 0, ',', '.')); ?></div>
                <?php if($crescimentoSemanal > 0): ?>
                <div class="trend up">↑ <?php echo e($crescimentoSemanal); ?>%</div>
                <?php elseif($crescimentoSemanal < 0): ?>
                    <div class="trend down">↓ <?php echo e(abs($crescimentoSemanal)); ?>%
            </div>
            <?php endif; ?>
        </div>

        <div class="stat-card">
            <div class="label">Últimos 30 dias</div>
            <div class="value"><?php echo e(number_format($relatos30dias, 0, ',', '.')); ?></div>
        </div>

        <div class="stat-card">
            <div class="label">Média diária (7d)</div>
            <div class="value"><?php echo e(number_format($relatos7dias / max(1, 7), 1, ',', '.')); ?></div>
        </div>
</div>

<!-- Gráfico de Tendência -->
        <div class="card">
            <div class="card-header">
                <h2>📈 Tendência (30 dias)</h2>
            </div>
            <div class="card-body">
                <canvas id="graficoTendencia" height="100"></canvas>
            </div>
        </div>

        <div class="grid-2">
            <!-- Top Problemas -->
            <div class="card">
                <div class="card-header">
                    <h2>🔥 Top 5 Problemas</h2>
                    <span class="badge badge-info">Mais relatados</span>
                </div>
                <div class="card-body" style="padding: 0;">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Problema</th>
                                <th style="text-align: right;">Qty</th>
                                <th style="text-align: right;">%</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $top5Problemas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($item->problema->titulo ?? 'N/A'); ?></td>
                                <td style="text-align: right;"><?php echo e(number_format($item->total, 0, ',', '.')); ?></td>
                                <td style="text-align: right;">
                                    <?php echo e($totalRelatos > 0 ? number_format(($item->total / $totalRelatos) * 100, 1, ',', '.') : 0); ?>%
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Top Estados -->
            <div class="card">
                <div class="card-header">
                    <h2>📍 Top 5 Estados</h2>
                    <span class="badge badge-warning">Mais afetados</span>
                </div>
                <div class="card-body" style="padding: 0;">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Estado</th>
                                <th style="text-align: right;">Qty</th>
                                <th style="text-align: right;">%</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $top5Estados; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($item->uf); ?></td>
                                <td style="text-align: right;"><?php echo e(number_format($item->total, 0, ',', '.')); ?></td>
                                <td style="text-align: right;">
                                    <?php echo e($totalRelatos > 0 ? number_format(($item->total / $totalRelatos) * 100, 1, ',', '.') : 0); ?>%
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="grid-2">
            <!-- Termos Mais Buscados -->
            <div class="card">
                <div class="card-header">
                    <h2>🔍 O que estão buscando</h2>
                    <span class="badge badge-success">Encontrados</span>
                </div>
                <div class="card-body" style="padding: 0;">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Termo</th>
                                <th style="text-align: right;">Buscas</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $termosBuscados; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td><?php echo e($item->term); ?></td>
                                <td style="text-align: right;"><?php echo e($item->total); ?></td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="2" style="text-align: center; color: #666;">Sem dados ainda</td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Oportunidades de Conteúdo -->
            <div class="card">
                <div class="card-header">
                    <h2>💡 Oportunidades (Não encontrado)</h2>
                    <span class="badge badge-warning">Criar Post</span>
                </div>
                <div class="card-body" style="padding: 0;">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Termo</th>
                                <th style="text-align: right;">Buscas</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $oportunidadesConteudo; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td style="color: #ef4444; font-weight: 500;"><?php echo e($item->term); ?></td>
                                <td style="text-align: right;"><?php echo e($item->total); ?></td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="2" style="text-align: center; color: #666;">Nenhuma oportunidade detectada</td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Manutenção do Sistema -->
        <div class="card" style="border-top: 4px solid #6366f1;">
            <div class="card-header">
                <h2>🛠 Manutenção do Sistema</h2>
            </div>
            <div class="card-body">
                <div style="display: flex; gap: 1rem; flex-wrap: wrap; align-items: center;">
                    
                    <!-- Limpar Cache -->
                    <form action="<?php echo e(route('admin.manutencao.limpar_cache')); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <button type="submit" class="btn-export" style="background-color: #64748b; color: white; border: none; cursor: pointer; padding: 0.5rem 1rem; border-radius: 6px;">
                            🧹 Limpar Cache
                        </button>
                    </form>

                    <!-- Limpar Dados -->
                    <form action="<?php echo e(route('admin.manutencao.limpar_dados')); ?>" method="POST" onsubmit="return confirm('ATENÇÃO: Isso apagará TODOS os relatórios do banco de dados.\n\nEsta ação é irreversível e deve ser usada para limpar dados de teste/seeds.\n\nTem certeza que deseja continuar?');">
                        <?php echo csrf_field(); ?>
                        <button type="submit" class="btn-export" style="background-color: #ef4444; color: white; border: none; cursor: pointer; padding: 0.5rem 1rem; border-radius: 6px;">
                            ⚠️ Resetar Relatórios
                        </button>
                    </form>

                    <span style="color: #666; font-size: 0.85rem; border-left: 1px solid #ddd; padding-left: 1rem; margin-left: auto;">
                        Use com cautela. Ações de manutenção afetam todo o sistema.
                    </span>
                </div>
            </div>
        </div>
</main>
</div>

<script src="<?php echo e(asset('js/chart.js')); ?>"></script>
<script>
    const ctx = document.getElementById('graficoTendencia').getContext('2d');
    const graficoData = <?php echo json_encode($graficoData, 15, 512) ?>;

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: graficoData.map(d => d.data),
            datasets: [{
                label: 'Relatos',
                data: graficoData.map(d => d.total),
                borderColor: '#22c55e',
                backgroundColor: 'rgba(34, 197, 94, 0.1)',
                fill: true,
                tension: 0.4,
                pointRadius: 2,
                pointHoverRadius: 5
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                x: {
                    grid: {
                        display: false
                    },
                    ticks: {
                        maxTicksLimit: 10
                    }
                },
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            }
        }
    });
</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Vibe Coding\Situação da Entrega\resources\views/admin/visao-geral.blade.php ENDPATH**/ ?>