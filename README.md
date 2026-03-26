# VEYLI Admin

Panel administrativo de VEYLI TMS. Este proyecto ofrece la interfaz de gestion para operar el sistema logistica desde navegador.

## Objetivo

Desde este panel se administran los modulos principales del negocio:

- dashboard ejecutivo
- usuarios, roles y permisos
- clientes, conductores, vehiculos y rutas
- estados de paquete, envios y asignaciones
- reportes y exportaciones
- configuracion del sistema

No es una app aislada: depende de la API de [`/home/ben/pi/api`](/home/ben/pi/api).

## Stack

- PHP 8.2
- Laravel 12
- Livewire 4
- Vite
- Tailwind CSS 4

## Puertos y contenedores

- Admin web: `http://localhost:8088`
- Vite dev server: `http://localhost:5173`

Servicios Docker:

- `veyli-admin`
- `veyli_node`

## Conexion con la API

El panel consume la API FastAPI mediante `API_BASE_URL`.

Valor usual en Docker local:

```txt
http://host.docker.internal:8001/api/v1
```

## Variables principales

Archivo base: [`.env.example`](/home/ben/pi/veyli-admin/.env.example)

Variables importantes:

- `APP_NAME`
- `APP_ENV`
- `APP_KEY`
- `APP_URL`
- `API_BASE_URL`
- `API_TIMEOUT`
- `SESSION_DRIVER`
- `CACHE_STORE`
- `QUEUE_CONNECTION`
- `DB_CONNECTION`
- `DB_HOST`
- `DB_PORT`
- `DB_DATABASE`
- `DB_USERNAME`
- `DB_PASSWORD`

Nota: este proyecto puede usar la misma base de datos de la API para sesiones, cache y jobs cuando se configura asi.

## Levantar con Docker

Desde [`/home/ben/pi/veyli-admin`](/home/ben/pi/veyli-admin):

```bash
docker compose up -d --build
```

Ver logs:

```bash
docker logs -f veyli-admin
docker logs -f veyli_node
```

Detener:

```bash
docker compose down
```

## Ejecutar sin Docker

```bash
cd /home/ben/pi/veyli-admin
composer install
cp .env.example .env
php artisan key:generate
npm install
php artisan serve --host=0.0.0.0 --port=8000
npm run dev
```

## Estructura

```text
veyli-admin/
├── app/
│   ├── Http/Controllers/   # auth, configuracion, exportaciones
│   ├── Livewire/Admin/     # modulos CRUD del panel
│   ├── Services/           # consumo de la API FastAPI
│   └── Http/Middleware/    # auth y permisos
├── resources/
│   ├── css/
│   ├── views/
│   └── js/
├── routes/
├── config/
├── database/
└── docker-compose.yml
```

## Modulos importantes

- `Dashboard`
- `Usuarios`
- `Roles`
- `Clientes`
- `Conductores`
- `Vehiculos`
- `Rutas`
- `Estados de paquete`
- `Envios`
- `Asignaciones`
- `Reportes`
- `Configuracion`

## Roles, permisos y acceso

El control de acceso se apoya en permisos servidos por la API. El menu lateral y las rutas del panel se muestran u ocultan segun los permisos del usuario autenticado.

Ejemplos de permisos:

- `dashboard.view`
- `users.view`
- `roles.create`
- `packages.update`
- `reports.export`
- `settings.manage`

## Sesion y autenticacion

- el login del admin autentica contra la API
- si el token expira, la sesion local se limpia y el usuario vuelve al login
- el panel no permite entrar a usuarios tipo cliente

## Reportes y configuracion

El panel incluye:

- exportacion de reportes
- configuracion de perfil
- configuracion general del sistema
- configuracion de notificaciones

Todo eso persiste en la API, no en logica aislada del front.

## Comandos utiles

Listar rutas:

```bash
docker exec -it veyli-admin php artisan route:list
```

Limpiar cache:

```bash
docker exec -it veyli-admin php artisan optimize:clear
```

## Problemas comunes

`SQLSTATE sessions doesn't exist`

- corre las migraciones necesarias de Laravel o verifica la tabla `sessions`

`Host mysql not found`

- revisa `DB_HOST`; si el admin consume el MySQL publicado por la API en Docker local, normalmente se usa `host.docker.internal`

`401` o logout inesperado

- revisa `API_BASE_URL`, expiracion del token y conectividad con la API

`vite assets not loading`

- verifica que `veyli_node` este arriba y escuchando en `5173`
