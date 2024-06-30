
<?php
require 'conexion.php';

$sql = "SELECT numero_documento_identidad AS DNI, 
               CONCAT(nombres, ' ', apellido_paterno, ' ', apellido_materno) AS nombresi,
               id_registro, solicitud, dependencia, nombres, apellido_paterno, apellido_materno, 
               tipo_documento_identidad, numero_documento_identidad, direccion, distrito, 
               provincia, departamento, email, telefono, celular, fundamento_solicitud, 
               archivo_fut_postulacion, archivo_formato1, archivo_formato2, archivo_formato3, 
               archivo_formato4, archivo_ficha_socioeconomica, archivo_copia_boleta_pago, 
               archivo_recibo_luz, archivo_croquis, archivo_recibo_alquiler, archivo_acta_orfandad_defuncion, 
               archivo_carga_familiar, archivo_carnet_conadis, archivo_denuncia_policial_abandono_hogar, 
               archivo_demanda_alimentos, archivo_pagos_deuda_bancaria, archivo_separacion_municipalidad, 
               observacion, codigo_estudiante, estado
        FROM postulacion_registro_fut
        WHERE estado = 'ESPERA';";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion de Postulaciones - UNAM</title>
    <link rel="stylesheet" href="../css/estilo_fut_gestion.css">
