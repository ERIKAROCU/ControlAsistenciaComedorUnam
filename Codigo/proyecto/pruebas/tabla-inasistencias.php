<table border="1">
    <tr>
        <th>DNI</th>
        <th>Nombres</th>
    </tr>
    <?php if ($result->num_rows > 0): ?>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr onclick="llenarCampos(
                '<?php echo $row['id_registro']; ?>',
                '<?php echo $row['solicitud']; ?>',
                '<?php echo $row['dependencia']; ?>',
                '<?php echo $row['tipo_documento_identidad']; ?>',
                '<?php echo $row['apellido_paterno']; ?>',
                '<?php echo $row['apellido_materno']; ?>',
                '<?php echo $row['nombres']; ?>',
                '<?php echo $row['DNI']; ?>',
                '<?php echo $row['direccion']; ?>',
                '<?php echo $row['distrito']; ?>',
                '<?php echo $row['provincia']; ?>',
                '<?php echo $row['departamento']; ?>',
                '<?php echo $row['email']; ?>',
                '<?php echo $row['telefono']; ?>',
                '<?php echo $row['celular']; ?>',
                '<?php echo $row['fundamento_solicitud']; ?>',
                '<?php echo $row['codigo_estudiante']; ?>',
                '<?php echo $row['observacion']; ?>',
                '<?php echo !empty($row['archivo_fut_justificacion']) ? '1' : '0'; ?>',
                '<?php echo !empty($row['archivo_documento_justificacion']) ? '1' : '0'; ?>')">

                <td><?php echo $row['DNI']; ?></td>
                <td><?php echo $row['nombresi']; ?></td>
            </tr>
        <?php endwhile; ?>
    <?php else: ?>
        <tr>
            <td colspan="2">No hay datos para mostrar</td>
        </tr>
    <?php endif; ?>
</table>
