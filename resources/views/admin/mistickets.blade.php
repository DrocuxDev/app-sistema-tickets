@include('components.admin.navbar-admin')
@include('components.admin.sidebar-admin')
@include('components.notificaciones.alertas')
@include('components.admin.editardetalleticket')
@include('components.admin.detalleticket')

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<div class="main-content">
<div class="container-fluid">

    {{-- ══════════════════════════════════════════
         HEADER
    ══════════════════════════════════════════ --}}
    <div class="page-header">
        <div class="page-header-left">
            <div class="page-header-icon">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M15 5v2M15 11v2M15 17v2M5 5h14a2 2 0 0 1 2 2v3a2 2 0 0 1 0 4v3a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-3a2 2 0 0 1 0-4V7a2 2 0 0 1 2-2z"/>
                </svg>
            </div>
            <div>
                <h1 class="page-title">Mis Tickets</h1>
                <p class="page-subtitle">Tickets asignados a ti — {{ session('nombre') }}</p>
            </div>
        </div>
    </div>

    {{-- ══════════════════════════════════════════
         STATS GLOBALES (INTERACTUABLES)
    ══════════════════════════════════════════ --}}
    @php
        $mt_total = $resumen['total'] ?? 0;
        $mt_programado = $resumen['programado'] ?? 0;
        $mt_proceso = $resumen['en_proceso'] ?? 0;
        $mt_cerrado = $resumen['cerrado'] ?? 0;
        $mt_cancelado = $resumen['cancelado'] ?? 0;
    @endphp

    <div class="stats-container" id="stats-global">
        <div class="stat-card" onclick="mtFiltrarDesdeStat('todos')" style="cursor: pointer;" title="Ver todos los tickets">
            <div class="stat-icon si-t">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M15 5v2M15 11v2M15 17v2M5 5h14a2 2 0 0 1 2 2v3a2 2 0 0 1 0 4v3a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-3a2 2 0 0 1 0-4V7a2 2 0 0 1 2-2z"/>
                </svg>
            </div>
            <div class="stat-body">
                <span class="stat-value">{{ $mt_total }}</span>
                <span class="stat-label">Total</span>
            </div>
        </div>

        <div class="stat-card" onclick="mtFiltrarDesdeStat('PROGRAMADO')" style="cursor: pointer;" title="Ver tickets programados">
            <div class="stat-icon" style="background: var(--erp-violet-bg); color: var(--erp-violet);">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
                    <line x1="16" y1="2" x2="16" y2="6"/>
                    <line x1="8" y1="2" x2="8" y2="6"/>
                    <line x1="3" y1="10" x2="21" y2="10"/>
                </svg>
            </div>
            <div class="stat-body">
                <span class="stat-value">{{ $mt_programado }}</span>
                <span class="stat-label">Programados</span>
            </div>
        </div>

        <div class="stat-card" onclick="mtFiltrarDesdeStat('EN PROCESO')" style="cursor: pointer;" title="Ver tickets en proceso">
            <div class="stat-icon" style="background: rgba(22,101,52,.10); color: #166534;">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"/>
                </svg>
            </div>
            <div class="stat-body">
                <span class="stat-value">{{ $mt_proceso }}</span>
                <span class="stat-label">En Proceso</span>
            </div>
        </div>

        <div class="stat-card" onclick="mtFiltrarDesdeStat('CERRADO')" style="cursor: pointer;" title="Ver tickets cerrados">
            <div class="stat-icon" style="background: rgba(100,116,139,.10); color: #475569;">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                    <polyline points="22 4 12 14.01 9 11.01"/>
                </svg>
            </div>
            <div class="stat-body">
                <span class="stat-value">{{ $mt_cerrado }}</span>
                <span class="stat-label">Cerrados</span>
            </div>
        </div>

        <div class="stat-card" onclick="mtFiltrarDesdeStat('CANCELADO')" style="cursor: pointer;" title="Ver tickets cancelados">
            <div class="stat-icon" style="background: rgba(153,27,27,.10); color: #991b1b;">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"/>
                    <line x1="15" y1="9" x2="9" y2="15"/>
                    <line x1="9" y1="9" x2="15" y2="15"/>
                </svg>
            </div>
            <div class="stat-body">
                <span class="stat-value">{{ $mt_cancelado }}</span>
                <span class="stat-label">Cancelados</span>
            </div>
        </div>
    </div>

    {{-- ══════════════════════════════════════════
         TOOLBAR (Filtros + Búsqueda)
    ══════════════════════════════════════════ --}}
    <div class="erp-toolbar">
        <div class="filter-section">
            <span class="filter-section-lbl">Estado</span>
            <div class="seg-ctrl">
                <button class="filter-toggle active" data-mt-status="todos" onclick="mtFiltrar('todos', this)">
                    Todos <span class="ft-ct">{{ $mt_total }}</span>
                </button>
                <button class="filter-toggle" data-mt-status="PROGRAMADO" onclick="mtFiltrar('PROGRAMADO', this)">
                    Programado <span class="ft-ct">{{ $mt_programado }}</span>
                </button>
                <button class="filter-toggle" data-mt-status="EN PROCESO" onclick="mtFiltrar('EN PROCESO', this)">
                    En Proceso <span class="ft-ct">{{ $mt_proceso }}</span>
                </button>
                <button class="filter-toggle" data-mt-status="CERRADO" onclick="mtFiltrar('CERRADO', this)">
                    Cerrado <span class="ft-ct">{{ $mt_cerrado }}</span>
                </button>
                <button class="filter-toggle" data-mt-status="CANCELADO" onclick="mtFiltrar('CANCELADO', this)">
                    Cancelado <span class="ft-ct">{{ $mt_cancelado }}</span>
                </button>
            </div>
        </div>
        <div class="toolbar-search">
            <input type="text" class="search-input" placeholder="Buscar por asunto, cliente o código..." id="mt-buscar" oninput="mtBuscar()">
            <button class="btn-search" onclick="mtBuscar()">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="11" cy="11" r="8"/>
                    <line x1="21" y1="21" x2="16.65" y2="16.65"/>
                </svg>
                Buscar
            </button>
        </div>
    </div>

    {{-- ══════════════════════════════════════════
         TABLA DE TICKETS
    ══════════════════════════════════════════ --}}
    <div class="erp-table-container">
        <table class="erp-table">
            <thead>
                <tr>
                    <th style="width:60px">ID</th>
                    <th>Asunto</th>
                    <th>Cliente</th>
                    <th>Estado</th>
                    <th>Prioridad</th>
                    <th>Fecha</th>
                    <th style="width:140px">Acciones</th>
                </tr>
            </thead>
            <tbody id="mt-tbody">
                <!-- JS llenará esto dinámicamente -->
            </tbody>
        </table>
    </div>

    {{-- ══════════════════════════════════════════
         EMPTY STATE
    ══════════════════════════════════════════ --}}
    <div class="erp-empty-state" id="mt-empty" style="display:none;">
        <div class="erp-empty-ico">
            <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="11" cy="11" r="8"/>
                <line x1="21" y1="21" x2="16.65" y2="16.65"/>
            </svg>
        </div>
        <p class="erp-empty-ttl">Sin tickets para mostrar</p>
        <p class="erp-empty-desc">No hay tickets que coincidan con los filtros aplicados.</p>
    </div>

