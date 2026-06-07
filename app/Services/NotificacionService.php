<?php

namespace App\Services;

use App\Models\Notificacion;
use Illuminate\Support\Facades\DB;

class NotificacionService
{
    public static function nuevoTicketCliente(object $ticket, object $usuario): void
    {
        $nombre = trim(($usuario->nombre ?? '') . ' ' . ($usuario->apellido_paterno ?? ''));

        Notificacion::create([
            'id_cliente' => $ticket->id_cliente,
            'id_ticket'  => $ticket->id_ticket,
            'tipo'       => 'nuevo_ticket',
            'mensaje'    => "{$nombre} creó el ticket {$ticket->codigo_ticket}",
        ]);
    }

    public static function cambioEstadoUsuario(int $ticketId, int $nuevoEstadoId): void
    {
        $ticket = DB::table('ticket')->where('id_ticket', $ticketId)->first();
        if (!$ticket) {
            return;
        }

        $estado = DB::table('estado_ticket')->where('id_estado', $nuevoEstadoId)->first();
        if (!$estado) {
            return;
        }

        Notificacion::create([
            'id_usuario' => $ticket->id_usuario,
            'id_ticket'  => $ticketId,
            'id_estado'  => $nuevoEstadoId,
            'tipo'       => 'cambio_estado',
            'mensaje'    => "Tu ticket {$ticket->codigo_ticket} cambió a {$estado->nombre_estado}",
        ]);
    }

    public static function asignacionTecnico(int $ticketId, int $idTecnico): void
    {
        $ticket = DB::table('ticket')->where('id_ticket', $ticketId)->first();
        if (!$ticket) {
            return;
        }

        Notificacion::create([
            'id_tecnico' => $idTecnico,
            'id_ticket'  => $ticketId,
            'tipo'       => 'asignacion',
            'mensaje'    => "Se te asignó el ticket {$ticket->codigo_ticket}",
        ]);
    }

    public static function marcarLeida(int $idNotificacion): bool
    {
        $tipo = session('tipo');
        $id   = session('id');

        if (!$tipo || !$id) {
            return false;
        }

        $query = Notificacion::where('id_notificacion', $idNotificacion)->where('leido', false);

        match ($tipo) {
            'cliente' => $query->where('id_cliente', $id),
            'usuario' => $query->where('id_usuario', $id),
            'tecnico' => $query->where('id_tecnico', $id),
            default   => null,
        };

        if ($tipo === 'admin') {
            return false;
        }

        return (bool) $query->update(['leido' => true]);
    }
}
