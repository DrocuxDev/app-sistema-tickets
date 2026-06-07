{{--
╔═══════════════════════════════════════════════════════════════════╗
║  alertas.blade.php — Enterprise Notification Layer               ║
║                                                                   ║
║  TOAST NOTIFICATIONS                                              ║
║    showNotification(type, title, message, duration?)             ║
║    Tipos: 'info' | 'success' | 'warning' | 'danger'             ║
║    showNotification('success', '¡Guardado!', 'Cambios aplicados')║
║                                                                   ║
║  CONFIRMATION MODALS                                              ║
║    ModalSystem.show(type, config)                                ║
║    Tipos: 'success' | 'confirm' | 'warning' | 'question'        ║
║    ModalSystem.show('confirm', {                                 ║
║      title: '¿Eliminar registro?',                              ║
║      text:  'Esta acción no se puede deshacer.',                ║
║      confirmText: 'Sí, eliminar',                               ║
║      onConfirm: () => { ... }                                    ║
║    })                                                             ║
╚═══════════════════════════════════════════════════════════════════╝
--}}
@once('alertas-styles')
<style>
/* ─────────────────────────────────────────────────────────────────
DESIGN TOKENS
───────────────────────────────────────────────────────────────── */
:root {
    --ease-spring: cubic-bezier(0.16, 1, 0.3, 1);
    --ease-smooth: cubic-bezier(0.4, 0, 0.2, 1);

    /* ── Toast: Info ───────────────────────────────────────────── */
    --nt-info-bg:       rgba(239, 246, 255, 0.97);
    --nt-info-accent:   #3B82F6;
    --nt-info-icon-bg:  #DBEAFE;
    --nt-info-icon:     #2563EB;
    --nt-info-title:    #1E40AF;

    /* ── Toast: Success ────────────────────────────────────────── */
    --nt-ok-bg:         rgba(240, 253, 244, 0.97);
    --nt-ok-accent:     #10B981;
    --nt-ok-icon-bg:    #D1FAE5;
    --nt-ok-icon:       #059669;
    --nt-ok-title:      #064E3B;

    /* ── Toast: Warning ────────────────────────────────────────── */
    --nt-warn-bg:       rgba(255, 251, 235, 0.97);
    --nt-warn-accent:   #F59E0B;
    --nt-warn-icon-bg:  #FEF3C7;
    --nt-warn-icon:     #D97706;
    --nt-warn-title:    #78350F;

    /* ── Toast: Danger ─────────────────────────────────────────── */
    --nt-err-bg:        rgba(254, 242, 242, 0.97);
    --nt-err-accent:    #EF4444;
    --nt-err-icon-bg:   #FEE2E2;
    --nt-err-icon:      #DC2626;
    --nt-err-title:     #7F1D1D;

    /* ── Shared toast ──────────────────────────────────────────── */
    --nt-msg-color:     #4B5563;
    --nt-border:        rgba(0, 0, 0, 0.06);
    --nt-shadow-sm:     0 1px 3px rgba(0,0,0,0.04), 0 6px 16px rgba(0,0,0,0.07);
    --nt-shadow-hover:  0 1px 3px rgba(0,0,0,0.04), 0 12px 28px rgba(0,0,0,0.11);

    /* ── Modal ─────────────────────────────────────────────────── */
    --ms-overlay:   rgba(15, 23, 42, 0.55);
    --ms-card-bg:   #ffffff;
    --ms-border:    rgba(148, 163, 184, 0.18);
    --ms-title:     #0F172A;
    --ms-desc:      #64748B;
    --ms-z:         99999;
}

/* ─────────────────────────────────────────────────────────────────
TOAST — Contenedor
───────────────────────────────────────────────────────────────── */
#nt-rack {
    position: fixed;
    top: 20px; right: 20px;
    display: flex; flex-direction: column; gap: 10px;
    z-index: 99999;
    pointer-events: none;
}

/* ─────────────────────────────────────────────────────────────────
TOAST — Base
───────────────────────────────────────────────────────────────── */
.nt {
    --nt-accent: currentColor;
    position: relative;
    display: flex; align-items: flex-start; gap: 12px;
    width: 380px; box-sizing: border-box;
    padding: 14px 14px 14px 18px;
    border-radius: 14px;
    border: 1px solid var(--nt-border);
    box-shadow: var(--nt-shadow-sm), 0 0 0 0.5px rgba(255,255,255,0.6) inset;
    backdrop-filter: blur(14px);
    -webkit-backdrop-filter: blur(14px);
    overflow: hidden;
    pointer-events: auto;
    transform: translateX(calc(100% + 24px));
    opacity: 0;
    transition:
        transform 0.5s var(--ease-spring),
        opacity 0.3s var(--ease-smooth),
        box-shadow 0.2s ease;
    will-change: transform, opacity;
}

