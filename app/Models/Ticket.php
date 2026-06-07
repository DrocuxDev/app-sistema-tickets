<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $table = 'ticket';
    protected $primaryKey = 'id_ticket';
    public $timestamps = true;

    protected $fillable = [
        'codigo_ticket',
        'id_cliente',
        'id_usuario',
        'id_tecnico_asignado',
        'id_tipo_ticket',
        'id_prioridad',
        'id_estado',
        'tipo_equipo',
        'marca',
        'modelo',
        'serie_serial',
        'asunto',
        'problema'
    ];
}