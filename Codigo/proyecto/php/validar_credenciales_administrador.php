<?php
// Incluir el archivo de conexión
include_once 'conexion.php';

// Supongamos que recibes estos valores del formulario de inicio de sesión
$dni_administrador = $_POST['dni_administrador'];
$contrasena = $_POST['contrasena'];

// Consulta SQL para verificar las credenciales
$sql = "SELECT * FROM login_administracion WHERE dni_administrador = '$dni_administrador'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Estudiante encontrado
    $row = $result->fetch_assoc();
    if (password_verify($contrasena, $row['contrasena'])) {
        // Credenciales válidas
        echo "Credenciales válidas";
        header("Location: ../html/ventana_administrador.html");
    } else {
        // Credenciales inválidas
        echo "Credenciales inválidas";
    }
} else {
    // DNI no encontrado
    echo "Credenciales inválidas";
}

// Cerrar conexión (opcionalmente, dependiendo de la lógica de tu aplicación)
$conn->close();
?>
