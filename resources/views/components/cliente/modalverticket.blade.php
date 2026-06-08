{{-- ══ MODAL VER TICKET (CLIENTE — carga via fetch) ══ --}}
<div class="vtk-overlay" id="vtk-overlay" style="display:none;" onclick="vtk_close()">
    <div class="vtk-card" onclick="event.stopPropagation()">

        {{-- HEADER --}}
        <div class="vtk-header">
            <div class="vtk-header-left">
                <div class="vtk-header-icon">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M20 12V22H4V12"/><path d="M22 7H2v5h20V7z"/><path d="M12 22V7"/>
                        <path d="M12 7H7.5a2.5 2.5 0 0 1 0-5C11 2 12 7 12 7z"/>
                        <path d="M12 7h4.5a2.5 2.5 0 0 0 0-5C13 2 12 7 12 7z"/>
                    </svg>
                </div>
                <div>
                    <div class="vtk-eyebrow">Detalle del ticket</div>
                    <div id="vtk-code" class="vtk-code">—</div>
                </div>
            </div>
            <div class="vtk-header-right">
                <div id="vtk-estado"></div>
                <button class="vtk-close-btn" onclick="vtk_close()">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                        <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
                    </svg>
                </button>
            </div>
        </div>

        {{-- LOADING --}}
        <div id="vtk-loading" class="vtk-body" style="display:flex;align-items:center;justify-content:center;min-height:200px;">
            <div style="text-align:center;color:#94a3b8;">
                <svg style="animation:vtkSpin 1s linear infinite;margin-bottom:10px;" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#1a6ed8" stroke-width="2.5">
                    <path d="M21 12a9 9 0 1 1-6.219-8.56"/>
                </svg>
                <div style="font-size:13px;">Cargando ticket...</div>
            </div>
        </div>

        {{-- CONTENIDO --}}
        <div id="vtk-content" class="vtk-body" style="display:none;">

            {{-- Usuario solicitante --}}
            <div class="vtk-section">
                <div class="vtk-section-header">
                    <div class="vtk-sec-icon vtk-icon-indigo">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/>
                        </svg>
                    </div>
                    <span>Usuario solicitante</span>
                </div>
                <div class="vtk-row-3">
                    <div class="vtk-field"><div class="vtk-label">Nombre completo</div><div id="vtk-usu-nombre" class="vtk-val"></div></div>
                    <div class="vtk-field"><div class="vtk-label">Código</div><div id="vtk-usu-codigo" class="vtk-val vtk-mono"></div></div>
                    <div class="vtk-field"><div class="vtk-label">Teléfono</div><div id="vtk-usu-tel" class="vtk-val vtk-mono"></div></div>
                </div>
            </div>

            {{-- Clasificación --}}
            <div class="vtk-section">
                <div class="vtk-section-header">
                    <div class="vtk-sec-icon vtk-icon-violet">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"/>
                            <line x1="7" y1="7" x2="7.01" y2="7"/>
                        </svg>
                    </div>
                    <span>Clasificación</span>
                </div>
                <div class="vtk-row-2">
                    <div class="vtk-field"><div class="vtk-label">Tipo de ticket</div><div id="vtk-tipo" class="vtk-val"></div></div>
                    <div class="vtk-field"><div class="vtk-label">Prioridad</div><div id="vtk-prioridad" class="vtk-val"></div></div>
                </div>
            </div>

            {{-- Equipo --}}
            <div class="vtk-section">
                <div class="vtk-section-header">
                    <div class="vtk-sec-icon vtk-icon-cyan">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="2" y="3" width="20" height="14" rx="2"/>
                            <line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/>
                        </svg>
                    </div>
                    <span>Equipo</span>
                </div>
                <div class="vtk-row-3">
                    <div class="vtk-field"><div class="vtk-label">Tipo</div><div id="vtk-tipo-equipo" class="vtk-val"></div></div>
                    <div class="vtk-field"><div class="vtk-label">Marca</div><div id="vtk-marca" class="vtk-val"></div></div>
                    <div class="vtk-field"><div class="vtk-label">Modelo</div><div id="vtk-modelo" class="vtk-val"></div></div>
                </div>
                <div class="vtk-row-1" style="margin-top:10px;">
                    <div class="vtk-field"><div class="vtk-label">Serie / Serial</div><div id="vtk-serial" class="vtk-val vtk-mono"></div></div>
                </div>
            </div>

            {{-- Solicitud --}}
            <div class="vtk-section">
                <div class="vtk-section-header">
                    <div class="vtk-sec-icon vtk-icon-blue">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                            <polyline points="14 2 14 8 20 8"/>
                            <line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/>
                        </svg>
                    </div>
                    <span>Solicitud</span>
                </div>
                <div class="vtk-field" style="margin-bottom:10px;">
                    <div class="vtk-label">Asunto</div><div id="vtk-asunto" class="vtk-val"></div>
                </div>
                <div class="vtk-field">
                    <div class="vtk-label">Descripción del problema</div>
                    <div id="vtk-problema" class="vtk-val vtk-area"></div>
                </div>
            </div>

            {{-- Fechas --}}
            <div class="vtk-section">
                <div class="vtk-section-header">
                    <div class="vtk-sec-icon vtk-icon-green">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="3" y="4" width="18" height="18" rx="2"/>
                            <line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/>
                            <line x1="3" y1="10" x2="21" y2="10"/>
                        </svg>
                    </div>
                    <span>Fechas</span>
                </div>
                <div class="vtk-dates-grid">
                    <div class="vtk-date-item"><div class="vtk-date-dot vtk-dot-blue"></div><div><div class="vtk-label">Creado</div><div id="vtk-f-creado" class="vtk-date-val">—</div></div></div>
                    <div class="vtk-date-item"><div class="vtk-date-dot vtk-dot-violet"></div><div><div class="vtk-label">Programado</div><div id="vtk-f-prog" class="vtk-date-val">—</div></div></div>
                    <div class="vtk-date-item"><div class="vtk-date-dot vtk-dot-orange"></div><div><div class="vtk-label">En proceso</div><div id="vtk-f-proc" class="vtk-date-val">—</div></div></div>
                    <div class="vtk-date-item"><div class="vtk-date-dot vtk-dot-green"></div><div><div class="vtk-label">Resuelto</div><div id="vtk-f-res" class="vtk-date-val">—</div></div></div>
                </div>
            </div>

            {{-- Evidencia --}}
            <div class="vtk-section">
                <div class="vtk-section-header">
                    <div class="vtk-sec-icon vtk-icon-indigo">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M21.44 11.05l-9.19 9.19a6 6 0 0 1-8.49-8.49l9.19-9.19a4 4 0 0 1 5.66 5.66l-9.2 9.19a2 2 0 0 1-2.83-2.83l8.49-8.48"/>
                        </svg>
                    </div>
                    <span>Evidencia</span>
                </div>
                <div id="vtk-evidencia" class="vtk-ev-box"></div>
            </div>

            {{-- Técnico (desde PROGRAMADO) --}}
            <div id="vtk-sec-tecnico" class="vtk-section" style="display:none;">
                <div class="vtk-section-header">
                    <div class="vtk-sec-icon vtk-icon-orange">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"/>
                        </svg>
                    </div>
                    <span>Técnico asignado</span>
                </div>
                <div class="vtk-row-2">
                    <div class="vtk-field"><div class="vtk-label">Nombre</div><div id="vtk-tecnico" class="vtk-val"></div></div>
                    <div class="vtk-field"><div class="vtk-label">Código</div><div id="vtk-tecnico-cod" class="vtk-val vtk-mono"></div></div>
                </div>
            </div>

            {{-- Actividad (desde EN PROCESO) --}}
            <div id="vtk-sec-proceso" class="vtk-section" style="display:none;">
                <div class="vtk-section-header">
                    <div class="vtk-sec-icon vtk-icon-orange">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
                        </svg>
                    </div>
                    <span>Actividad del técnico</span>
                </div>
                <div id="vtk-sec-com-ini" style="display:none;margin-bottom:14px;">
                    <div class="vtk-label" style="margin-bottom:6px;">Primer comentario</div>
                    <div id="vtk-com-ini" class="vtk-val vtk-area" style="white-space:pre-line;line-height:1.6;"></div>
                    <div id="vtk-com-ini-fecha" style="font-size:11px;color:#94a3b8;margin-top:4px;"></div>
                </div>
                <div id="vtk-sec-reporte" style="display:none;margin-bottom:14px;">
                    <div class="vtk-label" style="margin-bottom:6px;">Reporte técnico</div>
                    <div id="vtk-reporte" class="vtk-ev-box"></div>
                </div>
                <div id="vtk-sec-com-fin" style="display:none;">
                    <div class="vtk-label" style="margin-bottom:6px;">Comentario de cierre</div>
                    <div id="vtk-com-fin" class="vtk-val vtk-area" style="white-space:pre-line;line-height:1.6;"></div>
                    <div id="vtk-com-fin-fecha" style="font-size:11px;color:#94a3b8;margin-top:4px;"></div>
                </div>
            </div>

        </div>

        {{-- FOOTER --}}
        <div class="vtk-footer">
            <button class="vtk-btn-ghost" onclick="vtk_close()">Cerrar</button>
        </div>

    </div>
