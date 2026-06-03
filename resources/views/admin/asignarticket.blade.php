@include('components.admin.navbar-admin')
@include('components.admin.sidebar-admin')
@include('components.admin.modalcreartecnico')
@include('components.admin.modalcrearcliente')
@include('components.notificaciones.alertas')
@include('components.admin.detalleticket')
@include('components.admin.modalasignartecnico')

{{-- ══ GOOGLE FONTS ══ --}}
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,400;0,500;0,600;0,700;0,800;1,400&display=swap" rel="stylesheet">

<div class="main-content">
<div class="container-fluid">
    <div class="page-header">
        <div class="page-header-left">
            <div class="page-header-icon">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="3" y="3" width="7" height="7" rx="1.5"/>
                    <rect x="14" y="3" width="7" height="7" rx="1.5"/>
                    <rect x="14" y="14" width="7" height="7" rx="1.5"/>
                    <rect x="3" y="14" width="7" height="7" rx="1.5"/>
                </svg>
            </div>
            <div>
                <h1 class="page-title">Panel de Administración</h1>
                <p class="page-subtitle">Gestión global de clientes, usuarios y tickets</p>
            </div>
        </div>
    </div>

    <div class="breadcrumb-nav" id="breadcrumb-nav">
        <span class="bc-item active" id="bc-inicio" onclick="volverInicio()">
            <svg width="13" height="13" viewBox="0 0 24 24" fill="currentColor" style="flex-shrink:0;vertical-align:-1px">
                <path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z"/>
            </svg>
            Inicio
        </span>
        <span class="bc-sep" id="bc-sep-1" style="display:none">›</span>
        <span class="bc-item" id="bc-cliente" style="display:none"></span>
        <span class="bc-sep" id="bc-sep-2" style="display:none">›</span>
        <span class="bc-item" id="bc-usuario" style="display:none"></span>
    </div>

    <div class="stats-container" id="stats-global">
        <div class="stat-card stat-clientes" onclick="volverInicio()" style="cursor: pointer;" title="Ir a Clientes Registrados">
            <div class="stat-icon si-c">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="2" y="7" width="20" height="14" rx="2"/>
                    <path d="M16 21V5a2 2 0 00-2-2h-4a2 2 0 00-2 2v16"/>
                </svg>
            </div>
            <div class="stat-body">
                <span class="stat-value">{{ $clientes->count() }}</span>
                <span class="stat-label">Clientes</span>
            </div>
        </div>

        <div class="stat-card stat-total" onclick="filtrarTicketsGlobalStats('todos')" style="cursor: pointer;" title="Ver todos los tickets">
            <div class="stat-icon si-t">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M15 5v2M15 11v2M15 17v2M5 5h14a2 2 0 0 1 2 2v3a2 2 0 0 1 0 4v3a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-3a2 2 0 0 1 0-4V7a2 2 0 0 1 2-2z"/>
                </svg>
            </div>
            <div class="stat-body">
                <span class="stat-value">{{ $resumen['total'] }}</span>
                <span class="stat-label">Total Tickets</span>
            </div>
        </div>

        <div class="stat-card stat-pendiente" onclick="filtrarTicketsGlobalStats('PENDIENTE')" style="cursor: pointer;" title="Ver tickets pendientes">
            <div class="stat-icon" style="background: rgba(245,158,11,.10); color: #d97706;">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"/>
                    <polyline points="12 6 12 12 16 14"/>
                </svg>
            </div>
            <div class="stat-body">
                <span class="stat-value">{{ $resumen['pendiente'] }}</span>
                <span class="stat-label">Pendientes</span>
            </div>
        </div>

        <div class="stat-card stat-programado" onclick="filtrarTicketsGlobalStats('PROGRAMADO')" style="cursor: pointer;" title="Ver tickets programados">
            <div class="stat-icon" style="background: rgba(26,110,216,.10); color: #1a6ed8;">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
                    <line x1="16" y1="2" x2="16" y2="6"/>
                    <line x1="8" y1="2" x2="8" y2="6"/>
                    <line x1="3" y1="10" x2="21" y2="10"/>
                </svg>
            </div>
            <div class="stat-body">
                <span class="stat-value">{{ $resumen['programado'] }}</span>
                <span class="stat-label">Programados</span>
            </div>
        </div>

        <div class="stat-card stat-proceso" onclick="filtrarTicketsGlobalStats('EN PROCESO')" style="cursor: pointer;" title="Ver tickets en proceso">
            <div class="stat-icon" style="background: rgba(22,101,52,.10); color: #166534;">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"/>
                </svg>
            </div>
            <div class="stat-body">
                <span class="stat-value">{{ $resumen['en_proceso'] }}</span>
                <span class="stat-label">En Proceso</span>
            </div>
        </div>

        <div class="stat-card stat-cerrado" onclick="filtrarTicketsGlobalStats('CERRADO')" style="cursor: pointer;" title="Ver tickets cerrados">
            <div class="stat-icon" style="background: rgba(100,116,139,.10); color: #475569;">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                    <polyline points="22 4 12 14.01 9 11.01"/>
                </svg>
            </div>
            <div class="stat-body">
                <span class="stat-value">{{ $resumen['cerrado'] }}</span>
                <span class="stat-label">Cerrados</span>
            </div>
        </div>

        <div class="stat-card stat-cancelado" onclick="filtrarTicketsGlobalStats('CANCELADO')" style="cursor: pointer;" title="Ver tickets cancelados">
            <div class="stat-icon" style="background: rgba(153,27,27,.10); color: #991b1b;">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"/>
                    <line x1="15" y1="9" x2="9" y2="15"/>
                    <line x1="9" y1="9" x2="15" y2="15"/>
                </svg>
            </div>
            <div class="stat-body">
                <span class="stat-value">{{ $resumen['cancelado'] }}</span>
                <span class="stat-label">Cancelados</span>
            </div>
        </div>
    </div>

    <div id="panel-clientes">
        <div class="section-header">
            <div class="section-title-group">
                <div class="section-title-icon">
                    <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                        <circle cx="9" cy="7" r="4"/>
                        <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
                        <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                    </svg>
                </div>
                <h2 class="section-title">Clientes Registrados</h2>
            </div>
        </div>

        <div class="erp-toolbar">
            <div class="filter-section">
                <span class="filter-section-lbl">Estado</span>
                <div class="seg-ctrl">
                    <button class="filter-toggle active" data-cstatus="all" onclick="filtrarClientes(this)">
                        Todos <span class="ft-ct">{{ $clientes->count() }}</span>
                    </button>
                    <button class="filter-toggle" data-cstatus="activo" onclick="filtrarClientes(this)">
                        <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="9 12 11 14 15 10"/></svg>
                        Activos <span class="ft-ct">{{ $clientes->where('activo', 1)->count() }}</span>
                    </button>
                    <button class="filter-toggle" data-cstatus="inactivo" onclick="filtrarClientes(this)">
                        <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
                        Inactivos <span class="ft-ct">{{ $clientes->where('activo', 0)->count() }}</span>
                    </button>
                </div>
            </div>
            <div class="toolbar-search">
                <input type="text" class="search-input" placeholder="Buscar por razón social, RUC o correo..." id="buscar-cliente" onkeyup="aplicarFiltrosClientes()">
                <button class="btn-search" onclick="aplicarFiltrosClientes()">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                    Buscar
                </button>
            </div>
        </div>

        <div class="erp-table-container">
            <table class="erp-table">
                <thead>
                    <tr>
                        <th style="width:60px">Cód.</th>
                        <th>Razón Social</th>
                        <th>RUC</th>
                        <th>Correo</th>
                        <th>Rubro</th>
                        <th style="width:90px">Usuarios</th>
                        <th style="width:90px">Tickets</th>
                        <th style="width:100px">Estado</th>
                        <th style="width:140px">Acciones</th>
                    </tr>
                </thead>
                <tbody id="tbody-clientes">
                    @forelse($clientes as $cliente)
                    @php
                        $usuariosCliente = \App\Models\Usuario::where('id_cliente', $cliente->id_cliente)->get();
                        $totalUsuarios   = $usuariosCliente->count();
                        $ticketsCliente  = $tickets->where('id_cliente', $cliente->id_cliente);
                        $ticketCount     = $ticketsCliente->count();
                    @endphp
                    <tr data-id="{{ $cliente->id_cliente }}" data-status="{{ $cliente->activo ? 'activo' : 'inactivo' }}" data-search="{{ strtolower($cliente->razon_social . ' ' . $cliente->ruc . ' ' . $cliente->correo) }}">
                        <td class="cell-id">#{{ $cliente->id_cliente }}</td>
                        <td class="cell-name">
                            <div class="cliente-name-wrapper">
                                <div class="avatar-small avatar-empresa">{{ strtoupper(substr($cliente->razon_social, 0, 2)) }}</div>
                                <span>{{ Str::limit($cliente->razon_social, 40) }}</span>
                            </div>
                        </td>
                        <td>{{ $cliente->ruc ?? '—' }}</td>
                        <td>{{ Str::limit($cliente->correo ?? '—', 25) }}</td>
                        <td>{{ $cliente->rubro ?? '—' }}</td>
                        <td><span class="type-badge tb-c"><svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>{{ $totalUsuarios }}</span></td>
                        <td><span class="type-badge tb-t"><svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M15 5v2M15 11v2M15 17v2M5 5h14a2 2 0 0 1 2 2v3a2 2 0 0 1 0 4v3a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-3a2 2 0 0 1 0-4V7a2 2 0 0 1 2-2z"/></svg>{{ $ticketCount }}</span></td>
                        <td>
                            @if($cliente->activo)
                                <span class="badge-active"><span class="bdot"></span>Activo</span>
                            @else
                                <span class="badge-inactive"><span class="bdot"></span>Inactivo</span>
                            @endif
                        </td>
                        <td>
                            <div class="row-actions">
                                <button class="btn-action-sm" onclick="seleccionarCliente({{ $cliente->id_cliente }}, '{{ addslashes($cliente->razon_social) }}')">
                                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                                    Ver Usuarios
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr id="erp-empty-row-clientes">
                        <td colspan="9">
                            <div class="erp-empty-state">
                                <div class="erp-empty-ico">
                                    <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                                </div>
                                <p class="erp-empty-ttl">Sin clientes registrados</p>
                                <p class="erp-empty-desc">No hay clientes en el sistema.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div id="panel-usuarios" style="display:none">
        <div class="back-btn-row">
            <button class="btn-back" onclick="volverInicio()">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="15 18 9 12 15 6"/></svg>
                Volver a Clientes
            </button>
            <h2 class="section-title" id="titulo-usuarios">Usuarios</h2>
        </div>

        <div class="erp-toolbar">
            <div class="filter-section">
                <span class="filter-section-lbl">Estado</span>
                <div class="seg-ctrl">
                    <button class="filter-toggle active" data-ustatus="all" onclick="filtrarUsuarios(this)">
                        Todos <span class="ft-ct" id="count-utodos">0</span>
                    </button>
                    <button class="filter-toggle" data-ustatus="activo" onclick="filtrarUsuarios(this)">
                        <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="9 12 11 14 15 10"/></svg>
                        Activos <span class="ft-ct" id="count-uactivos">0</span>
                    </button>
                    <button class="filter-toggle" data-ustatus="inactivo" onclick="filtrarUsuarios(this)">
                        <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
                        Inactivos <span class="ft-ct" id="count-uinactivos">0</span>
                    </button>
                </div>
            </div>
            <div class="toolbar-search">
                <input type="text" class="search-input" placeholder="Buscar por nombre, DNI o correo..." id="buscar-usuario" onkeyup="aplicarFiltrosUsuarios()">
                <button class="btn-search" onclick="aplicarFiltrosUsuarios()">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                    Buscar
                </button>
            </div>
        </div>

        <div class="erp-table-container">
            <table class="erp-table">
                <thead>
                    <tr>
                        <th>Cód.</th>
                        <th>Nombre</th>
                        <th>DNI</th>
                        <th>Correo</th>
                        <th>Tickets</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody id="tbody-usuarios"></tbody>
            </table>
        </div>
    </div>

    <div id="panel-tickets" style="display:none">
        <div class="back-btn-row">
            <button class="btn-back" id="btn-back-tickets" onclick="volverInicio()">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="15 18 9 12 15 6"/></svg>
                Volver a Clientes
            </button>
            <h2 class="section-title" id="titulo-tickets">Tickets</h2>
        </div>

        <div class="erp-toolbar">
            <div class="filter-section">
                <span class="filter-section-lbl">Estado</span>
                <div class="seg-ctrl">
                    <button class="filter-toggle active" data-tstatus="todos" onclick="filtrarTicketsUI(this)">Todos <span class="ft-ct" id="count-ttodos">0</span></button>
                    <button class="filter-toggle" data-tstatus="PENDIENTE" onclick="filtrarTicketsUI(this)">Pendiente</button>
                    <button class="filter-toggle" data-tstatus="PROGRAMADO" onclick="filtrarTicketsUI(this)">Programado</button>
                    <button class="filter-toggle" data-tstatus="EN PROCESO" onclick="filtrarTicketsUI(this)">En Proceso</button>
                    <button class="filter-toggle" data-tstatus="CERRADO" onclick="filtrarTicketsUI(this)">Cerrado</button>
                    <button class="filter-toggle" data-tstatus="CANCELADO" onclick="filtrarTicketsUI(this)">Cancelado</button>
                </div>
            </div>
            <div class="toolbar-search">
                <input type="text" class="search-input" placeholder="Buscar por asunto, ID o cliente..." id="buscar-ticket" onkeyup="aplicarFiltrosTickets()">
                <button class="btn-search" onclick="aplicarFiltrosTickets()">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                    Buscar
                </button>
            </div>
        </div>

        <div class="erp-table-container">
            <table class="erp-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Asunto</th>
                        <th>Cliente</th>
                        <th>Estado</th>
                        <th>Prioridad</th>
                        <th>Fecha</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody id="tbody-tickets"></tbody>
            </table>
        </div>
    </div>

