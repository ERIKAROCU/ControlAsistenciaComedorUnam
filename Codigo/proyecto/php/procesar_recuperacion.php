<?php
include_once 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener DNI desde el formulario
    $dni_estudiante = $_POST['dni_estudiante'];

    // Consulta para buscar el estudiante en login_estudiantes
    $sql = "SELECT dni_estudiante, email FROM login_estudiantes WHERE dni_estudiante = '$dni_estudiante'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Estudiante encontrado
        $row = $result->fetch_assoc();
        $dni_estudiante = $row['dni_estudiante'];
        $email = $row['email'];

        // Generar código de recuperación de 8 a 10 caracteres
        $length = rand(8, 10);
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $token = '';
        for ($i = 0; $i < $length; $i++) {
            $token .= $characters[rand(0, $charactersLength - 1)];
        }

        // Guardar token y fecha en la tabla login_estudiantes
        $sql_update = "UPDATE login_estudiantes SET codigo_recuperacion = '$token', fecha = NOW() WHERE dni_estudiante = '$dni_estudiante'";
        if ($conn->query($sql_update) === TRUE) {
            // Envío del correo con el token al usuario
            $to = $email;
            $subject = 'Recuperación de Contraseña';
            $message = "Hola,\n\nPara recuperar tu contraseña, utiliza el siguiente código de recuperación:\n\n$token\n\nSi no solicitaste esta recuperación, ignora este mensaje.\n\nSaludos.";
            $headers = 'From: tu_correo@dominio.com' . "\r\n" .
                'Reply-To: tu_correo@dominio.com' . "\r\n" .
                'X-Mailer: PHP/' . phpversion();

            if (mail($to, $subject, $message, $headers)) {
                echo "Se ha enviado un correo con el código de recuperación.";
                header("Location: ../html/formulario_nueva_contrasena.html");
                
            } else {
                echo "Error al enviar el correo.";
            }
        } else {
            echo "Error al actualizar la base de datos.";
        }
    } else {
        echo "DNI no encontrado.";
    }

    // Cerrar conexión
    $conn->close();
}
?>
