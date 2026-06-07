<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<style>
* { margin:0; padding:0; box-sizing:border-box; }
body { font-family: DejaVu Sans, sans-serif; font-size:10px; color:#111; background:#fff; }

/* ── HEADER ── */
.hdr       { background:#0f4a8a; width:100%; }
.hdr-inner { padding:16px 24px 12px; display:table; width:100%; }
.hdr-l     { display:table-cell; vertical-align:middle; }
.hdr-r     { display:table-cell; vertical-align:middle; text-align:right; }
.brand     { font-size:16px; font-weight:700; color:#fff; letter-spacing:2px; }
.brand-s   { font-size:8px; color:#bfdbfe; letter-spacing:2px; margin-top:3px; }
.doc-t     { font-size:12px; font-weight:700; color:#fff; letter-spacing:.5px; }
.doc-s     { font-size:8px; color:#bfdbfe; margin-top:3px; }
.hdr-line  { height:3px; background:#1e3a8a; }

/* ── CONTENT ── */
.wrap { padding-bottom:44px; }

/* ── BLOQUE ── */
.blk     { margin:14px 20px; border:1px solid #bfdbfe; border-radius:4px; overflow:hidden; page-break-inside:avoid; }
.blk-hdr { background:#0f4a8a; padding:7px 14px; display:table; width:100%; }
.blk-hdr-l { display:table-cell; vertical-align:middle; }
.blk-hdr-r { display:table-cell; vertical-align:middle; text-align:right; }
.blk-t   { color:#fff; font-size:9px; font-weight:700; letter-spacing:.9px; text-transform:uppercase; }
.badge-tipo { background:#fff; color:#0f4a8a; font-size:8px; font-weight:700; padding:3px 10px; border-radius:20px; }

/* ── TABLA INFO ── */
.inf-tbl   { width:100%; border-collapse:collapse; background:#f9f9f9; }
.inf-tbl td { padding:9px 14px; border-right:1px solid #ddd; border-bottom:1px solid #ddd; vertical-align:top; }
.inf-tbl td:last-child { border-right:none; }
.inf-tbl tr:last-child td { border-bottom:none; }
.lbl { font-size:8px; color:#0f4a8a; font-weight:700; text-transform:uppercase; letter-spacing:.4px; display:block; margin-bottom:3px; }
.val { font-size:10px; font-weight:600; color:#111; }

/* ── PERIODO ── */
.periodo   { margin:0 20px 14px; background:#eff6ff; padding:9px 14px; display:table; width:calc(100% - 40px); }
.periodo-l { display:table-cell; vertical-align:middle; }
.periodo-r { display:table-cell; vertical-align:middle; text-align:right; }
.p-lbl     { font-size:8px; font-weight:700; color:#0f4a8a; text-transform:uppercase; letter-spacing:.5px; display:block; margin-bottom:3px; }
.p-val     { font-size:10px; font-weight:700; color:#111; }
.p-gen     { font-size:8px; color:#888; }

/* ── SEC TITLE ── */
.sec-t { margin:14px 20px 8px; }
.sec-t span { background:#0f4a8a; color:#fff; font-size:9px; font-weight:700; letter-spacing:.9px; text-transform:uppercase; padding:6px 14px; border-radius:3px; display:block; }

/* ── ESTADÍSTICAS ── */
.stats-w   { margin:0 20px 14px; }
.stats-tbl { width:100%; border-collapse:collapse; border:1px solid #ccc; }
.stats-tbl td { text-align:center; padding:12px 6px; border-right:1px solid #ddd; vertical-align:middle; background:#fff; }
.stats-tbl td:last-child { border-right:none; }
.s-n { font-size:20px; font-weight:700; display:block; margin-bottom:4px; color:#111; }
.s-l { font-size:8px; font-weight:700; text-transform:uppercase; letter-spacing:.4px; color:#666; }

/* ── USER CARD ── */
.uw { margin:0 20px; }
.uc { border:1px solid #ccc; border-radius:4px; margin-bottom:10px; overflow:hidden; page-break-inside:avoid; }
.uc-top { background:#f0f0f0; border-bottom:1px solid #ccc; display:table; width:100%; }
.uc-tl  { display:table-cell; padding:10px 14px; vertical-align:middle; width:50%; }
.uc-tr  { display:table-cell; padding:10px 14px; vertical-align:middle; text-align:right; }
.uname  { font-size:11px; font-weight:700; color:#111; }
.ucode  { font-size:9px; color:#555; margin-top:3px; }
.ust    { border-collapse:collapse; display:inline-table; }
.ust td { text-align:center; padding:0 10px; border-left:1px solid #ccc; vertical-align:middle; }
.ust td:first-child { border-left:none; }
.un     { font-size:15px; font-weight:700; display:block; color:#111; }
.ul     { font-size:7.5px; font-weight:600; text-transform:uppercase; color:#666; display:block; margin-top:2px; }

/* ── TICKET CARD ── */
.tw { margin:0 20px; }
.tc { border:1px solid #ddd; margin-bottom:2px; overflow:hidden; page-break-inside:avoid; }
.tc:last-child { margin-bottom:16px; border-radius:0 0 4px 4px; }

.tc-hdr  { background:#f5f5f5; border-bottom:1px solid #ddd; display:table; width:100%; }
.tc-hdr td { padding:7px 12px; font-size:9px; vertical-align:middle; }
.tc-num  { font-weight:700; color:#555; text-transform:uppercase; letter-spacing:.5px; }
.tc-num-tipo { color:#333; }
.tc-fecha { color:#555; text-align:right; }
.tc-fecha strong { color:#111; }

.tc-body { width:100%; border-collapse:collapse; }
.tc-body > tbody > tr > td { padding:10px 12px; vertical-align:top; background:#fff; }
.tc-col1 { width:40%; border-right:1px solid #eee; }
.tc-col2 { width:30%; border-right:1px solid #eee; }
.tc-col3 { width:30%; }

.tc-asunto-lbl { font-size:8px; font-weight:700; color:#666; text-transform:uppercase; letter-spacing:.3px; display:block; margin-bottom:4px; }
.tc-asunto     { font-size:11px; font-weight:700; color:#111; line-height:1.4; }

.dtbl   { width:100%; border-collapse:collapse; }
.dtbl td { padding:4px 0; font-size:10px; vertical-align:middle; border-bottom:1px solid #f0f0f0; }
.dtbl tr:last-child td { border-bottom:none; }
.dlbl   { color:#666; font-weight:700; font-size:8px; text-transform:uppercase; width:40%; padding-right:6px; }
.dval   { color:#222; font-weight:600; }

/* ── BADGES ── */
.badge  { display:inline-block; padding:2px 9px; border-radius:20px; font-size:8px; font-weight:700; letter-spacing:.3px; background:#dbeafe; color:#1d4ed8; border:1px solid #bfdbfe; }

.sub-lbl { font-size:8px; font-weight:700; color:#666; text-transform:uppercase; letter-spacing:.3px; display:block; margin-bottom:4px; }
.sub-val { font-size:10px; font-weight:600; color:#222; }

/* ── CABECERA SOLICITANTE ── */
.sol-bg { background:#0f4a8a; padding:9px 14px; border-radius:4px 4px 0 0; display:table; width:100%; }

/* ── NO DATA ── */
.nodata { margin:0 20px; text-align:center; padding:28px; color:#aaa; font-size:10px; border:2px dashed #ddd; border-radius:4px; }

/* ── FOOTER ── */
.ftr   { position:fixed; bottom:0; left:0; right:0; background:#0f4a8a; padding:7px 20px; display:table; width:100%; }
.ftr td { font-size:8px; vertical-align:middle; padding:0; }
.ftr-l { color:#bfdbfe; }
.ftr-r { color:#dbeafe; text-align:right; }
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
        <div class="doc-t">REPORTE DEL TÉCNICO</div>
        <div class="doc-s">Generado el {{ now()->format('d/m/Y') }} a las {{ now()->format('H:i') }}</div>
      </td>
    </tr>
  </table>
  <div class="hdr-line"></div>
</div>

<div class="wrap">

{{-- DATOS DEL TÉCNICO --}}
<div class="blk">
  <div class="blk-hdr">
    <table style="width:100%;border-collapse:collapse;">
      <tr>
        <td class="blk-hdr-l"><span class="blk-t">Datos del Técnico</span></td>
        <td class="blk-hdr-r"><span class="badge-tipo">REPORTE PERSONAL</span></td>
      </tr>
    </table>
  </div>
  <table class="inf-tbl">
    <tr>
      <td style="width:40%;"><span class="lbl">Nombre Completo</span><span class="val">{{ strtoupper($tecnico->nombre . ' ' . $tecnico->apellido_paterno . ' ' . $tecnico->apellido_materno) }}</span></td>
      <td style="width:20%;"><span class="lbl">Código Técnico</span><span class="val">{{ $tecnico->codigo_tecnico }}</span></td>
      <td style="width:40%;"><span class="lbl">Correo</span><span class="val">{{ $tecnico->correo }}</span></td>
    </tr>
    <tr>
      <td><span class="lbl">Cargo</span><span class="val">{{ $tecnico->cargo->nombre_cargo ?? 'Técnico' }}</span></td>
      <td><span class="lbl">Tickets en el periodo</span><span class="val">{{ $tickets->count() }}</span></td>
      <td><span class="lbl">Tickets Cerrados</span><span class="val">{{ $stats['cerrados'] }}</span></td>
    </tr>
  </table>
</div>

{{-- PERIODO --}}
<table class="periodo" style="width:calc(100% - 40px);border-collapse:collapse;">
  <tr>
    <td class="periodo-l">
      <span class="p-lbl">Periodo Analizado</span>
      <span class="p-val">{{ \Carbon\Carbon::parse($desdeStr)->format('d \d\e F \d\e Y') }} &nbsp;&rarr;&nbsp; {{ \Carbon\Carbon::parse($hastaStr)->format('d \d\e F \d\e Y') }}</span>
    </td>
    <td class="periodo-r"><span class="p-gen">Preparado por JHARDSYSTEX &bull; Documento confidencial</span></td>
  </tr>
</table>

{{-- RESUMEN EJECUTIVO --}}
<div class="sec-t"><span>Resumen Ejecutivo</span></div>
<div class="stats-w">
  <table class="stats-tbl">
    <tr>
      <td style="width:16.6%;"><span class="s-n">{{ $stats['total'] }}</span><span class="s-l">Total</span></td>
      <td style="width:16.6%;"><span class="s-n">{{ $stats['cerrados'] }}</span><span class="s-l">Cerrados</span></td>
      <td style="width:16.6%;"><span class="s-n">{{ $stats['programados'] }}</span><span class="s-l">Programados</span></td>
      <td style="width:16.6%;"><span class="s-n">{{ $stats['en_proceso'] }}</span><span class="s-l">En Proceso</span></td>
      <td style="width:16.6%;"><span class="s-n">{{ $stats['pendientes'] }}</span><span class="s-l">Pendientes</span></td>
      <td style="width:16.6%;"><span class="s-n">{{ $stats['cancelados'] }}</span><span class="s-l">Cancelados</span></td>
    </tr>
  </table>
</div>

{{-- DETALLE POR CLIENTE / USUARIO --}}
<div class="sec-t"><span>Detalle por Cliente / Usuario</span></div>
<div class="uw">
  @forelse($porCliente as $cliId => $cliData)
    {{-- Cabecera del cliente --}}
    <div style="background:#0f4a8a;padding:7px 14px;border-radius:4px 4px 0 0;margin-bottom:0;">
      <span style="color:#fff;font-size:10px;font-weight:700;">{{ strtoupper($cliData['razon_social']) }}</span>
      <span style="color:#bfdbfe;font-size:9px;margin-left:10px;">RUC: {{ $cliData['ruc'] }}</span>
    </div>

    @foreach($cliData['por_usuario'] as $nombre => $tu)
      @php
        $f    = $tu->first();
        $cerr = $tu->where('estado','CERRADO')->count();
        $prog = $tu->where('estado','PROGRAMADO')->count();
        $proc = $tu->where('estado','EN PROCESO')->count();
        $pend = $tu->where('estado','PENDIENTE')->count();
        $canc = $tu->where('estado','CANCELADO')->count();
      @endphp
      <div class="uc" style="border-radius:0;margin-bottom:0;border-top:none;">
        <table class="uc-top" style="width:100%;border-collapse:collapse;">
          <tr>
            <td class="uc-tl">
              <div class="uname">{{ $nombre }}</div>
              <div class="ucode">Cód: {{ $f->codigo_usuario }} &bull; DNI: {{ $f->usuario_dni }}</div>
            </td>
            <td class="uc-tr">
              <table class="ust">
                <tr>
                  <td><span class="un">{{ $tu->count() }}</span><span class="ul">Total</span></td>
                  <td><span class="un">{{ $cerr }}</span><span class="ul">Cerrados</span></td>
                  <td><span class="un">{{ $prog }}</span><span class="ul">Programados</span></td>
                  <td><span class="un">{{ $proc }}</span><span class="ul">En Proceso</span></td>
                  <td><span class="un">{{ $pend }}</span><span class="ul">Pendientes</span></td>
                  <td><span class="un">{{ $canc }}</span><span class="ul">Cancelados</span></td>
                </tr>
              </table>
            </td>
          </tr>
        </table>
        <table style="width:100%;border-collapse:collapse;background:#fff;">
          <tr>
            <td style="padding:8px 14px;width:50%;border-right:1px solid #eee;"><span class="lbl">Correo electrónico</span><span class="val">{{ $f->usuario_correo }}</span></td>
            <td style="padding:8px 14px;width:50%;"><span class="lbl">Tickets en el periodo</span><span class="val">{{ $tu->count() }} ticket(s)</span></td>
          </tr>
        </table>
      </div>
    @endforeach
    <div style="margin-bottom:12px;"></div>
  @empty
    <div class="nodata">No hay datos en el periodo seleccionado.</div>
  @endforelse
</div>

{{-- DETALLE DE TICKETS --}}
<div class="sec-t"><span>Tickets del Periodo &mdash; {{ $stats['total'] }} registro(s)</span></div>

@if($tickets->isEmpty())
  <div class="nodata">No se encontraron tickets en el rango de fechas seleccionado.</div>
@else
<div class="tw">
  @php $gi = 0; @endphp
  @foreach($porCliente as $cliId => $cliData)
    @foreach($cliData['por_usuario'] as $nomUsu => $tdu)
      @php $fu = $tdu->first(); @endphp

      {{-- Cabecera solicitante --}}
      <table style="width:100%;border-collapse:collapse;margin-bottom:0;page-break-inside:avoid;page-break-after:avoid;">
        <tr>
          <td class="sol-bg">
            <table style="width:100%;border-collapse:collapse;">
              <tr>
                <td>
                  <span style="font-size:8px;color:#bfdbfe;font-weight:700;text-transform:uppercase;letter-spacing:.8px;display:block;margin-bottom:2px;">
                    {{ strtoupper($cliData['razon_social']) }} &bull; Solicitante
                  </span>
                  <span style="font-size:12px;color:#fff;font-weight:700;">{{ $nomUsu }}</span>
                </td>
                <td style="text-align:right;">
                  <span style="font-size:9px;color:#bfdbfe;">
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
          $badgeCls = match(true) {
            str_contains($est,'CERR')  => 'b-cerr',
            str_contains($est,'PROGR') => 'b-prog',
            str_contains($est,'PROCE') => 'b-proc',
            str_contains($est,'PEND')  => 'b-pend',
            str_contains($est,'CANC')  => 'b-canc',
            default                    => 'badge',
          };
        @endphp

        <div class="tc" style="{{ $loop->last ? 'border-radius:0 0 4px 4px;margin-bottom:16px;' : '' }}">
          <table class="tc-hdr" style="width:100%;border-collapse:collapse;">
            <tr>
              <td class="tc-num">
                Ticket #{{ str_pad($gi,3,'0',STR_PAD_LEFT) }}
                <span style="color:#bbb;margin:0 5px;">|</span>
                <span class="tc-num-tipo">{{ $t->tipo_ticket_nombre }}</span>
                <span style="color:#bbb;margin:0 5px;">|</span>
                <span style="font-family:monospace;">{{ $t->codigo_ticket }}</span>
              </td>
              <td class="tc-fecha">
                Creado el <strong>{{ \Carbon\Carbon::parse($t->created_at)->format('d/m/Y \a \l\a\s H:i') }}</strong>
              </td>
            </tr>
          </table>
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
                    <td class="dval"><span class="badge">{{ $t->prioridad_nombre }}</span></td>
                  </tr>
                  @if($t->tipo_equipo || $t->marca)
                  <tr>
                    <td class="dlbl">Equipo</td>
                    <td class="dval">{{ implode(' ', array_filter([$t->tipo_equipo, $t->marca, $t->modelo])) }}</td>
                  </tr>
                  @endif
                  @if($t->serie_serial)
                  <tr>
                    <td class="dlbl">Serie</td>
                    <td class="dval">{{ $t->serie_serial }}</td>
                  </tr>
                  @endif
                </table>
              </td>
              <td class="tc-col3">
                <span class="sub-lbl">Técnico (yo)</span>
                <span class="sub-val">{{ $tecnico->nombre }} {{ $tecnico->apellido_paterno }}</span>
                @if($t->fecha_programado)
                  <span class="sub-lbl" style="margin-top:6px;">Programado</span>
                  <span class="sub-val">{{ \Carbon\Carbon::parse($t->fecha_programado)->format('d/m/Y') }}</span>
                @endif
                @if($t->fecha_en_proceso)
                  <span class="sub-lbl" style="margin-top:6px;">En proceso desde</span>
                  <span class="sub-val">{{ \Carbon\Carbon::parse($t->fecha_en_proceso)->format('d/m/Y') }}</span>
                @endif
                @if($t->fecha_resuelto)
                  <span class="sub-lbl" style="margin-top:6px;">Resuelto el</span>
                  <span class="sub-val">{{ \Carbon\Carbon::parse($t->fecha_resuelto)->format('d/m/Y') }}</span>
                @endif
              </td>
            </tr>
          </table>
        </div>
      @endforeach
    @endforeach
  @endforeach
</div>
@endif

</div>

{{-- FOOTER --}}
<table class="ftr" style="width:100%;border-collapse:collapse;">
  <tr>
    <td class="ftr-l">JHARDSYSTEX &mdash; Soluciones Especializadas de TI &mdash; Documento confidencial</td>
    <td class="ftr-r">{{ $tecnico->nombre }} {{ $tecnico->apellido_paterno }} &bull; Cód: {{ $tecnico->codigo_tecnico }} &bull; {{ now()->format('d/m/Y H:i') }}</td>
  </tr>
</table>

</body>
</html>
