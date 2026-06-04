<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "webbd"; 
$conexion = mysqli_connect($host, $user, $pass, $db);
if (!$conexion) {
    die("Error al conectar: " . mysqli_connect_error());
}

// AGREGAR categoría
if (isset($_POST['agregar'])) {
    $nombre     = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $sql_insert = "INSERT INTO categorias (nombre, descripcion) VALUES ('$nombre', '$descripcion')";
    if (mysqli_query($conexion, $sql_insert)) {
        $mensaje = "Categoría agregada correctamente.";
    } else {
        $mensaje = "Error al agregar: " . mysqli_error($conexion);
    }
}

// ELIMINAR categoría
if (isset($_GET['eliminar'])) {
    $id_eliminar = $_GET['eliminar'];
    $sql_delete = "DELETE FROM categorias WHERE id_categoria='$id_eliminar'";
    if (mysqli_query($conexion, $sql_delete)) {
        $mensaje = "Categoría eliminada correctamente.";
    } else {
        $mensaje = "Error al eliminar: " . mysqli_error($conexion);
    }
}

// BUSCAR o mostrar todas
if (isset($_POST['enviar']) && $_POST['id_categoria'] != "") {
    $id_categoria = $_POST['id_categoria'];
    $sql2 = "SELECT * FROM categorias WHERE id_categoria='$id_categoria'";
} else {
    $sql2 = "SELECT * FROM categorias";
}

$resultado2 = mysqli_query($conexion, $sql2);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Categorías</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>PAGINA PRINCIPAL</h1>
    <a href="Samuel.php">CLICK AQUI PARA LA PAGINA PRINCIPAL</a>
    <h1>Categorías</h1>

    <?php if (isset($mensaje)) echo "<p>$mensaje</p>"; ?>

    <!-- BUSCAR -->
    <form method="POST" action="tabla_categorias.php">
        Buscar por ID:
        <input type="text" name="id_categoria" value="<?php echo isset($_POST['id_categoria']) ? $_POST['id_categoria'] : ''; ?>">
        <input type="submit" name="enviar" value="Buscar">
        <a href="tabla_categorias.php">Ver todas</a>
    </form>

    <br>

    <!-- TABLA -->
    <table border="1" cellpadding="6">
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Descripción</th>
            <th>Acción</th>
        </tr>
        <?php 
        if (mysqli_num_rows($resultado2) == 0) {
            echo "<tr><td colspan='4'>No se encontró ninguna categoría.</td></tr>";
        } else {
            while ($fila = mysqli_fetch_array($resultado2)) {
                echo "<tr>";
                echo "<td>" . $fila['id_categoria'] . "</td>";
                echo "<td>" . $fila['nombre'] . "</td>";
                echo "<td>" . $fila['descripcion'] . "</td>";
                echo "<td><a href='tabla_categorias.php?eliminar=" . $fila['id_categoria'] . "' onclick=\"return confirm('¿Seguro que deseas eliminar esta categoría?')\">Eliminar</a></td>";
                echo "</tr>";
            }
        }
        ?>

        <!-- FILA PARA AGREGAR -->
        <tr>
            <form method="POST" action="tabla_categorias.php">
                <td><i>(auto)</i></td>
                <td><input type="text" name="nombre" placeholder="Nombre" required></td>
                <td><input type="text" name="descripcion" placeholder="Descripción"></td>
                <td><input type="submit" name="agregar" value="Agregar"></td>
            </form>
        </tr>
    </table>

    <?php mysqli_close($conexion); ?>
</body>
</html>