<?php
session_start();
error_reporting(0);

$validar = $_SESSION['usuario'];

if ($validar == null || $validar = '') {
    header("Location: ../../formularioIniciosesion.html");
    die();
}
?>

<?php
if (isset($_POST["btnModificar"])) {
    // Recoger los datos del formulario
    $num = $_POST['codAula'];
    $centro_regional = $_POST['id_centroRegional'];

    // Incluir el archivo de conexión a la base de datos
    include '../../db_Conexion/conector.php';

    // Instanciar un objeto de la clase Conexion
    $con = new Conexion();
    $mysqli = $con->conectar();

    // Construir la consulta SQL para actualizar los datos
    $sql_update = "UPDATE aula SET id_centroRegional='$centro_regional' WHERE numero_aula = '$num'";

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