.nt::before {
    content: '';
    position: absolute;
    left: 0; top: 10px; bottom: 10px;
    width: 3px;
    background: var(--nt-accent);
    border-radius: 0 3px 3px 0;
    opacity: 0.75;
}

.nt:hover {
    box-shadow: var(--nt-shadow-hover), 0 0 0 0.5px rgba(255,255,255,0.6) inset;
}

.nt.show { transform: translateX(0); opacity: 1; }
.nt.hide { transform: translateX(12px); opacity: 0; transition-duration: 0.25s, 0.2s, 0.2s; }

.nt-info    { background: var(--nt-info-bg);  --nt-accent: var(--nt-info-accent); }
.nt-success { background: var(--nt-ok-bg);    --nt-accent: var(--nt-ok-accent); }
.nt-warning { background: var(--nt-warn-bg);  --nt-accent: var(--nt-warn-accent); }
.nt-danger  { background: var(--nt-err-bg);   --nt-accent: var(--nt-err-accent); }

.nt-icon {
    flex-shrink: 0;
    width: 34px; height: 34px;
    border-radius: 9px;
    display: flex; align-items: center; justify-content: center;
}
.nt-icon svg { width: 16px; height: 16px; stroke-width: 2.3; }

.nt-info    .nt-icon { background: var(--nt-info-icon-bg);  color: var(--nt-info-icon); }
.nt-success .nt-icon { background: var(--nt-ok-icon-bg);    color: var(--nt-ok-icon); }
.nt-warning .nt-icon { background: var(--nt-warn-icon-bg);  color: var(--nt-warn-icon); }
.nt-danger  .nt-icon { background: var(--nt-err-icon-bg);   color: var(--nt-err-icon); }

.nt-body { flex: 1; min-width: 0; padding-top: 1px; }

.nt-title {
    margin: 0;
    font-size: 13.5px; font-weight: 600;
    line-height: 1.3; letter-spacing: -0.1px;
}
.nt-msg {
    margin-top: 3px;
    font-size: 12.5px; line-height: 1.5;
    color: var(--nt-msg-color);
}

.nt-info    .nt-title { color: var(--nt-info-title); }
.nt-success .nt-title { color: var(--nt-ok-title); }
.nt-warning .nt-title { color: var(--nt-warn-title); }
.nt-danger  .nt-title { color: var(--nt-err-title); }

