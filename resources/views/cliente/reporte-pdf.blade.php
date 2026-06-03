<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<style>
* { margin:0; padding:0; box-sizing:border-box; }
body { font-family: DejaVu Sans, sans-serif; font-size:10px; color:#1a202c; background:#fff; }

/* ── HEADER ── */
.hdr       { background:#0f2645; width:100%; }
.hdr-inner { padding:18px 24px 14px; display:table; width:100%; }
.hdr-l     { display:table-cell; vertical-align:middle; }
.hdr-r     { display:table-cell; vertical-align:middle; text-align:right; }
.brand     { font-size:17px; font-weight:700; color:#fff; letter-spacing:2px; }
.brand-s   { font-size:8px; color:#7ecfff; letter-spacing:2.5px; margin-top:3px; }
.doc-t     { font-size:13px; font-weight:700; color:#fff; letter-spacing:.5px; }
.doc-s     { font-size:8.5px; color:#90cdf4; margin-top:4px; }
.hdr-bar   { height:4px; background:linear-gradient(90deg,#2563eb,#0ea5e9,#2563eb); }

/* ── WRAPPER ── */
.wrap { padding-bottom:48px; }

/* ── SECCIÓN BLOQUE ── */
.blk       { margin:14px 20px; border:1px solid #c3daf5; border-radius:6px; overflow:hidden; page-break-inside:avoid; }
.blk-hdr   { background:#1e3a5f; padding:8px 14px; display:table; width:100%; }
.blk-hdr-l { display:table-cell; vertical-align:middle; }
.blk-hdr-r { display:table-cell; vertical-align:middle; text-align:right; }
.blk-t     { color:#fff; font-size:9px; font-weight:700; letter-spacing:.9px; text-transform:uppercase; }
.badge-tipo { background:#38bdf8; color:#0c1a2e; font-size:8px; font-weight:700; padding:3px 10px; border-radius:20px; }

/* ── TABLA INFO ── */
.inf-tbl   { width:100%; border-collapse:collapse; background:#eaf2ff; }
.inf-tbl td { padding:9px 14px; border-right:1px solid #c3daf5; border-bottom:1px solid #c3daf5; vertical-align:top; }
.inf-tbl td:last-child { border-right:none; }
.inf-tbl tr:last-child td { border-bottom:none; }
.lbl { font-size:8px; color:#1e3a5f; font-weight:700; text-transform:uppercase; letter-spacing:.4px; display:block; margin-bottom:3px; }
.val { font-size:10px; font-weight:600; color:#0f2645; }

/* ── PERIODO ── */
.periodo { margin:0 20px 14px; background:#eaf2ff; border-left:4px solid #2563eb; border-radius:0 6px 6px 0; padding:9px 14px; display:table; width:calc(100% - 40px); page-break-inside:avoid; }
.periodo-l { display:table-cell; vertical-align:middle; }
.periodo-r { display:table-cell; vertical-align:middle; text-align:right; }
.p-lbl     { font-size:8px; font-weight:700; color:#1e3a5f; text-transform:uppercase; letter-spacing:.5px; display:block; margin-bottom:3px; }
.p-val     { font-size:10px; font-weight:700; color:#0f2645; }
.p-gen     { font-size:8px; color:#64748b; }

/* ── SEC TITLE ── */
.sec-t { margin:14px 20px 8px; page-break-inside:avoid; page-break-after:avoid; }
.sec-t span { background:#1e3a5f; color:#fff; font-size:9px; font-weight:700; letter-spacing:.9px; text-transform:uppercase; padding:6px 14px; border-radius:4px; display:block; }

/* ── STATS ── */
.stats-w { margin:0 20px 14px; page-break-inside:avoid; }
.stats-tbl { width:100%; border-collapse:collapse; border:1px solid #cbd5e1; border-radius:6px; }
.stats-tbl td { text-align:center; padding:13px 6px; border-right:1px solid #cbd5e1; vertical-align:middle; }
.stats-tbl td:last-child { border-right:none; }
.s-n { font-size:20px; font-weight:700; display:block; margin-bottom:4px; }
.s-l { font-size:8px; font-weight:700; text-transform:uppercase; letter-spacing:.4px; color:#64748b; }

/* colores estadísticas */
.c-total { background:#f1f5f9; } .c-total .s-n { color:#0f172a; }
.c-cerr  { background:#f0fdf4; } .c-cerr  .s-n { color:#14532d; }
.c-prog  { background:#eff6ff; } .c-prog  .s-n { color:#1d4ed8; }
.c-proc  { background:#fff7ed; } .c-proc  .s-n { color:#9a3412; }
.c-pend  { background:#fefce8; } .c-pend  .s-n { color:#713f12; }
.c-canc  { background:#fff1f2; } .c-canc  .s-n { color:#9f1239; }

/* ── USER CARD ── */
.uw { margin:0 20px; }
.uc { border:1px solid #c3daf5; border-radius:6px; margin-bottom:10px; overflow:hidden; page-break-inside:avoid; }
.uc-top { background:#dbeafe; border-bottom:1px solid #c3daf5; display:table; width:100%; }
.uc-tl  { display:table-cell; padding:10px 14px; vertical-align:middle; width:50%; }
.uc-tr  { display:table-cell; padding:10px 14px; vertical-align:middle; text-align:right; }
.uname  { font-size:11px; font-weight:700; color:#0f2645; }
.ucode  { font-size:9px; color:#2563eb; margin-top:3px; }
.ust    { border-collapse:collapse; display:inline-table; }
.ust td { text-align:center; padding:0 10px; border-left:1px solid #bfdbfe; vertical-align:middle; }
.ust td:first-child { border-left:none; }
.un     { font-size:15px; font-weight:700; display:block; }
.ul     { font-size:7.5px; font-weight:600; text-transform:uppercase; color:#64748b; display:block; margin-top:2px; }

/* ── CABECERA SOLICITANTE ── */
.sol-hdr { background:#1e3a5f; padding:9px 14px; border-radius:6px 6px 0 0; display:table; width:100%; margin-bottom:0; page-break-inside:avoid; page-break-after:avoid; }
.sol-hdr-l { display:table-cell; vertical-align:middle; }
.sol-hdr-r { display:table-cell; vertical-align:middle; text-align:right; }

/* ── TICKET CARD ── */
.tw { margin:0 20px; }
.tc { border:1px solid #e2e8f0; border-radius:0; margin-bottom:2px; overflow:hidden; page-break-inside:avoid; }
.tc:last-child { margin-bottom:16px; border-radius:0 0 6px 6px; }
.tc-cerr { border-left:4px solid #16a34a; }
.tc-prog { border-left:4px solid #2563eb; }
.tc-proc { border-left:4px solid #ea580c; }
.tc-pend { border-left:4px solid #ca8a04; }
.tc-canc { border-left:4px solid #dc2626; }
.tc-def  { border-left:4px solid #94a3b8; }

.tc-hdr  { background:#f8fafc; border-bottom:1px solid #e2e8f0; display:table; width:100%; }
.tc-hdr td { padding:7px 12px; font-size:9px; vertical-align:middle; }
.tc-num  { font-weight:700; color:#64748b; text-transform:uppercase; letter-spacing:.5px; }
.tc-fecha { color:#475569; text-align:right; }
.tc-fecha strong { color:#0f2645; }

.tc-body { width:100%; border-collapse:collapse; }
.tc-body > tbody > tr > td { padding:10px 12px; vertical-align:top; }
.tc-col1 { width:40%; border-right:1px solid #e2e8f0; }
.tc-col2 { width:30%; border-right:1px solid #e2e8f0; }
.tc-col3 { width:30%; }

.tc-asunto-lbl { font-size:8px; font-weight:700; color:#64748b; text-transform:uppercase; letter-spacing:.3px; display:block; margin-bottom:4px; }
.tc-asunto     { font-size:11px; font-weight:700; color:#0f2645; line-height:1.4; }

.dtbl   { width:100%; border-collapse:collapse; }
.dtbl td { padding:4px 0; font-size:10px; vertical-align:middle; border-bottom:1px solid #f1f5f9; }
.dtbl tr:last-child td { border-bottom:none; }
.dlbl   { color:#64748b; font-weight:700; font-size:8px; text-transform:uppercase; width:40%; padding-right:6px; }
.dval   { color:#1e293b; font-weight:600; }

.badge  { display:inline-block; padding:2px 9px; border-radius:20px; font-size:8px; font-weight:700; letter-spacing:.3px; }
.b-cerr { background:#dcfce7; color:#14532d; border:1px solid #bbf7d0; }
.b-prog { background:#dbeafe; color:#1d4ed8; border:1px solid #bfdbfe; }
.b-proc { background:#ffedd5; color:#9a3412; border:1px solid #fed7aa; }
.b-pend { background:#fef9c3; color:#713f12; border:1px solid #fde68a; }
.b-canc { background:#fee2e2; color:#9f1239; border:1px solid #fecaca; }
.b-def  { background:#f1f5f9; color:#475569; border:1px solid #e2e8f0; }

.tec-lbl { font-size:8px; font-weight:700; color:#64748b; text-transform:uppercase; letter-spacing:.3px; display:block; margin-bottom:4px; }
.tec-val { font-size:10px; font-weight:600; color:#1e293b; }

/* ── NO DATA ── */
.nodata { margin:0 20px; text-align:center; padding:28px; color:#94a3b8; font-size:10px; border:2px dashed #e2e8f0; border-radius:6px; }

/* ── FOOTER ── */
.ftr { position:fixed; bottom:0; left:0; right:0; background:#0f2645; padding:7px 20px; display:table; width:100%; }
.ftr td { font-size:8px; vertical-align:middle; padding:0; }
.ftr-l { color:#7ecfff; }
.ftr-r { color:#bae6fd; text-align:right; }
</style>
</head>
<body>

{{-- HEADER --}}
<div class="hdr">
  <table class="hdr-inner" style="width:100%;border-collapse:collapse;">
    <tr>
      <td class="hdr-l">
        <div class="brand">JHARDSYSTEX</div>
        <div class="brand-s">SOLUCIONES ESPECIALIZADAS DE TI</div>
      </td>
      <td class="hdr-r">
        <div class="doc-t">REPORTE DE TICKETS</div>
        <div class="doc-s">Generado el {{ now()->format('d/m/Y') }} a las {{ now()->format('H:i') }}</div>
      </td>
    </tr>
  </table>
  <div class="hdr-bar"></div>
</div>

<div class="wrap">

{{-- DATOS CLIENTE --}}
<div class="blk">
  <div class="blk-hdr">
    <table style="width:100%;border-collapse:collapse;">
      <tr>
        <td class="blk-hdr-l"><span class="blk-t">Datos del Cliente</span></td>
        <td class="blk-hdr-r">
          <span class="badge-tipo">{{ $request->tipo === 'individual' ? 'REPORTE INDIVIDUAL' : 'REPORTE GENERAL' }}</span>
        </td>
      </tr>
    </table>
  </div>
  <table class="inf-tbl">
    <tr>
      <td style="width:34%;"><span class="lbl">Razón Social</span><span class="val">{{ strtoupper($cliente->razon_social) }}</span></td>
      <td style="width:22%;"><span class="lbl">RUC</span><span class="val">{{ $cliente->ruc }}</span></td>
      <td style="width:44%;"><span class="lbl">Correo Corporativo</span><span class="val">{{ $cliente->correo }}</span></td>
    </tr>
    <tr>
      <td><span class="lbl">Rubro</span><span class="val">{{ $cliente->rubro ?? '—' }}</span></td>
      <td><span class="lbl">Usuarios Registrados</span><span class="val">{{ $usuarios->count() }}</span></td>
      <td><span class="lbl">Sedes</span><span class="val">{{ $cliente->sedes ?? '—' }}</span></td>
    </tr>
  </table>
</div>

{{-- PERIODO --}}
<table class="periodo" style="width:calc(100% - 40px);border-collapse:collapse;">
  <tr>
    <td class="periodo-l">
      <span class="p-lbl">Periodo Analizado</span>
      <span class="p-val">{{ \Carbon\Carbon::parse($request->desde)->format('d \d\e F \d\e Y') }} &nbsp;&rarr;&nbsp; {{ \Carbon\Carbon::parse($request->hasta)->format('d \d\e F \d\e Y') }}</span>
    </td>
    <td class="periodo-r"><span class="p-gen">Preparado por JHARDSYSTEX &bull; Documento confidencial</span></td>
  </tr>
</table>

{{-- RESUMEN EJECUTIVO --}}
<div class="sec-t"><span>Resumen Ejecutivo</span></div>
<div class="stats-w">
  <table class="stats-tbl">
    <tr>
      <td class="c-total" style="width:16.6%;"><span class="s-n">{{ $stats['total'] }}</span><span class="s-l">Total</span></td>
      <td class="c-cerr"  style="width:16.6%;"><span class="s-n">{{ $stats['cerrados'] }}</span><span class="s-l">Cerrados</span></td>
      <td class="c-prog"  style="width:16.6%;"><span class="s-n">{{ $tickets->where('estado','PROGRAMADO')->count() }}</span><span class="s-l">Programados</span></td>
      <td class="c-proc"  style="width:16.6%;"><span class="s-n">{{ $stats['en_proceso'] }}</span><span class="s-l">En Proceso</span></td>
      <td class="c-pend"  style="width:16.6%;"><span class="s-n">{{ $tickets->where('estado','PENDIENTE')->count() }}</span><span class="s-l">Pendientes</span></td>
      <td class="c-canc"  style="width:16.6%;"><span class="s-n">{{ $stats['cancelados'] }}</span><span class="s-l">Cancelados</span></td>
    </tr>
  </table>
</div>

{{-- DETALLE POR USUARIO --}}
<div class="sec-t"><span>Detalle por Usuario</span></div>
<div class="uw">
  @forelse($porUsuario as $nombre => $tu)
    @php
      $cerr = $tu->where('estado','CERRADO')->count();
      $prog = $tu->where('estado','PROGRAMADO')->count();
      $proc = $tu->where('estado','EN PROCESO')->count();
      $pend = $tu->where('estado','PENDIENTE')->count();
      $canc = $tu->where('estado','CANCELADO')->count();
      $f    = $tu->first();
    @endphp
    <div class="uc">
      <table class="uc-top" style="width:100%;border-collapse:collapse;">
        <tr>
          <td class="uc-tl">
            <div class="uname">{{ $nombre }}</div>
            <div class="ucode">Cód: {{ $f->codigo_usuario }} &bull; DNI: {{ $f->usuario_dni }}</div>
          </td>
          <td class="uc-tr">
            <table class="ust">
              <tr>
                <td><span class="un" style="color:#0f172a;">{{ $tu->count() }}</span><span class="ul">Total</span></td>
                <td><span class="un" style="color:#14532d;">{{ $cerr }}</span><span class="ul">Cerrados</span></td>
                <td><span class="un" style="color:#1d4ed8;">{{ $prog }}</span><span class="ul">Programados</span></td>
                <td><span class="un" style="color:#9a3412;">{{ $proc }}</span><span class="ul">En Proceso</span></td>
                <td><span class="un" style="color:#713f12;">{{ $pend }}</span><span class="ul">Pendientes</span></td>
                <td><span class="un" style="color:#9f1239;">{{ $canc }}</span><span class="ul">Cancelados</span></td>
              </tr>
            </table>
          </td>
        </tr>
      </table>
      <table style="width:100%;border-collapse:collapse;background:#fff;">
        <tr>
          <td style="padding:8px 14px;width:50%;border-right:1px solid #f1f5f9;"><span class="lbl">Correo electrónico</span><span class="val">{{ $f->usuario_correo }}</span></td>
          <td style="padding:8px 14px;width:50%;"><span class="lbl">Tickets en el periodo</span><span class="val">{{ $tu->count() }} ticket(s) registrado(s)</span></td>
        </tr>
      </table>
    </div>
  @empty
    <div class="nodata">No hay usuarios con tickets en el periodo seleccionado.</div>
  @endforelse
</div>

{{-- DETALLE DE TICKETS --}}
<div class="sec-t"><span>Tickets del Periodo &mdash; {{ $stats['total'] }} registro(s)</span></div>

@if($tickets->isEmpty())
  <div class="nodata">No se encontraron tickets en el rango de fechas seleccionado.</div>
@else
<div class="tw">
  @php $gi = 0; @endphp
  @foreach($porUsuario as $nomUsu => $tdu)
    @php $fu = $tdu->first(); @endphp

    {{-- Cabecera solicitante --}}
    <table style="width:100%;border-collapse:collapse;margin-bottom:0;page-break-inside:avoid;page-break-after:avoid;">
      <tr>
        <td style="background:#1e3a5f;padding:9px 14px;border-radius:6px 6px 0 0;">
          <table style="width:100%;border-collapse:collapse;">
            <tr>
              <td>
                <span style="font-size:9px;color:#7ecfff;font-weight:700;text-transform:uppercase;letter-spacing:.8px;display:block;margin-bottom:2px;">Solicitante</span>
                <span style="font-size:12px;color:#fff;font-weight:700;">{{ $nomUsu }}</span>
              </td>
              <td style="text-align:right;">
                <span style="font-size:9px;color:#bae6fd;">
                  Cód: <strong style="color:#fff;">{{ $fu->codigo_usuario }}</strong>
                  &nbsp;&bull;&nbsp; DNI: <strong style="color:#fff;">{{ $fu->usuario_dni }}</strong>
                  &nbsp;&bull;&nbsp; {{ $fu->usuario_correo }}
                </span>
              </td>
            </tr>
          </table>
        </td>
      </tr>
    </table>

    {{-- Tickets del solicitante --}}
    @foreach($tdu as $t)
      @php
        $gi++;
        $est = strtoupper(trim($t->estado));
        $tcCls = match(true) {
          str_contains($est,'CERR')                       => 'tc-cerr',
          str_contains($est,'PROGR')                      => 'tc-prog',
          str_contains($est,'PROCE')                      => 'tc-proc',
          str_contains($est,'PEND')                       => 'tc-pend',
          str_contains($est,'CANC')                       => 'tc-canc',
          default                                         => 'tc-def',
        };
        $badgeCls = match(true) {
          str_contains($est,'CERR')                       => 'b-cerr',
          str_contains($est,'PROGR')                      => 'b-prog',
          str_contains($est,'PROCE')                      => 'b-proc',
          str_contains($est,'PEND')                       => 'b-pend',
          str_contains($est,'CANC')                       => 'b-canc',
          default                                         => 'b-def',
        };
        $prioBg = $t->prioridad_color
          ? 'background:'.$t->prioridad_color.'22;color:'.$t->prioridad_color.';border:1px solid '.$t->prioridad_color.'55;'
          : 'background:#f1f5f9;color:#475569;border:1px solid #e2e8f0;';
      @endphp

      <div class="tc {{ $tcCls }}" style="{{ $loop->last ? 'border-radius:0 0 6px 6px;margin-bottom:16px;' : '' }}">

        {{-- Cabecera ticket --}}
        <table class="tc-hdr" style="width:100%;border-collapse:collapse;">
          <tr>
            <td class="tc-num">
              Ticket #{{ str_pad($gi,3,'0',STR_PAD_LEFT) }}
              <span style="color:#cbd5e1;margin:0 5px;">|</span>
              <span style="color:#3b82f6;">{{ $t->tipo_ticket_nombre }}</span>
            </td>
            <td class="tc-fecha">
              Creado el <strong>{{ \Carbon\Carbon::parse($t->created_at)->format('d/m/Y \a \l\a\s H:i') }}</strong>
            </td>
          </tr>
        </table>

        {{-- Cuerpo ticket --}}
        <table class="tc-body" style="width:100%;border-collapse:collapse;">
          <tr>
            <td class="tc-col1">
              <span class="tc-asunto-lbl">Asunto</span>
              <span class="tc-asunto">{{ $t->asunto ?? 'Sin descripción' }}</span>
            </td>
            <td class="tc-col2">
              <table class="dtbl">
                <tr>
                  <td class="dlbl">Estado</td>
                  <td class="dval"><span class="badge {{ $badgeCls }}">{{ $t->estado }}</span></td>
                </tr>
                <tr>
                  <td class="dlbl">Prioridad</td>
                  <td class="dval"><span class="badge" style="{{ $prioBg }}">{{ $t->prioridad_nombre }}</span></td>
                </tr>
                @if($t->marca || $t->tipo_equipo)
                <tr>
                  <td class="dlbl">Equipo</td>
                  <td class="dval">{{ implode(' ', array_filter([$t->tipo_equipo, $t->marca, $t->modelo])) }}</td>
                </tr>
                @endif
              </table>
            </td>
            <td class="tc-col3">
              <span class="tec-lbl">Técnico asignado</span>
              <span class="tec-val">{{ $t->tecnico_nombre ?: 'Sin asignar' }}</span>
              @if($t->fecha_en_proceso)
                <span class="tec-lbl" style="margin-top:8px;">En proceso desde</span>
                <span class="tec-val">{{ \Carbon\Carbon::parse($t->fecha_en_proceso)->format('d/m/Y') }}</span>
              @endif
              @if($t->fecha_resuelto)
                <span class="tec-lbl" style="margin-top:6px;">Resuelto el</span>
                <span class="tec-val">{{ \Carbon\Carbon::parse($t->fecha_resuelto)->format('d/m/Y') }}</span>
              @endif
            </td>
          </tr>
        </table>

      </div>
    @endforeach
  @endforeach
</div>
@endif

</div>{{-- fin wrap --}}

{{-- FOOTER --}}
<table class="ftr" style="width:100%;border-collapse:collapse;">
  <tr>
    <td class="ftr-l">JHARDSYSTEX &mdash; Soluciones Especializadas de TI &mdash; Documento confidencial</td>
    <td class="ftr-r">{{ $cliente->razon_social }} &bull; RUC {{ $cliente->ruc }} &bull; {{ now()->format('d/m/Y H:i') }}</td>
  </tr>
</table>

</body>
</html>