</div>
</div>

<script>
const USUARIOS_POR_CLIENTE = @json(\App\Models\Usuario::all()->groupBy('id_cliente')->map(fn($u) => $u->values()));
const TICKETS_POR_USUARIO = @json($tickets->groupBy('id_usuario')->map(fn($t) => $t->values()));
window._matTecnicosAll = @json($tecnicos);

let TODOS_LOS_TICKETS = [];
for (let uid in TICKETS_POR_USUARIO) {
    TODOS_LOS_TICKETS = TODOS_LOS_TICKETS.concat(TICKETS_POR_USUARIO[uid]);
}

let clienteActual = null;
let usuarioActual = null;
let filtroTicketActual = 'todos';
let filtroClienteActual = 'all';
let filtroUsuarioActual = 'all';
let viniendoDeUsuario = false;

// ─── FILTROS CLIENTES ─────────────────────────────────────────
function filtrarClientes(btn) {
    document.querySelectorAll('#panel-clientes .filter-toggle').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');
    filtroClienteActual = btn.getAttribute('data-cstatus');
    aplicarFiltrosClientes();
}

function aplicarFiltrosClientes() {
    const busqueda = document.getElementById('buscar-cliente').value.toLowerCase();
    const filas = document.querySelectorAll('#tbody-clientes tr[data-id]');
    let visibles = 0;
    filas.forEach(fila => {
        const estadoFila = fila.getAttribute('data-status');
        const textoFila = fila.getAttribute('data-search') || '';
        const coincideEstado = filtroClienteActual === 'all' || estadoFila === filtroClienteActual;
        const coincideBusqueda = !busqueda || textoFila.includes(busqueda);
        if (coincideEstado && coincideBusqueda) { fila.style.display = ''; visibles++; }
        else { fila.style.display = 'none'; }
    });
    const emptyRow = document.getElementById('erp-empty-row-clientes');
    if (emptyRow) emptyRow.style.display = visibles === 0 ? '' : 'none';
}

