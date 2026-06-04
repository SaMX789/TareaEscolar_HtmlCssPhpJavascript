<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "webbd";
$conexion = mysqli_connect($host, $user, $pass, $db);
if (!$conexion) {
    die("Error al conectar: " . mysqli_connect_error());
}

$mensaje = "";
$error_detalle = false;

if (isset($_POST['guardar'])) {
    $id_cliente = $_POST['id_cliente'];
    $productos  = $_POST['id_producto'];
    $cantidades = $_POST['cantidad'];

    // Calcular total desde la BD
    $total = 0;
    for ($i = 0; $i < count($productos); $i++) {
        if (!empty($productos[$i]) && !empty($cantidades[$i])) {
            $id_prod_temp = (int)$productos[$i];
            $cant_temp    = (int)$cantidades[$i];
            $res_temp = mysqli_query($conexion, "SELECT precio FROM productos WHERE id_producto='$id_prod_temp'");
            $fila_temp = mysqli_fetch_array($res_temp);
            $total += (float)$fila_temp['precio'] * $cant_temp;
        }
    }

    // 1. Insertar la venta
    $sql_venta = "INSERT INTO ventas (id_cliente, total) VALUES ('$id_cliente', '$total')";

    if (mysqli_query($conexion, $sql_venta)) {
        $id_venta_nueva = mysqli_insert_id($conexion);

        // 2. Insertar cada detalle
        for ($i = 0; $i < count($productos); $i++) {
            if (!empty($productos[$i]) && !empty($cantidades[$i])) {
                $id_prod  = (int)$productos[$i];
                $cantidad = (int)$cantidades[$i];

                $res_precio  = mysqli_query($conexion, "SELECT precio FROM productos WHERE id_producto='$id_prod'");
                $fila_precio = mysqli_fetch_array($res_precio);
                $precio      = (float)$fila_precio['precio'];

                $sql_det = "INSERT INTO detalle_ventas (id_venta, id_producto, cantidad, precio_unitario)
                            VALUES ('$id_venta_nueva', '$id_prod', '$cantidad', '$precio')";
                if (!mysqli_query($conexion, $sql_det)) {
                    $error_detalle = true;
                    $mensaje = "Error en detalle: " . mysqli_error($conexion);
                    break;
                }
            }
        }

        if (!$error_detalle) {
            $mensaje = "Venta #$id_venta_nueva registrada correctamente. Total: $$total";
        }

    } else {
        $mensaje = "Error al crear la venta: " . mysqli_error($conexion);
    }
}

// Cargar clientes y productos para los selects
$clientes     = mysqli_query($conexion, "SELECT * FROM clientes");
$productos_bd = mysqli_query($conexion, "SELECT * FROM productos");
$productos_lista = [];
while ($p = mysqli_fetch_array($productos_bd)) {
    $productos_lista[] = $p;
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Nueva Venta</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>PAGINA PRINCIPAL</h1>
    <a href="Samuel.php">CLICK AQUI PARA LA PAGINA PRINCIPAL</a>
    <h1>Nueva Venta</h1>
    <a href="tabla_ventas.php">← Volver a Ventas</a>
    <br><br>

    <?php if ($mensaje != "") echo "<p>$mensaje</p>"; ?>

    <form method="POST" action="nueva_venta.php">

        Cliente:
        <select name="id_cliente" required>
            <option value="">-- Seleccionar --</option>
            <?php while ($c = mysqli_fetch_array($clientes)) { ?>
                <option value="<?php echo $c['id_cliente']; ?>">
                    <?php echo $c['nombre']; ?>
                </option>
            <?php } ?>
        </select>
        <br><br>

        <table border="1" cellpadding="6">
            <tr>
                <th>Producto</th>
                <th>Cantidad</th>
            </tr>
            <?php for ($i = 0; $i < 3; $i++) { ?>
            <tr>
                <td>
                    <select name="id_producto[]">
                        <option value="">-- Producto --</option>
                        <?php foreach ($productos_lista as $p) { ?>
                            <option value="<?php echo $p['id_producto']; ?>">
                                <?php echo $p['nombre']; ?> ($<?php echo $p['precio']; ?>)
                            </option>
                        <?php } ?>
                    </select>
                </td>
                <td><input type="number" name="cantidad[]" min="1" value="1"></td>
            </tr>
            <?php } ?>
        </table>

        <br>
        <input type="submit" name="guardar" value="Guardar Venta">
    </form>

    <?php mysqli_close($conexion); ?>
</body>
</html>