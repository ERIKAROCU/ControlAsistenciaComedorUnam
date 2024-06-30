<?php
session_start();
include_once 'conexion.php';

if (!isset($_SESSION['codigo_administrador'])) {
    header("Location: ../html/login_administrador.html");
    exit();
}

$codigo_administrador = $_SESSION['codigo_administrador'];

// Consulta SQL para obtener los datos del estudiante
$query = "SELECT CONCAT(nombres, ' ', apellido_paterno, ' ', apellido_materno) AS nombres, codigo_administrador FROM administracion WHERE codigo_administrador = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $codigo_administrador);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $nombre_administrador = $row['nombres'];
} else {
    $nombre_administrador = "<script>alert('Nombre no encontrado');</script>";
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comedor Universitario - UNAM</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/estilos-lobby.css">
</head>
<body>
    <?php
    $username = $row['nombres'];
    ?>
    <div class="container-fluid">
        <div class="row">
            <div class="main col-md-12">
                <div class="row">
                    <div class="col-md-8 full-height">
                        <div class="header flex-grow-1">
                            <h1>Módulo del Comedor</h1>
                            <hr>
                            <div class="d-flex align-items-center justify-content-center">
                                <img src="../img/Modulo_Comedor.png" alt="Comedor Universitario" class="header-image mr-3">
                                <div class="text-center">
                                    <p>Bienvenido</p>
                                    <p><strong><?php echo $username; ?></strong></p>
                                </div>
                            </div>
                        </div>
                        <div class="recomendaciones flex-grow-1">
                            <h2 class="section-title">Recomendaciones</h2>
                            <hr>
                        </div>
                        <div class="recommendations row flex-grow-1">
                            <div class="col-md-6 col-lg-6">
                                <div class="card o-hidden">
                                    <div class="card-body">
                                        <h3 class="recommendation-title">Uso en Celulares</h3>
                                        <hr>
                                        <div class="d-flex align-items-center">
                                            <img src="../img/firefox.jpg" alt="Firefox Logo" class="recommendation-image">
                                            <p>Para un mejor uso del Aula Virtual actualiza tu navegador a la última versión para acceder a todas las funciones.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-6">
                                <div class="card o-hidden">
                                    <div class="card-body">
                                        <h3 class="recommendation-title">Actualiza constantemente</h3>
                                        <hr>
                                        <div class="d-flex align-items-center">
                                            <img src="../img/reload.png" alt="Actualizar Icono" class="recommendation-image">
                                            <p>Recarga la página con SHIFT + F5 al iniciar el día.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-6">
                                <div class="card o-hidden">
                                    <div class="card-body">
                                        <h3 class="recommendation-title">Almacenamiento</h3>
                                        <hr>
                                        <div class="d-flex align-items-center">
                                            <img src="../img/onedrive-logo.png" alt="OneDrive Logo" class="recommendation-image">
                                            <p>Puede usar One Drive para subir tus tareas y exámenes (recomendado). No olvides dar permiso público a los enlaces para que tu docente los vea.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-6">
                                <div class="card o-hidden">
                                    <div class="card-body">
                                        <h3 class="recommendation-title">Entrega de Documentos</h3>
                                        <hr>
                                        <div class="d-flex align-items-center">
                                            <img src="../img/tarea.png" alt="Entrega de Documentos Icono" class="recommendation-image">
                                            <p>Antes de enviar los documentos verifica que sean los correctos.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 full-height">
                        <div class="directory-panel flex-grow-1">
                            <center><h2 class="section-title">Directorio telefónico</h2></center>
                            <center><img src="../img/soporte.png" alt="Directorio Telefónico"></center>
                            <table class="table table-sm table-hover">
                                <thead>
                                    <tr class="bg-primary text-white text-center">
                                        <th>Tienes duda sobre...</th>
                                        <th>Comunícate con:</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>OTI</td>
                                        <td>
                                            <ul>
                                                <li>999 999 999</li>
                                                <li>otiunam@unam.edu.pe</li>
                                            </ul>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Sistema o Aula Virtual No Funciona</td>
                                        <td>999 999 999</td>
                                    </tr>
                                    <tr>
                                        <td>Problemas con el Acceso al Correo Electrónico</td>
                                        <td>999 999 999</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
