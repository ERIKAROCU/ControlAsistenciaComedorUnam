<?php
require 'conexion.php';

$escuela_profesional = $_POST['escuela_profesional'];
$tipo_reporte = $_POST['tipo_reporte'];
$mes = $_POST['mes'];

$query = "";

// Combinaciones de consultas
if (empty($tipo_reporte) && empty($escuela_profesional)) {
    $query = "SELECT id_beneficiario, codigo_estudiante, dni_estudiante, CONCAT(nombres, ' ', apellido_paterno, ' ', apellido_materno) AS nombres, escuela_profesional
              FROM beneficiarios
              ORDER BY escuela_profesional ASC";
} elseif (empty($tipo_reporte) && !empty($escuela_profesional)) {
    $query = "SELECT id_beneficiario, codigo_estudiante, dni_estudiante, CONCAT(nombres, ' ', apellido_paterno, ' ', apellido_materno) AS nombres, escuela_profesional
              FROM beneficiarios
              WHERE escuela_profesional = '$escuela_profesional'
              ORDER BY escuela_profesional ASC";
} else {
    switch ($tipo_reporte) {
        case "postulantes":
            if (empty($escuela_profesional)) {
                $query = "SELECT p.codigo_estudiante, p.numero_documento_identidad, CONCAT(p.nombres, ' ', p.apellido_paterno, ' ', p.apellido_materno) AS nombres
                          FROM postulacion_registro_fut p, estudiantes e
                          WHERE e.codigo_estudiante = p.codigo_estudiante
                          ORDER BY e.escuela_profesional ASC";
            } else {
                $query = "SELECT p.codigo_estudiante, p.numero_documento_identidad, CONCAT(p.nombres, ' ', p.apellido_paterno, ' ', p.apellido_materno) AS nombres, e.escuela_profesional
                          FROM postulacion_registro_fut p, estudiantes e
                          WHERE e.codigo_estudiante = p.codigo_estudiante AND e.escuela_profesional = '$escuela_profesional'
                          ORDER BY e.escuela_profesional ASC";
            }
            break;

        case "beneficiarios":
            if (empty($escuela_profesional)) {
                $query = "SELECT codigo_estudiante, dni_estudiante, CONCAT(nombres, ' ', apellido_paterno, ' ', apellido_materno) AS nombres
                          FROM beneficiarios
                          ORDER BY apellido_paterno ASC";
            } else {
                $query = "SELECT b.codigo_estudiante, b.dni_estudiante, CONCAT(b.nombres, ' ', b.apellido_paterno, ' ', b.apellido_materno) AS nombres, b.escuela_profesional
                          FROM beneficiarios b, estudiantes e
                          WHERE b.codigo_estudiante = e.codigo_estudiante AND b.escuela_profesional = '$escuela_profesional'
                          ORDER BY b.apellido_paterno ASC";
            }
            break;

        case "asistencias":
            if (empty($escuela_profesional) && empty($mes)) {
                $query = "SELECT codigo_estudiante, dni_estudiante, CONCAT(nombres, ' ', apellido_paterno, ' ', apellido_materno) AS nombres
                          FROM asistencia
                          ORDER BY apellido_paterno ASC";
            } elseif (empty($mes)) {
                $query = "SELECT a.codigo_estudiante, a.dni_estudiante, CONCAT(a.nombres, ' ', a.apellido_paterno, ' ', a.apellido_materno) AS nombres, a.escuela_profesional
                          FROM asistencia a, beneficiarios b
                          WHERE a.codigo_estudiante = b.codigo_estudiante AND a.escuela_profesional = '$escuela_profesional'
                          ORDER BY a.apellido_paterno ASC";
            } else {
                $query = "SELECT a.codigo_estudiante, a.dni_estudiante, CONCAT(a.nombres, ' ', a.apellido_paterno, ' ', a.apellido_materno) AS nombres, a.escuela_profesional, a.fecha
                          FROM asistencia a, beneficiarios b
                          WHERE a.codigo_estudiante = b.codigo_estudiante AND a.escuela_profesional = '$escuela_profesional' AND MONTH(a.fecha) = '$mes'
                          ORDER BY a.apellido_paterno ASC";
            }
            break;
    }
}

// Ejecutar la consulta
$result = $conn->query($query);

if ($result->num_rows > 0) {
    echo "<h2>Resultados del Reporte</h2>";
    echo "<table border='1'>
            <tr>
                <th>Código Estudiante</th>
                <th>DNI</th>
                <th>Nombres</th>";
    if ($tipo_reporte == "asistencias" && !empty($mes)) {
        echo "<th>Fecha</th>";
    }
    echo "</tr>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>{$row['codigo_estudiante']}</td>
                <td>{$row['dni_estudiante']}</td>
                <td>{$row['nombres']}</td>";
        if ($tipo_reporte == "asistencias" && !empty($mes)) {
            echo "<td>{$row['fecha']}</td>";
        }
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "No se encontraron resultados.";
}

$conn->close();
?>
