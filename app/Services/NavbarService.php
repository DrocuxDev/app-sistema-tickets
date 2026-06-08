<?php

namespace App\Services;

use App\Models\Notificacion;
use App\Models\Ticket;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class NavbarService
{
    public static function config(): array
    {
        $tipo = session('tipo', '');

        return match ($tipo) {
            'admin'   => self::adminConfig(),
            'cliente' => self::clienteConfig(),
            'tecnico' => self::tecnicoConfig(),
            'usuario' => self::usuarioConfig(),
            default   => self::emptyConfig(),
        };
    }

    private static function emptyConfig(): array
    {
        return [
            'quickLinks'      => [],
            'searchModules'   => [],
            'notifTitle'      => 'Notificaciones',
            'notifSeeAll'     => null,
            'notifSeeAllText' => 'Ver todo →',
            'notifications'   => collect(),
            'notifCount'      => 0,
            'notifClickRoute' => null,
        ];
    }

    private static function adminConfig(): array
    {
        $pending = Ticket::whereNull('id_tecnico_asignado')
            ->orderByDesc('created_at')
            ->get();

        $count = Ticket::whereNull('id_tecnico_asignado')->count();

        $notifications = $pending->map(fn ($t) => [
            'id'          => 'ticket-' . $t->id_ticket,
            'ticket_id'   => $t->id_ticket,
            'icon'        => 'fa-triangle-exclamation',
            'icon_class'  => 'warning',
            'text'        => $t->asunto,
            'meta'        => [$t->codigo_ticket, 'Hace ' . $t->created_at->diffForHumans()],
            'href'        => null,
        ]);

        return [
            'quickLinks' => [
                ['route' => 'admin.mistickets',    'icon' => 'fa-ticket',           'title' => 'Mis Tickets'],
                ['route' => 'admin.datos',         'icon' => 'fa-user-pen',         'title' => 'Mis Datos'],
                ['route' => 'admin.asignarticket', 'icon' => 'fa-clipboard-check',  'title' => 'Asignar Tickets'],
                ['route' => 'admin.clientes',      'icon' => 'fa-building',         'title' => 'Clientes'],
            ],
            'searchModules' => [
                ['nombre' => 'Dashboard',         'ruta' => route('admin.dashboard'),     'icono' => 'fa-gauge-high',      'desc' => 'Panel principal'],
                ['nombre' => 'Mis Tickets',       'ruta' => route('admin.mistickets'),    'icono' => 'fa-ticket',          'desc' => 'Tickets asignados'],
                ['nombre' => 'Mis Datos',         'ruta' => route('admin.datos'),         'icono' => 'fa-user-pen',        'desc' => 'Editar perfil'],
                ['nombre' => 'Tickets Generales', 'ruta' => route('admin.asignarticket'), 'icono' => 'fa-clipboard-check', 'desc' => 'Gestionar tickets'],
                ['nombre' => 'Clientes',          'ruta' => route('admin.clientes'),      'icono' => 'fa-building',        'desc' => 'Listado clientes'],
                ['nombre' => 'Contactos',         'ruta' => route('admin.contactos'),     'icono' => 'fa-envelope',        'desc' => 'Mensajería'],
            ],
            'notifTitle'      => 'Tickets Pendientes',
            'notifSeeAll'     => route('admin.asignarticket'),
            'notifSeeAllText' => 'Gestionar todo →',
            'notifications'   => $notifications,
            'notifCount'      => $count,
            'notifClickRoute' => 'admin',
        ];
    }

    private static function clienteConfig(): array
    {
        $idCliente = session('id');

        // IDs de estados finales (CERRADO / CANCELADO)
        $estadosFinales = DB::table('estado_ticket')
            ->where('es_final', true)
            ->pluck('id_estado');

        // Auto-limpiar notificaciones de tickets ya finalizados para no acumular basura
        $notifObsoletas = Notificacion::where('id_cliente', $idCliente)
            ->where('leido', false)
            ->where('tipo', 'nuevo_ticket')
            ->whereHas('ticket', fn ($q) => $q->whereIn('id_estado', $estadosFinales))
            ->pluck('id_notificacion');

        if ($notifObsoletas->isNotEmpty()) {
            Notificacion::whereIn('id_notificacion', $notifObsoletas)
                ->update(['leido' => true]);
        }

        $items = Notificacion::where('id_cliente', $idCliente)
            ->where('leido', false)
            ->where('tipo', 'nuevo_ticket')
            ->whereHas('ticket', fn ($q) => $q->whereNotIn('id_estado', $estadosFinales))
            ->with('ticket')
            ->orderByDesc('created_at')
            ->get();

        $count = Notificacion::where('id_cliente', $idCliente)
            ->where('leido', false)
            ->where('tipo', 'nuevo_ticket')
            ->whereHas('ticket', fn ($q) => $q->whereNotIn('id_estado', $estadosFinales))
            ->count();

        return [
            'quickLinks' => [
                ['route' => 'cliente.dashboard', 'icon' => 'fa-gauge-high', 'title' => 'Dashboard'],
                ['route' => 'cliente.tickets',   'icon' => 'fa-ticket',     'title' => 'Mis Tickets'],
                ['route' => 'cliente.contactos', 'icon' => 'fa-envelope',   'title' => 'Contactos'],
                ['route' => 'cliente.datos',     'icon' => 'fa-user',       'title' => 'Mis Datos'],
            ],
            'searchModules' => [
                ['nombre' => 'Dashboard',   'ruta' => route('cliente.dashboard'), 'icono' => 'fa-gauge-high', 'desc' => 'Panel principal'],
                ['nombre' => 'Mis Tickets', 'ruta' => route('cliente.tickets'),   'icono' => 'fa-ticket',     'desc' => 'Tickets de la empresa'],
                ['nombre' => 'Contactos',   'ruta' => route('cliente.contactos'), 'icono' => 'fa-envelope',   'desc' => 'Mensajería'],
                ['nombre' => 'Mis Datos',   'ruta' => route('cliente.datos'),     'icono' => 'fa-user',       'desc' => 'Perfil empresa'],
            ],
            'notifTitle'      => 'Nuevos tickets de usuarios',
            'notifSeeAll'     => route('cliente.tickets'),
            'notifSeeAllText' => 'Ver tickets →',
            'notifications'   => self::mapDbNotifications($items, 'fa-user-plus', 'info'),
            'notifCount'      => $count,
            'notifClickRoute' => 'cliente',
        ];
    }

    private static function tecnicoConfig(): array
    {
        $idTecnico = session('id');

        // IDs de estados finales (CERRADO / CANCELADO)
        $estadosFinales = DB::table('estado_ticket')
            ->where('es_final', true)
            ->pluck('id_estado');

        // Auto-limpiar notificaciones de tickets ya finalizados
        $notifObsoletas = Notificacion::where('id_tecnico', $idTecnico)
            ->where('leido', false)
            ->whereIn('tipo', ['nuevo_ticket', 'asignacion'])
            ->whereHas('ticket', fn ($q) => $q->whereIn('id_estado', $estadosFinales))
            ->pluck('id_notificacion');

        if ($notifObsoletas->isNotEmpty()) {
            Notificacion::whereIn('id_notificacion', $notifObsoletas)
                ->update(['leido' => true]);
        }

        // Nuevos tickets + asignaciones (solo de tickets activos)
        $items = Notificacion::where('id_tecnico', $idTecnico)
            ->where('leido', false)
            ->whereIn('tipo', ['nuevo_ticket', 'asignacion'])
            ->whereHas('ticket', fn ($q) => $q->whereNotIn('id_estado', $estadosFinales))
            ->with('ticket')
            ->orderByDesc('created_at')
            ->get();

        $count = Notificacion::where('id_tecnico', $idTecnico)
            ->where('leido', false)
            ->whereIn('tipo', ['nuevo_ticket', 'asignacion'])
            ->whereHas('ticket', fn ($q) => $q->whereNotIn('id_estado', $estadosFinales))
            ->count();

        return [
            'quickLinks' => [
                ['route' => 'tecnico.datos',      'icon' => 'fa-user',     'title' => 'Mis Datos'],
                ['route' => 'tecnico.mistickets', 'icon' => 'fa-ticket',   'title' => 'Mis Tickets'],
                ['route' => 'tecnico.contactos',  'icon' => 'fa-envelope', 'title' => 'Contactos'],
            ],
            'searchModules' => [
                ['nombre' => 'Mis Datos',   'ruta' => route('tecnico.datos'),      'icono' => 'fa-user',     'desc' => 'Editar perfil'],
                ['nombre' => 'Mis Tickets', 'ruta' => route('tecnico.mistickets'), 'icono' => 'fa-ticket',   'desc' => 'Tickets asignados'],
                ['nombre' => 'Contactos',   'ruta' => route('tecnico.contactos'),  'icono' => 'fa-envelope', 'desc' => 'Mensajería'],
            ],
            'notifTitle'      => 'Tickets nuevos y asignados',
            'notifSeeAll'     => route('tecnico.mistickets'),
            'notifSeeAllText' => 'Ver mis tickets →',
            'notifications'   => self::mapTecnicoNotifications($items),
            'notifCount'      => $count,
            'notifClickRoute' => 'tecnico',
        ];
    }

    private static function usuarioConfig(): array
    {
        $idUsuario = session('id');

        $items = Notificacion::where('id_usuario', $idUsuario)
            ->where('leido', false)
            ->where('tipo', 'cambio_estado')
            ->with('ticket')
            ->orderByDesc('created_at')
            ->get();

        $count = Notificacion::where('id_usuario', $idUsuario)
            ->where('leido', false)
            ->where('tipo', 'cambio_estado')
            ->count();

        return [
            'quickLinks' => [
                ['route' => 'usuario.dashboard', 'icon' => 'fa-gauge-high', 'title' => 'Dashboard'],
                ['route' => 'usuario.datos',     'icon' => 'fa-user',       'title' => 'Mis Datos'],
            ],
            'searchModules' => [
                ['nombre' => 'Dashboard', 'ruta' => route('usuario.dashboard'), 'icono' => 'fa-gauge-high', 'desc' => 'Panel principal'],
                ['nombre' => 'Mis Datos', 'ruta' => route('usuario.datos'),     'icono' => 'fa-user',       'desc' => 'Editar perfil'],
            ],
            'notifTitle'      => 'Cambios en tus tickets',
            'notifSeeAll'     => route('usuario.dashboard'),
            'notifSeeAllText' => 'Ver dashboard →',
            'notifications'   => self::mapDbNotifications($items, 'fa-arrows-rotate', 'info'),
            'notifCount'      => $count,
            'notifClickRoute' => 'usuario',
        ];
    }

    // Notificaciones del técnico — ícono diferente por tipo
    private static function mapTecnicoNotifications(Collection $items): Collection
    {
        return $items->map(function (Notificacion $n) {
            $ticket    = $n->ticket;
            $isNuevo   = $n->tipo === 'nuevo_ticket';

            return [
                'id'         => $n->id_notificacion,
                'ticket_id'  => $n->id_ticket,
                'icon'       => $isNuevo ? 'fa-bell' : 'fa-clipboard-check',
                'icon_class' => $isNuevo ? 'warning' : 'success',
                'text'       => $n->mensaje,
                'meta'       => array_filter([
                    $ticket?->codigo_ticket,
                    $n->created_at?->diffForHumans(),
                ]),
                'href'       => null,
            ];
        });
    }

    private static function mapDbNotifications(Collection $items, string $icon, string $iconClass): Collection
    {
        return $items->map(function (Notificacion $n) use ($icon, $iconClass) {
            $ticket = $n->ticket;
            $estado = $n->id_estado
                ? DB::table('estado_ticket')->where('id_estado', $n->id_estado)->value('nombre_estado')
                : null;

            return [
                'id'         => $n->id_notificacion,
                'ticket_id'  => $n->id_ticket,
                'icon'       => $icon,
                'icon_class' => $iconClass,
                'text'       => $n->mensaje,
                'meta'       => array_filter([
                    $ticket?->codigo_ticket,
                    $estado,
                    $n->created_at?->diffForHumans(),
                ]),
                'href'       => null,
            ];
        });
    }
}
