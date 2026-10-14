# DIVM Educación Especial — API (Laravel)

Esta es la conversión de tu proyecto original **DIVM_Educacion** (PHP plano +
mysqli + sesiones + FPDF) a una **API REST en Laravel 11**, usando:

- **Laravel Sanctum** para autenticación por token (con verificación en 2 pasos por correo).
- **Contraseñas con bcrypt** (`Hash::make` / `Hash::check`) en lugar de texto plano.
- **barryvdh/laravel-dompdf** para generar los PDFs de informes y avances.
- Proxy del chatbot (Groq) con la API key movida a `.env`, ya no está escrita en el código.

## 1. Instalación

```bash
cd divm-laravel
composer install
cp .env.example .env
php artisan key:generate
```

Edita el `.env` con tus datos reales:

```env
DB_DATABASE=divm
DB_USERNAME=root
DB_PASSWORD=

MAIL_USERNAME=tu_correo@gmail.com
MAIL_PASSWORD=tu_app_password_de_gmail

GROQ_API_KEY=tu_api_key_de_groq
```

> ⚠️ La API key de Groq que traía tu `chatbot_proxy.php` original estaba
> escrita directamente en el código (`gsk_...`). La quité del proyecto por
> seguridad — si sigue siendo válida, considérala expuesta y genera una
> nueva desde tu panel de Groq, y ponla solo en `.env`.

## 2. Base de datos

Crea la base `divm` en MySQL (vacía) y corre:

```bash
php artisan migrate
php artisan db:seed
```

Esto crea las 8 tablas de tu sistema original (mismas columnas, mismos
`enum`, mismas relaciones) y siembra los usuarios de prueba con contraseñas
ya hasheadas:

| Correo | Password | Rol |
|---|---|---|
| guadalupe.vera.divm@gmail.com | 12345 | Administrador |
| leticia.garcia.divm@gmail.com | 12345 | Personal |
| soporte.divm@gmail.com | 123456 | Administrador |

Si prefieres **importar tus datos reales** desde `divm.sql` en vez de usar
el seeder: corre solo `php artisan migrate` (sin `db:seed`), luego importa
únicamente los `INSERT` de tus datos (no las sentencias `CREATE TABLE`, esas
ya las genera Laravel), y por último actualiza las contraseñas a bcrypt:

```bash
php artisan tinker
>>> \App\Models\Usuario::query()->update(['password' => bcrypt('12345')]); // ejemplo
```

## 3. Levantar el servidor

```bash
php artisan serve
```

La API queda en `http://localhost:8000/api`.

## 4. Autenticación

```
POST /api/login                { correo, contrasena }
POST /api/2fa/verificar        { correo, codigo }      (si el usuario tiene 2FA activo)
POST /api/2fa/reenviar         { correo }
POST /api/logout               (requiere Bearer token)
GET  /api/me                   (requiere Bearer token)
```

Todas las demás rutas van protegidas: agrega el header
`Authorization: Bearer {token}` que te devuelve `/api/login` (o
`/api/2fa/verificar` si el usuario tiene 2FA activo).

## 5. Mapeo de endpoints originales → nuevos

| Archivo PHP original | Endpoint nuevo |
|---|---|
| `login.php` | `POST /api/login` |
| `validar_2fa.php` | `POST /api/2fa/verificar` |
| `reenviar_codigo.php` | `POST /api/2fa/reenviar` |
| `logout.php` | `POST /api/logout` |
| `insertarusuario.php` | `POST /api/usuarios` (solo Administrador) |
| `actualizarusuario.php` | `PUT /api/usuarios/{id}` (solo Administrador) |
| `eliminar.php` | `DELETE /api/usuarios/{id}` (baja lógica → estado Inactivo) |
| `insertaregistro.php` | `POST /api/pacientes` |
| `actualizaregistro.php` | `PUT /api/pacientes/{id}` |
| `insertarinforme.php` | `POST /api/informes` |
| `actualizarinforme.php` | `PUT /api/informes/{id}` |
| `insertarvaloracion.php` | `POST /api/valoraciones` |
| `insertarplan.php` | `POST /api/planes` |
| `actualizarplan.php` | `PUT /api/planes/{id}` |
| `insertarrecomendaciones.php` | `POST /api/recomendaciones` |
| `actualizarrecomendacion.php` | `PUT /api/recomendaciones/{id}` |
| `insertar_avance.php` | `POST /api/avances` |
| `insertardistribucion.php` | `POST /api/horarios` |
| `obtener_grafica.php` | `GET /api/grafica/diagnosticos` |
| `generar_pdf.php` | `GET /api/informes/{id}/pdf` |
| `pdf_avance.php` | `GET /api/avances/{id}/pdf` |
| `chatbot_proxy.php` | `POST /api/chatbot` |