</div>

{{-- Lightbox propio para no colisionar con otros modals --}}
<div id="vtk-lightbox" onclick="vtk_closeLightbox()"
     style="display:none;position:fixed;inset:0;background:rgba(0,0,0,.92);z-index:9998;align-items:center;justify-content:center;cursor:zoom-out;flex-direction:column;gap:12px;">
    <img id="vtk-lb-img" src="" alt=""
         style="display:none;max-width:92vw;max-height:88vh;border-radius:12px;object-fit:contain;">
    <video id="vtk-lb-video" controls
           style="display:none;max-width:92vw;max-height:88vh;border-radius:12px;">
        <source id="vtk-lb-vsrc" src="">
    </video>
    <div style="color:rgba(255,255,255,.5);font-size:12px;">Click para cerrar · ESC</div>
</div>

<style>
@keyframes vtkUp   { from{opacity:0;transform:translateY(20px) scale(.98)} to{opacity:1;transform:translateY(0) scale(1)} }
@keyframes vtkSpin { to { transform: rotate(360deg); } }

.vtk-overlay {
    position:fixed; inset:0;
    background:rgba(8,20,45,.6); backdrop-filter:blur(6px);
    z-index:3000;
    align-items:center; justify-content:center; padding:16px;
}
.vtk-card {
    background:#fff; border-radius:20px;
    width:660px; max-width:100%; max-height:92vh;
    display:flex; flex-direction:column; overflow:hidden;
    animation:vtkUp .25s cubic-bezier(.16,1,.3,1);
    box-shadow:0 32px 80px rgba(8,20,45,.28), 0 0 0 1px rgba(255,255,255,.08);
}