// ─── FILTROS USUARIOS ─────────────────────────────────────────
function filtrarUsuarios(btn) {
    document.querySelectorAll('#panel-usuarios .filter-toggle').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');
    filtroUsuarioActual = btn.getAttribute('data-ustatus');
    aplicarFiltrosUsuarios();
}

function aplicarFiltrosUsuarios() {
    const busqueda = document.getElementById('buscar-usuario').value.toLowerCase();
    const filas = document.querySelectorAll('#tbody-usuarios tr[data-id]');
    let visibles = 0;
    filas.forEach(fila => {
        const estadoFila = fila.getAttribute('data-activo') == 1 ? 'activo' : 'inactivo';
        const textoFila = fila.getAttribute('data-search') || '';
        const coincideEstado = filtroUsuarioActual === 'all' || estadoFila === filtroUsuarioActual;
        const coincideBusqueda = !busqueda || textoFila.includes(busqueda);
        if (coincideEstado && coincideBusqueda) { fila.style.display = ''; visibles++; }
        else { fila.style.display = 'none'; }
    });
    const emptyRow = document.getElementById('erp-empty-row-usuarios');
    if (emptyRow) emptyRow.style.display = visibles === 0 ? '' : 'none';
}

// ─── FILTROS TICKETS ─────────────────────────────────────────
function filtrarTicketsUI(btn) {
    document.querySelectorAll('#panel-tickets .filter-toggle').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');
    filtroTicketActual = btn.getAttribute('data-tstatus');
    aplicarFiltrosTickets();
}

function aplicarFiltrosTickets() {
    const busqueda = document.getElementById('buscar-ticket').value.toLowerCase();
    const filas = document.querySelectorAll('#tbody-tickets tr[data-id]');
    let visibles = 0;
    filas.forEach(fila => {
        const estadoFila = fila.getAttribute('data-estado');
        const textoFila = fila.getAttribute('data-search') || '';
        const coincideEstado = filtroTicketActual === 'todos' || estadoFila === filtroTicketActual;
        const coincideBusqueda = !busqueda || textoFila.includes(busqueda);
        if (coincideEstado && coincideBusqueda) { fila.style.display = ''; visibles++; }
        else { fila.style.display = 'none'; }
    });
    const emptyRow = document.getElementById('erp-empty-row-tickets');
    if (emptyRow) emptyRow.style.display = visibles === 0 ? '' : 'none';
}

// ─── NAVEGACIÓN ───────────────────────────────────────────────
function seleccionarCliente(idCliente, nombre) {
    clienteActual = idCliente;
    usuarioActual = null;
    viniendoDeUsuario = false;

    document.getElementById('bc-cliente').textContent = '🏢 ' + nombre;
    document.getElementById('bc-cliente').style.display = 'inline';
    document.getElementById('bc-sep-1').style.display   = 'inline';
    document.getElementById('bc-usuario').style.display  = 'none';
    document.getElementById('bc-sep-2').style.display    = 'none';
    document.getElementById('bc-inicio').classList.remove('active');
    document.getElementById('bc-cliente').classList.add('active');

    document.getElementById('panel-clientes').style.display = 'none';
    document.getElementById('panel-tickets').style.display   = 'none';
    document.getElementById('panel-usuarios').style.display  = '';
    document.getElementById('titulo-usuarios').textContent = 'Usuarios de ' + nombre;

    const usuarios = USUARIOS_POR_CLIENTE[idCliente] || [];
    renderUsuarios(usuarios);
}

function seleccionarUsuario(idUsuario, nombre) {
    usuarioActual = idUsuario;
    viniendoDeUsuario = true;

    document.getElementById('bc-usuario').textContent = '👤 ' + nombre;
    document.getElementById('bc-usuario').style.display = 'inline';
    document.getElementById('bc-sep-2').style.display   = 'inline';
    document.getElementById('bc-cliente').classList.remove('active');
    document.getElementById('bc-usuario').classList.add('active');

    document.getElementById('panel-usuarios').style.display = 'none';
    document.getElementById('panel-tickets').style.display  = '';
    document.getElementById('titulo-tickets').textContent = 'Tickets de ' + nombre;

    const btnBack = document.getElementById('btn-back-tickets');
    btnBack.innerHTML = `<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="15 18 9 12 15 6"/></svg> Volver a Usuarios`;
    btnBack.setAttribute('onclick', 'volverUsuarios()');

    const tickets = TICKETS_POR_USUARIO[idUsuario] || [];
    renderTickets(tickets, 'todos');
}

function volverInicio() {
    clienteActual = null;
    usuarioActual = null;
    viniendoDeUsuario = false;

    document.getElementById('panel-clientes').style.display  = '';
    document.getElementById('panel-usuarios').style.display   = 'none';
    document.getElementById('panel-tickets').style.display   = 'none';

    ['bc-sep-1','bc-cliente','bc-sep-2','bc-usuario'].forEach(id => {
        document.getElementById(id).style.display = 'none';
        document.getElementById(id).classList.remove('active');
    });
    document.getElementById('bc-inicio').classList.add('active');
}

