# Proyecto Videoclub

## Descripción

Este proyecto es una simulación de la gestión de un videoclub, desarrollado en PHP orientado a objetos. Permite administrar clientes, productos (soportes como DVDs, cintas de vídeo y juegos), alquileres y devoluciones, gestionando el estado de cada producto y el cupo de alquiler de los clientes. El sistema utiliza namespaces, autoloading y excepciones personalizadas para una arquitectura moderna y escalable.

## Novedades y funcionalidades recientes

- **Gestión de clientes desde el panel de administración**: el administrador puede crear, editar y eliminar clientes desde la interfaz web.
- **Persistencia de clientes en sesión**: los clientes creados desde el panel admin se guardan en la sesión y permanecen disponibles tras cerrar y volver a iniciar sesión como admin.
- **Login con credenciales personalizadas**: cada cliente tiene su propio usuario y contraseña para acceder al sistema.
- **Edición y borrado de clientes**: el admin puede modificar los datos de los clientes o eliminarlos completamente.
- **Validación de datos y mensajes de error**: el sistema valida los datos introducidos y muestra mensajes claros en caso de error o duplicidad de usuario.

## Estructura de Carpetas

- **app/**: Contiene todas las clases principales del proyecto (Cliente, Videoclub, Soporte, excepciones, etc.).
- **test/**: Archivos de prueba y ejemplos de uso.
- **vendor/**: Librerías externas (si se usa Composer).
- **autoload.php**: Carga automática de clases mediante namespaces.
- **public/**: Archivos accesibles desde el navegador (formularios, paneles, login, etc.).

## Funcionamiento

- Los clientes pueden alquilar y devolver productos.
- El videoclub controla qué productos están alquilados y cuáles disponibles.
- El sistema lanza excepciones específicas para gestionar errores de negocio (cupo superado, soporte ya alquilado, etc.).
- El autoload permite cargar clases automáticamente sin necesidad de incluir archivos manualmente.
- El administrador puede gestionar clientes y soportes desde la interfaz web.

## Instrucciones de Ejecución

1. **Requisitos**:  
   - PHP 7.4 o superior.
   - Servidor local (XAMPP, WAMP, etc.) o CLI de PHP.

2. **Estructura**:  
   - Coloca el contenido del proyecto en la carpeta raíz de tu servidor local.
   - Asegúrate de que la estructura de carpetas sea la indicada arriba.

3. **Ejecutar pruebas**:  
   - Accede a la carpeta `test/`.
   - Ejecuta el archivo de prueba principal, por ejemplo:
     ```
     php test/inicio3.php
     ```
   - O accede desde el navegador si usas un servidor local:
     ```
     http://localhost/ProyectoVideoclub/test/inicio3.php
     ```

4. **Autoload**:  
   - El archivo `autoload.php` se encarga de cargar automáticamente las clases necesarias.  
   - No es necesario modificar los includes en los archivos de prueba, solo asegúrate de requerir `autoload.php` al inicio.

5. **Acceso web**:
   - Accede a `public/index.php` para iniciar sesión como admin o cliente.
   - Usuario admin: `admin` / `admin`.
   - Usuario cliente: usa los datos de los clientes creados o los de ejemplo.

## Ejemplo de Uso

```php
require_once __DIR__ . '/../autoload.php';

use Dwes\ProyectoVideoclub\Videoclub;

$vc = new Videoclub("Severo 8A");
$vc->alquilaSocioProducto(1, 2)
   ->alquilaSocioProducto(1, 3);
```

## Autor

Proyecto realizado para prácticas de DWES por Antonio Ángel Clemente Díaz y Víctor Mariscal Carril, alumnos de 2º de DAW.

## Licencia

Uso educativo.