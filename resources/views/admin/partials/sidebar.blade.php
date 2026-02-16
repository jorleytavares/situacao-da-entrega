<aside class="admin-sidebar">
    <div class="sidebar-logo">
        <span class="icon">📦</span>
        <span>Admin</span>
    </div>

    <nav>
        <ul class="sidebar-nav">
            <li>
                <a href="{{ route('admin.visao_geral') }}" class="{{ request()->routeIs('admin.visao_geral') ? 'active' : '' }}">
                    📊 Dashboard
                </a>
            </li>
            <li>
                <a href="{{ route('admin.codigos') }}" class="{{ request()->routeIs('admin.codigos') ? 'active' : '' }}">
                    🔧 Códigos / Tracking
                </a>
            </li>
            <li>
                <a href="{{ route('admin.blog.index') }}" class="{{ request()->routeIs('admin.blog.*') ? 'active' : '' }}">
                    📝 Blog
                </a>
            </li>
            <li>
                <a href="{{ route('admin.comentarios.index') }}" class="{{ request()->routeIs('admin.comentarios.*') ? 'active' : '' }}">
                    💬 Comentários
                </a>
            </li>
            <li>
                <a href="{{ route('admin.media.index') }}" class="{{ request()->routeIs('admin.media.*') ? 'active' : '' }}">
                    🖼️ Mídia
                </a>
            </li>
            <li style="margin-top: 2rem; border-top: 1px solid var(--admin-border); padding-top: 1rem;">
                <a href="{{ route('home') }}" target="_blank">
                    🌐 Ver site
                </a>
            </li>
            <li>
                <form action="{{ route('admin.logout') }}" method="POST">
                    @csrf
                    <button type="submit" style="background: none; border: none; color: inherit; cursor: pointer; display: flex; align-items: center; gap: 0.75rem; padding: 0.75rem 1rem; font-size: 0.875rem; width: 100%; text-align: left; color: var(--admin-text-muted);">
                        🚪 Sair
                    </button>
                </form>
            </li>
        </ul>
    </nav>
</aside>