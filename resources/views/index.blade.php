<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JHARDSYSTEX - Acceso</title>

    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">

    <style>
        /* ─── Reset & Base ─────────────────────────────────────── */
        * { margin: 0; padding: 0; box-sizing: border-box; }

        :root {
            --sb-bg-deep:  #0d1f3c;
            --sb-bg-mid:   #122444;
            --sb-bg-light: #162d52;
            --sb-accent:   #2b7fff;
            --sb-accent2:  #00c8ff;
            --sb-text:     #e8edf5;
            --sb-muted:    #7a92b4;
        }

        body {
            min-height: 100vh;
            font-family: 'DM Sans', sans-serif;
            background: var(--sb-bg-deep);
            overflow: hidden;
        }

        /* ─── Animations ──────────────────────────────────────── */
        @keyframes slideIn  { from { opacity: 0; transform: scale(1.04); } to { opacity: 1; transform: scale(1); } }
        @keyframes pulse    { 0%,100%{ opacity:.4; transform:scale(1);   } 50%{ opacity:.8; transform:scale(1.08); } }
        @keyframes blink    { 0%,100%{ opacity:1; box-shadow:0 0 6px #22d68a; } 50%{ opacity:.5; box-shadow:none; } }
        @keyframes fadeUp   { from { opacity:0; transform:translateY(12px); } to { opacity:1; transform:translateY(0); } }
        @keyframes spin     { to { transform: rotate(360deg); } }
        @keyframes ringAnim { to { transform: rotate(360deg); } }

        .slide-in       { animation: slideIn .8s cubic-bezier(.4,0,.2,1) both; }
        .anim-fade-up   { animation: fadeUp .5s ease both; }
        .anim-fade-up-1 { animation: fadeUp .5s .1s ease both; }
        .anim-fade-up-2 { animation: fadeUp .5s .2s ease both; }
        .anim-fade-up-3 { animation: fadeUp .5s .3s ease both; }
        .anim-fade-up-4 { animation: fadeUp .5s .4s ease both; }
        .anim-fade-up-5 { animation: fadeUp .5s .5s ease both; }

        /* ─── Layout ──────────────────────────────────────────── */
        .app-layout {
            display: flex;
            min-height: 100vh;
            width: 100vw;
            overflow: hidden;
        }

        /* ─── Grid overlay decorativo ─────────────────────────── */
        .login-panel.grid-overlay,
        .carousel-panel.grid-overlay {
            position: relative;
            overflow: visible;
        }

        .login-panel.grid-overlay::before,
        .carousel-panel.grid-overlay::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image:
                linear-gradient(rgba(43,127,255,.06) 1px, transparent 1px),
                linear-gradient(90deg, rgba(43,127,255,.06) 1px, transparent 1px);
            background-size: 20px 20px;  /* ← Reducido de 28px a 20px */
            pointer-events: none;
            z-index: 1;
        }

        /* ─────────────────────────────────────────────────────── */
        /*   PANEL IZQUIERDO – LOGIN                               */
        /* ─────────────────────────────────────────────────────── */
        .login-panel {
            width: clamp(340px, 38%, 460px);
            min-height: 100vh;
            flex-shrink: 0;
            position: relative;
            background: linear-gradient(160deg, #0d1f3c 0%, #122444 55%, #0f1e38 100%);
            border-right: 1px solid rgba(43,127,255,.15);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 40px 32px;
        }

        /* Orbes decorativos */
        .login-panel::before {
            content: '';
            position: absolute; top: 0; right: 0;
            width: 240px; height: 240px;
            background: radial-gradient(circle at top right, rgba(43,127,255,.10) 0%, transparent 65%);
            pointer-events: none;
        }
        .login-panel::after {
            content: '';
            position: absolute; bottom: 0; left: 0;
            width: 200px; height: 200px;
            background: radial-gradient(circle at bottom left, rgba(0,200,255,.07) 0%, transparent 65%);
            pointer-events: none;
        }

        /* Badge "Conexión segura" */
        .secure-badge {
            position: absolute; top: 16px; right: 16px; z-index: 5;
            display: flex; align-items: center; gap: 6px;
            font-size: 10px; font-family: 'DM Sans', sans-serif;
            padding: 4px 12px; border-radius: 100px;
            background: rgba(34,214,138,.10);
            border: 1px solid rgba(34,214,138,.30);
            color: #22d68a;
        }
        .secure-dot {
            width: 6px; height: 6px; border-radius: 50%;
            background: #22d68a;
            animation: blink 2s ease-in-out infinite;
        }

        /* Contenido del formulario */
        .login-inner {
            position: relative; z-index: 2;
            width: 100%; max-width: 380px;
        }

        /* Logo */
        .logo-box {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            max-width: 320px;
            margin: 0 auto 16px;           /* Separación con el subtítulo */
            padding: 12px;
            border-radius: 14px;
            background: transparent;       /* Sin fondo blanco */
            border: none;                  /* Sin borde */
            box-shadow: none;
        }

        .logo-box img {
            max-width: 260px;              /* Logo más grande */
            height: auto;
            object-fit: contain;
            display: block;
        }

        /* Subtítulo del logo */
        .logo-sub {
            text-align: center;
            color: rgba(255, 255, 255, 0.75);
            font-size: 14px;
            font-style: italic;
            margin: 0 0 24px;              /* Separación con el "Iniciar sesión" */
            letter-spacing: 0.3px;
        }

        /* Divider degradado */
        .divider {
            height: 1px; margin: 20px 0;
            background: linear-gradient(90deg, transparent, rgba(43,127,255,.35), transparent);
        }
        .divider-sm {
            height: 1px; margin: 24px 0 20px;
            background: linear-gradient(90deg, transparent, rgba(43,127,255,.20), transparent);
        }

        /* Heading */
        .login-heading { text-align: center; margin-bottom: 28px; }
        .login-heading h2 {
            font-family: 'Syne', sans-serif; font-weight: 700; font-size: 21px;
            color: var(--sb-text); margin: 0;
        }
        .login-heading p { font-size: 12px; color: var(--sb-muted); margin-top: 5px; }

        /* Labels */
        .field-label {
            display: block; font-size: 10.5px; font-weight: 600;
            letter-spacing: .10em; text-transform: uppercase;
            color: var(--sb-muted); margin-bottom: 7px;
            font-family: 'DM Sans', sans-serif;
        }

        /* Input wrapper */
        .input-wrap { position: relative; margin-bottom: 16px; }
        .input-icon {
            position: absolute; left: 13px; top: 50%; transform: translateY(-50%);
            color: #4a6280; display: flex; pointer-events: none;
        }
        .jhs-input {
            width: 100%; padding: 13px 14px 13px 42px;
            border-radius: 10px;
            border: 1.5px solid rgba(43,127,255,.35);
            background: rgba(18,36,68,.65);
            color: var(--sb-text); font-size: 14px; outline: none;
            font-family: 'DM Sans', sans-serif;
            transition: border-color .25s, box-shadow .25s;
        }
        .jhs-input::placeholder { color: #3d5070; }
        .jhs-input:focus {
            border-color: var(--sb-accent);
            box-shadow: 0 0 0 3px rgba(43,127,255,.18), 0 0 20px rgba(0,200,255,.06);
        }

        /* Password wrapper */
        .pass-wrap { position: relative; margin-bottom: 14px; }
        .pass-wrap .jhs-input { padding-right: 42px; }
        .toggle-pass {
            position: absolute; right: 13px; top: 50%; transform: translateY(-50%);
            background: none; border: none; color: var(--sb-muted);
            cursor: pointer; display: flex; padding: 2px; border-radius: 4px;
        }

        /* Remember / Forgot row */
        .row-meta {
            display: flex; justify-content: space-between; align-items: center;
            margin-bottom: 20px;
        }
        .remember-label { display: flex; align-items: center; gap: 8px; cursor: pointer; }
        .remember-box {
            width: 16px; height: 16px; border-radius: 4px; flex-shrink: 0;
            border: 1.5px solid rgba(43,127,255,.40);
            background: rgba(43,127,255,.08);
        }
        .remember-label span { font-size: 12px; color: var(--sb-muted); }
        .forgot-link { font-size: 12px; color: var(--sb-accent2); text-decoration: none; }
        .forgot-link:hover { opacity: .80; }

        /* Submit button */
        .btn-submit {
            width: 100%; padding: 14px; border-radius: 10px; border: none;
            background: linear-gradient(135deg, #2b7fff 0%, #0055e0 60%, #00c8ff 100%);
            color: #fff; font-weight: 700; font-size: 13px;
            letter-spacing: .12em; text-transform: uppercase; cursor: pointer;
            box-shadow: 0 6px 28px rgba(43,127,255,.35);
            transition: box-shadow .3s, filter .3s;
            font-family: 'Syne', sans-serif;
            display: flex; align-items: center; justify-content: center; gap: 8px;
        }
        .btn-submit:hover { box-shadow: 0 8px 36px rgba(43,127,255,.50); filter: brightness(1.05); }

        /* Footer links */
        .login-footer { text-align: center; }
        .login-footer p { font-size: 11px; color: #3d5070; margin: 0; }
        .login-footer p span { color: var(--sb-muted); }
        .footer-links { display: flex; justify-content: center; gap: 12px; margin-top: 10px; }
        .footer-links a { font-size: 10px; color: #2d3f5a; text-decoration: none; }

        /* Subtitle italic */
        .logo-sub { font-size: 12px; font-style: italic; color: var(--sb-muted); text-align: center; }

        /* ─────────────────────────────────────────────────────── */
        /*   PANEL DERECHO – CARRUSEL                              */
        /* ─────────────────────────────────────────────────────── */
        .carousel-panel {
            flex: 1; position: relative; overflow: hidden; min-height: 100vh;
        }

        /* Watermark */
        .carousel-watermark {
            position: absolute; top: 20px; left: 20px; z-index: 20;
            font-size: 10px; font-weight: 700; letter-spacing: .16em;
            text-transform: uppercase; padding: 5px 14px; border-radius: 8px;
            font-family: 'Syne', sans-serif;
            background: rgba(13,31,60,.65);
            border: 1px solid rgba(43,127,255,.30);
            color: var(--sb-muted); backdrop-filter: blur(8px);
        }

        /* Slide container */
        .slide-container {
            position: absolute; inset: 0;
            background-size: cover; background-position: center;
            transition: none;
        }

        /* Gradient overlays */
        .carousel-grad-v {
            position: absolute; inset: 0;
            background: linear-gradient(to top, rgba(13,31,60,.96) 0%, rgba(13,31,60,.35) 50%, rgba(13,31,60,.15) 100%);
            z-index: 2; pointer-events: none;
        }
        .carousel-grad-h {
            position: absolute; inset: 0;
            background: linear-gradient(to right, rgba(13,31,60,.50) 0%, transparent 50%);
            z-index: 2; pointer-events: none;
        }
        .carousel-grid {
            position: absolute; inset: 0; z-index: 2; opacity: .5;
            pointer-events: none;
        }

        /* Orbs */
        .orb-tl {
            position: absolute; top: -60px; right: -40px;
            width: 280px; height: 280px; border-radius: 50%;
            background: radial-gradient(circle, rgba(43,127,255,.15) 0%, transparent 70%);
            animation: pulse 4s ease-in-out infinite; z-index: 3; pointer-events: none;
        }
        .orb-bl {
            position: absolute; bottom: -40px; left: 60px;
            width: 220px; height: 220px; border-radius: 50%;
            background: radial-gradient(circle, rgba(0,200,255,.10) 0%, transparent 70%);
            animation: pulse 6s ease-in-out infinite reverse; z-index: 3; pointer-events: none;
        }

        /* Prev / Next arrows */
        .carousel-arrow {
            position: absolute; top: 50%; transform: translateY(-50%); z-index: 20;
            width: 40px; height: 40px; border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            background: rgba(43,127,255,.20);
            border: 1px solid rgba(43,127,255,.40);
            backdrop-filter: blur(8px); cursor: pointer;
            transition: background .2s;
        }
        .carousel-arrow:hover { background: rgba(43,127,255,.40); }
        .carousel-arrow.prev { left: 16px; }
        .carousel-arrow.next { right: 16px; }
        .carousel-arrow svg { width: 16px; height: 16px; }

        /* Counter */
        .carousel-counter {
            position: absolute; top: 20px; right: 20px; z-index: 20;
            font-size: 12px; font-family: 'Syne', sans-serif; font-weight: 600;
            color: var(--sb-muted);
            background: rgba(13,31,60,.50); backdrop-filter: blur(8px);
            padding: 4px 12px; border-radius: 100px;
            border: 1px solid rgba(43,127,255,.20);
        }

        /* Slide content */
        .slide-content {
            position: absolute; bottom: 0; left: 0; right: 0;
            z-index: 10; padding: 32px 40px;
        }
        .slide-badge {
            display: inline-block; font-size: 10px; font-weight: 700;
            letter-spacing: .14em; text-transform: uppercase;
            padding: 4px 14px; border-radius: 100px; margin-bottom: 14px;
            background: rgba(43,127,255,.18); border: 1px solid rgba(43,127,255,.50);
            color: var(--sb-accent2); backdrop-filter: blur(8px);
            font-family: 'DM Sans', sans-serif;
        }
        .slide-title {
            font-family: 'Syne', sans-serif; font-weight: 800;
            font-size: clamp(22px, 3vw, 32px);
            color: var(--sb-text); margin: 0 0 8px; line-height: 1.15;
            text-shadow: 0 2px 16px rgba(0,0,0,.60);
        }
        .slide-sub {
            font-size: 13px; color: var(--sb-muted);
            margin: 0 0 20px; max-width: 340px;
        }

        /* Contact chips */
        .contact-chips { display: flex; flex-wrap: wrap; gap: 8px; margin-bottom: 20px; }
        .chip {
            display: flex; align-items: center; gap: 6px;
            font-size: 11px; padding: 5px 12px; border-radius: 100px;
            background: rgba(255,255,255,.07);
            border: 1px solid rgba(255,255,255,.10);
            color: var(--sb-text); backdrop-filter: blur(8px);
        }

        /* Dots */
        .carousel-dots { display: flex; gap: 8px; align-items: center; }
        .dot {
            height: 8px; border-radius: 100px; border: none; cursor: pointer;
            transition: all .35s cubic-bezier(.4,0,.2,1); padding: 0;
        }
        .dot.active {
            width: 28px;
            background: linear-gradient(90deg, #2b7fff, #00c8ff);
        }
        .dot.inactive {
            width: 8px;
            background: rgba(255,255,255,.25);
        }

        /* ─── Responsive ──────────────────────────────────────── */
        @media (max-width: 900px) {
            .carousel-panel { display: none; }
            .login-panel    { width: 100%; border-right: none; }
            body { overflow: auto; }
            .app-layout { overflow: auto; min-height: 100vh; height: auto; }
        }
        @media (max-width: 480px) {
            .login-panel { padding: 28px 20px; }
            .login-inner { width: 100%; max-width: 100%; }
            .login-heading h2 { font-size: 1.5rem; }
            .jhs-input { font-size: 15px; }
            .btn-submit { padding: 14px; font-size: 14px; }
            .login-footer .footer-links { flex-direction: column; gap: 8px; align-items: center; }
        }
        @media (max-width: 360px) {
            .login-panel { padding: 20px 16px; }
            .logo-box img { max-width: 48px; max-height: 48px; }
        }
    </style>
</head>
<body>

{{-- ── Notificaciones ─────────────────────────────────────────── --}}
@include('components.notificaciones.alertas')

@if ($errors->any())
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            @foreach ($errors->all() as $error)
                showNotification('danger', 'Error', {!! json_encode($error, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) !!});
            @endforeach
        });
    </script>
@endif

@if (session('success'))
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            showNotification('success', 'Correcto', {!! json_encode(session('success'), JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) !!});
        });
    </script>
@endif

{{-- ── Layout ──────────────────────────────────────────────────── --}}
<div class="app-layout">

    {{-- ════════════════════════════════════════════════════════ --}}
    {{--   PANEL IZQUIERDO — LOGIN                               --}}
    {{-- ════════════════════════════════════════════════════════ --}}
    <div class="login-panel grid-overlay">

        {{-- Badge seguro --}}
        <div class="secure-badge">
            <div class="secure-dot"></div>
            Conexión segura
        </div>

        <div class="login-inner">

            {{-- Logo --}}
            <div class="anim-fade-up">
                <div class="logo-box">
                    <img src="{{ asset('images/logo.png') }}" alt="JHARDSYSTEX">
                </div>
                <p class="logo-sub">Soluciones Especializadas TI</p>
            </div>

            <div class="divider"></div>

            {{-- Heading --}}
            <div class="login-heading anim-fade-up-1">
                <h2>Iniciar sesión</h2>
                <p>Accede al panel de administración</p>
            </div>

            {{-- Formulario --}}
            <form id="login-form" method="POST" action="{{ route('login') }}">
                @csrf

                {{-- Email --}}
                <div class="anim-fade-up-2">
                    <label class="field-label" for="correo">Correo electrónico</label>
                    <div class="input-wrap">
                        <span class="input-icon">
                            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                        </span>
                        <input
                            id="correo"
                            type="email"
                            name="correo"
                            class="jhs-input"
                            placeholder="usuario@empresa.com"
                            value="{{ old('correo') }}"
                            required
                            autocomplete="username"
                        >
                    </div>
                </div>

                {{-- Contraseña --}}
                <div class="anim-fade-up-3">
                    <label class="field-label" for="login-pass">Contraseña</label>
                    <div class="pass-wrap">
                        <span class="input-icon">
                            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                            </svg>
                        </span>
                        <input
                            id="login-pass"
                            type="password"
                            name="password"
                            class="jhs-input"
                            placeholder="••••••••••"
                            required
                            autocomplete="current-password"
                        >
                        <button type="button" class="toggle-pass" onclick="togglePassword()" aria-label="Mostrar contraseña">
                            <svg id="eye-icon" width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                        </button>
                    </div>
                </div>

                {{-- Recordarme / Olvidé --}}
                {{-- 
                <div class="row-meta anim-fade-up-3">
                    <label class="remember-label">
                        <div class="remember-box"></div>
                        <input type="checkbox" name="remember" style="display:none">
                        <span>Recordarme</span>
                    </label>
                    <a href="#" class="forgot-link">¿Olvidaste tu contraseña?</a>
                </div>
                --}}

                {{-- Submit --}}
                <div class="anim-fade-up-4">
                    <button type="submit" class="btn-submit" id="btn-acceder">
                        <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
                        </svg>
                        Acceder al Sistema
                    </button>
                </div>

            </form>

            <div class="divider-sm"></div>

            {{-- Footer --}}
            <div class="login-footer anim-fade-up-5">
                <p>© 2026 <span>JHARDSYSTEX</span> — Infraestructura Crítica</p>
                <div class="footer-links">
                    <a href="#">Privacidad</a>
                    <a href="#">Términos</a>
                    <a href="#">Soporte</a>
                </div>
            </div>

        </div>{{-- .login-inner --}}
    </div>{{-- .login-panel --}}


    {{-- ════════════════════════════════════════════════════════ --}}
    {{--   PANEL DERECHO — CARRUSEL                              --}}
    {{-- ════════════════════════════════════════════════════════ --}}
    <div class="carousel-panel" id="carousel">

        {{-- Watermark --}}
        <div class="carousel-watermark">JHARDSYSTEX · TI</div>

        {{-- Counter --}}
        <div class="carousel-counter" id="counter">01 / 05</div>

        {{-- Imagen de fondo (animada por JS) --}}
        <div class="slide-container" id="slide-bg"></div>

        {{-- Gradientes --}}
        <div class="carousel-grad-v"></div>
        <div class="carousel-grad-h"></div>
        <div class="carousel-grid grid-overlay"></div>

        {{-- Orbes --}}
        <div class="orb-tl"></div>
        <div class="orb-bl"></div>

        {{-- Flechas --}}
        <button class="carousel-arrow prev" onclick="carouselPrev()" aria-label="Anterior">
            <svg fill="none" stroke="white" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
        </button>
        <button class="carousel-arrow next" onclick="carouselNext()" aria-label="Siguiente">
            <svg fill="none" stroke="white" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
        </button>

        {{-- Contenido del slide --}}
        <div class="slide-content" id="slide-content">
            <span class="slide-badge" id="slide-badge"></span>
            <h2 class="slide-title" id="slide-title"></h2>
            <p class="slide-sub" id="slide-sub"></p>

            {{-- Chips de contacto --}}
            <div class="contact-chips">
                <div class="chip"><span>🌐</span><span>www.jhardsystex.com</span></div>
                <div class="chip"><span>📞</span><span>+51 995 790 552 | 01 7480284</span></div>
                <div class="chip"><span>✉️</span><span>info@jhardsystex.com</span></div>
                <div class="chip"><span>📍</span><span>Av. Túpac Amaru 1719, Comas</span></div>
            </div>

            {{-- Dots --}}
            <div class="carousel-dots" id="dots-container"></div>
        </div>

    </div>{{-- .carousel-panel --}}

</div>{{-- .app-layout --}}


<script>
/* ─── Toggle Password ──────────────────────────────────────── */
function togglePassword() {
    const input = document.getElementById('login-pass');
    const icon  = document.getElementById('eye-icon');
    const isPass = input.type === 'password';
    input.type = isPass ? 'text' : 'password';
    icon.innerHTML = isPass
        ? `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
             d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>`
        : `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
           <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>`;
}

/* ─── Loading en submit ────────────────────────────────────── */
document.getElementById('login-form').addEventListener('submit', function() {
    const btn = document.getElementById('btn-acceder');
    btn.innerHTML = `
        <svg style="animation:spin 1s linear infinite;width:16px;height:16px" fill="none" viewBox="0 0 24 24">
            <circle style="opacity:.25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
            <path style="opacity:.8" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/>
        </svg>
        Verificando...`;
    btn.disabled = true;
    btn.style.background = 'rgba(43,127,255,0.4)';
    btn.style.boxShadow  = 'none';
    btn.style.cursor     = 'wait';
});

/* ─── Carrusel ─────────────────────────────────────────────── */
(function() {
const SLIDES = [
    { 
        src: "{{ asset('images/banner_diseñoweb.jpg') }}", 
        title: 'Soluciones Digitales', 
        sub: 'Diseño Web, SEO, Hosting', 
        badge: 'Digital' 
    },
    { 
        src: "{{ asset('images/banner_infraestructura.jpg') }}", 
        title: 'Infraestructura de Red', 
        sub: 'Cableado Estructurado, Conectividad, Router y Switches', 
        badge: 'Redes' 
    },
    { 
        src: "{{ asset('images/banner_microinformatico.jpg') }}", 
        title: 'Soporte Microinformático', 
        sub: 'Computadoras, Laptop, All in One, Mac', 
        badge: 'Soporte' 
    },
    { 
        src: "{{ asset('images/banner_camaras.jpg') }}", 
        title: 'Cámaras de Seguridad', 
        sub: 'Soporte, Mantenimiento e Instalación', 
        badge: 'Seguridad' 
    },
    { 
        src: "{{ asset('images/banner_printer.jpg') }}", 
        title: 'Soporte Printer', 
        sub: 'Impresoras, Scanner, Lectoras', 
        badge: 'Impresión' 
    },
];

    let current = 0;
    let timer   = null;
    const bg      = document.getElementById('slide-bg');
    const badge   = document.getElementById('slide-badge');
    const title   = document.getElementById('slide-title');
    const sub     = document.getElementById('slide-sub');
    const counter = document.getElementById('counter');
    const dotsWrap= document.getElementById('dots-container');
    const content = document.getElementById('slide-content');

    /* Crear dots */
    SLIDES.forEach(function(_, i) {
        const dot = document.createElement('button');
        dot.className = 'dot ' + (i === 0 ? 'active' : 'inactive');
        dot.setAttribute('aria-label', 'Slide ' + (i + 1));
        dot.addEventListener('click', function() { goTo(i); });
        dotsWrap.appendChild(dot);
    });

    function updateDots() {
        dotsWrap.querySelectorAll('.dot').forEach(function(d, i) {
            d.className = 'dot ' + (i === current ? 'active' : 'inactive');
        });
    }

    function goTo(idx) {
        current = (idx + SLIDES.length) % SLIDES.length;
        render();
        resetTimer();
    }

    function render() {
        const s = SLIDES[current];

        /* Fondo con animación */
        bg.style.backgroundImage = 'url(' + s.src + ')';
        bg.classList.remove('slide-in');
        void bg.offsetWidth; /* reflow para reiniciar animación */
        bg.classList.add('slide-in');

        /* Texto con animación */
        content.classList.remove('anim-fade-up');
        void content.offsetWidth;
        content.classList.add('anim-fade-up');

        badge.textContent   = s.badge;
        title.textContent   = s.title;
        sub.textContent     = s.sub;
        counter.textContent = String(current + 1).padStart(2, '0') + ' / ' + String(SLIDES.length).padStart(2, '0');
        updateDots();
    }

    function resetTimer() {
        if (timer) clearInterval(timer);
        timer = setInterval(function() { goTo(current + 1); }, 5000);
    }

    window.carouselPrev = function() { goTo(current - 1); };
    window.carouselNext = function() { goTo(current + 1); };

    render();
    resetTimer();
})();
</script>

</body>
</html>