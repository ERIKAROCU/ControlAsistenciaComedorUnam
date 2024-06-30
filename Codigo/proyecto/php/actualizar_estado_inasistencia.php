<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    include 'conexion.php'; // Asegúrate de incluir tu archivo de conexión a la base de datos

    $accion = $_POST['accion'];
    $id_registro = $_POST['id_registro'];

    if ($accion === 'aceptar') {
        $nuevo_estado = 'ACEPTADO';

        // Obtener el código del estudiante del registro de inasistencia
        $query = "SELECT codigo_estudiante FROM inasistencias_fut WHERE id_registro = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('i', $id_registro);
        $stmt->execute();
        $stmt->bind_result($codigo_estudiante);
        $stmt->fetch();
        $stmt->close();

        if ($codigo_estudiante) {
            // Obtener los datos del estudiante de la tabla beneficiarios
            $query = "SELECT codigo_estudiante, dni_estudiante, nombres, apellido_paterno, apellido_materno, escuela_profesional
                      FROM beneficiarios
                      WHERE codigo_estudiante = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param('s', $codigo_estudiante);
            $stmt->execute();
            $stmt->bind_result($codigo_estudiante, $dni_estudiante, $nombres, $apellido_paterno, $apellido_materno, $escuela_profesional);
            $stmt->fetch();
            $stmt->close();

            // Insertar los datos del estudiante en la tabla asistencia
            $query = "INSERT INTO asistencia (codigo_estudiante, dni_estudiante, nombres, apellido_paterno, apellido_materno, escuela_profesional)
                      VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($query);
            $stmt->bind_param('ssssss', $codigo_estudiante, $dni_estudiante, $nombres, $apellido_paterno, $apellido_materno, $escuela_profesional);
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

    // Actualizar el estado del registro de inasistencia
    $query = "UPDATE inasistencias_fut SET estado = ? WHERE id_registro = ?";
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
