@include('components.usuario.sidebar-usuario')
@include('components.usuario.modelcrearticket')
@include('components.usuario.detalleticket')
@include('components.notificaciones.alertas')

<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<style>
/* ══ BASE ══ */
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

/* ══ HEADER ══ */
.tk-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 28px;
    gap: 12px;
    flex-wrap: wrap;
}
.tk-header-left h1 {
    font-size: 22px; font-weight: 700; color: #0a2540; margin: 0 0 3px;
}
.tk-header-left p {
    font-size: 13px; color: #64748b; margin: 0;
}
.tk-btn-new {
    display: flex; align-items: center; gap: 8px;
    background: linear-gradient(135deg, #1254a0, #1a6ed8);
    color: #fff; border: none;
    border-radius: 10px; padding: 11px 22px;
    font-size: 13.5px; font-weight: 600; cursor: pointer;
    box-shadow: 0 4px 14px rgba(26,110,216,.35);
    transition: opacity .15s, transform .15s;
    white-space: nowrap;
}
.tk-btn-new:hover { opacity: .9; transform: translateY(-1px); }

/* ══ TARJETAS KPI ══ */
.tk-cards {
    display: grid;
    grid-template-columns: repeat(6, 1fr);
    gap: 14px;
    margin-bottom: 24px;
}
.tk-card {
    background: #fff;
    border: 1.5px solid #e2eaf4;
    border-radius: 14px;
    padding: 18px 16px;
    cursor: pointer;
    transition: box-shadow .2s, transform .2s, border-color .2s;
    position: relative;
    overflow: hidden;
}
.tk-card::before {
    content: '';
    position: absolute; top: 0; left: 0; right: 0; height: 3px;
    border-radius: 14px 14px 0 0;
    background: var(--card-accent, #e2eaf4);
    transition: height .2s;
}
.tk-card:hover { box-shadow: 0 6px 20px rgba(10,37,80,.1); transform: translateY(-2px); }
.tk-card.card-active {
    border-color: var(--card-accent, #185FA5);
    box-shadow: 0 6px 20px rgba(24,95,165,.15);
}
.tk-card.card-active::before { height: 4px; }

.tk-card-icon {
    width: 36px; height: 36px; border-radius: 10px;
    display: flex; align-items: center; justify-content: center;
    font-size: 16px; margin-bottom: 12px;
    background: var(--card-icon-bg, #f0f4f8);
    color: var(--card-accent, #64748b);
}
.tk-card-label { font-size: 11px; color: #94a3b8; margin-bottom: 4px; font-weight: 500; text-transform: uppercase; letter-spacing: .04em; }
.tk-card-num   { font-size: 28px; font-weight: 700; color: #0a2540; line-height: 1; }
.tk-card-badge { font-size: 10.5px; padding: 3px 9px; border-radius: 20px; margin-top: 8px; display: inline-block; font-weight: 500; }

/* ══ TOOLBAR ══ */
.tk-toolbar {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 16px;
    flex-wrap: wrap;
}
.tk-search-wrap {
    display: flex; align-items: center; gap: 10px;
    background: #fff; border: 1.5px solid #e2eaf4;
    border-radius: 10px; padding: 9px 14px;
    flex: 1; min-width: 200px;
    transition: border-color .15s, box-shadow .15s;
}
.tk-search-wrap:focus-within {
    border-color: #185FA5;
    box-shadow: 0 0 0 3px rgba(24,95,165,.1);
}
.tk-search-wrap svg { color: #94a3b8; flex-shrink: 0; }
.tk-search-wrap input {
    border: none; outline: none; font-size: 13.5px;
    width: 100%; background: transparent; color: #0a2540; font-family: 'Inter', sans-serif;
}
.tk-search-wrap input::placeholder { color: #b0bec5; }
.tk-date-wrap {
    display: flex; align-items: center; gap: 8px;
    background: #fff; border: 1.5px solid #e2eaf4;
    border-radius: 10px; padding: 9px 14px;
    white-space: nowrap; transition: border-color .15s;
}
.tk-date-wrap:focus-within { border-color: #185FA5; }
.tk-date-wrap svg { color: #94a3b8; }
.tk-date-wrap input {
    border: none; outline: none; font-size: 13px;
    color: #0a2540; background: transparent; cursor: pointer;
    font-family: 'Inter', sans-serif;
}
.tk-btn-clear {
    display: flex; align-items: center; gap: 6px;
    background: #fff; border: 1.5px solid #e2eaf4;
    border-radius: 10px; padding: 9px 16px;
    font-size: 13px; color: #64748b; cursor: pointer;
    transition: all .15s; white-space: nowrap; font-family: 'Inter', sans-serif;
}
.tk-btn-clear:hover { background: #f8fafd; border-color: #c8d8ec; color: #0a2540; }

/* ══ TABLA ══ */
.tk-table-wrap {
    background: #fff;
    border: 1.5px solid #e2eaf4;
    border-radius: 14px;
    overflow: hidden;
}
.tk-table-header {
    display: flex; align-items: center; justify-content: space-between;
    padding: 16px 20px 0;
    gap: 10px; flex-wrap: wrap;
}
.tk-table-title {
    font-size: 13px; font-weight: 600; color: #0a2540;
    display: flex; align-items: center; gap: 8px;
}
.tk-total-badge {
    background: #EEF2FF; color: #4338ca;
    font-size: 11px; font-weight: 600;
    padding: 2px 8px; border-radius: 20px;
}
.tk-table-scroll {
    overflow-x: auto;
    -webkit-overflow-scrolling: touch;
    max-height: 460px;
    overflow-y: auto;
    margin-top: 14px;
}
.tk-table-scroll::-webkit-scrollbar { width: 5px; height: 5px; }
.tk-table-scroll::-webkit-scrollbar-track { background: #f8fafd; }
.tk-table-scroll::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
.tk-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 13px;
    min-width: 580px;
}
.tk-table thead { background: #f8fafd; position: sticky; top: 0; z-index: 1; }
.tk-table th {
    padding: 11px 16px; text-align: left;
    font-size: 11px; font-weight: 600; color: #94a3b8;
    border-bottom: 1.5px solid #e2eaf4;
    text-transform: uppercase; letter-spacing: .05em;
}
.tk-table td { padding: 12px 16px; border-bottom: 1px solid #f0f4fa; vertical-align: middle; }
.tk-table tbody tr { transition: background .12s; }
.tk-table tbody tr:hover td { background: #f8fafd; }
.tk-table tbody tr:last-child td { border-bottom: none; }

.tk-code-cell {
    font-family: 'Courier New', monospace; font-size: 12px;
    color: #185FA5; font-weight: 600;
    background: #EEF6FF; padding: 3px 8px; border-radius: 6px;
    display: inline-block;
}
.tk-asunto-cell { color: #0a2540; font-size: 13px; max-width: 280px; }
.tk-asunto-cell span { 
    display: block; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;
}

.btn-detalle {
    display: inline-flex; align-items: center; gap: 5px;
    background: #EEF6FF; color: #185FA5; border: 1px solid #c8dff8;
    border-radius: 8px; padding: 5px 12px;
    font-size: 12px; font-weight: 500; cursor: pointer;
    transition: all .15s; font-family: 'Inter', sans-serif;
}
.btn-detalle:hover { background: #185FA5; color: #fff; border-color: #185FA5; }

/* ══ EMPTY STATE ══ */
.tk-empty {
    text-align: center; padding: 3rem 1rem;
}
.tk-empty-icon {
    width: 56px; height: 56px; border-radius: 16px;
    background: #f0f4f8; margin: 0 auto 14px;
    display: flex; align-items: center; justify-content: center;
    color: #94a3b8; font-size: 22px;
}
.tk-empty p { color: #94a3b8; font-size: 13.5px; margin: 0; }

/* ══ ALERTAS ══ */
.tk-alert {
    display: flex; align-items: center; gap: 10px;
    border-radius: 10px; padding: 12px 16px; margin-bottom: 18px; font-size: 13px;
}
.tk-alert-ok  { background: #f0fdf4; border: 1px solid #bbf7d0; color: #166534; }
.tk-alert-err { background: #fef2f2; border: 1px solid #fecaca; color: #991b1b; }

/* ══ RESPONSIVE ══ */
@media (min-width: 769px) and (max-width: 1024px) {
    .tk-main  { margin-left: 0; padding-top: 68px; }
    .tk-inner { padding: 20px; }
    .tk-cards { grid-template-columns: repeat(3, 1fr); }
}
@media (max-width: 768px) {
    .tk-main  { margin-left: 0 !important; padding-top: 64px; }
    .tk-inner { padding: 14px; }
    .tk-header { flex-direction: column; align-items: stretch; }
    .tk-btn-new { width: 100%; justify-content: center; }
    .tk-cards { grid-template-columns: repeat(2, 1fr); gap: 10px; }
    .tk-card-num { font-size: 22px; }
    .tk-toolbar { flex-direction: column; align-items: stretch; }
    .tk-search-wrap, .tk-date-wrap, .tk-btn-clear { width: 100%; }
}
@media (max-width: 420px) {
    .tk-cards { grid-template-columns: 1fr 1fr; gap: 8px; }
    .tk-card  { padding: 12px; }
}

input[type="date"]::-webkit-calendar-picker-indicator { opacity:.5; cursor:pointer; }
</style>

<div class="tk-main">
<div class="tk-inner">

    {{-- Header --}}
    <div class="tk-header">
        <div class="tk-header-left">
            <h1>Panel Usuario</h1>
            <p>Gestiona y hace seguimiento de tus solicitudes de soporte</p>
        </div>
        <button type="button" class="tk-btn-new" onclick="abrirModalTicket()">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            Crear ticket
        </button>
    </div>

    {{-- Alertas --}}
    @if(session('success'))
        <div class="tk-alert tk-alert-ok">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="tk-alert tk-alert-err">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
            {{ session('error') }}
        </div>
    @endif

    {{-- Tarjetas KPI --}}
    <div class="tk-cards">

        <div class="tk-card card-active" id="card-all"
             style="--card-accent:#4338ca; --card-icon-bg:#EEF2FF;"
             onclick="setFilter('all')">
            <div class="tk-card-icon">
                <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>
            </div>
            <div class="tk-card-label">Total</div>
            <div class="tk-card-num">{{ $tickets->count() }}</div>
            <span class="tk-card-badge" style="background:#EEF2FF;color:#4338ca;">Todos</span>
        </div>

        <div class="tk-card" id="card-PENDIENTE"
             style="--card-accent:#7c3aed; --card-icon-bg:#F5F3FF;"
             onclick="setFilter('PENDIENTE')">
            <div class="tk-card-icon">
                <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
            </div>
            <div class="tk-card-label">Pendientes</div>
            <div class="tk-card-num">{{ $tickets->where('estado','PENDIENTE')->count() }}</div>
            <span class="tk-card-badge" style="background:#F5F3FF;color:#7c3aed;">Pendiente</span>
        </div>

        <div class="tk-card" id="card-PROGRAMADO"
             style="--card-accent:#3B82F6; --card-icon-bg:#EFF6FF;"
             onclick="setFilter('PROGRAMADO')">
            <div class="tk-card-icon">
                <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
            </div>
            <div class="tk-card-label">Programados</div>
            <div class="tk-card-num">{{ $tickets->where('estado','PROGRAMADO')->count() }}</div>
            <span class="tk-card-badge" style="background:#EFF6FF;color:#3B82F6;">Programado</span>
        </div>

        <div class="tk-card" id="card-EN PROCESO"
             style="--card-accent:#f97316; --card-icon-bg:#FFF7ED;"
             onclick="setFilter('EN PROCESO')">
            <div class="tk-card-icon">
                <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="23 4 23 10 17 10"/><path d="M20.49 15a9 9 0 1 1-2.12-9.36L23 10"/></svg>
            </div>
            <div class="tk-card-label">En proceso</div>
            <div class="tk-card-num">{{ $tickets->where('estado','EN PROCESO')->count() }}</div>
            <span class="tk-card-badge" style="background:#FFF7ED;color:#c2410c;">En proceso</span>
        </div>

        <div class="tk-card" id="card-CERRADO"
             style="--card-accent:#16a34a; --card-icon-bg:#F0FDF4;"
             onclick="setFilter('CERRADO')">
            <div class="tk-card-icon">
                <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
            </div>
            <div class="tk-card-label">Cerrados</div>
            <div class="tk-card-num">{{ $tickets->where('estado','CERRADO')->count() }}</div>
            <span class="tk-card-badge" style="background:#F0FDF4;color:#16a34a;">Cerrado</span>
        </div>

        <div class="tk-card" id="card-CANCELADO"
             style="--card-accent:#dc2626; --card-icon-bg:#FEF2F2;"
             onclick="setFilter('CANCELADO')">
            <div class="tk-card-icon">
                <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
            </div>
            <div class="tk-card-label">Cancelados</div>
            <div class="tk-card-num">{{ $tickets->where('estado','CANCELADO')->count() }}</div>
            <span class="tk-card-badge" style="background:#FEF2F2;color:#dc2626;">Cancelado</span>
        </div>

    </div>

    {{-- Tabla --}}
    <div class="tk-table-wrap">

        <div class="tk-table-header">
            <div class="tk-table-title">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#185FA5" stroke-width="2.5"><path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>
                Lista de tickets
                <span class="tk-total-badge" id="totalBadge">0</span>
            </div>

            <div class="tk-toolbar" style="margin-bottom:0;">
                <div class="tk-search-wrap">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                    <input type="text" id="searchInput" placeholder="Buscar por código o asunto..." oninput="renderTable()">
                </div>
                <div class="tk-date-wrap">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                    <input type="date" id="dateFilter" onchange="renderTable()">
                </div>
                <button class="tk-btn-clear" onclick="clearFilters()">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                    Limpiar
                </button>
            </div>
        </div>

        <div class="tk-table-scroll">
            <table class="tk-table">
                <thead>
                    <tr>
                        <th style="width:190px;">Código</th>
                        <th>Asunto</th>
                        <th style="width:120px;">Estado</th>
                        <th style="width:110px;">Prioridad</th>
                        <th style="width:110px;">Fecha</th>
                        <th style="width:100px;text-align:center;">Acciones</th>
                    </tr>
                </thead>
                <tbody id="ticketBody"></tbody>
            </table>
        </div>
    </div>

</div>
</div>

<script>
    const tickets = @json($tickets->values());
    let filtro = 'all';

    function clearFilters() {
        document.getElementById('searchInput').value = '';
        document.getElementById('dateFilter').value = '';
        renderTable();
    }

    function setFilter(s) {
        filtro = s;
        document.querySelectorAll('[id^="card-"]').forEach(el => el.classList.remove('card-active'));
        document.getElementById('card-' + s)?.classList.add('card-active');
        renderTable();
    }

    function badge(s) {
        const map = {
            'PENDIENTE':  { bg:'#F5F3FF', color:'#7c3aed', dot:'#7c3aed' },
            'PROGRAMADO': { bg:'#EFF6FF', color:'#1d4ed8', dot:'#3B82F6' },
            'EN PROCESO': { bg:'#FFF7ED', color:'#c2410c', dot:'#f97316' },
            'CERRADO':    { bg:'#F0FDF4', color:'#15803d', dot:'#22c55e' },
            'CANCELADO':  { bg:'#FEF2F2', color:'#b91c1c', dot:'#ef4444' },
        };
        const m = map[s] ?? { bg:'#f1f5f9', color:'#64748b', dot:'#94a3b8' };
        return `<span style="display:inline-flex;align-items:center;gap:5px;background:${m.bg};color:${m.color};font-size:11px;font-weight:600;padding:4px 10px;border-radius:20px;">
                    <span style="width:6px;height:6px;border-radius:50%;background:${m.dot};flex-shrink:0;"></span>${s}
                </span>`;
    }

    function priorityBadge(p, color) {
        if (!p) return '<span style="color:#c0cfe4;">—</span>';
        const hex = color || '#64748b';
        return `<span style="display:inline-flex;align-items:center;gap:5px;font-size:12px;font-weight:600;color:${hex};">
                    <span style="width:8px;height:8px;border-radius:50%;background:${hex};"></span>${p}
                </span>`;
    }

    function renderTable() {
        const q    = document.getElementById('searchInput').value.trim().toLowerCase();
        const date = document.getElementById('dateFilter').value;

        let pool = tickets.map((t, i) => ({ ...t, _idx: i }));

        if (filtro !== 'all') pool = pool.filter(t => t.estado === filtro);
        if (date)             pool = pool.filter(t => (t.created_at ?? '').substring(0,10) === date);
        if (q)                pool = pool.filter(t =>
                                    t.codigo_ticket.toLowerCase().includes(q) ||
                                    (t.asunto ?? '').toLowerCase().includes(q));

        document.getElementById('totalBadge').textContent = pool.length;

        const tbody = document.getElementById('ticketBody');

        if (!pool.length) {
            tbody.innerHTML = `
                <tr><td colspan="6">
                    <div class="tk-empty">
                        <div class="tk-empty-icon">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>
                        </div>
                        <p>Sin tickets que mostrar</p>
                    </div>
                </td></tr>`;
            return;
        }

        tbody.innerHTML = pool.map(t => `
            <tr>
                <td><span class="tk-code-cell">${t.codigo_ticket}</span></td>
                <td class="tk-asunto-cell"><span title="${t.asunto}">${t.asunto}</span></td>
                <td>${badge(t.estado)}</td>
                <td>${priorityBadge(t.prioridad_nombre, t.prioridad_color)}</td>
                <td style="color:#64748b;font-size:12.5px;">${(t.created_at ?? '').substring(0,10)}</td>
                <td style="text-align:center;">
                    <button class="btn-detalle" onclick="openModal(${t._idx})">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                        Ver
                    </button>
                </td>
            </tr>`).join('');
    }

    renderTable();
</script>
