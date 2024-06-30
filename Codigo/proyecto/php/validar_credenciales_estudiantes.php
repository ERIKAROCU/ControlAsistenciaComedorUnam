<?php
session_start();
include_once 'conexion.php';

$dni_estudiante = $_POST['dni_estudiante'];
$contrasena = $_POST['contrasena'];

$sql = "SELECT * FROM login_estudiantes WHERE dni_estudiante = '$dni_estudiante'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    if (password_verify($contrasena, $row['contrasena'])) {
        $_SESSION['codigo_estudiante'] = $row['codigo_estudiante'];
        $_SESSION['nombre_estudiante'] = $row['codigo_estudiante'];
        
        header("Location: ../php/ventana_estudiante.php");
        exit();
    } else {
        echo "Credenciales inválidas";
    }
} else {
    echo "Credenciales inválidas";
}

$conn->close();
?>
