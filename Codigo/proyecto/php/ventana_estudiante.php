<?php
session_start();
include_once 'conexion.php';

if (!isset($_SESSION['codigo_estudiante'])) {
    header("Location: ../html/login_estudiantes.html");
    exit();
}

$codigo_estudiante = $_SESSION['codigo_estudiante'];

// Consulta SQL para obtener los datos del estudiante
$query = "SELECT CONCAT(nombres, ' ', apellido_paterno, ' ', apellido_materno) AS nombres, codigo_estudiante FROM estudiantes WHERE codigo_estudiante = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $codigo_estudiante);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $nombre_estudiante = $row['nombres'];
} else {
    $nombre_estudiante = "<script>alert('Nombre no encontrado');</script>";
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Estudiantes - UNAM</title>
    <link rel="stylesheet" href="../css/ventanas_usuarios.css">
</head>
<body>
    <header>
        <img src="../img/unamnofondo2.png" class="logo">
        <h1>Comedor Universitario - UNAM</h1>
        <span>Bienvenido, <?php echo htmlspecialchars($nombre_estudiante); ?></span>
        <span>Código: <?php echo htmlspecialchars($codigo_estudiante); ?></span>
        <a href="logout_estudiante.php">
            <img src="../icono/salida.png" class="exit-icon">
        </a>
    </header>
    <div id="sidebar">
        <button onclick="cargarPostulaciones()" class="load-content texto-centro"><center><img src="../img/icono_registro.png" class="icono2"><br>Postular</center></button>
        <button onclick="cargarRegistro()" class="load-content texto-centro"><center><img src="../img/icono_justificacion.png" class="icono2"><br>Justificar Inasistencias</center></button>
        <button onclick="cargarInasistencias()" class="load-content texto-centro"><center><img src="../img/icono_asistencia.png" class="icono2"><br>Ver Asistencias</center></button>
    </div>
    <div id="content">
        <iframe id="miIframe" src="ventana_lobby_estudiantes.php" width="100%" height="500px" frameborder="0"></iframe>
    </div>

    <script>
        function cargarPostulaciones() {
            var iframe = document.getElementById('miIframe');
            iframe.src = '../html/fut_postulacion.html';
            resetActiveButton();
            document.querySelector('#sidebar button:nth-child(1)').classList.add('active');
        }
    
        function cargarRegistro() {
            var iframe = document.getElementById('miIframe');
            iframe.src = '../html/fut_justificacion.html';
            resetActiveButton();
            document.querySelector('#sidebar button:nth-child(2)').classList.add('active');
        }
    
        function cargarInasistencias() {
            var iframe = document.getElementById('miIframe');
            iframe.src = '../php/ver_asistencia.php?codigo_estudiante=<?php echo $codigo_estudiante; ?>';
            resetActiveButton();
            document.querySelector('#sidebar button:nth-child(3)').classList.add('active');
        }
    
        function resetActiveButton() {
            var buttons = document.querySelectorAll('#sidebar button');
            buttons.forEach(button => button.classList.remove('active'));
        }
    </script>
    
</body>
</html>
