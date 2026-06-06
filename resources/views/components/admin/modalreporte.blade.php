<!-- MODAL REPORTE PDF ADMIN -->
<div id="modal-reporte-admin" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%;
     align-items:center; justify-content:center; z-index:1050;
     background:rgba(0,0,0,0.6); backdrop-filter:blur(4px);">
  <div style="background:white; border-radius:20px; width:90%; max-width:500px;
              box-shadow:0 20px 40px rgba(0,0,0,0.2); animation:slideUp 0.3s ease;">

    <!-- Header -->
    <div style="background:linear-gradient(135deg,#c53030,#9b2c2c); padding:20px 24px;
                border-radius:20px 20px 0 0; display:flex; justify-content:space-between; align-items:center;">
      <h3 style="margin:0; color:white; font-size:18px; font-family:'Plus Jakarta Sans',sans-serif;">
        <i class="fas fa-file-pdf" style="margin-right:10px;"></i> Generar Reporte PDF
      </h3>
      <button onclick="closeModalReporteAdmin()"
              style="background:rgba(255,255,255,0.2); border:none; color:white;
                     width:32px; height:32px; border-radius:50%; cursor:pointer; font-size:16px;">
        <i class="fas fa-times"></i>
      </button>
    </div>

    <!-- Body -->
    <div style="padding:24px;">

      <!-- Selector de cliente -->
      <div style="margin-bottom:18px;">
        <label style="font-size:13px; font-weight:600; color:#4a5568; display:block; margin-bottom:8px;">
          <i class="fas fa-building" style="margin-right:6px; color:#c53030;"></i> Cliente
        </label>
        <select id="admin-select-cliente"
                style="width:100%; padding:10px 14px; border:1px solid #e2e8f0; border-radius:10px;
                       font-size:14px; color:#4a5568; outline:none; font-family:'Plus Jakarta Sans',sans-serif;"
                onchange="adminOnClienteChange()">
          <option value="">-- Todos los clientes --</option>
          @foreach($clientes as $c)
            <option value="{{ $c->id_cliente }}">{{ $c->razon_social }} ({{ $c->ruc }})</option>
          @endforeach
        </select>
      </div>

      <!-- Tipo de reporte -->
      <div style="margin-bottom:18px;">
        <label style="font-size:13px; font-weight:600; color:#4a5568; display:block; margin-bottom:8px;">
          <i class="fas fa-users" style="margin-right:6px; color:#c53030;"></i> ¿Qué reporte deseas?
        </label>
        <div class="mr-tipo-options" style="display:flex; gap:10px;">
          <label style="flex:1; border:2px solid #e2e8f0; border-radius:10px; padding:12px;
                        cursor:pointer; text-align:center; transition:all 0.2s;" id="admin-opt-todos"
                 onclick="adminSeleccionarTipo('todos')">
            <i class="fas fa-globe" style="font-size:20px; color:#718096; display:block; margin-bottom:5px;"></i>
            <span style="font-size:12px; font-weight:600; color:#4a5568;">Todos los usuarios</span>
          </label>
          <label style="flex:1; border:2px solid #e2e8f0; border-radius:10px; padding:12px;
                        cursor:pointer; text-align:center; transition:all 0.2s;" id="admin-opt-individual"
                 onclick="adminSeleccionarTipo('individual')">
            <i class="fas fa-user" style="font-size:20px; color:#718096; display:block; margin-bottom:5px;"></i>
            <span style="font-size:12px; font-weight:600; color:#4a5568;">Usuario específico</span>
          </label>
        </div>
      </div>

      <!-- Select usuario (solo si individual) -->
      <div id="admin-select-usuario-wrap" style="display:none; margin-bottom:18px;">
        <label style="font-size:13px; font-weight:600; color:#4a5568; display:block; margin-bottom:8px;">
          <i class="fas fa-user-circle" style="margin-right:6px; color:#c53030;"></i> Seleccionar usuario
        </label>
        <select id="admin-select-usuario"
                style="width:100%; padding:10px 14px; border:1px solid #e2e8f0; border-radius:10px;
                       font-size:14px; color:#4a5568; outline:none; font-family:'Plus Jakarta Sans',sans-serif;">
          <option value="">-- Primero selecciona un cliente --</option>
        </select>
      </div>

      <!-- Rango de fechas -->
      <div class="mr-date-grid" style="display:grid; grid-template-columns:1fr 1fr; gap:14px; margin-bottom:18px;">
        <div>
          <label style="font-size:13px; font-weight:600; color:#4a5568; display:block; margin-bottom:8px;">
            <i class="fas fa-calendar-alt" style="margin-right:6px; color:#c53030;"></i> Fecha desde
          </label>
          <input type="date" id="admin-fecha-desde"
                 style="width:100%; padding:10px 14px; border:1px solid #e2e8f0; border-radius:10px;
                        font-size:14px; color:#4a5568; outline:none; box-sizing:border-box;">
        </div>
        <div>
          <label style="font-size:13px; font-weight:600; color:#4a5568; display:block; margin-bottom:8px;">
            <i class="fas fa-calendar-check" style="margin-right:6px; color:#c53030;"></i> Fecha hasta
          </label>
          <input type="date" id="admin-fecha-hasta"
                 style="width:100%; padding:10px 14px; border:1px solid #e2e8f0; border-radius:10px;
                        font-size:14px; color:#4a5568; outline:none; box-sizing:border-box;">
        </div>
      </div>

      <!-- Info -->
      <div style="background:#fff5f5; border:1px solid #feb2b2; border-radius:10px; padding:12px;
                  font-size:12px; color:#c53030; display:flex; align-items:center; gap:8px;">
        <i class="fas fa-info-circle" style="font-size:16px; flex-shrink:0;"></i>
        El reporte incluirá tickets por cliente y usuario: creados, cerrados, cancelados, pendientes y en proceso.
      </div>
    </div>

    <!-- Footer -->
    <div class="mr-modal-footer" style="padding:16px 24px; border-top:1px solid #edf2f7; display:flex; gap:12px;">
      <button onclick="closeModalReporteAdmin()"
              style="flex:1; padding:12px; border:none; background:#edf2f7; color:#4a5568;
                     border-radius:10px; cursor:pointer; font-weight:600; font-family:'Plus Jakarta Sans',sans-serif;">
        <i class="fas fa-times"></i> Cancelar
      </button>
      <button onclick="descargarReporteAdmin()"
              style="flex:2; padding:12px; border:none; background:linear-gradient(135deg,#c53030,#9b2c2c);
                     color:white; border-radius:10px; cursor:pointer; font-weight:600; font-size:14px;
                     font-family:'Plus Jakarta Sans',sans-serif;">
        <i class="fas fa-download"></i> Descargar PDF
      </button>
    </div>
  </div>
