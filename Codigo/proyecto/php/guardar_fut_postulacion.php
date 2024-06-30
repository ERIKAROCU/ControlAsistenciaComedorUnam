<?php
// Incluir el archivo de conexión
include_once 'conexion.php';

// Verificar si se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario y escaparlos para evitar inyecciones SQL
    $solicitud = $_POST['tipo_solicitud'];
    $dependencia = $_POST['solicitud_dirige'];
    $nombres = $_POST['nombres_pers_nat'];
    $apellido_paterno = $_POST['apel_paterno_pers_nat'];
    $apellido_materno = $_POST['apel_materno_pers_nat'];
    $tipo_documento = $_POST['documento_ident_pers_nat'];
    $numero_documento = $_POST['num_doc_pers_nat'];
    $direccion = $_POST['domicilio'];
    $distrito = $_POST['distrito'];
    $provincia = $_POST['provincia'];
    $departamento = $_POST['departamento'];
    $email = $_POST['email'];
    $telefono = $_POST['telefono'];
    $celular = $_POST['celular'];
    $fundamento_solicitud = $_POST['fundamento_solicitud'];
    $observaciones = $_POST['observaciones'];
    $codigo_estudiante = $_POST['codigo_estudiante'];

    // Procesar los archivos adjuntos
    $archivo_fut_postulacion = $_FILES['fut_postulacion']['tmp_name'];
    $archivo_formato1 = $_FILES['formato1']['tmp_name'];
    $archivo_formato2 = $_FILES['formato2']['tmp_name'];
    $archivo_formato3 = isset($_FILES['formato3']['tmp_name']) ? $_FILES['formato3']['tmp_name'] : null;
    $archivo_formato4 = $_FILES['formato4']['tmp_name'];
    $archivo_ficha_socioeconomica = $_FILES['ficha_socioec']['tmp_name'];
    $archivo_copia_boleta_pago = isset($_FILES['boleta_pago']['tmp_name']) ? $_FILES['boleta_pago']['tmp_name'] : null;
    $archivo_recibo_luz = $_FILES['recibo_luz']['tmp_name'];
    $archivo_croquis = $_FILES['croquis']['tmp_name'];
    $archivo_recibo_alquiler = isset($_FILES['recibo_alquiler']['tmp_name']) ? $_FILES['recibo_alquiler']['tmp_name'] : null;
    $archivo_acta_orfandad_defuncion = isset($_FILES['ficha_orfandad']['tmp_name']) ? $_FILES['ficha_orfandad']['tmp_name'] : null;
    $archivo_carga_familiar = isset($_FILES['carga_fam']['tmp_name']) ? $_FILES['carga_fam']['tmp_name'] : null;
    $archivo_carnet_conadis = isset($_FILES['copia_conadis']['tmp_name']) ? $_FILES['copia_conadis']['tmp_name'] : null;
    $archivo_denuncia_policial_abandono_hogar = isset($_FILES['denuncia_policial']['tmp_name']) ? $_FILES['denuncia_policial']['tmp_name'] : null;
    $archivo_demanda_alimentos = isset($_FILES['demanda_alimentos']['tmp_name']) ? $_FILES['demanda_alimentos']['tmp_name'] : null;
    $archivo_pagos_deuda_bancaria = isset($_FILES['deuda_bancaria']['tmp_name']) ? $_FILES['deuda_bancaria']['tmp_name'] : null;
    $archivo_separacion_municipalidad = isset($_FILES['otros_documentos']['tmp_name']) ? $_FILES['otros_documentos']['tmp_name'] : null;

    // Verificar que se hayan cargado los archivos obligatorios
    if (empty($archivo_fut_postulacion) || empty($archivo_formato1) || empty($archivo_formato2) || empty($archivo_formato4) || empty($archivo_ficha_socioeconomica) ||
        empty($archivo_recibo_luz) || empty($archivo_croquis)) {
        die("Por favor, asegúrese de cargar todos los archivos obligatorios.");
    }

    // Leer el contenido de los archivos como datos binarios
    $binario_fut_postulacion = file_get_contents($archivo_fut_postulacion);
    $binario_formato1 = file_get_contents($archivo_formato1);
    $binario_formato2 = file_get_contents($archivo_formato2);
    $binario_formato3 = $archivo_formato3 ? file_get_contents($archivo_formato3) : null;
    $binario_formato4 = file_get_contents($archivo_formato4);
    $binario_ficha_socioeconomica = file_get_contents($archivo_ficha_socioeconomica);
    $binario_copia_boleta_pago = $archivo_copia_boleta_pago ? file_get_contents($archivo_copia_boleta_pago) : null;
    $binario_recibo_luz = file_get_contents($archivo_recibo_luz);
    $binario_croquis = file_get_contents($archivo_croquis);
    $binario_recibo_alquiler = $archivo_recibo_alquiler ? file_get_contents($archivo_recibo_alquiler) : null;
    $binario_acta_orfandad_defuncion = $archivo_acta_orfandad_defuncion ? file_get_contents($archivo_acta_orfandad_defuncion) : null;
    $binario_carga_familiar = $archivo_carga_familiar ? file_get_contents($archivo_carga_familiar) : null;
    $binario_carnet_conadis = $archivo_carnet_conadis ? file_get_contents($archivo_carnet_conadis) : null;
    $binario_denuncia_policial_abandono_hogar = $archivo_denuncia_policial_abandono_hogar ? file_get_contents($archivo_denuncia_policial_abandono_hogar) : null;
    $binario_demanda_alimentos = $archivo_demanda_alimentos ? file_get_contents($archivo_demanda_alimentos) : null;
    $binario_pagos_deuda_bancaria = $archivo_pagos_deuda_bancaria ? file_get_contents($archivo_pagos_deuda_bancaria) : null;
    $binario_separacion_municipalidad = $archivo_separacion_municipalidad ? file_get_contents($archivo_separacion_municipalidad) : null;

    // Preparar la consulta SQL
    $sql = "INSERT INTO postulacion_registro_fut 
            (solicitud, dependencia, nombres, apellido_paterno, apellido_materno, tipo_documento_identidad, 
             numero_documento_identidad, direccion, distrito, provincia, departamento, email, telefono, celular, 
             fundamento_solicitud, archivo_fut_postulacion, archivo_formato1, archivo_formato2, archivo_formato3, archivo_formato4, 
             archivo_ficha_socioeconomica, archivo_copia_boleta_pago, archivo_recibo_luz, archivo_croquis, 
             archivo_recibo_alquiler, archivo_acta_orfandad_defuncion, archivo_carga_familiar, archivo_carnet_conadis, 
             archivo_denuncia_policial_abandono_hogar, archivo_demanda_alimentos, archivo_pagos_deuda_bancaria, 
             archivo_separacion_municipalidad, observacion, codigo_estudiante, estado)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'ESPERA')";
    
    // Preparar la declaración
    $stmt = $conn->prepare($sql);

    // Verificar si la preparación de la consulta fue exitosa
    if ($stmt === false) {
        echo "Error al preparar la consulta (" . $conn->errno . ") " . $conn->error;
        exit();
    }

    // Vincular los parámetros y ejecutar la consulta
    $stmt->bind_param("ssssssssssssssssssssssssssssssssss", $solicitud, $dependencia, $nombres, $apellido_paterno, $apellido_materno, $tipo_documento, 
                      $numero_documento, $direccion, $distrito, $provincia, $departamento, $email, $telefono, $celular, 
                      $fundamento_solicitud, $archivo_fut_postulacion, $binario_formato1, $binario_formato2, $binario_formato3, $binario_formato4, 
                      $binario_ficha_socioeconomica, $binario_copia_boleta_pago, $binario_recibo_luz, $binario_croquis, 
                      $binario_recibo_alquiler, $binario_acta_orfandad_defuncion, $binario_carga_familiar, $binario_carnet_conadis, 
                      $binario_denuncia_policial_abandono_hogar, $binario_demanda_alimentos, $binario_pagos_deuda_bancaria, 
                      $binario_separacion_municipalidad, $observaciones, $codigo_estudiante);

    // Ejecutar la consulta y verificar si ocurrió algún error
    if ($stmt->execute()) {
        echo "Los datos se han insertado correctamente.";
    } else {
        echo "Error al ejecutar la consulta (" . $stmt->errno . ") " . $stmt->error;
    }

    // Cerrar la declaración y la conexión
    $stmt->close();
    $conn->close();
}
?>
