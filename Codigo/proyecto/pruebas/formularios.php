<h2>Gestion de justificacion de inasistencias</h2><br><br>

<h4>2024 - 1</h4>
<button type="button">Aceptar</button>
<button type="button">Rechazar</button>

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
        <td><input id="documento_ident_pers_nat" readonly></td>
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
