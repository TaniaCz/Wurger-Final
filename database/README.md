# Base de Datos Wurger

Este directorio contiene los scripts SQL para configurar la base de datos del sistema Wurger.

## 📁 Estructura

```
database/
├── schema.sql          # Estructura de la base de datos (tablas, índices)
├── sample_data.sql     # Datos de ejemplo (opcional)
└── README.md          # Este archivo
```

## 🚀 Instalación

### Requisitos Previos
- MySQL 8.0 o superior
- Acceso a un servidor MySQL (local o remoto)

### Paso 1: Crear la Base de Datos

```bash
# Conectarse a MySQL
mysql -u root -p

# Ejecutar el script de esquema
source /ruta/a/wurger/database/schema.sql
```

O usando un cliente GUI como MySQL Workbench:
1. Abrir MySQL Workbench
2. Conectarse al servidor
3. File → Run SQL Script
4. Seleccionar `schema.sql`
5. Ejecutar

### Paso 2: Cargar Datos de Ejemplo (Opcional)

```bash
# Desde MySQL CLI
source /ruta/a/wurger/database/sample_data.sql
```

**⚠️ IMPORTANTE**: Los datos de ejemplo incluyen usuarios con contraseñas hasheadas. Para producción, debes crear tus propios usuarios con contraseñas seguras.

## 🔧 Configuración de la Aplicación

Después de crear la base de datos, configura la conexión en:

**Archivo**: `src/main/resources/application.properties`

```properties
spring.datasource.url=jdbc:mysql://localhost:3306/Wurger?useSSL=false&serverTimezone=UTC
spring.datasource.username=TU_USUARIO
spring.datasource.password=TU_CONTRASEÑA
spring.jpa.hibernate.ddl-auto=update
```

## 📊 Estructura de Tablas

### Principales Entidades

- **usuario**: Usuarios del sistema (clientes y administradores)
- **usuario_info**: Información adicional de usuarios
- **categoria_producto**: Categorías de productos
- **producto**: Productos disponibles
- **promocion**: Promociones activas
- **venta**: Órdenes de compra
- **detalle_venta**: Detalles de cada venta
- **pedido**: Pedidos realizados

### Diagrama de Relaciones

```
usuario (1) ──── (N) venta
usuario (1) ──── (1) usuario_info
categoria_producto (1) ──── (N) producto
producto (1) ──── (N) detalle_venta
producto (1) ──── (N) promocion
venta (1) ──── (N) detalle_venta
usuario_info (1) ──── (N) pedido
```

## 🔄 Actualizar la Base de Datos

Si necesitas actualizar la estructura:

1. **Modo desarrollo**: Usa `spring.jpa.hibernate.ddl-auto=update` (ya configurado)
2. **Modo producción**: Crea scripts de migración manualmente

## 📝 Exportar Base de Datos Actual

Para exportar tu base de datos actual con todos los datos:

```bash
# Exportar estructura y datos
mysqldump -u root -p Wurger > wurger_backup.sql

# Solo estructura (sin datos)
mysqldump -u root -p --no-data Wurger > wurger_schema_only.sql

# Solo datos (sin estructura)
mysqldump -u root -p --no-create-info Wurger > wurger_data_only.sql
```

## 🔒 Seguridad

> [!WARNING]
> **NO** incluyas contraseñas reales en los scripts SQL que subes a GitHub.
> 
> - Usa variables de entorno para credenciales de producción
> - Los datos de ejemplo deben tener contraseñas genéricas
> - Asegúrate de que `application.properties` esté en `.gitignore`

## 🆘 Solución de Problemas

### Error: "Access denied for user"
- Verifica usuario y contraseña en `application.properties`
- Asegúrate de que el usuario tenga permisos en la BD

### Error: "Unknown database 'Wurger'"
- Ejecuta primero `schema.sql` para crear la base de datos

### Error: "Table doesn't exist"
- Verifica que `spring.jpa.hibernate.ddl-auto=update` esté configurado
- O ejecuta manualmente `schema.sql`

## 📞 Soporte

Si encuentras problemas con la base de datos, revisa:
1. Los logs de la aplicación Spring Boot
2. Los logs de MySQL
3. La configuración en `application.properties`
