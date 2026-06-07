<!-- MODAL REPORTE PDF — TÉCNICO -->
<div id="tec-modal-reporte" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%;
     background:rgba(0,0,0,0.6); backdrop-filter:blur(4px);
     align-items:center; justify-content:center; z-index:1050;">
  <div style="background:white; border-radius:20px; width:90%; max-width:500px;
              box-shadow:0 20px 40px rgba(0,0,0,0.2); animation: slideUpTecRep 0.3s ease;">

    <!-- Header -->
    <div style="background:linear-gradient(135deg,#c53030,#9b2c2c); padding:20px 24px;
                border-radius:20px 20px 0 0; display:flex; justify-content:space-between; align-items:center;">
      <h3 style="margin:0; color:white; font-size:18px; display:flex; align-items:center; gap:10px; font-family:'Inter',sans-serif;">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
          <polyline points="14 2 14 8 20 8"/>
          <line x1="16" y1="13" x2="8" y2="13"/>
          <line x1="16" y1="17" x2="8" y2="17"/>
        </svg>
        Generar Reporte PDF
      </h3>
      <button onclick="tecCloseModalReporte()"
              style="background:rgba(255,255,255,0.2); border:none; color:white;
                     width:32px; height:32px; border-radius:50%; cursor:pointer; font-size:18px; line-height:1;">
        ✕
      </button>
    </div>

    <!-- Body -->
    <div style="padding:24px;">

      <!-- Selector de cliente -->
      <div style="margin-bottom:18px;">
        <label style="font-size:13px; font-weight:600; color:#4a5568; display:flex; align-items:center; gap:6px; margin-bottom:8px;">
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#c53030" stroke-width="2"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/></svg>
          Cliente
        </label>
        <select id="tec-select-cliente"
                style="width:100%; padding:10px 14px; border:1.5px solid #e2e8f0; border-radius:10px;
                       font-size:14px; color:#4a5568; outline:none; font-family:'Inter',sans-serif; background:#fff;"
                onchange="tecOnClienteChange()">
          <option value="">-- Todos los clientes --</option>
          @foreach($clientes as $c)
            <option value="{{ $c->id_cliente }}">{{ $c->razon_social }}</option>
          @endforeach
        </select>
      </div>

      <!-- Tipo de reporte -->
      <div style="margin-bottom:18px;">
        <label style="font-size:13px; font-weight:600; color:#4a5568; display:flex; align-items:center; gap:6px; margin-bottom:8px;">
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#c53030" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
          ¿Qué reporte deseas?
        </label>
        <div style="display:flex; gap:10px;">
          <label style="flex:1; border:2px solid #e2e8f0; border-radius:10px; padding:12px;
                        cursor:pointer; text-align:center; transition:all 0.2s;" id="tec-opt-todos"
                 onclick="tecSeleccionarTipo('todos')">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#718096" stroke-width="1.5" style="display:block; margin:0 auto 6px;">
              <circle cx="12" cy="12" r="10"/><line x1="2" y1="12" x2="22" y2="12"/>
              <path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/>
            </svg>
            <span style="font-size:12px; font-weight:600; color:#4a5568;">Todos los usuarios</span>
          </label>
          <label style="flex:1; border:2px solid #e2e8f0; border-radius:10px; padding:12px;
                        cursor:pointer; text-align:center; transition:all 0.2s;" id="tec-opt-individual"
                 onclick="tecSeleccionarTipo('individual')">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#718096" stroke-width="1.5" style="display:block; margin:0 auto 6px;">
              <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/>
            </svg>
            <span style="font-size:12px; font-weight:600; color:#4a5568;">Usuario específico</span>
          </label>
        </div>
      </div>

      <!-- Select usuario (solo si individual) -->
      <div id="tec-select-usuario-wrap" style="display:none; margin-bottom:18px;">
        <label style="font-size:13px; font-weight:600; color:#4a5568; display:flex; align-items:center; gap:6px; margin-bottom:8px;">
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#c53030" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
          Seleccionar usuario
        </label>
        <select id="tec-select-usuario"
                style="width:100%; padding:10px 14px; border:1.5px solid #e2e8f0; border-radius:10px;
                       font-size:14px; color:#4a5568; outline:none; font-family:'Inter',sans-serif; background:#fff;">
          <option value="">-- Primero selecciona un cliente --</option>
        </select>
      </div>

      <!-- Rango de fechas -->
      <div style="display:grid; grid-template-columns:1fr 1fr; gap:14px; margin-bottom:18px;">
        <div>
          <label style="font-size:13px; font-weight:600; color:#4a5568; display:flex; align-items:center; gap:6px; margin-bottom:8px;">
            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="#c53030" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
            Fecha desde
          </label>
          <input type="date" id="tec-fecha-desde"
                 style="width:100%; padding:10px 14px; border:1.5px solid #e2e8f0;
                        border-radius:10px; font-size:14px; color:#4a5568; outline:none; box-sizing:border-box;">
        </div>
        <div>
          <label style="font-size:13px; font-weight:600; color:#4a5568; display:flex; align-items:center; gap:6px; margin-bottom:8px;">
            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="#c53030" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
            Fecha hasta
          </label>
          <input type="date" id="tec-fecha-hasta"
                 style="width:100%; padding:10px 14px; border:1.5px solid #e2e8f0;
                        border-radius:10px; font-size:14px; color:#4a5568; outline:none; box-sizing:border-box;">
        </div>
      </div>

      <!-- Info -->
      <div style="background:#fff5f5; border:1px solid #feb2b2; border-radius:10px; padding:12px;
                  font-size:12px; color:#c53030; display:flex; align-items:flex-start; gap:8px;">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#c53030" stroke-width="2" style="flex-shrink:0; margin-top:1px;">
          <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>
        </svg>
        El reporte incluirá tickets por cliente y usuario: creados, cerrados, cancelados, pendientes y en proceso.
      </div>
    </div>

    <!-- Footer -->
    <div style="padding:16px 24px; border-top:1px solid #edf2f7; display:flex; gap:12px;">
      <button onclick="tecCloseModalReporte()"
              style="flex:1; padding:12px; border:none; background:#edf2f7; color:#4a5568;
                     border-radius:10px; cursor:pointer; font-weight:600; font-family:'Inter',sans-serif;">
        ✕ Cancelar
      </button>
      <button onclick="tecDescargarReporte()"
              style="flex:2; padding:12px; border:none; background:linear-gradient(135deg,#c53030,#9b2c2c);
                     color:white; border-radius:10px; cursor:pointer; font-weight:600; font-size:14px;
                     font-family:'Inter',sans-serif; display:flex; align-items:center; justify-content:center; gap:8px;">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
          <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
          <polyline points="7 10 12 15 17 10"/>
          <line x1="12" y1="15" x2="12" y2="3"/>
        </svg>
        Descargar PDF
      </button>
    </div>
  </div>
