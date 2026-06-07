<?php

namespace App\Http\Controllers;

use App\Services\NotificacionService;
use Illuminate\Http\Request;

class NotificacionController extends Controller
{
    public function marcarLeida(Request $request, int $id)
    {
        $ok = NotificacionService::marcarLeida($id);

        return response()->json(['ok' => $ok]);
    }
}
