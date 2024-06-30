
<?php
$servername = "localhost";
$username = "root";
$password = "Erik,1102";
$database = "prueba_universidad";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $database);

// Verificar la conexión
if ($conn->connect_error) {
    die("<script>alert('Conexion Fallida: ');</script>" . $conn->connect_error);
}
//echo "<script>alert('Conexion Exitosa');</script>";
?>
