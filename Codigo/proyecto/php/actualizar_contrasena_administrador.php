<?php
include_once 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener datos del formulario
    $codigo_recuperacion = $_POST['codigo_recuperacion'];
    $nueva_contrasena = $_POST['nueva_contrasena'];
    $nueva_contrasena_repetir = $_POST['nueva_contrasena_repetir'];

    // Validar que las contraseñas coinciden
    if ($nueva_contrasena !== $nueva_contrasena_repetir) {
        echo "Las contraseñas no coinciden.";
        exit;
    }

    // Consulta para verificar el código de recuperación
    $sql = "SELECT dni_administrador FROM login_administracion WHERE codigo_recuperacion = '$codigo_recuperacion'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Código de recuperación válido
        $row = $result->fetch_assoc();
        $dni_administrador = $row['dni_administrador'];

        // Actualizar la contraseña
        $hashed_password = password_hash($nueva_contrasena, PASSWORD_DEFAULT); // Encriptar la contraseña

        $sql_update = "UPDATE login_administracion SET contrasena = '$hashed_password', codigo_recuperacion = NULL WHERE dni_administrador = '$dni_administrador'";
        if ($conn->query($sql_update) === TRUE) {
            echo "Contraseña actualizada correctamente.";
        } else {
            echo "Error al actualizar la contraseña.";
        }
    } else {
        echo "Código de recuperación inválido.";
    }

    // Cerrar conexión
    $conn->close();
}
?>