Todos los `GET /api/{recurso}` y `GET /api/{recurso}/{id}` (listar/ver) son
nuevos: el sistema original no tenía endpoints de lectura en JSON, porque
las vistas PHP consultaban la base de datos directamente. También se agregó
`DELETE` para informes, planes, recomendaciones y horarios, que el sistema
original no exponía pero son necesarios para un CRUD completo vía API.

## 6. Notas importantes sobre la conversión

- **Contraseñas**: el dump original traía `12345`/`123456` en texto plano
  y se comparaban con `===`. Ahora se guardan con bcrypt y se validan con
  `Hash::check()`. Si vas a importar usuarios reales desde tu base actual,
  no copies la columna `password` tal cual — rehashea cada una (ver punto 2).
- **SQL Injection**: varios archivos originales (`insertarusuario.php`,
  `insertarplan.php`, `insertarinforme.php`, etc.) armaban las consultas con
  `mysqli_real_escape_string` y concatenación de strings. Ahora todo pasa
  por **Eloquent + `$request->validate()`**, que usa consultas preparadas
  automáticamente.
- **`usuario_id` / `id_usuario` en avances y valoraciones**: en el sistema
  original venían como campos de formulario (`$_POST['usuario_id']`), lo
  cual permitía que cualquiera los manipulara. Ahora se toman del usuario
  autenticado (`$request->user()->id_usuario`), no de lo que mande el cliente.
- **Logo en los PDFs**: el original insertaba `LOGO SIN FONDO.png` en el
  encabezado del PDF. Ese archivo está en tu carpeta `cliente/img/` original;
  si quieres el logo en el PDF nuevo, cópialo a `public/img/logo.png` y
  agrega `<img src="{{ public_path('img/logo.png') }}" style="...">` dentro
  de `resources/views/pdf/informe.blade.php` y `avance.blade.php`.
- **Roles**: `usuarios` solo puede gestionarlos (crear/editar/desactivar)
  un usuario con `rol = Administrador`, igual que se esperaba en el sistema
  original (donde no había ninguna verificación de rol — aquí sí se aplica).

## 7. Estructura de carpetas relevante

```
app/Models/               Usuario, Paciente, Informe, InformeValoracion,
                           Plan, Recomendacion, AvancePaciente, HorarioAtencion
app/Http/Controllers/Api/ Un controlador por recurso + AuthController,
                           ChatbotController, GraficaController, PdfController
app/Http/Middleware/      EnsureUserHasRole.php (control de rol Administrador/Personal)
app/Mail/                 CodigoVerificacionMail.php (2FA)
database/migrations/      Esquema completo (igual a divm.sql)
database/seeders/         Usuarios de prueba con password bcrypt
resources/views/pdf/      Vistas para dompdf (informe.blade.php, avance.blade.php)
resources/views/emails/   Plantilla del correo de código 2FA
routes/api.php            Todas las rutas de la API
```

## 8. Lo que NO se migró (por ser específico del frontend PHP anterior)

La carpeta `cliente/` de tu proyecto original (vistas HTML/PHP,
Bootstrap, JS) no se convierte a Laravel porque tu nuevo frontend
consumirá esta API por HTTP — puedes construirlo con lo que prefieras
(React, Vue, la misma carpeta `cliente/` adaptada a `fetch()`, etc.).