.nt-x {
    flex-shrink: 0;
    display: flex; align-items: center; justify-content: center;
    width: 22px; height: 22px; margin-top: 1px;
    background: transparent; border: none; padding: 0;
    color: #94A3B8; cursor: pointer;
    border-radius: 5px;
    transition: background 0.15s ease, color 0.15s ease;
}
.nt-x:hover { background: rgba(0,0,0,0.07); color: #475569; }
.nt-x:focus-visible { outline: 2px solid #3B82F6; outline-offset: 1px; }
.nt-x svg { width: 11px; height: 11px; stroke-width: 2.5; }

.nt-bar {
    position: absolute; bottom: 0; left: 0; right: 0;
    height: 2px; opacity: 0.25;
    transform-origin: left;
    animation: nt-shrink linear forwards;
}
.nt-info    .nt-bar { background: var(--nt-info-accent); }
.nt-success .nt-bar { background: var(--nt-ok-accent); }
.nt-warning .nt-bar { background: var(--nt-warn-accent); }
.nt-danger  .nt-bar { background: var(--nt-err-accent); }

@keyframes nt-shrink { from { transform: scaleX(1); } to { transform: scaleX(0); } }

@media (max-width: 560px) {
    #nt-rack { top: auto; bottom: 16px; left: 12px; right: 12px; }
    .nt { width: 100%; }
}

/* ─────────────────────────────────────────────────────────────────
MODAL — Fondo / Overlay
───────────────────────────────────────────────────────────────── */
.ms-veil {
    position: fixed; inset: 0;
    background: var(--ms-overlay);
    backdrop-filter: blur(6px);
    -webkit-backdrop-filter: blur(6px);
    display: flex; align-items: center; justify-content: center;
    z-index: var(--ms-z); padding: 20px;
    opacity: 0; visibility: hidden;
    transition: opacity 0.22s ease, visibility 0.22s ease;
}
.ms-veil.is-open { opacity: 1; visibility: visible; }

.ms-card {
    background: var(--ms-card-bg);
    width: 100%; max-width: 432px;
    border-radius: 22px;
    border: 1px solid var(--ms-border);
    padding: 36px 28px 28px;
    box-shadow:
        0 0 0 1px rgba(255,255,255,0.06) inset,
        0 4px 6px -1px rgba(0,0,0,0.06),
        0 24px 48px -8px rgba(0,0,0,0.18);
    display: flex; flex-direction: column; align-items: center; text-align: center;
    opacity: 0;
    transform: translateY(18px) scale(0.97);
    transition:
        transform 0.4s var(--ease-spring),
        opacity 0.25s var(--ease-smooth);
}
.ms-veil.is-open .ms-card { opacity: 1; transform: none; }

.ms-icon {
    width: 64px; height: 64px;
    border-radius: 20px;
    display: flex; align-items: center; justify-content: center;
    margin-bottom: 22px;
    position: relative;
}
.ms-icon svg { width: 28px; height: 28px; stroke-width: 2.1; }
.ms-icon::after {
    content: '';
    position: absolute; inset: -5px; border-radius: 25px;
    border: 1.5px dashed currentColor; opacity: 0.14;
}

.ms-title {
    margin: 0 0 10px;
    font-size: 20px; font-weight: 700;
    color: var(--ms-title); letter-spacing: -0.4px; line-height: 1.25;
}
.ms-desc {
    margin: 0 0 30px;
    font-size: 14.5px; line-height: 1.65; color: var(--ms-desc);
}

.ms-actions { width: 100%; display: flex; flex-direction: column; gap: 8px; }

@media (min-width: 480px) {
    .ms-actions { flex-direction: row-reverse; }
    .ms-btn { flex: 1; }
}

.ms-btn {
    height: 44px;
    border: none; border-radius: 11px;
    font-size: 14px; font-weight: 600;
    letter-spacing: -0.1px; cursor: pointer;
    transition: all 0.15s var(--ease-smooth);
    outline-offset: 3px;
}
.ms-btn:focus-visible { outline: 2px solid #3B82F6; }
.ms-btn:active { transform: scale(0.985); }

.ms-btn-primary {
    background: #0F172A; color: #fff;
    box-shadow: 0 1px 2px rgba(0,0,0,0.25), 0 0 0 1px rgba(255,255,255,0.05) inset;
}
.ms-btn-primary:hover { background: #1E293B; box-shadow: 0 3px 8px rgba(0,0,0,0.22); }

.ms-btn-danger {
    background: #EF4444; color: #fff;
    box-shadow: 0 1px 2px rgba(239,68,68,0.35), 0 0 0 1px rgba(255,255,255,0.08) inset;
}
.ms-btn-danger:hover { background: #DC2626; box-shadow: 0 3px 8px rgba(239,68,68,0.28); }

/* ── Campo contraseña con toggle (modales) ───────────────────────── */
.pass-field-wrap { position: relative; width: 100%; }
.pass-field-wrap input { padding-right: 44px !important; box-sizing: border-box; width: 100%; }
.modal-toggle-pass {
    position: absolute; right: 10px; top: 50%; transform: translateY(-50%);
    background: none; border: none; color: #9ca3af; cursor: pointer;
    display: flex; padding: 4px; border-radius: 4px; align-items: center;
}
.modal-toggle-pass:hover { color: #6b7280; }

.ms-btn-cancel {
    background: #F8FAFC; color: #334155;
    border: 1px solid rgba(148,163,184,0.35) !important;
}
.ms-btn-cancel:hover { background: #F1F5F9; color: #0F172A; }

body.ms-open { overflow: hidden; }
</style>
@endonce
@once('responsive-global')
@include('components.responsive-global')
@endonce
@once('alertas-script')
<script>
/* ═══════════════════════════════════════════════════════════════════
TOAST NOTIFICATION SYSTEM v2
═══════════════════════════════════════════════════════════════════ */
class EnterpriseToastSystem {
    #seen = new Set();
    #rack;

    constructor() { 
        this.#mountRack(); 
    }

    #mountRack() {
        let el = document.getElementById('nt-rack');
        if (!el) {
            el = document.createElement('div');
            el.id = 'nt-rack';
            
            // ✅ SOLUCIÓN: Verificar que document.body exista antes de appendChild
            if (document.body) {
                document.body.appendChild(el);
            } else {
                document.addEventListener('DOMContentLoaded', () => {
                    document.body.appendChild(el);
                });
            }
        }
        this.#rack = el;
    }

    #icon = {
        info: `<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
            <circle cx="12" cy="12" r="9"/>
            <line x1="12" y1="11" x2="12" y2="16"/>
            <line x1="12" y1="8" x2="12.01" y2="8"/>
        </svg>`,
        success: `<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
            <path d="M20 6L9 17l-5-5"/>
        </svg>`,
        warning: `<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
            <path d="M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/>
            <line x1="12" y1="9" x2="12" y2="13"/>
            <circle cx="12" cy="17" r=".4" fill="currentColor"/>
        </svg>`,
        danger: `<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
            <circle cx="12" cy="12" r="9"/>
            <line x1="15" y1="9" x2="9" y2="15"/>
            <line x1="9" y1="9" x2="15" y2="15"/>
        </svg>`,
    };

    #xIcon = `<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
        <line x1="18" y1="6" x2="6" y2="18"/>
        <line x1="6" y1="6" x2="18" y2="18"/>
    </svg>`;

    show(type = 'info', title = '', message = '', duration = 5000) {
        if (type === 'error') type = 'danger';
        const key = `${type}|${title}|${message}`;
        if (this.#seen.has(key)) return;
        this.#seen.add(key);

        const el = document.createElement('div');
        el.className = `nt nt-${type}`;
        el.setAttribute('role', 'alert');
        el.setAttribute('aria-live', 'polite');
        el.innerHTML = `
            <div class="nt-icon">${this.#icon[type] ?? this.#icon.info}</div>
            <div class="nt-body">
                <p class="nt-title">${title}</p>
                <p class="nt-msg">${message}</p>
            </div>
            <button class="nt-x" aria-label="Cerrar notificación">${this.#xIcon}</button>
            <div class="nt-bar" aria-hidden="true" style="animation-duration:${duration}ms"></div>
        `;
        
        // ✅ SOLUCIÓN: Verificar que #rack exista antes de appendChild
        if (this.#rack) {
            this.#rack.appendChild(el);
        } else {
            setTimeout(() => {
                if (this.#rack) {
                    this.#rack.appendChild(el);
                    requestAnimationFrame(() => el.classList.add('show'));
                }
            }, 100);
            return;
        }
        
        requestAnimationFrame(() => el.classList.add('show'));

        const dismiss = () => {
            el.classList.replace('show', 'hide');
            el.addEventListener('transitionend', () => {
                el.remove();
                this.#seen.delete(key);
            }, { once: true });
        };

        const tid = setTimeout(dismiss, duration);
        el.querySelector('.nt-x').addEventListener('click', () => { 
            clearTimeout(tid); 
            dismiss(); 
        });
    }
}

const _PASS_EYE_ON = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>`;
const _PASS_EYE_OFF = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>`;

function togglePassField(inputId, iconId) {
    const input = document.getElementById(inputId);
    const icon  = document.getElementById(iconId);
    if (!input || !icon) return;
    const isPass = input.type === 'password';
    input.type = isPass ? 'text' : 'password';
    icon.innerHTML = isPass ? _PASS_EYE_OFF : _PASS_EYE_ON;
}

function resetPassField(inputId, iconId) {
    const input = document.getElementById(inputId);
    const icon  = document.getElementById(iconId);
    if (input) { input.type = 'password'; input.value = ''; }
    if (icon) icon.innerHTML = _PASS_EYE_ON;
}

function bootAlertasLayer() {
    if (window.__AlertasLayer?.ready) return;

    const layer = window.__AlertasLayer ?? { queue: [], ready: false };
    window.__AlertasLayer = layer;

    const toast = new EnterpriseToastSystem();
    const modal = new ModalSystemCore();

    window.showNotification = (...args) => toast.show(...args);
    window.ModalSystem = modal;

    layer.ready = true;
    layer.queue.forEach(item => {
        if (item.kind === 'toast') window.showNotification(...item.args);
        else if (item.kind === 'modal') window.ModalSystem.show(...item.args);
    });
    layer.queue.length = 0;
}

window.__AlertasLayer = window.__AlertasLayer ?? { queue: [], ready: false };

if (!window.__AlertasLayer.ready) {
    window.showNotification = function (...args) {
        if (window.__AlertasLayer.ready) return window.showNotification(...args);
        window.__AlertasLayer.queue.push({ kind: 'toast', args });
    };

    window.ModalSystem = window.ModalSystem ?? {
        show(...args) {
            if (window.__AlertasLayer.ready) return window.ModalSystem.show(...args);
            window.__AlertasLayer.queue.push({ kind: 'modal', args });
        },
        close() {
            if (window.__AlertasLayer.ready) window.ModalSystem.close();
        },
    };
}

/* ═══════════════════════════════════════════════════════════════════
MODAL CONFIRMATION SYSTEM v2
═══════════════════════════════════════════════════════════════════ */
class ModalSystemCore {
    #veil = null;
    #prevFocus = null;
    #opts = {};
    #onKey = null;

    #icons = {
        success: {
            bg: '#DCFCE7', color: '#16A34A',
            svg: `<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                <path d="M20 6L9 17l-5-5"/>
            </svg>`,
        },
        confirm: {
            bg: '#FEE2E2', color: '#DC2626',
            svg: `<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                <path d="M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/>
                <line x1="12" y1="9" x2="12" y2="13"/>
                <circle cx="12" cy="17.5" r=".5" fill="currentColor"/>
            </svg>`,
        },
        warning: {
            bg: '#FEF3C7', color: '#D97706',
            svg: `<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                <path d="M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/>
                <line x1="12" y1="9" x2="12" y2="13"/>
                <circle cx="12" cy="17.5" r=".5" fill="currentColor"/>
            </svg>`,
        },
        question: {
            bg: '#EFF6FF', color: '#2563EB',
            svg: `<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="9"/>
                <path d="M9.09 9a3 3 0 015.83 1c0 2-3 3-3 3"/>
                <circle cx="12" cy="17" r=".5" fill="currentColor"/>
            </svg>`,
        },
    };

    show(type = 'success', config = {}) {
        this.#opts = {
            title: '', text: '',
            confirmText: 'Aceptar', cancelText: 'Cancelar',
            closeOnOutsideClick: false,
            onConfirm: () => {}, onCancel: () => {}, onClose: () => {},
            ...config,
        };

        this.#prevFocus = document.activeElement;
        this.#buildDOM(type);
        this.#bindEvents();
        document.body.classList.add('ms-open');

        requestAnimationFrame(() => {
            this.#veil.classList.add('is-open');
            this.#veil.querySelector('[data-action]')?.focus();
        });
    }

    #buildDOM(type) {
        this.#veil?.remove();
        const ic = this.#icons[type] ?? this.#icons.success;
        const isSuccess = type === 'success';

        document.body.insertAdjacentHTML('beforeend', `
            <div class="ms-veil" aria-hidden="true">
                <div class="ms-card" role="dialog" aria-modal="true" aria-labelledby="ms-title">
                    <div class="ms-icon" style="background:${ic.bg}; color:${ic.color};">${ic.svg}</div>
                    <h2 class="ms-title" id="ms-title">${this.#opts.title}</h2>
                    <p class="ms-desc">${this.#opts.text}</p>
                    <div class="ms-actions">
                        ${isSuccess
                            ? `<button class="ms-btn ms-btn-primary" data-action="confirm">${this.#opts.confirmText}</button>`
                            : `<button class="ms-btn ms-btn-danger" data-action="confirm">${this.#opts.confirmText}</button>
                               <button class="ms-btn ms-btn-cancel" data-action="cancel">${this.#opts.cancelText}</button>`
                        }
                    </div>
                </div>
            </div>
        `);
        this.#veil = document.body.lastElementChild;
    }

    #bindEvents() {
        this.#veil.querySelectorAll('[data-action]').forEach(btn =>
            btn.addEventListener('click', e => {
                const action = e.currentTarget.dataset.action;
                this.close();
                setTimeout(() => {
                    if (action === 'confirm') this.#opts.onConfirm();
                    if (action === 'cancel') this.#opts.onCancel();
                }, 10);
            })
        );

        this.#onKey = e => {
            if (e.key === 'Escape') { this.#opts.onCancel(); this.close(); }
        };
        document.addEventListener('keydown', this.#onKey);

        if (this.#opts.closeOnOutsideClick) {
            this.#veil.addEventListener('mousedown', e => {
                if (e.target === this.#veil) { this.#opts.onCancel(); this.close(); }
            });
        }
    }

    close() {
        if (!this.#veil) return;
        const v = this.#veil;
        this.#veil = null;

        v.classList.remove('is-open');
        document.removeEventListener('keydown', this.#onKey);
        this.#opts.onClose();

        setTimeout(() => {
            v.remove();
            document.body.classList.remove('ms-open');
            this.#prevFocus?.focus();
        }, 250);
    }
}

if (document.body) {
    bootAlertasLayer();
} else if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', bootAlertasLayer);
} else {
    bootAlertasLayer();
}
</script>
@endonce