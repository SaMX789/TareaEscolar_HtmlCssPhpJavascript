<?php
// CONEXION
$conexion = mysqli_connect("localhost", "root", "", "webbd");
// Verificar conexión
if (!$conexion) {
    die("Error de conexión");
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Buscar Venta</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>PAGINA PRINCIPAL</h1>
    <a href="Samuel.php">CLICK AQUI PARA LA PAGINA PRINCIPAL</a>
    
<h2>Buscar Ventas por ID de Cliente</h2>
<form method="POST" action="buscar_venta.php">
    ID Cliente:
    <input type="text" name="id_cliente">
    <input type="submit" name="enviar" value="Buscar">
</form>

<?php
if (isset($_POST['enviar']))
{
    $id_cliente = $_POST['id_cliente'];

    // Buscar datos del cliente
    $res_cliente = mysqli_query(
        $conexion,
        "SELECT * FROM clientes WHERE id_cliente='$id_cliente'"
    );

    if (mysqli_num_rows($res_cliente) == 0)
    {
        echo "<p>No se encontró ningún cliente con ese ID.</p>";
    }
    else
    {
        $cliente = mysqli_fetch_assoc($res_cliente);
        echo "<p><strong>Cliente:</strong> " . $cliente['nombre'] . " — " . $cliente['email'] . "</p>";

        // Buscar ventas de ese cliente
        $res_ventas = mysqli_query(
            $conexion,
            "SELECT * FROM ventas WHERE id_cliente='$id_cliente'"
        );

        if (mysqli_num_rows($res_ventas) == 0)
        {
            echo "<p>Este cliente no tiene ventas registradas.</p>";
        }
        else
        {
            echo "<table border='1' cellpadding='6'>";
            echo "<tr>
                    <th>ID Venta</th>
                    <th>Fecha</th>
                    <th>Total</th>
                    <th>Detalle</th>
                  </tr>";

            while ($venta = mysqli_fetch_assoc($res_ventas))
            {
                $id_venta = $venta['id_venta'];

                // Buscar detalle de cada venta
                $res_detalle = mysqli_query(
                    $conexion,
                    "SELECT dv.cantidad, dv.precio_unitario, p.nombre
                     FROM detalle_ventas dv
                     JOIN productos p ON dv.id_producto = p.id_producto
                     WHERE dv.id_venta='$id_venta'"
                );

                $detalle_html = "";
                while ($det = mysqli_fetch_assoc($res_detalle))
                {
                    $subtotal = $det['cantidad'] * $det['precio_unitario'];
                    $detalle_html .= $det['nombre'] . " x" . $det['cantidad'] . " = $" . number_format($subtotal, 2) . "<br>";
                }

                echo "<tr>";
                echo "<td>" . $venta['id_venta'] . "</td>";
                echo "<td>" . $venta['fecha'] . "</td>";
                echo "<td>$" . number_format($venta['total'], 2) . "</td>";
                echo "<td>" . $detalle_html . "</td>";
                echo "</tr>";
            }

            echo "</table>";
        }
    }
}
?>
</body>
</html>