<?php
require 'conexion.php';

$sql = "SELECT numero_documento_identidad AS DNI, CONCAT(nombres, ' ', apellido_paterno, ' ', apellido_materno) AS nombresi,
id_registro, solicitud, dependencia, nombres, apellido_paterno, apellido_materno, tipo_documento_identidad,
numero_documento_identidad, direccion, distrito, provincia, departamento, email, telefono, celular, fundamento_solicitud,
archivo_fut_justificacion, archivo_documento_justificacion, observacion, codigo_estudiante
FROM inasistencias_fut
WHERE estado = 'ESPERA' AND DATE(fecha) = CURDATE();";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion de Inasistencias - UNAM</title>
    <link rel="stylesheet" href="../css/estilo_fut_gestion.css">

</head>
<body>
<h2>Gestion de justificacion de inasistencias</h2>
<h4>2024 - 1</h4>

    <div class="container">

        <!-- SEGUNDA TABLA (LARGE TABLE) -->
        <div class="large-table">

            <table>
                <tr>
                    <td><img src="../img/UNAM-SIN FONDO.png" alt=""></td>
                    <td class="texto-centro">FORMULARIO ÚNICO DE TRÁMITE (FUT)</td>
                    <td>
                        <table class="tabla1">
                            <tr><td><input name="num_registro" id="num_registro" class="texto" readonly></td></tr>
                            <tr><td class="texto-centro">N° de Registro:</td></tr>
                        </table>
                    </td>
                </tr>
            </table>

            <table>
                <tr><td>I. SOLICITO:</td></tr>
                <tr><td><input name="tipo_solicitud" id="tipo_solicitud" class="texto" readonly></td></tr>
                <tr><td>II. DEPENDENCIA O AUTORIDAD A QUIEN SE DIRIGE LA SOLICITUD:</td></tr>
                <tr><td><input name="solicitud_dirige" id="solicitud_dirige" class="texto" readonly></td></tr>
            </table>

            <table>
                <tr><td colspan="4">IV. DATOS DEL SOLICITANTE:</td></tr>
                <tr><td colspan="3">PERSONA NATURAL</td><td class="texto-centro">DOCUMENTO DE IDENTIDAD</td></tr>
                <tr>
                    <td class="texto-centro">Apellido Paterno</td>
                    <td class="texto-centro">Apellido Materno</td>
                    <td class="texto-centro">Nombres</td>
                    <td><input id="documento_ident_pers_nat" class="texto" readonly></td>
                </tr>
                <tr>
                    <td><input name="apel_paterno_pers_nat" id="apel_paterno_pers_nat" class="texto" readonly></td>
                    <td><input name="apel_materno_pers_nat" id="apel_materno_pers_nat" class="texto" readonly></td>
                    <td><input name="nombres_pers_nat" id="nombres_pers_nat" class="texto" readonly></td>
                    <td>N° <input name="num_doc_pers_nat" id="num_doc_pers_nat" class="texto-N" readonly></td>
                </tr>
            </table>

            <table>
                <tr><td colspan="3">V. DIRECCION:</td></tr>
                <tr><td colspan="3" class="texto-centro">DOMICILIO : AV. /CALLE / JIRÓN / DPTO. / MZ. / LOTE / URB.</td></tr>
                <tr><td colspan="3"><input name="domicilio" id="domicilio" class="texto" readonly></td></tr>
                <tr>
                    <td class="texto-centro">DISTRITO</td>
                    <td class="texto-centro">PROVINCIA</td>
                    <td class="texto-centro">DEPARTAMENTO</td>
                </tr>
                <tr>
                    <td><input name="distrito" id="distrito" class="texto" readonly></td>
                    <td><input name="provincia" id="provincia" class="texto" readonly></td>
                    <td><input name="departamento" id="departamento" class="texto" readonly></td>
                </tr>
                <tr>
                    <td>CORREO ELECTRONICO: <input type="email" name="email" id="email" class="texto" readonly></td>
                    <td>TELEFONO: <input name="telefono" id="telefono" class="texto" readonly></td>
                    <td>CELULAR: <input name="celular" id="celular" class="texto" readonly></td>
                </tr>
            </table>

            <table>
                <tr><td>VI. FUNDAMENTACION DE LA SOLICITUD (PETITORIO - Indicar en forma clara lo que se solicita):</td></tr>
                <tr><td><textarea name="fundamento_solicitud" id="fundamento_solicitud" class="texto" readonly></textarea></td></tr>
            </table>

            <table>
                <tr><td>VII. ANEXOS (Documento de justificacion):</td></tr>
                <tr>
                    <td>
                        <table class="tabla1">
                            <tr>
                                <td>Descargar FUT</td>
                                <td>
                                    <span id="descargar_fut">
                                        <span>Archivo no disponible</span>
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td>Descargar Justificación</td>
                                <td>
                                    <span id="descargar_justificacion">
                                        <span>Archivo no disponible</span>
                                    </span>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>

            <table>
                <tr>
                    <td>
                        <table class="tabla1">
                            <tr><td><input name="codigo_estudiante" id="codigo_estudiante" class="texto-registro-centro" readonly></td></tr>
                            <tr><td class="texto-centro">FIRMA DEL USUARIO (Codigo Estudiantil)</td></tr>
                        </table>
                    </td>
                    <td>
                        <table class="tabla1">
                            <tr><td>OBSERVACIONES:</td></tr>
                            <tr><td><textarea name="observaciones" id="observaciones" class="texto" readonly></textarea></td></tr>
                        </table>
                    </td>
                </tr>
            </table><br><br>
        </div>

        <!-- PRIMERA TABLA (SMALL TABLE) -->
         

        <div class="small-table">
        <center><button type="button" class="color-boton-verde" onclick="actualizarEstado('aceptar')">Aceptar</button></center>
        <br><br>
        <center><button type="button" class="color-boton-rojo" onclick="actualizarEstado('rechazar')">Rechazar</button></center>
        <br><br>
        <h3 class="texto-centro">Estudiantes</h3>
        <br>
            <table border="1" class="tabla-pequena">
                <tr>
                    <td class="texto-centro"><strong>DNI</strong></td>
                    <td class="texto-centro"><strong>Nombres</strong></td>
                </tr>
                <?php if ($result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr onclick="llenarCampos(
                            '<?php echo $row['id_registro']; ?>',
                            '<?php echo $row['solicitud']; ?>',
                            '<?php echo $row['dependencia']; ?>',
                            '<?php echo $row['tipo_documento_identidad']; ?>',
                            '<?php echo $row['apellido_paterno']; ?>',
                            '<?php echo $row['apellido_materno']; ?>',
                            '<?php echo $row['nombres']; ?>',
                            '<?php echo $row['DNI']; ?>',
                            '<?php echo $row['direccion']; ?>',
                            '<?php echo $row['distrito']; ?>',
                            '<?php echo $row['provincia']; ?>',
                            '<?php echo $row['departamento']; ?>',
                            '<?php echo $row['email']; ?>',
                            '<?php echo $row['telefono']; ?>',
                            '<?php echo $row['celular']; ?>',
                            '<?php echo $row['fundamento_solicitud']; ?>',
                            '<?php echo $row['codigo_estudiante']; ?>',
                            '<?php echo $row['observacion']; ?>',
                            '<?php echo !empty($row['archivo_fut_justificacion']) ? '1' : '0'; ?>',
                            '<?php echo !empty($row['archivo_documento_justificacion']) ? '1' : '0'; ?>')">

                            <td><?php echo $row['DNI']; ?></td>
                            <td><?php echo $row['nombresi']; ?></td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="2">No hay datos para mostrar</td>
                    </tr>
                <?php endif; ?>
            </table>
        </div>

    </div>

    <script>
        function llenarCampos(id, solicitud, dependencia, tipo_documento, apellido_paterno, apellido_materno, nombre, dni, direccion, distrito, provincia, departamento, email, telefono, celular, fundamento_solicitud, codigo_estudiante, observaciones, archivoFutDisponibilidad, archivoJustificacionDisponibilidad) {
            document.getElementById('num_registro').value = id;
            document.getElementById('tipo_solicitud').value = solicitud;
            document.getElementById('solicitud_dirige').value = dependencia;
            document.getElementById('documento_ident_pers_nat').value = tipo_documento;
            document.getElementById('apel_paterno_pers_nat').value = apellido_paterno;
            document.getElementById('apel_materno_pers_nat').value = apellido_materno;
            document.getElementById('nombres_pers_nat').value = nombre;
            document.getElementById('num_doc_pers_nat').value = dni;
            document.getElementById('domicilio').value = direccion;
            document.getElementById('distrito').value = distrito;
            document.getElementById('provincia').value = provincia;
            document.getElementById('departamento').value = departamento;
            document.getElementById('email').value = email;
            document.getElementById('telefono').value = telefono;
            document.getElementById('celular').value = celular;
            document.getElementById('fundamento_solicitud').value = fundamento_solicitud;
            document.getElementById('codigo_estudiante').value = codigo_estudiante;
            document.getElementById('observaciones').value = observaciones;

            var enlaceDescargaFut = document.getElementById('enlace_descarga_fut');
            var enlaceDescargaJustificacion = document.getElementById('enlace_descarga_justificacion');
            
            var descargarFut = document.getElementById('descargar_fut');
            var descargarJustificacion = document.getElementById('descargar_justificacion');

            if (archivoFutDisponibilidad === '1') {
                descargarFut.innerHTML = '<a id="enlace_descarga_fut" href="../php/descarga_inasistencias/1_fut_justificacion.php?id=' + id + '" target="_blank">Descargar Archivo</a>';
            } else {
                descargarFut.innerHTML = '<span>Archivo no disponible</span>';
            }

            if (archivoJustificacionDisponibilidad === '1') {
                descargarJustificacion.innerHTML = '<a id="enlace_descarga_justificacion" href="../php/descarga_inasistencias/1_documento_justificacion.php?id=' + id + '" target="_blank">Descargar Archivo</a>';
            } else {
                descargarJustificacion.innerHTML = '<span>Archivo no disponible</span>';
            }
        }
    </script>

    <script>
        function actualizarEstado(accion) {
            var id_registro = document.getElementById('num_registro').value;

            if (!id_registro) {
                alert("Por favor, seleccione un registro primero.");
                return;
            }

            var xhr = new XMLHttpRequest();
            xhr.open("POST", "actualizar_estado_inasistencia.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

            xhr.onreadystatechange = function() {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status === 200) {
                        if (xhr.responseText.trim() === "success") {
                            alert("La asistencia ha sido actualizado correctamente.");
                            location.reload(); // Recargar la página para reflejar los cambios
                        } else {
                            alert("Hubo un error al actualizar la asistencia: " + xhr.responseText);
                        }
                    } else {
                        alert("Hubo un error con la solicitud: " + xhr.status);
                    }
                }
            };

            xhr.send("accion=" + accion + "&id_registro=" + id_registro);
        }
    </script>

</body>
</html>
<?php $conn->close(); ?>
