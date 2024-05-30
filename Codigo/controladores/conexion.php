<?php
$host = "localhost:3306";
$usuario = "root";
$contrasena = "Erik,1102";
$base_datos = "asistencia_db";

$conexion = mysqli_connect($host, $usuario, $contrasena, $base_datos);

if (!$conexion) {
    die("Error de conexión: " . mysqli_connect_error());
}

// Procesar los datos del formulario
// ...

// Procesar los archivos subidos
for ($i = 1; $i <= 5; $i++) {
    if (isset($_FILES["archivo$i"])) {
        $archivo = $_FILES["archivo$i"];
        // Guardar el archivo en el servidor
        // ...
    }
}

echo "Conexión exitosa";
?>