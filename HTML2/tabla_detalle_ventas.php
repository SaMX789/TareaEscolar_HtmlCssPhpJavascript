<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "webbd";
$conexion = mysqli_connect($host, $user, $pass, $db);
if (!$conexion) {
    die("Error al conectar: " . mysqli_connect_error());
}

$id_venta = isset($_GET['id_venta']) ? $_GET['id_venta'] : 0;
$sql4 = "SELECT * FROM detalle_ventas WHERE id_venta='$id_venta'";
$resultado4 = mysqli_query($conexion, $sql4);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Detalles de Venta</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>PAGINA PRINCIPAL</h1>
    <a href="Samuel.php">CLICK AQUI PARA LA PAGINA PRINCIPAL</a>
    <h1>Detalles de Venta #<?php echo $id_venta; ?></h1>
    <a href="tabla_ventas.php">← Volver a Ventas</a>
    <br><br>

    <table border="1" cellpadding="6">
        <tr>
            <th>ID Detalle</th>
            <th>ID Venta</th>
            <th>ID Producto</th>
            <th>Cantidad</th>
            <th>Precio Unitario</th>
        </tr>
        <?php
        if (mysqli_num_rows($resultado4) == 0) {
            echo "<tr><td colspan='5'>No hay detalles para esta venta.</td></tr>";
        } else {
            while ($fila = mysqli_fetch_array($resultado4)) {
                echo "<tr>";
                echo "<td>" . $fila['id_detalle'] . "</td>";
                echo "<td>" . $fila['id_venta'] . "</td>";
                echo "<td>" . $fila['id_producto'] . "</td>";
                echo "<td>" . $fila['cantidad'] . "</td>";
                echo "<td>$" . $fila['precio_unitario'] . "</td>";
                echo "</tr>";
            }
        }
        ?>
    </table>

    <?php mysqli_close($conexion); ?>
</body>
</html>