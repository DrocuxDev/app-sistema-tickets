<div class="dashboard-layout">
    @include('components.notificaciones.alertas')
    @include('components.admin.navbar-admin')
    @include('components.admin.sidebar-admin')
    @include('components.admin.detalleticket')

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>

    <main class="main-content">
        <div class="content-wrapper">

            <div class="header">
                <h2>Mi Perfil de Administrador</h2>
                <p>Gestiona la información principal del administrador en JHARDSYSTEX</p>
            </div>

            <div class="profile-container">

                <form class="glass-form" id="perfil-form" method="POST" action="{{ route('admin.update') }}">
                    @csrf

                    {{-- Notificación de ÉXITO --}}
                        @if(session('success'))
                        <script>
                            document.addEventListener('DOMContentLoaded', function() {
                                ModalSystem.show('success', {
                                    title: '¡Perfil actualizado!',
                                    text: {!! json_encode(session('success'), JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) !!},
                                    confirmText: 'Entendido'
                                });
                            });
                        </script>
                        @endif

                        {{-- Notificación de ERROR --}}
                        @if(session('error'))
                        <script>
                            document.addEventListener('DOMContentLoaded', function() {
                                showNotification('danger', 'Error de validación', {!! json_encode(session('error'), JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) !!});
                            });
                        </script>
                        @endif

                    <div class="section-label">
                        <div class="section-icon">
                            <svg viewBox="0 0 20 20">
                                <path d="M10 2a4 4 0 100 8 4 4 0 000-8zm0 10c-3.33 0-6 2.67-6 6h12c0-3.33-2.67-6-6-6z"/>
                            </svg>
                        </div>
                        <span>Datos del Administrador</span>
                    </div>

                    <div class="form-grid">

                        <div class="input-group">
                            <label>Código de Administrador <small>(No editable)</small></label>
                            <input
                                type="text"
                                name="codigo_tecnico"
                                value="{{ $tecnico->codigo_tecnico }}"
                                class="input-readonly"
                                readonly
                            >
                        </div>

                        <div class="input-group">
                            <label>DNI <small>(No editable)</small></label>
                            <input
                                type="text"
                                name="dni"
                                value="{{ $tecnico->dni }}"
                                class="input-readonly"
                                readonly
                            >
                        </div>

                        <div class="input-group">
                            <label>Nombre</label>
                            <input
                                type="text"
                                name="nombre"
                                value="{{ old('nombre', $tecnico->nombre) }}"
                                maxlength="100"
                                required
                            >
                        </div>

                        <div class="input-group">
                            <label>Apellido Paterno</label>
                            <input
                                type="text"
                                name="apellido_paterno"
                                value="{{ old('apellido_paterno', $tecnico->apellido_paterno) }}"
                                maxlength="100"
                                required
                            >
                        </div>

                        <div class="input-group">
                            <label>Apellido Materno</label>
                            <input
                                type="text"
                                name="apellido_materno"
                                value="{{ old('apellido_materno', $tecnico->apellido_materno) }}"
                                maxlength="100"
                            >
                        </div>

                        <div class="input-group">
                            <label>Correo Electrónico<small>(No editable)</small></label>
                            <input
                                type="email"
                                name="correo"
                                value="{{ old('correo', $tecnico->correo) }}"
                                maxlength="120"
                                required
                                class="input-readonly"
                                readonly
                            >
                        </div>

                    </div>

                    <div class="section-label" style="margin-top: 30px;">
                        <div class="section-icon">
                            <svg viewBox="0 0 20 20"><path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.746 4.477a1 1 0 01-.769 1.134l-1.937.387a11.001 11.001 0 004.56 4.56l.387-1.937a1 1 0 011.134-.769l4.477.746a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"/></svg>
                        </div>
                        <span>Contacto</span>
                    </div>

                    <div class="form-grid">
                        <div class="input-group-phone">
                            <label>Teléfono</label>
                            <div class="phone-container">
                                <input type="hidden" id="codigo_pais" name="codigo_pais" value="{{ old('codigo_pais', $tecnico->codigo_pais ?? '+51') }}">
                                <input type="text" id="telefono" name="telefono" value="{{ old('telefono', $tecnico->telefono) }}" maxlength="15" required>
                            </div>
                        </div>
                    </div>

                    <div class="form-footer">

                        <div class="footer-hint">
                            <svg viewBox="0 0 20 20">
                                <path d="M10 2a8 8 0 100 16A8 8 0 0010 2zm1 11H9V9h2v4zm0-6H9V5h2v2z"/>
                            </svg>
                            Algunos datos están protegidos por seguridad
                        </div>

                        <div class="btn-actions">

                            <a href="{{ route('admin.dashboard') }}" class="btn-discard">
                                Cancelar
                            </a>

                            <button type="submit" class="btn-save" id="btn-guardar" disabled>

                                <svg viewBox="0 0 20 20">
                                    <path d="M15.7 5.3a1 1 0 010 1.4l-8 8a1 1 0 01-1.4 0l-4-4a1 1 0 011.4-1.4L7 12.6l8.3-8.3a1 1 0 011.4 0z"/>
                                </svg>

                                <span>Guardar Cambios</span>

                            </button>

                        </div>

                    </div>

                </form>

            </div>
        </div>
    </main>
