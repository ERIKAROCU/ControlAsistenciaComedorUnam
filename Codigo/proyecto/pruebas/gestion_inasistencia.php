<?php
require 'conexion.php';

$sql = "SELECT numero_documento_identidad AS DNI, CONCAT(nombres, ' ', apellido_paterno, ' ', apellido_materno) AS nombresi,
id_registro, solicitud, dependencia, nombres, apellido_paterno, apellido_materno, tipo_documento_identidad,
numero_documento_identidad, direccion, distrito, provincia, departamento, email, telefono, celular, fundamento_solicitud,
archivo_fut_justificacion, archivo_documento_justificacion, observacion, codigo_estudiante
FROM inasistencias_fut;";

$result = $conn->query($sql);
?>
