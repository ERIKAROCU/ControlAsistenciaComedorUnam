<?php
// Verificar si se han enviado datos del formulario
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['tipo_reporte'])) {
    // Obtener datos del formulario
    $tipo_reporte = $_POST['tipo_reporte'];
    $escuela_profesional = isset($_POST['escuela_profesional']) ? $_POST['escuela_profesional'] : '';
    $mes = isset($_POST['mes']) ? $_POST['mes'] : '';

    // Incluir archivo de conexión a la base de datos
    require 'conexion.php';

    // Definir consulta inicial y variables
    $query = "";
    $result = null;

    switch ($tipo_reporte) {
        case 'Postulacion':
            if ($escuela_profesional) {
                // R + E
                $query = "SELECT p.codigo_estudiante, p.numero_documento_identidad AS dni_estudiante, CONCAT(p.nombres, ' ', p.apellido_paterno, ' ', p.apellido_materno) AS nombres, e.escuela_profesional, p.fecha
                    FROM postulacion_registro_fut p, estudiantes e
                    WHERE p.codigo_estudiante = e.codigo_estudiante AND e.escuela_profesional = '$escuela_profesional'
                    ORDER BY e.escuela_profesional ASC;";
            } else {
                // R
                $query = "SELECT p.codigo_estudiante, p.numero_documento_identidad AS dni_estudiante, CONCAT(p.nombres, ' ', p.apellido_paterno, ' ', p.apellido_materno) AS nombres, e.escuela_profesional, p.fecha
                    FROM postulacion_registro_fut p, estudiantes e
                    WHERE p.codigo_estudiante = e.codigo_estudiante 
                    ORDER BY e.nombres ASC;";
            }
            break;

        case 'Beneficiarios':
            if ($escuela_profesional) {
                // R + E
                $query = "SELECT codigo_estudiante, dni_estudiante, CONCAT(nombres, ' ', apellido_paterno, ' ', apellido_materno) AS nombres, escuela_profesional, fecha
                        FROM beneficiarios
                        WHERE escuela_profesional = '$escuela_profesional'
                        ORDER BY escuela_profesional ASC;";
            } else {
                // R
                $query = "SELECT codigo_estudiante, dni_estudiante, CONCAT(nombres, ' ', apellido_paterno, ' ', apellido_materno) AS nombres, escuela_profesional, fecha
                        FROM beneficiarios
                        ORDER BY nombres ASC;";
            }
            break;

        case 'Asistencias':
            if ($escuela_profesional && $mes) {
                // R + E + M
                $query = "SELECT codigo_estudiante, dni_estudiante, CONCAT(nombres, ' ', apellido_paterno, ' ', apellido_materno) AS nombres, escuela_profesional, fecha
                        FROM asistencia
                        WHERE escuela_profesional = '$escuela_profesional' AND DATE_FORMAT(fecha, '%m') = '$mes'
                        ORDER BY fecha ASC;";
            } elseif ($escuela_profesional) {
                // R + E
                $query = "SELECT codigo_estudiante, dni_estudiante, CONCAT(nombres, ' ', apellido_paterno, ' ', apellido_materno) AS nombres, escuela_profesional, fecha
                        FROM asistencia
                        WHERE escuela_profesional = '$escuela_profesional'
                        ORDER BY escuela_profesional ASC;";
            } elseif ($mes) {
                // R + M
                $query = "SELECT codigo_estudiante, dni_estudiante, CONCAT(nombres, ' ', apellido_paterno, ' ', apellido_materno) AS nombres, escuela_profesional, fecha
                        FROM asistencia
                        WHERE DATE_FORMAT(fecha, '%m') = '$mes'
                        ORDER BY fecha ASC;";
            } else {
                // R
                $query = "SELECT codigo_estudiante, dni_estudiante, CONCAT(nombres, ' ', apellido_paterno, ' ', apellido_materno) AS nombres, escuela_profesional, fecha
                        FROM asistencia
                        ORDER BY fecha ASC;";
            }
            break;

        default:
            echo "<p>No seleccionó ningún criterio para generar el reporte.</p>";
            exit;
    }

    // Ejecutar la consulta si hay una consulta definida
    if (!empty($query)) {
        $result = $conn->query($query);

        if ($result->num_rows > 0) {
            // Mostrar tabla HTML con los resultados
            echo "<table border='1'>
                    <tr>
                    <td colspan=5>$tipo_reporte  $escuela_profesional $mes</td>
                    </tr>
                    <tr>
                        <th>Código Estudiante</th>
                        <th>DNI Estudiante</th>
                        <th>Nombres</th>
                        <th>Escuela Profesional</th>
                        <th>Fecha</th>
                    </tr>";

            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>" . $row['codigo_estudiante'] . "</td>
                        <td>" . $row['dni_estudiante'] . "</td>
                        <td>" . $row['nombres'] . "</td>
                        <td>" . $row['escuela_profesional'] . "</td>
                        <td>" . $row['fecha'] . "</td>
                    </tr>";
            }

            echo "</table>";
        } else {
            echo "<p>No se encontraron resultados.</p>";
        }
    }

    // Cerrar conexión a la base de datos
    $conn->close();
} else {
    echo "<p>No se han recibido datos del formulario.</p>";
}
?>
