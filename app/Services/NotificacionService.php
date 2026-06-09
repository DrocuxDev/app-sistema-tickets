<?php

namespace App\Services;

use App\Models\Notificacion;
use Illuminate\Support\Facades\DB;

class NotificacionService
{
    public static function nuevoTicketCliente(object $ticket, object $usuario): void
    {
        $nombre = trim(($usuario->nombre ?? '') . ' ' . ($usuario->apellido_paterno ?? ''));

        // Notificar al cliente
        Notificacion::create([
            'id_cliente' => $ticket->id_cliente,
            'id_ticket'  => $ticket->id_ticket,
            'tipo'       => 'nuevo_ticket',
            'mensaje'    => "{$nombre} creó el ticket {$ticket->codigo_ticket}",
        ]);

        // Notificar a todos los técnicos activos
        $tecnicos = DB::table('tecnico')->where('activo', 1)->pluck('id_tecnico');
        foreach ($tecnicos as $idTecnico) {
            Notificacion::create([
                'id_tecnico' => $idTecnico,
                'id_ticket'  => $ticket->id_ticket,
                'tipo'       => 'nuevo_ticket',
                'mensaje'    => "Nuevo ticket de {$nombre}: {$ticket->codigo_ticket}",
            ]);
        }
    }

    public static function cambioEstadoUsuario(int $ticketId, int $nuevoEstadoId, ?int $estadoAnteriorId = null): void
    {
        $ticket = DB::table('ticket')->where('id_ticket', $ticketId)->first();
        if (!$ticket) {
            return;
        }

        // Si no se pasa el estado anterior, lo obtenemos del ticket actual
        // NOTA: Esto solo funciona si se llama ANTES de actualizar el ticket
        if ($estadoAnteriorId === null) {
            $estadoAnteriorId = $ticket->id_estado;
        }

        $estadoAnterior = DB::table('estado_ticket')
            ->where('id_estado', $estadoAnteriorId)
            ->value('nombre_estado') ?? 'PENDIENTE';

        // Obtener el estado NUEVO
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

        // Enviar email al usuario
        $usuario = DB::table('usuario')->where('id_usuario', $ticket->id_usuario)->first();
        if ($usuario && $usuario->correo) {
            try {
                \Mail::to($usuario->correo)->send(
                    new \App\Mail\TicketCambioEstado(
                        (object)[
                            'codigo_ticket' => $ticket->codigo_ticket,
                            'asunto' => $ticket->asunto,
                        ],
                        $usuario,
                        $estadoAnterior,
                        $estado->nombre_estado
                    )
                );
            } catch (\Exception $e) {
                \Log::error('Error enviando email de cambio estado: ' . $e->getMessage());
            }
        }
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

    public static function nuevoTicketTecnicos(object $ticket, object $usuario): void
    {
        // Alias por compatibilidad — llama al método principal
        self::nuevoTicketCliente($ticket, $usuario);
    }
}