</div>
</div>

{{-- ══════════════════════════════════════════
DATOS PHP → JS
══════════════════════════════════════════ --}}
<script>
const MT_TICKETS = @json($tickets->values());

let mtFiltroActual = 'todos';
let mtBusqueda     = '';

// ── Render ────────────────────────────────────────────────────────
function mtRender() {
    const tbody = document.getElementById('mt-tbody');
    const empty = document.getElementById('mt-empty');

    let lista = MT_TICKETS;

    if (mtFiltroActual !== 'todos') {
        lista = lista.filter(t => t.estado === mtFiltroActual);
    }

    if (mtBusqueda.trim()) {
        const q = mtBusqueda.toLowerCase();
        lista = lista.filter(t =>
            (t.asunto         || '').toLowerCase().includes(q) ||
            (t.razon_social   || '').toLowerCase().includes(q) ||
            (t.usuario_nombre || '').toLowerCase().includes(q) ||
            (t.codigo_ticket  || '').toLowerCase().includes(q) ||
            String(t.id_ticket).includes(q)
        );
    }

    if (!lista.length) {
        tbody.innerHTML = '';
        empty.style.display = 'flex';
        return;
    }

    empty.style.display = 'none';

    tbody.innerHTML = lista.map(t => {
        const estadoClass = t.estado === 'PENDIENTE' ? 'badge-pendiente' : 
                            t.estado === 'PROGRAMADO' ? 'badge-programado' :
                            t.estado === 'EN PROCESO' ? 'badge-proceso' :
                            t.estado === 'CERRADO' ? 'badge-cerrado' : 'badge-cancelado';
                            
        const prioColor = t.prioridad_color ? `background:${t.prioridad_color}20;color:${t.prioridad_color};border:1px solid ${t.prioridad_color}40` : '';
        const fecha = t.created_at ? new Date(t.created_at).toLocaleDateString('es-PE', { day: '2-digit', month: 'short', year: 'numeric' }) : '—';

        return `
        <tr>
            <td class="cell-id">#${t.id_ticket}</td>
            <td class="cell-name">${t.asunto || 'Sin asunto'}</td>
            <td>${t.razon_social || '—'}</td>
            <td><span class="${estadoClass}"><span class="bdot"></span>${t.estado}</span></td>
            <td><span class="type-badge" style="${prioColor}">${t.prioridad_nombre || 'Normal'}</span></td>
            <td>${fecha}</td>
            <td>
                <div class="row-actions">
                    <button class="btn-action-sm" onclick="abrirDetalleInteligente(${t.id_ticket}, '${t.estado}')">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                            <circle cx="12" cy="12" r="3"/>
                        </svg>
                        Detalle
                    </button>
                    <button class="btn-action-sm btn-deactivate" onclick="mtCancelarTicket(${t.id_ticket})">
                        Cancelar
                    </button>
                </div>
            </td>
        </tr>`;
    }).join('');
}

