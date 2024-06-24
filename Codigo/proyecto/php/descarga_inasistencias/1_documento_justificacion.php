<?php
require '../conexion.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $stmt = $conn->prepare("SELECT archivo_documento_justificacion FROM inasistencias_fut WHERE id_registro = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->bind_result($fileData);
    $stmt->fetch();
    $stmt->close();

    if ($fileData) {
        header("Content-Type: application/octet-stream");
        header("Content-Disposition: attachment; filename=DocumentoJustificacion_$id.pdf");
        echo $fileData;
    } else {
        echo "No se encontró el archivo.";
    }
    
    $conn->close();
} else {
    echo "ID no especificado.";
}
?>
