<?php
session_start();
require('conexion.php');

// Función para obtener el nombre del mes
function obtenerNombreMes($numeroMes) {
    $meses = array("enero", "febrero", "marzo", "abril", "mayo", "junio", "julio", "agosto", "septiembre", "octubre", "noviembre", "diciembre");
    return $meses[$numeroMes - 1];
}

// Función para obtener los días hábiles de un mes
function obtenerDiasHabiles($mes, $ano) {
    $total_dias = cal_days_in_month(CAL_GREGORIAN, $mes, $ano);
    $dias_habiles = [];

    for ($dia = 1; $dia <= $total_dias; $dia++) {
        $fecha = mktime(0, 0, 0, $mes, $dia, $ano);
        if (date("N", $fecha) <= 5) { // Si es de lunes a viernes
            $dias_habiles[] = date("Y-m-d", $fecha);
        }
    }

    return $dias_habiles;
}

// Obtener el mes y año actuales o por parámetro
if (isset($_GET['mes']) && isset($_GET['ano'])) {
    $mes_actual = intval($_GET['mes']);
    $ano_actual = intval($_GET['ano']);
} else {
    $mes_actual = date('n');
    $ano_actual = date('Y');
}

// Calcular el número de días hábiles para el mes actual
$dias_habiles = obtenerDiasHabiles($mes_actual, $ano_actual);

// Nombre del mes y año actual
$nombre_mes = obtenerNombreMes($mes_actual);
$mes_siguiente = ($mes_actual % 12) + 1;
$ano_siguiente = $ano_actual + floor(($mes_actual + 1) / 13);
$nombre_mes_siguiente = obtenerNombreMes($mes_siguiente);

// Calcular el número de días hábiles para el mes siguiente
$dias_habiles_siguiente = obtenerDiasHabiles($mes_siguiente, $ano_siguiente);

// Nombre del mes anterior
$mes_anterior = ($mes_actual == 1) ? 12 : $mes_actual - 1;
$ano_anterior = ($mes_actual == 1) ? $ano_actual - 1 : $ano_actual;
$nombre_mes_anterior = obtenerNombreMes($mes_anterior);

// Calcular el número de días hábiles para el mes anterior
$dias_habiles_anterior = obtenerDiasHabiles($mes_anterior, $ano_anterior);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calendario de Asistencias</title>
    <link rel="stylesheet" href="../css/gestion-asistencias.css">
    <link rel="stylesheet" href="../css/modal.css">
    <style>
        .calendario {
            width: 100%;
            margin-top: 20px;
            text-align: center;
        }

        .calendario table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .calendario th,
        .calendario td {
            padding: 15px;
            text-align: center;
            border: 2px solid #ddd;
        }

        .calendario th {
            background-color: #fff;
            color: #233293;
        }

        .calendario td {
            background-color: #ffffff;
        }

        .calendario tr:nth-child(even) td {
            background-color: #f9f9f9;
        }

        .calendario tr:hover td {
            background-color: #f1f1f1;
        }

        .calendario td.empty {
            background-color: #f4f4f9;
            border: 1px solid #fff;
        }

        .calendario .mes {
            font-size: 1.5em;
            margin-bottom: 10px;
        }

        .calendario .navegacion {
            margin-bottom: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .calendario .navegacion a {
            text-decoration: none;
            padding: 10px 15px;
            background-color: #233293;
            color: #fff;
            border-radius: 20px;
            transition: background-color 0.3s ease;
            border: none;
        }

        .calendario .navegacion a:hover {
            background-color: #1a237e;
        }
    </style>
</head>
<body>
    <h2>Calendario de Asistencias</h2>
    <div class="calendario">
        <div class="navegacion">
            <a href="?mes=<?php echo $mes_anterior; ?>&ano=<?php echo $ano_anterior; ?>">Anterior: <?php echo $nombre_mes_anterior; ?></a>
            <span class="mes"><strong><?php echo $ano_actual; ?> - <?php echo $nombre_mes; ?></strong></span>
            <a href="?mes=<?php echo $mes_siguiente; ?>&ano=<?php echo $ano_siguiente; ?>">Siguiente: <?php echo $nombre_mes_siguiente; ?></a>
        </div>
        <table>
            <tr>
                <th>Lunes</th>
                <th>Martes</th>
                <th>Miércoles</th>
                <th>Jueves</th>
                <th>Viernes</th>
            </tr>
            <?php
            $day_of_week = 0;
            $current_month_days = $dias_habiles;

            // Inicializar el primer día del mes
            $date = date('Y-m-d', strtotime("$ano_actual-$mes_actual-01"));

            // Encontrar el primer lunes del mes
            while (date('N', strtotime($date)) > 5) {
                $date = date('Y-m-d', strtotime($date . ' +1 day'));
            }

            // Mostrar los días hábiles del mes
            foreach ($current_month_days as $dia) {
                if (date('N', strtotime($dia)) <= 5) { // De lunes a viernes
                    echo "<td>" . date('Y-m-d', strtotime($dia)) . "<br><button onclick=\"showDetails('$dia')\">Ver Asistencias</button></td>";
                    $day_of_week++;

                    if ($day_of_week == 5) {
                        echo "</tr><tr>";
                        $day_of_week = 0;
                    }
                }
            }

            // Rellenar los días restantes de la última semana con celdas vacías
            while ($day_of_week > 0 && $day_of_week < 5) {
                echo "<td class='empty'></td>";
                $day_of_week++;
            }
            ?>
        </table>
    </div>

    <!-- Modal para mostrar los detalles -->
    <div id="myModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <div id="modal-content-placeholder"></div>
        </div>
    </div>

    <script>
        function showDetails(date) {
            var modal = document.getElementById('myModal');
            var modalContent = document.getElementById('modal-content-placeholder');

            var iframe = document.createElement('iframe');
            iframe.src = '../php/gestion_visualizar_asistencias.php?date=' + date;
            iframe.style.width = '100%';
            iframe.style.height = '395px';
            iframe.style.border = 'none';

            modalContent.innerHTML = '';
            modalContent.appendChild(iframe);

            modal.style.display = 'block';

            var spanClose = document.getElementsByClassName("close")[0];
            spanClose.onclick = function() {
                modal.style.display = "none";
                modalContent.removeChild(iframe);
            }
        }
    </script>

</body>
</html>
