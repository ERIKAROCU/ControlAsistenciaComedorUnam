<?php
// Iniciar sesión
session_start();

// Incluir el archivo de conexión
include_once 'conexion.php';

// Supongamos que recibes estos valores del formulario de inicio de sesión
$dni_administrador = $_POST['dni_administrador'];
$contrasena = $_POST['contrasena'];

// Consulta SQL para verificar las credenciales
$sql = "SELECT * FROM login_administracion WHERE dni_administrador = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $dni_administrador);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Administrador encontrado
    $row = $result->fetch_assoc();
    if (password_verify($contrasena, $row['contrasena'])) {
        // Credenciales válidas
        $_SESSION['codigo_administrador'] = $row['codigo_administrador']; // Guardar el código del administrador en la sesión
        header("Location: ../php/ventana_administrador.php");
        
        exit();
    } else {
        // Credenciales inválidas
        echo "<script>alert('Credenciales inválidas'); window.location.href = '../html/login_administrador.html';</script>";
    }
} else {
    // DNI no encontrado
    echo "<script>alert('Credenciales inválidas'); window.location.href = '../html/login_administrador.html';</script>";
}

// Cerrar conexión
$stmt->close();
$conn->close();
?>