// ── Filtrar desde Toolbar ─────────────────────────────────────────
function mtFiltrar(estado, btn) {
    mtFiltroActual = estado;
    document.querySelectorAll('.filter-toggle[data-mt-status]').forEach(p => p.classList.remove('active'));
    
    if (btn) {
        btn.classList.add('active');
    } else {
        const targetBtn = document.querySelector(`.filter-toggle[data-mt-status="${estado}"]`);
        if (targetBtn) targetBtn.classList.add('active');
    }
    mtRender();
}

// ── Filtrar desde Stat Card (Interactivo) ─────────────────────────
function mtFiltrarDesdeStat(estado) {
    mtFiltrar(estado, null);
    document.querySelector('.erp-table-container').scrollIntoView({ behavior: 'smooth', block: 'start' });
}

// ── Buscar ────────────────────────────────────────────────────────
function mtBuscar() {
    mtBusqueda = document.getElementById('mt-buscar').value;
    mtRender();
}

// ── Init ──────────────────────────────────────────────────────────
document.addEventListener('DOMContentLoaded', mtRender);

// ── stub requerido por detalleticket.blade.php del admin ─────────
function cerrarPanelEdicion() {}

function abrirDetalleInteligente(id, estado) {
    const estadosFinales  = ['CERRADO', 'CANCELADO'];

    if (estadosFinales.includes(estado)) {
        if (typeof abrirDetalleTicket === 'function') {
            abrirDetalleTicket(id);
        } else {
            window.location.href = `/admin/ticket/${id}/detalle`;
        }
    } else {
        if (typeof abrirModalEdicion === 'function') {
            abrirModalEdicion(id);
        } else {
            window.location.href = `/admin/ticket/${id}/detalle`;
        }
    }
}

// ── Cancelar Ticket (CON MODAL DE CONFIRMACIÓN) ───────────────────
function mtCancelarTicket(idTicket) {
    // Usamos el ModalSystem de alertas.blade.php
    ModalSystem.show('question', {
        title: '¿Cancelar ticket?',
        text: '¿Estás seguro de que deseas cancelar este ticket? Esta acción no se puede deshacer.',
        confirmText: 'Sí, cancelar',
        cancelText: 'No, mantener',
        onConfirm: async () => {
            try {
                const res = await fetch(`/admin/ticket/${idTicket}/cancelar`, {
                    method: 'POST',
                    headers: { 
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content, 
                        'Content-Type': 'application/json' 
                    }
                });
                const data = await res.json();
                
                if (data.ok) {
                    // Notificación de éxito (toast)
                    showNotification('success', '¡Éxito!', 'El ticket ha sido cancelado correctamente.');
                    
                    // Actualiza la tabla instantáneamente sin recargar la página
                    mtRender(); 
                    
                    // Si prefieres recarga completa de la página en lugar de actualización dinámica, 
                    // descomenta la siguiente línea y comenta mtRender():
                    // setTimeout(() => location.reload(), 1000);
                } else {
                    showNotification('danger', 'Error', data.message || 'No se pudo cancelar el ticket.');
                }
            } catch (err) {
                console.error('Error al cancelar:', err);
                showNotification('danger', 'Error de conexión', 'Ocurrió un error al intentar cancelar el ticket.');
            }
        }
    });
}
</script>

