{{-- Navbar unificado — detecta rol por sesión y usa NavbarService --}}
@php
    use App\Services\NavbarService;
    $nav = NavbarService::config();
    $hasPending = ($nav['notifCount'] ?? 0) > 0;
@endphp

<style>
  :root {
    --nav-bg: linear-gradient(90deg, #0d1f3c 0%, #162d52 100%);
    --nav-border: rgba(43, 127, 255, 0.2);
    --nav-accent: #2b7fff;
    --nav-text: #e8edf5;
    --nav-muted: #7a92b4;
    --nav-height: 60px;
  }
  .admin-navbar {
    position: fixed; top: 0; left: 0; right: 0;
    height: var(--nav-height);
    background: var(--nav-bg);
    border-bottom: 1px solid var(--nav-border);
    z-index: 300;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.4);
    display: flex; align-items: center;
    padding: 0 1.5rem; justify-content: space-between;
  }
  .nav-left { display: flex; align-items: center; gap: 0.5rem; }
  .nav-hamburger {
    background: transparent; border: 1px solid transparent; color: var(--nav-text);
    font-size: 1.2rem; padding: 8px; border-radius: 8px; cursor: pointer;
    transition: all 0.2s ease; display: flex; align-items: center; justify-content: center;
  }
  .nav-hamburger:hover { background: rgba(43, 127, 255, 0.15); border-color: var(--nav-accent); color: #fff; }
  .nav-quick-links { display: flex; align-items: center; gap: 4px; }
  .nav-link {
    display: inline-flex; align-items: center; justify-content: center;
    width: 40px; height: 40px; border-radius: 8px; color: var(--nav-muted);
    text-decoration: none; transition: all 0.2s ease; white-space: nowrap;
  }
  .nav-link i { font-size: 1.1rem; }
  .nav-link:hover { color: #fff; background: rgba(43, 127, 255, 0.1); }
  .nav-link.active {
    color: #fff; background: rgba(43, 127, 255, 0.2);
    border: 1px solid rgba(43, 127, 255, 0.4);
    box-shadow: 0 0 0 1px rgba(43, 127, 255, 0.2);
  }
  .nav-center { flex: 1; max-width: 500px; margin: 0 2rem; display: flex; justify-content: center; }
  .search-container { position: relative; width: 100%; }
  .search-icon { position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: var(--nav-muted); font-size: 0.9rem; pointer-events: none; }
  .search-input {
    width: 100%; background: rgba(0, 0, 0, 0.2); border: 1px solid var(--nav-border);
    border-radius: 10px; padding: 10px 12px 10px 36px; color: var(--nav-text);
    font-family: 'DM Sans', sans-serif; font-size: 0.85rem; outline: none; transition: all 0.2s ease;
  }
  .search-input:focus { background: rgba(0, 0, 0, 0.3); border-color: var(--nav-accent); box-shadow: 0 0 0 3px rgba(43, 127, 255, 0.15); }
  .search-input::placeholder { color: var(--nav-muted); }
  .search-shortcut {
    position: absolute; right: 12px; top: 50%; transform: translateY(-50%);
    background: rgba(255, 255, 255, 0.1); color: var(--nav-muted); font-size: 0.7rem;
    padding: 3px 6px; border-radius: 4px; border: 1px solid rgba(255, 255, 255, 0.1); pointer-events: none;
  }
  .nav-right { display: flex; align-items: center; gap: 12px; position: relative; }
  .notif-wrapper { position: relative; }
  .notif-btn {
    position: relative; background: transparent; border: none; color: var(--nav-text);
    font-size: 1.2rem; padding: 10px; border-radius: 50%; cursor: pointer; transition: all 0.2s ease;
  }
  .notif-btn:hover { background: rgba(43, 127, 255, 0.15); color: #fff; }
  .notif-btn.has-pending { animation: bellRing 2s ease-in-out infinite; color: #ffd700; }
  @keyframes bellRing {
    0%, 100% { transform: rotate(0deg); }
    10%, 30%, 50%, 70%, 90% { transform: rotate(-10deg); }
    20%, 40%, 60%, 80% { transform: rotate(10deg); }
  }
  .notif-badge {
    position: absolute; top: 4px; right: 4px; background: #ef4444; color: #fff;
    font-size: 0.65rem; font-weight: 700; padding: 2px 5px; border-radius: 10px;
    border: 2px solid #0d1f3c; min-width: 16px; text-align: center; line-height: 1;
    box-shadow: 0 2px 6px rgba(239, 68, 68, 0.5);
  }
  .notif-dropdown {
    position: absolute; top: calc(100% + 12px); right: 0; width: 340px;
    background: #162d52; border: 1px solid var(--nav-border); border-radius: 12px;
    box-shadow: 0 12px 40px rgba(0, 0, 0, 0.6); display: none; flex-direction: column;
    overflow: hidden; z-index: 400; transform-origin: top right;
    animation: slideIn 0.2s ease-out forwards;
  }
  .notif-dropdown.show { display: flex; }
  @keyframes slideIn { from { opacity: 0; transform: scale(0.95); } to { opacity: 1; transform: scale(1); } }
  .notif-header {
    padding: 14px 16px; background: rgba(0, 0, 0, 0.2); border-bottom: 1px solid var(--nav-border);
    display: flex; justify-content: space-between; align-items: center;
  }
  .notif-title { color: #fff; font-family: 'Syne', sans-serif; font-weight: 700; font-size: 0.9rem; margin: 0; }
  .notif-see-all { color: var(--nav-accent); text-decoration: none; font-size: 0.75rem; font-weight: 600; }
  .notif-see-all:hover { text-decoration: underline; }
  .notif-list { max-height: 320px; overflow-y: auto; padding: 0; margin: 0; scrollbar-width: thin; scrollbar-color: var(--nav-accent) transparent; }
  .notif-item {
    display: flex; align-items: flex-start; gap: 12px; padding: 14px 16px;
    border-bottom: 1px solid rgba(43, 127, 255, 0.1); transition: background 0.2s;
    text-decoration: none; cursor: pointer;
  }
  .notif-item:hover { background: rgba(43, 127, 255, 0.1); }
  .notif-item:last-child { border-bottom: none; }
  .notif-icon-circle {
    width: 36px; height: 36px; border-radius: 50%; display: flex;
    align-items: center; justify-content: center; font-size: 1rem; flex-shrink: 0;
  }
  .notif-icon-circle.warning { background: rgba(239, 68, 68, 0.2); color: #f87171; }
  .notif-icon-circle.info { background: rgba(43, 127, 255, 0.2); color: #60a5fa; }
  .notif-icon-circle.success { background: rgba(34, 197, 94, 0.2); color: #4ade80; }
  .notif-content { flex: 1; min-width: 0; }
  .notif-text {
    color: #e8edf5; font-size: 0.85rem; font-weight: 500; margin: 0 0 4px;
    overflow: hidden; text-overflow: ellipsis; white-space: nowrap;
  }
  .notif-meta { color: var(--nav-muted); font-size: 0.75rem; margin: 0; display: flex; gap: 6px; flex-wrap: wrap; }
  .notif-dot { color: var(--nav-accent); }
  .notif-empty { padding: 30px 20px; text-align: center; color: var(--nav-muted); }

  /* ── Layout global: compensar navbar fijo (60px + margen) ── */
  .main-content,
  .dashboard-content,
  .tk-main,
  .mt-main {
    box-sizing: border-box;
    padding-top: 80px !important;
  }
  #nt-rack,
  .sb-toast {
    top: 72px !important;
  }
  @media (max-width: 1024px) {
    .main-content,
    .dashboard-content,
    .tk-main,
    .mt-main {
      margin-left: 0 !important;
    }
    body.sb-collapsed .main-content,
    body.sb-collapsed .dashboard-content,
    body.sb-collapsed .tk-main,
    body.sb-collapsed .mt-main {
      margin-left: 0 !important;
    }
  }

  @media (max-width: 1024px) {
    .nav-center { margin: 0 1rem; max-width: 300px; }
  }
  @media (max-width: 768px) {
    .nav-center { display: none; }
    .nav-link { display: none; }
    .nav-left { gap: 0.25rem; }
    .nav-hamburger { font-size: 1.4rem; }
    .search-shortcut { display: none; }
    .notif-dropdown { right: 0; left: auto; width: min(280px, calc(100vw - 24px)); max-width: calc(100vw - 24px); }
    .notif-header { flex-wrap: wrap; gap: 8px; }
    .notif-see-all { font-size: 0.7rem; }
  }
  @media (max-width: 480px) {
    .admin-navbar { padding: 0 12px; }
    .nav-right { gap: 8px; }
  }
</style>

<nav class="admin-navbar">
  <div class="nav-left">
    <button class="nav-hamburger" id="navHamburgerBtn" title="Mostrar/Ocultar Menú" type="button">
      <i class="fa-solid fa-bars"></i>
    </button>
    <div class="nav-quick-links">
      @foreach($nav['quickLinks'] as $link)
        <a href="{{ route($link['route']) }}"
           class="nav-link {{ Route::is($link['route']) ? 'active' : '' }}"
           title="{{ $link['title'] }}">
          <i class="fa-solid {{ $link['icon'] }}"></i>
        </a>
      @endforeach
    </div>
  </div>

  <div class="nav-center">
    <div class="search-container">
      <i class="fa-solid fa-magnifying-glass search-icon"></i>
      <input type="text" class="search-input" placeholder="Buscar..." id="navSearchInput">
      <span class="search-shortcut">Ctrl + K</span>
    </div>
  </div>

  <div class="nav-right">
    <div class="notif-wrapper" id="notifWrapper">
      <button class="notif-btn {{ $hasPending ? 'has-pending' : '' }}" id="notifBtn" type="button">
        <i class="fa-solid fa-bell"></i>
        @if($hasPending)
          <span class="notif-badge">{{ $nav['notifCount'] }}</span>
        @endif
      </button>

      <div class="notif-dropdown" id="notifDropdown">
        <div class="notif-header">
          <h4 class="notif-title">{{ $nav['notifTitle'] }}</h4>
          @if($nav['notifSeeAll'])
            <a href="{{ $nav['notifSeeAll'] }}" class="notif-see-all">{{ $nav['notifSeeAllText'] }}</a>
          @endif
        </div>
        <div class="notif-list">
          @forelse($nav['notifications'] as $notif)
            <div class="notif-item"
                 data-ticket-id="{{ $notif['ticket_id'] ?? '' }}"
                 data-notif-id="{{ is_numeric($notif['id'] ?? null) ? $notif['id'] : '' }}"
                 data-notif-role="{{ $nav['notifClickRoute'] ?? '' }}">
              <div class="notif-icon-circle {{ $notif['icon_class'] ?? 'warning' }}">
                <i class="fa-solid {{ $notif['icon'] ?? 'fa-bell' }}"></i>
              </div>
              <div class="notif-content">
                <p class="notif-text">{{ Str::limit($notif['text'], 50) }}</p>
                <p class="notif-meta">
                  @foreach($notif['meta'] ?? [] as $i => $meta)
                    @if($i > 0)<span class="notif-dot">•</span>@endif
                    <span>{{ $meta }}</span>
                  @endforeach
                </p>
              </div>
            </div>
          @empty
            <div class="notif-empty">
              <i class="fa-solid fa-circle-check" style="font-size: 2rem; margin-bottom: 8px;"></i>
              <p>¡Todo al día! No hay notificaciones nuevas.</p>
            </div>
          @endforelse
        </div>
      </div>
    </div>
  </div>
</nav>

<script>
document.addEventListener('DOMContentLoaded', function() {
  const navHamburger = document.getElementById('navHamburgerBtn');
  const sidebar = document.getElementById('jhs-sidebar');
  const overlay = document.getElementById('sb-overlay');

  if (navHamburger && sidebar) {
    navHamburger.addEventListener('click', function(e) {
      e.stopPropagation();
      const isMobile = window.innerWidth <= 1024;
      const isSidebarOpen = sidebar.classList.contains('sb-open');

      if (isMobile) {
        if (isSidebarOpen) {
          sidebar.classList.remove('sb-open');
          if (overlay) overlay.classList.remove('visible');
          document.body.style.overflow = '';
          navHamburger.innerHTML = '<i class="fa-solid fa-bars"></i>';
        } else {
          sidebar.classList.add('sb-open');
          if (overlay) overlay.classList.add('visible');
          document.body.style.overflow = 'hidden';
          navHamburger.innerHTML = '<i class="fa-solid fa-xmark"></i>';
        }
      } else {
        sidebar.classList.toggle('collapsed');
        document.body.classList.toggle('sb-collapsed');
      }
    });

    if (overlay) {
      overlay.addEventListener('click', function() {
        sidebar.classList.remove('sb-open');
        overlay.classList.remove('visible');
        document.body.style.overflow = '';
        navHamburger.innerHTML = '<i class="fa-solid fa-bars"></i>';
      });
    }
  }

  const notifBtn = document.getElementById('notifBtn');
  const notifDropdown = document.getElementById('notifDropdown');

  if (notifBtn && notifDropdown) {
    notifBtn.addEventListener('click', function(e) {
      e.stopPropagation();
      const isOpen = notifDropdown.classList.toggle('show');
      notifBtn.style.transform = isOpen ? 'scale(1.2)' : 'scale(1)';
      if (isOpen) notifBtn.classList.remove('has-pending');
    });

    document.addEventListener('click', function(e) {
      if (!notifBtn.contains(e.target) && !notifDropdown.contains(e.target)) {
        notifDropdown.classList.remove('show');
        notifBtn.style.transform = 'scale(1)';
      }
    });
  }

  const searchInput = document.getElementById('navSearchInput');
  const modulos = @json($nav['searchModules'] ?? []);

  if (searchInput && modulos.length) {
    searchInput.addEventListener('input', function(e) {
      const existing = document.querySelector('.module-search-dropdown');
      if (existing) existing.remove();

      const query = e.target.value.toLowerCase().trim();
      if (query.length < 2) return;

      const resultados = modulos.filter(m =>
        m.nombre.toLowerCase().includes(query) || m.desc.toLowerCase().includes(query)
      );
      if (resultados.length === 0) return;

      const dropdown = document.createElement('div');
      dropdown.className = 'module-search-dropdown';
      dropdown.style.cssText = `
        position:absolute;top:calc(100% + 8px);left:0;right:0;
        background:#122444;border:1px solid rgba(43,127,255,0.3);
        border-radius:10px;box-shadow:0 8px 30px rgba(0,0,0,0.5);
        z-index:1000;overflow:hidden;
      `;

      resultados.forEach((mod, index) => {
        const item = document.createElement('a');
        item.href = mod.ruta;
        item.style.cssText = `
          display:flex;align-items:center;gap:12px;padding:12px 16px;
          text-decoration:none;color:#e8edf5;transition:background 0.2s;
          border-bottom:${index < resultados.length - 1 ? '1px solid rgba(255,255,255,0.05)' : 'none'};
        `;
        item.onmouseenter = () => item.style.background = 'rgba(43,127,255,0.2)';
        item.onmouseleave = () => item.style.background = 'transparent';
        item.innerHTML = `
          <div style="width:32px;height:32px;border-radius:8px;background:rgba(43,127,255,0.2);display:flex;align-items:center;justify-content:center;color:#60a5fa;">
            <i class="fa-solid ${mod.icono}"></i>
          </div>
          <div style="flex:1;min-width:0;">
            <div style="font-weight:600;font-size:0.9rem;">${mod.nombre}</div>
            <div style="font-size:0.75rem;color:#7a92b4;">${mod.desc}</div>
          </div>
          <i class="fa-solid fa-arrow-right" style="color:#5a6a8a;font-size:0.8rem;"></i>
        `;
        dropdown.appendChild(item);
      });

      searchInput.closest('.search-container').style.position = 'relative';
      searchInput.closest('.search-container').appendChild(dropdown);
    });

    document.addEventListener('click', function(e) {
      if (!searchInput.contains(e.target)) {
        const existing = document.querySelector('.module-search-dropdown');
        if (existing) existing.remove();
      }
    });
  }

  document.addEventListener('keydown', function(e) {
    if ((e.ctrlKey || e.metaKey) && e.key.toLowerCase() === 'k') {
      e.preventDefault();
      if (searchInput) { searchInput.focus(); searchInput.select(); }
    }
  });

  // ── Quitar notificación del dropdown al cerrar un modal ──────────
  window.navbarQuitarNotificacion = function(notifId) {
    if (!notifId) return;

    // Quitar el item del dropdown
    const item = document.querySelector(`.notif-item[data-notif-id="${notifId}"]`);
    if (item) item.remove();

    // Actualizar badge
    const badge   = document.querySelector('.notif-badge');
    const btnBell = document.getElementById('notifBtn');
    const lista   = document.querySelectorAll('.notif-item[data-ticket-id]');

    if (badge) {
      const actual = Math.max(0, (parseInt(badge.textContent) || 1) - 1);
      if (actual <= 0) {
        badge.remove();
        if (btnBell) btnBell.classList.remove('has-pending');

        // Mostrar estado vacío si no quedan notificaciones
        const list = document.querySelector('.notif-list');
        if (list && lista.length === 0) {
          list.innerHTML = `
            <div class="notif-empty">
              <i class="fa-solid fa-circle-check" style="font-size:2rem;margin-bottom:8px;"></i>
              <p>¡Todo al día! No hay notificaciones nuevas.</p>
            </div>`;
        }
      } else {
        badge.textContent = actual;
      }
    }
  };

  document.querySelectorAll('.notif-item[data-ticket-id]').forEach(item => {
    item.addEventListener('click', async function(e) {
      e.preventDefault();
      e.stopPropagation();

      const ticketId = this.getAttribute('data-ticket-id');
      const notifId = this.getAttribute('data-notif-id');
      const role = this.getAttribute('data-notif-role');

      if (notifDropdown) notifDropdown.classList.remove('show');

      if (notifId) {
        try {
          await fetch(`/notificaciones/${notifId}/leer`, {
            method: 'POST',
            headers: {
              'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}',
              'Accept': 'application/json',
            },
          });
        } catch (_) {}
      }

      if (typeof abrirDetalleTicket === 'function' && ticketId) {
        abrirDetalleTicket(ticketId, notifId);
        return;
      }

      const routes = {
        admin: `/admin/ticket/${ticketId}/detalle`,
        tecnico: `/tecnico/ticket/${ticketId}/detalle`,
        cliente: '{{ route("cliente.tickets") }}',
        usuario: '{{ route("usuario.dashboard") }}',
      };

      if (ticketId && routes[role]) {
        window.location.href = role === 'admin' || role === 'tecnico'
          ? routes[role]
          : routes[role];
      }
    });
  });
});
</script>
