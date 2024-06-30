<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    include 'conexion.php'; // Asegúrate de incluir tu archivo de conexión a la base de datos

    $accion = $_POST['accion'];
    $id_registro = $_POST['id_registro'];

    if ($accion === 'aceptar') {
        $nuevo_estado = 'ACEPTADO';

        // Obtener el código del estudiante del registro de postulación
        $query = "SELECT codigo_estudiante FROM postulacion_registro_fut WHERE id_registro = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('i', $id_registro);
        $stmt->execute();
        $stmt->bind_result($codigo_estudiante);
        $stmt->fetch();
        $stmt->close();

        if ($codigo_estudiante) {
            // Obtener los datos del estudiante
            $query = "SELECT codigo_estudiante, dni_estudiante, nombres, apellido_paterno, apellido_materno, escuela_profesional, celular, direccion
                      FROM estudiantes
                      WHERE codigo_estudiante = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param('s', $codigo_estudiante);
            $stmt->execute();
            $stmt->bind_result($codigo_estudiante, $dni_estudiante, $nombres, $apellido_paterno, $apellido_materno, $escuela_profesional, $celular, $direccion);
            $stmt->fetch();
            $stmt->close();

            // Insertar o actualizar los datos del estudiante en la tabla beneficiarios
            $query = "INSERT INTO beneficiarios (codigo_estudiante, dni_estudiante, nombres, apellido_paterno, apellido_materno, escuela_profesional, celular, direccion)
                      VALUES (?, ?, ?, ?, ?, ?, ?, ?)
                      ON DUPLICATE KEY UPDATE
                      dni_estudiante = VALUES(dni_estudiante),
                      nombres = VALUES(nombres),
                      apellido_paterno = VALUES(apellido_paterno),
                      apellido_materno = VALUES(apellido_materno),
                      escuela_profesional = VALUES(escuela_profesional),
                      celular = VALUES(celular),
                      direccion = VALUES(direccion)";
            $stmt = $conn->prepare($query);
            $stmt->bind_param('ssssssss', $codigo_estudiante, $dni_estudiante, $nombres, $apellido_paterno, $apellido_materno, $escuela_profesional, $celular, $direccion);
            if (!$stmt->execute()) {
                echo 'error: ' . $stmt->error;
                $stmt->close();
                $conn->close();
                exit;
            }
            $stmt->close();
        } else {
            echo 'error: estudiante no encontrado';
            $conn->close();
            exit;
        }
    } elseif ($accion === 'rechazar') {
        $nuevo_estado = 'RECHAZADO';
    } else {
        echo 'error: acción no válida';
        exit;
    }

    // Actualizar el estado del registro de postulación
    $query = "UPDATE postulacion_registro_fut SET estado = ? WHERE id_registro = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('si', $nuevo_estado, $id_registro);

    if ($stmt->execute()) {
        echo 'success';
    } else {
        echo 'error: ' . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    echo 'error: método no válido';
}
?>