{{-- ══════════════════════════════════════════
ESTILOS UNIFICADOS (ERP DESIGN - AZUL JEAN)
══════════════════════════════════════════ --}}
<style>
:root {
    --erp-bg:           #f1f4f8;
    --erp-card:         #ffffff;
    --erp-text:         #0f172a;
    --erp-text-2:       #334155;
    --erp-muted:        #64748b;
    --erp-border:       #e2e8f0;
    --erp-border-li:    #f1f5f9;

    --erp-primary:      #0f4a8a;
    --erp-primary-h:    #1a6ed8;
    --erp-primary-bg:   #eff6ff;

    --erp-success:      #166534;
    --erp-success-bg:   #f0fdf4;
    --erp-danger:       #991b1b;
    --erp-danger-bg:    #fef2f2;

    --erp-teal:         #0f766e;
    --erp-teal-bg:      #f0fdfa;
    --erp-violet:       #5b21b6;
    --erp-violet-bg:    #f5f3ff;

    --erp-radius:       6px;
    --erp-shadow:       0 1px 2px rgba(0,0,0,0.05), 0 1px 3px rgba(0,0,0,0.07);
    --erp-shadow-md:    0 4px 6px -1px rgba(0,0,0,0.07), 0 2px 4px rgba(0,0,0,0.04);
}

.main-content {
    margin-left: 260px;
    padding: 34px 32px;
    background: var(--erp-bg);
    min-height: 100vh;
    font-family: 'Plus Jakarta Sans', -apple-system, system-ui, sans-serif;
    transition: margin-left 0.35s ease;
    box-sizing: border-box;
}
body.sb-collapsed .main-content { margin-left: 70px; }

.page-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 22px;
    padding: 18px 22px;
    background: var(--erp-card);
    border-radius: var(--erp-radius);
    border: 1px solid var(--erp-border);
    box-shadow: var(--erp-shadow);
    gap: 16px;
    flex-wrap: wrap;
}
.page-header-left { display: flex; align-items: center; gap: 14px; }
.page-header-icon {
    width: 46px; height: 46px;
    background: linear-gradient(135deg, var(--erp-primary) 0%, var(--erp-primary-h) 100%);
    border-radius: 7px;
    display: flex; align-items: center; justify-content: center;
    color: #fff;
    box-shadow: 0 4px 14px rgba(15,74,138,.25);
    flex-shrink: 0;
}
.page-title { font-size: 1.375rem; font-weight: 700; color: var(--erp-text); margin: 0; letter-spacing: -0.015em; line-height: 1.2; }
.page-subtitle { font-size: 0.875rem; color: var(--erp-muted); margin: 3px 0 0; font-weight: 500; }

.stats-container {
    display: grid; grid-template-columns: repeat(auto-fill, minmax(148px, 1fr));
    gap: 10px; margin-bottom: 14px;
}
.stat-card {
    display: flex; align-items: center; gap: 12px;
    background: var(--erp-card); border: 1px solid var(--erp-border);
    border-radius: var(--erp-radius); padding: 12px 16px;
    box-shadow: var(--erp-shadow);
    transition: box-shadow .15s, border-color .15s, transform .15s;
    animation: fadeInUp 0.45s ease backwards;
    position: relative; overflow: hidden; min-width: 0; cursor: pointer;
}
.stat-card:hover { 
    box-shadow: var(--erp-shadow-md); 
    border-color: var(--erp-primary-h); 
    transform: translateY(-2px);
}
.stat-icon {
    display: flex; align-items: center; justify-content: center;
    width: 34px; height: 34px; border-radius: 7px; flex-shrink: 0;
}
.stat-icon.si-t { background: var(--erp-violet-bg); color: var(--erp-violet); }
.stat-body { display: flex; flex-direction: column; gap: 1px; }
.stat-value { font-size: 1.25rem; font-weight: 700; color: var(--erp-text); line-height: 1; }
.stat-label { font-size: 0.725rem; color: var(--erp-muted); font-weight: 500; letter-spacing: .01em; }
.stat-card:nth-child(1) { animation-delay: .04s; } .stat-card:nth-child(2) { animation-delay: .09s; }
.stat-card:nth-child(3) { animation-delay: .14s; } .stat-card:nth-child(4) { animation-delay: .19s; }
.stat-card:nth-child(5) { animation-delay: .24s; }

