{{-- ══ MODAL CREAR TÉCNICO (ADMIN) ══ --}}
<div id="modalCrearTecnico" style="display:none;position:fixed;inset:0;z-index:9999;background:rgba(10,5,25,0.72);backdrop-filter:blur(6px);align-items:center;justify-content:center;">
    <div style="width:100%;max-width:540px;margin:16px;animation:tSlideIn .3s cubic-bezier(.16,1,.3,1)">
        <div style="background:#fff;border-radius:20px;overflow:hidden;box-shadow:0 30px 60px rgba(0,0,0,.35)">

            {{-- Header --}}
            <div style="background:linear-gradient(135deg,#4c1d95,#7c3aed);padding:22px 28px;display:flex;align-items:center;justify-content:space-between">
                <div style="display:flex;align-items:center;gap:14px">
                    <div style="width:40px;height:40px;background:rgba(255,255,255,.2);border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:20px">🔧</div>
                    <div>
                        <div style="color:#fff;font-weight:700;font-size:1.1rem;font-family:'Segoe UI',sans-serif">Registrar Técnico</div>
                        <div style="color:rgba(255,255,255,.7);font-size:.75rem">Código y correo autogenerados</div>
                    </div>
                </div>
                <button onclick="cerrarModalTecnico()" style="background:rgba(255,255,255,.15);border:none;color:#fff;width:32px;height:32px;border-radius:8px;cursor:pointer;font-size:16px;display:flex;align-items:center;justify-content:center;transition:.2s" onmouseover="this.style.background='rgba(239,68,68,.7)'" onmouseout="this.style.background='rgba(255,255,255,.15)'">✕</button>
            </div>

            {{-- Body --}}
            <div style="padding:26px 28px 10px;font-family:'Segoe UI',sans-serif">

                {{-- Nombre + Apellido Paterno --}}
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:16px">
                    <div>
                        <label style="font-size:.78rem;font-weight:600;color:#374151;display:block;margin-bottom:5px">Nombre <span style="color:#7c3aed">*</span></label>
                        <input id="tec_nombre" type="text" placeholder="Ej. Carlos"
                               style="width:100%;padding:10px 13px;border:2px solid #ede9fe;border-radius:10px;font-size:.9rem;outline:none;transition:.2s;box-sizing:border-box;background:#faf8ff;color:#1e1b4b"
                               onfocus="this.style.borderColor='#7c3aed';this.style.background='#fff'"
                               onblur="this.style.borderColor='#ede9fe';this.style.background='#faf8ff'"
                               oninput="this.value = this.value.replace(/[^a-zA-ZáéíóúÁÉÍÓÚñÑ\s]/g, ''); generarDatosTecnico()">
                    </div>
                    <div>
                        <label style="font-size:.78rem;font-weight:600;color:#374151;display:block;margin-bottom:5px">Apellido Paterno <span style="color:#7c3aed">*</span></label>
                        <input id="tec_apellido_paterno" type="text" placeholder="Ej. García"
                               style="width:100%;padding:10px 13px;border:2px solid #ede9fe;border-radius:10px;font-size:.9rem;outline:none;transition:.2s;box-sizing:border-box;background:#faf8ff;color:#1e1b4b"
                               onfocus="this.style.borderColor='#7c3aed';this.style.background='#fff'"
                               onblur="this.style.borderColor='#ede9fe';this.style.background='#faf8ff'"
                               oninput="this.value = this.value.replace(/[^a-zA-ZáéíóúÁÉÍÓÚñÑ\s]/g, ''); generarDatosTecnico()">
                    </div>
                </div>

                {{-- Apellido Materno + DNI --}}
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:16px">
                    <div>
                        <label style="font-size:.78rem;font-weight:600;color:#374151;display:block;margin-bottom:5px">Apellido Materno <span style="color:#7c3aed">*</span></label>
                        <input id="tec_apellido_materno" type="text" placeholder="Ej. López"
                               style="width:100%;padding:10px 13px;border:2px solid #ede9fe;border-radius:10px;font-size:.9rem;outline:none;transition:.2s;box-sizing:border-box;background:#faf8ff;color:#1e1b4b"
                               onfocus="this.style.borderColor='#7c3aed';this.style.background='#fff'"
                               onblur="this.style.borderColor='#ede9fe';this.style.background='#faf8ff'"
                               oninput="this.value = this.value.replace(/[^a-zA-ZáéíóúÁÉÍÓÚñÑ\s]/g, ''); generarDatosTecnico()">
                    </div>
                    <div>
                        <label style="font-size:.78rem;font-weight:600;color:#374151;display:block;margin-bottom:5px">DNI <span style="color:#7c3aed">*</span></label>
                        <input id="tec_dni" type="text" placeholder="8 dígitos" maxlength="8"
                               oninput="this.value=this.value.replace(/[^0-9]/g,'');generarDatosTecnico()"
                               style="width:100%;padding:10px 13px;border:2px solid #ede9fe;border-radius:10px;font-size:.9rem;outline:none;transition:.2s;box-sizing:border-box;background:#faf8ff;color:#1e1b4b"
                               onfocus="this.style.borderColor='#7c3aed';this.style.background='#fff'"
                               onblur="this.style.borderColor='#ede9fe';this.style.background='#faf8ff'">
                    </div>
                </div>

                {{-- Correo real --}}
                {{-- código oculto usado solo por el JS --}}
                <div id="tec_codigo_preview" style="display:none"></div>
                <div style="margin-bottom:6px">
                    <label style="font-size:.78rem;font-weight:600;color:#374151;display:block;margin-bottom:5px">
                        Correo Gmail del técnico <span style="color:#7c3aed">*</span>
                        <span style="font-size:.7rem;color:#6b7280;font-weight:400"> — recibirá las credenciales aquí</span>
                    </label>
                    <input id="tec_correo" type="email" placeholder="tecnico@gmail.com"
                           style="width:100%;padding:10px 13px;border:2px solid #ede9fe;border-radius:10px;font-size:.9rem;outline:none;transition:.2s;box-sizing:border-box;background:#faf8ff;color:#1e1b4b"
                           onfocus="this.style.borderColor='#7c3aed';this.style.background='#fff'"
                           onblur="this.style.borderColor='#ede9fe';this.style.background='#faf8ff'">
                </div>

            </div>

            {{-- Footer --}}
            <div style="padding:14px 28px 24px;display:flex;gap:10px;justify-content:flex-end">
                <button onclick="cerrarModalTecnico()" style="padding:10px 22px;border-radius:10px;border:2px solid #ede9fe;background:#fff;color:#6b7280;font-weight:600;cursor:pointer;font-size:.9rem;transition:.2s" onmouseover="this.style.background='#f5f3ff'" onmouseout="this.style.background='#fff'">Cancelar</button>
                <button id="btnGuardarTecnico" onclick="guardarTecnico()" style="padding:10px 26px;border-radius:10px;border:none;background:linear-gradient(135deg,#4c1d95,#7c3aed);color:#fff;font-weight:700;cursor:pointer;font-size:.9rem;box-shadow:0 4px 12px rgba(124,58,237,.3);transition:.2s" onmouseover="this.style.transform='translateY(-1px)'" onmouseout="this.style.transform='none'">Guardar Técnico</button>
            </div>
        </div>
    </div>
