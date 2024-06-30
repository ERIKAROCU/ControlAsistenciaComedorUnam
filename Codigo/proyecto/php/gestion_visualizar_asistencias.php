<?php
require('conexion.php');

if (isset($_GET['date'])) {
    $date = $_GET['date'];
} else {
    echo "Fecha no especificada.";
    exit;
}

$sql = "
SELECT
    b.codigo_estudiante,
    b.dni_estudiante,
    CONCAT(b.nombres, ' ', b.apellido_paterno, ' ', b.apellido_materno) AS nombres,
    b.escuela_profesional,
    CASE
        WHEN a.fecha IS NOT NULL THEN 'ASISTIO'
        ELSE 'FALTO'
    END AS estado
FROM beneficiarios b
LEFT JOIN asistencia a ON b.codigo_estudiante = a.codigo_estudiante AND DATE(a.fecha) = ?
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $date);
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles de la Fecha: <?php echo htmlspecialchars($date); ?></title>
    <link rel="stylesheet" href="../css/gestion-asistencias.css">
    <link rel="stylesheet" href="../css/modal.css">
    <style>
        body, html {
            height: 100%;
        }

        .container {
            padding: 10px;
            height: 100%;
            box-sizing: border-box;
        }

        .table-container {
            overflow-y: auto;
            max-height: 100%; /* Ajustar la altura máxima para el contenido */
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Detalles de Asistencia para la Fecha: <?php echo htmlspecialchars($date); ?></h2>
        <div class="table-container">
            <table>
                <tr>
                    <th>Código</th>
                    <th>DNI</th>
                    <th>Nombre</th>
                    <th>Escuela Profesional</th>
                    <th>Estado</th>
                </tr>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $estado_clase = $row['estado'] === 'ASISTIO' ? 'asistio' : 'falta';
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row['codigo_estudiante']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['dni_estudiante']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['nombres']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['escuela_profesional']) . "</td>";
                        echo "<td class='estado " . $estado_clase . "'>" . htmlspecialchars($row['estado']) . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>No se encontraron registros.</td></tr>";
                }
                $stmt->close();
                $conn->close();
                ?>
            </table>
        </div>
    </div>
</body>
</html>
