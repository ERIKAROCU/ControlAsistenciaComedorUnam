// conexion.php

<?php
$servername = "localhost";
$username = "root";
$password = "Erik,1102";
$database = "prueba_universidad";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $database);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
echo "Conexión exitosa";
?>
