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
    $nombre = $_POST['nom'];
    $apellido = $_POST['ape'];
    $cedulaNueva = $_POST['nueva_cedula'];
    $cedulaAntigua = $_POST['cedAntigua'];
    $email = $_POST['correo'];

    $contraseña = $_POST['pass'];

    $con = new Conexion();
    $mysqli = $con->conectar();

    // Construir la consulta SQL para actualizar los datos 
    $sql_update = "UPDATE profesores SET nombre='$nombre', apellido='$apellido', cedula='$cedulaNueva', email='$email', contraseña='$contraseña' WHERE cedula='$cedulaAntigua'";

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


<?php
// Iniciar sesión y control de errores
session_start();
error_reporting(0);

// Verificar sesión iniciada
$validar = $_SESSION['usuario'];

if ($validar == null || $validar = '') {
    header("Location: ../../formularioIniciosesion.html");
    die();
}

// Verificar si se ha enviado el formulario
if (isset($_POST["btnModificar"])) {
    // Recoger los datos del formulario
    $nombre = $_POST['nom'];
    $apellido = $_POST['ape'];
    $cedulaNueva = $_POST['nueva_cedula'];
    $cedulaAntigua = $_POST['cedAntigua'];
    $email = $_POST['correo'];
    $contraseña = $_POST['pass'];

    $con = new Conexion();
    $mysqli = $con->conectar();

    // Verificar si la cédula nueva es diferente de la antigua
    if ($cedulaNueva == $cedulaAntigua) {
        // Construir la consulta SQL para actualizar los datos 
        $sql_update = "UPDATE profesores SET nombre='$nombre', apellido='$apellido', email='$email', contraseña='$contraseña' WHERE cedula='$cedulaAntigua'";

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
    } else {

        // Verificar si la nueva cédula exista en la tabla de profesores
        $sql_verificar = "SELECT * FROM profesores WHERE cedula='$cedulaNueva'";
        $resultado = $mysqli->query($sql_verificar);

        // Si la consulta devuelve algún resultado, significa que la nueva cédula ya está en uso
        if ($resultado->num_rows > 0) {
        ?>
            <div class="alert alert-danger" role="alert">
                La cédula ya está en uso. Por favor, ingrese otra.
            </div>
            <?php
        } else {
            // Construir la consulta SQL para actualizar los datos 
            $sql_update = "UPDATE profesores SET nombre='$nombre', apellido='$apellido', cedula='$cedulaNueva', email='$email', contraseña='$contraseña' WHERE cedula='$cedulaAntigua'";

            // Ejecutar la consulta de actualización
            if ($mysqli->query($sql_update) === TRUE) {
                // Verificar si se realizó alguna actualización
                if ($mysqli->affected_rows > 0) {
            ?>
                    <div class="alert alert-success" role="alert">
                        Registro actualizado correctamente.
                    </div>
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
                        No se realizó ninguna actualización en el registro.
                    </div>
                <?php
                }
            } else {
                ?>
                <div class="alert alert-danger" role="alert">
                    Error al ejecutar la consulta: <?php echo $mysqli->error; ?>
                </div>
               <?php
            }
        }
    }

    // Cerrar la conexión
    $mysqli->close();
}
?>