</div>

<style>

.dashboard-layout {
    display: flex;
    min-height: 100vh;
}

.main-content {
    flex: 1;
    margin-left: 260px;
    padding: 40px;
    background: #eef4fb;
    transition: margin-left 0.35s cubic-bezier(.4,0,.2,1);
    min-width: 0;
}

body.sb-collapsed .main-content {
    margin-left: 70px;
}

.content-wrapper {
    width: 100%;
}

.header {
    margin-bottom: 28px;
}

.header h2 {
    font-size: 22px;
    font-weight: 600;
    color: #0a2d4a;
    margin-bottom: 6px;
}

.header p {
    font-size: 13.5px;
    color: #5a8ab5;
}

.glass-form {
    background: white;
    padding: 32px;
    border-radius: 16px;
    border: 0.5px solid #c8def5;
    box-shadow: 0 4px 20px rgba(10, 61, 107, 0.06);
}

.section-label {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 20px;
}

.section-icon {
    width: 30px;
    height: 30px;
    border-radius: 8px;
    background: #e6f1fb;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.section-icon svg {
    width: 15px;
    height: 15px;
    fill: #1a7fd4;
}

.section-label span {
    font-size: 13px;
    font-weight: 600;
    color: #0a3d6b;
    letter-spacing: 0.01em;
}

.form-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 18px;
}

.input-group {
    display: flex;
    flex-direction: column;
    gap: 6px;
}

.input-group label {
    font-size: 11.5px;
    font-weight: 600;
    color: #3a6a9a;
    letter-spacing: 0.03em;
    text-transform: uppercase;
    display: flex;
    align-items: center;
    gap: 6px;
}

.input-group input {
    padding: 11px 14px;
    border: 1px solid #d0e6f7;
    border-radius: 9px;
    font-size: 13.5px;
    color: #0a2d4a;
    background: white;
    outline: none;
    font-family: inherit;
    transition: border-color 0.2s, box-shadow 0.2s;
    width: 100%;
    box-sizing: border-box;
}

.input-group input:focus {
    border-color: #1a7fd4;
    box-shadow: 0 0 0 3px rgba(26, 127, 212, 0.1);
}

.input-readonly {
    background: #f5f9fe !important;
    color: #8aaac8 !important;
    cursor: not-allowed;
}

.input-group-phone {
    display: flex;
    flex-direction: column;
    gap: 6px;
}

.input-group-phone label {
    font-size: 11.5px;
    font-weight: 600;
    color: #3a6a9a;
    letter-spacing: 0.03em;
    text-transform: uppercase;
}

.phone-container { width: 100%; }
.iti { width: 100%; }

.phone-container input {
    padding: 11px 14px;
    padding-left: 90px !important;
    border: 1px solid #d0e6f7;
    border-radius: 9px;
    font-size: 13.5px;
    color: #0a2d4a;
    background: white;
    outline: none;
    font-family: inherit;
    transition: border-color 0.2s, box-shadow 0.2s;
    width: 100% !important;
    box-sizing: border-box;
}

.phone-container input:focus {
    border-color: #1a7fd4;
    box-shadow: 0 0 0 3px rgba(26, 127, 212, 0.1);
}