function volverUsuarios() {
    usuarioActual = null;
    document.getElementById('panel-tickets').style.display  = 'none';
    document.getElementById('panel-usuarios').style.display = '';
    document.getElementById('bc-sep-2').style.display       = 'none';
    document.getElementById('bc-usuario').style.display     = 'none';
    document.getElementById('bc-usuario').classList.remove('active');
    document.getElementById('bc-cliente').classList.add('active');
}

// ─── RENDER USUARIOS ─────────────────────────────────────────
function renderUsuarios(usuarios) {
    const tbody = document.getElementById('tbody-usuarios');
    if (!usuarios.length) {
        tbody.innerHTML = `<tr id="erp-empty-row-usuarios"><td colspan="7"><div class="erp-empty-state"><div class="erp-empty-ico"><svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg></div><p class="erp-empty-ttl">Sin usuarios</p><p class="erp-empty-desc">Este cliente no tiene usuarios registrados.</p></div></td></tr>`;
        ['utodos','uactivos','uinactivos'].forEach(k => document.getElementById('count-'+k).textContent = '0');
        return;
    }

    let activos = 0, inactivos = 0;
    tbody.innerHTML = usuarios.map(u => {
        const tickets = TICKETS_POR_USUARIO[u.id_usuario] || [];
        const activo  = u.activo ? 'Activo' : 'Inactivo';
        const badgeClass = u.activo ? 'badge-active' : 'badge-inactive';
        const btnClass = u.activo ? 'btn-deactivate' : 'btn-activate';
        const btnText  = u.activo ? 'Desactivar' : 'Activar';
        if(u.activo) activos++; else inactivos++;

        return `<tr data-id="${u.id_usuario}" data-activo="${u.activo ? 1 : 0}" data-search="${(u.nombre + ' ' + u.apellido_paterno + ' ' + u.dni + ' ' + u.correo + ' ' + u.codigo_usuario).toLowerCase()}">
            <td class="cell-id">${u.codigo_usuario || '#' + u.id_usuario}</td>
            <td class="cell-name">${u.nombre} ${u.apellido_paterno}</td>
            <td>${u.dni || '—'}</td>
            <td>${u.correo || '—'}</td>
            <td><span class="type-badge tb-t"><svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M15 5v2M15 11v2M15 17v2M5 5h14a2 2 0 0 1 2 2v3a2 2 0 0 1 0 4v3a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-3a2 2 0 0 1 0-4V7a2 2 0 0 1 2-2z"/></svg>${tickets.length}</span></td>
            <td><span class="${badgeClass}"><span class="bdot"></span>${activo}</span></td>
            <td>
                <div class="row-actions">
                <button class="btn-action-sm" onclick="seleccionarUsuario(${u.id_usuario}, '${(u.nombre + ' ' + u.apellido_paterno).replace(/'/g, "\\'")}')">
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M15 5v2M15 11v2M15 17v2M5 5h14a2 2 0 0 1 2 2v3a2 2 0 0 1 0 4v3a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-3a2 2 0 0 1 0-4V7a2 2 0 0 1 2-2z"/></svg>
                Ver Tickets
                </button>
                </div>
                </td>
        </tr>`;
    }).join('');

    document.getElementById('count-utodos').textContent = usuarios.length;
    document.getElementById('count-uactivos').textContent = activos;
    document.getElementById('count-uinactivos').textContent = inactivos;
    filtroUsuarioActual = 'all';
    document.querySelectorAll('#panel-usuarios .filter-toggle').forEach(b => {
        b.classList.remove('active');
        if(b.getAttribute('data-ustatus') === 'all') b.classList.add('active');
    });
    aplicarFiltrosUsuarios();
}

// ── TOGGLE USUARIO (CORREGIDO) ──────────────────────────────
function toggleUsuario(id, activo) {
    // activo: 1 = está activo (lo vamos a desactivar → nuevoEstado = 0)
    //         0 = está inactivo (lo vamos a activar → nuevoEstado = 1)
    const nuevoEstado = activo ? 0 : 1;
    const accion = nuevoEstado ? 'activar' : 'desactivar';
    const titulo = nuevoEstado ? '¿Activar usuario?' : '¿Desactivar usuario?';

    ModalSystem.show('question', {
        title: titulo,
        text: `¿Estás seguro de que deseas ${accion} este usuario? Esta acción se puede revertir.`,
        confirmText: 'Sí, continuar',
        cancelText: 'Cancelar',
        onConfirm: async () => {
            try {
                const res = await fetch(`/admin/usuarios/${id}/toggle`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    // ✅ CLAVE: enviar el nuevo estado en el body
                    body: JSON.stringify({ activo: nuevoEstado })
                });

                const data = await res.json();

                if (data.ok) {
                    showNotification('success', '¡Éxito!', `Usuario ${accion}do correctamente.`);

                    // Actualizar la vista si hay un cliente seleccionado
                    if (clienteActual) {
                        const nombre = document.getElementById('bc-cliente').textContent.replace('🏢 ', '');
                        seleccionarCliente(clienteActual, nombre);
                    }
                } else {
                    showNotification('danger', 'Error', data.message || `No se pudo ${accion} el usuario.`);
                }
            } catch (err) {
                console.error('Error al togglear usuario:', err);
                showNotification('danger', 'Error de conexión', 'No se pudo conectar con el servidor.');
            }
        }
    });
}

function ejecutarToggle(id, nuevoEstado, accionVerbo) {
    console.log('📡 Enviando toggle:', { id, nuevoEstado });

    fetch(`/admin/usuarios/${id}/toggle`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content 
                         || document.querySelector('meta[name="_token"]')?.content
                         || '{{ csrf_token() }}'
        },
        body: JSON.stringify({ activo: nuevoEstado })
    })
    .then(res => {
        console.log('📥 Respuesta status:', res.status);
        if (!res.ok) throw new Error(`HTTP ${res.status}`);
        return res.json();
    })
    .then(data => {
        console.log('✅ Data recibida:', data);
        if (data.ok || data.success) {
            if (typeof showNotification !== 'undefined') {
                showNotification('success', '¡Éxito!', `Usuario ${accionVerbo}do correctamente.`);
            }
            actualizarFilaUsuario(id, nuevoEstado);
        } else {
            const msg = data.message || `No se pudo ${accionVerbo} el usuario.`;
            if (typeof showNotification !== 'undefined') {
                showNotification('danger', 'Error', msg);
            } else {
                alert(msg);
            }
        }
    })
    .catch(err => {
        console.error('❌ Error en toggle:', err);
        if (typeof showNotification !== 'undefined') {
            showNotification('danger', 'Error de conexión', 'No se pudo conectar con el servidor.');
        } else {
            alert('Error de conexión: ' + err.message);
        }
    });
}

