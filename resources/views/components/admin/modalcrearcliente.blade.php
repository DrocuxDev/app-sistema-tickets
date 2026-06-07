{{-- ══ MODAL CREAR CLIENTE (ADMIN) ══ --}}
<div id="modalCrearCliente" style="display:none;position:fixed;inset:0;z-index:9999;background:rgba(10,15,30,0.7);backdrop-filter:blur(6px);align-items:center;justify-content:center;">
    <div style="width:100%;max-width:520px;margin:16px;animation:acSlideIn .3s cubic-bezier(.16,1,.3,1)">
        <div style="background:#fff;border-radius:20px;overflow:hidden;box-shadow:0 30px 60px rgba(0,0,0,.3)">

            {{-- Header --}}
            <div style="background:linear-gradient(135deg,#0f4c81,#1a73e8);padding:22px 28px;display:flex;align-items:center;justify-content:space-between">
                <div style="display:flex;align-items:center;gap:14px">
                    <div style="width:40px;height:40px;background:rgba(255,255,255,.2);border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:20px">🏢</div>
                    <div>
                        <div style="color:#fff;font-weight:700;font-size:1.1rem;font-family:'Segoe UI',sans-serif">Registrar Cliente</div>
                        <div style="color:rgba(255,255,255,.7);font-size:.75rem">Empresa / Organización</div>
                    </div>
                </div>
                <button onclick="cerrarModalCliente()" style="background:rgba(255,255,255,.15);border:none;color:#fff;width:32px;height:32px;border-radius:8px;cursor:pointer;font-size:16px;display:flex;align-items:center;justify-content:center;transition:.2s" onmouseover="this.style.background='rgba(239,68,68,.7)'" onmouseout="this.style.background='rgba(255,255,255,.15)'">✕</button>
            </div>

            {{-- Body --}}
            <div class="modal-form-scroll" style="padding:26px 28px 10px;font-family:'Segoe UI',sans-serif">

                {{-- Razón Social + RUC --}}
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:16px">
                    <div>
                        <label style="font-size:.78rem;font-weight:600;color:#374151;display:block;margin-bottom:5px">Razón Social <span style="color:#ef4444">*</span></label>
                        <input id="cli_razon_social" type="text" placeholder="Ej. Empresa SAC"
                               style="width:100%;padding:10px 13px;border:2px solid #e5e7eb;border-radius:10px;font-size:.9rem;outline:none;transition:.2s;box-sizing:border-box;background:#f9fafb;color:#111827"
                               onfocus="this.style.borderColor='#1a73e8';this.style.background='#fff'"
                               onblur="this.style.borderColor='#e5e7eb';this.style.background='#f9fafb'"
                               oninput="generarDatosCliente()">
                    </div>
                    <div>
                        <label style="font-size:.78rem;font-weight:600;color:#374151;display:block;margin-bottom:5px">RUC <span style="color:#ef4444">*</span></label>
                        <input id="cli_ruc" type="text" placeholder="11 dígitos" maxlength="11"
                               oninput="this.value=this.value.replace(/[^0-9]/g,'');generarDatosCliente()"
                               style="width:100%;padding:10px 13px;border:2px solid #e5e7eb;border-radius:10px;font-size:.9rem;outline:none;transition:.2s;box-sizing:border-box;background:#f9fafb;color:#111827"
                               onfocus="this.style.borderColor='#1a73e8';this.style.background='#fff'"
                               onblur="this.style.borderColor='#e5e7eb';this.style.background='#f9fafb'">
                    </div>
                </div>

                {{-- Sedes + Rubro --}}
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:16px">
                    <div>
                        <label style="font-size:.78rem;font-weight:600;color:#374151;display:block;margin-bottom:5px">Sedes</label>
                        <input id="cli_sedes" type="text" placeholder="Ej. Lima, Arequipa"
                               style="width:100%;padding:10px 13px;border:2px solid #e5e7eb;border-radius:10px;font-size:.9rem;outline:none;transition:.2s;box-sizing:border-box;background:#f9fafb;color:#111827"
                               onfocus="this.style.borderColor='#1a73e8';this.style.background='#fff'"
                               onblur="this.style.borderColor='#e5e7eb';this.style.background='#f9fafb'">
                    </div>
                    <div>
                        <label style="font-size:.78rem;font-weight:600;color:#374151;display:block;margin-bottom:5px">Rubro</label>
                        <input id="cli_rubro" type="text" placeholder="Ej. Tecnología"
                               style="width:100%;padding:10px 13px;border:2px solid #e5e7eb;border-radius:10px;font-size:.9rem;outline:none;transition:.2s;box-sizing:border-box;background:#f9fafb;color:#111827"
                               onfocus="this.style.borderColor='#1a73e8';this.style.background='#fff'"
                               onblur="this.style.borderColor='#e5e7eb';this.style.background='#f9fafb'">
                    </div>
                </div>

                {{-- Correo real --}}
                <div style="margin-bottom:16px">
                    <label style="font-size:.78rem;font-weight:600;color:#374151;display:block;margin-bottom:5px">
                        Correo del cliente <span style="color:#ef4444">*</span>
                        <span style="font-size:.7rem;color:#6b7280;font-weight:400"> — recibirá las credenciales aquí</span>
                    </label>
                    <input id="cli_correo" type="email" placeholder="ejemplo@gmail.com"
                           style="width:100%;padding:10px 13px;border:2px solid #e5e7eb;border-radius:10px;font-size:.9rem;outline:none;transition:.2s;box-sizing:border-box;background:#f9fafb;color:#111827"
                           onfocus="this.style.borderColor='#1a73e8';this.style.background='#fff'"
                           onblur="this.style.borderColor='#e5e7eb';this.style.background='#f9fafb'">
                </div>

                {{-- Contraseña --}}
                <div style="margin-bottom:6px">
                    <label style="font-size:.78rem;font-weight:600;color:#374151;display:block;margin-bottom:5px">
                        Contraseña de acceso <span style="color:#ef4444">*</span>
                        <span style="font-size:.7rem;color:#6b7280;font-weight:400"> — mín. 6 caracteres</span>
                    </label>
                    <div class="pass-field-wrap">
                        <input id="cli_contrasena" type="password" placeholder="Ingresa la contraseña" minlength="6" autocomplete="new-password"
                               style="padding:10px 13px;border:2px solid #e5e7eb;border-radius:10px;font-size:.9rem;outline:none;transition:.2s;background:#f9fafb;color:#111827"
                               onfocus="this.style.borderColor='#1a73e8';this.style.background='#fff'"
                               onblur="this.style.borderColor='#e5e7eb';this.style.background='#f9fafb'">
                        <button type="button" class="modal-toggle-pass" onclick="togglePassField('cli_contrasena','cli_contrasena_eye')" aria-label="Mostrar contraseña">
                            <svg id="cli_contrasena_eye" width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            {{-- Footer --}}
            <div class="modal-form-footer" style="padding:14px 28px 24px;display:flex;gap:10px;justify-content:flex-end">
                <button onclick="cerrarModalCliente()" style="padding:10px 22px;border-radius:10px;border:2px solid #e5e7eb;background:#fff;color:#6b7280;font-weight:600;cursor:pointer;font-size:.9rem;transition:.2s" onmouseover="this.style.background='#f3f4f6'" onmouseout="this.style.background='#fff'">Cancelar</button>
                <button id="btnGuardarCliente" onclick="guardarCliente()" style="padding:10px 26px;border-radius:10px;border:none;background:linear-gradient(135deg,#0f4c81,#1a73e8);color:#fff;font-weight:700;cursor:pointer;font-size:.9rem;box-shadow:0 4px 12px rgba(26,115,232,.3);transition:.2s" onmouseover="this.style.transform='translateY(-1px)'" onmouseout="this.style.transform='none'">Guardar Cliente</button>
            </div>
        </div>
    </div>
