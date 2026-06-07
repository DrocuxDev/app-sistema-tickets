<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nueva contraseña — JHARDSYSTEX</title>
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@700;800&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        * { margin:0; padding:0; box-sizing:border-box; }
        body { min-height:100vh; font-family:'DM Sans',sans-serif; background:linear-gradient(160deg,#0d1f3c,#122444,#0f1e38); display:flex; align-items:center; justify-content:center; padding:16px; }
        .card { background:rgba(18,36,68,.85); border:1px solid rgba(43,127,255,.2); border-radius:20px; width:100%; max-width:420px; box-shadow:0 24px 60px rgba(0,0,0,.5); overflow:hidden; }
        .card-header { background:#0d1f3c; padding:28px 32px; text-align:center; border-bottom:1px solid rgba(43,127,255,.15); }
        .card-header h1 { font-family:'Syne',sans-serif; font-size:18px; color:#e8edf5; margin-bottom:4px; }
        .card-header p { font-size:12px; color:#7a92b4; }
        .card-body { padding:28px 32px; }
        .field-label { display:block; font-size:10.5px; font-weight:600; letter-spacing:.1em; text-transform:uppercase; color:#7a92b4; margin-bottom:7px; }
        .input-wrap { position:relative; margin-bottom:16px; }
        .input-icon { position:absolute; left:13px; top:50%; transform:translateY(-50%); color:#4a6280; display:flex; pointer-events:none; }
        .jhs-input { width:100%; padding:13px 14px 13px 42px; border-radius:10px; border:1.5px solid rgba(43,127,255,.35); background:rgba(18,36,68,.65); color:#e8edf5; font-size:14px; outline:none; font-family:'DM Sans',sans-serif; transition:border-color .25s; }
        .jhs-input::placeholder { color:#3d5070; }
        .jhs-input:focus { border-color:#2b7fff; box-shadow:0 0 0 3px rgba(43,127,255,.18); }
        .btn-submit { width:100%; padding:14px; border-radius:10px; border:none; background:linear-gradient(135deg,#2b7fff,#0055e0); color:#fff; font-weight:700; font-size:13px; letter-spacing:.1em; text-transform:uppercase; cursor:pointer; font-family:'Syne',sans-serif; box-shadow:0 6px 24px rgba(43,127,255,.3); transition:.2s; }
        .btn-submit:hover { filter:brightness(1.08); }
        .error-msg { background:rgba(239,68,68,.15); border:1px solid rgba(239,68,68,.4); color:#f87171; padding:10px 14px; border-radius:10px; font-size:13px; margin-bottom:16px; }
        .back-link { text-align:center; margin-top:16px; font-size:12px; color:#4a6280; }
        .back-link a { color:#2b7fff; text-decoration:none; }
        .hint { font-size:11px; color:#4a6280; margin-top:4px; }
    </style>
</head>
<body>

<div class="card">
    <div class="card-header">
        <h1>Nueva contraseña</h1>
        <p>Ingresa tu nueva contraseña para <strong style="color:#e8edf5;">{{ $email }}</strong></p>
    </div>
    <div class="card-body">

        @if ($errors->any())
            <div class="error-msg">{{ $errors->first() }}</div>
        @endif

        <form method="POST" action="{{ route('password.update') }}">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">
            <input type="hidden" name="email" value="{{ $email }}">

            <label class="field-label">Nueva contraseña</label>
            <div class="input-wrap">
                <span class="input-icon">
                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                </span>
                <input type="password" name="password" class="jhs-input" placeholder="Mínimo 6 caracteres" required minlength="6" autocomplete="new-password">
            </div>

            <label class="field-label">Confirmar contraseña</label>
            <div class="input-wrap">
                <span class="input-icon">
                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                </span>
                <input type="password" name="password_confirmation" class="jhs-input" placeholder="Repite la contraseña" required minlength="6" autocomplete="new-password">
            </div>
            <p class="hint">La contraseña debe tener al menos 6 caracteres.</p>

            <br>
            <button type="submit" class="btn-submit">Guardar nueva contraseña</button>
        </form>

        <div class="back-link">
            <a href="/">← Volver al inicio de sesión</a>
        </div>
    </div>
</div>

</body>
</html>
