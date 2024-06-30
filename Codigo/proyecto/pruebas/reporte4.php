<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Reportes - UNAM</title>
    <link rel="stylesheet" href="../css/gestion-reportes.css">
    <script>
        function ajustarMes() {
            var tipo_reporte = document.getElementById("tipo_reporte").value;
            var mes = document.getElementById("mes");

            if (tipo_reporte === "Postulacion" || tipo_reporte === "Beneficiarios") {
                mes.disabled = true;
            } else {
                mes.disabled = false;
            }

            actualizarTabla();
        }

        function actualizarTabla() {
            var tipo_reporte = document.getElementById("tipo_reporte").value;
            var escuela_profesional = document.getElementById("escuela_profesional").value;
            var mes = document.getElementById("mes").value;

            var xhr = new XMLHttpRequest();
            xhr.open("POST", "reporte4-procesar.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    document.getElementById("tabla_resultados").innerHTML = xhr.responseText;
                }
            };

            xhr.send("tipo_reporte=" + tipo_reporte + "&escuela_profesional=" + escuela_profesional + "&mes=" + mes);
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
                        <select name="escuela_profesional" id="escuela_profesional" onchange="actualizarTabla()">
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
                        <select name="mes" id="mes" onchange="actualizarTabla()">
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
            </table>
        </form>
    </div>
    <div id="tabla_resultados">
        <!-- Aquí se mostrarán los resultados de la tabla -->
    </div>
</body>
</html>
