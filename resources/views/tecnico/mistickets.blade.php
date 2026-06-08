@include('components.notificaciones.alertas')
@include('components.tecnico.navbar-tecnico')
@include('components.tecnico.sidebar-tecnico')
@include('components.tecnico.editardetalleticket')
@include('components.tecnico.modalreporte')

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<style>
*, *::before, *::after { box-sizing: border-box; }

.tk-main {
    margin-left: 260px;
    background: #f0f4f8;
    min-height: 100vh;
    font-family: 'Inter', sans-serif;
    transition: margin-left var(--sb-transition, .35s);
}
body.sb-collapsed .tk-main { margin-left: 70px; }
.tk-inner { padding: 28px 32px; max-width: 1400px; }

/* HEADER */
.tk-header { display:flex; align-items:center; justify-content:space-between; margin-bottom:28px; gap:12px; flex-wrap:wrap; }
.tk-header h1 { font-size:22px; font-weight:700; color:#0a2540; margin:0 0 3px; }
.tk-header p  { font-size:13px; color:#64748b; margin:0; }

/* KPI CARDS */
.tk-cards { display:grid; grid-template-columns:repeat(5,1fr); gap:14px; margin-bottom:24px; }
.tk-card {
    background:#fff; border:1.5px solid #e2eaf4; border-radius:14px;
    padding:16px; cursor:pointer;
    transition:box-shadow .2s,transform .2s,border-color .2s; position:relative; overflow:hidden;
}
.tk-card::before { content:''; position:absolute; top:0; left:0; right:0; height:3px; border-radius:14px 14px 0 0; background:var(--card-accent,#e2eaf4); }
.tk-card:hover { box-shadow:0 6px 20px rgba(10,37,80,.1); transform:translateY(-2px); }
.tk-card.card-active { border-color:var(--card-accent,#185FA5); box-shadow:0 6px 20px rgba(24,95,165,.15); }
.tk-card.card-active::before { height:4px; }
.tk-card-icon { width:36px; height:36px; border-radius:10px; display:flex; align-items:center; justify-content:center; font-size:15px; margin-bottom:10px; background:var(--card-icon-bg,#f0f4f8); color:var(--card-accent,#64748b); }
.tk-card-label { font-size:11px; color:#94a3b8; margin-bottom:4px; font-weight:500; text-transform:uppercase; letter-spacing:.04em; }
.tk-card-num   { font-size:26px; font-weight:700; color:#0a2540; line-height:1; }

/* TOOLBAR */
.tk-toolbar { display:flex; align-items:center; gap:10px; margin-bottom:16px; flex-wrap:wrap; }
.tk-pills { display:flex; gap:6px; flex-wrap:wrap; flex:1; }
.tk-pill {
    padding:7px 14px; border-radius:20px; border:1.5px solid #e2eaf4;
    background:#fff; font-size:12px; font-weight:600; color:#64748b;
    cursor:pointer; transition:.15s; font-family:'Inter',sans-serif;
}
.tk-pill:hover { background:#f8fafd; }
.tk-pill.active { background:#0a2540; color:#fff; border-color:#0a2540; }

.tk-search {
    display:flex; align-items:center; gap:8px;
    background:#fff; border:1.5px solid #e2eaf4; border-radius:10px; padding:9px 14px;
    min-width:240px; transition:border-color .15s, box-shadow .15s;
}
.tk-search:focus-within { border-color:#185FA5; box-shadow:0 0 0 3px rgba(24,95,165,.1); }
.tk-search svg { color:#94a3b8; flex-shrink:0; }
.tk-search input { border:none; outline:none; font-size:13.5px; color:#0a2540; background:transparent; width:100%; font-family:'Inter',sans-serif; }
.tk-search input::placeholder { color:#b0bec5; }

/* GRID */
.tk-grid { display:grid; grid-template-columns:repeat(auto-fill,minmax(300px,1fr)); gap:16px; margin-bottom:28px; }

/* CARD */
.tk-tcard {
    background:#fff; border:1.5px solid #e2eaf4; border-radius:14px;
    overflow:hidden; display:flex; flex-direction:column;
    transition:box-shadow .2s, transform .15s;
}
.tk-tcard:hover { box-shadow:0 8px 24px rgba(10,37,80,.1); transform:translateY(-2px); }

.tk-tcard-head {
    display:flex; justify-content:space-between; align-items:center;
    padding:11px 14px; background:#f8fafd; border-bottom:1px solid #eef2f7;
}
.tk-tcard-codigo {
    font-size:11.5px; font-weight:700; color:#185FA5;
    background:#EEF6FF; padding:3px 9px; border-radius:20px;
    border:1px solid #c8dff8; font-family:'Courier New',monospace;
}
.tk-tcard-estado { font-size:10.5px; font-weight:700; padding:3px 10px; border-radius:20px; white-space:nowrap; }

.tk-tcard-body { padding:14px; flex:1; display:flex; flex-direction:column; gap:10px; }
.tk-tcard-asunto { font-size:14px; font-weight:700; color:#0f2a4a; margin:0; line-height:1.4; }

.tk-tcard-rows { display:flex; flex-direction:column; gap:5px; }
.tk-tcard-row  { display:flex; align-items:center; gap:7px; font-size:12px; color:#4a5568; }
.tk-tcard-row svg { color:#94a3b8; flex-shrink:0; }

.tk-tcard-divider { border:none; border-top:1px solid #f0f4fa; }

.tk-tcard-bottom { display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:6px; }
.tk-tcard-badges { display:flex; gap:5px; flex-wrap:wrap; }
.tk-badge-tipo { font-size:10.5px; background:#f1f5f9; color:#475569; padding:3px 9px; border-radius:20px; border:1px solid #e2e8f0; }
.tk-badge-prio { font-size:10.5px; padding:3px 9px; border-radius:20px; font-weight:700; }
.tk-tcard-fecha { display:flex; align-items:center; gap:4px; font-size:11px; color:#94a3b8; white-space:nowrap; }

.tk-tcard-foot { border-top:1.5px solid #f0f4fa; background:#f8fafd; }
.tk-btn-ver {
    width:100%; padding:10px; border:none; background:transparent;
    font-size:13px; font-weight:600; color:#185FA5; cursor:pointer;
    transition:background .15s; display:flex; align-items:center; justify-content:center; gap:6px;
    font-family:'Inter',sans-serif;
}
.tk-btn-ver:hover { background:#EEF6FF; }

/* EMPTY */
.tk-empty { text-align:center; padding:3rem; color:#94a3b8; }
.tk-empty svg { display:block; margin:0 auto 12px; color:#cbd5e1; }

/* Pill especial disponibles */
.tk-pill-new { position:relative; }
.tk-pill-new.active { background:#7c3aed; border-color:#7c3aed; color:#fff; }
.tk-pill-new:hover:not(.active) { background:#f5f3ff; }

/* Botón autoasignar */
.tk-btn-autoasignar:hover { background:#f5f3ff !important; }

/* BOTÓN REPORTE */
.tk-btn-reporte {
    display:flex; align-items:center; gap:8px;
    background:linear-gradient(135deg,#c53030,#9b2c2c);
    color:#fff; border:none; border-radius:12px;
    padding:10px 20px; font-size:13px; font-weight:600;
    cursor:pointer; font-family:'Inter',sans-serif;
    box-shadow:0 4px 14px rgba(197,48,48,.35);
    transition:opacity .15s, transform .15s;
}
.tk-btn-reporte:hover { opacity:.88; transform:translateY(-1px); }

/* RESPONSIVE */
@media (min-width:769px) and (max-width:1024px) {
    .tk-main{margin-left:0;padding-top:68px;}
    .tk-inner{padding:20px;}
    .tk-cards{grid-template-columns:repeat(3,1fr);}
    .tk-grid{grid-template-columns:repeat(2,1fr);}
}
@media (max-width:768px) {
    .tk-main{margin-left:0!important;padding-top:64px;}
    .tk-inner{padding:14px;}
    .tk-cards{grid-template-columns:repeat(2,1fr);gap:10px;}
    .tk-toolbar{flex-direction:column;align-items:stretch;}
    .tk-search{width:100%;}
    .tk-pills{width:100%;}
    .tk-grid{grid-template-columns:1fr;}
}
@media (max-width:480px) {
    .tk-main { padding-top: 64px; }
    .tk-inner { padding: 12px; }
    .tk-cards { grid-template-columns: 1fr; gap: 10px; }
}
@media (max-width:420px) {
    .tk-cards { grid-template-columns: 1fr; }
}
</style>

<div class="tk-main">
<div class="tk-inner">

    <div class="tk-header">
        <div>
            <h1>Panel de Tecnico</h1>
            <p>Tickets asignados a ti</p>
        </div>
        <div>
            <button class="tk-btn-reporte" onclick="tecOpenModalReporte()">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                    <polyline points="14 2 14 8 20 8"/>
                    <line x1="16" y1="13" x2="8" y2="13"/>
                    <line x1="16" y1="17" x2="8" y2="17"/>
                </svg>
                Descargar Reporte
            </button>
        </div>
    </div>

    {{-- KPI --}}
    <div class="tk-cards">
        <div class="tk-card card-active" id="card-todos" style="--card-accent:#4338ca;--card-icon-bg:#EEF2FF;" onclick="mtFiltrar('todos',this)">
            <div class="tk-card-icon">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>
            </div>
            <div class="tk-card-label">Total</div>
            <div class="tk-card-num">{{ $resumen['total'] }}</div>
        </div>
        <div class="tk-card" id="card-PROGRAMADO" style="--card-accent:#3B82F6;--card-icon-bg:#EFF6FF;" onclick="mtFiltrar('PROGRAMADO',this)">
            <div class="tk-card-icon">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
            </div>
            <div class="tk-card-label">Programados</div>
            <div class="tk-card-num">{{ $resumen['programado'] }}</div>
        </div>
        <div class="tk-card" id="card-EN PROCESO" style="--card-accent:#f97316;--card-icon-bg:#FFF7ED;" onclick="mtFiltrar('EN PROCESO',this)">
            <div class="tk-card-icon">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="23 4 23 10 17 10"/><path d="M20.49 15a9 9 0 1 1-2.12-9.36L23 10"/></svg>
            </div>
            <div class="tk-card-label">En Proceso</div>
            <div class="tk-card-num">{{ $resumen['en_proceso'] }}</div>
        </div>
        <div class="tk-card" id="card-CERRADO" style="--card-accent:#16a34a;--card-icon-bg:#F0FDF4;" onclick="mtFiltrar('CERRADO',this)">
            <div class="tk-card-icon">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
            </div>
            <div class="tk-card-label">Cerrados</div>
            <div class="tk-card-num">{{ $resumen['cerrado'] }}</div>
        </div>
        <div class="tk-card" id="card-CANCELADO" style="--card-accent:#dc2626;--card-icon-bg:#FEF2F2;" onclick="mtFiltrar('CANCELADO',this)">
            <div class="tk-card-icon">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
            </div>
            <div class="tk-card-label">Cancelados</div>
            <div class="tk-card-num">{{ $resumen['cancelado'] }}</div>
        </div>
    </div>

    {{-- TOOLBAR --}}
    <div class="tk-toolbar">
        <div class="tk-pills" id="tk-pills">
            <button class="tk-pill active" onclick="cambiarVista('mis',this)">Mis Tickets</button>
            <button class="tk-pill tk-pill-new" onclick="cambiarVista('disponibles',this)" id="pill-disponibles">
                Disponibles
                <span id="badge-disponibles" style="background:#dc2626;color:#fff;font-size:9px;font-weight:700;padding:2px 7px;border-radius:20px;margin-left:4px;">{{ $ticketsDisponibles->count() }}</span>
            </button>
        </div>
    </div>

    {{-- FILTROS MIS TICKETS --}}
    <div id="seccion-mis" style="display:block;">
        <div class="tk-toolbar" style="margin-top:0;">
            <div class="tk-pills" id="tk-pills-estado">
                <button class="tk-pill active" onclick="mtFiltrar('todos',this)">Todos</button>
                <button class="tk-pill" onclick="mtFiltrar('PROGRAMADO',this)">Programado</button>
                <button class="tk-pill" onclick="mtFiltrar('EN PROCESO',this)">En Proceso</button>
                <button class="tk-pill" onclick="mtFiltrar('CERRADO',this)">Cerrado</button>
                <button class="tk-pill" onclick="mtFiltrar('CANCELADO',this)">Cancelado</button>
            </div>
            <div class="tk-search">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                <input type="text" id="mt-buscar" placeholder="Buscar por asunto, cliente..." oninput="mtBuscar()">
            </div>
        </div>
        <div class="tk-grid" id="mt-grid"></div>
        <div class="tk-empty" id="mt-empty" style="display:none;">
            <svg width="44" height="44" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>
            <p>No hay tickets para mostrar.</p>
        </div>
    </div>

    {{-- SECCIÓN DISPONIBLES --}}
    <div id="seccion-disponibles" style="display:none;">
        <div class="tk-toolbar" style="margin-top:0;">
            <div class="tk-search">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                <input type="text" id="disp-buscar" placeholder="Buscar por asunto, cliente, código..." oninput="filtrarDisponibles()">
            </div>
        </div>
        <div class="tk-grid" id="disp-grid"></div>
        <div class="tk-empty" id="disp-empty" style="display:none;">
            <svg width="44" height="44" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M9 11l3 3L22 4"/></svg>
            <p>No hay tickets disponibles para asignar.</p>
        </div>
    </div>

</div>
</div>

<script>
const MT_TICKETS = @json($tickets->values());
let mtFiltroActual = 'todos';
let mtBusqueda = '';

function badgeEstado(estado) {
    const map = {
        'PENDIENTE':  'background:#F5F3FF;color:#7c3aed;border:1px solid #c4b5fd;',
        'PROGRAMADO': 'background:#EFF6FF;color:#1d4ed8;border:1px solid #bfdbfe;',
        'EN PROCESO': 'background:#FFF7ED;color:#c2410c;border:1px solid #fed7aa;',
        'CERRADO':    'background:#F0FDF4;color:#15803d;border:1px solid #bbf7d0;',
        'CANCELADO':  'background:#FEF2F2;color:#b91c1c;border:1px solid #fecaca;',
    };
    return map[estado] ?? 'background:#f1f5f9;color:#64748b;border:1px solid #e2e8f0;';
}

function mtRender() {
    const grid  = document.getElementById('mt-grid');
    const empty = document.getElementById('mt-empty');
    let lista = MT_TICKETS;
    if (mtFiltroActual !== 'todos') lista = lista.filter(t => t.estado === mtFiltroActual);
    if (mtBusqueda.trim()) {
        const q = mtBusqueda.toLowerCase();
        lista = lista.filter(t =>
            (t.asunto||'').toLowerCase().includes(q) ||
            (t.razon_social||'').toLowerCase().includes(q) ||
            (t.usuario_nombre||'').toLowerCase().includes(q) ||
            (t.codigo_ticket||'').toLowerCase().includes(q)
        );
    }
    if (!lista.length) { grid.innerHTML=''; empty.style.display='block'; return; }
    empty.style.display = 'none';
    grid.innerHTML = lista.map(t => {
        const prioStyle = t.prioridad_color
            ? `background:${t.prioridad_color}22;color:${t.prioridad_color};border:1px solid ${t.prioridad_color}55;`
            : 'background:#f1f5f9;color:#475569;border:1px solid #e2e8f0;';
        const fecha = t.created_at
            ? new Date(t.created_at).toLocaleDateString('es-PE',{day:'2-digit',month:'short',year:'numeric'})
            : '—';
        return `
<div class="tk-tcard">
    <div class="tk-tcard-head">
        <span class="tk-tcard-codigo">${t.codigo_ticket||'—'}</span>
        <span class="tk-tcard-estado" style="${badgeEstado(t.estado)}">${t.estado}</span>
    </div>
    <div class="tk-tcard-body">
        <p class="tk-tcard-asunto">${t.asunto||'Sin asunto'}</p>
        <div class="tk-tcard-rows">
            <div class="tk-tcard-row">
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/></svg>
                <span>${t.razon_social||'—'}</span>
            </div>
            <div class="tk-tcard-row">
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                <span>${t.usuario_nombre||'—'}</span>
            </div>
        </div>
        <hr class="tk-tcard-divider">
        <div class="tk-tcard-bottom">
            <div class="tk-tcard-badges">
                <span class="tk-badge-tipo">${t.tipo_ticket_nombre||'—'}</span>
                <span class="tk-badge-prio" style="${prioStyle}">${t.prioridad_nombre||'—'}</span>
            </div>
            <div class="tk-tcard-fecha">
                <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                ${fecha}
            </div>
        </div>
    </div>
    <div class="tk-tcard-foot">
        <button class="tk-btn-ver" onclick="abrirDetalleTicket(${t.id_ticket})">
            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="3"/><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7S2 12 2 12z"/></svg>
            Ver detalle
        </button>
    </div>
</div>`;
    }).join('');
}

function mtFiltrar(estado, btn) {
    mtFiltroActual = estado;
    document.querySelectorAll('#tk-pills-estado .tk-pill').forEach(p => p.classList.remove('active'));
    if (btn) btn.classList.add('active');
    document.querySelectorAll('.tk-card').forEach(c => c.classList.remove('card-active'));
    const kpi = document.getElementById('card-' + estado);
    if (kpi) kpi.classList.add('card-active');
    mtRender();
}

function mtBuscar() { mtBusqueda = document.getElementById('mt-buscar').value; mtRender(); }
document.addEventListener('DOMContentLoaded', mtRender);
function cerrarPanelEdicion() {}

/* ── VISTA DISPONIBLES ─────────────────────────────────────────── */
const TICKETS_DISPONIBLES = @json($ticketsDisponibles->values());

function cambiarVista(vista, btn) {
    document.querySelectorAll('#tk-pills .tk-pill').forEach(p => p.classList.remove('active'));
    if (btn) btn.classList.add('active');

    if (vista === 'mis') {
        document.getElementById('seccion-mis').style.display = 'block';
        document.getElementById('seccion-disponibles').style.display = 'none';
    } else {
        document.getElementById('seccion-mis').style.display = 'none';
        document.getElementById('seccion-disponibles').style.display = 'block';
        renderDisponibles();
    }
}

function filtrarDisponibles() { renderDisponibles(); }

function renderDisponibles() {
    const q     = (document.getElementById('disp-buscar')?.value || '').toLowerCase();
    const grid  = document.getElementById('disp-grid');
    const empty = document.getElementById('disp-empty');

    let lista = TICKETS_DISPONIBLES;
    if (q) lista = lista.filter(t =>
        (t.asunto||'').toLowerCase().includes(q) ||
        (t.razon_social||'').toLowerCase().includes(q) ||
        (t.codigo_ticket||'').toLowerCase().includes(q) ||
        (t.usuario_nombre||'').toLowerCase().includes(q)
    );

    if (!lista.length) { grid.innerHTML = ''; empty.style.display = 'block'; return; }
    empty.style.display = 'none';

    grid.innerHTML = lista.map(t => {
        const badgeMap = {
            'PENDIENTE':  'background:#F5F3FF;color:#7c3aed;border:1px solid #c4b5fd;',
            'PROGRAMADO': 'background:#EFF6FF;color:#1d4ed8;border:1px solid #bfdbfe;',
            'EN PROCESO': 'background:#FFF7ED;color:#c2410c;border:1px solid #fed7aa;',
        };
        const badgeStyle = badgeMap[t.estado] ?? 'background:#f1f5f9;color:#64748b;border:1px solid #e2e8f0;';
        const prioStyle  = t.prioridad_color
            ? `background:${t.prioridad_color}22;color:${t.prioridad_color};border:1px solid ${t.prioridad_color}55;`
            : 'background:#f1f5f9;color:#475569;border:1px solid #e2e8f0;';
        const fecha = t.created_at
            ? new Date(t.created_at).toLocaleDateString('es-PE',{day:'2-digit',month:'short',year:'numeric'})
            : '—';

        return `
<div class="tk-tcard" id="disp-card-${t.id_ticket}">
    <div class="tk-tcard-head">
        <span class="tk-tcard-codigo">${t.codigo_ticket||'—'}</span>
        <span class="tk-tcard-estado" style="${badgeStyle}">${t.estado}</span>
    </div>
    <div class="tk-tcard-body">
        <p class="tk-tcard-asunto">${t.asunto||'Sin asunto'}</p>
        <div class="tk-tcard-rows">
            <div class="tk-tcard-row">
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/></svg>
                <span>${t.razon_social||'—'}</span>
            </div>
            <div class="tk-tcard-row">
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                <span>${t.usuario_nombre||'—'}</span>
            </div>
        </div>
        <hr class="tk-tcard-divider">
        <div class="tk-tcard-bottom">
            <div class="tk-tcard-badges">
                <span class="tk-badge-tipo">${t.tipo_ticket_nombre||'—'}</span>
                <span class="tk-badge-prio" style="${prioStyle}">${t.prioridad_nombre||'—'}</span>
            </div>
            <div class="tk-tcard-fecha">
                <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                ${fecha}
            </div>
        </div>
    </div>
    <div class="tk-tcard-foot" style="display:flex;">
        <button class="tk-btn-ver" onclick="abrirDetalleTicket(${t.id_ticket})"
            style="flex:1;border-right:1px solid #eef2f7;">
            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="3"/><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7S2 12 2 12z"/></svg>
            Ver detalle
        </button>
        <button class="tk-btn-ver tk-btn-autoasignar" onclick="autoAsignarDesdeDisponibles(${t.id_ticket}, this)"
            style="flex:1;color:#7c3aed;">
            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"/></svg>
            Autoasignar
        </button>
    </div>
</div>`;
    }).join('');
}

async function autoAsignarDesdeDisponibles(idTicket, btn) {
    ModalSystem.show('confirm', {
        title: '¿Autoasignar ticket?',
        text: '¿Deseas autoasignarte este ticket? Se moverá a tu lista de "Mis Tickets".',
        confirmText: 'Sí, autoasignar',
        cancelText: 'Cancelar',
        onConfirm: async () => {
            btn.disabled = true;
            btn.textContent = 'Asignando…';

            try {
                const res  = await fetch(`/tecnico/ticket/${idTicket}/autoasignar`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                });
                const data = await res.json();

                if (data.ok) {
                    ModalSystem.show('success', {
                        title: '¡Ticket autoasignado!',
                        text: 'El ticket se agregó a tus "Mis Tickets".',
                        confirmText: 'Ver mis tickets',
                        onConfirm: () => location.reload()
                    });
                } else {
                    showNotification('danger', 'Error', data.message || 'No se pudo autoasignar.');
                    btn.disabled = false;
                    btn.innerHTML = `<svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"/></svg> Autoasignar`;
                }
            } catch(e) {
                showNotification('danger', 'Error', 'No se pudo conectar.');
                btn.disabled = false;
            }
        }
    });
}
</script>
