

<?php $__env->startSection('title', 'Códigos de Tracking | Admin'); ?>

<?php $__env->startSection('content'); ?>

<div class="admin-layout">
    <?php echo $__env->make('admin.partials.sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <main class="admin-main">
        <div class="admin-header">
            <h1>Códigos de Tracking</h1>
            <div class="user-menu">
                <span style="color: var(--admin-text-muted); font-size: 0.875rem;">
                    <?php echo e(session('admin_email')); ?>

                </span>
            </div>
        </div>

        <?php if(session('sucesso')): ?>
        <div class="alert alert-success" style="margin-bottom: 1.5rem;">
            ✓ <?php echo e(session('sucesso')); ?>

        </div>
        <?php endif; ?>

        <form method="POST" action="<?php echo e(route('admin.codigos.salvar')); ?>" class="admin-form">
            <?php echo csrf_field(); ?>

            <?php $__currentLoopData = $configs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $chave => $config): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="card">
                <div class="card-header">
                    <h2><?php echo e($config['titulo']); ?></h2>
                    <div class="toggle-wrapper">
                        <label class="toggle">
                            <input type="checkbox" name="ativo_<?php echo e($chave); ?>" value="1"
                                <?php echo e($valores[$chave]['ativo'] ? 'checked' : ''); ?>>
                            <span class="toggle-slider"></span>
                        </label>
                        <span class="toggle-label"><?php echo e($valores[$chave]['ativo'] ? 'Ativo' : 'Inativo'); ?></span>
                    </div>
                </div>
                <div class="card-body">
                    <p class="form-hint" style="margin-bottom: 0.75rem;"><?php echo e($config['descricao']); ?></p>
                    <textarea name="valor_<?php echo e($chave); ?>" rows="4"
                        placeholder="<?php echo e($config['placeholder']); ?>"><?php echo e($valores[$chave]['valor']); ?></textarea>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            <div class="alert" style="background: rgba(245, 158, 11, 0.1); border: 1px solid rgba(245, 158, 11, 0.3); color: #fcd34d; margin-bottom: 1.5rem;">
                ⚠️ <strong>Atenção:</strong> Scripts incorretos podem quebrar o site. Teste antes de ativar.
            </div>

            <button type="submit" class="btn-save">💾 Salvar configurações</button>
        </form>
    </main>
</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Vibe Coding\Situação da Entrega\resources\views/admin/codigos.blade.php ENDPATH**/ ?>