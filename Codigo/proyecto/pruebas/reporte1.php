<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Gestion Reportes - UNAM</title>
</head>
<body>
    <h2>Gestion de Reportes</h2>
    <div>
        <form method="POST" action="reporte1-procesar.php">
            <table>
                <tr>
                    <td>Escuela Profesional</td>
                    <td>Tipo de Reporte</td>
                    <td>Mes</td>
                </tr>
                <tr>
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
                        <!-- Combo Box Tipo de Reporte -->
                        <select name="tipo_reporte" id="tipo_reporte">
                            <option value="">Escoge el tipo de reporte</option>
                            <option value="postulantes">Postulantes</option>
                            <option value="beneficiarios">Beneficiarios</option>
                            <option value="asistencias">Asistencias</option>
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
</body>
</html>
