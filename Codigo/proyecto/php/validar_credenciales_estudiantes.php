// validar_credenciales_estudiantes.php
<?php
// Incluir el archivo de conexión
include_once 'conexion.php';

// Supongamos que recibes estos valores del formulario de inicio de sesión
$dni_estudiante = $_POST['dni_estudiante'];
$contrasena = $_POST['contrasena'];

// Consulta SQL para verificar las credenciales
$sql = "SELECT * FROM login_estudiantes WHERE dni_estudiante = '$dni_estudiante'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Estudiante encontrado
    $row = $result->fetch_assoc();
    if (password_verify($contrasena, $row['contrasena'])) {
        // Credenciales válidas
        echo "Credenciales válidas";
        header("Location: ../html/ventana_estudiante.html");
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