</div>

<style>
@keyframes slideUpTecRep {
  from { opacity:0; transform:translateY(20px) scale(.97); }
  to   { opacity:1; transform:translateY(0) scale(1); }
}
@media (max-width: 540px) {
    #tec-modal-reporte > div { width: 95%; max-height: 90vh; overflow-y: auto; }
}
</style>

<script>
// Usuarios por cliente (para el select dinámico)
const _tecUsuariosPorCliente = @json($usuariosPorCliente);

let tecTipoReporte = 'todos';

function tecOpenModalReporte() {
    tecTipoReporte = 'todos';
    tecSeleccionarTipo('todos');
    const hoy  = new Date().toISOString().split('T')[0];
    const pMes = new Date(new Date().getFullYear(), new Date().getMonth(), 1).toISOString().split('T')[0];
    document.getElementById('tec-fecha-desde').value = pMes;
    document.getElementById('tec-fecha-hasta').value = hoy;
    document.getElementById('tec-select-cliente').value = '';
    document.getElementById('tec-select-usuario').innerHTML = '<option value="">-- Primero selecciona un cliente --</option>';
    document.getElementById('tec-modal-reporte').style.display = 'flex';
}

function tecCloseModalReporte() {
    document.getElementById('tec-modal-reporte').style.display = 'none';
}

function tecSeleccionarTipo(tipo) {
    tecTipoReporte = tipo;
    const optTodos      = document.getElementById('tec-opt-todos');
    const optIndividual = document.getElementById('tec-opt-individual');
    const selectWrap    = document.getElementById('tec-select-usuario-wrap');

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

function tecOnClienteChange() {
    const clienteId = document.getElementById('tec-select-cliente').value;
    const select    = document.getElementById('tec-select-usuario');
    select.innerHTML = '<option value="">-- Todos los usuarios del cliente --</option>';

    if (clienteId && _tecUsuariosPorCliente[clienteId] && _tecUsuariosPorCliente[clienteId].length) {
        _tecUsuariosPorCliente[clienteId].forEach(u => {
            const opt = document.createElement('option');
            opt.value       = u.id;
            opt.textContent = u.nombre;
            select.appendChild(opt);
        });
    } else {
        select.innerHTML = '<option value="">-- Primero selecciona un cliente --</option>';
    }
}

function tecDescargarReporte() {
    const desde     = document.getElementById('tec-fecha-desde').value;
    const hasta     = document.getElementById('tec-fecha-hasta').value;
    const clienteId = document.getElementById('tec-select-cliente').value;
    const userId    = document.getElementById('tec-select-usuario').value;

    if (!desde || !hasta) {
        showNotification('warning', 'Campos requeridos', 'Selecciona el rango de fechas.');
        return;
    }
    if (desde > hasta) {
        showNotification('warning', 'Fechas inválidas', 'La fecha "desde" no puede ser mayor que "hasta".');
        return;
    }
    if (tecTipoReporte === 'individual' && !userId) {
        showNotification('warning', 'Usuario requerido', 'Selecciona un usuario específico.');
        return;
    }

    let url = `/tecnico/reporte-pdf?desde=${desde}&hasta=${hasta}&tipo=${tecTipoReporte}`;
    if (clienteId)  url += `&cliente_id=${clienteId}`;
    if (tecTipoReporte === 'individual' && userId) url += `&usuario_id=${userId}`;

    window.open(url, '_blank');
    tecCloseModalReporte();
}

// Cerrar al hacer clic fuera
document.addEventListener('DOMContentLoaded', function () {
    document.getElementById('tec-modal-reporte').addEventListener('click', function (e) {
        if (e.target === this) tecCloseModalReporte();
    });
});
</script>