function actualizarFilaUsuario(id, nuevoEstado) {
    const fila = document.querySelector(`#tbody-usuarios tr[data-id="${id}"]`);
    if (!fila) {
        console.warn('No se encontró la fila del usuario', id);
        return;
    }

    // Actualizar atributo data-activo
    fila.setAttribute('data-activo', nuevoEstado);

    // Actualizar badge (columna 6)
    const badgeTd = fila.querySelector('td:nth-child(6)');
    if (badgeTd) {
        const texto = nuevoEstado ? 'Activo' : 'Inactivo';
        const clase = nuevoEstado ? 'badge-active' : 'badge-inactive';
        badgeTd.innerHTML = `<span class="${clase}"><span class="bdot"></span>${texto}</span>`;
    }

    // Actualizar botón (columna 7, último botón)
    const btn = fila.querySelector('td:nth-child(7) .row-actions .btn-action-sm:last-child');
    if (btn) {
        const textoBtn = nuevoEstado ? 'Activar' : 'Desactivar';
        const claseBtn = nuevoEstado ? 'btn-activate' : 'btn-deactivate';
        btn.className = `btn-action-sm ${claseBtn}`;
        btn.textContent = textoBtn;
        // Reasignar onclick con el NUEVO estado para que el próximo click haga lo contrario
        btn.setAttribute('onclick', `toggleUsuario(${id}, ${nuevoEstado})`);
    }

    // Actualizar contadores
    actualizarContadoresUsuarios(nuevoEstado);

    // Reaplicar filtros
    aplicarFiltrosUsuarios();
}

function actualizarContadoresUsuarios(nuevoEstado) {
    const cActivos = document.getElementById('count-uactivos');
    const cInactivos = document.getElementById('count-uinactivos');
    const cTodos = document.getElementById('count-utodos');
    
    if (cActivos && cInactivos) {
        let a = parseInt(cActivos.textContent) || 0;
        let i = parseInt(cInactivos.textContent) || 0;
        if (nuevoEstado) { a++; i = Math.max(0, i - 1); } 
        else { i++; a = Math.max(0, a - 1); }
        cActivos.textContent = a;
        cInactivos.textContent = i;
        if (cTodos) cTodos.textContent = a + i;
    }
}

// ─── RENDER TICKETS ──────────────────────────────────────────
function renderTickets(tickets, filtroInicial) {
    const tbody = document.getElementById('tbody-tickets');
    if (!tickets.length) {
        tbody.innerHTML = `<tr id="erp-empty-row-tickets"><td colspan="7"><div class="erp-empty-state"><div class="erp-empty-ico"><svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg></div><p class="erp-empty-ttl">Sin tickets</p><p class="erp-empty-desc">No hay tickets para este usuario.</p></div></td></tr>`;
        ['todos','PENDIENTE','PROGRAMADO','EN PROCESO','CERRADO','CANCELADO'].forEach(k => { const el = document.getElementById('count-t'+k); if(el) el.textContent = '0'; });
        return;
    }

    let counts = { todos: 0, PENDIENTE: 0, PROGRAMADO: 0, 'EN PROCESO': 0, CERRADO: 0, CANCELADO: 0 };
    tbody.innerHTML = tickets.map(t => {
        counts['todos']++;
        if(counts[t.estado] !== undefined) counts[t.estado]++;

        const estadoClass = t.estado === 'PENDIENTE' ? 'badge-pendiente' : 
                            t.estado === 'PROGRAMADO' ? 'badge-programado' :
                            t.estado === 'EN PROCESO' ? 'badge-proceso' :
                            t.estado === 'CERRADO' ? 'badge-cerrado' : 'badge-cancelado';
        const prioColor = t.prioridad_color ? `background:${t.prioridad_color}20;color:${t.prioridad_color};border:1px solid ${t.prioridad_color}40` : '';
        const fecha = t.created_at ? new Date(t.created_at).toLocaleDateString('es-PE', { day: '2-digit', month: 'short', year: 'numeric' }) : '—';

        const btnAsignar = t.estado === 'PENDIENTE' ? `<button class="btn-action-sm" onclick="abrirAsignar(${t.id_ticket}, this)">🔧 Asignar</button>` : '';
        const btnCancelar = t.estado === 'PROGRAMADO' ? `<button class="btn-action-sm btn-deactivate" onclick="cancelarTicket(${t.id_ticket})">❌ Cancelar</button>` : '';

        return `<tr data-id="${t.id_ticket}" data-estado="${t.estado}" data-search="${(t.asunto + ' ' + t.razon_social + ' ' + t.id_ticket).toLowerCase()}">
            <td class="cell-id">#${t.id_ticket}</td>
            <td class="cell-name">${t.asunto || 'Sin asunto'}</td>
            <td>${t.razon_social || '—'}</td>
            <td><span class="${estadoClass}"><span class="bdot"></span>${t.estado}</span></td>
            <td><span class="type-badge" style="${prioColor}">${t.prioridad_nombre || 'Normal'}</span></td>
            <td>${fecha}</td>
            <td>
                <div class="row-actions">
                    <button class="btn-action-sm" onclick="verDetalleTicket(${t.id_ticket})">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                        Detalle
                    </button>
                    ${btnAsignar}
                    ${btnCancelar}
                </div>
            </td>
        </tr>`;
    }).join('');

    ['todos','PENDIENTE','PROGRAMADO','EN PROCESO','CERRADO','CANCELADO'].forEach(k => {
        const el = document.getElementById('count-t'+k);
        if(el) el.textContent = counts[k];
    });

    filtroTicketActual = filtroInicial || 'todos';
    document.querySelectorAll('#panel-tickets .filter-toggle').forEach(b => {
        b.classList.remove('active');
        if(b.getAttribute('data-tstatus') === filtroTicketActual) b.classList.add('active');
    });
    aplicarFiltrosTickets();
}

function filtrarTicketsGlobalStats(estado) {
    clienteActual = null;
    usuarioActual = null;
    viniendoDeUsuario = false;

    document.getElementById('panel-clientes').style.display = 'none';
    document.getElementById('panel-usuarios').style.display = 'none';
    document.getElementById('panel-tickets').style.display = '';

    document.getElementById('bc-inicio').classList.remove('active');
    document.getElementById('bc-cliente').style.display = 'none';
    document.getElementById('bc-sep-1').style.display = 'none';
    document.getElementById('bc-usuario').style.display = 'none';
    document.getElementById('bc-sep-2').style.display = 'none';

    const titulo = estado === 'todos' ? 'Todos los Tickets' : 'Tickets ' + estado.charAt(0).toUpperCase() + estado.slice(1).toLowerCase();
    document.getElementById('titulo-tickets').textContent = titulo;

    const btnBack = document.getElementById('btn-back-tickets');
    btnBack.innerHTML = `<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="15 18 9 12 15 6"/></svg> Volver a Clientes`;
    btnBack.setAttribute('onclick', 'volverInicio()');

    renderTicketsGlobal(TODOS_LOS_TICKETS, estado);
}