</div>

<style>
@keyframes acSlideIn { from{transform:translateY(-20px) scale(.97);opacity:0} to{transform:none;opacity:1} }
#modalCrearCliente > div > div { max-height:92vh; display:flex; flex-direction:column; }
#modalCrearCliente .modal-form-scroll { overflow-y:auto; flex:1; min-height:0; -webkit-overflow-scrolling:touch; }
#modalCrearCliente .modal-form-footer { flex-shrink:0; }
@media (max-width:540px) {
  #modalCrearCliente > div { margin:8px !important; }
  #modalCrearCliente [style*="grid-template-columns:1fr 1fr"],
  #modalCrearCliente [style*="grid-template-columns: 1fr 1fr"] { grid-template-columns:1fr !important; }
  #modalCrearCliente [style*="padding:26px 28px"] { padding:16px 14px !important; }
}
</style>

<script>
function abrirModalCliente() {
    const m = document.getElementById('modalCrearCliente');
    m.style.display = 'flex';
    document.getElementById('cli_razon_social').value = '';
    document.getElementById('cli_ruc').value          = '';
    document.getElementById('cli_sedes').value        = '';
    document.getElementById('cli_rubro').value        = '';
    document.getElementById('cli_correo').value       = '';
    resetPassField('cli_contrasena', 'cli_contrasena_eye');
    const btn = document.getElementById('btnGuardarCliente');
    btn.disabled         = false;
    btn.textContent      = 'Guardar Cliente';
    btn.style.background = 'linear-gradient(135deg,#0f4c81,#1a73e8)';
}