</div>

<style>
@media (max-width: 540px) {
    #modal-reporte-admin > div { width: 95%; max-height: 90vh; overflow-y: auto; }
    #modal-reporte-admin .mr-date-grid { grid-template-columns: 1fr; }
    #modal-reporte-admin .mr-tipo-options { flex-direction: column; }
    #modal-reporte-admin .mr-modal-footer { flex-direction: column; }
    #modal-reporte-admin .mr-modal-footer button { width: 100%; flex: none; }
}
</style>

<script>
// Todos los usuarios agrupados por cliente (para el select dinámico)
const _adminUsuariosPorCliente = @json(
    $usuarios_lista->groupBy('id_cliente')->map(fn($g) => $g->map(fn($u) => [
        'id'     => $u->id_usuario,
        'nombre' => $u->nombre . ' ' . $u->apellido_paterno . ' (' . $u->codigo_usuario . ')',
    ]))
);

let adminTipoReporte = 'todos';

function openModalReporteAdmin() {
    adminTipoReporte = 'todos';
    adminSeleccionarTipo('todos');
    const hoy  = new Date().toISOString().split('T')[0];
    const pMes = new Date(new Date().getFullYear(), new Date().getMonth(), 1).toISOString().split('T')[0];
    document.getElementById('admin-fecha-desde').value = pMes;
    document.getElementById('admin-fecha-hasta').value = hoy;
    document.getElementById('admin-select-cliente').value = '';
    document.getElementById('admin-select-usuario').innerHTML = '<option value="">-- Primero selecciona un cliente --</option>';
    document.getElementById('modal-reporte-admin').style.display = 'flex';
}

function closeModalReporteAdmin() {
    document.getElementById('modal-reporte-admin').style.display = 'none';
}

function adminSeleccionarTipo(tipo) {
    adminTipoReporte = tipo;
    const optTodos      = document.getElementById('admin-opt-todos');
    const optIndividual = document.getElementById('admin-opt-individual');
    const selectWrap    = document.getElementById('admin-select-usuario-wrap');

    if (tipo === 'todos') {
        optTodos.style.borderColor      = '#c53030';
        optTodos.style.background       = '#fff5f5';
        optIndividual.style.borderColor = '#e2e8f0';
        optIndividual.style.background  = 'white';
        selectWrap.style.display        = 'none';
    } else {
        optIndividual.style.borderColor = '#c53030';
        optIndividual.style.background  = '#fff5f5';
        optTodos.style.borderColor      = '#e2e8f0';
        optTodos.style.background       = 'white';
        selectWrap.style.display        = 'block';
    }
}

function adminOnClienteChange() {
    const clienteId = document.getElementById('admin-select-cliente').value;
    const select    = document.getElementById('admin-select-usuario');
    select.innerHTML = '<option value="">-- Todos los usuarios del cliente --</option>';

    if (clienteId && _adminUsuariosPorCliente[clienteId]) {
        _adminUsuariosPorCliente[clienteId].forEach(u => {
            const opt = document.createElement('option');
            opt.value       = u.id;
            opt.textContent = u.nombre;
            select.appendChild(opt);
        });
    } else {
        select.innerHTML = '<option value="">-- Primero selecciona un cliente --</option>';
    }
}

function descargarReporteAdmin() {
    const desde    = document.getElementById('admin-fecha-desde').value;
    const hasta    = document.getElementById('admin-fecha-hasta').value;
    const clienteId = document.getElementById('admin-select-cliente').value;
    const userId   = document.getElementById('admin-select-usuario').value;

    if (!desde || !hasta) {
        alert('Selecciona el rango de fechas.');
        return;
    }
    if (adminTipoReporte === 'individual' && !userId) {
        alert('Selecciona un usuario específico.');
        return;
    }

let url = `{{ route('admin.reporte.pdf') }}?desde=${desde}&hasta=${hasta}&tipo=${adminTipoReporte}`;
    if (clienteId)  url += `&cliente_id=${clienteId}`;
    if (adminTipoReporte === 'individual' && userId) url += `&usuario_id=${userId}`;

    window.open(url, '_blank');
    closeModalReporteAdmin();
}

// Cerrar al click fuera
document.getElementById('modal-reporte-admin')?.addEventListener('click', function(e) {
    if (e.target === this) closeModalReporteAdmin();
});
</script>
