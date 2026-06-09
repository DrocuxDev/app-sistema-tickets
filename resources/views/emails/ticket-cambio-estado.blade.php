<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actualización de Ticket</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f1f5f9;
            padding: 40px 16px;
        }
        .email-card {
            max-width: 580px;
            margin: 0 auto;
            background: #ffffff;
            border-radius: 16px;
            overflow: hidden;
            border: 1px solid #e2e8f0;
            box-shadow: 0 4px 24px rgba(0,0,0,0.07);
        }

        /* ── HEADERS por estado ── */
        .em-header { padding: 36px 32px 28px; text-align: center; }
        .em-header.programado  { background: linear-gradient(135deg, #7c3aed 0%, #a855f7 50%, #c084fc 100%); }
        .em-header.en_proceso  { background: linear-gradient(135deg, #1d4ed8 0%, #3b82f6 50%, #60a5fa 100%); }
        .em-header.cerrado     { background: linear-gradient(135deg, #15803d 0%, #22c55e 50%, #4ade80 100%); }
        .em-header.cancelado   { background: linear-gradient(135deg, #b91c1c 0%, #ef4444 50%, #f87171 100%); }
        .em-header.pendiente   { background: linear-gradient(135deg, #b45309 0%, #f59e0b 50%, #fbbf24 100%); }
        .em-header.default     { background: linear-gradient(135deg, #475569 0%, #64748b 50%, #94a3b8 100%); }

        .em-icon {
            font-size: 48px;
            margin-bottom: 14px;
            display: block;
        }
        .em-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: rgba(255,255,255,0.15);
            border: 1px solid rgba(255,255,255,0.25);
            border-radius: 20px;
            padding: 5px 14px;
            font-size: 12px;
            color: rgba(255,255,255,0.9);
            margin-bottom: 14px;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            font-weight: 600;
        }
        .em-header h1 {
            font-size: 22px;
            font-weight: 700;
            color: #ffffff;
            margin-bottom: 6px;
            line-height: 1.3;
        }
        .em-header p {
            font-size: 14px;
            color: rgba(255,255,255,0.8);
            line-height: 1.5;
        }

        /* ── BODY ── */
        .em-body { padding: 28px 32px; }
        .em-greeting {
            font-size: 17px;
            font-weight: 600;
            color: #13294b;
            margin-bottom: 12px;
        }

        /* ── Mensaje principal personalizado por estado ── */
        .em-main-message {
            border-radius: 12px;
            padding: 20px 22px;
            margin-bottom: 24px;
            border-left: 4px solid;
            line-height: 1.7;
            font-size: 14.5px;
        }
        .em-main-message.programado  { background: #f5f3ff; border-color: #7c3aed; color: #3b1d8c; }
        .em-main-message.en_proceso  { background: #eff6ff; border-color: #3b82f6; color: #1e3a8a; }
        .em-main-message.cerrado     { background: #f0fdf4; border-color: #22c55e; color: #14532d; }
        .em-main-message.cancelado   { background: #fff1f2; border-color: #ef4444; color: #7f1d1d; }
        .em-main-message.pendiente   { background: #fffbeb; border-color: #f59e0b; color: #78350f; }
        .em-main-message.default     { background: #f8fafc; border-color: #94a3b8; color: #334155; }

        /* ── Ticket code ── */
        .em-ticket-code {
            background: #f8fafc;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            padding: 14px 20px;
            text-align: center;
            margin-bottom: 24px;
        }
        .em-ticket-code-label {
            font-size: 11px;
            color: #94a3b8;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            margin-bottom: 5px;
        }
        .em-ticket-code-val {
            font-size: 20px;
            font-weight: 700;
            color: #7c3aed;
            font-family: 'Courier New', monospace;
            letter-spacing: 0.04em;
        }

        /* ── Status flow ── */
        .em-status-change {
            background: #f8fafc;
            border-radius: 12px;
            padding: 18px 20px;
            margin-bottom: 24px;
            text-align: center;
            border: 1px solid #e2e8f0;
        }
        .em-status-label {
            font-size: 11px;
            color: #94a3b8;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            margin-bottom: 12px;
        }
        .em-status-flow {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            flex-wrap: wrap;
        }
        .em-status-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 7px 14px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.04em;
        }
        .em-status-badge::before {
            content: '';
            width: 7px; height: 7px;
            border-radius: 50%;
            flex-shrink: 0;
        }
        .em-status-badge.pendiente  { background: #fef9c3; color: #854d0e; }
        .em-status-badge.pendiente::before { background: #f59e0b; }
        .em-status-badge.programado { background: #ede9fe; color: #4c1d95; }
        .em-status-badge.programado::before { background: #8b5cf6; }
        .em-status-badge.en_proceso { background: #dbeafe; color: #1e40af; }
        .em-status-badge.en_proceso::before { background: #3b82f6; }
        .em-status-badge.cerrado    { background: #dcfce7; color: #14532d; }
        .em-status-badge.cerrado::before { background: #22c55e; }
        .em-status-badge.cancelado  { background: #fee2e2; color: #7f1d1d; }
        .em-status-badge.cancelado::before { background: #ef4444; }
        .em-arrow { font-size: 18px; color: #cbd5e1; }

        /* ── Detalles ── */
        .em-details {
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            overflow: hidden;
            margin-bottom: 24px;
        }
        .em-details-header {
            background: #f8fafc;
            padding: 10px 16px;
            font-size: 11px;
            font-weight: 600;
            color: #94a3b8;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            border-bottom: 1px solid #e2e8f0;
        }
        .em-detail-row {
            display: flex;
            gap: 12px;
            padding: 13px 16px;
            border-bottom: 1px solid #e2e8f0;
        }
        .em-detail-row:last-child { border-bottom: none; }
        .em-detail-label { font-size: 13px; color: #94a3b8; min-width: 120px; flex-shrink: 0; }
        .em-detail-val   { font-size: 13px; font-weight: 500; color: #13294b; flex: 1; }

        /* ── Qué sigue ── */
        .em-next-steps {
            background: #f8fafc;
            border-radius: 12px;
            padding: 18px 20px;
            margin-bottom: 24px;
            border: 1px solid #e2e8f0;
        }
        .em-next-title {
            font-size: 12px;
            font-weight: 700;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            margin-bottom: 10px;
        }
        .em-next-steps ul {
            padding-left: 18px;
            margin: 0;
        }
        .em-next-steps ul li {
            font-size: 13px;
            color: #475569;
            line-height: 1.7;
        }

        /* ── Botón ── */
        .em-btn-wrap { text-align: center; margin-bottom: 8px; }
        .em-btn {
            display: inline-block;
            background: #7c3aed;
            color: #ffffff;
            padding: 13px 32px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            text-decoration: none;
        }
        .em-btn.cerrado   { background: #16a34a; }
        .em-btn.cancelado { background: #dc2626; }
        .em-btn.en_proceso{ background: #2563eb; }
        .em-btn.pendiente { background: #d97706; }

        /* ── Footer ── */
        .em-footer {
            background: #f8fafc;
            border-top: 1px solid #e2e8f0;
            padding: 18px 32px;
            text-align: center;
        }
        .em-footer p { font-size: 12px; color: #94a3b8; line-height: 1.7; }
    </style>
</head>
<body>

@php
    // Slugify para CSS
    $estadoNuevoSlug    = strtolower(str_replace(' ', '_', $estadoNuevo));
    $estadoAnteriorSlug = strtolower(str_replace(' ', '_', $estadoAnterior));
    $nombreCompleto     = trim(($usuario->nombre ?? '') . ' ' . ($usuario->apellido_paterno ?? ''));

    // ─── Configuración por estado ───
    $config = match($estadoNuevo) {

        'PROGRAMADO' => [
            'icon'       => '📅',
            'badge'      => 'Ticket Programado',
            'titulo'     => '¡Tu ticket ha sido programado!',
            'subtitulo'  => 'Hemos encontrado al técnico indicado para ti',
            'css'        => 'programado',
            'mensaje'    => "¡Excelentes noticias, {$nombreCompleto}! 🎉\n\n" .
                            "Tu ticket ha sido revisado y asignado a uno de nuestros técnicos especializados. " .
                            "Muy pronto te contactarán para coordinar la atención y resolver tu solicitud de la mejor manera posible.\n\n" .
                            "Te recomendamos estar pendiente de tu correo y teléfono para no perderte la comunicación del técnico.",
            'pasos'      => [
                'Un técnico se pondrá en contacto contigo próximamente.',
                'Asegúrate de tener disponible el equipo o información relacionada.',
                'Puedes revisar el estado de tu ticket en cualquier momento desde el sistema.',
            ],
            'btn_texto'  => 'Ver mi ticket programado →',
        ],

        'EN PROCESO' => [
            'icon'       => '⚙️',
            'badge'      => 'En Atención',
            'titulo'     => '¡Estamos trabajando en tu ticket!',
            'subtitulo'  => 'Tu solicitud ya está en manos de nuestro equipo',
            'css'        => 'en_proceso',
            'mensaje'    => "¡Tu ticket ya está en proceso, {$nombreCompleto}! 🔧\n\n" .
                            "Nuestro técnico ya está trabajando activamente en tu solicitud. " .
                            "Hacemos todo lo posible para resolverlo en el menor tiempo posible y con la mayor calidad.\n\n" .
                            "No es necesario que hagas nada adicional por el momento. Te notificaremos tan pronto tengamos novedades o cuando tu ticket sea cerrado.",
            'pasos'      => [
                'El técnico está analizando y atendiendo tu solicitud.',
                'Si necesitan información adicional, te contactarán directamente.',
                'Recibirás una notificación cuando tu ticket sea resuelto.',
            ],
            'btn_texto'  => 'Ver el progreso de mi ticket →',
        ],

        'CERRADO' => [
            'icon'       => '✅',
            'badge'      => 'Ticket Resuelto',
            'titulo'     => '¡Tu ticket ha sido resuelto!',
            'subtitulo'  => 'Tu solicitud ha sido atendida exitosamente',
            'css'        => 'cerrado',
            'mensaje'    => "¡Felicidades, {$nombreCompleto}! Tu ticket ha sido cerrado exitosamente. ✅\n\n" .
                            "Nos alegra informarte que tu solicitud ha sido atendida y resuelta por nuestro equipo. " .
                            "Esperamos haber cumplido con tus expectativas y que la solución haya sido de utilidad.\n\n" .
                            "Si en el futuro necesitas ayuda con algún otro problema o tienes alguna duda sobre la atención recibida, no dudes en abrir un nuevo ticket. ¡Estamos aquí para ayudarte!",
            'pasos'      => [
                'Verifica que tu problema haya quedado completamente resuelto.',
                'Si el problema persiste, puedes abrir un nuevo ticket desde el sistema.',
                'Tu opinión es importante — gracias por confiar en nuestro equipo.',
            ],
            'btn_texto'  => 'Ver detalles de la solución →',
        ],

        'CANCELADO' => [
            'icon'       => '❌',
            'badge'      => 'Ticket Cancelado',
            'titulo'     => 'Tu ticket ha sido cancelado',
            'subtitulo'  => 'Lamentamos los inconvenientes causados',
            'css'        => 'cancelado',
            'mensaje'    => "Estimado/a {$nombreCompleto},\n\n" .
                            "Lamentamos informarte que tu ticket ha sido cancelado. Entendemos que esto puede ser frustrante " .
                            "y nos disculpamos por cualquier inconveniente que esto pueda causarte.\n\n" .
                            "Si crees que esta cancelación fue un error, o si tu problema sigue sin resolverse, " .
                            "por favor no dudes en abrir un nuevo ticket o contactarnos directamente. " .
                            "Estaremos encantados de ayudarte.",
            'pasos'      => [
                'Si tu problema persiste, abre un nuevo ticket con más detalles.',
                'Puedes contactar a soporte directamente si necesitas orientación.',
                'Revisaremos el motivo de la cancelación si lo solicitas.',
            ],
            'btn_texto'  => 'Abrir un nuevo ticket →',
        ],

        'PENDIENTE' => [
            'icon'       => '⏳',
            'badge'      => 'En Cola',
            'titulo'     => 'Tu ticket está en lista de espera',
            'subtitulo'  => 'Lo atenderemos lo antes posible',
            'css'        => 'pendiente',
            'mensaje'    => "Hola, {$nombreCompleto}.\n\n" .
                            "Tu ticket se encuentra actualmente en nuestra lista de espera (pendiente de asignación). " .
                            "Nuestro equipo lo revisará próximamente y lo asignará al técnico más adecuado para tu caso.\n\n" .
                            "Gracias por tu paciencia. Te notificaremos en cuanto haya novedades sobre tu solicitud.",
            'pasos'      => [
                'Tu ticket está siendo revisado por el equipo de soporte.',
                'Pronto será asignado a un técnico especializado.',
                'Recibirás una notificación cuando haya avances.',
            ],
            'btn_texto'  => 'Ver estado de mi ticket →',
        ],

        default => [
            'icon'       => '🔔',
            'badge'      => 'Actualización',
            'titulo'     => 'Tu ticket ha sido actualizado',
            'subtitulo'  => 'Hay novedades sobre tu solicitud',
            'css'        => 'default',
            'mensaje'    => "Hola, {$nombreCompleto}.\n\nTu ticket ha recibido una actualización de estado. Ingresa al sistema para ver los detalles.",
            'pasos'      => [
                'Accede al sistema para ver los detalles de la actualización.',
                'Si tienes dudas, comunícate con soporte.',
            ],
            'btn_texto'  => 'Ver mi ticket →',
        ],
    };
@endphp

<div class="email-card">

    {{-- ── HEADER ── --}}
    <div class="em-header {{ $config['css'] }}">
        <span class="em-icon">{{ $config['icon'] }}</span>
        <div class="em-badge">{{ $config['badge'] }}</div>
        <h1>{{ $config['titulo'] }}</h1>
        <p>{{ $config['subtitulo'] }}</p>
    </div>

    {{-- ── BODY ── --}}
    <div class="em-body">

        <p class="em-greeting">¡Hola, {{ $nombreCompleto }}!</p>

        {{-- Mensaje principal personalizado --}}
        <div class="em-main-message {{ $config['css'] }}">
            {!! nl2br(e($config['mensaje'])) !!}
        </div>

        {{-- Código de ticket --}}
        <div class="em-ticket-code">
            <div class="em-ticket-code-label">Número de ticket</div>
            <div class="em-ticket-code-val">{{ $ticket->codigo_ticket }}</div>
        </div>

        {{-- Flujo de estado --}}
        <div class="em-status-change">
            <div class="em-status-label">Cambio de estado</div>
            <div class="em-status-flow">
                <span class="em-status-badge {{ $estadoAnteriorSlug }}">{{ $estadoAnterior }}</span>
                <span class="em-arrow">→</span>
                <span class="em-status-badge {{ $estadoNuevoSlug }}">{{ $estadoNuevo }}</span>
            </div>
        </div>

        {{-- Detalles del ticket --}}
        <div class="em-details">
            <div class="em-details-header">Información del ticket</div>
            <div class="em-detail-row">
                <div class="em-detail-label">Asunto:</div>
                <div class="em-detail-val">{{ $ticket->asunto }}</div>
            </div>
            <div class="em-detail-row">
                <div class="em-detail-label">Estado actual:</div>
                <div class="em-detail-val">{{ $estadoNuevo }}</div>
            </div>
            <div class="em-detail-row">
                <div class="em-detail-label">Fecha de actualización:</div>
                <div class="em-detail-val">{{ now()->format('d/m/Y H:i') }} <span style="font-size:11px;color:#94a3b8;">(UTC{{ now()->format('P') }})</span></div>
            </div>
        </div>

        {{-- Qué sigue --}}
        @if(!empty($config['pasos']))
        <div class="em-next-steps">
            <div class="em-next-title">¿Qué sigue?</div>
            <ul>
                @foreach($config['pasos'] as $paso)
                    <li>{{ $paso }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        {{-- CTA Button --}}
        <div class="em-btn-wrap">
            <a href="{{ url('/') }}" class="em-btn {{ $config['css'] }}">{{ $config['btn_texto'] }}</a>
        </div>

    </div>

    {{-- ── FOOTER ── --}}
    <div class="em-footer">
        <p>Este es un correo automático, por favor no responder.</p>
        <p>&copy; {{ date('Y') }} Sistema de Tickets &middot; Todos los derechos reservados.</p>
    </div>

</div>
</body>
</html>
