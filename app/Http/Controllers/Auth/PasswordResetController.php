<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Models\Tecnico;
use App\Models\Usuario;
use App\Models\Cliente;

class PasswordResetController extends Controller
{
    /**
     * Envía el enlace de recuperación al correo.
     */
    public function sendResetLink(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $email = strtolower(trim($request->email));

        // Buscar en las 3 tablas
        $existe = Usuario::where('correo', $email)->exists()
                || Tecnico::where('correo', $email)->exists()
                || Cliente::where('correo', $email)->exists();

        // Siempre responder OK por seguridad (no revelar si existe o no)
        if (!$existe) {
            return response()->json([
                'status' => 'sent',
                'message' => 'Si el correo está registrado, recibirás un enlace en breve.'
            ]);
        }

        // Generar token único
        $token = Str::random(64);

        // Guardar en tabla password_resets (o la propia si existe)
        DB::table('password_resets')->updateOrInsert(
            ['email' => $email],
            [
                'email'      => $email,
                'token'      => Hash::make($token),
                'created_at' => Carbon::now(),
            ]
        );

        // Enviar correo
        $resetUrl = url('/password/reset/' . $token . '?email=' . urlencode($email));

        try {
            Mail::send([], [], function ($message) use ($email, $resetUrl) {
                $message->to($email)
                    ->subject('Recuperación de contraseña — JHARDSYSTEX')
                    ->html("
                        <div style='font-family:Segoe UI,sans-serif;max-width:520px;margin:0 auto;background:#fff;border-radius:16px;overflow:hidden;border:1px solid #e2e8f0;'>
                            <div style='background:#0d1f3c;padding:28px 32px;text-align:center;'>
                                <h1 style='color:#fff;margin:0;font-size:20px;'>JHARDSYSTEX</h1>
                                <p style='color:#7a92b4;font-size:12px;margin:6px 0 0;'>Recuperación de contraseña</p>
                            </div>
                            <div style='padding:28px 32px;'>
                                <p style='color:#1a202c;font-size:15px;'>Hemos recibido una solicitud para restablecer tu contraseña.</p>
                                <p style='color:#4a5568;font-size:14px;'>Haz clic en el botón para crear una nueva contraseña. Este enlace expirará en <strong>30 minutos</strong>.</p>
                                <div style='text-align:center;margin:28px 0;'>
                                    <a href='{$resetUrl}' style='background:#2b7fff;color:#fff;padding:14px 32px;border-radius:10px;text-decoration:none;font-weight:700;font-size:14px;display:inline-block;'>
                                        Restablecer contraseña
                                    </a>
                                </div>
                                <p style='color:#94a3b8;font-size:12px;'>Si no solicitaste esto, ignora este correo.</p>
                            </div>
                            <div style='background:#f8fafc;padding:16px 32px;text-align:center;font-size:11px;color:#94a3b8;'>
                                © " . date('Y') . " JHARDSYSTEX · Documento confidencial
                            </div>
                        </div>
                    ");
            });
        } catch (\Exception $e) {
            \Log::warning('No se pudo enviar correo de recuperación: ' . $e->getMessage());
        }

        return response()->json([
            'status'  => 'sent',
            'message' => 'Si el correo está registrado, recibirás un enlace en breve.'
        ]);
    }

    /**
     * Muestra el formulario para ingresar la nueva contraseña.
     */
    public function showResetForm(Request $request, $token)
    {
        $email = $request->query('email', '');
        return view('auth.reset-password', compact('token', 'email'));
    }

    /**
     * Procesa el cambio de contraseña.
     */
    public function reset(Request $request)
    {
        $request->validate([
            'token'    => 'required',
            'email'    => 'required|email',
            'password' => 'required|min:6|confirmed',
        ], [
            'password.required'  => 'La contraseña es obligatoria.',
            'password.min'       => 'La contraseña debe tener al menos 6 caracteres.',
            'password.confirmed' => 'Las contraseñas no coinciden.',
        ]);

        $email = strtolower(trim($request->email));

        // Verificar token
        $record = DB::table('password_resets')->where('email', $email)->first();

        if (!$record || !Hash::check($request->token, $record->token)) {
            return back()->withErrors(['email' => 'El enlace es inválido o ha expirado.']);
        }

        // Verificar expiración (30 minutos)
        if (Carbon::parse($record->created_at)->addMinutes(30)->isPast()) {
            DB::table('password_resets')->where('email', $email)->delete();
            return back()->withErrors(['email' => 'El enlace ha expirado. Solicita uno nuevo.']);
        }

        $newPassword = Hash::make($request->password);

        // Actualizar en la tabla correspondiente
        if (Usuario::where('correo', $email)->exists()) {
            Usuario::where('correo', $email)->update(['contraseña' => $newPassword]);
        } elseif (Tecnico::where('correo', $email)->exists()) {
            Tecnico::where('correo', $email)->update(['contraseña' => $newPassword]);
        } elseif (Cliente::where('correo', $email)->exists()) {
            Cliente::where('correo', $email)->update(['contraseña' => $newPassword]);
        } else {
            return back()->withErrors(['email' => 'No se encontró la cuenta.']);
        }

        // Eliminar el token usado
        DB::table('password_resets')->where('email', $email)->delete();

        return redirect('/')->with('success', '¡Contraseña actualizada! Ya puedes iniciar sesión.');
    }
}
