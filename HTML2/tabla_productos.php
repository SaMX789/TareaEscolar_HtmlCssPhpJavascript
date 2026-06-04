<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "webbd";
$conexion = mysqli_connect($host, $user, $pass, $db);
if (!$conexion) {
    die("Error al conectar: " . mysqli_connect_error());
}

// AGREGAR producto
if (isset($_POST['agregar'])) {
    $nombre      = $_POST['nombre'];
    $precio      = $_POST['precio'];
    $stock       = $_POST['stock'];
    $id_categoria = $_POST['id_categoria'];
    $sql_insert = "INSERT INTO productos (nombre, precio, stock, id_categoria) VALUES ('$nombre', '$precio', '$stock', '$id_categoria')";
    if (mysqli_query($conexion, $sql_insert)) {
        $mensaje = "Producto agregado correctamente.";
    } else {
        $mensaje = "Error al agregar: " . mysqli_error($conexion);
    }
}

// ELIMINAR producto
if (isset($_GET['eliminar'])) {
    $id_eliminar = $_GET['eliminar'];
    $sql_delete = "DELETE FROM productos WHERE id_producto='$id_eliminar'";
    if (mysqli_query($conexion, $sql_delete)) {
        $mensaje = "Producto eliminado correctamente.";
    } else {
        $mensaje = "Error al eliminar: " . mysqli_error($conexion);
    }
}

// BUSCAR o mostrar todos
if (isset($_POST['enviar']) && $_POST['id_producto'] != "") {
    $id_producto = $_POST['id_producto'];
    $sql = "SELECT * FROM productos WHERE id_producto='$id_producto'";
} else {
    $sql = "SELECT * FROM productos";
}

$resultado = mysqli_query($conexion, $sql);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Inventario</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>PAGINA PRINCIPAL</h1>
    <a href="Samuel.php">CLICK AQUI PARA LA PAGINA PRINCIPAL</a>
    <h1>Inventario de Productos</h1>

    <?php if (isset($mensaje)) echo "<p>$mensaje</p>"; ?>

    <!-- BUSCAR -->
    <form method="POST" action="tabla_productos.php">
        Buscar por ID:
        <input type="text" name="id_producto" value="<?php echo isset($_POST['id_producto']) ? $_POST['id_producto'] : ''; ?>">
        <input type="submit" name="enviar" value="Buscar">
        <a href="tabla_productos.php">Ver todos</a>
    </form>

    <br>

    <!-- TABLA -->
    <table border="1" cellpadding="6">
        <tr>
            <th>ID</th>
            <th>Nombre del Producto</th>
            <th>Precio</th>
            <th>Stock Actual</th>
            <th>Categoría</th>
            <th>Acción</th>
        </tr>
        <?php
        if (mysqli_num_rows($resultado) == 0) {
            echo "<tr><td colspan='6'>No se encontró ningún producto.</td></tr>";
        } else {
            while ($fila = mysqli_fetch_array($resultado)) {
                echo "<tr>";
                echo "<td>" . $fila['id_producto'] . "</td>";
                echo "<td>" . $fila['nombre'] . "</td>";
                echo "<td>$" . $fila['precio'] . "</td>";
                echo "<td>" . $fila['stock'] . "</td>";
                echo "<td>" . $fila['id_categoria'] . "</td>";
                echo "<td><a href='tabla_productos.php?eliminar=" . $fila['id_producto'] . "' onclick=\"return confirm('¿Seguro que deseas eliminar este producto?')\">Eliminar</a></td>";
                echo "</tr>";
            }
        }
        ?>

        <!-- FILA PARA AGREGAR -->
        <tr>
            <form method="POST" action="tabla_productos.php">
                <td><i>(auto)</i></td>
                <td><input type="text" name="nombre" placeholder="Nombre" required></td>
                <td><input type="number" step="0.01" name="precio" placeholder="Precio" required></td>
                <td><input type="number" name="stock" placeholder="Stock" required></td>
                <td><input type="number" name="id_categoria" placeholder="ID Categoría" required></td>
                <td><input type="submit" name="agregar" value="Agregar"></td>
            </form>
        </tr>
    </table>

    <?php mysqli_close($conexion); ?>
</body>
</html>