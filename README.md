# Prueba Tecnica Gigante del Hogar

Aplicacion construida con Laravel, Inertia, Vue 3, PrimeVue y Tailwind. La idea es mostrar una solucion ordenada, modular y facil de evaluar, con autenticacion, asignacion de roles, suscripciones, citas y reserva transaccional de cupos.

## Que incluye

- Autenticacion con Jetstream y Fortify.
- Asignacion de perfil para uno o dos roles.
- Vista de dashboard con resumen y accesos rapidos.
- Flujo de prestadores para crear y revisar citas.
- Flujo de solicitantes para suscribirse y reservar cupos.
- Repositorios para separar acceso a datos y reglas de negocio.
- Interfaz minimalista, clara y responsive.

## Tecnologias

- Laravel
- Vue 3
- Inertia
- PrimeVue
- Tailwind CSS
- MySQL

## Requisitos

Antes de ejecutar el proyecto, confirma que tienes instalado lo siguiente:

- PHP y Composer.
- Node.js y npm.
- MySQL o el motor de base de datos que uses localmente.
- Variables de entorno configuradas en `.env`.

## Paso 1: Instalar dependencias

Primero descarga las dependencias de backend y frontend. Este paso prepara el proyecto para que Laravel pueda correr y para que Vite pueda compilar los componentes Vue.

```bash
composer install
npm install
```

## Paso 2: Configurar el archivo `.env`

Duplica el archivo de ejemplo y ajusta los datos de tu base de datos. Aqui es donde Laravel toma la conexion, la clave de la aplicacion y otras variables del entorno.

```bash
cp .env.example .env
```

Luego revisa al menos estos valores:

- `APP_NAME`
- `APP_URL`
- `DB_CONNECTION`
- `DB_HOST`
- `DB_PORT`
- `DB_DATABASE`
- `DB_USERNAME`
- `DB_PASSWORD`

## Paso 3: Generar la clave de la aplicacion

Laravel necesita una clave unica para cifrado y sesiones. Este paso solo se hace una vez por instalacion.

```bash
php artisan key:generate
```

## Paso 4: Crear la base de datos y ejecutar migraciones

Las migraciones crean las tablas del sistema: usuarios, roles, suscripciones, citas, cupos y las tablas base que Laravel necesita para trabajar.

```bash
php artisan migrate
```

## Paso 5: Cargar datos demo

El seeder incluye usuarios de ejemplo, roles, citas, suscripciones y cupos. Esto sirve para revisar el flujo completo sin tener que crear todo manualmente.

```bash
php artisan db:seed
```

## Paso 6: Compilar los assets frontend

Este paso construye la interfaz Vue y deja listo el bundle de produccion. Tambien lo puedes repetir cuando hagas cambios en los componentes.

```bash
npm run build
```

Durante desarrollo, en vez de build puedes dejar Vite en modo observacion:

```bash
npm run dev
```

## Paso 7: Levantar el servidor

Con la base de datos y los assets listos, inicia Laravel para abrir la aplicacion en el navegador.

```bash
php artisan serve
```

## Paso 8: Ingresar y probar el flujo

Abre la aplicacion, registra un usuario nuevo o usa los usuarios demo. Luego asigna el perfil, revisa el dashboard y prueba los flujos de prestador y solicitante.

## Cuentas demo

La base de datos de ejemplo crea estas cuentas para probar el sistema rapidamente:

- `prestador.demo@gigantedelhogar.com.co` / `password` - Prestador
- `solicitante.demo@gigantedelhogar.com.co` / `password` - Solicitante
- `mixto.demo@gigantedelhogar.com.co` / `password` - Prestador + Solicitante

## Flujo resumido

1. El usuario entra al sistema y se autentica.
2. Si no tiene roles asignados, se le lleva a la pantalla de perfil.
3. Segun el rol, el menu muestra solo las opciones que aplican.
4. El prestador crea citas y administra cupos disponibles.
5. El solicitante se suscribe a prestadores y reserva cupos.
6. La reserva valida suscripcion, disponibilidad y duplicados dentro de una transaccion.

## Estructura general

- `app/Repositories`: acceso a datos y reglas del dominio.
- `app/Http/Controllers`: coordinacion de cada flujo.
- `resources/js/Pages`: pantallas Inertia por modulo.
- `resources/js/Layouts`: layout principal de la aplicacion.
- `database/seeders`: datos demo para evaluacion rapida.

## Notas de ejecucion

- Si trabajas en local y la base de datos esta en tu maquina, revisa que `DB_HOST` apunte al host correcto.
- Si cambias componentes Vue, vuelve a ejecutar `npm run build` o deja `npm run dev` activo.
- Si necesitas regenerar datos demo, puedes volver a correr `php artisan db:seed`.

## Licencia

Este proyecto se entrega con fines de prueba tecnica.
