<?php
session_start();
include_once 'conexion.php';

if (!isset($_SESSION['codigo_administrador'])) {
    header("Location: ../html/login_administrador.html");
    exit();
}

$codigo_administrador = $_SESSION['codigo_administrador'];

// Consulta SQL para obtener los datos del administrador
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

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Administracion - UNAM</title>
    <link rel="stylesheet" href="../css/ventanas_usuarios.css">
</head>
<body>
    <header>
        <img src="../img/unamnofondo2.png" class="logo">
        <h1>Comedor Universitario - UNAM</h1>
        <span>Bienvenido, <?php echo htmlspecialchars($nombre_administrador); ?></span>
        <span>Código: <?php echo htmlspecialchars($codigo_administrador); ?></span>
        <a href="logout_administrador.php">
            <img src="../icono/salida.png" class="exit-icon">
        </a>
    </header>
    <div id="sidebar">
        <button onclick="cargarPostulaciones()" class="load-content texto-centro"><center><img src="../img/icono_gestion_postulantes.png" class="icono"><br>Gestion de Postulantes</center></button>
        <button onclick="cargarRegistro()" class="load-content texto-centro"><center><img src="../img/icono_control_asistencia.png" class="icono"><br>Control de Asistencias</center></button>
        <button onclick="cargarInasistencias()" class="load-content texto-centro"><center><img src="../img/icono_gestion_inasistencia.png" class="icono"><br>Gestion de Inasistencias</center></button>
        <button onclick="cargarAsistencias()" class="load-content texto-centro"><center><img src="../img/icono_asistencia.png" class="icono"><br>Visualizar Asistencias</center></button>
        <button onclick="cargarReportes()" class="load-content texto-centro"><center><img src="../img/icono_gestion_reportes.png" class="icono"><br>Gestion de Reportes</center></button>
    </div>
    <div id="content">
        <iframe id="miIframe" src="ventana_lobby_administrador.php" width="100%" height="500px" frameborder="0"></iframe>
    </div>

    <script>
        function cargarPostulaciones() {
            var iframe = document.getElementById('miIframe');
            iframe.src = '../php/gestion_postulacion.php';
            resetActiveButton();
            document.querySelector('#sidebar button:nth-child(1)').classList.add('active');
        }
    
        function cargarRegistro() {
            var iframe = document.getElementById('miIframe');
            iframe.src = '../php/registrar_asistencia.php';
            resetActiveButton();
            document.querySelector('#sidebar button:nth-child(2)').classList.add('active');
        }
    
        function cargarInasistencias() {
            var iframe = document.getElementById('miIframe');
            iframe.src = '../php/gestion_justificacion.php';
            resetActiveButton();
            document.querySelector('#sidebar button:nth-child(3)').classList.add('active');
        }

        function cargarAsistencias() {
            var iframe = document.getElementById('miIframe');
            iframe.src = '../php/gestion_asistencias.php';
            resetActiveButton();
            document.querySelector('#sidebar button:nth-child(4)').classList.add('active');
        }

        function cargarReportes() {
            var iframe = document.getElementById('miIframe');
            iframe.src = '../html/pagina_reportes.html';
            resetActiveButton();
            document.querySelector('#sidebar button:nth-child(5)').classList.add('active');
        }
    
        function resetActiveButton() {
            var buttons = document.querySelectorAll('#sidebar button');
            buttons.forEach(button => button.classList.remove('active'));
        }
    </script>
    
</body>
</html>