/* ── Header ── */
.vtk-header {
    background:linear-gradient(135deg,#0f4a8a 0%,#1a6ed8 50%,#0ea5e9 100%);
    padding:20px 24px;
    display:flex; align-items:center; justify-content:space-between;
    border-radius:20px 20px 0 0; flex-shrink:0;
}
.vtk-header-left  { display:flex; align-items:center; gap:14px; }
.vtk-header-right { display:flex; align-items:center; gap:10px; }
.vtk-header-icon  {
    width:42px; height:42px; border-radius:12px;
    background:rgba(255,255,255,.18); border:1px solid rgba(255,255,255,.25);
    display:flex; align-items:center; justify-content:center; color:#fff; flex-shrink:0;
}
.vtk-eyebrow { font-size:10px; color:rgba(255,255,255,.6); letter-spacing:.1em; text-transform:uppercase; margin-bottom:3px; }
.vtk-code    { font-size:16px; font-weight:700; color:#fff; font-family:'Courier New',monospace; letter-spacing:.04em; }
.vtk-close-btn {
    width:34px; height:34px; border-radius:10px;
    background:rgba(255,255,255,.15); border:1px solid rgba(255,255,255,.2);
    color:#fff; display:flex; align-items:center; justify-content:center;
    cursor:pointer; transition:background .15s;
}
.vtk-close-btn:hover { background:rgba(255,255,255,.28); }

/* ── Body ── */
.vtk-body {
    padding:6px 0 0; overflow-y:auto; flex:1;
    scrollbar-width:thin; scrollbar-color:#c8d8f0 transparent;
}
.vtk-body::-webkit-scrollbar { width:4px; }
.vtk-body::-webkit-scrollbar-thumb { background:#c8d8f0; border-radius:99px; }

/* ── Sections ── */
.vtk-section        { padding:18px 24px; border-bottom:1px solid #f0f4fa; }
.vtk-section-header {
    display:flex; align-items:center; gap:8px; margin-bottom:14px;
    font-size:11px; font-weight:700; color:#1e3a5f;
    text-transform:uppercase; letter-spacing:.08em;
}
.vtk-sec-icon  { width:24px; height:24px; border-radius:6px; display:flex; align-items:center; justify-content:center; flex-shrink:0; }
.vtk-icon-blue   { background:#dbeafe; color:#1d4ed8; }
.vtk-icon-indigo { background:#e0e7ff; color:#4338ca; }
.vtk-icon-violet { background:#ede9fe; color:#7c3aed; }
.vtk-icon-cyan   { background:#cffafe; color:#0e7490; }
.vtk-icon-green  { background:#dcfce7; color:#15803d; }
.vtk-icon-orange { background:#ffedd5; color:#c2410c; }

.vtk-row-1 { display:grid; grid-template-columns:1fr; gap:10px; }
.vtk-row-2 { display:grid; grid-template-columns:1fr 1fr; gap:10px; }
.vtk-row-3 { display:grid; grid-template-columns:1fr 1fr 1fr; gap:10px; }

.vtk-field  { display:flex; flex-direction:column; gap:5px; }
.vtk-label  { font-size:10px; font-weight:600; color:#94a3b8; text-transform:uppercase; letter-spacing:.06em; }
.vtk-val {
    font-size:13.5px; color:#0f2a4a; background:#f8fafd;
    border:1px solid #e8eef8; border-radius:10px;
    padding:9px 13px; min-height:38px; word-break:break-word; line-height:1.5;
}
.vtk-val.vtk-empty::before { content:'—'; color:#c0cfe4; font-style:italic; }
.vtk-mono { font-family:'Courier New',monospace; font-size:12.5px; color:#1e4080; }
.vtk-area { min-height:80px; }

/* ── Badge estado ── */
.vtk-badge { display:inline-flex; align-items:center; gap:6px; font-size:12px; font-weight:600; padding:5px 12px; border-radius:20px; }
.vtk-badge::before { content:''; width:7px; height:7px; border-radius:50%; }
.vtk-badge.pendiente  { background:#fef9c3; color:#854d0e; } .vtk-badge.pendiente::before  { background:#f59e0b; }
.vtk-badge.en_proceso { background:#dbeafe; color:#1e40af; } .vtk-badge.en_proceso::before { background:#3b82f6; }
.vtk-badge.resuelto   { background:#dcfce7; color:#14532d; } .vtk-badge.resuelto::before   { background:#22c55e; }
.vtk-badge.cancelado  { background:#fee2e2; color:#7f1d1d; } .vtk-badge.cancelado::before  { background:#ef4444; }
.vtk-badge.programado { background:#ede9fe; color:#4c1d95; } .vtk-badge.programado::before { background:#8b5cf6; }

/* ── Fechas ── */
.vtk-dates-grid { display:grid; grid-template-columns:1fr 1fr; gap:10px; }
.vtk-date-item  { display:flex; align-items:flex-start; gap:10px; background:#f8fafd; border:1px solid #e8eef8; border-radius:10px; padding:10px 12px; }
.vtk-date-dot   { width:8px; height:8px; border-radius:50%; margin-top:4px; flex-shrink:0; }
.vtk-dot-blue   { background:#3b82f6; box-shadow:0 0 6px #3b82f680; }
.vtk-dot-violet { background:#8b5cf6; box-shadow:0 0 6px #8b5cf680; }
.vtk-dot-orange { background:#f97316; box-shadow:0 0 6px #f9731680; }
.vtk-dot-green  { background:#22c55e; box-shadow:0 0 6px #22c55e80; }
.vtk-date-val   { font-size:13px; font-weight:600; color:#1e3a5f; margin-top:2px; font-family:'Courier New',monospace; }

/* ── Evidencia ── */
.vtk-ev-box {
    background:#f8fafd; border:1px solid #e8eef8;
    border-radius:12px; padding:14px;
    min-height:48px; display:flex; align-items:center; justify-content:center;
}
.vtk-ev-box.vtk-empty::before { content:'— Sin archivos adjuntos —'; color:#c0cfe4; font-size:13px; font-style:italic; }
.vtk-ev-grid { display:grid; grid-template-columns:repeat(auto-fill,minmax(120px,1fr)); gap:10px; width:100%; }
.vtk-ev-item { border:1px solid #e8eef8; border-radius:10px; overflow:hidden; background:#fff; display:flex; flex-direction:column; align-items:center; }
.vtk-ev-thumb { width:100%; height:100px; object-fit:cover; cursor:zoom-in; transition:opacity .15s; display:block; }
.vtk-ev-thumb:hover { opacity:.85; }
.vtk-ev-name { font-size:10px; color:#64748b; padding:6px 8px; text-align:center; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; width:100%; box-sizing:border-box; border-top:1px solid #f0f4fa; }
.vtk-ev-file { width:100%; height:100px; display:flex; flex-direction:column; align-items:center; justify-content:center; gap:6px; color:#1a6ed8; text-decoration:none; background:#eff6ff; transition:background .15s; }
.vtk-ev-file:hover { background:#dbeafe; }
.vtk-ev-file span { font-size:10px; font-weight:600; text-transform:uppercase; color:#1e40af; }

/* ── Footer ── */
.vtk-footer {
    display:flex; gap:10px; justify-content:flex-end;
    padding:16px 24px; border-top:1px solid #f0f4fa;
    background:#fafbfd; border-radius:0 0 20px 20px; flex-shrink:0;
}
.vtk-btn-ghost {
    background:transparent; border:1px solid #d1dce8; color:#64748b;
    border-radius:10px; padding:9px 20px; font-size:13px; font-weight:500;
    cursor:pointer; transition:all .15s;
}
.vtk-btn-ghost:hover { background:#f1f5f9; border-color:#b0bec5; }

/* ── Responsive ── */
@media (max-width:640px) {
    .vtk-row-3, .vtk-row-2 { grid-template-columns:1fr; }
    .vtk-dates-grid { grid-template-columns:1fr; }
    .vtk-section, .vtk-body { padding-left:14px; padding-right:14px; }
}
@media (max-width:480px) {
    .vtk-footer { flex-direction:column-reverse; }
    .vtk-btn-ghost { width:100%; text-align:center; }
}
</style>

<script>
// ── Utilidades ──────────────────────────────────────────
function vtkFill(id, val) {
    const el = document.getElementById(id);
    if (!el) return;
    const empty = !val || String(val) === 'null' || String(val).trim() === '' || String(val).trim() === ' ';
    if (empty) { el.textContent = ''; el.classList.add('vtk-empty'); }
    else       { el.textContent = val; el.classList.remove('vtk-empty'); }
}
function vtkShow(id) { const el = document.getElementById(id); if (el) el.style.display = ''; }
function vtkHide(id) { const el = document.getElementById(id); if (el) el.style.display = 'none'; }

// ── Lightbox ────────────────────────────────────────────
function vtk_openLightbox(url, type) {
    const lb   = document.getElementById('vtk-lightbox');
    const img  = document.getElementById('vtk-lb-img');
    const vid  = document.getElementById('vtk-lb-video');
    const vsrc = document.getElementById('vtk-lb-vsrc');
    if (type === 'video') {
        img.style.display = 'none'; vid.style.display = 'block';
        vsrc.src = url; vid.load(); vid.play();
    } else {
        vid.pause(); vid.style.display = 'none';
        img.style.display = 'block'; img.src = url;
    }
    lb.style.display = 'flex';
}
function vtk_closeLightbox() {
    document.getElementById('vtk-lb-video').pause();
    document.getElementById('vtk-lightbox').style.display = 'none';
}

// ── Render archivos ─────────────────────────────────────
function vtkRenderArchivos(boxId, lista) {
    const box = document.getElementById(boxId);
    box.innerHTML = ''; box.classList.remove('vtk-empty');
    box.style.cssText = 'align-items:center;justify-content:center;';

    if (!lista || lista.length === 0) { box.classList.add('vtk-empty'); return; }

    box.style.cssText = 'align-items:stretch;justify-content:flex-start;';
    const grid = document.createElement('div');
    grid.className = 'vtk-ev-grid';

    lista.forEach(ev => {
        const nombre = ev.nombre_original ?? 'Archivo';
        const ruta   = ev.ruta_archivo ?? ev.archivo_reporte ?? '';
        const ext    = ruta.split('.').pop().toLowerCase();
        const url    = '/storage/' + ruta;
        const item   = document.createElement('div');
        item.className = 'vtk-ev-item';

        if (['jpg','jpeg','png','gif','webp'].includes(ext)) {
            item.innerHTML = `<img src="${url}" alt="${nombre}" class="vtk-ev-thumb" onclick="vtk_openLightbox('${url}','image')"><div class="vtk-ev-name" title="${nombre}">${nombre}</div>`;
        } else if (['mp4','mov','webm'].includes(ext)) {
            item.innerHTML = `<video style="width:100%;height:100px;object-fit:cover;display:block;cursor:pointer;" onclick="vtk_openLightbox('${url}','video')" muted><source src="${url}"></video><div class="vtk-ev-name" title="${nombre}">${nombre}</div>`;
        } else if (ext === 'pdf') {
            item.innerHTML = `<a href="${url}" target="_blank" class="vtk-ev-file" style="background:#fef2f2;"><svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#dc2626" stroke-width="1.5"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg><span style="color:#dc2626;">PDF</span></a><div class="vtk-ev-name" title="${nombre}">${nombre}</div>`;
        } else {
            item.innerHTML = `<a href="${url}" target="_blank" class="vtk-ev-file"><svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg><span>${ext.toUpperCase()}</span></a><div class="vtk-ev-name" title="${nombre}">${nombre}</div>`;
        }
        grid.appendChild(item);
    });
    box.appendChild(grid);
}

// ── Abrir modal con fetch ───────────────────────────────
window.abrirDetalleTicket = async function(ticketId, notifId = null) {
    if (!ticketId) return;

    const overlay = document.getElementById('vtk-overlay');
    overlay.style.display = 'flex';

    // Mostrar loading, ocultar contenido
    document.getElementById('vtk-loading').style.display = 'flex';
    document.getElementById('vtk-content').style.display = 'none';
    document.getElementById('vtk-code').textContent = '...';
    document.getElementById('vtk-estado').innerHTML  = '';

    try {
        const res  = await fetch(`/cliente/ticket/${ticketId}/detalle`, {
            headers: { 'Accept': 'application/json' }
        });
        const data = await res.json();

        if (!data.ok) {
            overlay.style.display = 'none';
            if (typeof showNotification === 'function')
                showNotification('danger', 'Error', data.message || 'No se pudo cargar el ticket.');
            return;
        }

        vtk_render(data.ticket);

        // Quitar notificación del navbar si viene desde allí
        if (notifId && typeof window.navbarQuitarNotificacion === 'function') {
            window.navbarQuitarNotificacion(notifId);
        }

    } catch(e) {
        overlay.style.display = 'none';
        if (typeof showNotification === 'function')
            showNotification('danger', 'Error de conexión', 'No se pudo cargar el ticket.');
    }
};

// ── Render datos en el modal ────────────────────────────
function vtk_render(t) {
    const estado = t.estado ?? 'PENDIENTE';

    // Header
    document.getElementById('vtk-code').textContent = t.codigo_ticket ?? '—';
    const estadoMap = { 'PENDIENTE':'pendiente','PROGRAMADO':'programado','EN PROCESO':'en_proceso','CERRADO':'resuelto','CANCELADO':'cancelado' };
    const eCls = estadoMap[estado] ?? 'pendiente';
    document.getElementById('vtk-estado').innerHTML = `<span class="vtk-badge ${eCls}">${estado}</span>`;

    // Usuario
    vtkFill('vtk-usu-nombre', t.usuario_nombre);
    vtkFill('vtk-usu-codigo', t.codigo_usuario);
    vtkFill('vtk-usu-tel',    t.usuario_telefono);

    // Clasificación
    vtkFill('vtk-tipo', t.tipo_ticket_nombre);
    const pColor = t.prioridad_color ?? '#1a6ed8';
    document.getElementById('vtk-prioridad').innerHTML = t.prioridad_nombre
        ? `<span style="display:inline-flex;align-items:center;gap:6px;padding:4px 12px;border-radius:20px;font-size:12px;font-weight:600;background:${pColor}18;color:${pColor};border:1px solid ${pColor}30;"><span style="width:7px;height:7px;border-radius:50%;background:${pColor};display:inline-block;"></span>${t.prioridad_nombre}</span>`
        : '<span style="color:#c0cfe4;font-style:italic;">—</span>';
    document.getElementById('vtk-prioridad').classList.remove('vtk-empty');

    // Equipo y solicitud
    vtkFill('vtk-tipo-equipo', t.tipo_equipo);
    vtkFill('vtk-marca',       t.marca);
    vtkFill('vtk-modelo',      t.modelo);
    vtkFill('vtk-serial',      t.serie_serial);
    vtkFill('vtk-asunto',      t.asunto);
    vtkFill('vtk-problema',    t.problema);

    // Fechas
    document.getElementById('vtk-f-creado').textContent = t.created_at?.substring(0,10)        || '—';
    document.getElementById('vtk-f-prog').textContent   = t.fecha_programado?.substring(0,10)  || '—';
    document.getElementById('vtk-f-proc').textContent   = t.fecha_en_proceso?.substring(0,10)  || '—';
    document.getElementById('vtk-f-res').textContent    = t.fecha_resuelto?.substring(0,10)    || '—';

    // Evidencias
    vtkRenderArchivos('vtk-evidencia', t.evidencias ?? []);

    // Ocultar secciones opcionales
    vtkHide('vtk-sec-tecnico');
    vtkHide('vtk-sec-proceso');
    vtkHide('vtk-sec-com-ini');
    vtkHide('vtk-sec-reporte');
    vtkHide('vtk-sec-com-fin');

    const fase = { 'PENDIENTE':1,'PROGRAMADO':2,'EN PROCESO':3,'CERRADO':4,'CANCELADO':5 }[estado] ?? 1;

    if (fase >= 2) {
        vtkShow('vtk-sec-tecnico');
        vtkFill('vtk-tecnico',     t.tecnico_nombre);
        vtkFill('vtk-tecnico-cod', t.tecnico_codigo);
    }

    if (fase >= 3) {
        const comentarios = t.comentarios ?? [];
        const reportes    = t.reportes    ?? [];
        let   hayAlgo     = false;

        if (comentarios.length >= 1) {
            vtkShow('vtk-sec-com-ini');
            vtkFill('vtk-com-ini', comentarios[0].comentario);
            document.getElementById('vtk-com-ini-fecha').textContent = comentarios[0].created_at?.substring(0,10) ?? '';
            hayAlgo = true;
        }
        if (reportes.length >= 1) {
            vtkShow('vtk-sec-reporte');
            vtkRenderArchivos('vtk-reporte', reportes);
            hayAlgo = true;
        }
        if (comentarios.length >= 2) {
            vtkShow('vtk-sec-com-fin');
            const ultimo = comentarios[comentarios.length - 1];
            vtkFill('vtk-com-fin', ultimo.comentario);
            document.getElementById('vtk-com-fin-fecha').textContent = ultimo.created_at?.substring(0,10) ?? '';
            hayAlgo = true;
        }
        if (hayAlgo) vtkShow('vtk-sec-proceso');
    }

    // Mostrar contenido, ocultar loading
    document.getElementById('vtk-loading').style.display = 'none';
    document.getElementById('vtk-content').style.display = 'block';
}

// ── Cerrar ──────────────────────────────────────────────
function vtk_close() {
    document.getElementById('vtk-lb-video')?.pause();
    document.getElementById('vtk-lightbox').style.display = 'none';
    document.getElementById('vtk-overlay').style.display  = 'none';
}

document.addEventListener('keydown', e => {
    if (e.key === 'Escape') { vtk_closeLightbox(); vtk_close(); }
});
</script>
