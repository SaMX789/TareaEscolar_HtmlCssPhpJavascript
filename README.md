# Proyecto Web - HTML, CSS, JavaScript y PHP

Este proyecto contiene una colección de páginas web estáticas y una pequeña aplicación PHP con MySQL para gestionar ventas e inventario.

## Estructura principal

- `calculadora.html` - calculadora básica con botones y pantalla.
- `script.js` - lógica de la calculadora.
- `calc.css` - estilos para la calculadora.
- `venta.html` - simulador de tienda con carrito de compras y cálculo de total en JavaScript.
- `estilos.css` - estilos globales para varias páginas HTML.
- `Samuel.html` - página principal de navegación en la carpeta raíz.
- `CODIGO.js`, `micodigo.js` - archivos JavaScript adicionales.
- `CALCULADORA/` - carpeta con otra versión de calculadora y páginas relacionadas.
- `HTML2/` - aplicación PHP y páginas de base de datos.
- `XML/contenido.xml` - archivo XML incluido en el proyecto.

## Sección PHP (`HTML2/`)

La carpeta `HTML2` contiene una pequeña aplicación de ventas e inventario que usa PHP y MySQL.

Archivos importantes:
- `Samuel.php` - página de inicio y navegación para la app PHP.
- `buscar_venta.php` - búsqueda de ventas.
- `nueva_venta.php` - formulario para registrar nuevas ventas.
- `tabla_productos.php` - muestra productos.
- `tabla_categorias.php` - muestra categorías.
- `tabla_clientes.php` - muestra clientes.
- `tabla_detalle_ventas.php` - muestra los detalles de ventas.
- `tabla_ventas.php` - muestra las ventas registradas.
- `style.css` - estilos para las páginas PHP.

## Requisitos

- XAMPP o servidor local con Apache y MySQL.
- Base de datos MySQL llamada `webbd`.
- Tablas esperadas:
  - `productos`
  - `categorias`
  - `clientes`
  - `detalle_ventas`
  - `ventas`

## Configuración

1. Colocar la carpeta del proyecto en `htdocs` de XAMPP, por ejemplo `C:\xampp\htdocs\html`.
2. Iniciar Apache y MySQL desde el panel de XAMPP.
3. Crear la base de datos `webbd` y las tablas necesarias.
4. Acceder a las páginas desde el navegador:
   - `http://localhost/html/Samuel.html` - página principal HTML.
   - `http://localhost/html/calculadora.html` - calculadora básica.
   - `http://localhost/html/venta.html` - simulador de tienda.
   - `http://localhost/html/HTML2/Samuel.php` - app PHP de inventario y ventas.

## Notas importantes

- Los archivos PHP usan conexión a MySQL con `root` sin contraseña:
  - host: `localhost`
  - usuario: `root`
  - contraseña: ``
  - base de datos: `webbd`
- Esta configuración es adecuada para desarrollo local, pero no para producción.

## Mejora recomendada

- Crear un archivo de esquema SQL para la base de datos.
- Separar la lógica PHP en archivos más pequeños.
- Añadir validación adicional y manejo de errores en los formularios.
