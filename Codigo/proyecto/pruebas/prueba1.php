<?php
require 'conexion.php';

$sql = "SELECT id_registro, numero_documento_identidad AS DNI, CONCAT(nombres, ' ', apellido_paterno, ' ', apellido_materno) AS nombres, telefono FROM inasistencias_fut;";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Lista de Nombres</title>
</head>
<body>
    <table border="1">
        <tr>
            <th>DNI</th>
            <th>Nombres</th>
        </tr>
        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr onclick="llenarCampos('<?php echo $row['id_registro']; ?>', '<?php echo $row['nombres']; ?>', '<?php echo $row['DNI']; ?>', '<?php echo $row['telefono']; ?>')">
                    <td><?php echo $row['DNI']; ?></td>
                    <td><?php echo $row['nombres']; ?></td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr>
                <td colspan="2">No hay datos para mostrar</td>
            </tr>
        <?php endif; ?>
    </table>

    <!-- Aquí va tu segunda tabla con los inputs -->
    <table>
        <tr>
            <td>ID</td>
            <td><input id="num_registro" name="num_registro"></td>
        </tr>
        <tr>
            <td>Nombre</td>
            <td><input id="nombre" name="nombre"></td>
        </tr>
        <tr>
            <td>DNI</td>
            <td><input id="dni" name="dni"></td>
        </tr>
        <tr>
            <td>Telefono</td>
            <td><input id="telefono" name="telefono"></td>
        </tr>
    </table>

    <script>
        function llenarCampos(id, nombre, dni, telefono) {
            document.getElementById('num_registro').value = id;
            document.getElementById('nombre').value = nombre;
            document.getElementById('dni').value = dni;
            document.getElementById('telefono').value = telefono;
        }
    </script>

    <?php $conn->close(); ?>
</body>
</html>