</head>
<body>
<h2>Gestion de justificacion de Postulaciones</h2>
<h4>2024 - 1</h4>

    <div class="container">

    <!-- SEGUNDA TABLA-->
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
            <td><input name="apellido_paterno" id="apellido_paterno" class="texto" readonly></td>
            <td><input name="apellido_materno" id="apellido_materno" class="texto" readonly></td>
            <td><input name="nombres" id="nombres" class="texto" readonly></td>
            <td>N°:<input name="documento_identidad" id="documento_identidad" class="texto" readonly></td>
        </tr>
    </table>

    <table>
        <tr><td>Dirección:</td><td><input name="direccion" id="direccion" class="texto" readonly></td></tr>
        <tr><td>Distrito:</td><td><input name="distrito" id="distrito" class="texto" readonly></td></tr>
        <tr><td>Provincia:</td><td><input name="provincia" id="provincia" class="texto" readonly></td></tr>
        <tr><td>Departamento:</td><td><input name="departamento" id="departamento" class="texto" readonly></td></tr>
        <tr><td>Email:</td><td><input name="email" id="email" class="texto" readonly></td></tr>
        <tr><td>Teléfono:</td><td><input name="telefono" id="telefono" class="texto" readonly></td></tr>
        <tr><td>Celular:</td><td><input name="celular" id="celular" class="texto" readonly></td></tr>
    </table>

    <table>
        <tr><td>III. FUNDAMENTOS DE LA SOLICITUD:</td></tr>
        <tr><td><textarea name="fundamentos_solicitud" id="fundamentos_solicitud" class="texto" readonly></textarea></td></tr>
    </table>

    <table>
        <tr><td>IV. OBSERVACIONES:</td></tr>
        <tr><td><textarea name="observacion" id="observacion" class="texto" readonly></textarea></td></tr>
        <tr><td>V. CODIGO DE ESTUDIANTE:</td></tr>
        <tr><td><input name="codigo_estudiante" id="codigo_estudiante" class="texto" readonly></td></tr>
    </table>

    <table>
        <tr><td>FUT Postulación</td><td><span id="fut_postulacion"></span></td></tr>
        <tr><td>Formato 1</td><td><span id="formato1"></span></td></tr>
        <tr><td>Formato 2</td><td><span id="formato2"></span></td></tr>
        <tr><td>Formato 3</td><td><span id="formato3"></span></td></tr>
        <tr><td>Formato 4</td><td><span id="formato4"></span></td></tr>
        <tr><td>Ficha Socioeconómica</td><td><span id="ficha_socioeconomica"></span></td></tr>
        <tr><td>Copia Boleta de Pago</td><td><span id="copia_boleta_pago"></span></td></tr>
        <tr><td>Recibo de Luz</td><td><span id="recibo_luz"></span></td></tr>
        <tr><td>Croquis</td><td><span id="croquis"></span></td></tr>
        <tr><td>Recibo de Alquiler</td><td><span id="recibo_alquiler"></span></td></tr>
        <tr><td>Acta de Orfandad/Defunción</td><td><span id="acta_orfandad_defuncion"></span></td></tr>
        <tr><td>Carga Familiar</td><td><span id="carga_familiar"></span></td></tr>
        <tr><td>Carnet CONADIS</td><td><span id="carnet_conadis"></span></td></tr>
        <tr><td>Denuncia Policial por Abandono de Hogar</td><td><span id="denuncia_policial_abandono_hogar"></span></td></tr>
        <tr><td>Demanda de Alimentos</td><td><span id="demanda_alimentos"></span></td></tr>
        <tr><td>Pagos de Deuda Bancaria</td><td><span id="pagos_deuda_bancaria"></span></td></tr>
        <tr><td>Separación en la Municipalidad</td><td><span id="separacion_municipalidad"></span></td></tr>
    </table>
    </div>

        <!-- PRIMERA TABLA (SMALL TABLE) -->

        <div class="small-table">
        <center><button type="button" class="color-boton-verde" onclick="actualizarEstado('aceptar')">Aceptar</button></center>
        <br><br>
        <center><button type="button" class="color-boton-rojo" onclick="actualizarEstado('rechazar')">Rechazar</button></center>
        <br><br>
        <h3 class="texto-centro">Postulantes</h3>
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
                        
                        '<?php echo !empty($row['archivo_fut_postulacion']) ? '1' : '0'; ?>',
                        '<?php echo !empty($row['archivo_formato1']) ? '1' : '0'; ?>',
                        '<?php echo !empty($row['archivo_formato2']) ? '1' : '0'; ?>',
                        '<?php echo !empty($row['archivo_formato3']) ? '1' : '0'; ?>',
                        '<?php echo !empty($row['archivo_formato4']) ? '1' : '0'; ?>',
                        '<?php echo !empty($row['archivo_ficha_socioeconomica']) ? '1' : '0'; ?>',
                        '<?php echo !empty($row['archivo_copia_boleta_pago']) ? '1' : '0'; ?>',
                        '<?php echo !empty($row['archivo_recibo_luz']) ? '1' : '0'; ?>',
                        '<?php echo !empty($row['archivo_croquis']) ? '1' : '0'; ?>',
                        '<?php echo !empty($row['archivo_recibo_alquiler']) ? '1' : '0'; ?>',
                        '<?php echo !empty($row['archivo_acta_orfandad_defuncion']) ? '1' : '0'; ?>',
                        '<?php echo !empty($row['archivo_carga_familiar']) ? '1' : '0'; ?>',
                        '<?php echo !empty($row['archivo_carnet_conadis']) ? '1' : '0'; ?>',
                        '<?php echo !empty($row['archivo_denuncia_policial_abandono_hogar']) ? '1' : '0'; ?>',
                        '<?php echo !empty($row['archivo_demanda_alimentos']) ? '1' : '0'; ?>',
                        '<?php echo !empty($row['archivo_pagos_deuda_bancaria']) ? '1' : '0'; ?>',
                        '<?php echo !empty($row['archivo_separacion_municipalidad']) ? '1' : '0'; ?>'
                    )">
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
        function llenarCampos(
            id_registro, solicitud, dependencia, tipo_documento_identidad, apellido_paterno, apellido_materno, nombres, DNI, direccion, distrito, provincia, departamento, email, telefono, celular, fundamento_solicitud, codigo_estudiante, observacion,
            fut_postulacion, formato1, formato2, formato3, formato4, ficha_socioeconomica, copia_boleta_pago, recibo_luz, croquis, recibo_alquiler, acta_orfandad_defuncion, carga_familiar, carnet_conadis, denuncia_policial_abandono_hogar, demanda_alimentos, pagos_deuda_bancaria, separacion_municipalidad
        ) {
            document.getElementById('num_registro').value = id_registro;
            document.getElementById('tipo_solicitud').value = solicitud;
            document.getElementById('solicitud_dirige').value = dependencia;
            document.getElementById('documento_ident_pers_nat').value = tipo_documento_identidad;
            document.getElementById('apellido_paterno').value = apellido_paterno;
            document.getElementById('apellido_materno').value = apellido_materno;
            document.getElementById('nombres').value = nombres;
            document.getElementById('documento_identidad').value = DNI;
            document.getElementById('direccion').value = direccion;
            document.getElementById('distrito').value = distrito;
            document.getElementById('provincia').value = provincia;
            document.getElementById('departamento').value = departamento;
            document.getElementById('email').value = email;
            document.getElementById('telefono').value = telefono;
            document.getElementById('celular').value = celular;
            document.getElementById('fundamentos_solicitud').value = fundamento_solicitud;
            document.getElementById('codigo_estudiante').value = codigo_estudiante;
            document.getElementById('observacion').value = observacion;

            document.getElementById('fut_postulacion').innerHTML = fut_postulacion === '1' ? '<a href="../php/descarga_postulaciones/1_fut_postulacion.php?id=' + id_registro + '">Descargar</a>' : 'Archivo no disponible';
            document.getElementById('formato1').innerHTML = formato1 === '1' ? '<a href="../php/descarga_postulaciones/2_formato1.php?id=' + id_registro + '">Descargar</a>' : 'Archivo no disponible';
            document.getElementById('formato2').innerHTML = formato2 === '1' ? '<a href="../php/descarga_postulaciones/3_formato2.php?id=' + id_registro + '">Descargar</a>' : 'Archivo no disponible';
            document.getElementById('formato3').innerHTML = formato3 === '1' ? '<a href="../php/descarga_postulaciones/4_formato3.php?id=' + id_registro + '">Descargar</a>' : 'Archivo no disponible';
            document.getElementById('formato4').innerHTML = formato4 === '1' ? '<a href="../php/descarga_postulaciones/5_formato4.php?id=' + id_registro + '">Descargar</a>' : 'Archivo no disponible';
            document.getElementById('ficha_socioeconomica').innerHTML = ficha_socioeconomica === '1' ? '<a href="../php/descarga_postulaciones/6_ficha_socioeconomica.php?id=' + id_registro + '">Descargar</a>' : 'Archivo no disponible';
            document.getElementById('copia_boleta_pago').innerHTML = copia_boleta_pago === '1' ? '<a href="../php/descarga_postulaciones/7_boleta_pago.php?id=' + id_registro + '">Descargar</a>' : 'Archivo no disponible';
            document.getElementById('recibo_luz').innerHTML = recibo_luz === '1' ? '<a href="../php/descarga_postulaciones/8_recibo_luz.php?id=' + id_registro + '">Descargar</a>' : 'Archivo no disponible';
            document.getElementById('croquis').innerHTML = croquis === '1' ? '<a href="../php/descarga_postulaciones/9_croquis.php?id=' + id_registro + '">Descargar</a>' : 'Archivo no disponible';
            document.getElementById('recibo_alquiler').innerHTML = recibo_alquiler === '1' ? '<a href="../php/descarga_postulaciones/10_recibo_alquiler.php?id=' + id_registro + '">Descargar</a>' : 'Archivo no disponible';
            document.getElementById('acta_orfandad_defuncion').innerHTML = acta_orfandad_defuncion === '1' ? '<a href="../php/descarga_postulaciones/11_recibo_orfandad.php?id=' + id_registro + '">Descargar</a>' : 'Archivo no disponible';
            document.getElementById('carga_familiar').innerHTML = carga_familiar === '1' ? '<a href="../php/descarga_postulaciones/12_carga_familiar.php?id=' + id_registro + '">Descargar</a>' : 'Archivo no disponible';
            document.getElementById('carnet_conadis').innerHTML = carnet_conadis === '1' ? '<a href="../php/descarga_postulaciones/13_carnet_conadis.php?id=' + id_registro + '">Descargar</a>' : 'Archivo no disponible';
            document.getElementById('denuncia_policial_abandono_hogar').innerHTML = denuncia_policial_abandono_hogar === '1' ? '<a href="../php/descarga_postulaciones/14_denuncia_policial.php?id=' + id_registro + '">Descargar</a>' : 'Archivo no disponible';
            document.getElementById('demanda_alimentos').innerHTML = demanda_alimentos === '1' ? '<a href="../php/descarga_postulaciones/15_demanda_alimentos.php?id=' + id_registro + '">Descargar</a>' : 'Archivo no disponible';
            document.getElementById('pagos_deuda_bancaria').innerHTML = pagos_deuda_bancaria === '1' ? '<a href="../php/descarga_postulaciones/16_deuda_bancaria.php?id=' + id_registro + '">Descargar</a>' : 'Archivo no disponible';
            document.getElementById('separacion_municipalidad').innerHTML = separacion_municipalidad === '1' ? '<a href="../php/descarga_postulaciones/17_separacion_municipalidad.php?id=' + id_registro + '">Descargar</a>' : 'Archivo no disponible';
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
            xhr.open("POST", "actualizar_estado_postulacion.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

            xhr.onreadystatechange = function() {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status === 200) {
                        if (xhr.responseText.trim() === "success") {
                            alert("El estado ha sido actualizado correctamente.");
                            location.reload(); // Recargar la página para reflejar los cambios
                        } else {
                            alert("Hubo un error al actualizar el estado: " + xhr.responseText);
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