function cerrarModalCliente() {
    document.getElementById('modalCrearCliente').style.display = 'none';
}

function generarDatosCliente() { /* preview eliminado */ }

async function guardarCliente() {
    const btn    = document.getElementById('btnGuardarCliente');
    const rs     = document.getElementById('cli_razon_social').value.trim();
    const ruc    = document.getElementById('cli_ruc').value.trim();
    const correo    = document.getElementById('cli_correo').value.trim();
    const contrasena = document.getElementById('cli_contrasena').value;

    const errores = [];
    if (!rs)                    errores.push('La razón social es obligatoria.');
    if (!ruc)                   errores.push('El RUC es obligatorio.');
    else if (ruc.length !== 11) errores.push('El RUC debe tener exactamente 11 dígitos.');
    if (!correo)                errores.push('El correo del cliente es obligatorio.');
    else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(correo)) errores.push('El correo no tiene un formato válido.');
    if (!contrasena)            errores.push('La contraseña es obligatoria.');
    else if (contrasena.length < 6) errores.push('La contraseña debe tener al menos 6 caracteres.');

    if (errores.length > 0) {
        errores.forEach(e => showNotification('danger', 'Error', e));
        return;
    }

    const datos = {
        razon_social: rs,
        ruc,
        sedes:      document.getElementById('cli_sedes').value.trim(),
        rubro:      document.getElementById('cli_rubro').value.trim(),
        correo,
        contrasena,
    };

    btn.disabled    = true;
    btn.textContent = 'Guardando…';

    try {
        const res  = await fetch('{{ route("admin.cliente.guardar") }}', {
            method:  'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept':       'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content
                                ?? '{{ csrf_token() }}'
            },
            body: JSON.stringify(datos)
        });

        const data = await res.json();

        if (!res.ok) {
            if (data.errors) {
                Object.values(data.errors).flat()
                      .forEach(e => showNotification('danger', 'Error', e));
            } else {
                showNotification('danger', 'Error', data.message || 'Error desconocido.');
            }
            return;
        }

        if (data.ok) {
            cerrarModalCliente();
            setTimeout(() => {
                ModalSystem.show('success', {
                    title: '¡Cliente registrado!',
                    text:  `
                        <div style="text-align:center;">
                            <div style="font-size:48px;margin-bottom:12px;">📧</div>
                            <p style="font-size:14px;color:#374151;margin-bottom:8px;">
                                La empresa <strong>${rs}</strong> fue creada correctamente.
                            </p>
                            <p style="font-size:13px;color:#6b7280;">
                                Se enviaron las credenciales de acceso a:
                            </p>
                            <div style="margin-top:10px;padding:10px 16px;background:#eff6ff;border:1px solid #bfdbfe;border-radius:10px;font-size:14px;font-weight:600;color:#1d4ed8;">
                                📬 ${correo}
                            </div>
                            <p style="font-size:12px;color:#9ca3af;margin-top:10px;">
                                Pídele al cliente que revise su bandeja de entrada o spam.
                            </p>
                        </div>`,
                    confirmText: 'Entendido',
                    onConfirm:   () => location.reload()
                });
            }, 300);
        }

    } catch (err) {
        showNotification('danger', 'Error de conexión', 'No se pudo conectar con el servidor.');
    } finally {
        btn.disabled         = false;
        btn.textContent      = 'Guardar Cliente';
        btn.style.background = 'linear-gradient(135deg,#0f4c81,#1a73e8)';
    }
}
</script>