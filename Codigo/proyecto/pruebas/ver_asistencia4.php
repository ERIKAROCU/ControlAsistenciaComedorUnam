<?php
session_start();
require('conexion.php');

$codigo_estudiante = $_GET['codigo_estudiante'] ?? '';

if (!$codigo_estudiante) {
    echo "Código de estudiante no proporcionado.";
    exit();
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Asistencia de Estudiantes</title>
    <link rel="stylesheet" href="../css/ver_asistencia.css">
</head>
<body>
<?php
$create_table_sql = "
CREATE TEMPORARY TABLE date_range AS
SELECT
    CURDATE() - INTERVAL (a.a + (10 * b.a) + (100 * c.a)) DAY AS fecha
FROM
    (SELECT 0 AS a UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9) AS a
    CROSS JOIN
    (SELECT 0 AS a UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9) AS b
    CROSS JOIN
    (SELECT 0 AS a UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9) AS c
WHERE
    CURDATE() - INTERVAL (a.a + (10 * b.a) + (100 * c.a)) DAY BETWEEN '2024-06-01' AND '2024-06-30'
    AND DAYOFWEEK(CURDATE() - INTERVAL (a.a + (10 * b.a) + (100 * c.a)) DAY) NOT IN (1, 7);
";

if ($conn->query($create_table_sql) === TRUE) {
    $select_sql = "
    SELECT
        b.codigo_estudiante,
        b.nombres,
        b.apellido_paterno,
        b.apellido_materno,
        d.fecha AS fecha_dia,
        IF(a.id_asistencia IS NOT NULL, 'Asistió', 'Falta') AS estado
    FROM
        beneficiarios b
    CROSS JOIN
        date_range d
    LEFT JOIN
        asistencia a ON b.codigo_estudiante = a.codigo_estudiante AND DATE(a.fecha) = d.fecha
    WHERE
        b.codigo_estudiante = ?
    ORDER BY
        d.fecha;
    ";

    $stmt = $conn->prepare($select_sql);
    $stmt->bind_param("s", $codigo_estudiante);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $rows = $result->fetch_all(MYSQLI_ASSOC);
        $student_name = $rows[0]['nombres'] . ' ' . $rows[0]['apellido_paterno'] . ' ' . $rows[0]['apellido_materno'];

        echo "<h2>Asistencias de: $student_name</h2>";
        echo "<table>
                <tr>
                    <th>Lunes</th>
                    <th>Martes</th>
                    <th>Miércoles</th>
                    <th>Jueves</th>
                    <th>Viernes</th>
                </tr>";

        $week = [];
        foreach ($rows as $row) {
            $day_of_week = date('N', strtotime($row['fecha_dia'])) - 1;
            if ($day_of_week >= 5) {
                continue;
            }
            $week[$day_of_week] = $row;
            if ($day_of_week == 4) {
                echo "<tr>";
                for ($i = 0; $i < 5; $i++) {
                    if (isset($week[$i])) {
                        echo "<td>" . $week[$i]['fecha_dia'] . "<br>" . $week[$i]['estado'] . "</td>";
                    } else {
                        echo "<td class='empty'></td>";
                    }
                }
                echo "</tr>";
                $week = [];
            }
        }

        if (!empty($week)) {
            echo "<tr>";
            for ($i = 0; $i < 5; $i++) {
                if (isset($week[$i])) {
                    echo "<td>" . $week[$i]['fecha_dia'] . "<br>" . $week[$i]['estado'] . "</td>";
                } else {
                    echo "<td class='empty'></td>";
                }
            }
            echo "</tr>";
        }

        echo "</table>";
    } else {
        echo "No se encontraron resultados para el estudiante especificado.";
    }
    $stmt->close();
} else {
    echo "Error creando la tabla temporal: " . $conn->error;
}

$conn->close();
?>
</body>
</html>
