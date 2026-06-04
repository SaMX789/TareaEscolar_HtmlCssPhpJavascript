<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "webbd";
$conexion = mysqli_connect($host, $user, $pass, $db);
if (!$conexion) {
    die("Error al conectar: " . mysqli_connect_error());
}

// ELIMINAR venta
if (isset($_GET['eliminar'])) {
    $id_eliminar = $_GET['eliminar'];
    // Primero eliminar detalles (por la FK)
    mysqli_query($conexion, "DELETE FROM detalle_ventas WHERE id_venta='$id_eliminar'");
    $sql_delete = "DELETE FROM ventas WHERE id_venta='$id_eliminar'";
    if (mysqli_query($conexion, $sql_delete)) {
        $mensaje = "Venta eliminada correctamente.";
    } else {
        $mensaje = "Error al eliminar: " . mysqli_error($conexion);
    }
}

// BUSCAR o mostrar todas
if (isset($_POST['enviar']) && $_POST['id_venta'] != "") {
    $id_venta = $_POST['id_venta'];
    $sql5 = "SELECT * FROM ventas WHERE id_venta='$id_venta'";
} else {
    $sql5 = "SELECT * FROM ventas";
}

$resultado5 = mysqli_query($conexion, $sql5);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Ventas</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>PAGINA PRINCIPAL</h1>
    <a href="Samuel.php">CLICK AQUI PARA LA PAGINA PRINCIPAL</a>
    <h1>Ventas</h1>

    <?php if (isset($mensaje)) echo "<p>$mensaje</p>"; ?>

    <!-- BUSCAR -->
    <form method="POST" action="tabla_ventas.php">
        Buscar por ID:
        <input type="text" name="id_venta" value="<?php echo isset($_POST['id_venta']) ? $_POST['id_venta'] : ''; ?>">
        <input type="submit" name="enviar" value="Buscar">
        <a href="tabla_ventas.php">Ver todas</a>
    </form>

    <br>
    <a href="nueva_venta.php">+ Nueva Venta</a>
    <br><br>

    <!-- TABLA -->
    <table border="1" cellpadding="6">
        <tr>
            <th>ID</th>
            <th>Fecha</th>
            <th>ID Cliente</th>
            <th>Total</th>
            <th>Detalles</th>
            <th>Acción</th>
        </tr>
        <?php
        if (mysqli_num_rows($resultado5) == 0) {
            echo "<tr><td colspan='6'>No se encontró ninguna venta.</td></tr>";
        } else {
            while ($fila = mysqli_fetch_array($resultado5)) {
                echo "<tr>";
                echo "<td>" . $fila['id_venta'] . "</td>";
                echo "<td>" . $fila['fecha'] . "</td>";
                echo "<td>" . $fila['id_cliente'] . "</td>";
                echo "<td>$" . $fila['total'] . "</td>";
                echo "<td><a href='tabla_detalle_ventas.php?id_venta=" . $fila['id_venta'] . "'>Ver detalles</a></td>";
                echo "<td><a href='tabla_ventas.php?eliminar=" . $fila['id_venta'] . "' onclick=\"return confirm('¿Eliminar esta venta y sus detalles?')\">Eliminar</a></td>";
                echo "</tr>";
            }
        }
        ?>
    </table>

    <?php mysqli_close($conexion); ?>
</body>
</html>