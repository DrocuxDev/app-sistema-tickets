# Sistema de gestión de tickets

Aplicación web para registrar, asignar y dar seguimiento a solicitudes de soporte técnico. Está construida con Laravel 10, PostgreSQL, Blade, Bootstrap y Vite.

## Roles

- **Cliente:** consulta sus tickets, registra solicitudes y administra usuarios de su empresa.
- **Usuario:** registra y consulta sus propios tickets.
- **Técnico:** toma tickets, agrega comentarios, adjunta reportes y actualiza estados.
- **Administrador:** gestiona clientes, usuarios, técnicos y el ciclo completo de los tickets.

## Requisitos

- Docker y Docker Compose para el entorno recomendado.
- O PHP 8.1+, Composer, Node.js 20+ y PostgreSQL.

## Instalación local con Docker

```bash
cp .env.example .env
docker compose up -d --build
```

La aplicación queda disponible en `http://localhost:8000`. El contenedor prepara la configuración, ejecuta las migraciones y crea el enlace de almacenamiento.

Para detener el entorno:

```bash
docker compose down
```

## Desarrollo sin Docker

```bash
composer install
npm install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
npm run dev
php artisan serve
```

Configura en `.env` la conexión de PostgreSQL, correo y `FILESYSTEM_DISK=public`. Para archivos públicos, ejecuta:

```bash
php artisan storage:link
```

## Pruebas y calidad

```bash
php artisan test
vendor/bin/pint --test
npm run build
```

Las rutas privadas están protegidas por middleware de rol y, además, los controladores conservan sus validaciones de sesión para evitar regresiones.

## Despliegue en Render

El archivo `render.yaml` crea el servicio Docker y una base de datos PostgreSQL. Render genera `APP_KEY` y proporciona `DATABASE_URL`; el entrypoint convierte esa URL en las variables que Laravel necesita.

En el dashboard de Render deben configurarse:

- `MAIL_USERNAME`
- `MAIL_PASSWORD`
- `MAIL_FROM_ADDRESS`

En producción `APP_DEBUG` permanece desactivado y los logs se envían a `stderr`.

## Estructura principal

```text
app/
  Http/Controllers/   Controladores por rol y autenticación
  Http/Middleware/    Protección de sesión y roles
  Models/             Modelos Eloquent
  Services/           Notificaciones y lógica compartida
database/migrations/ Esquema de la aplicación
resources/views/     Interfaces Blade
routes/web.php       Rutas web protegidas
tests/               Pruebas unitarias y funcionales
```

## Licencia

Este proyecto se distribuye bajo la licencia MIT.
