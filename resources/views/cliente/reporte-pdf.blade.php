<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<style>
  * { margin:0; padding:0; box-sizing:border-box; }
  body {
    font-family: DejaVu Sans, sans-serif;
    font-size: 10px;
    color: #1a202c;
    background: #ffffff;
  }

  /* ─── HEADER ─── */
  .header {
    background: #13294b;
    padding: 0;
  }
  .header-top {
    padding: 16px 24px 12px;
    display: table;
    width: 100%;
  }
  .header-left  { display: table-cell; vertical-align: middle; }
  .header-right { display: table-cell; vertical-align: middle; text-align: right; }
  .brand-name { font-size: 16px; font-weight: 700; color: #ffffff; letter-spacing: 1.5px; }
  .brand-sub  { font-size: 8px; color: #90cdf4; letter-spacing: 2px; margin-top: 2px; }
  .doc-title  { font-size: 13px; font-weight: 700; color: #ffffff; letter-spacing: .5px; }
  .doc-sub    { font-size: 9px; color: #90cdf4; margin-top: 3px; }
  .header-stripe { height: 4px; background: #2b6cb0; }

  /* ─── INFO CLIENTE ─── */
  .block {
    margin: 14px 20px;
    border: 1px solid #bee3f8;
    border-radius: 6px;
    overflow: hidden;
    page-break-inside: avoid;
  }
  .block-header {
    background: #2b6cb0;
    padding: 7px 14px;
    display: table;
    width: 100%;
  }
  .block-header-left  { display: table-cell; vertical-align: middle; }
  .block-header-right { display: table-cell; vertical-align: middle; text-align: right; }
  .block-title { color: white; font-size: 9px; font-weight: 700; letter-spacing: .8px; text-transform: uppercase; }
  .badge-tipo {
    background: #90cdf4;
    color: #13294b;
    font-size: 8px;
    font-weight: 700;
    padding: 3px 10px;
    border-radius: 20px;
  }

  /* tabla transparente para cliente */
  .info-table {
    width: 100%;
    border-collapse: collapse;
    background: #f0f8ff;
  }
  .info-table td {
    padding: 9px 14px;
    border-right: 1px solid #bee3f8;
    border-bottom: 1px solid #bee3f8;
    vertical-align: top;
  }
  .info-table td:last-child { border-right: none; }
  .info-table tr:last-child td { border-bottom: none; }
  .lbl { font-size: 8px; color: #2b6cb0; font-weight: 700; text-transform: uppercase; letter-spacing: .4px; display: block; margin-bottom: 3px; }
  .val { font-size: 10px; font-weight: 600; color: #1a365d; }

  /* ─── PERIODO ─── */
  .periodo-bar {
    margin: 0 20px 14px;
    background: #f0f8ff;
    border-left: 4px solid #2b6cb0;
    border-radius: 0 6px 6px 0;
    padding: 9px 14px;
    display: table;
    width: calc(100% - 40px);
    page-break-inside: avoid;
  }
  .periodo-bar-left  { display: table-cell; vertical-align: middle; }
  .periodo-bar-right { display: table-cell; vertical-align: middle; text-align: right; }
  .periodo-label { font-size: 8px; font-weight: 700; color: #2b6cb0; text-transform: uppercase; letter-spacing: .5px; display: block; margin-bottom: 3px; }
  .periodo-val   { font-size: 10px; font-weight: 700; color: #1a365d; }
  .gen-label     { font-size: 8px; color: #718096; }

  /* ─── TÍTULO DE SECCIÓN ─── */
  .sec-title {
    margin: 16px 20px 10px;
    page-break-inside: avoid;
    page-break-after: avoid;
  }
  .sec-title-text {
    background: #2b6cb0;
    color: white;
    font-size: 9px;
    font-weight: 700;
    letter-spacing: .8px;
    text-transform: uppercase;
    padding: 6px 14px;
    border-radius: 4px;
    display: block;
  }

  /* ─── ESTADÍSTICAS ─── */
  .stats-block {
    margin: 0 20px 14px;
    page-break-inside: avoid;
  }
  .stats-table {
    width: 100%;
    border-collapse: collapse;
    border: 1px solid #e2e8f0;
    border-radius: 6px;
  }
  .stats-table td {
    text-align: center;
    padding: 12px 8px;
    border-right: 1px solid #e2e8f0;
    vertical-align: middle;
  }
  .stats-table td:last-child { border-right: none; }
  .stat-num { font-size: 18px; font-weight: 700; display: block; margin-bottom: 4px; }
  .stat-lbl { font-size: 8px; font-weight: 700; text-transform: uppercase; letter-spacing: .4px; color: #718096; }
  .s-total  { background: #f7fafc; }  .s-total .stat-num  { color: #2d3748; }
  .s-cerr   { background: #f0fff4; }  .s-cerr .stat-num   { color: #276749; }
  .s-proc   { background: #ebf8ff; }  .s-proc .stat-num   { color: #2b6cb0; }
  .s-pend   { background: #fffbeb; }  .s-pend .stat-num   { color: #975a16; }
  .s-canc   { background: #fff5f5; }  .s-canc .stat-num   { color: #c53030; }

  /* ─── RESUMEN POR USUARIO ─── */
  .user-wrap { margin: 0 20px 6px; }
  .user-card {
    border: 1px solid #bee3f8;
    border-radius: 6px;
    margin-bottom: 10px;
    overflow: hidden;
    page-break-inside: avoid;
  }
  .user-card-top {
    background: #ebf8ff;
    padding: 0;
    border-bottom: 1px solid #bee3f8;
    display: table;
    width: 100%;
  }
  .user-card-top-left  { display: table-cell; padding: 10px 14px; vertical-align: middle; }
  .user-card-top-right { display: table-cell; padding: 10px 14px; vertical-align: middle; text-align: right; }
  .uname { font-size: 11px; font-weight: 700; color: #1a365d; }
  .ucode { font-size: 9px; color: #4a90d9; margin-top: 3px; }

  .user-stats-table { border-collapse: collapse; }
  .user-stats-table td {
    text-align: center;
    padding: 4px 10px;
    border-left: 1px solid #bee3f8;
    vertical-align: middle;
  }
  .user-stats-table td:first-child { border-left: none; }
  .un { font-size: 16px; font-weight: 700; display: block; }
  .ul { font-size: 8px; font-weight: 600; text-transform: uppercase; color: #718096; display: block; margin-top: 2px; }
  .un-total { color: #2d3748; }
  .un-cerr  { color: #276749; }
  .un-proc  { color: #2b6cb0; }
  .un-pend  { color: #975a16; }
  .un-canc  { color: #c53030; }

  .user-card-bottom { padding: 0; }
  .user-info-table { width: 100%; border-collapse: collapse; }
  .user-info-table td {
    padding: 8px 14px;
    font-size: 10px;
    border-right: 1px solid #f0f4f8;
    vertical-align: top;
  }
  .user-info-table td:last-child { border-right: none; }

  /* ─── TICKET CARDS ─── */
  .tickets-wrap { margin: 0 20px; }

  .ticket-card {
    border: 1px solid #e2e8f0;
    border-radius: 6px;
    margin-bottom: 12px;
    overflow: hidden;
    page-break-inside: avoid;
  }
  .tc-cerrado   { border-left: 4px solid #38a169; }
  .tc-proceso   { border-left: 4px solid #3182ce; }
  .tc-pendiente { border-left: 4px solid #d69e2e; }
  .tc-cancelado { border-left: 4px solid #e53e3e; }
  .tc-default   { border-left: 4px solid #a0aec0; }

  .ticket-header-bar {
    background: #f7fafc;
    border-bottom: 1px solid #e2e8f0;
    display: table;
    width: 100%;
    padding: 0;
  }
  .ticket-header-bar td {
    padding: 7px 12px;
    vertical-align: middle;
    font-size: 9px;
  }
  .ticket-num   { font-weight: 700; color: #718096; text-transform: uppercase; letter-spacing: .5px; }
  .ticket-fecha { color: #4a5568; text-align: right; }
  .ticket-fecha strong { color: #1a365d; }

  /* tabla interna del ticket */
  .ticket-body-table {
    width: 100%;
    border-collapse: collapse;
  }
  .ticket-body-table > tbody > tr > td {
    padding: 10px 12px;
    vertical-align: top;
    font-size: 10px;
  }
  .ticket-col-main { width: 58%; border-right: 1px solid #e2e8f0; }
  .ticket-col-side { width: 42%; }

  .ticket-asunto {
    font-size: 11px;
    font-weight: 700;
    color: #1a365d;
    margin-bottom: 10px;
    line-height: 1.4;
  }

  /* sub-tabla de datos */
  .data-table {
    width: 100%;
    border-collapse: collapse;
  }
  .data-table td {
    padding: 5px 0;
    font-size: 10px;
    vertical-align: top;
    border-bottom: 1px solid #f0f4f8;
  }
  .data-table tr:last-child td { border-bottom: none; }
  .data-label { color: #718096; font-weight: 700; font-size: 8px; text-transform: uppercase; letter-spacing: .3px; width: 38%; padding-right: 6px; }
  .data-value { color: #2d3748; font-weight: 600; }

  /* badges */
  .badge {
    display: inline-block;
    padding: 2px 9px;
    border-radius: 20px;
    font-size: 8px;
    font-weight: 700;
    letter-spacing: .3px;
  }
  .badge-cerrado   { background: #f0fff4; color: #276749; border: 1px solid #c6f6d5; }
  .badge-proceso   { background: #ebf8ff; color: #2b6cb0; border: 1px solid #bee3f8; }
  .badge-pendiente { background: #fffbeb; color: #975a16; border: 1px solid #fefcbf; }
  .badge-cancelado { background: #fff5f5; color: #c53030; border: 1px solid #fed7d7; }
  .badge-default   { background: #edf2f7; color: #4a5568; border: 1px solid #e2e8f0; }

  .side-section-label {
    font-size: 8px;
    font-weight: 700;
    color: #2b6cb0;
    text-transform: uppercase;
    letter-spacing: .5px;
    margin-bottom: 8px;
    padding-bottom: 4px;
    border-bottom: 1px solid #bee3f8;
  }

  /* ─── FOOTER ─── */
  .footer {
    position: fixed;
    bottom: 0; left: 0; right: 0;
    background: #13294b;
    padding: 7px 20px;
    display: table;
    width: 100%;
  }
  .footer td { font-size: 8px; vertical-align: middle; padding: 0; }
  .footer-left  { color: #90cdf4; }
  .footer-right { color: #bee3f8; text-align: right; }

  .no-data {
    margin: 0 20px;
    text-align: center;
    padding: 30px;
    color: #a0aec0;
    font-size: 10px;
    border: 2px dashed #e2e8f0;
    border-radius: 6px;
  }

  .content-wrap { padding-bottom: 44px; }
</style>
</head>
<body>

{{-- ══════════════ HEADER ══════════════ --}}
<div class="header">
  <table class="header-top" style="width:100%; border-collapse:collapse;">
    <tr>
      <td class="header-left">
        <div class="brand-name">JHARDSYSTEX</div>
        <div class="brand-sub">SOLUCIONES ESPECIALIZADAS TI</div>
      </td>
      <td class="header-right">
        <div class="doc-title">REPORTE DE TICKETS</div>
        <div class="doc-sub">Generado el {{ now()->format('d/m/Y') }} a las {{ now()->format('H:i') }}</div>
      </td>
    </tr>
  </table>
  <div class="header-stripe"></div>
</div>

<div class="content-wrap">

{{-- ══════════════ INFO CLIENTE ══════════════ --}}
<div class="block">
  <div class="block-header">
    <table style="width:100%; border-collapse:collapse;">
      <tr>
        <td class="block-header-left"><span class="block-title">Datos del Cliente</span></td>
        <td class="block-header-right">
          <span class="badge-tipo">
            {{ $request->tipo === 'individual' ? 'REPORTE INDIVIDUAL' : 'REPORTE GENERAL' }}
          </span>
        </td>
      </tr>
    </table>
  </div>
  <table class="info-table">
    <tr>
      <td style="width:34%;">
        <span class="lbl">Razón Social</span>
        <span class="val">{{ strtoupper($cliente->razon_social) }}</span>
      </td>
      <td style="width:22%;">
        <span class="lbl">RUC</span>
        <span class="val">{{ $cliente->ruc }}</span>
      </td>
      <td style="width:44%;">
        <span class="lbl">Correo corporativo</span>
        <span class="val">{{ $cliente->correo }}</span>
      </td>
    </tr>
    <tr>
      <td>
        <span class="lbl">Rubro</span>
        <span class="val">{{ $cliente->rubro ?? '—' }}</span>
      </td>
      <td>
        <span class="lbl">Usuarios registrados</span>
        <span class="val">{{ $usuarios->count() }}</span>
      </td>
      <td>
        <span class="lbl">Sedes</span>
        <span class="val">{{ $cliente->sedes ?? '—' }}</span>
      </td>
    </tr>
  </table>
</div>

{{-- ══════════════ PERIODO ══════════════ --}}
<table class="periodo-bar" style="width:calc(100% - 40px);">
  <tr>
    <td class="periodo-bar-left">
      <span class="periodo-label">Periodo analizado</span>
      <span class="periodo-val">
        {{ \Carbon\Carbon::parse($request->desde)->format('d \d\e F \d\e Y') }}
        &nbsp;&rarr;&nbsp;
        {{ \Carbon\Carbon::parse($request->hasta)->format('d \d\e F \d\e Y') }}
      </span>
    </td>
    <td class="periodo-bar-right">
      <span class="gen-label">Preparado por JHARDSYSTEX &bull; Documento confidencial</span>
    </td>
  </tr>
</table>

{{-- ══════════════ ESTADÍSTICAS ══════════════ --}}
<div class="sec-title"><span class="sec-title-text">Resumen Ejecutivo</span></div>

<div class="stats-block">
  <table class="stats-table" style="width:100%; border-collapse:collapse; border:1px solid #e2e8f0;">
    <tr>
      <td class="s-total" style="text-align:center; padding:12px 8px; border-right:1px solid #e2e8f0; width:20%;">
        <span class="stat-num" style="font-size:18px; font-weight:700; display:block; color:#2d3748; margin-bottom:4px;">{{ $stats['total'] }}</span>
        <span class="stat-lbl" style="font-size:8px; font-weight:700; text-transform:uppercase; color:#718096;">Total Tickets</span>
      </td>
      <td class="s-cerr" style="text-align:center; padding:12px 8px; border-right:1px solid #e2e8f0; width:20%; background:#f0fff4;">
        <span class="stat-num" style="font-size:18px; font-weight:700; display:block; color:#276749; margin-bottom:4px;">{{ $stats['cerrados'] }}</span>
        <span class="stat-lbl" style="font-size:8px; font-weight:700; text-transform:uppercase; color:#718096;">Cerrados</span>
      </td>
      <td class="s-proc" style="text-align:center; padding:12px 8px; border-right:1px solid #e2e8f0; width:20%; background:#ebf8ff;">
        <span class="stat-num" style="font-size:18px; font-weight:700; display:block; color:#2b6cb0; margin-bottom:4px;">{{ $stats['en_proceso'] }}</span>
        <span class="stat-lbl" style="font-size:8px; font-weight:700; text-transform:uppercase; color:#718096;">En Proceso</span>
      </td>
      <td class="s-pend" style="text-align:center; padding:12px 8px; border-right:1px solid #e2e8f0; width:20%; background:#fffbeb;">
        <span class="stat-num" style="font-size:18px; font-weight:700; display:block; color:#975a16; margin-bottom:4px;">{{ $stats['pendientes'] }}</span>
        <span class="stat-lbl" style="font-size:8px; font-weight:700; text-transform:uppercase; color:#718096;">Pendientes</span>
      </td>
      <td class="s-canc" style="text-align:center; padding:12px 8px; width:20%; background:#fff5f5;">
        <span class="stat-num" style="font-size:18px; font-weight:700; display:block; color:#c53030; margin-bottom:4px;">{{ $stats['cancelados'] }}</span>
        <span class="stat-lbl" style="font-size:8px; font-weight:700; text-transform:uppercase; color:#718096;">Cancelados</span>
      </td>
    </tr>
  </table>
</div>

{{-- ══════════════ RESUMEN POR USUARIO ══════════════ --}}
<div class="sec-title"><span class="sec-title-text">Detalle por Usuario</span></div>

<div class="user-wrap">
  @forelse($porUsuario as $nombre => $ticketsUser)
  @php
    $cerr  = $ticketsUser->where('estado','Cerrado')->count();
    $pend  = $ticketsUser->whereIn('estado',['Pendiente','Abierto'])->count();
    $canc  = $ticketsUser->where('estado','Cancelado')->count();
    $proc  = $ticketsUser->where('estado','En Proceso')->count();
    $first = $ticketsUser->first();
  @endphp
  <div class="user-card">

    {{-- fila superior: nombre + contadores --}}
    <table style="width:100%; border-collapse:collapse; background:#ebf8ff; border-bottom:1px solid #bee3f8;">
      <tr>
        <td style="padding:10px 14px; vertical-align:middle; width:55%;">
          <div class="uname">{{ $nombre }}</div>
          <div class="ucode">
            Cód: {{ $first->codigo_usuario }}
            &nbsp;&bull;&nbsp; DNI: {{ $first->usuario_dni }}
          </div>
        </td>
        <td style="padding:10px 14px; vertical-align:middle; text-align:right;">
          <table class="user-stats-table" style="display:inline-table; border-collapse:collapse;">
            <tr>
              <td style="text-align:center; padding:0 10px; border-left:1px solid #bee3f8;">
                <span class="un un-total" style="font-size:16px; font-weight:700; display:block; color:#2d3748;">{{ $ticketsUser->count() }}</span>
                <span class="ul" style="font-size:8px; font-weight:600; text-transform:uppercase; color:#718096; display:block; margin-top:2px;">Total</span>
              </td>
              <td style="text-align:center; padding:0 10px; border-left:1px solid #bee3f8;">
                <span class="un" style="font-size:16px; font-weight:700; display:block; color:#276749;">{{ $cerr }}</span>
                <span class="ul" style="font-size:8px; font-weight:600; text-transform:uppercase; color:#718096; display:block; margin-top:2px;">Cerrados</span>
              </td>
              <td style="text-align:center; padding:0 10px; border-left:1px solid #bee3f8;">
                <span class="un" style="font-size:16px; font-weight:700; display:block; color:#2b6cb0;">{{ $proc }}</span>
                <span class="ul" style="font-size:8px; font-weight:600; text-transform:uppercase; color:#718096; display:block; margin-top:2px;">En Proceso</span>
              </td>
              <td style="text-align:center; padding:0 10px; border-left:1px solid #bee3f8;">
                <span class="un" style="font-size:16px; font-weight:700; display:block; color:#975a16;">{{ $pend }}</span>
                <span class="ul" style="font-size:8px; font-weight:600; text-transform:uppercase; color:#718096; display:block; margin-top:2px;">Pendientes</span>
              </td>
              <td style="text-align:center; padding:0 10px; border-left:1px solid #bee3f8;">
                <span class="un" style="font-size:16px; font-weight:700; display:block; color:#c53030;">{{ $canc }}</span>
                <span class="ul" style="font-size:8px; font-weight:600; text-transform:uppercase; color:#718096; display:block; margin-top:2px;">Cancelados</span>
              </td>
            </tr>
          </table>
        </td>
      </tr>
    </table>

    {{-- fila inferior: datos de contacto --}}
    <table style="width:100%; border-collapse:collapse; background:white;">
      <tr>
        <td style="padding:8px 14px; width:50%; border-right:1px solid #f0f4f8;">
          <span class="lbl">Correo electrónico</span>
          <span class="val">{{ $first->usuario_correo }}</span>
        </td>
        <td style="padding:8px 14px; width:50%;">
          <span class="lbl">Tickets en el periodo</span>
          <span class="val">{{ $ticketsUser->count() }} ticket(s) registrado(s)</span>
        </td>
      </tr>
    </table>

  </div>
  @empty
  <div class="no-data">No hay usuarios con tickets en el periodo seleccionado.</div>
  @endforelse
</div>

{{-- ══════════════ DETALLE DE TICKETS ══════════════ --}}
<div class="sec-title">
  <span class="sec-title-text">Tickets del Periodo &mdash; {{ $stats['total'] }} registro(s)</span>
</div>

@if($tickets->isEmpty())
  <div class="no-data">No se encontraron tickets en el rango de fechas seleccionado.</div>
@else
<div class="tickets-wrap">

  @foreach($porUsuario as $nombreUsuario => $ticketsDelUsuario)
  @php $firstUser = $ticketsDelUsuario->first(); @endphp

  {{-- ── CABECERA DEL SOLICITANTE ── --}}
  <table style="width:100%; border-collapse:collapse; margin-bottom:6px; page-break-inside:avoid; page-break-after:avoid;">
    <tr>
      <td style="background:#2b6cb0; padding:9px 14px; border-radius:6px 6px 0 0;">
        <table style="width:100%; border-collapse:collapse;">
          <tr>
            <td style="vertical-align:middle;">
              <span style="font-size:9px; color:#bee3f8; font-weight:700; text-transform:uppercase; letter-spacing:.8px; display:block; margin-bottom:2px;">Solicitante</span>
              <span style="font-size:12px; color:#ffffff; font-weight:700;">{{ $nombreUsuario }}</span>
            </td>
            <td style="vertical-align:middle; text-align:right;">
              <span style="font-size:9px; color:#bee3f8;">
                Cód: <strong style="color:white;">{{ $firstUser->codigo_usuario }}</strong>
                &nbsp;&bull;&nbsp;
                DNI: <strong style="color:white;">{{ $firstUser->usuario_dni }}</strong>
                &nbsp;&bull;&nbsp;
                {{ $firstUser->usuario_correo }}
              </span>
            </td>
          </tr>
        </table>
      </td>
    </tr>
  </table>

  {{-- ── TICKETS DE ESTE SOLICITANTE ── --}}
  @foreach($ticketsDelUsuario as $i => $t)
  @php
    $est = strtolower($t->estado);
    $tcClass = match(true) {
        str_contains($est,'cerr')                                => 'tc-cerrado',
        str_contains($est,'proce')                               => 'tc-proceso',
        str_contains($est,'pend') || str_contains($est,'abier') => 'tc-pendiente',
        str_contains($est,'canc')                                => 'tc-cancelado',
        default                                                  => 'tc-default',
    };
    $badgeClass = match(true) {
        str_contains($est,'cerr')                                => 'badge-cerrado',
        str_contains($est,'proce')                               => 'badge-proceso',
        str_contains($est,'pend') || str_contains($est,'abier') => 'badge-pendiente',
        str_contains($est,'canc')                                => 'badge-cancelado',
        default                                                  => 'badge-default',
    };
    $prioBg = $t->prioridad_color
        ? 'background:' . $t->prioridad_color . '22; color:' . $t->prioridad_color . '; border:1px solid ' . $t->prioridad_color . '55;'
        : 'background:#edf2f7; color:#4a5568; border:1px solid #e2e8f0;';
    // Número global del ticket en el reporte
    static $globalIdx = 0;
    $globalIdx++;
  @endphp

  <div class="ticket-card {{ $tcClass }}" style="border-radius: {{ $loop->last ? '0 0 6px 6px' : '0' }}; margin-bottom: {{ $loop->last ? '16px' : '2px' }};">

    {{-- cabecera del ticket --}}
    <table style="width:100%; border-collapse:collapse; background:#f7fafc; border-bottom:1px solid #e2e8f0;">
      <tr>
        <td style="padding:7px 12px; font-size:9px; font-weight:700; color:#718096; text-transform:uppercase; letter-spacing:.5px;">
          Ticket #{{ str_pad($globalIdx, 3, '0', STR_PAD_LEFT) }}
          <span style="color:#bee3f8; margin:0 6px;">|</span>
          <span style="color:#4a90d9;">{{ $t->tipo_ticket_nombre }}</span>
        </td>
        <td style="padding:7px 12px; font-size:9px; color:#4a5568; text-align:right;">
          Creado el <strong style="color:#1a365d;">{{ \Carbon\Carbon::parse($t->created_at)->format('d/m/Y \a \l\a\s H:i') }}</strong>
        </td>
      </tr>
    </table>

    {{-- cuerpo: asunto + datos en una sola fila --}}
    <table style="width:100%; border-collapse:collapse;">
      <tr>
        {{-- asunto --}}
        <td style="width:40%; padding:10px 12px; vertical-align:top; border-right:1px solid #e2e8f0;">
          <span style="font-size:8px; font-weight:700; color:#718096; text-transform:uppercase; letter-spacing:.3px; display:block; margin-bottom:4px;">Asunto</span>
          <span style="font-size:11px; font-weight:700; color:#1a365d; line-height:1.4;">
            {{ $t->asunto ?? $t->descripcion ?? 'Sin descripción' }}
          </span>
        </td>
        {{-- estado + prioridad --}}
        <td style="width:30%; padding:10px 12px; vertical-align:top; border-right:1px solid #e2e8f0;">
          <table style="width:100%; border-collapse:collapse;">
            <tr>
              <td style="padding:4px 0; border-bottom:1px solid #f0f4f8; font-size:8px; font-weight:700; color:#718096; text-transform:uppercase; width:40%;">Estado</td>
              <td style="padding:4px 0; border-bottom:1px solid #f0f4f8; font-size:10px;">
                <span class="badge {{ $badgeClass }}">{{ $t->estado }}</span>
              </td>
            </tr>
            <tr>
              <td style="padding:4px 0; font-size:8px; font-weight:700; color:#718096; text-transform:uppercase;">Prioridad</td>
              <td style="padding:4px 0; font-size:10px;">
                <span class="badge" style="{{ $prioBg }}">{{ $t->prioridad_nombre }}</span>
              </td>
            </tr>
          </table>
        </td>
        {{-- técnico --}}
        <td style="width:30%; padding:10px 12px; vertical-align:top;">
          <span style="font-size:8px; font-weight:700; color:#718096; text-transform:uppercase; letter-spacing:.3px; display:block; margin-bottom:4px;">Técnico asignado</span>
          <span style="font-size:10px; font-weight:600; color:#2d3748;">
            {{ $t->tecnico_nombre ?: 'Sin asignar' }}
          </span>
        </td>
      </tr>
    </table>

  </div>{{-- fin ticket-card --}}
  @endforeach

  @endforeach

</div>
@endif

</div>{{-- fin content-wrap --}}

{{-- ══════════════ FOOTER FIJO ══════════════ --}}
<table class="footer" style="width:100%; border-collapse:collapse;">
  <tr>
    <td class="footer-left">JHARDSYSTEX &mdash; Soluciones Especializadas TI &mdash; Documento confidencial</td>
    <td class="footer-right">{{ $cliente->razon_social }} &bull; RUC {{ $cliente->ruc }} &bull; {{ now()->format('d/m/Y H:i') }}</td>
  </tr>
</table>

</body>
</html>
