<?php

// Verificar si se envió el formulario
if (isset($_POST["btnModificar"])) {

    // Recoger los datos del formulario
    $codigoNuevo = $_POST['codigoAula'];
    $nombre = $_POST['nom'];
    $codigo = $_POST['codAntiguo'];

    $con = new Conexion();
    $mysqli = $con->conectar();

    // Construir la consulta SQL para actualizar los datos
    $sql_update = "UPDATE asignaturas SET nombre='$nombre', codigo_asignatura='$codigoNuevo' WHERE codigo_asignatura='$codigo'";
    // Preparar la consulta
    $stmt = $mysqli->prepare($sql_update);

    // Ejecutar la consulta
    if ($stmt->execute()) {
        // Verificar si se realizó alguna actualización
        if ($stmt->affected_rows > 0) {
            ?>
            <center>
                <div class="alert alert-success" role="alert">
                    <?php echo "Registro actualizado correctamente"; ?>
                </div>
            </center>
            <script>
                setTimeout(function() {
                    window.location.href = 'tablaAsignatura.php';
                }, 1500);
            </script>
            <?php
        } else {
            echo "<div class='alert alert-warning' role='alert'>No se realizó ninguna actualización en el registro</div>";
        }
    } else {
        echo "<div class='alert alert-danger' role='alert'>Error al ejecutar la consulta: " . $stmt->error . "</div>";
    }

    // Cerrar la declaración
    $stmt->close();


    // Cerrar la conexión
    $mysqli->close();
}
?>