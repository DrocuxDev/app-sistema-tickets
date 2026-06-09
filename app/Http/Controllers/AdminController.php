<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Ticket;
use App\Models\EstadoTicket;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use Carbon\Carbon;
use App\Models\Tecnico;
use App\Models\Usuario;
use App\Models\Cliente;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Services\NotificacionService;

class AdminController extends Controller
{
    private function tecnicoEsAdminProtegido(int $id): bool
    {
        $tecnico = Tecnico::with('cargo')->find($id);

        return $tecnico && $tecnico->esAdmin();
    }

    public function dashboard()
    {
        if (session('tipo') !== 'admin' || !session('id')) {
            return redirect('/')->with('error', 'Acceso restringido.');
        }

        // ═══════════════════════════════════════════════════════
        // ✅ TU CÓDIGO ORIGINAL (MANTENIDO PARA COMPATIBILIDAD)
        // ═══════════════════════════════════════════════════════
        
        // Tickets con toda la info
        $tickets = DB::table('ticket')
            ->join('tipo_ticket',   'ticket.id_tipo_ticket',          '=', 'tipo_ticket.id_tipo_ticket')
            ->join('prioridad',     'ticket.id_prioridad',            '=', 'prioridad.id_prioridad')
            ->join('estado_ticket', 'ticket.id_estado',               '=', 'estado_ticket.id_estado')
            ->join('cliente',       'ticket.id_cliente',              '=', 'cliente.id_cliente')
            ->join('usuario as usu','ticket.id_usuario',              '=', 'usu.id_usuario')
            ->leftJoin('tecnico as tec', 'ticket.id_tecnico_asignado','=', 'tec.id_tecnico')
            ->select(
                'ticket.*',
                'tipo_ticket.nombre              as tipo_ticket_nombre',
                'prioridad.nombre                as prioridad_nombre',
                'prioridad.color_hex             as prioridad_color',
                'estado_ticket.nombre_estado     as estado',
                'cliente.razon_social',
                'cliente.ruc',
                DB::raw("CONCAT(usu.nombre,' ',usu.apellido_paterno,' ',usu.apellido_materno) as usuario_nombre"),
                'usu.codigo_usuario',
                DB::raw("CONCAT(COALESCE(usu.codigo_pais,''),' ',COALESCE(usu.telefono,'')) as usuario_telefono"),
                DB::raw("(COALESCE(tec.nombre,'')||' '||COALESCE(tec.apellido_paterno,'')||' '||COALESCE(tec.apellido_materno,'')) as tecnico_nombre"),
                'tec.codigo_tecnico              as tecnico_codigo'
            )
            ->orderByDesc('ticket.created_at')
            ->get();

            if (request()->filled('desde') && request()->filled('hasta')) {
                $desde = \Carbon\Carbon::parse(request('desde'))->startOfDay();
                $hasta = \Carbon\Carbon::parse(request('hasta'))->endOfDay();
                $tickets = $tickets->filter(fn($t) => \Carbon\Carbon::parse($t->created_at)->between($desde, $hasta));
            }   

        $ticketIds = $tickets->pluck('id_ticket')->toArray();
        $evidencias  = DB::table('evidencia')->whereIn('id_ticket', $ticketIds)->get()->groupBy('id_ticket');
        $comentarios = DB::table('comentario')->whereIn('id_ticket', $ticketIds)->orderBy('created_at')->get()->groupBy('id_ticket');
        $reportes    = DB::table('reporte_tecnico')->whereIn('id_ticket', $ticketIds)->get()->groupBy('id_ticket');

        $tickets->each(function ($ticket) use ($evidencias, $comentarios, $reportes) {
            $ticket->evidencias  = $evidencias->get($ticket->id_ticket, collect());
            $ticket->comentarios = $comentarios->get($ticket->id_ticket, collect());
            $ticket->reportes    = $reportes->get($ticket->id_ticket, collect());
        });

        $tecnicos = Tecnico::orderBy('nombre')->get();
        $usuarios_lista = Usuario::orderBy('nombre')->get();
        $clientes = Cliente::orderBy('razon_social')->get();

        $resumen = [
            'total'      => $tickets->count(),
            'pendiente'  => $tickets->where('estado', 'PENDIENTE')->count(),
            'programado' => $tickets->where('estado', 'PROGRAMADO')->count(),
            'en_proceso' => $tickets->where('estado', 'EN PROCESO')->count(),
            'cerrado'    => $tickets->where('estado', 'CERRADO')->count(),
            'cancelado'  => $tickets->where('estado', 'CANCELADO')->count(),
            'total_usuarios' => $usuarios_lista->count(),
        ];

        // ═══════════════════════════════════════════════════════
        // ➕ NUEVO: DATOS PARA EL DASHBOARD ENTERPRISE
        // ═══════════════════════════════════════════════════════

        // ── KPIs Principales ──

        $kpi = [
            'total'        => $tickets->count(),
            'pendientes'   => $tickets->where('estado', 'PENDIENTE')->count(),
            'en_proceso'   => $tickets->where('estado', 'EN PROCESO')->count(),
            'cerrados_hoy' => $tickets->where('estado', 'CERRADO')
                            ->filter(fn($t) => $t->fecha_resuelto && \Carbon\Carbon::parse($t->fecha_resuelto)->isToday())
                            ->count(),

            'programado' => $tickets->where('estado', 'PROGRAMADO')->count(),
        ];

        // ── Técnicos: Libres vs Ocupados ──
        $idsOcupados = DB::table('ticket')
            ->join('estado_ticket', 'ticket.id_estado', '=', 'estado_ticket.id_estado')
            ->whereIn('estado_ticket.nombre_estado', ['PENDIENTE', 'PROGRAMADO', 'EN PROCESO'])
            ->whereNotNull('ticket.id_tecnico_asignado')
            ->distinct()
            ->pluck('ticket.id_tecnico_asignado')
            ->toArray();

        $totalActivos = $tecnicos->count();
        $tecnicos_ocupados = count(array_unique($idsOcupados));
        $tecnicos_libres   = max(0, $totalActivos - $tecnicos_ocupados);

        // ── Panel de Asignación Rápida ──
        $asignacion_rapida = DB::table('ticket')
            ->join('prioridad', 'ticket.id_prioridad', '=', 'prioridad.id_prioridad')
            ->join('cliente', 'ticket.id_cliente', '=', 'cliente.id_cliente')
            ->join('estado_ticket', 'ticket.id_estado', '=', 'estado_ticket.id_estado')
            ->leftJoin('usuario as usu', 'ticket.id_usuario', '=', 'usu.id_usuario') 
            ->whereNull('ticket.id_tecnico_asignado')
            ->whereNotIn('estado_ticket.nombre_estado', ['CERRADO', 'CANCELADO'])
            ->orderByRaw("CASE prioridad.nombre WHEN 'Crítica' THEN 1 WHEN 'Alta' THEN 2 WHEN 'Media' THEN 3 WHEN 'Baja' THEN 4 ELSE 5 END")
            ->orderByDesc('ticket.created_at')
            ->limit(8)
            ->select(
                'ticket.id_ticket',
                'ticket.codigo_ticket',
                'ticket.asunto',
                'ticket.created_at',
                'prioridad.nombre as prioridad',
                'prioridad.color_hex',
                'cliente.razon_social',
                DB::raw("CONCAT(usu.nombre,' ',usu.apellido_paterno,' ',usu.apellido_materno) as usuario_nombre")
            )
            ->get();

        // ── Estado del Sistema ──
        $sistema = [
            'clientes_activos'       => $clientes->where('activo', 1)->count(),
            'usuarios_bloqueados'    => $usuarios_lista->where('activo', 0)->count(),
            'tickets_sin_asignar_viejo' => $tickets->whereNull('id_tecnico_asignado')
                ->filter(fn($t) => \Carbon\Carbon::parse($t->created_at)->lt(\Carbon\Carbon::now()->subDays(3)))
                ->count(),
        ];

        // ── Técnicos para selects (reutilizamos colección) ──
        $tecnicos_select = $tecnicos;

        // ═══════════════════════════════════════════════════════
        // ✅ RETORNO ACTUALIZADO (original + nuevo)
        // ═══════════════════════════════════════════════════════
        return view('admin.dashboard', compact(
            // Original (para compatibilidad con tu vista actual)
            'tickets', 'tecnicos', 'usuarios_lista', 'clientes', 'resumen',
            // Nuevo (para el dashboard enterprise)
            'kpi', 'tecnicos_libres', 'tecnicos_ocupados',
            'asignacion_rapida', 'sistema', 'tecnicos_select'
        ));
    }


