<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JHARDSYSTEX - Acceso</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">

    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            min-height: 100vh;
            font-family: 'Poppins', sans-serif;
            background-color: #ffffff;
            color: #333333;
            overflow-x: hidden;
        }

        /* Contenedor principal en pantalla dividida */
        .main-split-container {
            display: flex;
            min-height: 100vh;
            width: 100vw;
        }

        /* --- COLUMNA IZQUIERDA: FORMULARIO DE ACCESO --- */
        .login-side {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 40px;
            background-color: #ffffff;
        }

        .login-wrapper {
            width: 100%;
            max-width: 380px; /* Ancho de las cajas de texto */
            text-align: center;
        }

        /* Contenedor del Logo alineado al ancho del formulario */
        .logo-container {
            width: 100%;
            max-width: 340px;
            margin: 0 auto 5px auto;
        }

        .logo-container img {
            width: 100%;
            height: auto;
            display: block;
        }

        .subtitle-ti {
            font-size: 15px;
            font-style: italic;
            color: #444444;
            margin-bottom: 35px;
            font-weight: 400;
        }

        .login-wrapper h2 {
            font-size: 18px;
            color: #333333;
            margin-bottom: 25px;
            font-weight: 400;
        }

        /* Estilos del Formulario e Inputs */
        .input-group {
            margin-bottom: 16px;
            text-align: left;
            position: relative;
        }

        input {
            width: 100%;
            padding: 14px 16px;
            border-radius: 8px;
            border: 1.5px solid #00bcff;
            background: #ffffff;
            color: #333333;
            font-size: 14px;
            outline: none;
            transition: 0.3s;
        }

        input:focus {
            border-color: #0072ff;
            box-shadow: 0 0 8px rgba(0, 188, 255, 0.2);
        }

        /* Botón de envío en degradado azul */
        button[type="submit"] {
            width: 100%;
            padding: 14px;
            margin-top: 10px;
            border-radius: 8px;
            border: none;
            background: linear-gradient(90deg, #00d2ff, #0066ff);
            color: white;
            font-weight: bold;
            font-size: 15px;
            letter-spacing: 1px;
            cursor: pointer;
            transition: 0.3s;
        }

        button[type="submit"]:hover {
            filter: brightness(1.05);
            box-shadow: 0 4px 12px rgba(0, 102, 255, 0.3);
        }

        /* Mostrar / Ocultar Contraseña */
        .password-wrapper { position: relative; }
        .toggle-password {
            position: absolute;
            right: 14px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #8892b0;
            z-index: 2;
            user-select: none;
        }

        .footer { 
            margin-top: 50px; 
            font-size: 11px; 
            color: #777777; 
        }

        /* --- COLUMNA DERECHA: NUEVA IMAGEN DE CÁMARAS --- */
        .image-side {
            flex: 1.2;
            position: relative;
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: hidden;
            background-color: #0d1b2a; /* Fondo base oscuro que combina con el azul */
        }

        /* Clon de fondo borroso para rellenar los espacios verticales de forma estética */
        .image-side-blur-bg {
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            background: url("{{ asset('images/banner_camaras.jpg') }}") center/cover no-repeat;
            filter: blur(15px) brightness(0.4);
            transform: scale(1.1); /* Evita bordes blancos por el blur */
            z-index: 1;
        }

        /* Contenedor del Banner principal al frente */
        .banner-foreground {
            position: relative;
            z-index: 2;
            width: 95%;
            max-width: 650px;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.5);
            overflow: hidden;
            display: block;
            transition: transform 0.3s ease;
        }

        .banner-foreground:hover {
            transform: scale(1.02);
        }

        .banner-foreground img {
            width: 100%;
            height: auto;
            display: block;
        }

        /* --- RESPONSIVE --- */
        @media (max-width: 900px) {
            .image-side {
                display: none; /* Oculta el banner en celulares */
            }
            .login-side {
                padding: 20px;
            }
        }
    </style>
</head>
<body>

@include('components.notificaciones.alertas')

    @if ($errors->any())
        <script>
            @foreach ($errors->all() as $error)
                showNotification(
                    'danger',
                    'Error',
                    '{{ $error }}'
                );
            @endforeach
        </script>
    @endif

    @if (session('success'))
        <script>
            showNotification(
                'success',
                'Correcto',
                '{{ session("success") }}'
            );
        </script>
    @endif

    <div class="main-split-container">
        
        <div class="login-side">
            <div class="login-wrapper">
                
                <div class="logo-container">
                    <img src="{{ asset('images/logo.png') }}" alt="JHARDSYSTEX">
                </div>
                <div class="subtitle-ti">Soluciones Especializadas TI</div>

                <h2>Iniciar sesión</h2>

                <form id="login-form" method="POST" action="{{ route('login') }}">
                    @csrf
                    
                    <div class="input-group">
                        <input type="email" name="correo" placeholder="Correo electrónico" required autocomplete="username">
                    </div>
                    
                    <div class="input-group password-wrapper">
                        <input type="password" id="login-pass" name="password" placeholder="Contraseña" required autocomplete="current-password">
                        <span class="toggle-password" onclick="togglePassword('login-pass', this)">👁</span>
                    </div>
                    
                    <button type="submit">ACCEDER</button>
                </form>

                <div class="footer">
                    © 2026 JHARDSYSTEX | Infraestructura Crítica
                </div>
            </div>
        </div>

        <div class="image-side">
            <div class="image-side-blur-bg"></div>
            
            <div class="banner-foreground">
                <img src="{{ asset('images/banner_camaras.jpg') }}" alt="Soporte y Cámaras de Seguridad">
            </div>
        </div>

    </div>

<script>
    function togglePassword(id, el) {
        const input = document.getElementById(id);
        const isSecret = input.type === "password";
        
        input.type = isSecret ? "text" : "password";
        el.textContent = isSecret ? "🙈" : "👁";
    }
</script>
</body>
</html>