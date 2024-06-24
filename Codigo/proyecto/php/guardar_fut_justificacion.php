//guardar_fut_justificacion.php

<?php
// Aquí debes realizar la conexión a la base de datos, si aún no lo has hecho
require_once 'conexion.php';

// Recibir datos del formulario
$num_registro = $_POST['num_registro']; // Este campo corresponde a id_registro en la base de datos
$tipo_solicitud = $_POST['tipo_solicitud'];
$solicitud_dirige = $_POST['solicitud_dirige'];
$nombres_pers_nat = $_POST['nombres_pers_nat'];
$apel_paterno_pers_nat = $_POST['apel_paterno_pers_nat'];
$apel_materno_pers_nat = $_POST['apel_materno_pers_nat'];
$documento_ident_pers_nat = $_POST['documento_ident_pers_nat'];
$num_doc_pers_nat = $_POST['num_doc_pers_nat'];
$domicilio = $_POST['domicilio'];
$distrito = $_POST['distrito'];
$provincia = $_POST['provincia'];
$departamento = $_POST['departamento'];
$email = $_POST['email'];
$telefono = $_POST['telefono'];
$celular = $_POST['celular'];
$fundamento_solicitud = $_POST['fundamento_solicitud'];
$fut_justificacion = file_get_contents($_FILES['fut_justificacion']['tmp_name']);
$documento_justificacion = file_get_contents($_FILES['documento_justificacion']['tmp_name']); // Aquí obtenemos el contenido del archivo
$observaciones = $_POST['observaciones'];
$codigo_estudiante = $_POST['codigo_estudiante'];

// Preparar la consulta SQL
$sql = "INSERT INTO inasistencias_fut (solicitud, dependencia, nombres, apellido_paterno, apellido_materno, tipo_documento_identidad, numero_documento_identidad, direccion, distrito, provincia, departamento, email, telefono, celular, fundamento_solicitud, archivo_fut_justificacion, archivo_documento_justificacion, observacion, codigo_estudiante)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);

// Verificar si la preparación de la consulta fue exitosa
if ($stmt === false) {
    die('Error al preparar la consulta: ' . $conn->error);
}

// Vincular parámetros y ejecutar la consulta
$stmt->bind_param('sssssssssssssssssss', $tipo_solicitud, $solicitud_dirige, $nombres_pers_nat, $apel_paterno_pers_nat, $apel_materno_pers_nat, $documento_ident_pers_nat, $num_doc_pers_nat, $domicilio, $distrito, $provincia, $departamento, $email, $telefono, $celular, $fundamento_solicitud, $fut_justificacion, $documento_justificacion, $observaciones, $codigo_estudiante);

$result = $stmt->execute();

// Verificar si la ejecución fue exitosa
if ($result === false) {
    die('Error al ejecutar la consulta: ' . $stmt->error);
} else {
    echo '¡Los datos se han guardado correctamente!';
}

// Cerrar la conexión y liberar recursos
$stmt->close();
$conn->close();
?>
