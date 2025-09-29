# Wurger - Sistema de Gestión Empresarial

Sistema completo de gestión empresarial desarrollado con Laravel, con diseño moderno y funcionalidades completas.

## 🚀 Características

- **Dashboard Moderno**: Panel de control con estadísticas en tiempo real
- **Gestión de Usuarios**: Sistema completo de usuarios con roles
- **Gestión de Productos**: Control de inventario y categorías
- **Sistema de Ventas**: Procesamiento completo de ventas
- **Gestión de Clientes**: Base de datos de clientes
- **Sistema de Inventario**: Control de movimientos y stock
- **Diseño Responsivo**: Interfaz moderna y adaptable

## 📋 Requisitos

- PHP 8.1 o superior
- Composer
- MySQL 5.7 o superior
- Node.js y NPM (para assets)

## 🛠️ Instalación

1. **Clonar el repositorio**
   ```bash
   git clone [url-del-repositorio]
   cd Wurger
   ```

2. **Instalar dependencias**
   ```bash
   composer install
   npm install
   ```

3. **Configurar variables de entorno**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Configurar base de datos**
   - Crear base de datos MySQL llamada `Wurger`
   - Configurar credenciales en `.env`:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=Wurger
   DB_USERNAME=tu_usuario
   DB_PASSWORD=tu_contraseña
   ```

5. **Ejecutar migraciones y seeders**
   ```bash
   php artisan migrate:fresh --seed
   ```

6. **Compilar assets**
   ```bash
   npm run build
   ```

7. **Iniciar servidor**
   ```bash
   php artisan serve
   ```

## 🔑 Acceso Inicial

- **URL**: http://localhost:8000
- **Email**: admin@wurger.com
- **Contraseña**: 123456

## 📁 Estructura del Proyecto

```
Wurger/
├── app/
│   ├── Http/Controllers/     # Controladores
│   └── Models/              # Modelos Eloquent
├── database/
│   ├── migrations/          # Migraciones de BD
│   └── seeders/            # Seeders de datos
├── resources/
│   └── views/              # Vistas Blade
│       ├── layouts/        # Layouts principales
│       ├── auth/           # Vistas de autenticación
│       └── dashboard.blade.php
└── routes/
    └── web.php             # Rutas web
```

## 🎨 Módulos Disponibles

### 1. Dashboard
- Estadísticas generales
- Ventas recientes
- Productos con stock bajo
- Acciones rápidas

### 2. Gestión de Usuarios
- CRUD completo de usuarios
- Sistema de roles
- Autenticación segura

### 3. Gestión de Productos
- Catálogo de productos
- Control de inventario
- Categorías de productos
- Unidades de medida

### 4. Sistema de Ventas
- Procesamiento de ventas
- Detalles de venta
- Formas de pago
- Descuentos

### 5. Gestión de Clientes
- Base de datos de clientes
- Información de contacto
- Historial de compras

### 6. Sistema de Inventario
- Movimientos de stock
- Control de entradas y salidas
- Alertas de stock bajo

## 🔧 Tecnologías Utilizadas

- **Backend**: Laravel 10
- **Frontend**: Blade Templates, Bootstrap 5
- **Base de Datos**: MySQL
- **Iconos**: Font Awesome 6
- **Estilos**: CSS3 personalizado

## 📱 Diseño Responsivo

La aplicación está completamente optimizada para:
- Desktop (1200px+)
- Tablet (768px - 1199px)
- Mobile (320px - 767px)

## 🚀 Próximas Funcionalidades

- [ ] Sistema de reportes avanzados
- [ ] Gráficos interactivos
- [ ] Notificaciones en tiempo real
- [ ] API REST
- [ ] Exportación de datos
- [ ] Sistema de backup automático

## 📞 Soporte

Para soporte técnico o consultas, contactar al equipo de desarrollo.

## 📄 Licencia

Este proyecto está bajo la Licencia MIT.

---

**Wurger** - Sistema de Gestión Empresarial Moderno y Eficiente