function renderTicketsGlobal(tickets, filtroInicial) {
    const tbody = document.getElementById('tbody-tickets');
    if (!tickets.length) {
        tbody.innerHTML = `<tr id="erp-empty-row-tickets"><td colspan="7"><div class="erp-empty-state"><div class="erp-empty-ico"><svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg></div><p class="erp-empty-ttl">Sin tickets</p><p class="erp-empty-desc">No hay tickets que coincidan.</p></div></td></tr>`;
        ['todos','PENDIENTE','PROGRAMADO','EN PROCESO','CERRADO','CANCELADO'].forEach(k => { const el = document.getElementById('count-t'+k); if(el) el.textContent = '0'; });
        return;
    }

    let counts = { todos: 0, PENDIENTE: 0, PROGRAMADO: 0, 'EN PROCESO': 0, CERRADO: 0, CANCELADO: 0 };
    tbody.innerHTML = tickets.map(t => {
        counts['todos']++;
        if(counts[t.estado] !== undefined) counts[t.estado]++;

        const estadoClass = t.estado === 'PENDIENTE' ? 'badge-pendiente' : 
                            t.estado === 'PROGRAMADO' ? 'badge-programado' :
                            t.estado === 'EN PROCESO' ? 'badge-proceso' :
                            t.estado === 'CERRADO' ? 'badge-cerrado' : 'badge-cancelado';
        const prioColor = t.prioridad_color ? `background:${t.prioridad_color}20;color:${t.prioridad_color};border:1px solid ${t.prioridad_color}40` : '';
        const fecha = t.created_at ? new Date(t.created_at).toLocaleDateString('es-PE', { day: '2-digit', month: 'short', year: 'numeric' }) : '—';

        const btnAsignar = t.estado === 'PENDIENTE' ? `<button class="btn-action-sm" onclick="abrirAsignar(${t.id_ticket}, this, ${t.id_usuario})">🔧 Asignar</button>` : '';
        const btnCancelar = t.estado === 'PROGRAMADO' ? `<button class="btn-action-sm btn-deactivate" onclick="cancelarTicket(${t.id_ticket}, ${t.id_usuario})">❌ Cancelar</button>` : '';

        return `<tr data-id="${t.id_ticket}" data-estado="${t.estado}" data-search="${(t.asunto + ' ' + t.razon_social + ' ' + t.id_ticket).toLowerCase()}">
            <td class="cell-id">#${t.id_ticket}</td>
            <td class="cell-name">${t.asunto || 'Sin asunto'}</td>
            <td>${t.razon_social || '—'}</td>
            <td><span class="${estadoClass}"><span class="bdot"></span>${t.estado}</span></td>
            <td><span class="type-badge" style="${prioColor}">${t.prioridad_nombre || 'Normal'}</span></td>
            <td>${fecha}</td>
            <td>
                <div class="row-actions">
                    <button class="btn-action-sm" onclick="verDetalleTicket(${t.id_ticket})">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                        Detalle
                    </button>
                    ${btnAsignar}
                    ${btnCancelar}
                </div>
            </td>
        </tr>`;
    }).join('');

    ['todos','PENDIENTE','PROGRAMADO','EN PROCESO','CERRADO','CANCELADO'].forEach(k => {
        const el = document.getElementById('count-t'+k);
        if(el) el.textContent = counts[k];
    });

    filtroTicketActual = filtroInicial || 'todos';
    document.querySelectorAll('#panel-tickets .filter-toggle').forEach(b => {
        b.classList.remove('active');
        if(b.getAttribute('data-tstatus') === filtroTicketActual) b.classList.add('active');
    });
    aplicarFiltrosTickets();
}

// ─── ACCIONES ────────────────────────────────────────────────
function abrirAsignar(idTicket, btnEl, idUsuarioOverride = null) {
    const uid = idUsuarioOverride || usuarioActual;
    const tickets = uid ? (TICKETS_POR_USUARIO[uid] || []) : TODOS_LOS_TICKETS;
    const t = tickets.find(x => x.id_ticket == idTicket);
    if (!t) return;
    window._matTicketUserId = t.id_usuario;

    if(typeof abrirModalAsignar === 'function') {
        abrirModalAsignar(t.id_ticket, t.asunto, t.razon_social || '—', t.usuario_nombre || '—', t.prioridad_nombre || null, t.prioridad_color || null, t.codigo_ticket || ('#' + t.id_ticket));
    }
}

function cancelarTicket(idTicket, idUsuarioOverride = null) {
    const uid = idUsuarioOverride || usuarioActual;

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
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json'
                    }
                });
                const data = await res.json();

                if (data.ok) {
                    showNotification('success', '¡Éxito!', 'El ticket ha sido cancelado correctamente.');
                    setTimeout(() => location.reload(), 1200);
                }else {
                    showNotification('danger', 'Error', data.message || 'No se pudo cancelar el ticket.');
                }
            } catch (err) {
                console.error('Error al cancelar:', err);
                showNotification('danger', 'Error de conexión', 'Ocurrió un error al intentar cancelar el ticket.');
            }
        }
    });
}

function verDetalleTicket(idTicket) {
    if (typeof abrirDetalleTicket === 'function') { 
        abrirDetalleTicket(idTicket); 
        return; 
    }
    if (typeof abrirModalDetalleTicket === 'function') { 
        abrirModalDetalleTicket(idTicket); 
        return; 
    }
    const modal = document.getElementById('modalDetalleTicket') || document.getElementById('modal-ver-detalle');
    if (modal) {
        fetch(`/ticket/${idTicket}/detalle`) 
        .then(response => response.json())
        .then(ticket => {
            const contenido = document.getElementById('detalleTicketContenido');
            if (contenido) {
                contenido.innerHTML = `<h3>Ticket #${ticket.id_ticket}</h3><p><strong>Asunto:</strong> ${ticket.asunto || 'Sin asunto'}</p><p><strong>Estado:</strong> ${ticket.estado}</p>`;
            }
            modal.style.display = 'flex';
        })
        .catch(err => {
            console.error("Error al obtener detalle: ", err);
            showNotification('danger', 'Error', 'No se pudo cargar el detalle del ticket.');
        });
    } else {
        console.warn("No se encontró el modal de detalle.");
    }
}

document.getElementById('bc-cliente').addEventListener('click', function() {
    if (!clienteActual) return;
    volverUsuarios();
});
</script>

<style>
:root {
    --erp-bg: #f1f4f8; --erp-card: #ffffff; --erp-text: #0f172a; --erp-text-2: #334155; --erp-muted: #64748b;
    --erp-border: #e2e8f0; --erp-border-li: #f1f5f9;
    --erp-primary: #0f4a8a; --erp-primary-h: #1a6ed8; --erp-primary-bg: #eff6ff;
    --erp-success: #166534; --erp-success-bg: #f0fdf4;
    --erp-danger: #991b1b; --erp-danger-bg: #fef2f2;
    --erp-teal: #0f766e; --erp-teal-bg: #f0fdfa;
    --erp-violet: #5b21b6; --erp-violet-bg: #f5f3ff;
    --erp-radius: 6px;
    --erp-shadow: 0 1px 2px rgba(0,0,0,0.05), 0 1px 3px rgba(0,0,0,0.07);
    --erp-shadow-md: 0 4px 6px -1px rgba(0,0,0,0.07), 0 2px 4px rgba(0,0,0,0.04);
}

