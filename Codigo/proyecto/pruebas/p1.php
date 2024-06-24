<?php
require 'conexion.php'; // Archivo de conexión a la base de datos

$sql = "SELECT numero_documento_identidad AS DNI, CONCAT(nombres, ' ', apellido_paterno, ' ', apellido_materno) AS nombresi,
id_registro, solicitud, dependencia, nombres, apellido_paterno, apellido_materno, tipo_documento_identidad,
numero_documento_identidad, direccion, distrito, provincia, departamento, email, telefono, celular, fundamento_solicitud,
archivo_fut_justificacion, archivo_documento_justificacion, observacion, codigo_estudiante
FROM inasistencias_fut;";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion de Inasistencias - UNAM</title>
    <link rel="stylesheet" href="../css/estilo-fut.css">
</head>
<body>

    <?php include 'tabla-inasistencias.php'; ?>

    <!-- SEGUNDA TABLA -->
    <?php include 'formularios.php'; ?>

    <?php $conn->close(); ?>
    
    <script src="funciones.js"></script>
</body>
</html>
