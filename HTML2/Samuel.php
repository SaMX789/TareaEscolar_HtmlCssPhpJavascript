<?php
$host = "localhost";
$user = "root";
$pass = "";

$db   = "webbd"; 

$conexion = mysqli_connect($host, $user, $pass, $db);

if (!$conexion) {
    die("Error al conectar: " . mysqli_connect_error());
}


$sql = "SELECT * FROM productos";
$sql2 = "SELECT * FROM categorias";
$sql3 = "SELECT * FROM clientes";
$sql4 = "SELECT * FROM detalle_ventas";
$sql5 = "SELECT * FROM ventas";
$resultado = mysqli_query($conexion, $sql);
$resultado2 = mysqli_query($conexion, $sql2);
$resultado3 = mysqli_query($conexion, $sql3);
$resultado4 = mysqli_query($conexion, $sql4);
$resultado5 = mysqli_query($conexion, $sql5);
// -------------------------------------------
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Inventario</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>LINKS PARA NAVEGAR ENTRE PAGINAS PHP</h1>
    <a href="buscar_venta.php">CLICK AQUI PARA LA PRIMERA PAGINA</a>
    <br>
    <a href="tabla_productos.php">CLICK AQUI PARA LA SEGUNDA PAGINA (tabla de productos)</a>
    <br>
    <a href="tabla_categorias.php">CLICK AQUI PARA LA TERCERA PAGINA (tabla de categorias)</a>
    <br>
    <a href="tabla_clientes.php">CLICK AQUI PARA LA CUARTA PAGINA (tabla de clientes)</a>
    <br>
    <a href="tabla_detalle_ventas.php">CLICK AQUI PARA LA QUINTA PAGINA (tabla de detalles de ventas)</a>
    <br>
    <a href="tabla_ventas.php">CLICK AQUI PARA LA SEXTA PAGINA (tabla de ventas)</a>
    <br>
    <a href="nueva_venta.php">CLICK AQUI PARA LA SEPTIMA PAGINA (nueva venta)</a>
    <br>
    <a href="../Samuel.html" style="color: red; font-size: 20px;">CLICK AQUI PARA VOLVER A LA PAGINA QUE USA HTML</a>
    <br>
    <h1>Inventario de Productos</h1>

    <table border="1">
        <tr>
            <th>ID</th>
            <th>Nombre del Producto</th>
            <th>Precio</th>
            <th>Stock Actual</th>
            <th>Categoría</th>
        </tr>
        <?php 

        while ($fila = mysqli_fetch_array($resultado)) {
            echo "<tr>";
            echo "<td>" . $fila['id_producto'] . "</td>";
            echo "<td>" . $fila['nombre'] . "</td>";
            echo "<td>$" . $fila['precio'] . "</td>";
            echo "<td>" . $fila['stock'] . "</td>";
            echo "<td>" . $fila['id_categoria'] . "</td>";
            echo "</tr>";
        }
        ?>
    </table>
    <h1>categorias</h1>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Nombre </th>
            <th>descripción</th>
            
        </tr>
        <?php 

        while ($fila = mysqli_fetch_array($resultado2)) {
            echo "<tr>";
            echo "<td>" . $fila['id_categoria'] . "</td>";
            echo "<td>" . $fila['nombre'] . "</td>";
            echo "<td>" . $fila['descripcion'] . "</td>";
            echo "</tr>";
        }
        ?>
    </table>

    <h1>Clientes</h1>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Email</th>
            <th>Teléfono</th>
        </tr>
        <?php 
        while ($fila = mysqli_fetch_array($resultado3)) {
            echo "<tr>";
            echo "<td>" . $fila['id_cliente'] . "</td>";
            echo "<td>" . $fila['nombre'] . "</td>";
            echo "<td>" . $fila['email'] . "</td>";
            echo "<td>" . $fila['telefono'] . "</td>";
            echo "</tr>";
        }
        ?>
    </table>

    <h1>Detalles de Venta</h1>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>ID Venta</th>
            <th>ID Producto</th>
            <th>Cantidad</th>
            <th>precio unitario</th>
        </tr>
        <?php 
        while ($fila = mysqli_fetch_array($resultado4)) {
            echo "<tr>";
            echo "<td>" . $fila['id_detalle'] . "</td>";
            echo "<td>" . $fila['id_venta'] . "</td>";
            echo "<td>" . $fila['id_producto'] . "</td>";
            echo "<td>" . $fila['cantidad'] . "</td>";
            echo "<td>$" . $fila['precio_unitario'] . "</td>";
            echo "</tr>";
        }
        ?>
    </table>

    <h1>Ventas</h1>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>fecha</th>
            <th>ID Cliente</th>
            <th>total</th>
        </tr>
        <?php 
        while ($fila = mysqli_fetch_array($resultado5)) {
            echo "<tr>";
            echo "<td>" . $fila['id_venta'] . "</td>";
            echo "<td>" . $fila['fecha'] . "</td>";
            echo "<td>" . $fila['id_cliente'] . "</td>";           
            echo "<td>$" . $fila['total'] . "</td>";
            echo "</tr>";
        }
        ?>
    </table>

    <?php
    mysqli_close($conexion);
    ?>
</body>
</html>