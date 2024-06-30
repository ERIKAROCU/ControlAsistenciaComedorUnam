<?php
session_start();
require('conexion.php');

// Función para obtener el nombre del mes
function obtenerNombreMes($numeroMes) {
    $meses = array("enero", "febrero", "marzo", "abril", "mayo", "junio", "julio", "agosto", "septiembre", "octubre", "noviembre", "diciembre");
    return $meses[$numeroMes - 1];
}

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
    <link rel="stylesheet" href="../css/gestion-asistencias.css">

    
</head>
<body>
<?php

// Función para obtener las asistencias por mes y año
function obtenerAsistenciasPorMes($conn, $codigo_estudiante, $year, $month) {
    // Crear tabla temporal para las fechas hábiles del mes
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
        CURDATE() - INTERVAL (a.a + (10 * b.a) + (100 * c.a)) DAY BETWEEN DATE_ADD(LAST_DAY(DATE_SUB(CURDATE(), INTERVAL 1 MONTH)), INTERVAL 1 DAY) AND LAST_DAY(CURDATE())
        AND DAYOFWEEK(CURDATE() - INTERVAL (a.a + (10 * b.a) + (100 * c.a)) DAY) NOT IN (1, 7);
    ";

    if ($conn->query($create_table_sql) === TRUE) {
        // Consulta para obtener las asistencias por mes
        $select_sql = "
        SELECT
            b.codigo_estudiante,
            b.nombres,
            b.apellido_paterno,
            b.apellido_materno,
            d.fecha AS fecha_dia,
            IF(a.id_asistencia IS NOT NULL, '<a style=color:green><strong>Asistió</strong></a>', '<a style=color:red><strong>Falta</strong></a>') AS estado
        FROM
            beneficiarios b
        CROSS JOIN
            date_range d
        LEFT JOIN
            asistencia a ON b.codigo_estudiante = a.codigo_estudiante AND DATE(a.fecha) = d.fecha
        WHERE
            b.codigo_estudiante = ?
            AND DATE(d.fecha) BETWEEN DATE_ADD(LAST_DAY(DATE_SUB(?, INTERVAL 1 MONTH)), INTERVAL 1 DAY) AND LAST_DAY(?)
        ORDER BY
            d.fecha;
        ";

        $stmt = $conn->prepare($select_sql);
        $first_day = date('Y-m-01', strtotime("$year-$month-01"));
        $last_day = date('Y-m-t', strtotime("$year-$month-01"));
        $stmt->bind_param("sss", $codigo_estudiante, $first_day, $last_day);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $rows = $result->fetch_all(MYSQLI_ASSOC);
            $student_name = $rows[0]['nombres'] . ' ' . $rows[0]['apellido_paterno'] . ' ' . $rows[0]['apellido_materno'];

            echo "<h2>Asistencias de: $student_name</h2>";

            // Mostrar botones para navegar entre meses
            /*echo "<div style='text-align:center;margin-bottom:20px;'>";
            
            echo "<a style='font-size: 24px;'><center><strong>$year - " . obtenerNombreMes($month) . "</strong></center></a>";
            echo "<button style='margin-right: 80%;' onclick=\"window.location.href='ver_asistencia.php?codigo_estudiante=$codigo_estudiante&year=" . ($month == 1 ? $year - 1 : $year) . "&month=" . ($month == 1 ? 12 : $month - 1) . "'\">Mes Anterior</button>";
            echo "<button style='margin-left: 80%;' onclick=\"window.location.href='ver_asistencia.php?codigo_estudiante=$codigo_estudiante&year=" . ($month == 12 ? $year + 1 : $year) . "&month=" . ($month == 12 ? 1 : $month + 1) . "'\">Mes Siguiente</button>";
            echo "</div>";*/

            // Mostrar botones para navegar entre meses
            echo "<div style='display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;'>";
            echo "<button style='margin-right: 10px; font-size:16px;' onclick=\"window.location.href='ver_asistencia.php?codigo_estudiante=$codigo_estudiante&year=" . ($month == 1 ? $year - 1 : $year) . "&month=" . ($month == 1 ? 12 : $month - 1) . "'\">Mes Anterior</button>";
            echo "<a style='font-size: 24px; text-align: center; flex-grow: 1;'><strong>$year - " . obtenerNombreMes($month) . "</strong></a>";
            echo "<button style='margin-left: 10px; font-size:16px;' onclick=\"window.location.href='ver_asistencia.php?codigo_estudiante=$codigo_estudiante&year=" . ($month == 12 ? $year + 1 : $year) . "&month=" . ($month == 12 ? 1 : $month + 1) . "'\">Mes Siguiente</button>";
            echo "</div>";


            // Mostrar tabla de asistencias
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
            echo "<script>alert('No se encontraron resultados para el estudiante especificado en este mes.');</script>";
        }
        $stmt->close();
    } else {
        echo "<script>alert('Error creando la tabla temporal: ');</script>" . $conn->error;
    }
}

// Lógica para obtener el año y mes actual o desde la URL
$year = isset($_GET['year']) ? intval($_GET['year']) : date('Y');
$month = isset($_GET['month']) ? intval($_GET['month']) : date('m');

// Llamar a la función para obtener y mostrar las asistencias del mes actual
obtenerAsistenciasPorMes($conn, $codigo_estudiante, $year, $month);

$conn->close();
?>
</body>
</html>
