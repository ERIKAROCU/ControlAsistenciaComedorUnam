<?php
require 'conexion.php';

$nombres = "";
$apellido_paterno = "";
$apellido_materno = "";
$escuela_profesional = "";
$mensaje = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['buscar'])) {
        // Obtener el código o DNI ingresado
        $codigo_dni = $_POST['codigo_dni'];

        // Verificar si el código o DNI existe en la tabla beneficiarios
        $query = "SELECT * FROM beneficiarios WHERE codigo_estudiante = ? OR dni_estudiante = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ss", $codigo_dni, $codigo_dni);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // El código o DNI existe, obtener los datos del beneficiario
            $beneficiario = $result->fetch_assoc();
            
            $codigo_estudiante = $beneficiario['codigo_estudiante'];
            $dni_estudiante = $beneficiario['dni_estudiante'];
            $nombres = $beneficiario['nombres'];
            $apellido_paterno = $beneficiario['apellido_paterno'];
            $apellido_materno = $beneficiario['apellido_materno'];
            $escuela_profesional = $beneficiario['escuela_profesional'];
        } else {
            $mensaje = "El código o DNI ingresado no existe en la base de datos de beneficiarios.";
        }

        // Cerrar la conexión
        $stmt->close();
    } elseif (isset($_POST['registrar'])) {
        // Obtener los datos del formulario
        $codigo_estudiante = $_POST['codigo_estudiante'];
        $dni_estudiante = $_POST['dni_estudiante'];
        $nombres = $_POST['nombres'];
        $apellido_paterno = $_POST['apellido_paterno'];
        $apellido_materno = $_POST['apellido_materno'];
        $escuela_profesional = $_POST['carrera'];

        // Verificar si ya existe un registro para este estudiante hoy
        $check_query = "SELECT * FROM asistencia WHERE codigo_estudiante = ? AND DATE(fecha) = CURDATE()";
        $check_stmt = $conn->prepare($check_query);
        $check_stmt->bind_param("s", $codigo_estudiante);
        $check_stmt->execute();
        $check_result = $check_stmt->get_result();

        if ($check_result->num_rows > 0) {
            $mensaje = "Ya se ha registrado la asistencia para este estudiante hoy.";
        } else {
            // Insertar los datos en la tabla asistencia
            $insert_query = "INSERT INTO asistencia (codigo_estudiante, dni_estudiante, nombres, apellido_paterno, apellido_materno, escuela_profesional) VALUES (?, ?, ?, ?, ?, ?)";
            $insert_stmt = $conn->prepare($insert_query);
            $insert_stmt->bind_param("ssssss", $codigo_estudiante, $dni_estudiante, $nombres, $apellido_paterno, $apellido_materno, $escuela_profesional);
            
            if ($insert_stmt->execute()) {
                $mensaje = "Asistencia registrada correctamente.";
            } else {
                $mensaje = "Error al registrar la asistencia: " . $conn->error;
            }

            // Cerrar la conexión
            $insert_stmt->close();
        }

        // Cerrar la conexión
        $check_stmt->close();
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../css/estilo_registro_asistencia.css">
    <title>Registro de Asistencias - UNAM</title>
</head>
<body>
    <div class="main-container">
        <form action="registrar_asistencia.php" method="post">
            <h2>Registro de Asistencias</h2>
            <div class="contenido-centro">
                <table>
                    <tr>
                        <td><label for="codigo_dni"><strong>Número de Código estudiantil o DNI:</strong></label></td>
                        <td><input type="text" id="codigo_dni" name="codigo_dni" class="cajas2" required value="<?php echo htmlspecialchars($codigo_dni ?? '', ENT_QUOTES); ?>"></td>
                        <td><button type="submit" name="buscar" class="boton1">Buscar</button></td>
                    </tr>
                    <tr>
                        <td><label for="nombres"><strong>Nombres:</strong></label></td>
                        <td colspan="2"><input type="text" id="nombres" name="nombres" class="cajas" readonly value="<?php echo htmlspecialchars($nombres, ENT_QUOTES); ?>"></td>
                    </tr>
                    <tr>
                        <td><label for="apellido_paterno"><strong>Apellido Paterno:</strong></label></td>
                        <td colspan="2"><input type="text" id="apellido_paterno" name="apellido_paterno" class="cajas" readonly value="<?php echo htmlspecialchars($apellido_paterno, ENT_QUOTES); ?>"></td>
                    </tr>
                    <tr>
                        <td><label for="apellido_materno"><strong>Apellido Materno:</strong></label></td>
                        <td colspan="2"><input type="text" id="apellido_materno" name="apellido_materno" class="cajas" readonly value="<?php echo htmlspecialchars($apellido_materno, ENT_QUOTES); ?>"></td>
                    </tr>
                    <tr>
                        <td><label for="carrera"><strong>Carrera:</strong></label></td>
                        <td colspan="2"><input type="text" id="carrera" name="carrera" class="cajas" readonly value="<?php echo htmlspecialchars($escuela_profesional, ENT_QUOTES); ?>"></td>
                    </tr>
                    <input type="hidden" name="codigo_estudiante" value="<?php echo htmlspecialchars($codigo_estudiante ?? '', ENT_QUOTES); ?>">
                    <input type="hidden" name="dni_estudiante" value="<?php echo htmlspecialchars($dni_estudiante ?? '', ENT_QUOTES); ?>">
                    <tr>
                        <td colspan="3"><button type="submit" name="registrar" class="boton2">Registrar</button></td>
                    </tr>
                </table>
                <p><?php echo $mensaje; ?></p>
            </div>
        </form>
    </div>
</body>
</html>
