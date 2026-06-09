<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Ticket Creado</title>
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
        }
        .em-header {
            background: linear-gradient(135deg, #0f4a8a 0%, #1a6ed8 50%, #0ea5e9 100%);
            padding: 36px 32px 28px;
            text-align: center;
        }
        .em-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: rgba(255,255,255,0.12);
            border: 1px solid rgba(255,255,255,0.2);
            border-radius: 20px;
            padding: 5px 14px;
            font-size: 12px;
            color: rgba(255,255,255,0.85);
            margin-bottom: 16px;
        }
        .em-divider {
            width: 32px;
            height: 2px;
            background: rgba(255,255,255,0.3);
            margin: 0 auto 18px;
            border-radius: 2px;
        }
        .em-header h1 {
            font-size: 22px;
            font-weight: 500;
            color: #ffffff;
            margin-bottom: 6px;
        }
        .em-header p {
            font-size: 14px;
            color: rgba(255,255,255,0.7);
        }
        .em-body {
            padding: 28px 32px;
        }
        .em-greeting {
            font-size: 17px;
            font-weight: 600;
            color: #13294b;
            margin-bottom: 8px;
        }
        .em-subtext {
            font-size: 14px;
            color: #64748b;
            line-height: 1.6;
            margin-bottom: 24px;
        }
        .em-ticket-code {
            background: #f8fafc;
            border: 2px solid #1a6ed8;
            border-radius: 12px;
            padding: 16px 20px;
            text-align: center;
            margin-bottom: 24px;
        }
        .em-ticket-code-label {
            font-size: 11px;
            color: #94a3b8;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            margin-bottom: 6px;
        }
        .em-ticket-code-val {
            font-size: 20px;
            font-weight: 700;
            color: #1a6ed8;
            font-family: 'Courier New', monospace;
            letter-spacing: 0.04em;
        }
        .em-details {
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            overflow: hidden;
            margin-bottom: 20px;
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
            padding: 14px 16px;
            border-bottom: 1px solid #e2e8f0;
        }
        .em-detail-row:last-child {
            border-bottom: none;
        }
        .em-detail-label {
            font-size: 13px;
            color: #94a3b8;
            min-width: 120px;
            flex-shrink: 0;
        }
        .em-detail-val {
            font-size: 13px;
            font-weight: 500;
            color: #13294b;
            flex: 1;
        }
        .em-notice {
            display: flex;
            gap: 12px;
            align-items: flex-start;
            background: #dcfce7;
            border: 1px solid #86efac;
            border-radius: 10px;
            padding: 12px 14px;
            margin-bottom: 28px;
        }
        .em-notice-icon {
            font-size: 17px;
            margin-top: 1px;
            flex-shrink: 0;
        }
        .em-notice p {
            font-size: 13px;
            color: #14532d;
            line-height: 1.5;
        }
        .em-btn-wrap {
            text-align: center;
        }
        .em-btn {
            display: inline-block;
            background: #1a6ed8;
            color: #ffffff;
            padding: 13px 32px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 500;
            text-decoration: none;
        }
        .em-footer {
            background: #f8fafc;
            border-top: 1px solid #e2e8f0;
            padding: 18px 32px;
            text-align: center;
        }
        .em-footer p {
            font-size: 12px;
            color: #94a3b8;
            line-height: 1.7;
        }
    </style>
</head>
<body>
    <div class="email-card">

        <div class="em-header">
            <div class="em-badge">✅ Ticket Creado</div>
            <div class="em-divider"></div>
            <h1>Se ha generado su ticket correctamente</h1>
            <p>Tu solicitud ha sido registrada con éxito</p>
        </div>

        <div class="em-body">
            <p class="em-greeting">¡Hola, {{ $usuario->nombre }} {{ $usuario->apellido_paterno }}!</p>
            <p class="em-subtext">Tu ticket ha sido creado exitosamente en nuestro sistema. Nuestro equipo de soporte técnico lo revisará a la brevedad posible.</p>

            <div class="em-ticket-code">
                <div class="em-ticket-code-label">Número de ticket</div>
                <div class="em-ticket-code-val">{{ $ticket->codigo_ticket }}</div>
            </div>

            <div class="em-details">
                <div class="em-details-header">Detalles del ticket</div>
                <div class="em-detail-row">
                    <div class="em-detail-label">Asunto:</div>
                    <div class="em-detail-val">{{ $ticket->asunto }}</div>
                </div>
                <div class="em-detail-row">
                    <div class="em-detail-label">Problema:</div>
                    <div class="em-detail-val">{{ Str::limit($ticket->problema, 100) }}</div>
                </div>
                @if($ticket->tipo_equipo)
                <div class="em-detail-row">
                    <div class="em-detail-label">Tipo de equipo:</div>
                    <div class="em-detail-val">{{ $ticket->tipo_equipo }}</div>
                </div>
                @endif
                @if($ticket->marca)
                <div class="em-detail-row">
                    <div class="em-detail-label">Marca:</div>
                    <div class="em-detail-val">{{ $ticket->marca }}</div>
                </div>
                @endif
                <div class="em-detail-row">
                    <div class="em-detail-label">Estado:</div>
                    <div class="em-detail-val">PENDIENTE</div>
                </div>
                <div class="em-detail-row">
                    <div class="em-detail-label">Fecha de creación:</div>
                    <div class="em-detail-val">{{ $ticket->created_at->format('d/m/Y H:i') }} (UTC{{ now()->format('P') }})</div>
                </div>
            </div>

            <div class="em-notice">
                <div class="em-notice-icon">✅</div>
                <p><strong>Próximos pasos:</strong> Recibirás notificaciones por correo cada vez que tu ticket cambie de estado. Puedes hacer seguimiento desde el portal.</p>
            </div>

            <div class="em-btn-wrap">
                <a href="{{ url('/') }}" class="em-btn">Ver mi ticket →</a>
            </div>
        </div>

        <div class="em-footer">
            <p>Este es un correo automático, por favor no responder.</p>
            <p>&copy; {{ date('Y') }} Sistema de Tickets · Todos los derechos reservados.</p>
        </div>

    </div>
</body>
</html>
