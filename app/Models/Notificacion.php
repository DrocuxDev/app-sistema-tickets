<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notificacion extends Model
{
    protected $table = 'notificacion';
    protected $primaryKey = 'id_notificacion';

    protected $fillable = [
        'id_cliente',
        'id_usuario',
        'id_tecnico',
        'id_ticket',
        'id_estado',
        'tipo',
        'mensaje',
        'leido',
    ];

    protected $casts = [
        'leido' => 'boolean',
    ];

    public function ticket()
    {
        return $this->belongsTo(Ticket::class, 'id_ticket', 'id_ticket');
    }
}