    public function cambiarEstadoCliente(Request $request, $id)
    {
        DB::table('cliente')->where('id_cliente', $id)->update(['activo' => $request->estado]);
        return response()->json(['ok' => true]);
    }

    public function cambiarEstadoUsuario(Request $request, $id)
    {
        DB::table('usuario')->where('id_usuario', $id)->update(['activo' => $request->estado]);
        return response()->json(['ok' => true]);
    }

    public function cambiarEstadoTecnico(Request $request, $id)
    {
        if (!$request->estado && $this->tecnicoEsAdminProtegido((int) $id)) {
            return response()->json([
                'ok'      => false,
                'message' => 'No se puede desactivar la cuenta del administrador principal.',
            ], 403);
        }

        DB::table('tecnico')->where('id_tecnico', $id)->update([
            'activo' => $request->estado, 
            'updated_at' => now()
        ]);
        return response()->json(['ok' => true]);
    }

  public function crearCliente(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'razon_social' => 'required|string|max:200',
            'ruc'          => 'required|string|size:11|unique:cliente,ruc',
            'correo'       => 'required|email|max:150|unique:cliente,correo',
            'contrasena'   => 'required|string|min:6',
            'sedes'        => 'nullable|string|max:200',
            'rubro'        => 'required|string|max:100',
        ], [
            'razon_social.required' => 'La razón social es obligatoria.',
            'razon_social.max'      => 'La razón social no debe exceder los 200 caracteres.',
            'ruc.required'          => 'El RUC es obligatorio.',
            'ruc.size'              => 'El RUC debe tener exactamente 11 dígitos.',
            'ruc.unique'            => 'El RUC ingresado ya se encuentra registrado.',
            'correo.required'       => 'El correo electrónico es obligatorio.',
            'correo.email'          => 'El formato del correo electrónico no es válido.',
            'correo.max'            => 'El correo electrónico no debe exceder los 150 caracteres.',
            'correo.unique'         => 'Este correo electrónico ya está registrado.',
            'contrasena.required'   => 'La contraseña es obligatoria.',
            'contrasena.min'        => 'La contraseña debe tener al menos 6 caracteres.',
            'sedes.max'             => 'El campo sedes no debe exceder los 200 caracteres.',
            'rubro.required'        => 'El rubro de la empresa es obligatorio.',
            'rubro.max'             => 'El campo rubro no debe exceder los 100 caracteres.',
        ]);

        if ($validator->fails()) {
            return response()->json(['ok' => false, 'errors' => $validator->errors()], 422);
        }

        try {
            DB::table('cliente')->insert([
                'razon_social' => $request->razon_social,
                'ruc'          => $request->ruc,
                'sedes'        => $request->sedes,
                'rubro'        => $request->rubro,
                'correo'       => $request->correo,
                'contraseña'   => Hash::make($request->contrasena),
                'activo'       => 1,
                'created_at'   => now(),
                'updated_at'   => now(),
            ]);

            // Enviar credenciales por correo
            $clienteObj = (object)[
                'nombre'           => $request->razon_social,
                'apellido_paterno' => '',
                'correo'           => $request->correo,
                'tipo'             => 'cliente',
                'razon_social'     => $request->razon_social,
            ];
            try {
                \Illuminate\Support\Facades\Mail::to($request->correo)
                    ->send(new \App\Mail\CredencialesUsuario($clienteObj, $request->contrasena));
            } catch (\Exception $mailEx) {
                \Log::warning('No se pudo enviar el correo al cliente: ' . $mailEx->getMessage());
            }

            return response()->json(['ok' => true]);

        } catch (\Exception $e) {
            return response()->json(['ok' => false, 'message' => $e->getMessage()], 500);
        }
    }
    public function guardarUsuario(Request $request)
{
    $validator = Validator::make($request->all(), [
        'id_cliente'       => 'required|exists:cliente,id_cliente',
        'codigo_usuario'   => 'required|string|max:20|unique:usuario,codigo_usuario',
        'nombre'           => 'required|string|max:100',
        'apellido_paterno' => 'required|string|max:100',
        'apellido_materno' => 'required|string|max:100',
        'dni'              => 'required|string|max:15|unique:usuario,dni',
        'codigo_pais'      => 'required|string|max:6',
        'telefono'         => 'required|string|max:15',
        'correo'           => 'required|email|max:150|unique:usuario,correo',
        'contrasena'       => 'required|string|min:6',
    ], [
        'id_cliente.required'         => 'Debe seleccionar un cliente.',
        'id_cliente.exists'           => 'El cliente seleccionado no es válido.',
        'codigo_usuario.required'     => 'El código de usuario es obligatorio.',
        'codigo_usuario.unique'       => 'El código de usuario ya se encuentra en uso.',
        'nombre.required'             => 'El nombre es obligatorio.',
        'nombre.max'                  => 'El nombre no debe exceder los 100 caracteres.',
        'apellido_paterno.required'   => 'El apellido paterno es obligatorio.',
        'apellido_paterno.max'        => 'El apellido paterno no debe exceder los 100 caracteres.',
        'apellido_materno.required'   => 'El apellido materno es obligatorio.',
        'apellido_materno.max'        => 'El apellido materno no debe ser mayor a 100 caracteres.',
        'dni.required'                => 'El DNI es obligatorio.',
        'dni.size'                    => 'El DNI debe tener exactamente 8 caracteres.',
        'dni.unique'                  => 'El DNI ingresado ya está registrado.',
        'telefono.required'           => 'El teléfono es obligatorio.',
        
        // ¡Solución al error de tu foto aquí! 🔥
        'correo.required'             => 'El correo es obligatorio.',
        'correo.email'                => 'El formato del correo no es válido.',
        'correo.max'                  => 'El correo electrónico no debe exceder los 150 caracteres.',
        'correo.unique'               => 'Este correo ya se encuentra registrado.',
        
        'contrasena.required'         => 'La contraseña es obligatoria.',
        'contrasena.min'              => 'La contraseña debe tener al menos 6 caracteres.',
        'contrasena.mixed_case'       => 'La contraseña debe contener al menos una letra mayúscula y una minúscula.',
        'contrasena.letters'          => 'La contraseña debe contener al menos una letra.',
        'contrasena.symbols'          => 'La contraseña debe contener al menos un símbolo.',
        'contrasena.numbers'          => 'La contraseña debe contener al menos un número.',
    ]);

    if ($validator->fails()) {
        return response()->json(['ok' => false, 'errors' => $validator->errors()], 422);
    }

    try {
        DB::table('usuario')->insert([
            'id_cliente'       => $request->id_cliente,
            'codigo_usuario'   => strtoupper(trim($request->codigo_usuario)),
            'nombre'           => ucfirst(strtolower(trim($request->nombre))),
            'apellido_paterno' => ucfirst(strtolower(trim($request->apellido_paterno))),
            'apellido_materno' => ucfirst(strtolower(trim($request->apellido_materno))),
            'dni'              => trim($request->dni),
            'codigo_pais'      => trim($request->codigo_pais),
            'telefono'         => trim($request->telefono),
            'correo'           => strtolower(trim($request->correo)),
            'contraseña'       => Hash::make($request->contrasena),
            'activo'           => 1,
            'created_at'       => now(),
            'updated_at'       => now(),
        ]);

        // Enviar credenciales por correo
        $usuarioObj = (object)[
            'nombre'           => ucfirst(strtolower(trim($request->nombre))),
            'apellido_paterno' => ucfirst(strtolower(trim($request->apellido_paterno))),
            'correo'           => strtolower(trim($request->correo)),
        ];
        try {
            \Illuminate\Support\Facades\Mail::to($request->correo)
                ->send(new \App\Mail\CredencialesUsuario($usuarioObj, $request->contrasena));
        } catch (\Exception $mailEx) {
            \Log::warning('No se pudo enviar el correo al usuario: ' . $mailEx->getMessage());
        }

        return response()->json(['ok' => true]);

    } catch (\Exception $e) {
        return response()->json(['ok' => false, 'message' => $e->getMessage()], 500);
    }

        try {
            DB::table('usuario')->insert([
                'id_cliente'       => $request->id_cliente,
                'codigo_usuario'   => strtoupper(trim($request->codigo_usuario)),
                'nombre'           => ucfirst(strtolower(trim($request->nombre))),
                'apellido_paterno' => ucfirst(strtolower(trim($request->apellido_paterno))),
                'apellido_materno' => ucfirst(strtolower(trim($request->apellido_materno))),
                'dni'              => trim($request->dni),
                'codigo_pais'      => trim($request->codigo_pais),
                'telefono'         => trim($request->telefono),
                'correo'           => strtolower(trim($request->correo)),
                'contraseña'       => Hash::make($request->contrasena),
                'activo'           => 1,
                'created_at'       => now(),
                'updated_at'       => now(),
            ]);

            return response()->json(['ok' => true]);

        } catch (\Exception $e) {
            return response()->json(['ok' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function crearTecnico(Request $request)
{
    $validator = Validator::make($request->all(), [
        'nombre'           => 'required|string|max:100',
        'apellido_paterno' => 'required|string|max:100',
        'apellido_materno' => 'required|string|max:100',
        'dni'              => 'required|string|size:8|unique:tecnico,dni',
        'correo'           => [
            'required', 'email', 'max:150', 'unique:tecnico,correo',
            function ($attribute, $value, $fail) {
                if (Cliente::where('correo', $value)->exists()) {
                    $fail('Este correo ya está registrado como cliente.');
                }
            },
        ],
        'contrasena'      => 'required|string|min:6',
        'codigo_tecnico'  => 'required|string|max:20|unique:tecnico,codigo_tecnico',
    ], [
        'nombre.required'           => 'El nombre es obligatorio.',
        'nombre.max'                => 'El nombre no debe exceder los 100 caracteres.',
        'apellido_paterno.required' => 'El apellido paterno es obligatorio.',
        'apellido_paterno.max'      => 'El apellido paterno no debe exceder los 100 caracteres.',
        'apellido_materno.required' => 'El apellido materno es obligatorio.',
        'apellido_materno.max'      => 'El apellido materno no debe exceder los 100 caracteres.',
        'dni.required'              => 'El DNI es obligatorio.',
        'dni.size'                  => 'El DNI debe tener exactamente 8 caracteres.',
        'dni.unique'                => 'El DNI ya pertenece a un técnico registrado.',
        'correo.required'           => 'El correo electrónico es obligatorio.',
        'correo.email'              => 'El formato del correo no es válido.',
        'correo.max'                => 'El correo electrónico no debe exceder los 150 caracteres.',
        'correo.unique'             => 'Este correo electrónico ya está en uso.',
        'codigo_tecnico.required'   => 'El código de técnico es obligatorio.',
        'codigo_tecnico.unique'     => 'El código de técnico ya está en uso.',
        'contrasena.required'         => 'La contraseña es obligatoria.',
        'contrasena.min'              => 'La contraseña debe tener un mínimo de 6 caracteres.',
        'contrasena.mixed_case'       => 'La contraseña debe contener al menos una letra mayúscula y una minúscula.',
        'contrasena.letters'          => 'La contraseña debe contener al menos una letra.',
        'contrasena.symbols'          => 'La contraseña debe contener al menos un símbolo.',
        'contrasena.numbers'          => 'La contraseña debe contener al menos un número.',
    ]);

    if ($validator->fails()) {
        return response()->json(['ok' => false, 'errors' => $validator->errors()], 422);
    }

    try {
        DB::table('tecnico')->insert([
            'codigo_tecnico'   => strtoupper(trim($request->codigo_tecnico)),
            'nombre'           => ucfirst(strtolower(trim($request->nombre))),
            'apellido_paterno' => ucfirst(strtolower(trim($request->apellido_paterno))),
            'apellido_materno' => ucfirst(strtolower(trim($request->apellido_materno))),
            'dni'              => trim($request->dni),
            'correo'           => strtolower(trim($request->correo)),
            'contraseña'       => Hash::make($request->contrasena),
            'id_cargo'         => 2,
            'activo'           => 1,
            'created_at'       => now(),
            'updated_at'       => now(),
        ]);

        $tecnicoObj = (object) [
            'nombre'           => ucfirst(strtolower(trim($request->nombre))),
            'apellido_paterno' => ucfirst(strtolower(trim($request->apellido_paterno))),
            'correo'           => strtolower(trim($request->correo)),
            'codigo_tecnico'   => strtoupper(trim($request->codigo_tecnico)),
            'tipo'             => 'tecnico',
        ];

        $emailSent = false;
        try {
            \Illuminate\Support\Facades\Mail::to($tecnicoObj->correo)
                ->send(new \App\Mail\CredencialesUsuario($tecnicoObj, $request->contrasena));
            $emailSent = true;
        } catch (\Exception $mailEx) {
            \Log::warning('No se pudo enviar el correo al técnico: ' . $mailEx->getMessage());
        }

        return response()->json([
            'ok'         => true,
            'message'    => 'Técnico registrado con éxito.',
            'email_sent' => $emailSent,
        ]);

    } catch (\Exception $e) {
        return response()->json(['ok' => false, 'message' => $e->getMessage()], 500);
    }
}
    public function asignarTecnico(Request $request, $id)
    {
        $request->validate([
            'id_tecnico' => 'required|exists:tecnico,id_tecnico',
        ]);

        // Obtener el estado PROGRAMADO
        $estadoProgramado = DB::table('estado_ticket')
            ->where('nombre_estado', 'PROGRAMADO')
            ->first();

        if (!$estadoProgramado) {
            return response()->json(['ok' => false, 'message' => 'Estado PROGRAMADO no encontrado.'], 500);
        }

        // Obtener ticket actual
        $ticket = DB::table('ticket')->where('id_ticket', $id)->first();

        if (!$ticket) {
            return response()->json(['ok' => false, 'message' => 'Ticket no encontrado.'], 404);
        }

        $update = [
            'id_tecnico_asignado' => $request->id_tecnico,
            'updated_at'          => now(),
        ];

        // Solo cambia a PROGRAMADO si estaba PENDIENTE
        if ($ticket->id_estado == DB::table('estado_ticket')->where('nombre_estado', 'PENDIENTE')->value('id_estado')) {
            $update['id_estado'] = $estadoProgramado->id_estado;
            $update['fecha_programado']   = now();
        }

        DB::table('ticket')->where('id_ticket', $id)->update($update);

        NotificacionService::asignacionTecnico((int) $id, (int) $request->id_tecnico);

        if (isset($update['id_estado'])) {
            NotificacionService::cambioEstadoUsuario((int) $id, (int) $update['id_estado'], (int) $ticket->id_estado);
        }

        $tecnico = DB::table('tecnico')->where('id_tecnico', $request->id_tecnico)->first();

        return response()->json([
            'ok'      => true,
            'message' => 'Técnico asignado correctamente.',
            'tecnico' => $tecnico->nombre . ' ' . $tecnico->apellido_paterno,
        ]);
    }


    public function misTickets()
    {
        if (session('tipo') !== 'admin' || !session('id')) {
            return redirect('/')->with('error', 'Acceso restringido.');
        }
     
        $idTecnico = session('id');
     
        $tickets = DB::table('ticket')
            ->join('tipo_ticket',   'ticket.id_tipo_ticket', '=', 'tipo_ticket.id_tipo_ticket')
            ->join('prioridad',     'ticket.id_prioridad',   '=', 'prioridad.id_prioridad')
            ->join('estado_ticket', 'ticket.id_estado',      '=', 'estado_ticket.id_estado')
            ->join('cliente',       'ticket.id_cliente',     '=', 'cliente.id_cliente')
            ->join('usuario as usu','ticket.id_usuario',     '=', 'usu.id_usuario')
            ->join('tecnico as tec','ticket.id_tecnico_asignado', '=', 'tec.id_tecnico')
            ->where('ticket.id_tecnico_asignado', $idTecnico)
            ->select(
                'ticket.*',
                'tipo_ticket.nombre              as tipo_ticket_nombre',
                'prioridad.nombre                as prioridad_nombre',
                'prioridad.color_hex             as prioridad_color',
                'estado_ticket.nombre_estado     as estado',
                'estado_ticket.color_hex         as estado_color',
                'cliente.razon_social',
                'cliente.ruc',
                DB::raw("CONCAT(usu.nombre,' ',usu.apellido_paterno,' ',usu.apellido_materno) as usuario_nombre"),
                'usu.codigo_usuario',
                DB::raw("CONCAT(COALESCE(usu.codigo_pais,''),' ',COALESCE(usu.telefono,'')) as usuario_telefono"),
                DB::raw("CONCAT(tec.nombre,' ',tec.apellido_paterno) as tecnico_nombre"),
                'tec.codigo_tecnico'
            )
            ->orderByDesc('ticket.created_at')
            ->get();
     
        $ticketIds = $tickets->pluck('id_ticket')->toArray();
     
        $evidencias  = DB::table('evidencia')
            ->whereIn('id_ticket', $ticketIds)->get()->groupBy('id_ticket');
        $comentarios = DB::table('comentario')
            ->whereIn('id_ticket', $ticketIds)->orderBy('created_at')->get()->groupBy('id_ticket');
        $reportes    = DB::table('reporte_tecnico')
            ->whereIn('id_ticket', $ticketIds)->get()->groupBy('id_ticket');
     
        $tickets->each(function ($t) use ($evidencias, $comentarios, $reportes) {
            $t->evidencias  = $evidencias->get($t->id_ticket,  collect());
            $t->comentarios = $comentarios->get($t->id_ticket, collect());
            $t->reportes    = $reportes->get($t->id_ticket,    collect());
        });
     
        $resumen = [
            'total'      => $tickets->count(),
            'programado' => $tickets->where('estado', 'PROGRAMADO')->count(),
            'en_proceso' => $tickets->where('estado', 'EN PROCESO')->count(),
            'cerrado'    => $tickets->where('estado', 'CERRADO')->count(),
            'cancelado'  => $tickets->where('estado', 'CANCELADO')->count(),
        ];
     
        return view('admin.mistickets', compact('tickets', 'resumen'));
    }

    public function datos()
    {
        $tecnico = Tecnico::find(session('id'));

        session(['nombre' => $tecnico->nombre]);
        session(['correo' => $tecnico->correo]);

        return view('admin.datos', compact('tecnico'));
    }

    public function update(Request $request)
    {
        $tecnico = Tecnico::find(session('id'));
        if (!$tecnico) {
            return back()->with('error', 'No se encontró la sesión del administrador.');
        }

        // ✅ Validación estricta: SOLO letras, espacios, guiones y apóstrofes
        $validator = Validator::make($request->all(), [
            'nombre'             => ['required', 'string', 'max:100', 'regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s\'-]+$/'],
            'apellido_paterno'   => ['required', 'string', 'max:100', 'regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s\'-]+$/'],
            'apellido_materno'   => ['nullable', 'string', 'max:100', 'regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s\'-]+$/'],
            'correo'             => 'required|email|max:100',
            'telefono'           => 'required|digits_between:7,15',
            'codigo_pais'        => ['required', 'regex:/^\+?\d{1,4}$/', 'max:10'],
        ], [
            'nombre.regex'                => 'El nombre solo debe contener letras y espacios.',
            'apellido_paterno.regex'      => 'El apellido paterno solo debe contener letras y espacios.',
            'apellido_materno.regex'      => 'El apellido materno solo debe contener letras y espacios.',
            'nombre.max'                  => 'El nombre no puede superar los 100 caracteres.',
            'apellido_paterno.max'        => 'El apellido paterno no puede superar los 100 caracteres.',
            'apellido_materno.max'        => 'El apellido materno no puede superar los 100 caracteres.',
            'telefono.required'           => 'El teléfono es obligatorio.',
            'telefono.digits_between'     => 'El teléfono debe tener entre 7 y 15 dígitos numéricos.',
            'codigo_pais.required'        => 'El código de país es obligatorio.',
            'codigo_pais.regex'           => 'El código de país debe tener formato válido (ej: +51).',
        ]);

        // ✅ Si falla: NO usamos ->withInput() para que el formulario NO guarde los datos inválidos
        if ($validator->fails()) {
            return back()->with('error', $validator->errors()->first());
        }

        // ✅ Si pasa: actualizamos y guardamos
        $tecnico->nombre           = ucfirst(strtolower($request->nombre));
        $tecnico->apellido_paterno = ucfirst(strtolower($request->apellido_paterno));
        $tecnico->apellido_materno = ucfirst(strtolower($request->apellido_materno ?? ''));
        $tecnico->correo           = strtolower($request->correo);
        $tecnico->codigo_pais      = $request->codigo_pais ?? '+51';
        $tecnico->telefono         = $request->telefono;
        
        $tecnico->save();
        session(['nombre' => $tecnico->nombre]);

        return back()->with('success', 'Datos actualizados correctamente.');
    }

    public function asignarticket()
    {
        // 🔐 Seguridad primero
        if (session('tipo') !== 'admin' || !session('id')) {
            return redirect('/')->with('error', 'Acceso restringido.');
        }

        // 👥 Clientes
        $clientes = Cliente::all();

        // 🧑‍🔧 Técnicos activos
        $tecnicos = Tecnico::where('activo', 1)
            ->orderBy('nombre')
            ->get();

        // 🎫 Tickets con joins
        $tickets = DB::table('ticket')
            ->join('tipo_ticket', 'ticket.id_tipo_ticket', '=', 'tipo_ticket.id_tipo_ticket')
            ->join('prioridad', 'ticket.id_prioridad', '=', 'prioridad.id_prioridad')
            ->join('estado_ticket', 'ticket.id_estado', '=', 'estado_ticket.id_estado')
            ->join('cliente', 'ticket.id_cliente', '=', 'cliente.id_cliente')
            ->join('usuario as usu', 'ticket.id_usuario', '=', 'usu.id_usuario')
            ->leftJoin('tecnico as tec', 'ticket.id_tecnico_asignado', '=', 'tec.id_tecnico')
            ->select(
                'ticket.*',
                'ticket.id_usuario', // importante
                'tipo_ticket.nombre as tipo_ticket_nombre',
                'prioridad.nombre as prioridad_nombre',
                'prioridad.color_hex as prioridad_color',
                'estado_ticket.nombre_estado as estado',
                'estado_ticket.color_hex as estado_color',
                'cliente.razon_social',
                DB::raw("CONCAT(usu.nombre,' ',usu.apellido_paterno) as usuario_nombre"),
                DB::raw("CONCAT(COALESCE(tec.nombre,''),' ',COALESCE(tec.apellido_paterno,'')) as tecnico_nombre")
            )
            ->orderByDesc('ticket.created_at')
            ->get();

        // 📊 RESUMEN DE TODOS LOS ESTADOS (INCLUYE PROGRAMADO)
        $resumen = [
            'total' => $tickets->count(),

            'pendiente' => $tickets->where('estado', 'PENDIENTE')->count(),
            'programado' => $tickets->where('estado', 'PROGRAMADO')->count(),
            'en_proceso' => $tickets->where('estado', 'EN PROCESO')->count(),
            'cerrado' => $tickets->where('estado', 'CERRADO')->count(),
            'cancelado' => $tickets->where('estado', 'CANCELADO')->count(),
            'total_usuarios' => DB::table('usuario')->count(),
        ];

        return view('admin.asignarticket', compact(
            'tickets',
            'tecnicos',
            'clientes',
            'resumen'
        ));
    }

    // ── GET detalle ───────────────────────────────────────────────────
    public function detalleCliente($id)
    {
        $c = DB::table('cliente')->where('id_cliente', $id)->first();
        if (!$c) return response()->json(['message' => 'No encontrado'], 404);
        return response()->json($c);
    }

    public function detalleUsuario($id)
    {
        $u = DB::table('usuario')->where('id_usuario', $id)->first();
        if (!$u) return response()->json(['message' => 'No encontrado'], 404);
        return response()->json($u);
    }

    public function detalleTecnico($id)
    {
        $t = DB::table('tecnico')->where('id_tecnico', $id)->first();
        if (!$t) return response()->json(['message' => 'No encontrado'], 404);
        return response()->json($t);
    }

    // ── POST editar ───────────────────────────────────────────────────
    public function editarCliente(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'razon_social' => 'required|string|max:200',
            'sedes'        => 'nullable|string|max:200',
            'rubro'        => 'nullable|string|max:100',
        ], [
            'razon_social.required' => 'La razón social es obligatoria.'
        ]);
        if ($validator->fails()) {
            return response()->json(['ok' => false, 'errors' => $validator->errors()], 422);
        }
        DB::table('cliente')->where('id_cliente', $id)->update([
            'razon_social' => $request->razon_social,
            'sedes'        => $request->sedes,
            'rubro'        => $request->rubro,
            'updated_at'   => now(),
        ]);
        return response()->json(['ok' => true]);
    }
    
    public function toggleEstado(Request $request, $tipo, $id) {
        $tablas = ['cliente'=>'cliente','usuario'=>'usuario','tecnico'=>'tecnico'];
        $llaves = ['cliente'=>'id_cliente','usuario'=>'id_usuario','tecnico'=>'id_tecnico'];
        
        if (!isset($tablas[$tipo])) return response()->json(['ok'=>false], 400);

        $activo = (int) $request->activo;

        if ($tipo === 'tecnico' && !$activo && $this->tecnicoEsAdminProtegido((int) $id)) {
            return response()->json([
                'ok'      => false,
                'message' => 'No se puede desactivar la cuenta del administrador principal.',
            ], 403);
        }
        
        DB::table($tablas[$tipo])->where($llaves[$tipo], $id)
            ->update(['activo' => $activo, 'updated_at'=>now()]);
        
        return response()->json(['ok'=>true]);
    }
    
    public function editarUsuario(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nombre'           => 'required|string|max:100',
            'apellido_paterno' => 'required|string|max:100',
            'apellido_materno' => 'required|string|max:100',
            'telefono'         => 'required|string|max:20',
        ], [
            'nombre.required'           => 'El nombre es obligatorio.',
            'apellido_paterno.required' => 'El apellido paterno es obligatorio.',
            'apellido_materno.required' => 'El apellido materno es obligatorio.',
            'telefono.required'         => 'El teléfono es obligatorio.',
        ]);
        if ($validator->fails()) {
            return response()->json(['ok' => false, 'errors' => $validator->errors()], 422);
        }
        DB::table('usuario')->where('id_usuario', $id)->update([
            'nombre'           => ucfirst(strtolower($request->nombre)),
            'apellido_paterno' => ucfirst(strtolower($request->apellido_paterno)),
            'apellido_materno' => ucfirst(strtolower($request->apellido_materno)),
            'telefono'         => $request->telefono,
            'updated_at'       => now(),
        ]);
        return response()->json(['ok' => true]);
    }

    public function editarTecnico(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nombre'           => 'required|string|max:100',
            'apellido_paterno' => 'required|string|max:100',
            'apellido_materno' => 'required|string|max:100',
        ], [
            'nombre.required'           => 'El nombre es obligatorio.',
            'apellido_paterno.required' => 'El apellido paterno es obligatorio.',
            'apellido_materno.required' => 'El apellido materno es obligatorio.',
        ]);
        if ($validator->fails()) {
            return response()->json(['ok' => false, 'errors' => $validator->errors()], 422);
        }
        DB::table('tecnico')->where('id_tecnico', $id)->update([
            'nombre'           => ucfirst(strtolower($request->nombre)),
            'apellido_paterno' => ucfirst(strtolower($request->apellido_paterno)),
            'apellido_materno' => ucfirst(strtolower($request->apellido_materno)),
            'updated_at'       => now(),
        ]);
        return response()->json(['ok' => true]);
    }

    public function detalleTicket($id)
{
    $ticket = DB::table('ticket')
        ->join('tipo_ticket',   'ticket.id_tipo_ticket',           '=', 'tipo_ticket.id_tipo_ticket')
        ->join('prioridad',     'ticket.id_prioridad',             '=', 'prioridad.id_prioridad')
        ->join('estado_ticket', 'ticket.id_estado',                '=', 'estado_ticket.id_estado')
        ->join('cliente',       'ticket.id_cliente',               '=', 'cliente.id_cliente')
        ->join('usuario as usu','ticket.id_usuario',               '=', 'usu.id_usuario')
        ->leftJoin('tecnico as tec','ticket.id_tecnico_asignado',  '=', 'tec.id_tecnico')
        ->where('ticket.id_ticket', $id)
        ->select(
            'ticket.*',
            'tipo_ticket.nombre              as tipo_ticket_nombre',
            'prioridad.nombre                as prioridad_nombre',
            'prioridad.color_hex             as prioridad_color',
            'estado_ticket.nombre_estado     as estado',
            'estado_ticket.color_hex         as estado_color',
            'cliente.razon_social', 
            'cliente.ruc',
            DB::raw("CONCAT(usu.nombre, ' ', usu.apellido_paterno, ' ', usu.apellido_materno) as usuario_nombre"),
            'usu.codigo_usuario',
            DB::raw("CONCAT(COALESCE(usu.codigo_pais,''), ' ', COALESCE(usu.telefono,'')) as usuario_telefono"),
            DB::raw("CONCAT(COALESCE(tec.nombre,''), ' ', COALESCE(tec.apellido_paterno,'')) as tecnico_nombre"),
            'tec.codigo_tecnico as tecnico_codigo'  
        )
        ->first();

    if (!$ticket) {
        return request()->wantsJson() || request()->ajax() 
            ? response()->json(['message' => 'No encontrado'], 404) 
            : abort(404);
    }

    $ticket->evidencias  = DB::table('evidencia')->where('id_ticket', $id)->get();
    $ticket->comentarios = DB::table('comentario')->where('id_ticket', $id)->orderBy('created_at')->get();
    $ticket->reportes    = DB::table('reporte_tecnico')->where('id_ticket', $id)->get();

    // ✅ SI ES AJAX/JSON → Devuelve datos para el modal
    if (request()->wantsJson() || request()->ajax()) {
        return response()->json($ticket);
    }

    // ✅ SI ES NAVEGACIÓN NORMAL → Devuelve la vista completa
    return view('admin.tickets.detalle', compact('ticket'));
}

    public function cancelarTicket(Request $request, $id)
    {
        if (session('tipo') !== 'admin' || !session('id')) {
            return response()->json(['ok' => false, 'message' => 'No autenticado.'], 401);
        }

        $ticket = DB::table('ticket')->where('id_ticket', $id)->first();
        if (!$ticket) {
            return response()->json(['ok' => false, 'message' => 'Ticket no encontrado.'], 404);
        }

        $estadoProgramado = DB::table('estado_ticket')
            ->where('nombre_estado', 'PROGRAMADO')->value('id_estado');

        if ($ticket->id_estado !== $estadoProgramado) {
            return response()->json(['ok' => false, 'message' => 'Solo se pueden cancelar tickets en estado PROGRAMADO.'], 422);
        }

        $estadoCancelado = DB::table('estado_ticket')
            ->where('nombre_estado', 'CANCELADO')->value('id_estado');

        if (!$estadoCancelado) {
            return response()->json(['ok' => false, 'message' => 'Estado CANCELADO no encontrado en la base de datos.'], 500);
        }

        $ticket = DB::table('ticket')->where('id_ticket', $id)->first();

        DB::table('ticket')->where('id_ticket', $id)->update([
            'id_estado'  => $estadoCancelado,
            'updated_at' => now(),
        ]);

        NotificacionService::cambioEstadoUsuario((int) $id, (int) $estadoCancelado, (int) $ticket->id_estado);

        return response()->json(['ok' => true]);
    }

    public function editarCamposTicket(Request $request, $id)
    {
        if (session('tipo') !== 'admin' || !session('id')) {
            return response()->json(['ok' => false, 'message' => 'No autenticado.'], 401);
        }
     
        $validator = Validator::make($request->all(), [
            'tipo_equipo'  => 'nullable|string|max:100',
            'marca'        => 'nullable|string|max:100',
            'modelo'       => 'nullable|string|max:100',
            'serie_serial' => 'nullable|string|max:100',
            'asunto'       => 'nullable|string|max:255',
            'problema'     => 'nullable|string',
        ]);
     
        if ($validator->fails()) {
            return response()->json(['ok' => false, 'errors' => $validator->errors()], 422);
        }
     
        $ticket = DB::table('ticket')->where('id_ticket', $id)->first();
        if (!$ticket) {
            return response()->json(['ok' => false, 'message' => 'Ticket no encontrado.'], 404);
        }
     
        $estadoEnProceso = DB::table('estado_ticket')
            ->where('nombre_estado', 'EN PROCESO')
            ->value('id_estado');
     
        $estadoActual = DB::table('estado_ticket')
            ->where('id_estado', $ticket->id_estado)
            ->value('nombre_estado');
     
        $update = [
            'tipo_equipo'  => $request->tipo_equipo  ?: $ticket->tipo_equipo,
            'marca'        => $request->marca         ?: $ticket->marca,
            'modelo'       => $request->modelo        ?: $ticket->modelo,
            'serie_serial' => $request->serie_serial  ?: $ticket->serie_serial,
            'asunto'       => $request->asunto        ?: $ticket->asunto,
            'problema'     => $request->problema      ?: $ticket->problema,
            'updated_at'   => now(),
        ];
     
        if (in_array($estadoActual, ['PENDIENTE', 'PROGRAMADO'])) {
            $update['id_estado']        = $estadoEnProceso;
            $update['fecha_en_proceso'] = now();
        }
     
        DB::table('ticket')->where('id_ticket', $id)->update($update);

        if (isset($update['id_estado'])) {
            NotificacionService::cambioEstadoUsuario((int) $id, (int) $update['id_estado'], (int) $ticket->id_estado);
        }
     
        return response()->json(['ok' => true]);
    }
     
    /**
     * POST /admin/ticket/{id}/comentario
     * Agrega un comentario al ticket y lo pasa a EN PROCESO.
     */
    public function agregarComentario(Request $request, $id)
    {
        if (session('tipo') !== 'admin' || !session('id')) {
            return response()->json(['ok' => false, 'message' => 'No autenticado.'], 401);
        }
     
        $validator = Validator::make($request->all(), [
            'comentario' => 'required|string|max:2000',
        ], [
            'comentario.required' => 'El comentario no puede estar vacío.'
        ]);
     
        if ($validator->fails()) {
            return response()->json(['ok' => false, 'errors' => $validator->errors()], 422);
        }
     
        $ticket = DB::table('ticket')->where('id_ticket', $id)->first();
        if (!$ticket) {
            return response()->json(['ok' => false, 'message' => 'Ticket no encontrado.'], 404);
        }
     
        DB::table('comentario')->insert([
            'id_ticket'  => $id,
            'id_tecnico' => session('id'),
            'comentario' => $request->comentario,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
     
        $estadoActual = DB::table('estado_ticket')
            ->where('id_estado', $ticket->id_estado)
            ->value('nombre_estado');
     
        if (in_array($estadoActual, ['PENDIENTE', 'PROGRAMADO'])) {
            $estadoEnProceso = DB::table('estado_ticket')
                ->where('nombre_estado', 'EN PROCESO')
                ->value('id_estado');
     
            DB::table('ticket')->where('id_ticket', $id)->update([
                'id_estado'        => $estadoEnProceso,
                'fecha_en_proceso' => now(),
                'updated_at'       => now(),
            ]);

            NotificacionService::cambioEstadoUsuario((int) $id, (int) $estadoEnProceso, (int) $ticket->id_estado);
        }
     
        return response()->json(['ok' => true]);
    }
     
    /**
     * POST /admin/ticket/{id}/reporte
     * Sube el reporte técnico (1 solo archivo: imagen o PDF).
     * Cambia el ticket a EN PROCESO.
     */
    public function subirReporte(Request $request, $id)
    {
        try {
            if (session('tipo') !== 'admin' || !session('id')) {
                return response()->json(['ok' => false, 'message' => 'No autenticado.'], 401);
            }

            $validator = Validator::make($request->all(), [
                'archivo' => 'required|file|mimes:jpg,jpeg,png,gif,webp,pdf,doc,docx|max:5120',
            ], [
                'archivo.required' => 'El archivo del reporte es obligatorio.',
                'archivo.mimes'    => 'Solo se permiten imágenes (JPG, PNG, GIF, WEBP), PDF, DOC o DOCX.',
                'archivo.max'      => 'El tamaño máximo permitido para el archivo es de 5MB.',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'ok' => false,
                    'errors' => $validator->errors()
                ], 422);
            }

            $ticket = DB::table('ticket')->where('id_ticket', $id)->first();
            if (!$ticket) {
                return response()->json(['ok' => false, 'message' => 'Ticket no encontrado.'], 404);
            }

            $yaExiste = DB::table('reporte_tecnico')->where('id_ticket', $id)->exists();
            if ($yaExiste) {
                return response()->json([
                    'ok' => false,
                    'message' => 'Ya existe un reporte para este ticket.'
                ], 422);
            }

            $file = $request->file('archivo');

            $nombreOriginal = $file->getClientOriginalName();
            $extension      = $file->getClientOriginalExtension();

            $nombreBase = pathinfo($nombreOriginal, PATHINFO_FILENAME);
            $nombreBase = preg_replace('/[^a-zA-Z0-9_-]/', '_', $nombreBase);

            $nombreFinal = $nombreBase . '_' . time() . '.' . $extension;

            $carpeta = 'tecnico/Reportes/'
                . session('id') . '-TICKET-' . $id;

            $ruta = $file->storeAs($carpeta, $nombreFinal, 'public');

            DB::table('reporte_tecnico')->insert([
                'id_ticket'       => $id,
                'id_tecnico'      => session('id'),
                'archivo_reporte' => $ruta,
                'nombre_original' => $nombreOriginal,
                'created_at'      => now(),
                'updated_at'      => now(),
            ]);

            $estadoActual = DB::table('estado_ticket')
                ->where('id_estado', $ticket->id_estado)
                ->value('nombre_estado');

            if (in_array($estadoActual, ['PENDIENTE', 'PROGRAMADO'])) {
                $estadoEnProceso = DB::table('estado_ticket')
                    ->where('nombre_estado', 'EN PROCESO')
                    ->value('id_estado');

                DB::table('ticket')->where('id_ticket', $id)->update([
                    'id_estado'        => $estadoEnProceso,
                    'fecha_en_proceso' => now(),
                    'updated_at'       => now(),
                ]);

                NotificacionService::cambioEstadoUsuario((int) $id, (int) $estadoEnProceso, (int) $ticket->id_estado);
            }

            return response()->json(['ok' => true]);

        } catch (\Exception $e) {
            return response()->json([
                'ok' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
     
    /**
     * POST /admin/ticket/{id}/cerrar
     * Cierra el ticket (requiere reporte técnico subido).
     */
    public function cerrarTicket(Request $request, $id)
    {
        if (session('tipo') !== 'admin' || !session('id')) {
            return response()->json(['ok' => false, 'message' => 'No autenticado.'], 401);
        }
     
        $ticket = DB::table('ticket')->where('id_ticket', $id)->first();
        if (!$ticket) {
            return response()->json(['ok' => false, 'message' => 'Ticket no encontrado.'], 404);
        }
     
        $tieneReporte = DB::table('reporte_tecnico')->where('id_ticket', $id)->exists();
        if (!$tieneReporte) {
            return response()->json([
                'ok'      => false,
                'message' => 'No puedes cerrar el ticket sin subir el reporte técnico.'
            ], 422);
        }
     
        $estadoCerrado = DB::table('estado_ticket')
            ->where('nombre_estado', 'CERRADO')
            ->value('id_estado');
     
        DB::table('ticket')->where('id_ticket', $id)->update([
            'id_estado'      => $estadoCerrado,
            'fecha_resuelto' => now(),
            'updated_at'     => now(),
        ]);

        NotificacionService::cambioEstadoUsuario((int) $id, (int) $estadoCerrado, (int) $ticket->id_estado);
     
        DB::table('reporte_tecnico')
            ->where('id_ticket', $id)
            ->update(['updated_at' => now()]);
     
        return response()->json(['ok' => true]);
    }
    
    public function contactos()
    {
        if (session('tipo') !== 'admin' || !session('id')) {
            return redirect('/')->with('error', 'Acceso restringido.');
        }

        $clientes = Cliente::orderBy('razon_social')->get();
        $usuarios = Usuario::with('cliente')->orderBy('nombre')->get();

        return view('admin.contactos', compact('clientes', 'usuarios'));
    }

public function clientes()
{
    if (session('tipo') !== 'admin' || !session('id')) {
        return redirect('/')->with('error', 'Acceso restringido.');
    }

    // ═══════════════════════════════════════════════════════
    // ✅ CÓDIGO REAL (igual que dashboard, para compatibilidad)
    // ═══════════════════════════════════════════════════════
    
    // Tickets con toda la info
    $tickets = DB::table('ticket')
        ->join('tipo_ticket',   'ticket.id_tipo_ticket',          '=', 'tipo_ticket.id_tipo_ticket')
        ->join('prioridad',     'ticket.id_prioridad',            '=', 'prioridad.id_prioridad')
        ->join('estado_ticket', 'ticket.id_estado',               '=', 'estado_ticket.id_estado')
        ->join('cliente',       'ticket.id_cliente',              '=', 'cliente.id_cliente')
        ->join('usuario as usu','ticket.id_usuario',              '=', 'usu.id_usuario')
        ->leftJoin('tecnico as tec', 'ticket.id_tecnico_asignado','=', 'tec.id_tecnico')
        ->select(
            'ticket.*',
            'tipo_ticket.nombre              as tipo_ticket_nombre',
            'prioridad.nombre                as prioridad_nombre',
            'prioridad.color_hex             as prioridad_color',
            'estado_ticket.nombre_estado     as estado',
            'cliente.razon_social',
            'cliente.ruc',
            DB::raw("CONCAT(usu.nombre,' ',usu.apellido_paterno,' ',usu.apellido_materno) as usuario_nombre"),
            'usu.codigo_usuario',
            DB::raw("CONCAT(COALESCE(usu.codigo_pais,''),' ',COALESCE(usu.telefono,'')) as usuario_telefono"),
            DB::raw("(COALESCE(tec.nombre,'')||' '||COALESCE(tec.apellido_paterno,'')||' '||COALESCE(tec.apellido_materno,'')) as tecnico_nombre"),
            'tec.codigo_tecnico              as tecnico_codigo'
        )
        ->orderByDesc('ticket.created_at')
        ->get();

    $ticketIds = $tickets->pluck('id_ticket')->toArray();
    $evidencias  = DB::table('evidencia')->whereIn('id_ticket', $ticketIds)->get()->groupBy('id_ticket');
    $comentarios = DB::table('comentario')->whereIn('id_ticket', $ticketIds)->orderBy('created_at')->get()->groupBy('id_ticket');
    $reportes    = DB::table('reporte_tecnico')->whereIn('id_ticket', $ticketIds)->get()->groupBy('id_ticket');

    $tickets->each(function ($ticket) use ($evidencias, $comentarios, $reportes) {
        $ticket->evidencias  = $evidencias->get($ticket->id_ticket, collect());
        $ticket->comentarios = $comentarios->get($ticket->id_ticket, collect());
        $ticket->reportes    = $reportes->get($ticket->id_ticket, collect());
    });

    // Técnicos disponibles (con cargo para identificar administradores protegidos)
    $tecnicos = Tecnico::with('cargo')->orderBy('nombre')->get();
    
    // Usuarios
    $usuarios_lista = Usuario::orderBy('nombre')->get();
    
    // Clientes
    $clientes = Cliente::orderBy('razon_social')->get();

    // Contadores resumen
    $resumen = [
        'total'      => $tickets->count(),
        'pendiente'  => $tickets->where('estado', 'PENDIENTE')->count(),
        'programado' => $tickets->where('estado', 'PROGRAMADO')->count(),
        'en_proceso' => $tickets->where('estado', 'EN PROCESO')->count(),
        'cerrado'    => $tickets->where('estado', 'CERRADO')->count(),
        'cancelado'  => $tickets->where('estado', 'CANCELADO')->count(),
        'total_usuarios' => $usuarios_lista->count(),
    ];

    // ═══════════════════════════════════════════════════════
    // ✅ RETORNO PARA LA VISTA DE CLIENTES
    // ═══════════════════════════════════════════════════════
    return view('admin.clientes', compact(
        'tickets', 'tecnicos', 'usuarios_lista', 'clientes', 'resumen'
    ));
}
    public function reportePdf(Request $request)
{
    // ── Clientes filtrados ──
    $clientesQuery = Cliente::orderBy('razon_social');
    if ($request->filled('cliente_id')) {
        $clientesQuery->where('id_cliente', $request->cliente_id);
    }
    $clientesFiltrados = $clientesQuery->get();

    $desde = $request->desde . ' 00:00:00';
    $hasta = $request->hasta . ' 23:59:59';

    // ── Usuarios elegibles ──
    $usuarioIds = Usuario::whereIn('id_cliente', $clientesFiltrados->pluck('id_cliente'))
                         ->pluck('id_usuario')->toArray();

    if ($request->tipo === 'individual' && $request->filled('usuario_id')) {
        $usuarioIds = [$request->usuario_id];
    }

    // ── Tickets ──
    $tickets = DB::table('ticket')
        ->join('tipo_ticket',   'ticket.id_tipo_ticket', '=', 'tipo_ticket.id_tipo_ticket')
        ->join('prioridad',     'ticket.id_prioridad',   '=', 'prioridad.id_prioridad')
        ->join('estado_ticket', 'ticket.id_estado',      '=', 'estado_ticket.id_estado')
        ->join('cliente',       'ticket.id_cliente',     '=', 'cliente.id_cliente')
        ->join('usuario as usu','ticket.id_usuario',     '=', 'usu.id_usuario')
        ->leftJoin('tecnico as tec','ticket.id_tecnico_asignado', '=', 'tec.id_tecnico')
        ->select(
            'ticket.id_ticket',
            'ticket.codigo_ticket',
            'ticket.id_cliente',
            'ticket.id_usuario',
            'ticket.id_tecnico_asignado',
            'ticket.id_tipo_ticket',
            'ticket.id_prioridad',
            'ticket.id_estado',
            'ticket.tipo_equipo',
            'ticket.marca',
            'ticket.modelo',
            'ticket.serie_serial',
            'ticket.asunto',
            'ticket.problema',
            'ticket.fecha_programado',
            'ticket.fecha_en_proceso',
            'ticket.fecha_resuelto',
            'ticket.created_at',
            'ticket.updated_at',
            'tipo_ticket.nombre           as tipo_ticket_nombre',
            'prioridad.nombre             as prioridad_nombre',
            'prioridad.color_hex          as prioridad_color',
            'estado_ticket.nombre_estado  as estado',
            'cliente.razon_social',
            'cliente.ruc',
            'cliente.id_cliente           as cliente_id',
            DB::raw("CONCAT(usu.nombre,' ',usu.apellido_paterno) as usuario_nombre"),
            'usu.codigo_usuario',
            'usu.correo                   as usuario_correo',
            'usu.dni                      as usuario_dni',
            DB::raw("COALESCE(CONCAT(tec.nombre,' ',tec.apellido_paterno), 'Sin asignar') as tecnico_nombre")
        )
        ->whereIn('ticket.id_usuario', $usuarioIds)
        ->whereBetween('ticket.created_at', [$desde, $hasta])
        ->orderBy('cliente.razon_social')
        ->orderByDesc('ticket.created_at')
        ->get();

    // ── Stats globales ──
        $stats = [
            'total'       => $tickets->count(),
            'cerrados'    => $tickets->where('estado', 'CERRADO')->count(),
            'programados' => $tickets->where('estado', 'PROGRAMADO')->count(),
            'en_proceso'  => $tickets->where('estado', 'EN PROCESO')->count(),
            'pendientes'  => $tickets->where('estado', 'PENDIENTE')->count(),
            'cancelados'  => $tickets->where('estado', 'CANCELADO')->count(),
        ];

    // ── Agrupado: por cliente → por usuario ──
        $porCliente = $tickets->groupBy('cliente_id')->map(function ($tc) {
            return [
                'razon_social' => $tc->first()->razon_social,
                'ruc'          => $tc->first()->ruc,
                'tickets'      => $tc->count(),
                'cerrados'     => $tc->where('estado', 'CERRADO')->count(),
                'programados'  => $tc->where('estado', 'PROGRAMADO')->count(),
                'en_proceso'   => $tc->where('estado', 'EN PROCESO')->count(),
                'pendientes'   => $tc->where('estado', 'PENDIENTE')->count(),
                'cancelados'   => $tc->where('estado', 'CANCELADO')->count(),
                'por_usuario'  => $tc->groupBy('usuario_nombre'),
            ];
        });

    // ── Variables que la vista necesita ──
    // $porUsuario = resumen global de usuarios (para la sección "Detalle por Usuario")
    $porUsuario = $tickets->groupBy('usuario_nombre');

    // $usuarios = colección de usuarios (para el count del bloque info)
    $usuarios = Usuario::whereIn('id_cliente', $clientesFiltrados->pluck('id_cliente'))->get();

    // $cliente = objeto para el bloque header (si es reporte de 1 cliente usamos ese,
    //            si son todos usamos uno ficticio)
    if ($request->filled('cliente_id') && $clientesFiltrados->count() === 1) {
        $cliente = $clientesFiltrados->first();
    } else {
        // Objeto genérico para el header cuando son TODOS los clientes
        $cliente = (object)[
            'razon_social' => 'TODOS LOS CLIENTES',
            'ruc'          => '—',
            'correo'       => '—',
            'rubro'        => '—',
            'sedes'        => '—',
        ];
    }

    $pdf = Pdf::loadView('admin.reporte-pdf', compact(
        'clientesFiltrados', 'tickets', 'stats',
        'porCliente', 'porUsuario', 'usuarios', 'cliente', 'request'
    ))->setPaper('a4', 'portrait');

    $sufijo  = $request->filled('cliente_id') ? 'cliente_' . $request->cliente_id : 'todos';
    $archivo = 'reporte_admin_' . $sufijo . '_' . $request->desde . '_' . $request->hasta . '.pdf';

    return $pdf->download($archivo);
}
}
