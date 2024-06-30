<?php
require('conexion.php');

$codigo_estudiante = $_GET['codigo_estudiante'] ?? '';

if ($codigo_estudiante) {
    // Primera consulta: Crear la tabla temporal
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
        CURDATE() - INTERVAL (a.a + (10 * b.a) + (100 * c.a)) DAY BETWEEN '2024-06-01' AND '2024-06-30';
    ";

    if ($conn->query($create_table_sql) === TRUE) {
        // Segunda consulta: Obtener las asistencias y faltas
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
            echo "<table border='1'>
                    <tr>
                        <th>Código Estudiante</th>
                        <th>Nombre</th>
                        <th>Apellido Paterno</th>
                        <th>Apellido Materno</th>
                        <th>Fecha</th>
                        <th>Estado</th>
                    </tr>";
            while($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>" . $row["codigo_estudiante"]. "</td>
                        <td>" . $row["nombres"]. "</td>
                        <td>" . $row["apellido_paterno"]. "</td>
                        <td>" . $row["apellido_materno"]. "</td>
                        <td>" . $row["fecha_dia"]. "</td>
                        <td>" . $row["estado"]. "</td>
                    </tr>";
            }
            echo "</table>";
        } else {
            echo "No results found for the specified student.";
        }
        $stmt->close();
    } else {
        echo "Error creating temporary table: " . $conn->error;
    }
} else {
    echo "Please provide a student code.";
}

$conn->close();
?>
