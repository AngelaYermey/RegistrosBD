
<?php

if (isset($_POST["btn_Modificar"])) {
    // Recoger los datos del formulario
    $nombre = $_POST['nom'];
    $apellido = $_POST['ape'];
    $cedulaNueva = $_POST['nueva_cedula'];
    $cedulaAntigua = $_POST['cedAntigua'];
    $email = $_POST['correo'];

    $contraseña = $_POST['pass'];

    $con = new Conexion();
    $mysqli = $con->conectar();

    // Construir la consulta SQL para actualizar los datos 
    $sql_update = "UPDATE profesores SET nombre='$nombre', apellido='$apellido', cedula_prof='$cedulaNueva', email='$email', contraseña='$contraseña' WHERE cedula_prof='$cedulaAntigua'";

    // Ejecutar la consulta
    if ($mysqli->query($sql_update) === TRUE) {
        // Verificar si se realizó alguna actualización
        if ($mysqli->affected_rows > 0) {
?>
            <center>
                <div class="alert alert-success" role="alert">
                    <?php echo "Registro actualizado correctamente"; ?>
                </div>
            </center>
            <script>
                setTimeout(function() {
                    window.location.href = 'tablaprofesor.php';
                }, 4000);
            </script>
        <?php
            exit; // Finalizar la ejecución del script después de la redirección
        } else {
        ?>
            <div class="alert alert-warning" role="alert">
                <?php echo "No se realizó ninguna actualización en el registro"; ?>
            </div>
        <?php
        }
    } else {
        ?>
        <div class="alert alert-danger" role="alert">
            <?php echo "Error al ejecutar la consulta: " . $mysqli->error; ?>
        </div>
<?php
    }

    // Cerrar la conexión
    $mysqli->close();
}
?>