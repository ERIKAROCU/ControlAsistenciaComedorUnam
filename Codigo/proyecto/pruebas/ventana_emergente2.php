<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);

    echo "Nombre: " . $name . "<br>";
    echo "Correo Electrónico: " . $email . "<br>";
}
?>
