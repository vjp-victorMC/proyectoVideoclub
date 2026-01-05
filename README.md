# Proyecto Videoclub

## Descripción

Este proyecto es una simulación de la gestión de un videoclub moderno, desarrollado en PHP 8. El sistema permite administrar integralmente productos (Cintas, DVDs, Juegos), socios y transacciones de alquiler/devolución.

## Características Principales

### Gestión de Videoclub
- **Catálogo Diverso**: Soporte para Cintas de Vídeo, DVDs y Videojuegos, cada uno con atributos específicos.
- **Control de Stock y Alquileres**:
    - Alquileres individuales o por lotes (arrays).
    - Control de cupos máximos por cliente.
    - Control de disponibilidad (evita doble alquiler).
    - Historial de alquileres por cliente.
- **Gestión de Socios**: Altas de socios con credenciales y límites personalizados.

### Funcionalidades Avanzadas
- **Web Scraping Integrado**:
    - Conexión automática con **Metacritic** para obtener puntuaciones reales de los productos.
    - Implementado en la clase `Soporte`, capaz de analizar HTML y JSON-LD.
- **Sistema de Logs (Monolog)**:
    - Registro detallado de todas las operaciones (alquileres, devoluciones, errores, altas).
    - Salidas configurables (consola, archivos rotativos) mediante `LogFactory`.
- **Manejo de Errores Robusto**:
    - Uso de excepciones personalizadas: `CupoSuperadoException`, `SoporteYaAlquiladoException`, `SoporteNoEncontradoException`.

### Calidad de Código
- **Tests Unitarios**: Suite completa con **PHPUnit** cubriendo >95% de la funcionalidad.
- **Refactorización**: Código optimizado para baja complejidad ciclomática (CRAP).
- **Estándares**: PSR-4 Autoloading vía Composer.

## Requisitos e Instalación

### Requisitos
- PHP 8.0 o superior.
- Composer.

### Instalación
1. Clonar el repositorio.
2. Instalar dependencias:
   ```bash
   composer install
   ```
3. Generar el autoloader (si es necesario):
   ```bash
   composer dump-autoload
   ```

## Estructura del Proyecto

- **`app/`**: Código fuente (Namespaces `Dwes\ProyectoVideoclub`).
    - **`Util/`**: Factorías y Excepciones.
- **`tests/`**: Pruebas unitarias (PHPUnit).
- **`logs/`**: Archivos de log generados por Monolog.
- **`vendor/`**: Librerías de terceros (Monolog, PHPUnit).
- **`test/`**: Scripts de prueba manuales (`inicio3.php`).

## Ejecución de Pruebas

El proyecto incluye una batería de pruebas automatizadas.

Para ejecutar todos los tests:
```bash
./vendor/bin/phpunit
```

Para ver la cobertura (requiere Xdebug/PCOV):
```bash
./vendor/bin/phpunit --coverage-text
```

## Ejemplo de Uso

```php
use Dwes\ProyectoVideoclub\Videoclub;

// Instanciar Videoclub
$vc = new Videoclub("Blockbuster Reloaded");

// Incluir productos con URL de Metacritic
$vc->incluirJuego("https://www.metacritic.com/game/god-of-war", "God of War", 19.99, "PS4", 1, 1);

// Alquilar
$vc->alquilaSocioProducto(1, 1); // Alquila God of War al Socio 1
```

## Autor
Proyecto realizado para prácticas de DWES por Antonio Ángel Clemente Díaz y Víctor Mariscal Carril.

## Licencia
Uso educativo.