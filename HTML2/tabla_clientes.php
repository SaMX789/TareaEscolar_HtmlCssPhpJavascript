<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "webbd";
$conexion = mysqli_connect($host, $user, $pass, $db);
if (!$conexion) {
    die("Error al conectar: " . mysqli_connect_error());
}

// AGREGAR cliente
if (isset($_POST['agregar'])) {
    $nombre   = $_POST['nombre'];
    $email    = $_POST['email'];
    $telefono = $_POST['telefono'];
    $sql_insert = "INSERT INTO clientes (nombre, email, telefono) VALUES ('$nombre', '$email', '$telefono')";
    if (mysqli_query($conexion, $sql_insert)) {
        $mensaje = "Cliente agregado correctamente.";
    } else {
        $mensaje = "Error al agregar: " . mysqli_error($conexion);
    }
}

// ELIMINAR cliente
if (isset($_GET['eliminar'])) {
    $id_eliminar = $_GET['eliminar'];
    $sql_delete = "DELETE FROM clientes WHERE id_cliente='$id_eliminar'";
    if (mysqli_query($conexion, $sql_delete)) {
        $mensaje = "Cliente eliminado correctamente.";
    } else {
        $mensaje = "Error al eliminar: " . mysqli_error($conexion);
    }
}

// BUSCAR o mostrar todos
if (isset($_POST['enviar']) && $_POST['id_cliente'] != "") {
    $id_cliente = $_POST['id_cliente'];
    $sql3 = "SELECT * FROM clientes WHERE id_cliente='$id_cliente'";
} else {
    $sql3 = "SELECT * FROM clientes";
}

$resultado3 = mysqli_query($conexion, $sql3);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Clientes</title>
</head>
<body>
    <h1>PAGINA PRINCIPAL</h1>
    <a href="Samuel.php">CLICK AQUI PARA LA PAGINA PRINCIPAL</a>
    <h1>Clientes</h1>

    <?php if (isset($mensaje)) echo "<p>$mensaje</p>"; ?>

    <!-- BUSCAR -->
    <form method="POST" action="tabla_clientes.php">
        Buscar por ID:
        <input type="text" name="id_cliente" value="<?php echo isset($_POST['id_cliente']) ? $_POST['id_cliente'] : ''; ?>">
        <input type="submit" name="enviar" value="Buscar">
        <a href="tabla_clientes.php">Ver todos</a>
    </form>

    <br>

    <!-- TABLA -->
    <table border="1" cellpadding="6">
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Email</th>
            <th>Teléfono</th>
            <th>Acción</th>
        </tr>
        <?php
        if (mysqli_num_rows($resultado3) == 0) {
            echo "<tr><td colspan='5'>No se encontró ningún cliente.</td></tr>";
        } else {
            while ($fila = mysqli_fetch_array($resultado3)) {
                echo "<tr>";
                echo "<td>" . $fila['id_cliente'] . "</td>";
                echo "<td>" . $fila['nombre'] . "</td>";
                echo "<td>" . $fila['email'] . "</td>";
                echo "<td>" . $fila['telefono'] . "</td>";
                echo "<td><a href='tabla_clientes.php?eliminar=" . $fila['id_cliente'] . "' onclick=\"return confirm('¿Seguro que deseas eliminar este cliente?')\">Eliminar</a></td>";
                echo "</tr>";
            }
        }
        ?>

        <!-- FILA PARA AGREGAR -->
        <tr>
            <form method="POST" action="tabla_clientes.php">
                <td><i>(auto)</i></td>
                <td><input type="text" name="nombre" placeholder="Nombre" required></td>
                <td><input type="email" name="email" placeholder="Email" required></td>
                <td><input type="text" name="telefono" placeholder="Teléfono"></td>
                <td><input type="submit" name="agregar" value="Agregar"></td>
            </form>
        </tr>
    </table>

    <?php mysqli_close($conexion); ?>
</body>
</html>