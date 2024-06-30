<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Reportes - UNAM</title>
    <link rel="stylesheet" href="../css/gestion-asistencias.css">
    <script>
        function ajustarMes() {
            var tipo_reporte = document.getElementById("tipo_reporte").value;
            var mes = document.getElementById("mes");

            if (tipo_reporte === "Postulacion" || tipo_reporte === "Beneficiarios") {
                mes.disabled = true;
            } else {
                mes.disabled = false;
            }
        }
    </script>
</head>
<body>
    <h2>Gestión de Reportes</h2>
    <div>
        <form method="POST" action="">
            <table>
                <tr>
                    <td>Tipo de Reporte</td>
                    <td>Escuela Profesional</td>
                    <td>Mes</td>
                </tr>
                <tr>
                    <td>
                        <!-- Combo Box Tipo de Reporte -->
                        <select name="tipo_reporte" id="tipo_reporte" onchange="ajustarMes()">
                            <option value="">Escoge el tipo de reporte</option>
                            <option value="Postulacion">Postulantes</option>
                            <option value="Beneficiarios">Beneficiarios</option>
                            <option value="Asistencias">Asistencias</option>
                        </select>
                    </td>
                    <td>
                        <!-- Combo Box Escuela Profesional -->
                        <select name="escuela_profesional" id="escuela_profesional">
                            <option value="">Escoge la escuela</option>
                            <option value="Ingenieria de Sistemas e Informatica">Ingenieria de Sistemas e Informatica</option>
                            <option value="Ingenieria Ambiental">Ingenieria Ambiental</option>
                            <option value="Ingenieria Pesquera">Ingenieria Pesquera</option>
                            <option value="Administracion">Administracion</option>
                            <option value="Contabilidad">Contabilidad</option>
                            <option value="Derecho">Derecho</option>
                        </select>
                    </td>
                    <td>
                        <!-- Combo Box Mes -->
                        <select name="mes" id="mes">
                            <option value="">Escoge el mes</option>
                            <option value="01">Enero</option>
                            <option value="02">Febrero</option>
                            <option value="03">Marzo</option>
                            <option value="04">Abril</option>
                            <option value="05">Mayo</option>
                            <option value="06">Junio</option>
                            <option value="07">Julio</option>
                            <option value="08">Agosto</option>
                            <option value="09">Septiembre</option>
                            <option value="10">Octubre</option>
                            <option value="11">Noviembre</option>
                            <option value="12">Diciembre</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td colspan="3">
                        <button type="submit">Generar Reporte</button>
                    </td>
                </tr>
            </table>
        </form>
    </div>

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

            case '':
                if ($escuela_profesional && $mes) {
                    // E + M
                    $query = "SELECT codigo_estudiante, dni_estudiante, CONCAT(nombres, ' ', apellido_paterno, ' ', apellido_materno) AS nombres, escuela_profesional, fecha
                            FROM beneficiarios
                            WHERE escuela_profesional = '$escuela_profesional' AND DATE_FORMAT(fecha, '%m') = '$mes'
                            ORDER BY fecha ASC;";
                } elseif ($escuela_profesional) {
                    // E
                    $query = "SELECT codigo_estudiante, dni_estudiante, CONCAT(nombres, ' ', apellido_paterno, ' ', apellido_materno) AS nombres, escuela_profesional, fecha
                            FROM beneficiarios
                            WHERE escuela_profesional = '$escuela_profesional'
                            ORDER BY escuela_profesional ASC;";
                } elseif ($mes) {
                    // M
                    $query = "SELECT codigo_estudiante, dni_estudiante, CONCAT(nombres, ' ', apellido_paterno, ' ', apellido_materno) AS nombres, escuela_profesional, fecha
                            FROM beneficiarios
                            WHERE DATE_FORMAT(fecha, '%m') = '$mes'
                            ORDER BY fecha ASC;";
                } else {
                    // No seleccionó nada
                    echo "<p>No seleccionó ningún criterio para generar el reporte.</p>";
                }
                break;
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
</body>
</html>