.erp-toolbar {
    background: var(--erp-card); border: 1px solid var(--erp-border);
    border-radius: var(--erp-radius); padding: 11px 16px;
    margin-bottom: 14px; box-shadow: var(--erp-shadow);
    display: flex; flex-wrap: wrap; gap: 12px; align-items: center;
}
.filter-section { display: flex; align-items: center; gap: 8px; }
.filter-section-lbl {
    font-size: 0.675rem; font-weight: 700; color: var(--erp-muted);
    text-transform: uppercase; letter-spacing: .07em; white-space: nowrap;
}
.seg-ctrl {
    display: inline-flex; background: var(--erp-bg);
    border: 1px solid var(--erp-border); border-radius: 7px; padding: 3px; gap: 2px;
}
.filter-toggle {
    display: inline-flex; align-items: center; gap: 5px; padding: 5px 11px;
    border-radius: 5px; font-size: 0.7875rem; font-weight: 500; cursor: pointer;
    border: none; background: transparent; color: var(--erp-muted);
    transition: all .15s ease; white-space: nowrap; line-height: 1.15;
}
.filter-toggle:hover { background: rgba(255,255,255,.75); color: var(--erp-text-2); }
.filter-toggle.active {
    background: var(--erp-card); color: var(--erp-primary); font-weight: 600;
    box-shadow: 0 1px 3px rgba(0,0,0,.09), 0 1px 2px rgba(0,0,0,.05);
}
.ft-ct {
    display: inline-flex; align-items: center; justify-content: center;
    min-width: 17px; height: 17px; padding: 0 4px; border-radius: 9px;
    font-size: 0.67rem; font-weight: 700; background: #e9edf3; color: var(--erp-muted);
    transition: all .15s; margin-left: 1px;
}
.filter-toggle.active .ft-ct { background: var(--erp-primary-bg); color: var(--erp-primary-h); }

