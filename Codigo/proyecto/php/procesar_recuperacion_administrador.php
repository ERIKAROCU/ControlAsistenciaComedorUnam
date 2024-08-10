<?php
include_once 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener DNI desde el formulario
    $dni_administrador = $_POST['dni_administrador'];

    // Consulta para buscar el estudiante en login_estudiantes
    $sql = "SELECT dni_administrador, email FROM login_administracion WHERE dni_administrador = '$dni_administrador'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Estudiante encontrado
        $row = $result->fetch_assoc();
        $dni_administrador = $row['dni_administrador'];
        $email = $row['email'];

        // Generar código de recuperación de 8 a 10 caracteres
        $length = rand(8, 10);
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $token = '';
        for ($i = 0; $i < $length; $i++) {
            $token .= $characters[rand(0, $charactersLength - 1)];
        }

        // Guardar token y fecha en la tabla login_administracion
        $sql_update = "UPDATE login_administracion SET codigo_recuperacion = '$token', fecha = NOW() WHERE dni_administrador = '$dni_administrador'";
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
                header("Location: ../html/formulario_nueva_contrasena_administrador.html");
                
            } else {
                echo "Error al enviar el correo.";
            }
        } else {
            echo "Error al actualizar la base de datos.";
        }
    } else {
        header("Location: ../html/formulario_recuperar_contrasena_administrador.html?error=1");
    }

    // Cerrar conexión
    $conn->close();
}
?>