.main-content { margin-left: 260px; padding: 34px 32px; background: var(--erp-bg); min-height: 100vh; font-family: 'Plus Jakarta Sans', -apple-system, system-ui, sans-serif; transition: margin-left 0.35s ease; box-sizing: border-box; }
body.sb-collapsed .main-content { margin-left: 70px; }

.page-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 22px; padding: 18px 22px; background: var(--erp-card); border-radius: var(--erp-radius); border: 1px solid var(--erp-border); box-shadow: var(--erp-shadow); gap: 16px; flex-wrap: wrap; }
.page-header-left { display: flex; align-items: center; gap: 14px; }
.page-header-icon { width: 46px; height: 46px; background: linear-gradient(135deg, var(--erp-primary) 0%, var(--erp-primary-h) 100%); border-radius: 7px; display: flex; align-items: center; justify-content: center; color: #fff; box-shadow: 0 4px 14px rgba(15,74,138,.25); flex-shrink: 0; }
.page-title { font-size: 1.375rem; font-weight: 700; color: var(--erp-text); margin: 0; letter-spacing: -0.015em; line-height: 1.2; }
.page-subtitle { font-size: 0.875rem; color: var(--erp-muted); margin: 3px 0 0; font-weight: 500; }

.breadcrumb-nav { display: flex; align-items: center; gap: 4px; margin-bottom: 22px; padding: 7px 10px; background: var(--erp-card); border: 1px solid var(--erp-border); border-radius: 9999px; font-size: 13px; font-weight: 600; box-shadow: var(--erp-shadow); width: fit-content; flex-wrap: wrap; }
.bc-item { cursor: pointer; padding: 5px 13px; border-radius: 9999px; transition: all .14s ease; color: var(--erp-muted); display: inline-flex; align-items: center; gap: 5px; }
.bc-item:hover { background: var(--erp-border-li); color: var(--erp-text-2); }
.bc-item.active { background: linear-gradient(135deg, var(--erp-primary) 0%, var(--erp-primary-h) 100%); color: #fff; box-shadow: 0 2px 10px rgba(15,74,138,.28); }
.bc-sep { color: var(--erp-muted); font-size: 17px; line-height: 1; padding: 0 2px; user-select: none; }

.stats-container { display: grid; grid-template-columns: repeat(auto-fill, minmax(148px, 1fr)); gap: 10px; margin-bottom: 14px; }
.stat-card { display: flex; align-items: center; gap: 12px; background: var(--erp-card); border: 1px solid var(--erp-border); border-radius: var(--erp-radius); padding: 12px 16px; box-shadow: var(--erp-shadow); transition: box-shadow .15s, border-color .15s; animation: fadeInUp 0.45s ease backwards; position: relative; overflow: hidden; min-width: 0; cursor: pointer; }
.stat-card:hover { box-shadow: var(--erp-shadow-md); border-color: var(--erp-primary-h); }
.stat-icon { display: flex; align-items: center; justify-content: center; width: 34px; height: 34px; border-radius: 7px; flex-shrink: 0; }
.stat-icon.si-c { background: var(--erp-primary-bg); color: var(--erp-primary-h); }
.stat-icon.si-t { background: var(--erp-violet-bg); color: var(--erp-violet); }
.stat-body { display: flex; flex-direction: column; gap: 1px; }
.stat-value { font-size: 1.25rem; font-weight: 700; color: var(--erp-text); line-height: 1; }
.stat-label { font-size: 0.725rem; color: var(--erp-muted); font-weight: 500; letter-spacing: .01em; }
.stat-card:nth-child(1) { animation-delay: .04s; } .stat-card:nth-child(2) { animation-delay: .09s; }
.stat-card:nth-child(3) { animation-delay: .14s; } .stat-card:nth-child(4) { animation-delay: .19s; }
.stat-card:nth-child(5) { animation-delay: .24s; } .stat-card:nth-child(6) { animation-delay: .29s; }
.stat-card:nth-child(7) { animation-delay: .34s; }

.section-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 20px; gap: 14px; flex-wrap: wrap; }
.section-title-group { display: flex; align-items: center; gap: 10px; }
.section-title-icon { width: 36px; height: 36px; background: var(--erp-primary-bg); color: var(--erp-primary); border-radius: var(--erp-radius); display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
.section-title { font-size: 1.125rem; font-weight: 700; color: var(--erp-text); margin: 0; letter-spacing: -0.015em; }
.back-btn-row { display: flex; align-items: center; gap: 14px; margin-bottom: 20px; flex-wrap: wrap; }
.btn-back { display: inline-flex; align-items: center; gap: 6px; background: var(--erp-card); border: 1px solid var(--erp-border); color: var(--erp-text-2); padding: 8px 15px; border-radius: var(--erp-radius); cursor: pointer; font-size: 0.8125rem; font-weight: 600; transition: all .15s ease; white-space: nowrap; }
.btn-back:hover { background: var(--erp-primary-bg); color: var(--erp-primary); border-color: var(--erp-primary-h); transform: translateX(-2px); }

.erp-toolbar { background: var(--erp-card); border: 1px solid var(--erp-border); border-radius: var(--erp-radius); padding: 11px 16px; margin-bottom: 14px; box-shadow: var(--erp-shadow); display: flex; flex-wrap: wrap; gap: 12px; align-items: center; }
.filter-section { display: flex; align-items: center; gap: 8px; }
.filter-section-lbl { font-size: 0.675rem; font-weight: 700; color: var(--erp-muted); text-transform: uppercase; letter-spacing: .07em; white-space: nowrap; }
.seg-ctrl { display: inline-flex; background: var(--erp-bg); border: 1px solid var(--erp-border); border-radius: 7px; padding: 3px; gap: 2px; }
.filter-toggle { display: inline-flex; align-items: center; gap: 5px; padding: 5px 11px; border-radius: 5px; font-size: 0.7875rem; font-weight: 500; cursor: pointer; border: none; background: transparent; color: var(--erp-muted); transition: all .15s ease; white-space: nowrap; line-height: 1.15; }
.filter-toggle:hover { background: rgba(255,255,255,.75); color: var(--erp-text-2); }
.filter-toggle.active { background: var(--erp-card); color: var(--erp-primary); font-weight: 600; box-shadow: 0 1px 3px rgba(0,0,0,.09), 0 1px 2px rgba(0,0,0,.05); }
.ft-ct { display: inline-flex; align-items: center; justify-content: center; min-width: 17px; height: 17px; padding: 0 4px; border-radius: 9px; font-size: 0.67rem; font-weight: 700; background: #e9edf3; color: var(--erp-muted); transition: all .15s; margin-left: 1px; }
.filter-toggle.active .ft-ct { background: var(--erp-primary-bg); color: var(--erp-primary-h); }

.toolbar-search { display: flex; align-items: center; gap: 7px; margin-left: auto; }
.toolbar-search .search-input { border: 1px solid var(--erp-border); border-radius: var(--erp-radius); padding: 7px 12px 7px 34px; font-size: 0.84rem; width: 260px; outline: none; background: var(--erp-bg) url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='13' height='13' viewBox='0 0 24 24' fill='none' stroke='%2394a3b8' stroke-width='2.2' stroke-linecap='round'%3E%3Ccircle cx='11' cy='11' r='8'/%3E%3Cline x1='21' y1='21' x2='16.65' y2='16.65'/%3E%3C/svg%3E") 10px center no-repeat; color: var(--erp-text); transition: border-color .15s, box-shadow .15s, background-color .15s; }
.toolbar-search .search-input:focus { border-color: var(--erp-primary-h); box-shadow: 0 0 0 3px rgba(26,110,216,.1); background-color: #fff; }
.toolbar-search .search-input::placeholder { color: #94a3b8; }
.toolbar-search .btn-search { background: var(--erp-primary); color: #fff; border: 1px solid var(--erp-primary); border-radius: var(--erp-radius); padding: 7px 14px; font-size: 0.8125rem; font-weight: 600; cursor: pointer; display: inline-flex; align-items: center; gap: 6px; transition: background .15s; white-space: nowrap; }
.toolbar-search .btn-search:hover { background: var(--erp-primary-h); border-color: var(--erp-primary-h); }

.erp-table-container { background: var(--erp-card); border: 1px solid var(--erp-border); border-radius: var(--erp-radius); box-shadow: var(--erp-shadow); overflow-x: auto; overflow-y: hidden; }
.erp-table { width: 100%; border-collapse: collapse; }
.erp-table thead { background: #f8fafc; border-bottom: 2px solid var(--erp-border); }
.erp-table th { padding: 10px 16px; text-align: left; font-size: 0.69rem; font-weight: 700; color: var(--erp-muted); text-transform: uppercase; letter-spacing: .065em; }
.erp-table td { padding: 11px 16px; border-bottom: 1px solid var(--erp-border-li); font-size: 0.875rem; color: var(--erp-text); vertical-align: middle; }
.erp-table tbody tr:last-child td { border-bottom: none; }
.erp-table tbody tr:hover { background: #f8fbff; }

.cell-id { font-size: 0.775rem; font-weight: 600; color: var(--erp-muted); font-variant-numeric: tabular-nums; letter-spacing: .01em; }
.cell-name { font-weight: 500; color: var(--erp-text); }
.cliente-name-wrapper { display: flex; align-items: center; gap: 10px; }
.avatar-small { width: 32px; height: 32px; background: linear-gradient(135deg, #eff6ff 0%, #f0f9ff 100%); color: var(--erp-primary); font-size: 11px; font-weight: 800; display: flex; align-items: center; justify-content: center; border-radius: 50%; flex-shrink: 0; border: 2px solid #fff; box-shadow: 0 2px 6px rgba(15,74,138,.15); }

.type-badge { display: inline-flex; align-items: center; gap: 5px; padding: 3px 8px 3px 5px; border-radius: 4px; font-size: 0.73rem; font-weight: 600; letter-spacing: .01em; line-height: 1; }
.type-badge svg { flex-shrink: 0; }
.type-badge.tb-c { background: var(--erp-primary-bg); color: var(--erp-primary-h); }
.type-badge.tb-t { background: var(--erp-violet-bg); color: var(--erp-violet); }

.badge-active, .badge-inactive, .badge-pendiente, .badge-programado, .badge-proceso, .badge-cerrado, .badge-cancelado { display: inline-flex; align-items: center; gap: 5px; padding: 3px 8px; border-radius: 4px; font-size: 0.73rem; font-weight: 600; line-height: 1; }
.badge-active   { background: var(--erp-success-bg); color: var(--erp-success); }
.badge-inactive { background: var(--erp-danger-bg); color: var(--erp-danger); }
.badge-pendiente { background: rgba(245,158,11,.12); color: #d97706; border: 1px solid rgba(245,158,11,.28); }
.badge-programado { background: rgba(26,110,216,.12); color: var(--erp-primary-h); border: 1px solid rgba(26,110,216,.28); }
.badge-proceso { background: rgba(22,101,52,.12); color: var(--erp-success); border: 1px solid rgba(22,101,52,.28); }
.badge-cerrado { background: rgba(100,116,139,.10); color: #475569; border: 1px solid rgba(100,116,139,.22); }
.badge-cancelado { background: var(--erp-danger-bg); color: var(--erp-danger); border: 1px solid rgba(153,27,27,.22); }

.bdot { display: inline-block; width: 5px; height: 5px; border-radius: 50%; flex-shrink: 0; }
.badge-active .bdot { background: var(--erp-success); }
.badge-inactive .bdot { background: var(--erp-danger); }
.badge-pendiente .bdot { background: #d97706; }
.badge-programado .bdot { background: var(--erp-primary-h); }
.badge-proceso .bdot { background: var(--erp-success); }
.badge-cerrado .bdot { background: #475569; }
.badge-cancelado .bdot { background: var(--erp-danger); }

.row-actions { display: flex; gap: 5px; align-items: center; flex-wrap: nowrap; }
.btn-action-sm { display: inline-flex; align-items: center; gap: 5px; padding: 4px 10px; border-radius: 5px; font-size: 0.775rem; font-weight: 500; cursor: pointer; border: 1px solid var(--erp-border); background: var(--erp-card); color: var(--erp-muted); transition: all .15s ease; white-space: nowrap; line-height: 1; }
.btn-action-sm:hover { border-color: var(--erp-primary-h); color: var(--erp-primary); background: var(--erp-primary-bg); }
.btn-action-sm.btn-deactivate:hover { border-color: var(--erp-danger); color: var(--erp-danger); background: var(--erp-danger-bg); }
.btn-action-sm.btn-activate:hover { border-color: var(--erp-success); color: var(--erp-success); background: var(--erp-success-bg); }

.erp-empty-state { display: flex; flex-direction: column; align-items: center; padding: 56px 24px; text-align: center; color: var(--erp-muted); }
.erp-empty-ico { color: #cbd5e1; margin-bottom: 14px; }
.erp-empty-ttl { font-size: 0.9375rem; font-weight: 600; color: var(--erp-text-2); margin: 0 0 4px; }
.erp-empty-desc { font-size: 0.84rem; margin: 0; }

@keyframes fadeInUp { from { opacity: 0; transform: translateY(18px); } to { opacity: 1; transform: translateY(0); } }

@media (max-width: 1024px) { .main-content { margin-left: 0 !important; padding: 24px 20px; padding-top: 68px; } }
@media (max-width: 768px) {
    .main-content { padding: 16px; padding-top: 68px; }
    .page-header { flex-direction: column; align-items: flex-start; gap: 12px; padding: 16px; }
    .stats-container { grid-template-columns: repeat(2, 1fr); gap: 10px; }
    .section-header, .back-btn-row { flex-direction: column; align-items: flex-start; gap: 10px; }
    .erp-toolbar { flex-direction: column; align-items: stretch; }
    .filter-section { width: 100%; }
    .seg-ctrl { width: 100%; justify-content: center; }
    .toolbar-search { width: 100%; margin-left: 0; }
    .toolbar-search .search-input { width: 100%; }
}
</style>