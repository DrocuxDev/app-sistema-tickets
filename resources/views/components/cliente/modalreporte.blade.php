<!-- MODAL REPORTE PDF -->
<div id="modal-reporte" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%;
     background:rgba(0,0,0,0.6); backdrop-filter:blur(4px); display:none;
     align-items:center; justify-content:center; z-index:1050;">
  <div style="background:white; border-radius:20px; width:90%; max-width:460px;
              box-shadow:0 20px 40px rgba(0,0,0,0.2); animation: slideUp 0.3s ease;">

    <!-- Header -->
    <div style="background:linear-gradient(135deg,#c53030,#9b2c2c); padding:20px 24px;
                border-radius:20px 20px 0 0; display:flex; justify-content:space-between; align-items:center;">
      <h3 style="margin:0; color:white; font-size:18px;">
        <i class="fas fa-file-pdf" style="margin-right:10px;"></i> Generar Reporte PDF
      </h3>
      <button onclick="closeModalReporte()" style="background:rgba(255,255,255,0.2); border:none;
              color:white; width:32px; height:32px; border-radius:50%; cursor:pointer;">
        <i class="fas fa-times"></i>
      </button>
    </div>

    <!-- Body -->
    <div style="padding:24px;">

      <!-- Tipo de reporte -->
      <div style="margin-bottom:18px;">
        <label style="font-size:13px; font-weight:600; color:#4a5568; display:block; margin-bottom:8px;">
          <i class="fas fa-users" style="margin-right:6px; color:#c53030;"></i> ¿Qué reporte deseas?
        </label>
        <div style="display:flex; gap:10px;">
          <label style="flex:1; border:2px solid #e2e8f0; border-radius:10px; padding:12px;
                        cursor:pointer; text-align:center; transition:all 0.2s;" id="opt-todos"
                 onclick="seleccionarTipo('todos')">
            <i class="fas fa-globe" style="font-size:22px; color:#718096; display:block; margin-bottom:6px;"></i>
            <span style="font-size:13px; font-weight:600; color:#4a5568;">Todos los usuarios</span>
          </label>
          <label style="flex:1; border:2px solid #e2e8f0; border-radius:10px; padding:12px;
                        cursor:pointer; text-align:center; transition:all 0.2s;" id="opt-individual"
                 onclick="seleccionarTipo('individual')">
            <i class="fas fa-user" style="font-size:22px; color:#718096; display:block; margin-bottom:6px;"></i>
            <span style="font-size:13px; font-weight:600; color:#4a5568;">Usuario específico</span>
          </label>
        </div>
      </div>

      <!-- Select usuario (solo si individual) -->
      <div id="select-usuario-wrap" style="display:none; margin-bottom:18px;">
        <label style="font-size:13px; font-weight:600; color:#4a5568; display:block; margin-bottom:8px;">
          <i class="fas fa-user-circle" style="margin-right:6px; color:#c53030;"></i> Seleccionar usuario
        </label>
        <select id="select-usuario" style="width:100%; padding:10px 14px; border:1px solid #e2e8f0;
                border-radius:10px; font-size:14px; color:#4a5568; outline:none;">
          <option value="">-- Selecciona un usuario --</option>
          @foreach($usuarios as $u)
            <option value="{{ $u->id_usuario }}">
              {{ $u->nombre }} {{ $u->apellido_paterno }} ({{ $u->codigo_usuario }})
            </option>
          @endforeach
        </select>
      </div>

      <!-- Rango de fechas -->
      <div style="display:grid; grid-template-columns:1fr 1fr; gap:14px; margin-bottom:18px;">
        <div>
          <label style="font-size:13px; font-weight:600; color:#4a5568; display:block; margin-bottom:8px;">
            <i class="fas fa-calendar-alt" style="margin-right:6px; color:#c53030;"></i> Fecha desde
          </label>
          <input type="date" id="fecha-desde" style="width:100%; padding:10px 14px; border:1px solid #e2e8f0;
                 border-radius:10px; font-size:14px; color:#4a5568; outline:none; box-sizing:border-box;">
        </div>
        <div>
          <label style="font-size:13px; font-weight:600; color:#4a5568; display:block; margin-bottom:8px;">
            <i class="fas fa-calendar-check" style="margin-right:6px; color:#c53030;"></i> Fecha hasta
          </label>
          <input type="date" id="fecha-hasta" style="width:100%; padding:10px 14px; border:1px solid #e2e8f0;
                 border-radius:10px; font-size:14px; color:#4a5568; outline:none; box-sizing:border-box;">
        </div>
      </div>

      <!-- Info -->
      <div style="background:#fff5f5; border:1px solid #feb2b2; border-radius:10px; padding:12px;
                  font-size:12px; color:#c53030; display:flex; align-items:center; gap:8px;">
        <i class="fas fa-info-circle" style="font-size:16px; flex-shrink:0;"></i>
        El reporte incluirá: tickets creados, cerrados, cancelados, pendientes y en proceso, datos del usuario y tiempos de atención.
      </div>
    </div>

    <!-- Footer -->
    <div style="padding:16px 24px; border-top:1px solid #edf2f7; display:flex; gap:12px;">
      <button onclick="closeModalReporte()" style="flex:1; padding:12px; border:none; background:#edf2f7;
              color:#4a5568; border-radius:10px; cursor:pointer; font-weight:600; transition:all 0.2s;">
        <i class="fas fa-times"></i> Cancelar
      </button>
      <button onclick="descargarReporte()" style="flex:2; padding:12px; border:none;
              background:linear-gradient(135deg,#c53030,#9b2c2c); color:white; border-radius:10px;
              cursor:pointer; font-weight:600; font-size:14px; transition:all 0.2s;">
        <i class="fas fa-download"></i> Descargar PDF
      </button>
    </div>
  </div>
</div>

<script>
let tipoReporte = 'todos';

function openModalReporte() {
    tipoReporte = 'todos';
    seleccionarTipo('todos');
    // Poner fecha de hoy por defecto
    const hoy = new Date().toISOString().split('T')[0];
    const primerDiaMes = new Date(new Date().getFullYear(), new Date().getMonth(), 1).toISOString().split('T')[0];
    document.getElementById('fecha-desde').value = primerDiaMes;
    document.getElementById('fecha-hasta').value = hoy;
    document.getElementById('modal-reporte').style.display = 'flex';
}

function closeModalReporte() {
    document.getElementById('modal-reporte').style.display = 'none';
}

function seleccionarTipo(tipo) {
    tipoReporte = tipo;
    const optTodos      = document.getElementById('opt-todos');
    const optIndividual = document.getElementById('opt-individual');
    const selectWrap    = document.getElementById('select-usuario-wrap');

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

function descargarReporte() {
    const desde  = document.getElementById('fecha-desde').value;
    const hasta  = document.getElementById('fecha-hasta').value;
    const userId = document.getElementById('select-usuario').value;

    if (!desde || !hasta) {
        showNotification('error', 'Error', 'Selecciona el rango de fechas.');
        return;
    }
    if (tipoReporte === 'individual' && !userId) {
        showNotification('error', 'Error', 'Selecciona un usuario.');
        return;
    }

    let url = `/cliente/reporte-pdf?desde=${desde}&hasta=${hasta}&tipo=${tipoReporte}`;
    if (tipoReporte === 'individual') url += `&usuario_id=${userId}`;

    window.open(url, '_blank');
    closeModalReporte();
}

</script>