</div>

<style>
@keyframes tSlideIn { from{transform:translateY(-20px) scale(.97);opacity:0} to{transform:none;opacity:1} }

/* Responsive modal */
@media (max-width: 540px) {
  #modalCrearTecnico > div { margin: 8px !important; }
  #modalCrearTecnico [style*="grid-template-columns:1fr 1fr"],
  #modalCrearTecnico [style*="grid-template-columns: 1fr 1fr"] {
    grid-template-columns: 1fr !important;
  }
  #modalCrearTecnico [style*="padding:26px 28px"] {
    padding: 16px 14px !important;
  }
  #modalCrearTecnico [style*="padding:22px 28px"] {
    padding: 16px !important;
  }
}
</style>

<script>
const _tecCodigosUsados = new Set();

function abrirModalTecnico() {
    const m = document.getElementById('modalCrearTecnico');
    m.style.display = 'flex';
    ['tec_nombre','tec_apellido_paterno','tec_apellido_materno','tec_dni','tec_correo'].forEach(id => {
        const el = document.getElementById(id);
        if (el) el.value = '';
    });
    document.getElementById('tec_codigo_preview').textContent = '———';
    const btn = document.getElementById('btnGuardarTecnico');
    btn.disabled         = false;
    btn.textContent      = 'Guardar Técnico';
    btn.style.background = 'linear-gradient(135deg,#4c1d95,#7c3aed)';
}

function cerrarModalTecnico() {
    document.getElementById('modalCrearTecnico').style.display = 'none';
}