.toolbar-search { display: flex; align-items: center; gap: 7px; margin-left: auto; }
.toolbar-search .search-input {
    border: 1px solid var(--erp-border); border-radius: var(--erp-radius);
    padding: 7px 12px 7px 34px; font-size: 0.84rem; width: 260px; outline: none;
    background: var(--erp-bg) url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='13' height='13' viewBox='0 0 24 24' fill='none' stroke='%2394a3b8' stroke-width='2.2' stroke-linecap='round'%3E%3Ccircle cx='11' cy='11' r='8'/%3E%3Cline x1='21' y1='21' x2='16.65' y2='16.65'/%3E%3C/svg%3E") 10px center no-repeat;
    color: var(--erp-text); transition: border-color .15s, box-shadow .15s, background-color .15s;
}
.toolbar-search .search-input:focus {
    border-color: var(--erp-primary-h); box-shadow: 0 0 0 3px rgba(26,110,216,.1); background-color: #fff;
}
.toolbar-search .search-input::placeholder { color: #94a3b8; }
.toolbar-search .btn-search {
    background: var(--erp-primary); color: #fff; border: 1px solid var(--erp-primary);
    border-radius: var(--erp-radius); padding: 7px 14px; font-size: 0.8125rem;
    font-weight: 600; cursor: pointer; display: inline-flex; align-items: center;
    gap: 6px; transition: background .15s; white-space: nowrap;
}
.toolbar-search .btn-search:hover { background: var(--erp-primary-h); border-color: var(--erp-primary-h); }

.erp-table-container {
    background: var(--erp-card); border: 1px solid var(--erp-border);
    border-radius: var(--erp-radius); box-shadow: var(--erp-shadow);
    overflow-x: auto; overflow-y: hidden;
}
.erp-table { width: 100%; border-collapse: collapse; }
.erp-table thead { background: #f8fafc; border-bottom: 2px solid var(--erp-border); }
.erp-table th {
    padding: 10px 16px; text-align: left; font-size: 0.69rem; font-weight: 700;
    color: var(--erp-muted); text-transform: uppercase; letter-spacing: .065em;
}
.erp-table td {
    padding: 11px 16px; border-bottom: 1px solid var(--erp-border-li);
    font-size: 0.875rem; color: var(--erp-text); vertical-align: middle;
}
.erp-table tbody tr:last-child td { border-bottom: none; }
.erp-table tbody tr:hover { background: #f8fbff; }

.cell-id { font-size: 0.775rem; font-weight: 600; color: var(--erp-muted); font-variant-numeric: tabular-nums; letter-spacing: .01em; }
.cell-name { font-weight: 500; color: var(--erp-text); }

.type-badge {
    display: inline-flex; align-items: center; gap: 5px;
    padding: 3px 8px 3px 5px; border-radius: 4px;
    font-size: 0.73rem; font-weight: 600; letter-spacing: .01em; line-height: 1;
}
.type-badge svg { flex-shrink: 0; }

/* ── Status badges (sin borde, con gap) ────────────────────────── */
.badge-pendiente,
.badge-programado,
.badge-proceso,
.badge-cerrado,
.badge-cancelado {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    padding: 3px 8px;
    border-radius: 4px;
    font-size: 0.73rem;
    font-weight: 600;
    line-height: 1;
    border: none; /* ← QUITA el borde que los hace ver como recuadro */
}
.badge-pendiente  { background: rgba(245,158,11,.12); color: #d97706; }
.badge-programado { background: rgba(26,110,216,.12); color: var(--erp-primary-h); }
.badge-proceso    { background: rgba(22,101,52,.12);  color: var(--erp-success); }
.badge-cerrado    { background: rgba(100,116,139,.10); color: #475569; }
.badge-cancelado  { background: var(--erp-danger-bg); color: var(--erp-danger); }

/* ─ Punto indicador ────────────────────────────────────────────── */
.bdot {
    display: inline-block;
    width: 5px;
    height: 5px;
    border-radius: 50%;
    flex-shrink: 0;
    /* margin-right ya no es necesario porque usamos gap en el padre */
}
.badge-pendiente  .bdot { background: #d97706; }
.badge-programado .bdot { background: var(--erp-primary-h); }
.badge-proceso    .bdot { background: var(--erp-success); }
.badge-cerrado    .bdot { background: #475569; }
.badge-cancelado  .bdot { background: var(--erp-danger); }

.row-actions { display: flex; gap: 5px; align-items: center; flex-wrap: nowrap; }
.btn-action-sm {
    display: inline-flex; align-items: center; gap: 5px; padding: 4px 10px;
    border-radius: 5px; font-size: 0.775rem; font-weight: 500; cursor: pointer;
    border: 1px solid var(--erp-border); background: var(--erp-card);
    color: var(--erp-muted); transition: all .15s ease; white-space: nowrap; line-height: 1;
}
.btn-action-sm:hover { border-color: var(--erp-primary-h); color: var(--erp-primary); background: var(--erp-primary-bg); }
.btn-action-sm.btn-deactivate:hover { border-color: var(--erp-danger); color: var(--erp-danger); background: var(--erp-danger-bg); }

.erp-empty-state {
    display: flex; flex-direction: column; align-items: center;
    padding: 56px 24px; text-align: center; color: var(--erp-muted);
}
.erp-empty-ico { color: #cbd5e1; margin-bottom: 14px; }
.erp-empty-ttl { font-size: 0.9375rem; font-weight: 600; color: var(--erp-text-2); margin: 0 0 4px; }
.erp-empty-desc { font-size: 0.84rem; margin: 0; }

@keyframes fadeInUp { from { opacity: 0; transform: translateY(18px); } to { opacity: 1; transform: translateY(0); } }

@media (max-width: 1024px) { .main-content { margin-left: 0 !important; padding: 24px 20px; padding-top: 68px; } }
@media (max-width: 768px) {
    .main-content { padding: 16px; padding-top: 68px; }
    .page-header { flex-direction: column; align-items: flex-start; gap: 12px; padding: 16px; }
    .stats-container { grid-template-columns: repeat(2, 1fr); gap: 10px; }
    .erp-toolbar { flex-direction: column; align-items: stretch; }
    .filter-section { width: 100%; }
    .seg-ctrl { width: 100%; justify-content: center; }
    .toolbar-search { width: 100%; margin-left: 0; }
    .toolbar-search .search-input { width: 100%; }
}
</style>