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
        descargarFut.innerHTML = '<a id="enlace_descarga_fut" href="descarga_inasistencias/1_fut_justificacion.php?id=' + id + '" target="_blank">Descargar Archivo</a>';
    } else {
        descargarFut.innerHTML = '<span>Archivo no disponible</span>';
    }

    if (archivoJustificacionDisponibilidad === '1') {
        descargarJustificacion.innerHTML = '<a id="enlace_descarga_justificacion" href="descarga_inasistencias/1_documento_justificacion.php?id=' + id + '" target="_blank">Descargar Archivo</a>';
    } else {
        descargarJustificacion.innerHTML = '<span>Archivo no disponible</span>';
    }
}