.form-footer {
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 14px;
    margin-top: 28px;
    padding-top: 22px;
    border-top: 1px solid #e8f2fb;
}

.footer-hint {
    display: flex;
    align-items: center;
    gap: 6px;
    font-size: 12px;
    color: #7aabcc;
}

.footer-hint svg {
    width: 13px;
    height: 13px;
    fill: #1a7fd4;
}

.btn-actions {
    display: flex;
    gap: 10px;
    align-items: center;
}

.btn-discard {
    padding: 10px 20px;
    border-radius: 8px;
    font-size: 13px;
    font-weight: 500;
    cursor: pointer;
    background: transparent;
    border: 1px solid #c8def5;
    color: #5a8ab5;
    font-family: inherit;
    text-decoration: none;
    transition: 0.2s;
}

.btn-discard:hover {
    background: #f0f6ff;
    color: #0a3d6b;
}

.btn-save {
    padding: 10px 24px;
    border-radius: 8px;
    font-size: 13px;
    font-weight: 500;
    cursor: pointer;
    background: #1a7fd4;
    border: none;
    color: white;
    font-family: inherit;
    transition: 0.2s;
    display: flex;
    align-items: center;
    gap: 7px;
}

.btn-save svg {
    width: 13px;
    height: 13px;
    fill: white;
}

.btn-save:hover {
    background: #0f5ea3;
    transform: translateY(-1px);
}

@media (min-width: 769px) and (max-width: 1024px) {
    .main-content {
        margin-left: 0 !important;
        padding-top: 80px;
    }
}

@media (max-width: 768px) {

    .main-content {
        margin-left: 0 !important;
        padding: 20px 16px;
        padding-top: 68px;
    }

    body.sb-collapsed .main-content {
        margin-left: 0 !important;
    }

    .form-grid {
        grid-template-columns: 1fr;
    }

    .glass-form {
        padding: 20px 16px;
    }

    .header h2 {
        font-size: 18px;
    }

    .header p {
        font-size: 12px;
    }
}

@media (max-width: 480px) {

    .main-content {
        padding: 15px 12px;
        padding-top: 68px;
    }

    .btn-actions {
        flex-direction: column;
        width: 100%;
    }

    .btn-save,
    .btn-discard {
        width: 100%;
        justify-content: center;
        text-align: center;
    }

    .form-footer {
        flex-direction: column;
        align-items: flex-start;
    }
}

</style>

<script>
    (function () {
        const form    = document.getElementById('perfil-form');
        const btnSave = document.getElementById('btn-guardar');
        const inputTelefono = document.getElementById('telefono');
        const inputCodigoPais = document.getElementById('codigo_pais');
        if (!form || !btnSave) return;

        let iti = null;
        if (inputTelefono && window.intlTelInput) {
            iti = window.intlTelInput(inputTelefono, {
                initialCountry: 'pe',
                separateDialCode: true,
                preferredCountries: ['pe', 'cl', 'co', 'ar'],
                utilsScript: 'https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js',
            });
        }

        const originales = {};
        form.querySelectorAll('input:not([readonly]):not([type="hidden"])').forEach(input => {
            originales[input.name] = input.value;
        });

        function limpiarSoloNumeros(e) {
            e.target.value = e.target.value.replace(/[^0-9]/g, '');
            verificarCambios();
        }

        if (inputTelefono) inputTelefono.addEventListener('input', limpiarSoloNumeros);

        function verificarCambios() {
            const hayCambio = Array.from(form.querySelectorAll('input:not([readonly]):not([type="hidden"])')).some(input => {
                return input.value !== originales[input.name];
            });

            btnSave.disabled = !hayCambio;
            btnSave.style.opacity       = hayCambio ? '1'   : '0.45';
            btnSave.style.cursor        = hayCambio ? 'pointer' : 'not-allowed';
            btnSave.style.pointerEvents = hayCambio ? 'auto' : 'none';
        }

        form.querySelectorAll('input:not([readonly]):not([type="hidden"])').forEach(input => {
            input.addEventListener('input', verificarCambios);
        });

        form.addEventListener('submit', function () {
            if (iti) {
                inputCodigoPais.value = '+' + iti.getSelectedCountryData().dialCode;
            }
        });

        verificarCambios();
    })();
    </script>   