<?php
error_reporting(E_ALL);
if (isset($_POST["btnModificar"])) {
    // Recoger los datos del formulario
    $codigo = $_POST['numAntiguo'];
    $codigoNuevo = $_POST['codigoAula'];
    $centro_regional = $_POST['id_centroRegional'];

    // Instanciar un objeto de la clase Conexion
    $con = new Conexion();
    $mysqli = $con->conectar();

    // Construir la consulta SQL para actualizar los datos
    $sql_update = "UPDATE aula SET id_centroRegional= ?, numero_aula= ? WHERE numero_aula= ?";
    
    // Preparar la consulta
    $stmt = $mysqli->prepare($sql_update);

    // Vincular los parámetros y ejecutar la consulta
    $stmt->bind_param("iss", $centro_regional, $codigoNuevo, $codigo);

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
                    window.location.href = 'tablaAulas.php';
                }, 3000);
            </script>
        <?php
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
    $stmt->close();
    $mysqli->close();
}
?>
