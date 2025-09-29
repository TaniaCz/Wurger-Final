# Guía de Instalación - Wurger

## Pasos para Completar la Instalación

### 1. Configurar Base de Datos

Ejecuta estos comandos en tu terminal:

```bash
# Crear la base de datos
mysql -u root -p
CREATE DATABASE Wurger;
exit

# Ejecutar migraciones restantes
php artisan migrate --force

# Insertar datos iniciales
php artisan db:seed
```

### 2. Configurar Variables de Entorno

Edita el archivo `.env` y asegúrate de que tenga estas configuraciones:

```env
APP_NAME=Wurger
APP_ENV=local
APP_KEY=base64:tu-clave-aqui
APP_DEBUG=true
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=Wurger
DB_USERNAME=root
DB_PASSWORD=

# Otras configuraciones...
```

### 3. Generar Clave de Aplicación

```bash
php artisan key:generate
```

### 4. Iniciar el Servidor

```bash
php artisan serve
```

### 5. Acceder a la Aplicación

Abre tu navegador y ve a: **http://localhost:8000**

### 6. Credenciales de Acceso

- **Email**: admin@wurger.com
- **Contraseña**: 123456

## Solución de Problemas

### Si hay errores de migración:

```bash
# Limpiar y recrear base de datos
php artisan migrate:fresh --seed
```

### Si hay errores de permisos:

```bash
# En Windows
icacls storage /grant Everyone:F /T

# En Linux/Mac
chmod -R 775 storage
chmod -R 775 bootstrap/cache
```

### Si no se ven los estilos:

```bash
# Compilar assets
npm install
npm run build
```

## Estructura de Archivos Creados

### Modelos Eloquent
- `app/Models/Usuario.php` - Gestión de usuarios
- `app/Models/Rol.php` - Roles de usuario
- `app/Models/Producto.php` - Productos
- `app/Models/CategoriaProducto.php` - Categorías
- `app/Models/Cliente.php` - Clientes
- `app/Models/Venta.php` - Ventas
- `app/Models/Proveedor.php` - Proveedores
- `app/Models/Movimiento.php` - Movimientos de inventario
- Y más...

### Controladores
- `app/Http/Controllers/InicioController.php` - Dashboard
- `app/Http/Controllers/AuthController.php` - Autenticación
- `app/Http/Controllers/UsuarioController.php` - Usuarios
- `app/Http/Controllers/ProductoController.php` - Productos
- `app/Http/Controllers/VentaController.php` - Ventas
- `app/Http/Controllers/ClienteController.php` - Clientes

### Vistas
- `resources/views/layouts/app.blade.php` - Layout principal
- `resources/views/auth/login.blade.php` - Página de login
- `resources/views/dashboard.blade.php` - Dashboard principal

### Rutas
- `routes/web.php` - Rutas web configuradas

## Funcionalidades Implementadas

✅ **Sistema de Autenticación**
- Login con email y contraseña
- Middleware de autenticación
- Cierre de sesión

✅ **Dashboard Moderno**
- Estadísticas en tiempo real
- Diseño responsivo
- Navegación intuitiva

✅ **Modelos Eloquent Completos**
- Relaciones entre entidades
- Validaciones
- Casts de datos

✅ **Base de Datos**
- Migraciones configuradas
- Seeders con datos iniciales
- Estructura completa

✅ **Diseño Moderno**
- CSS personalizado
- Iconos Font Awesome
- Interfaz profesional

## Próximos Pasos

1. **Completar Controladores**: Implementar métodos CRUD
2. **Crear Vistas**: Desarrollar interfaces de usuario
3. **Validaciones**: Agregar reglas de validación
4. **Testing**: Implementar pruebas unitarias
5. **Optimización**: Mejorar rendimiento