function normStr(str) {
    return str.toLowerCase().normalize('NFD').replace(/[\u0300-\u036f]/g,'').replace(/[^a-z]/g,'');
}

function generarDatosTecnico() {
    // Tomamos los valores limpios eliminando espacios extras en los extremos
    const n   = document.getElementById('tec_nombre').value.trim();
    const ap  = document.getElementById('tec_apellido_paterno').value.trim();
    const am  = document.getElementById('tec_apellido_materno').value.trim();
    const dni = document.getElementById('tec_dni').value.trim();

    // Ahora validamos que los 4 campos tengan información coherente antes de previsualizar
    if (!n || !ap || !am || dni.length < 3) {
        const el = document.getElementById('tec_codigo_preview');
        if (el) el.textContent = '———';
        return;
    }

    // Extraemos las iniciales limpias de tildes/eñes
    const i1 = normStr(n).charAt(0).toUpperCase();
    const i2 = normStr(ap).charAt(0).toUpperCase();
    const i3 = normStr(am).charAt(0).toUpperCase();
    const d3 = dni.substring(0, 3);

    // Formamos el código base inicial (Ej: TGL123)
    let codigo = i1 + i2 + i3 + d3;
    let idx = 3;
    
    // Evitamos duplicados locales si el set ya conoce este código temporal
    while (_tecCodigosUsados.has(codigo) && idx < dni.length) {
        codigo = i1 + i2 + i3 + dni.substring(0, idx + 1);
        idx++;
    }

    // Seteamos la vista previa del código en tiempo real
    document.getElementById('tec_codigo_preview').textContent = codigo;
}

async function guardarTecnico() {
    const btn = document.getElementById('btnGuardarTecnico');
    const n   = document.getElementById('tec_nombre').value.trim();
    const ap  = document.getElementById('tec_apellido_paterno').value.trim();
    const am  = document.getElementById('tec_apellido_materno').value.trim();
    const dni = document.getElementById('tec_dni').value.trim();
    const correo = document.getElementById('tec_correo').value.trim();

    // ── Validaciones ──────────────────────────────────────────────────────
    const errores = [];
    if (!n)   errores.push('El nombre es obligatorio.');
    if (!ap)  errores.push('El apellido paterno es obligatorio.');
    if (!am)  errores.push('El apellido materno es obligatorio.');
    if (!dni) errores.push('El DNI es obligatorio.');
    else if (dni.length !== 8) errores.push('El DNI debe tener 8 dígitos.');
    if (!correo) errores.push('El correo del técnico es obligatorio.');
    else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(correo)) errores.push('El correo no tiene un formato válido.');

    if (errores.length > 0) {
        errores.forEach(e => showNotification('danger', 'Error', e));
        return;
    }

    const codigo = document.getElementById('tec_codigo_preview').textContent;

    if (codigo === '———') {
        showNotification('danger', 'Error', 'Completa los datos para generar el código.');
        return;
    }

    // Estructura de datos exacta para el backend en Laravel
    const datos = {
        nombre:           n,
        apellido_paterno: ap,
        apellido_materno: am,
        dni,
        correo,
        contrasena:       dni,
        codigo_tecnico:   codigo
    };

    btn.disabled    = true;
    btn.textContent = 'Guardando…';

    try {
        const res  = await fetch('{{ route("admin.tecnico.guardar") }}', {
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
            cerrarModalTecnico();
            setTimeout(() => {
                ModalSystem.show('success', {
                    title: '¡Técnico registrado!',
                    text:  `
                        <div style="text-align:center;">
                            <div style="font-size:48px;margin-bottom:12px;">📧</div>
                            <p style="font-size:14px;color:#374151;margin-bottom:8px;">
                                El técnico <strong>${n} ${ap}</strong> fue registrado con el código <strong style="color:#6d28d9;">${codigo}</strong>.
                            </p>
                            <p style="font-size:13px;color:#6b7280;">
                                Se enviaron las credenciales de acceso a:
                            </p>
                            <div style="margin-top:10px;padding:10px 16px;background:#f5f3ff;border:1px solid #ddd6fe;border-radius:10px;font-size:14px;font-weight:600;color:#6d28d9;">
                                📬 ${correo}
                            </div>
                            <p style="font-size:12px;color:#9ca3af;margin-top:10px;">
                                Pídele al técnico que revise su bandeja de entrada o spam.
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
        btn.textContent      = 'Guardar Técnico';
        btn.style.background = 'linear-gradient(135deg,#4c1d95,#7c3aed)';
    }
}
</script>