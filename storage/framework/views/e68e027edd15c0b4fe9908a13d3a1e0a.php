<aside class="admin-sidebar">
    <div class="sidebar-logo">
        <span class="icon">📦</span>
        <span>Admin</span>
    </div>

    <nav>
        <ul class="sidebar-nav">
            <li>
                <a href="<?php echo e(route('admin.visao_geral')); ?>" class="<?php echo e(request()->routeIs('admin.visao_geral') ? 'active' : ''); ?>">
                    📊 Dashboard
                </a>
            </li>
            <li>
                <a href="<?php echo e(route('admin.codigos')); ?>" class="<?php echo e(request()->routeIs('admin.codigos') ? 'active' : ''); ?>">
                    🔧 Códigos / Tracking
                </a>
            </li>
            <li>
                <a href="<?php echo e(route('admin.blog.index')); ?>" class="<?php echo e(request()->routeIs('admin.blog.*') ? 'active' : ''); ?>">
                    📝 Blog
                </a>
            </li>
            <li>
                <a href="<?php echo e(route('admin.media.index')); ?>" class="<?php echo e(request()->routeIs('admin.media.*') ? 'active' : ''); ?>">
                    🖼️ Mídia
                </a>
            </li>
            <li style="margin-top: 2rem; border-top: 1px solid var(--admin-border); padding-top: 1rem;">
                <a href="<?php echo e(route('home')); ?>" target="_blank">
                    🌐 Ver site
                </a>
            </li>
            <li>
                <form action="<?php echo e(route('admin.logout')); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <button type="submit" style="background: none; border: none; color: inherit; cursor: pointer; display: flex; align-items: center; gap: 0.75rem; padding: 0.75rem 1rem; font-size: 0.875rem; width: 100%; text-align: left; color: var(--admin-text-muted);">
                        🚪 Sair
                    </button>
                </form>
            </li>
        </ul>
    </nav>
</aside><?php /**PATH D:\Vibe Coding\Situação da Entrega\resources\views/admin/partials/sidebar.blade.php ENDPATH**/ ?>